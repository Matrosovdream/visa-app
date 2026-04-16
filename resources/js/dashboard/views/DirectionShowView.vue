<template>
    <div>
        <PageHeader :eyebrow="`Direction #${id}`"
            :title="direction?.name || 'Loading…'"
            :subtitle="direction ? subtitle : ''">
            <template #actions>
                <router-link :to="{ name: 'dashboard.directions' }" class="adm-btn adm-btn--ghost">← Back</router-link>
            </template>
        </PageHeader>

        <div v-if="loading" class="adm-card">
            <div class="adm-skel adm-skel-line" style="width: 60%;"></div>
            <div class="adm-skel adm-skel-line" style="width: 80%;"></div>
        </div>

        <div v-else-if="!direction" class="adm-card adm-empty">Direction not found.</div>

        <div v-else class="adm-grid-2">
            <div class="adm-card">
                <h3 class="adm-card__title">Route</h3>
                <dl class="adm-meta-list">
                    <dt>Slug</dt><dd><code>{{ direction.slug }}</code></dd>
                    <dt>From</dt>
                    <dd>{{ direction.countryFrom?.name }} <span class="adm-text-soft">({{ direction.country_from_code }})</span></dd>
                    <dt>To</dt>
                    <dd>{{ direction.countryTo?.name }} <span class="adm-text-soft">({{ direction.country_to_code }})</span></dd>
                    <dt>Visa required</dt>
                    <dd>
                        <span class="adm-badge" :class="direction.visa_req ? 'adm-badge--warn' : 'adm-badge--success'">
                            {{ direction.visa_req ? 'Yes' : 'No' }}
                        </span>
                    </dd>
                </dl>
            </div>

            <div class="adm-card">
                <h3 class="adm-card__title">
                    Products
                    <span class="adm-text-soft" style="font-weight: 400; font-size: 0.85rem;">
                        ({{ direction.products?.length || 0 }})
                    </span>
                </h3>
                <ul v-if="direction.products?.length" style="list-style: none; padding: 0; margin: 0;">
                    <li v-for="p in direction.products" :key="p.id"
                        style="padding: 8px 0; border-bottom: 1px solid var(--adm-border);">
                        Product #{{ p.product_id ?? p.id }}
                    </li>
                </ul>
                <div v-else class="adm-text-soft">No products configured for this route.</div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, ref, watch } from 'vue';
import api from '../api';
import PageHeader from '../components/PageHeader.vue';

const props = defineProps({ id: { type: [String, Number], required: true } });

const direction = ref(null);
const loading = ref(true);

const subtitle = computed(() => {
    if (!direction.value) return '';
    return `${direction.value.country_from_code} → ${direction.value.country_to_code}`;
});

async function load() {
    loading.value = true;
    try {
        const { data } = await api.get(`/directions/${props.id}`);
        direction.value = data.data ?? null;
    } catch (e) {
        direction.value = null;
    } finally {
        loading.value = false;
    }
}

onMounted(load);
watch(() => props.id, load);
</script>
