<template>
    <div>
        <PageHeader :eyebrow="`Order #${id}`"
            :title="order?.hash ? `#${order.id}` : 'Loading…'"
            :subtitle="order ? formatDate(order.created_at) : ''">
            <template #actions>
                <router-link :to="{ name: 'dashboard.orders' }" class="adm-btn adm-btn--ghost">← Back</router-link>
            </template>
        </PageHeader>

        <div v-if="loading" class="adm-card">
            <div class="adm-skel adm-skel-line" style="width: 50%;"></div>
            <div class="adm-skel adm-skel-line" style="width: 80%;"></div>
            <div class="adm-skel adm-skel-line"></div>
        </div>

        <div v-else-if="!order" class="adm-card adm-empty">
            Order not found.
        </div>

        <div v-else class="adm-grid-2">
            <!-- LEFT: edit panel -->
            <form class="adm-card" @submit.prevent="save">
                <h3 class="adm-card__title">Status &amp; payment</h3>

                <FormSelect v-model="form.status_id" label="Status" numeric
                    :options="statuses" value-key="id" label-key="name"
                    placeholder="— Pick a status —" :error="err('status_id')" />

                <FormCheckbox v-model="form.is_paid" label="Order is paid" />

                <FormField v-model="form.total_price" label="Total price"
                    type="number" step="0.01" min="0" :error="err('total_price')" />

                <div class="adm-form-actions">
                    <button type="submit" class="adm-btn adm-btn--primary" :disabled="saving">
                        {{ saving ? 'Saving…' : 'Save changes' }}
                    </button>
                </div>
            </form>

            <!-- RIGHT: read-only summary + travellers -->
            <div>
                <div class="adm-card" style="margin-bottom: 16px;">
                    <h3 class="adm-card__title">Customer</h3>
                    <dl class="adm-meta-list">
                        <dt>Name</dt><dd>{{ order.user?.name || '—' }}</dd>
                        <dt>Email</dt><dd>{{ order.user?.email || '—' }}</dd>
                        <dt>Hash</dt>
                        <dd style="font-family: ui-monospace, monospace; font-size: 0.82rem;">
                            {{ order.hash }}
                        </dd>
                        <dt>Created</dt><dd>{{ formatDate(order.created_at) }}</dd>
                    </dl>
                </div>

                <div class="adm-card">
                    <div class="adm-flex adm-between adm-center" style="margin-bottom: 12px;">
                        <h3 class="adm-card__title" style="margin: 0;">
                            Applicants
                            <span class="adm-text-soft" style="font-weight: 400; font-size: 0.85rem;">
                                ({{ order.travellers?.length || 0 }})
                            </span>
                        </h3>
                        <router-link :to="{ name: 'dashboard.order.traveller.create', params: { id } }"
                            class="adm-btn adm-btn--primary" style="padding: 6px 10px; font-size: 0.82rem;">
                            + Add
                        </router-link>
                    </div>
                    <div v-if="!order.travellers?.length" class="adm-text-soft">
                        No applicants.
                    </div>
                    <ul v-else style="list-style: none; padding: 0; margin: 0;">
                        <li v-for="t in order.travellers" :key="t.id"
                            style="padding: 10px 0; border-bottom: 1px solid var(--adm-border);
                                display: flex; justify-content: space-between; align-items: center; gap: 10px;">
                            <div>
                                <div style="font-weight: 600;">{{ t.full_name || `${t.name} ${t.lastname}` }}</div>
                                <div class="adm-text-soft" style="font-size: 0.82rem;">
                                    <span v-if="t.passport">Passport: {{ t.passport }}</span>
                                    <span v-else>—</span>
                                </div>
                            </div>
                            <div class="adm-flex adm-gap-8">
                                <router-link :to="{ name: 'dashboard.order.traveller.edit',
                                    params: { id, travellerId: t.id } }"
                                    class="adm-actions__btn" title="Edit">
                                    <svg viewBox="0 0 16 16" width="14" height="14" fill="none"
                                        stroke="currentColor" stroke-width="1.6">
                                        <path d="M11 2l3 3-8 8H3v-3l8-8z" />
                                    </svg>
                                </router-link>
                                <button type="button" class="adm-actions__btn adm-actions__btn--danger"
                                    title="Remove" @click="removeTraveller(t)">
                                    <svg viewBox="0 0 16 16" width="14" height="14" fill="none"
                                        stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 4h10M6 4V2h4v2M5 4l1 10h4l1-10"/>
                                    </svg>
                                </button>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, reactive, ref, watch } from 'vue';
import api from '../api';
import FormField from '../components/FormField.vue';
import FormSelect from '../components/FormSelect.vue';
import FormCheckbox from '../components/FormCheckbox.vue';
import PageHeader from '../components/PageHeader.vue';
import { useToastStore } from '../stores/toast';
import { useConfirmStore } from '../stores/confirm';

const props = defineProps({ id: { type: [String, Number], required: true } });
const toast = useToastStore();
const confirm = useConfirmStore();

async function removeTraveller(t) {
    const ok = await confirm.ask({
        title: `Remove ${t.full_name || t.name}?`,
        message: 'They will be detached from this order.',
        confirmLabel: 'Remove', danger: true,
    });
    if (!ok) return;
    try {
        await api.delete(`/orders/${props.id}/travellers/${t.id}`);
        if (order.value?.travellers) {
            order.value.travellers = order.value.travellers.filter((x) => x.id !== t.id);
        }
        toast.success('Applicant removed.');
    } catch (e) {
        toast.error(e.response?.data?.message || 'Could not remove applicant.');
    }
}

const order = ref(null);
const statuses = ref([]);
const loading = ref(true);
const saving = ref(false);
const errors = ref({});

const form = reactive({ status_id: null, is_paid: false, total_price: 0 });

function err(key) {
    const v = errors.value[key];
    return Array.isArray(v) ? v[0] : v || '';
}

function formatDate(iso) {
    return iso ? new Date(iso).toLocaleString() : '';
}

async function load() {
    loading.value = true;
    try {
        const [o, s] = await Promise.all([
            api.get(`/orders/${props.id}`),
            statuses.value.length ? null : api.get('/order-statuses'),
        ]);
        order.value = o.data.data ?? null;
        if (s) statuses.value = s.data.data ?? [];

        if (order.value) {
            form.status_id = order.value.status_id ?? order.value.status?.id ?? null;
            form.is_paid = !!order.value.is_paid;
            form.total_price = order.value.total_price ?? 0;
        }
    } catch (e) {
        order.value = null;
    } finally {
        loading.value = false;
    }
}

async function save() {
    saving.value = true;
    errors.value = {};
    try {
        const { data } = await api.put(`/orders/${props.id}`, form);
        order.value = { ...order.value, ...data.data };
        toast.success('Order updated.');
    } catch (e) {
        if (e.response?.status === 422) errors.value = e.response.data.errors || {};
        else toast.error(e.response?.data?.message || 'Could not save order.');
    } finally {
        saving.value = false;
    }
}

onMounted(load);
watch(() => props.id, load);
</script>
