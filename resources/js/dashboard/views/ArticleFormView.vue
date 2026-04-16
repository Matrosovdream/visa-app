<template>
    <div>
        <PageHeader :eyebrow="isEdit ? `Article #${id}` : 'Articles'"
            :title="isEdit ? (form.title || 'Edit article') : 'New article'"
            :subtitle="isEdit ? 'Update this article.' : 'Create a new article.'">
            <template #actions>
                <router-link :to="{ name: 'dashboard.articles' }" class="adm-btn adm-btn--ghost">← Back</router-link>
            </template>
        </PageHeader>

        <form class="adm-card" @submit.prevent="submit">
            <div class="adm-grid-2">
                <FormField v-model="form.title" label="Title" required :error="err('title')" />
                <FormField v-model="form.slug" label="Slug"
                    hint="Leave empty to auto-generate from the title." :error="err('slug')" />
            </div>

            <FormTextarea v-model="form.short_description" label="Short description"
                :rows="3" :error="err('short_description')" />
            <FormTextarea v-model="form.content" label="Content"
                :rows="12" :error="err('content')" />

            <FormCheckbox v-model="form.published" label="Published" />

            <div class="adm-form-actions">
                <button type="submit" class="adm-btn adm-btn--primary" :disabled="saving">
                    {{ saving ? 'Saving…' : (isEdit ? 'Save changes' : 'Create article') }}
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { computed, onMounted, reactive, ref, watch } from 'vue';
import { useRouter } from 'vue-router';
import api from '../api';
import FormField from '../components/FormField.vue';
import FormTextarea from '../components/FormTextarea.vue';
import FormCheckbox from '../components/FormCheckbox.vue';
import PageHeader from '../components/PageHeader.vue';
import { useToastStore } from '../stores/toast';

const props = defineProps({ id: { type: [String, Number], default: null } });
const router = useRouter();
const toast = useToastStore();

const isEdit = computed(() => !!props.id);
const saving = ref(false);
const errors = ref({});

const form = reactive({
    title: '',
    slug: '',
    short_description: '',
    content: '',
    published: false,
});

function err(key) {
    const v = errors.value[key];
    return Array.isArray(v) ? v[0] : v || '';
}

async function load() {
    if (!isEdit.value) return;
    try {
        const { data } = await api.get(`/articles/${props.id}`);
        const a = data.data ?? {};
        Object.assign(form, {
            title: a.title ?? '',
            slug: a.slug ?? '',
            short_description: a.short_description ?? '',
            content: a.content ?? '',
            published: !!a.published,
        });
    } catch (e) {
        toast.error('Could not load article.');
    }
}

async function submit() {
    saving.value = true;
    errors.value = {};
    try {
        if (isEdit.value) {
            await api.put(`/articles/${props.id}`, form);
            toast.success('Article saved.');
        } else {
            const { data } = await api.post('/articles', form);
            toast.success('Article created.');
            router.push({ name: 'dashboard.article.edit', params: { id: data.data.id } });
        }
    } catch (e) {
        if (e.response?.status === 422) errors.value = e.response.data.errors || {};
        else toast.error(e.response?.data?.message || 'Could not save article.');
    } finally {
        saving.value = false;
    }
}

onMounted(load);
watch(() => props.id, load);
</script>
