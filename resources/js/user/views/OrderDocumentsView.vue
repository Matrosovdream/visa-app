<template>
    <section class="blog pt-30 pb-120">
        <div class="container">
            <div class="row">
                <aside class="col-lg-3 mb-4">
                    <OrderNav :id="id" :travellers="travellers" />
                </aside>

                <div class="col-lg-9">
                    <div class="p-4 p-md-5 bg-light rounded shadow-sm" v-reveal:up>
                        <h2 class="mb-2">{{ $t('Documents') }}</h2>
                        <p class="text-muted mb-4">
                            {{ $t('All documents uploaded across your applicants.') }}
                        </p>

                        <div v-if="loading">
                            <div v-for="n in 3" :key="n" class="skeleton skeleton-line"
                                style="width: 80%;"></div>
                        </div>
                        <div v-else-if="!travellers.length" class="text-muted py-4 text-center">
                            {{ $t('No applicants yet.') }}
                        </div>
                        <div v-else>
                            <div v-for="t in travellers" :key="t.id" class="mb-4">
                                <h5 class="mb-2">
                                    {{ t.full_name || `${t.name || ''} ${t.lastname || ''}` }}
                                </h5>
                                <div v-if="!t.documents?.length" class="text-muted small">
                                    {{ $t('No documents uploaded yet.') }}
                                    <router-link :to="{ name: 'account.order.applicant.documents',
                                        params: { id, applicantId: t.id } }"
                                        class="text-success ms-2">
                                        {{ $t('Add documents →') }}
                                    </router-link>
                                </div>
                                <ul v-else class="list-unstyled">
                                    <li v-for="d in t.documents" :key="d.id"
                                        class="d-flex align-items-center justify-content-between
                                            p-2 bg-white rounded mb-2">
                                        <div>
                                            <div class="fw-semibold">{{ d.filename || `#${d.id}` }}</div>
                                            <div class="text-muted small">{{ d.type || '—' }}</div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { onMounted, watch } from 'vue';
import OrderNav from '../components/OrderNav.vue';
import { useOrder } from '../composables/useOrder';

const props = defineProps({ id: { type: [String, Number], required: true } });

const { order, travellers, loading, load } = useOrder(props.id);

onMounted(load);
watch(() => props.id, load);
</script>
