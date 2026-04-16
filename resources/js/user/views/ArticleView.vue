<template>
    <section class="blog pt-30 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="blog-post-wrapper">
                        <transition name="fade" mode="out-in">
                            <div v-if="loading" key="skeleton">
                                <div class="skeleton skeleton-line sm" style="width: 140px;"></div>
                                <div class="skeleton skeleton-line lg" style="width: 80%;"></div>
                                <div class="skeleton skeleton-block"></div>
                                <div class="skeleton skeleton-line"></div>
                                <div class="skeleton skeleton-line"></div>
                                <div class="skeleton skeleton-line" style="width: 92%;"></div>
                                <div class="skeleton skeleton-line" style="width: 70%;"></div>
                            </div>

                            <div v-else-if="error" key="error" class="alert alert-warning">
                                {{ error }}
                                <div class="mt-3">
                                    <router-link to="/articles" class="btn btn-sm btn-success">
                                        Back to articles
                                    </router-link>
                                </div>
                            </div>

                            <article v-else-if="article" key="content" class="post-details">
                                <ul class="post-meta ul_li">
                                    <li>
                                        <span class="posted-on">{{ formatDate(article.created_at) }}</span>
                                    </li>
                                </ul>
                                <h2>{{ article.title }}</h2>
                                <div v-if="article.short_description" class="lead mb-4">
                                    {{ article.short_description }}
                                </div>
                                <div v-html="article.content"></div>

                                <div class="mt-5">
                                    <router-link to="/articles" class="btn btn-outline-success btn-sm">
                                        ← Back to all articles
                                    </router-link>
                                </div>
                            </article>
                        </transition>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="blog-sidebar"></div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { onMounted, ref, watch } from 'vue';
import { useRoute } from 'vue-router';
import api from '../api';

const props = defineProps({
    slug: { type: String, required: true },
});

const route = useRoute();
const article = ref(null);
const loading = ref(true);
const error = ref('');

function formatDate(iso) {
    if (!iso) return '';
    const d = new Date(iso);
    return d.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
}

async function load(slug) {
    loading.value = true;
    error.value = '';
    article.value = null;
    try {
        const { data } = await api.get(`/articles/${slug}`);
        article.value = data.data?.Model ?? data.data ?? null;
        document.title = article.value?.title ? `${article.value.title} — Articles` : 'Article';
    } catch (e) {
        error.value = e.response?.status === 404 ? 'Article not found.' : 'Could not load article.';
    } finally {
        loading.value = false;
    }
}

onMounted(() => load(props.slug));
watch(() => route.params.slug, (slug) => {
    if (slug) load(slug);
});
</script>
