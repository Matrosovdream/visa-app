<template>
    <div>
        <PageHeader title="Orders" subtitle="All customer orders, newest first.">
            <template #actions>
                <router-link :to="{ name: 'dashboard.order.create' }" class="adm-btn adm-btn--primary">
                    + New order
                </router-link>
            </template>
        </PageHeader>

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
            <template #cell:created_at="{ value }">{{ formatDate(value) }}</template>
            <template #cell:actions="{ row }">
                <ActionsCell :edit-to="{ name: 'dashboard.order.show', params: { id: row.id } }"
                    :on-delete="() => askDelete(row)" />
            </template>
        </DataTable>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import api from '../api';
import DataTable from '../components/DataTable.vue';
import PageHeader from '../components/PageHeader.vue';
import ActionsCell from '../components/ActionsCell.vue';
import { useToastStore } from '../stores/toast';
import { useConfirmStore } from '../stores/confirm';

const toast = useToastStore();
const confirm = useConfirmStore();

const rows = ref([]);
const loading = ref(true);
const error = ref('');

const columns = [
    { key: 'id', label: 'ID', width: '70px' },
    { key: 'hash', label: 'Hash' },
    { key: 'user', label: 'Customer' },
    { key: 'status', label: 'Status', width: '130px' },
    { key: 'is_paid', label: 'Payment', width: '100px' },
    { key: 'total_price', label: 'Total', width: '100px' },
    { key: 'created_at', label: 'Created', width: '140px' },
    { key: 'actions', label: '', width: '90px' },
];

function formatDate(iso) {
    return iso ? new Date(iso).toLocaleDateString() : '';
}

async function askDelete(row) {
    const ok = await confirm.ask({
        title: `Delete order #${row.id}?`,
        message: 'This will remove the order and its related data.',
        confirmLabel: 'Delete',
        danger: true,
    });
    if (!ok) return;
    try {
        await api.delete(`/orders/${row.id}`);
        rows.value = rows.value.filter((o) => o.id !== row.id);
        toast.success('Order deleted.');
    } catch (e) {
        toast.error(e.response?.data?.message || 'Could not delete order.');
    }
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
