<template>
    <section class="blog pt-60 pb-120">
        <div class="container">
            <transition name="fade" mode="out-in">
                <div v-if="loading" key="skel" class="row">
                    <div class="col-lg-8">
                        <div class="skeleton skeleton-line lg" style="width: 50%;"></div>
                        <div class="skeleton skeleton-block" style="height: 100px;"></div>
                        <div class="skeleton skeleton-line" style="width: 70%;"></div>
                    </div>
                </div>

                <div v-else-if="error" key="err" class="alert alert-warning">
                    {{ error }}
                    <div class="mt-3">
                        <router-link to="/" class="btn btn-sm btn-success">{{ $t('Back to homepage') }}</router-link>
                    </div>
                </div>

                <div v-else-if="order" key="content" class="row" v-reveal:up>
                    <div class="col-lg-8">
                        <div class="p-4 p-md-5 bg-light rounded shadow-sm">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <h2 class="mb-1">{{ $t('Order') }} #{{ order.id }}</h2>
                                    <div class="text-muted small">{{ formatDate(order.created_at) }}</div>
                                </div>
                                <span v-if="order.status?.name" class="badge text-bg-light"
                                    :style="order.status.color
                                        ? { background: order.status.color + ' !important', color: '#fff' }
                                        : null">
                                    {{ order.status.name }}
                                </span>
                            </div>

                            <dl class="row">
                                <dt class="col-sm-4 text-muted">{{ $t('Hash') }}</dt>
                                <dd class="col-sm-8" style="font-family: ui-monospace, monospace; font-size: 0.86rem;">
                                    {{ order.hash }}
                                </dd>
                                <dt class="col-sm-4 text-muted">{{ $t('Total') }}</dt>
                                <dd class="col-sm-8"><strong>{{ formatPrice(order.total_price) }}</strong></dd>
                                <dt class="col-sm-4 text-muted">{{ $t('Paid') }}</dt>
                                <dd class="col-sm-8">
                                    <span class="badge" :class="order.is_paid ? 'text-bg-success' : 'text-bg-warning'">
                                        {{ order.is_paid ? $t('Yes') : $t('No') }}
                                    </span>
                                </dd>
                            </dl>

                            <div v-if="order.travellers?.length" class="mt-4">
                                <h5 class="mb-3">{{ $t('Applicants') }}</h5>
                                <ul class="list-unstyled">
                                    <li v-for="t in order.travellers" :key="t.id" class="mb-2">
                                        <div class="fw-semibold">{{ t.full_name || `${t.name} ${t.lastname}` }}</div>
                                        <div class="text-muted small" v-if="t.passport">
                                            {{ $t('Passport') }}: {{ t.passport }}
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="mt-4 pt-3 border-top" v-if="!order.is_paid">
                                <router-link v-if="auth.isAuthenticated"
                                    :to="{ name: 'account.order', params: { id: order.id } }"
                                    class="btn btn-success">
                                    {{ $t('Manage this order') }}
                                </router-link>
                                <router-link v-else to="/login" class="btn btn-outline-success">
                                    {{ $t('Log in to manage') }}
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </section>
</template>

<script setup>
import { onMounted, ref, watch } from 'vue';
import { useRoute } from 'vue-router';
import { useI18n } from 'vue-i18n';
import api from '../api';
import { useAuthStore } from '../stores/auth';

const { t } = useI18n();
const route = useRoute();
const auth = useAuthStore();

const order = ref(null);
const loading = ref(true);
const error = ref('');

function formatDate(iso) {
    return iso ? new Date(iso).toLocaleDateString(undefined, { year: 'numeric', month: 'long', day: 'numeric' }) : '';
}
function formatPrice(v) {
    const n = Number(v);
    return Number.isNaN(n) ? '' : n.toFixed(2);
}

async function load(hash) {
    loading.value = true;
    error.value = '';
    try {
        const { data } = await api.get(`/orders/preview/${hash}`);
        const payload = data.data ?? null;
        const model = payload?.Model ?? payload;
        order.value = { ...payload, travellers: model?.travellers || payload?.travellers || [] };
    } catch (e) {
        error.value = e.response?.status === 404
            ? t('Order not found.')
            : t('Could not load order.');
    } finally {
        loading.value = false;
    }
}

onMounted(() => load(route.params.hash));
watch(() => route.params.hash, (h) => { if (h) load(h); });
</script>
