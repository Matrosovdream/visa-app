<template>
    <DataTable :rows="rows" :columns="columns" :loading="loading" :error="error"
        search-placeholder="Search articles…"
        :search-keys="['title', 'slug']">
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
    { key: 'title', label: 'Title' },
    { key: 'slug', label: 'Slug' },
    { key: 'created_at', label: 'Created', width: '140px' },
];

function formatDate(iso) {
    if (!iso) return '';
    return new Date(iso).toLocaleDateString();
}

onMounted(async () => {
    try {
        const { data } = await api.get('/articles');
        rows.value = data.data ?? [];
    } catch (e) {
        error.value = 'Could not load articles.';
    } finally {
        loading.value = false;
    }
});
</script>
