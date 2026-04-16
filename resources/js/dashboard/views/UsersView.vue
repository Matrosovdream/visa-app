<template>
    <DataTable :rows="rows" :columns="columns" :loading="loading" :error="error"
        search-placeholder="Search by name or email…"
        :search-keys="['name', 'email']">
        <template #cell:roles="{ row }">
            <span v-if="!row.roles?.length" class="adm-text-soft">—</span>
            <span v-else v-for="role in row.roles" :key="role.id"
                class="adm-badge" :class="`adm-badge--${roleClass(role.slug)}`"
                style="margin-right: 4px;">
                {{ role.title || role.slug }}
            </span>
        </template>
        <template #cell:is_active="{ value }">
            <span class="adm-badge" :class="value ? 'adm-badge--success' : 'adm-badge--danger'">
                {{ value ? 'Active' : 'Disabled' }}
            </span>
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
    { key: 'email', label: 'Email' },
    { key: 'roles', label: 'Roles' },
    { key: 'is_active', label: 'Status', width: '110px' },
    { key: 'created_at', label: 'Created', width: '140px' },
];

function roleClass(slug) {
    if (slug === 'admin') return 'success';
    if (slug === 'manager') return 'warn';
    return 'success';
}
function formatDate(iso) {
    if (!iso) return '';
    return new Date(iso).toLocaleDateString();
}

onMounted(async () => {
    try {
        const { data } = await api.get('/users');
        rows.value = data.data ?? [];
    } catch (e) {
        error.value = 'Could not load users.';
    } finally {
        loading.value = false;
    }
});
</script>
