<template>
    <div>
        <PageHeader eyebrow="Orders" title="New order" subtitle="Create an order manually.">
            <template #actions>
                <router-link :to="{ name: 'dashboard.orders' }" class="adm-btn adm-btn--ghost">← Back</router-link>
            </template>
        </PageHeader>

        <form class="adm-card" @submit.prevent="submit">
            <div class="adm-grid-2">
                <FormSelect v-model="form.user_id" label="Customer" numeric
                    :options="users" value-key="id" :format-options="true"
                    label-key="email" placeholder="— No customer —" :error="err('user_id')" />
                <FormSelect v-model="form.status_id" label="Status" numeric
                    :options="statuses" value-key="id" label-key="name"
                    placeholder="— Default —" :error="err('status_id')" />
            </div>
            <div class="adm-grid-2">
                <FormField v-model="form.total_price" label="Total price" type="number"
                    step="0.01" min="0" required :error="err('total_price')" />
                <FormCheckbox v-model="form.is_paid" label="Mark as paid" />
            </div>
            <div class="adm-form-actions">
                <button type="submit" class="adm-btn adm-btn--primary" :disabled="saving">
                    {{ saving ? 'Creating…' : 'Create order' }}
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { onMounted, reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import api from '../api';
import PageHeader from '../components/PageHeader.vue';
import FormField from '../components/FormField.vue';
import FormSelect from '../components/FormSelect.vue';
import FormCheckbox from '../components/FormCheckbox.vue';
import { useToastStore } from '../stores/toast';

const router = useRouter();
const toast = useToastStore();

const users = ref([]);
const statuses = ref([]);
const saving = ref(false);
const errors = ref({});

const form = reactive({
    user_id: null,
    status_id: null,
    total_price: 0,
    is_paid: false,
});

function err(key) {
    const v = errors.value[key];
    return Array.isArray(v) ? v[0] : v || '';
}

async function submit() {
    saving.value = true;
    errors.value = {};
    try {
        const payload = { ...form };
        if (!payload.user_id) delete payload.user_id;
        if (!payload.status_id) delete payload.status_id;
        const { data } = await api.post('/orders', payload);
        toast.success('Order created.');
        router.push({ name: 'dashboard.order.show', params: { id: data.data.id } });
    } catch (e) {
        if (e.response?.status === 422) errors.value = e.response.data.errors || {};
        else toast.error(e.response?.data?.message || 'Could not create order.');
    } finally {
        saving.value = false;
    }
}

onMounted(async () => {
    try {
        const [u, s] = await Promise.all([
            api.get('/users'),
            api.get('/order-statuses'),
        ]);
        users.value = u.data.data ?? [];
        statuses.value = s.data.data ?? [];
    } catch (e) {
        toast.error('Could not load reference data.');
    }
});
</script>
