<template>
    <div>
        <PageHeader title="Users" subtitle="All accounts with access to the app.">
            <template #actions>
                <router-link :to="{ name: 'dashboard.user.create' }" class="adm-btn adm-btn--primary">
                    + New user
                </router-link>
            </template>
        </PageHeader>

        <DataTable :rows="rows" :columns="columns" :loading="loading" :error="error"
            search-placeholder="Search by name or email…"
            :search-keys="['name', 'email']">
            <template #cell:roles="{ row }">
                <span v-if="!row.roles?.length" class="adm-text-soft">—</span>
                <span v-else v-for="role in row.roles" :key="role.id"
                    class="adm-badge adm-badge--success" style="margin-right: 4px;">
                    {{ role.title || role.slug }}
                </span>
            </template>
            <template #cell:is_active="{ value }">
                <span class="adm-badge" :class="value ? 'adm-badge--success' : 'adm-badge--danger'">
                    {{ value ? 'Active' : 'Disabled' }}
                </span>
            </template>
            <template #cell:created_at="{ value }">{{ formatDate(value) }}</template>
            <template #cell:actions="{ row }">
                <ActionsCell :edit-to="{ name: 'dashboard.user.edit', params: { id: row.id } }"
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
    { key: 'email', label: 'Email' },
    { key: 'roles', label: 'Roles' },
    { key: 'is_active', label: 'Status', width: '110px' },
    { key: 'created_at', label: 'Created', width: '140px' },
    { key: 'actions', label: '', width: '90px' },
];

function formatDate(iso) {
    return iso ? new Date(iso).toLocaleDateString() : '';
}

async function load() {
    loading.value = true;
    try {
        const { data } = await api.get('/users');
        rows.value = data.data ?? [];
    } catch (e) {
        error.value = 'Could not load users.';
    } finally {
        loading.value = false;
    }
}

async function askDelete(row) {
    const ok = await confirm.ask({
        title: `Delete ${row.name}?`,
        message: 'The user will lose access immediately. This cannot be undone.',
        confirmLabel: 'Delete user',
        danger: true,
    });
    if (!ok) return;
    try {
        await api.delete(`/users/${row.id}`);
        rows.value = rows.value.filter((u) => u.id !== row.id);
        toast.success('User deleted.');
    } catch (e) {
        toast.error(e.response?.data?.message || 'Could not delete user.');
    }
}

onMounted(load);
</script>
