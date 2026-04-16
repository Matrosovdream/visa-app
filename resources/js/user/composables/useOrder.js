import { ref } from 'vue';
import api from '../api';

/**
 * Small composable for loading an order (and its travellers) once
 * and sharing it between the account-order sub-pages.
 */
export function useOrder(orderId) {
    const order = ref(null);
    const travellers = ref([]);
    const loading = ref(true);
    const error = ref('');

    async function load() {
        loading.value = true;
        error.value = '';
        try {
            const { data } = await api.get(`/orders/${orderId}`);
            const payload = data.data ?? null;
            const model = payload?.Model ?? payload;
            order.value = payload;
            travellers.value = Array.isArray(model?.travellers)
                ? model.travellers
                : (payload?.travellers ?? []);
        } catch (e) {
            order.value = null;
            error.value = e.response?.status === 404 ? 'Order not found.' : 'Could not load order.';
        } finally {
            loading.value = false;
        }
    }

    return { order, travellers, loading, error, load };
}
