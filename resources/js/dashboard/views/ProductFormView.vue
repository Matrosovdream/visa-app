<template>
    <div>
        <PageHeader :eyebrow="isEdit ? `Product #${id}` : 'Products'"
            :title="isEdit ? (form.name || 'Edit product') : 'New product'"
            :subtitle="isEdit ? 'Update this visa product.' : 'Create a new visa product.'">
            <template #actions>
                <router-link :to="{ name: 'dashboard.products' }" class="adm-btn adm-btn--ghost">← Back</router-link>
            </template>
        </PageHeader>

        <form class="adm-card" @submit.prevent="submit">
            <div class="adm-grid-2">
                <FormField v-model="form.name" label="Name" required :error="err('name')" />
                <FormField v-model="form.slug" label="Slug"
                    hint="Leave empty to auto-generate from the name." :error="err('slug')" />
            </div>

            <div class="adm-grid-2">
                <FormField v-model="form.price" label="Price (USD)" type="number"
                    step="0.01" min="0" required :error="err('price')" />
                <FormCheckbox v-model="form.published" label="Published" />
            </div>

            <FormTextarea v-model="form.description" label="Short description"
                :rows="3" :error="err('description')" />
            <FormTextarea v-model="form.content" label="Long content / details"
                :rows="8" :error="err('content')" />

            <div class="adm-form-actions">
                <button type="submit" class="adm-btn adm-btn--primary" :disabled="saving">
                    {{ saving ? 'Saving…' : (isEdit ? 'Save changes' : 'Create product') }}
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
    name: '',
    slug: '',
    description: '',
    content: '',
    price: 0,
    published: false,
});

function err(key) {
    const v = errors.value[key];
    return Array.isArray(v) ? v[0] : v || '';
}

async function load() {
    if (!isEdit.value) return;
    try {
        const { data } = await api.get(`/products/${props.id}`);
        const p = data.data ?? {};
        Object.assign(form, {
            name: p.name ?? '',
            slug: p.slug ?? '',
            description: p.description ?? '',
            content: p.content ?? '',
            price: p.price ?? 0,
            published: !!p.published,
        });
    } catch (e) {
        toast.error('Could not load product.');
    }
}

async function submit() {
    saving.value = true;
    errors.value = {};
    try {
        if (isEdit.value) {
            await api.put(`/products/${props.id}`, form);
            toast.success('Product saved.');
        } else {
            const { data } = await api.post('/products', form);
            toast.success('Product created.');
            router.push({ name: 'dashboard.product.edit', params: { id: data.data.id } });
        }
    } catch (e) {
        if (e.response?.status === 422) errors.value = e.response.data.errors || {};
        else toast.error(e.response?.data?.message || 'Could not save product.');
    } finally {
        saving.value = false;
    }
}

onMounted(load);
watch(() => props.id, load);
</script>
