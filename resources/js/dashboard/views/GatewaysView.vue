<template>
    <div>
        <PageHeader title="Payment gateways" subtitle="Configured payment providers." />

        <DataTable :rows="rows" :columns="columns" :loading="loading" :error="error"
            search-placeholder="Search gateways…" :search-keys="['name', 'slug']">
            <template #cell:is_active="{ value }">
                <span class="adm-badge" :class="value ? 'adm-badge--success' : 'adm-badge--danger'">
                    {{ value ? 'Enabled' : 'Disabled' }}
                </span>
            </template>
        </DataTable>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import api from '../api';
import DataTable from '../components/DataTable.vue';
import PageHeader from '../components/PageHeader.vue';

const rows = ref([]);
const loading = ref(true);
const error = ref('');

const columns = [
    { key: 'id', label: 'ID', width: '70px' },
    { key: 'name', label: 'Name' },
    { key: 'slug', label: 'Slug' },
    { key: 'description', label: 'Description' },
    { key: 'is_active', label: 'Status', width: '110px' },
];

onMounted(async () => {
    try {
        const { data } = await api.get('/gateways');
        rows.value = data.data ?? [];
    } catch (e) {
        error.value = 'Could not load gateways.';
    } finally {
        loading.value = false;
    }
});
</script>
