<template>
    <section class="blog pt-30 pb-120">
        <div class="container">
            <div class="row">
                <aside class="col-lg-3 mb-4">
                    <OrderNav :id="id" :travellers="travellers" />
                </aside>

                <div class="col-lg-9">
                    <div class="p-4 p-md-5 bg-light rounded shadow-sm" v-reveal:up>
                        <h2 class="mb-2">{{ $t('Trip details') }}</h2>
                        <p class="text-muted mb-4">
                            {{ $t('Tell us when you\'re traveling so we can schedule your application.') }}
                        </p>

                        <transition name="fade">
                            <div v-if="savedMessage" class="alert alert-success">{{ savedMessage }}</div>
                        </transition>
                        <transition name="fade">
                            <div v-if="generalError" class="alert alert-danger">{{ generalError }}</div>
                        </transition>

                        <form v-if="!loading" @submit.prevent="save">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">{{ $t('Arrival date') }}</label>
                                    <input v-model="form.arrival_date" type="date" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ $t('Departure date') }}</label>
                                    <input v-model="form.departure_date" type="date" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ $t('Contact phone') }}</label>
                                    <input v-model="form.phone" type="tel" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ $t('Contact email') }}</label>
                                    <input v-model="form.email" type="email" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">{{ $t('Purpose of trip') }}</label>
                                    <textarea v-model="form.purpose" rows="3" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-success px-4" :disabled="saving">
                                    <span v-if="saving" class="spinner-border spinner-border-sm me-2"
                                        role="status" aria-hidden="true"></span>
                                    {{ saving ? $t('Saving…') : $t('Save changes') }}
                                </button>
                            </div>
                        </form>

                        <div v-else>
                            <div class="skeleton skeleton-line" style="width: 50%;"></div>
                            <div class="skeleton skeleton-block" style="height: 120px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { onMounted, reactive, ref, watch } from 'vue';
import { useI18n } from 'vue-i18n';
import api from '../api';
import OrderNav from '../components/OrderNav.vue';
import { useOrder } from '../composables/useOrder';

const props = defineProps({ id: { type: [String, Number], required: true } });
const { t } = useI18n();

const { order, travellers, loading, load } = useOrder(props.id);
const saving = ref(false);
const savedMessage = ref('');
const generalError = ref('');

const fields = ['arrival_date', 'departure_date', 'phone', 'email', 'purpose'];
const form = reactive(Object.fromEntries(fields.map((f) => [f, ''])));

function hydrate() {
    const meta = order.value?.Model?.meta || order.value?.meta || [];
    const list = Array.isArray(meta) ? meta : Object.values(meta);
    const map = {};
    list.forEach((m) => { map[m.meta_key ?? m.key] = m.meta_value ?? m.value; });
    fields.forEach((f) => { form[f] = map[f] ?? ''; });
}

async function save() {
    saving.value = true;
    savedMessage.value = '';
    generalError.value = '';
    try {
        await api.put(`/orders/${props.id}/trip`, {
            meta: fields.reduce((acc, f) => { acc[f] = form[f]; return acc; }, {}),
        });
        savedMessage.value = t('Trip details saved.');
    } catch (e) {
        generalError.value = t('Could not save.');
    } finally {
        saving.value = false;
    }
}

onMounted(async () => {
    await load();
    hydrate();
});
watch(() => props.id, async () => {
    await load();
    hydrate();
});
</script>
