<template>
    <DataTable :rows="rows" :columns="columns" :loading="loading" :error="error"
        search-placeholder="Search by hash or user…"
        :search-keys="['hash', 'user.email', 'user.name']">
        <template #cell:user="{ row }">
            <div style="font-weight:500">{{ row.user?.name || '—' }}</div>
            <div class="adm-text-soft" style="font-size: 0.78rem;">{{ row.user?.email }}</div>
        </template>
        <template #cell:status="{ row }">
            <span v-if="row.status?.name" class="adm-badge"
                :style="row.status?.color ? { background: row.status.color, color: '#fff', borderColor: 'transparent' } : null">
                {{ row.status.name }}
            </span>
            <span v-else class="adm-text-soft">—</span>
        </template>
        <template #cell:is_paid="{ value }">
            <span class="adm-badge" :class="value ? 'adm-badge--success' : 'adm-badge--warn'">
                {{ value ? 'Paid' : 'Unpaid' }}
            </span>
        </template>
        <template #cell:total_price="{ value }">
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
    { key: 'hash', label: 'Hash' },
    { key: 'user', label: 'Customer' },
    { key: 'status', label: 'Status', width: '140px' },
    { key: 'is_paid', label: 'Payment', width: '100px' },
    { key: 'total_price', label: 'Total', width: '100px' },
    { key: 'created_at', label: 'Created', width: '140px' },
];

function formatDate(iso) {
    if (!iso) return '';
    return new Date(iso).toLocaleDateString();
}

onMounted(async () => {
    try {
        const { data } = await api.get('/orders');
        rows.value = data.data ?? [];
    } catch (e) {
        error.value = 'Could not load orders.';
    } finally {
        loading.value = false;
    }
});
</script>
