<template>
    <div>
        <PageHeader title="Product offers" subtitle="Pricing options attached to products.">
            <template #actions>
                <button type="button" class="adm-btn adm-btn--primary" @click="openCreate">+ New offer</button>
            </template>
        </PageHeader>

        <DataTable :rows="rows" :columns="columns" :loading="loading" :error="error"
            search-placeholder="Search offers…" :search-keys="['name', 'product.name']">
            <template #cell:product="{ row }">
                {{ row.product?.name || `#${row.product_id}` }}
            </template>
            <template #cell:price="{ value }"><strong>{{ Number(value).toFixed(2) }}</strong></template>
            <template #cell:actions="{ row }">
                <ActionsCell :edit-to="null" :on-delete="() => askDelete(row)">
                    <button type="button" class="adm-actions__btn" title="Edit" @click="openEdit(row)">
                        <svg viewBox="0 0 16 16" width="14" height="14" fill="none" stroke="currentColor"
                            stroke-width="1.6"><path d="M11 2l3 3-8 8H3v-3l8-8z"/></svg>
                    </button>
                </ActionsCell>
            </template>
        </DataTable>

        <!-- Inline editor -->
        <teleport to="body">
            <transition name="adm-modal">
                <div v-if="form" class="adm-modal" @mousedown.self="close">
                    <div class="adm-modal__panel" style="max-width: 520px;">
                        <h3 class="adm-modal__title">{{ form.id ? 'Edit offer' : 'New offer' }}</h3>
                        <FormSelect v-model="form.product_id" label="Product" required numeric
                            :options="products" value-key="id" label-key="name"
                            placeholder="Pick a product" :error="err('product_id')" />
                        <FormField v-model="form.name" label="Name" required :error="err('name')" />
                        <FormField v-model="form.price" label="Price (USD)" type="number"
                            step="0.01" min="0" required :error="err('price')" />
                        <FormTextarea v-model="form.description" label="Description" :rows="3"
                            :error="err('description')" />
                        <div class="adm-modal__actions">
                            <button type="button" class="adm-btn" @click="close">Cancel</button>
                            <button type="button" class="adm-btn adm-btn--primary"
                                :disabled="saving" @click="save">
                                {{ saving ? 'Saving…' : 'Save' }}
                            </button>
                        </div>
                    </div>
                </div>
            </transition>
        </teleport>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import api from '../api';
import DataTable from '../components/DataTable.vue';
import PageHeader from '../components/PageHeader.vue';
import ActionsCell from '../components/ActionsCell.vue';
import FormField from '../components/FormField.vue';
import FormSelect from '../components/FormSelect.vue';
import FormTextarea from '../components/FormTextarea.vue';
import { useToastStore } from '../stores/toast';
import { useConfirmStore } from '../stores/confirm';

const toast = useToastStore();
const confirm = useConfirmStore();

const rows = ref([]);
const products = ref([]);
const loading = ref(true);
const error = ref('');
const form = ref(null);
const saving = ref(false);
const errors = ref({});

const columns = [
    { key: 'id', label: 'ID', width: '70px' },
    { key: 'product', label: 'Product' },
    { key: 'name', label: 'Name' },
    { key: 'price', label: 'Price', width: '110px' },
    { key: 'actions', label: '', width: '90px' },
];

function err(key) {
    const v = errors.value[key];
    return Array.isArray(v) ? v[0] : v || '';
}

async function loadAll() {
    loading.value = true;
    try {
        const [r, p] = await Promise.all([api.get('/offers'), api.get('/products')]);
        rows.value = r.data.data ?? [];
        products.value = p.data.data ?? [];
    } catch (e) {
        error.value = 'Could not load offers.';
    } finally {
        loading.value = false;
    }
}

function openCreate() {
    errors.value = {};
    form.value = { id: null, product_id: null, name: '', price: 0, description: '' };
}
function openEdit(row) {
    errors.value = {};
    form.value = {
        id: row.id,
        product_id: row.product_id ?? row.product?.id ?? null,
        name: row.name ?? '',
        price: row.price ?? 0,
        description: row.description ?? '',
    };
}
function close() { form.value = null; errors.value = {}; }

async function save() {
    saving.value = true;
    errors.value = {};
    try {
        const payload = { ...form.value };
        delete payload.id;
        if (form.value.id) {
            const { data } = await api.put(`/offers/${form.value.id}`, payload);
            rows.value = rows.value.map((r) => r.id === form.value.id ? data.data : r);
            toast.success('Offer updated.');
        } else {
            const { data } = await api.post('/offers', payload);
            rows.value = [data.data, ...rows.value];
            toast.success('Offer created.');
        }
        close();
    } catch (e) {
        if (e.response?.status === 422) errors.value = e.response.data.errors || {};
        else toast.error(e.response?.data?.message || 'Could not save offer.');
    } finally {
        saving.value = false;
    }
}

async function askDelete(row) {
    const ok = await confirm.ask({
        title: `Delete offer "${row.name}"?`,
        confirmLabel: 'Delete', danger: true,
    });
    if (!ok) return;
    try {
        await api.delete(`/offers/${row.id}`);
        rows.value = rows.value.filter((r) => r.id !== row.id);
        toast.success('Offer deleted.');
    } catch (e) {
        toast.error(e.response?.data?.message || 'Could not delete offer.');
    }
}

onMounted(loadAll);
</script>
