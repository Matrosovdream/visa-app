<template>
    <DataTable :rows="rows" :columns="columns" :loading="loading" :error="error"
        search-placeholder="Search by name or code…"
        :search-keys="['name', 'code', 'slug']" />
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
    { key: 'code', label: 'Code', width: '100px' },
    { key: 'slug', label: 'Slug' },
];

onMounted(async () => {
    try {
        const { data } = await api.get('/countries');
        rows.value = data.data ?? [];
    } catch (e) {
        error.value = 'Could not load countries.';
    } finally {
        loading.value = false;
    }
});
</script>
