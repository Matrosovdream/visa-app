<template>
    <section class="blog pt-30 pb-120">
        <div class="container mb-75 mt-50">
            <transition name="fade" mode="out-in">
                <!-- Loading skeleton -->
                <div v-if="loading" key="skeleton" class="row">
                    <div class="col-md-7">
                        <div class="skeleton skeleton-line lg" style="width: 80%;"></div>
                        <div class="skeleton skeleton-block" style="height: 90px;"></div>
                        <div class="skeleton skeleton-line"></div>
                        <div class="skeleton skeleton-line" style="width: 60%;"></div>
                        <div class="skeleton skeleton-line"></div>
                    </div>
                    <div class="col-md-4 offset-md-1">
                        <div class="skeleton skeleton-block" style="height: 220px;"></div>
                    </div>
                </div>

                <div v-else-if="error" key="error" class="alert alert-warning">
                    {{ error }}
                    <div class="mt-3">
                        <router-link to="/" class="btn btn-sm btn-success">Back to homepage</router-link>
                    </div>
                </div>

                <div v-else key="content" class="row">
                    <div class="col-md-7 mr-100">
                        <h2 v-reveal:up>Apply now for your {{ country?.name }} eVisa</h2>

                        <!-- Visa info banner -->
                        <transition name="fade" mode="out-in">
                            <div :key="visaBannerKey" class="alert alert-info mt-4" role="alert" v-reveal="{ delay: 100 }">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <i class="far fa-info-circle"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <template v-if="countryFrom && direction">
                                            <template v-if="direction.visa_req">
                                                <strong>Visa required</strong><br>
                                                You need a visa to travel to {{ country.name }} if you have a passport from
                                                {{ countryFrom.name }}.
                                            </template>
                                            <template v-else>
                                                <strong>No visa required</strong><br>
                                                You don't need a visa to travel to {{ country.name }} if you have a passport
                                                from {{ countryFrom.name }}.
                                            </template>
                                        </template>
                                        <template v-else>
                                            Choose a nationality to see if you need a visa to travel to
                                            <strong>{{ country?.name }}</strong>.
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </transition>

                        <!-- Nationality + product picker -->
                        <form v-if="!direction || direction.visa_req" class="mt-4" @submit.prevent="startApplication"
                            v-reveal="{ delay: 150 }">
                            <div class="mb-4">
                                <label class="form-label">What is your nationality?</label>
                                <SiteSelect v-model="nationalitySlug"
                                    :options="otherCountries"
                                    value-key="slug"
                                    :format-label="countryLabel"
                                    placeholder="Select your nationality"
                                    search-placeholder="Type a country or code"
                                    searchable
                                    @change="onNationalityChange" />
                                <small class="form-text text-muted">
                                    Ensure you select the nationality of the passport you'll be traveling with.
                                </small>
                            </div>

                            <transition name="fade">
                                <div v-if="products.length" class="mb-4">
                                    <label class="form-label">Applying for</label>
                                    <SiteSelect v-model="selectedProductId"
                                        :options="products"
                                        value-key="id"
                                        label-key="name"
                                        placeholder="Choose a visa type" />
                                </div>
                            </transition>

                            <div class="d-grid" v-if="products.length">
                                <button type="submit" class="btn btn-success btn-lg">
                                    Start your application
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Product detail card -->
                    <div class="col-md-4">
                        <transition-group name="fade" tag="div">
                            <div v-for="product in products" :key="product.id"
                                v-show="product.id === selectedProductId"
                                class="country-product-card mt-5"
                                v-reveal="{ delay: 200 }">
                                <h6 class="text-uppercase">{{ product.name }}</h6>
                                <h3>{{ getMeta(product, 'valid_for') || '—' }} days</h3>
                                <ul class="country-product-list mb-4">
                                    <li><strong>Valid for: </strong>&nbsp;{{ getMeta(product, 'valid_for') || '—' }} days</li>
                                    <li><strong>Number of entries: </strong>&nbsp;{{ getMeta(product, 'entries_number') || '—' }}</li>
                                    <li><strong>Max stay: </strong>&nbsp;{{ getMeta(product, 'max_stay') || '—' }} days in total</li>
                                </ul>
                            </div>
                        </transition-group>
                    </div>
                </div>
            </transition>
        </div>
    </section>
