<template>
    <section class="blog pt-30 pb-120">
        <div class="container">
            <div class="row">
                <aside class="col-lg-3 mb-4">
                    <AccountSidebar />
                </aside>

                <div class="col-lg-9">
                    <div class="p-4 p-md-5 bg-light rounded shadow-sm" v-reveal:up>
                        <h2 class="mb-4">{{ $t('Orders') }}</h2>

                        <transition name="fade" mode="out-in">
                            <div v-if="loading" key="skel">
                                <div v-for="n in 3" :key="n" class="mb-3">
                                    <div class="skeleton skeleton-line lg" style="width: 50%;"></div>
                                    <div class="skeleton skeleton-line" style="width: 30%;"></div>
                                </div>
                            </div>

                            <div v-else-if="error" key="err" class="alert alert-warning">{{ error }}</div>

                            <div v-else-if="!orders.length" key="empty" class="text-muted py-4 text-center">
                                {{ $t('You have no orders yet.') }}
                            </div>

                            <transition-group v-else name="stagger-list" tag="div" key="list" class="orders-list">
                                <router-link v-for="order in orders" :key="order.id"
                                    :to="{ name: 'account.order', params: { id: order.id } }"
                                    class="orders-row">
                                    <div class="orders-row__main">
                                        <div class="orders-row__title">
                                            {{ $t('Order') }} #{{ order.id }}
                                        </div>
                                        <div class="orders-row__meta">
                                            <span>{{ formatDate(order.created_at) }}</span>
                                            <span v-if="order.status?.name" class="orders-row__status"
                                                :style="{ background: order.status?.color || '#adb5bd' }">
                                                {{ order.status.name }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="orders-row__total">
                                        {{ formatPrice(order.total_price) }}
                                    </div>
                                </router-link>
                            </transition-group>
                        </transition>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useI18n } from 'vue-i18n';
import api from '../api';
import AccountSidebar from '../components/AccountSidebar.vue';

const { t } = useI18n();
const orders = ref([]);
const loading = ref(true);
const error = ref('');

function formatDate(iso) {
    if (!iso) return '';
    return new Date(iso).toLocaleDateString(undefined, { year: 'numeric', month: 'long', day: 'numeric' });
}

function formatPrice(v) {
    const n = Number(v);
    if (Number.isNaN(n)) return '';
    return n.toFixed(2);
}

onMounted(async () => {
    try {
        const { data } = await api.get('/orders');
        const payload = data.data;
        orders.value = Array.isArray(payload) ? payload : (payload?.Model ?? []);
    } catch (err) {
        error.value = t('Could not load orders.');
    } finally {
        loading.value = false;
    }
});
</script>

<style>
.orders-list { display: flex; flex-direction: column; gap: 10px; }
.orders-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 18px;
    background: #fff;
    border: 1px solid #e6e9ed;
    border-radius: 10px;
    color: inherit;
    text-decoration: none;
    transition: border-color 160ms ease, box-shadow 160ms ease, transform 160ms ease;
}
.orders-row:hover {
    border-color: #20c997;
    box-shadow: 0 6px 18px rgba(32,201,151,0.1);
    transform: translateY(-1px);
    color: inherit;
}
.orders-row__title { font-weight: 600; }
.orders-row__meta {
    display: flex; gap: 10px; align-items: center;
    margin-top: 4px; color: #6b7886; font-size: 0.88rem;
}
.orders-row__status {
    padding: 2px 10px; border-radius: 999px; color: #fff;
    font-size: 0.75rem; font-weight: 600; letter-spacing: 0.02em;
}
.orders-row__total { font-weight: 700; color: #12b886; font-size: 1.05rem; }
</style>
