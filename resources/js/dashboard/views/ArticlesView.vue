<template>
    <div>
        <PageHeader title="Articles" subtitle="Blog / knowledge-base posts.">
            <template #actions>
                <router-link :to="{ name: 'dashboard.article.create' }" class="adm-btn adm-btn--primary">
                    + New article
                </router-link>
            </template>
        </PageHeader>

        <DataTable :rows="rows" :columns="columns" :loading="loading" :error="error"
            search-placeholder="Search articles…"
            :search-keys="['title', 'slug']">
            <template #cell:created_at="{ value }">{{ formatDate(value) }}</template>
            <template #cell:actions="{ row }">
                <ActionsCell :edit-to="{ name: 'dashboard.article.edit', params: { id: row.id } }"
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
    { key: 'title', label: 'Title' },
    { key: 'slug', label: 'Slug' },
    { key: 'created_at', label: 'Created', width: '140px' },
    { key: 'actions', label: '', width: '90px' },
];

function formatDate(iso) { return iso ? new Date(iso).toLocaleDateString() : ''; }

async function askDelete(row) {
    const ok = await confirm.ask({
        title: `Delete "${row.title}"?`,
        message: 'The article will be soft-deleted.',
        confirmLabel: 'Delete',
        danger: true,
    });
    if (!ok) return;
    try {
        await api.delete(`/articles/${row.id}`);
        rows.value = rows.value.filter((a) => a.id !== row.id);
        toast.success('Article deleted.');
    } catch (e) {
        toast.error(e.response?.data?.message || 'Could not delete article.');
    }
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
