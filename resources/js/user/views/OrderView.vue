<template>
    <section class="blog pt-30 pb-120">
        <div class="container">
            <div class="row">
                <aside class="col-lg-3 mb-4">
                    <AccountSidebar />
                </aside>

                <div class="col-lg-9">
                    <transition name="fade" mode="out-in">
                        <div v-if="loading" key="skel" class="p-4 p-md-5 bg-light rounded shadow-sm">
                            <div class="skeleton skeleton-line lg" style="width: 40%;"></div>
                            <div class="skeleton skeleton-line" style="width: 70%;"></div>
                            <div class="skeleton skeleton-block" style="height: 140px;"></div>
                        </div>

                        <div v-else-if="error" key="err" class="alert alert-warning">
                            {{ error }}
                            <div class="mt-3">
                                <router-link to="/account/orders" class="btn btn-sm btn-success">
                                    {{ $t('Back to orders') }}
                                </router-link>
                            </div>
                        </div>

                        <div v-else-if="order" key="content" class="p-4 p-md-5 bg-light rounded shadow-sm"
                            v-reveal:up>
                            <div class="d-flex justify-content-between align-items-start mb-4">
                                <div>
                                    <h2 class="mb-1">{{ $t('Order') }} #{{ order.id }}</h2>
                                    <div class="text-muted small">{{ formatDate(order.created_at) }}</div>
                                </div>
                                <span v-if="order.status?.name" class="orders-row__status"
                                    :style="{ background: order.status?.color || '#adb5bd' }">
                                    {{ order.status.name }}
                                </span>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <div class="stat-card">
                                        <div class="stat-card__label">{{ $t('Total') }}</div>
                                        <div class="stat-card__value">{{ formatPrice(order.total_price) }}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="stat-card">
                                        <div class="stat-card__label">{{ $t('Paid') }}</div>
                                        <div class="stat-card__value">
                                            {{ order.is_paid ? $t('Yes') : $t('No') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="stat-card">
                                        <div class="stat-card__label">{{ $t('Hash') }}</div>
                                        <div class="stat-card__value stat-card__value--muted">{{ order.hash }}</div>
                                    </div>
                                </div>
                            </div>

                            <div v-if="travellers.length" class="mb-4">
                                <h5 class="mb-3">{{ $t('Applicants') }}</h5>
                                <ul class="traveller-list">
                                    <li v-for="t in travellers" :key="t.id" class="traveller-row">
                                        <div class="fw-semibold">{{ t.full_name || `${t.name} ${t.lastname}` }}</div>
                                        <div class="small text-muted">
                                            {{ t.passport ? `${$t('Passport')}: ${t.passport}` : '' }}
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div>
                                <router-link to="/account/orders" class="btn btn-outline-success btn-sm">
                                    ← {{ $t('Back to orders') }}
                                </router-link>
                            </div>
                        </div>
                    </transition>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { onMounted, ref, watch } from 'vue';
import { useI18n } from 'vue-i18n';
import api from '../api';
import AccountSidebar from '../components/AccountSidebar.vue';

const props = defineProps({ id: { type: [String, Number], required: true } });
const { t } = useI18n();

const order = ref(null);
const travellers = ref([]);
const loading = ref(true);
const error = ref('');

function formatDate(iso) {
    if (!iso) return '';
    return new Date(iso).toLocaleDateString(undefined, { year: 'numeric', month: 'long', day: 'numeric' });
}

function formatPrice(v) {
    const n = Number(v);
    return Number.isNaN(n) ? '' : n.toFixed(2);
}

async function load(id) {
    loading.value = true;
    error.value = '';
    try {
        const { data } = await api.get(`/orders/${id}`);
        const payload = data.data ?? null;
        const model = payload?.Model ?? payload;
        order.value = payload;
        travellers.value = Array.isArray(model?.travellers) ? model.travellers : (payload?.travellers ?? []);
    } catch (err) {
        error.value = err.response?.status === 404 ? t('Order not found.') : t('Could not load order.');
    } finally {
        loading.value = false;
    }
}

onMounted(() => load(props.id));
watch(() => props.id, (id) => { if (id) load(id); });
</script>

<style>
.stat-card {
    background: #fff;
    border: 1px solid #e6e9ed;
    border-radius: 10px;
    padding: 16px;
    height: 100%;
}
.stat-card__label {
    font-size: 0.8rem;
    color: #6b7886;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.stat-card__value {
    font-size: 1.3rem;
    font-weight: 700;
    margin-top: 4px;
    color: #12b886;
}
.stat-card__value--muted {
    color: #495057;
    font-family: ui-monospace, SFMono-Regular, monospace;
    font-size: 0.85rem;
    word-break: break-all;
}

.traveller-list { list-style: none; padding: 0; margin: 0; }
.traveller-row {
    padding: 12px 14px;
    background: #fff;
    border: 1px solid #e6e9ed;
    border-radius: 10px;
    margin-bottom: 8px;
}
</style>
