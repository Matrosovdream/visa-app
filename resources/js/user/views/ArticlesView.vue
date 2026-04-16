<template>
    <section class="blog pt-30 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="blog-post-wrapper">
                        <transition name="fade" mode="out-in">
                            <!-- Loading skeleton -->
                            <div v-if="loading" key="skeleton">
                                <div v-for="n in 4" :key="n" class="single-post-item">
                                    <div class="post-content-wrapper">
                                        <div class="skeleton skeleton-line sm" style="width: 140px;"></div>
                                        <div class="skeleton skeleton-line lg" style="width: 70%;"></div>
                                        <div class="skeleton skeleton-line"></div>
                                        <div class="skeleton skeleton-line" style="width: 90%;"></div>
                                    </div>
                                    <hr>
                                </div>
                            </div>

                            <!-- Error -->
                            <div v-else-if="error" key="error" class="alert alert-warning">
                                {{ error }}
                            </div>

                            <!-- Empty -->
                            <div v-else-if="!articles.length" key="empty" class="text-muted py-5 text-center">
                                <p class="mb-0">No articles found{{ searchTerm ? ` for "${searchTerm}"` : '' }}.</p>
                            </div>

                            <!-- Articles list -->
                            <transition-group v-else name="stagger-list" tag="div" key="list">
                                <article v-for="article in articles" :key="article.id"
                                    class="single-post-item article-row">
                                    <div class="post-content-wrapper">
                                        <ul class="post-meta ul_li">
                                            <li>
                                                <span class="posted-on">
                                                    <i class="far fa-calendar-check"></i>
                                                    <span>{{ formatDate(article.created_at) }}</span>
                                                </span>
                                            </li>
                                        </ul>
                                        <h3 class="post-title border_effect">
                                            <router-link :to="{ name: 'article', params: { slug: article.slug } }">
                                                {{ article.title }}
                                            </router-link>
                                        </h3>
                                        <div class="post-excerpt">
                                            <p>{{ article.short_description }}</p>
                                        </div>
                                    </div>
                                </article>
                            </transition-group>
                        </transition>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="blog-sidebar">
                        <div class="widget">
                            <h3 class="widget-title">Search</h3>
                            <form class="widget__search" @submit.prevent="runSearch">
                                <input v-model="searchInput" type="text" placeholder="Search your keyword">
                                <button type="submit" :disabled="loading">
                                    <img :src="asset('user/assets/img/icon/search.svg')" alt="">
                                </button>
                            </form>
                            <div v-if="searchTerm" class="mt-2 small text-muted">
                                Showing results for
                                <strong>"{{ searchTerm }}"</strong>
                                <a href="#" class="ms-2" @click.prevent="clearSearch">clear</a>
                            </div>
                        </div>
                        <div class="widget">
                            <h3 class="widget-title">Categories</h3>
                            <ul class="widget__category list-unstyled">
                                <li><a href="#!"><i class="far fa-arrow-up"></i> Business visa</a></li>
                                <li><a href="#!"><i class="far fa-arrow-up"></i> Tourist visa</a></li>
                                <li><a href="#!"><i class="far fa-arrow-up"></i> Permanent Residency</a></li>
                            </ul>
                        </div>
                        <div class="widget">
                            <h3 class="widget-title">Tags</h3>
                            <div class="tagcloud">
                                <a href="#!">Citizenship</a>
                                <a href="#!">Family</a>
                                <a href="#!">Immigration</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { onMounted, ref, watch } from 'vue';
import api from '../api';

const articles = ref([]);
const loading = ref(true);
const error = ref('');
const searchInput = ref('');
const searchTerm = ref('');
let debounceTimer = null;

const asset = (path) => `/${path.replace(/^\/+/, '')}`;

function formatDate(iso) {
    if (!iso) return '';
    const d = new Date(iso);
    return d.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
}

async function loadArticles(q = '') {
    loading.value = true;
    error.value = '';
    try {
        const { data } = await api.get('/articles', { params: q ? { q } : {} });
        // Repo returns either a paginated array (search) or a flat mapped list.
        const payload = data.data;
        if (Array.isArray(payload)) {
            articles.value = payload;
        } else if (payload?.Model?.data) {
            articles.value = payload.Model.data;
        } else if (Array.isArray(payload?.data)) {
            articles.value = payload.data;
        } else {
            articles.value = [];
        }
    } catch (e) {
        error.value = 'Could not load articles.';
        articles.value = [];
    } finally {
        loading.value = false;
    }
}

function runSearch() {
    searchTerm.value = searchInput.value.trim();
    loadArticles(searchTerm.value);
}

function clearSearch() {
    searchInput.value = '';
    searchTerm.value = '';
    loadArticles();
}

// Debounced live search as the user types.
watch(searchInput, (val) => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        const trimmed = val.trim();
        if (trimmed === searchTerm.value) return;
        searchTerm.value = trimmed;
        loadArticles(trimmed);
    }, 350);
});

onMounted(() => loadArticles());
</script>