</template>

<script setup>
import { computed, onMounted, ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import api from '../api';
import { useGlobalsStore } from '../stores/globals';
import SiteSelect from '../components/SiteSelect.vue';

const countryLabel = (c) => `${c.name} — ${c.code}`;

const props = defineProps({
    slug: { type: String, required: true },
});

const route = useRoute();
const router = useRouter();
const globals = useGlobalsStore();

const country = ref(null);
const countryFrom = ref(null);
const direction = ref(null);
const products = ref([]);
const nationalitySlug = ref('');
const selectedProductId = ref(null);
const loading = ref(true);
const error = ref('');

const otherCountries = computed(() =>
    (globals.countries || []).filter((c) => c.slug !== props.slug)
);

const visaBannerKey = computed(() =>
    direction.value ? `dir-${direction.value.id}-${direction.value.visa_req ? 'y' : 'n'}` : 'empty'
);

function getMeta(product, key) {
    const meta = product?.meta;
    if (!meta) return null;
    const entries = Array.isArray(meta) ? meta : Object.values(meta);
    const match = entries.find((m) => m.meta_key === key || m.key === key);
    return match?.meta_value ?? match?.value ?? null;
}

async function loadCountry() {
    loading.value = true;
    error.value = '';
    try {
        const { data } = await api.get(`/countries/${props.slug}`);
        country.value = data.data?.Model ?? data.data;
        document.title = country.value?.name ? `${country.value.name} — eVisa` : 'Country';
    } catch (e) {
        error.value = e.response?.status === 404 ? 'Country not found.' : 'Could not load country information.';
    } finally {
        loading.value = false;
    }
}

async function resolveDirection(fromCode, toCode) {
    direction.value = null;
    products.value = [];

    if (!fromCode || !toCode) return;
    try {
        const { data } = await api.get('/directions/search', {
            params: { from: fromCode, to: toCode },
        });
        const payload = data.data;
        const model = payload?.Model;
        direction.value = {
            id: payload?.id,
            visa_req: Boolean(model?.visa_req),
        };

        // Pull products for the destination country.
        if (direction.value.visa_req) {
            const { data: p } = await api.get(`/countries/${props.slug}/products`);
            const list = p.data?.Model ?? p.data ?? [];
            const mapped = Array.isArray(list)
                ? list.map((item) => item.Model ?? item)
                : [];
            products.value = mapped;
            selectedProductId.value = mapped[0]?.id ?? null;
        }
    } catch (e) {
        // 404 means no direction configured — treat as "no visa info".
        direction.value = null;
        products.value = [];
    }
}

async function onNationalityChange() {
    await refreshFromQuery();
    router.replace({
        name: 'country',
        params: { slug: props.slug },
        query: nationalitySlug.value ? { nationality: nationalitySlug.value } : {},
    });
}

async function refreshFromQuery() {
    const slug = nationalitySlug.value;
    if (!slug) {
        countryFrom.value = null;
        direction.value = null;
        products.value = [];
        return;
    }
    // Find the "from" country record from the globals store.
    const from = (globals.countries || []).find((c) => c.slug === slug);
    countryFrom.value = from || null;

    if (from && country.value) {
        await resolveDirection(from.code, country.value.code);
    }
}

function startApplication() {
    if (!selectedProductId.value) return;
    // Apply page still uses legacy Blade — full nav is intentional.
    window.location.href = `/country/${props.slug}/apply-now?nationality=${nationalitySlug.value}&product_id=${selectedProductId.value}`;
}

async function init() {
    await loadCountry();
    // Make sure globals are warm so the nationality select has options.
    if (!globals.loaded) await globals.load();
    nationalitySlug.value = route.query.nationality?.toString() || '';
    await refreshFromQuery();
}

onMounted(init);

// If the user navigates between countries, reload.
watch(() => props.slug, () => init());
watch(() => route.query.nationality, (v) => {
    if (v !== nationalitySlug.value) {
        nationalitySlug.value = v?.toString() || '';
        refreshFromQuery();
    }
});
</script>
