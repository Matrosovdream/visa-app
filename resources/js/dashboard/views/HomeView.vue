<template>
    <div>
        <div class="adm-stats">
            <div v-for="stat in stats" :key="stat.label" class="adm-stat">
                <div class="adm-stat__label">{{ stat.label }}</div>
                <div class="adm-stat__value">
                    <span v-if="loading" class="adm-skel" style="display:inline-block;width:60px;height:1.4rem;"></span>
                    <span v-else>{{ stat.value }}</span>
                </div>
                <div v-if="stat.hint" class="adm-stat__delta">{{ stat.hint }}</div>
            </div>
        </div>

        <div class="adm-card">
            <h3 class="adm-card__title">Quick start</h3>
            <p class="adm-text-muted" style="margin: 0 0 12px;">
                Use the sidebar to jump into Users, Orders, Products, Articles or Countries.
                Click any row to see more details (detail screens coming next).
            </p>
            <div class="adm-flex adm-gap-8">
                <router-link :to="{ name: 'dashboard.orders' }" class="adm-btn adm-btn--primary">
                    View orders →
                </router-link>
                <router-link :to="{ name: 'dashboard.users' }" class="adm-btn">
                    Manage users
                </router-link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import api from '../api';

const loading = ref(true);
const stats = ref([
    { label: 'Total users', value: 0, hint: '' },
    { label: 'Total orders', value: 0, hint: '' },
    { label: 'Products', value: 0, hint: '' },
    { label: 'Articles', value: 0, hint: '' },
]);

onMounted(async () => {
    try {
        const { data } = await api.get('/stats');
        const s = data.data ?? {};
        stats.value = [
            { label: 'Total users', value: s.users ?? 0 },
            { label: 'Total orders', value: s.orders ?? 0, hint: s.orders_paid != null ? `${s.orders_paid} paid` : '' },
            { label: 'Products', value: s.products ?? 0 },
            { label: 'Articles', value: s.articles ?? 0 },
        ];
    } catch (e) {
        // leave defaults
    } finally {
        loading.value = false;
    }
});
</script>
