<template>
    <div>
        <PageHeader title="Products" subtitle="Visa products and their offers.">
            <template #actions>
                <router-link :to="{ name: 'dashboard.product.create' }" class="adm-btn adm-btn--primary">
                    + New product
                </router-link>
            </template>
        </PageHeader>

        <DataTable :rows="rows" :columns="columns" :loading="loading" :error="error"
            search-placeholder="Search products…"
            :search-keys="['name', 'slug']">
            <template #cell:price="{ value }">
                <strong>{{ Number(value).toFixed(2) }}</strong>
            </template>
            <template #cell:published="{ value }">
                <span class="adm-badge" :class="value ? 'adm-badge--success' : ''">
                    {{ value ? 'Published' : 'Draft' }}
                </span>
            </template>
            <template #cell:created_at="{ value }">{{ formatDate(value) }}</template>
            <template #cell:actions="{ row }">
                <ActionsCell :edit-to="{ name: 'dashboard.product.edit', params: { id: row.id } }"
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
    { key: 'name', label: 'Name' },
    { key: 'slug', label: 'Slug' },
    { key: 'price', label: 'Price', width: '100px' },
    { key: 'published', label: 'Status', width: '110px' },
    { key: 'created_at', label: 'Created', width: '140px' },
    { key: 'actions', label: '', width: '90px' },
];

function formatDate(iso) { return iso ? new Date(iso).toLocaleDateString() : ''; }

async function askDelete(row) {
    const ok = await confirm.ask({
        title: `Delete "${row.name}"?`,
        message: 'The product will be soft-deleted.',
        confirmLabel: 'Delete',
        danger: true,
    });
    if (!ok) return;
    try {
        await api.delete(`/products/${row.id}`);
        rows.value = rows.value.filter((p) => p.id !== row.id);
        toast.success('Product deleted.');
    } catch (e) {
        toast.error(e.response?.data?.message || 'Could not delete product.');
    }
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
