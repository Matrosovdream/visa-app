<template>
    <div>
        <PageHeader title="Directions"
            subtitle="From / to country pairs and their visa requirements." />

        <DataTable :rows="rows" :columns="columns" :loading="loading" :error="error"
            search-placeholder="Search by country, code or slug…"
            :search-keys="['name', 'slug', 'country_from_code', 'country_to_code', 'countryFrom.name', 'countryTo.name']">
            <template #cell:name="{ row }">
                <router-link :to="{ name: 'dashboard.direction.show', params: { id: row.id } }"
                    class="adm-link">
                    {{ row.name }}
                </router-link>
            </template>
            <template #cell:countryFrom="{ row }">
                <span>{{ row.countryFrom?.name || row.country_from_code }}</span>
                <span class="adm-text-soft"> ({{ row.country_from_code }})</span>
            </template>
            <template #cell:countryTo="{ row }">
                <span>{{ row.countryTo?.name || row.country_to_code }}</span>
                <span class="adm-text-soft"> ({{ row.country_to_code }})</span>
            </template>
            <template #cell:visa_req="{ value }">
                <span class="adm-badge" :class="value ? 'adm-badge--warn' : 'adm-badge--success'">
                    {{ value ? 'Required' : 'Not required' }}
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
    { key: 'countryFrom', label: 'From' },
    { key: 'countryTo', label: 'To' },
    { key: 'visa_req', label: 'Visa', width: '140px' },
];

onMounted(async () => {
    try {
        const { data } = await api.get('/directions');
        rows.value = data.data ?? [];
    } catch (e) {
        error.value = 'Could not load directions.';
    } finally {
        loading.value = false;
    }
});
</script>
