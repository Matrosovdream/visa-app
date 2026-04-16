<template>
    <div>
        <PageHeader :eyebrow="`Order #${id}`"
            :title="isEdit ? 'Edit applicant' : 'New applicant'">
            <template #actions>
                <router-link :to="{ name: 'dashboard.order.show', params: { id } }" class="adm-btn adm-btn--ghost">
                    ← Back to order
                </router-link>
            </template>
        </PageHeader>

        <form class="adm-card" @submit.prevent="submit">
            <div class="adm-grid-2">
                <FormField v-model="form.name" label="First name" required :error="err('name')" />
                <FormField v-model="form.lastname" label="Last name" required :error="err('lastname')" />
            </div>
            <div class="adm-grid-2">
                <FormField v-model="form.birthday" label="Birthday" type="date" :error="err('birthday')" />
                <FormField v-model="form.passport" label="Passport number" :error="err('passport')" />
            </div>

            <div class="adm-form-actions">
                <button type="submit" class="adm-btn adm-btn--primary" :disabled="saving">
                    {{ saving ? 'Saving…' : (isEdit ? 'Save changes' : 'Add applicant') }}
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { computed, onMounted, reactive, ref, watch } from 'vue';
import { useRouter } from 'vue-router';
import api from '../api';
import PageHeader from '../components/PageHeader.vue';
import FormField from '../components/FormField.vue';
import { useToastStore } from '../stores/toast';

const props = defineProps({
    id: { type: [String, Number], required: true },
    travellerId: { type: [String, Number], default: null },
});

const router = useRouter();
const toast = useToastStore();

const isEdit = computed(() => !!props.travellerId);
const saving = ref(false);
const errors = ref({});

const form = reactive({ name: '', lastname: '', birthday: '', passport: '' });

function err(key) {
    const v = errors.value[key];
    return Array.isArray(v) ? v[0] : v || '';
}

async function load() {
    if (!isEdit.value) return;
    try {
        const { data } = await api.get(`/orders/${props.id}/travellers/${props.travellerId}`);
        const t = data.data ?? {};
        Object.assign(form, {
            name: t.name ?? '', lastname: t.lastname ?? '',
            birthday: t.birthday ?? '', passport: t.passport ?? '',
        });
    } catch (e) {
        toast.error('Could not load applicant.');
    }
}

async function submit() {
    saving.value = true;
    errors.value = {};
    try {
        if (isEdit.value) {
            await api.put(`/orders/${props.id}/travellers/${props.travellerId}`, form);
            toast.success('Applicant saved.');
        } else {
            await api.post(`/orders/${props.id}/travellers`, form);
            toast.success('Applicant added.');
        }
        router.push({ name: 'dashboard.order.show', params: { id: props.id } });
    } catch (e) {
        if (e.response?.status === 422) errors.value = e.response.data.errors || {};
        else toast.error(e.response?.data?.message || 'Could not save applicant.');
    } finally {
        saving.value = false;
    }
}

onMounted(load);
watch(() => [props.id, props.travellerId], load);
</script>
