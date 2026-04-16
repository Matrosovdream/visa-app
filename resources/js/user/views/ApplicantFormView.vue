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
                            <h2 class="mb-1">{{ $t(config.label) }}</h2>
                            <p class="text-muted mb-0">{{ $t(config.description) }}</p>
                        </div>

                        <transition name="fade">
                            <div v-if="savedMessage" class="alert alert-success">{{ savedMessage }}</div>
                        </transition>
                        <transition name="fade">
                            <div v-if="generalError" class="alert alert-danger">{{ generalError }}</div>
                        </transition>

                        <form v-if="!loading" @submit.prevent="save">
                            <div class="row g-3">
                                <div v-for="f in config.fields" :key="f.key"
                                    :class="f.wide ? 'col-12' : 'col-md-6'">
                                    <label class="form-label">{{ $t(f.label) }}</label>

                                    <textarea v-if="f.type === 'textarea'" v-model="form[f.key]"
                                        rows="3" class="form-control"></textarea>

                                    <select v-else-if="f.type === 'select'" v-model="form[f.key]"
                                        class="form-control">
                                        <option value="" disabled>— {{ $t('Select') }} —</option>
                                        <option v-for="opt in f.options" :key="opt.value" :value="opt.value">
                                            {{ $t(opt.label) }}
                                        </option>
                                    </select>

                                    <input v-else :type="f.type || 'text'" v-model="form[f.key]"
                                        class="form-control" :placeholder="f.placeholder || ''">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div class="text-muted small">
                                    <span v-if="nextSectionName">
                                        {{ $t('Next:') }}
                                        <router-link :to="{ name: `account.order.applicant.${nextSectionName}`,
                                            params: { id, applicantId } }" class="text-success">
                                            {{ $t(nextSectionLabel) }} →
                                        </router-link>
                                    </span>
                                </div>
                                <button type="submit" class="btn btn-success px-4" :disabled="saving">
                                    <span v-if="saving" class="spinner-border spinner-border-sm me-2"
                                        role="status" aria-hidden="true"></span>
                                    {{ saving ? $t('Saving…') : $t('Save changes') }}
                                </button>
                            </div>
                        </form>

                        <div v-else>
                            <div class="skeleton skeleton-line"></div>
                            <div class="skeleton skeleton-line" style="width: 70%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { computed, onMounted, reactive, ref, watch } from 'vue';
import { useRoute } from 'vue-router';
import { useI18n } from 'vue-i18n';
import api from '../api';
import OrderNav from '../components/OrderNav.vue';
import { useOrder } from '../composables/useOrder';
import { SECTIONS, SECTION_ORDER } from '../applicantSections';

const props = defineProps({
    id: { type: [String, Number], required: true },
    applicantId: { type: [String, Number], required: true },
    section: { type: String, required: true },
});

const route = useRoute();
const { t } = useI18n();

const { order, travellers, loading, load } = useOrder(props.id);
const saving = ref(false);
const savedMessage = ref('');
const generalError = ref('');

const config = computed(() => SECTIONS[props.section] || SECTIONS.personal);
const form = reactive({});

const applicantName = computed(() => {
    const t = travellers.value.find((x) => String(x.id) === String(props.applicantId));
    if (!t) return `#${props.applicantId}`;
    return t.full_name || `${t.name || ''} ${t.lastname || ''}`.trim() || `#${t.id}`;
});

const nextSectionName = computed(() => {
    const i = SECTION_ORDER.indexOf(props.section);
    return i >= 0 && i < SECTION_ORDER.length - 1 ? SECTION_ORDER[i + 1] : null;
});
const nextSectionLabel = computed(() =>
    nextSectionName.value ? SECTIONS[nextSectionName.value].label : ''
);

async function hydrate() {
    // Reset form to empty for each field in the current section's config.
    Object.keys(form).forEach((k) => delete form[k]);
    config.value.fields.forEach((f) => { form[f.key] = ''; });

    // Try to load existing values from the API (returns mapped traveller meta).
    try {
        const { data } = await api.get(
            `/orders/${props.id}/applicants/${props.applicantId}/${props.section}`
        );
        const payload = data.data ?? null;
        const meta = payload?.Model?.meta || payload?.meta || [];
        const list = Array.isArray(meta) ? meta : Object.values(meta);
        const map = {};
        list.forEach((m) => { map[m.meta_key ?? m.key] = m.meta_value ?? m.value; });
        config.value.fields.forEach((f) => { form[f.key] = map[f.key] ?? ''; });
    } catch (e) {
        // fall through with empty form
    }
}

async function save() {
    saving.value = true;
    savedMessage.value = '';
    generalError.value = '';
    try {
        const fields = config.value.fields.reduce((acc, f) => {
            acc[f.key] = form[f.key];
            return acc;
        }, {});
        await api.put(
            `/orders/${props.id}/applicants/${props.applicantId}/${props.section}`,
            { fields }
        );
        savedMessage.value = t('Saved.');
    } catch (e) {
        generalError.value = t('Could not save.');
    } finally {
        saving.value = false;
    }
}

onMounted(async () => {
    await load();
    await hydrate();
});
watch(() => [props.id, props.applicantId, props.section], async () => {
    await load();
    await hydrate();
});
</script>
