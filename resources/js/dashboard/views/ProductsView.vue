<template>
    <DataTable :rows="rows" :columns="columns" :loading="loading" :error="error"
        search-placeholder="Search products…"
        :search-keys="['name', 'slug']">
        <template #cell:price="{ value }">
            <strong>{{ Number(value).toFixed(2) }}</strong>
        </template>
        <template #cell:created_at="{ value }">
            {{ formatDate(value) }}
        </template>
    </DataTable>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import api from '../api';
import DataTable from '../components/DataTable.vue';

const rows = ref([]);
const loading = ref(true);
const error = ref('');

const columns = [
    { key: 'id', label: 'ID', width: '70px' },
    { key: 'name', label: 'Name' },
    { key: 'slug', label: 'Slug' },
    { key: 'price', label: 'Price', width: '100px' },
    { key: 'created_at', label: 'Created', width: '140px' },
];

function formatDate(iso) {
    if (!iso) return '';
    return new Date(iso).toLocaleDateString();
}

onMounted(async () => {
    try {
        const { data } = await api.get('/products');
        rows.value = data.data ?? [];
    } catch (e) {
        error.value = 'Could not load products.';
    } finally {
        loading.value = false;
    }
});
</script>
