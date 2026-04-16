<template>
    <section class="blog pt-30 pb-120">
        <div class="container">
            <div class="row">
                <aside class="col-lg-3 mb-4">
                    <OrderNav :id="id" :travellers="travellers" />
                </aside>

                <div class="col-lg-9">
                    <div class="p-4 p-md-5 bg-light rounded shadow-sm" v-reveal:up>
                        <div class="mb-4">
                            <div class="text-muted small">
                                {{ $t('Applicant') }}: <strong>{{ applicantName }}</strong>
                            </div>
                            <h2 class="mb-1">{{ $t('Documents') }}</h2>
                            <p class="text-muted mb-0">
                                {{ $t('Upload the documents required for this applicant.') }}
                            </p>
                        </div>

                        <transition name="fade">
                            <div v-if="message" class="alert alert-success">{{ message }}</div>
                        </transition>
                        <transition name="fade">
                            <div v-if="generalError" class="alert alert-danger">{{ generalError }}</div>
                        </transition>

                        <div v-if="loading">
                            <div v-for="n in 3" :key="n" class="skeleton skeleton-line"></div>
                        </div>

                        <div v-else>
                            <transition-group name="stagger-list" tag="ul" class="list-unstyled">
                                <li v-for="doc in documents" :key="doc.id"
                                    class="d-flex justify-content-between align-items-center
                                        p-3 mb-2 bg-white rounded border">
                                    <div>
                                        <div class="fw-semibold">{{ doc.filename || `Document #${doc.id}` }}</div>
                                        <div class="small text-muted">
                                            {{ doc.type || $t('Document') }}
                                            <span v-if="doc.created_at"> · {{ formatDate(doc.created_at) }}</span>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                        @click="deleteDoc(doc)">
                                        {{ $t('Delete') }}
                                    </button>
                                </li>
                            </transition-group>

                            <div v-if="!documents.length" class="text-muted py-4 text-center">
                                {{ $t('No documents uploaded yet.') }}
                            </div>

                            <div class="mt-4 pt-3 border-top">
                                <p class="small text-muted">
                                    {{ $t('Upload support is coming soon. Documents will be verified by your account manager.') }}
                                </p>
                                <button type="button" class="btn btn-outline-success" disabled>
                                    + {{ $t('Upload document') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { computed, onMounted, ref, watch } from 'vue';
import { useI18n } from 'vue-i18n';
import api from '../api';
import OrderNav from '../components/OrderNav.vue';
import { useOrder } from '../composables/useOrder';

const props = defineProps({
    id: { type: [String, Number], required: true },
    applicantId: { type: [String, Number], required: true },
});

const { t } = useI18n();
const { travellers, load } = useOrder(props.id);

const documents = ref([]);
const loading = ref(true);
const message = ref('');
const generalError = ref('');

const applicantName = computed(() => {
    const a = travellers.value.find((x) => String(x.id) === String(props.applicantId));
    if (!a) return `#${props.applicantId}`;
    return a.full_name || `${a.name || ''} ${a.lastname || ''}`.trim() || `#${a.id}`;
});

function formatDate(iso) {
    return iso ? new Date(iso).toLocaleDateString() : '';
}

async function loadDocuments() {
    loading.value = true;
    try {
        const { data } = await api.get(
            `/orders/${props.id}/applicants/${props.applicantId}/documents`
        );
        const payload = data.data ?? null;
        const model = payload?.Model ?? payload;
        documents.value = Array.isArray(model?.documents) ? model.documents : [];
    } catch (e) {
        documents.value = [];
    } finally {
        loading.value = false;
    }
}

async function deleteDoc(doc) {
    if (!confirm(t('Delete this document?'))) return;
    try {
        await api.delete(
            `/orders/${props.id}/applicants/${props.applicantId}/documents/${doc.id}`
        );
        documents.value = documents.value.filter((d) => d.id !== doc.id);
        message.value = t('Document deleted.');
    } catch (e) {
        generalError.value = t('Could not delete document.');
    }
}

onMounted(async () => {
    await load();
    await loadDocuments();
});
watch(() => [props.id, props.applicantId], async () => {
    await load();
    await loadDocuments();
});
</script>
