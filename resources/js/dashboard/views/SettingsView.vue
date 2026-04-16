<template>
    <div>
        <PageHeader title="Site settings" subtitle="Key/value pairs used across the public site." />

        <form class="adm-card" @submit.prevent="save">
            <div v-if="loading">
                <div v-for="n in 4" :key="n" class="adm-skel adm-skel-line" style="width: 60%;"></div>
            </div>

            <div v-else-if="!keys.length" class="adm-empty">
                No settings yet. Add the first one below.
            </div>

            <div v-else>
                <div v-for="key in keys" :key="key" class="adm-grid-2" style="margin-bottom: 8px;">
                    <div>
                        <label class="adm-field__label">{{ key }}</label>
                        <div class="adm-text-soft" style="font-size: 0.75rem;">
                            <code>{{ key }}</code>
                        </div>
                    </div>
                    <FormField v-model="draft[key]" :error="err(`settings.${key}`)" />
                </div>
            </div>

            <!-- Add new key/value pair -->
            <div class="adm-grid-2" style="margin-top: 20px;
                padding-top: 16px; border-top: 1px dashed var(--adm-border);">
                <FormField v-model="newKey" label="New key (optional)"
                    placeholder="e.g. support_email" />
                <FormField v-model="newValue" label="Value" placeholder="" />
            </div>
            <div v-if="newKey && newValue" style="text-align: right;">
                <button type="button" class="adm-btn" @click="addKey">+ Add to list</button>
            </div>

            <div class="adm-form-actions">
                <button type="submit" class="adm-btn adm-btn--primary" :disabled="saving">
                    {{ saving ? 'Saving…' : 'Save settings' }}
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { computed, onMounted, reactive, ref } from 'vue';
import api from '../api';
import FormField from '../components/FormField.vue';
import PageHeader from '../components/PageHeader.vue';
import { useToastStore } from '../stores/toast';

const toast = useToastStore();

const draft = reactive({});
const loading = ref(true);
const saving = ref(false);
const errors = ref({});
const newKey = ref('');
const newValue = ref('');

const keys = computed(() => Object.keys(draft));

function err(path) {
    const v = errors.value[path];
    return Array.isArray(v) ? v[0] : v || '';
}

async function load() {
    try {
        const { data } = await api.get('/settings');
        const src = data.data ?? {};
        Object.keys(draft).forEach((k) => delete draft[k]);
        Object.entries(src).forEach(([k, v]) => { draft[k] = v ?? ''; });
    } catch (e) {
        toast.error('Could not load settings.');
    } finally {
        loading.value = false;
    }
}

function addKey() {
    const k = newKey.value.trim();
    if (!k) return;
    draft[k] = newValue.value;
    newKey.value = '';
    newValue.value = '';
}

async function save() {
    saving.value = true;
    errors.value = {};
    try {
        await api.put('/settings', { settings: { ...draft } });
        toast.success('Settings updated.');
    } catch (e) {
        if (e.response?.status === 422) errors.value = e.response.data.errors || {};
        else toast.error(e.response?.data?.message || 'Could not save settings.');
    } finally {
        saving.value = false;
    }
}

onMounted(load);
</script>
