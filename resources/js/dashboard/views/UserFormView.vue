<template>
    <div>
        <PageHeader :eyebrow="isEdit ? `User #${id}` : 'Users'"
            :title="isEdit ? (user.name || 'Edit user') : 'New user'"
            :subtitle="isEdit ? user.email : 'Create a new user account.'">
            <template #actions>
                <router-link :to="{ name: 'dashboard.users' }" class="adm-btn adm-btn--ghost">
                    ← Back
                </router-link>
            </template>
        </PageHeader>

        <div class="adm-tabs" v-if="isEdit">
            <button type="button" class="adm-tabs__item"
                :class="{ 'adm-tabs__item--active': tab === 'general' }"
                @click="tab = 'general'">General</button>
            <button type="button" class="adm-tabs__item"
                :class="{ 'adm-tabs__item--active': tab === 'password' }"
                @click="tab = 'password'">Password</button>
            <button type="button" class="adm-tabs__item"
                :class="{ 'adm-tabs__item--active': tab === 'pin' }"
                @click="tab = 'pin'">PIN</button>
        </div>

        <!-- General -->
        <form v-if="!isEdit || tab === 'general'" class="adm-card" @submit.prevent="submitGeneral">
            <h3 class="adm-card__title">Profile</h3>

            <div class="adm-grid-2">
                <FormField v-model="form.name" label="Name" required :error="err('name')" />
                <FormField v-model="form.email" label="Email" type="email" required :error="err('email')" />
            </div>

            <div class="adm-grid-2">
                <FormSelect v-model="form.role_id" label="Role" required numeric
                    :options="roles" value-key="id" label-key="title"
                    placeholder="Choose a role"
                    :error="err('role_id')" />
                <FormCheckbox v-model="form.is_active" label="Account active" />
            </div>

            <div v-if="!isEdit">
                <FormField v-model="form.password" label="Password" type="password" required
                    hint="At least 6 characters." :error="err('password')" />
                <FormField v-model="form.pin" label="PIN (optional)" type="password"
                    hint="Staff PIN for the PIN login tab." :error="err('pin')" />
            </div>

            <div class="adm-form-actions">
                <button type="submit" class="adm-btn adm-btn--primary" :disabled="saving">
                    {{ saving ? 'Saving…' : (isEdit ? 'Save changes' : 'Create user') }}
                </button>
            </div>
        </form>

        <!-- Password -->
        <form v-if="isEdit && tab === 'password'" class="adm-card" @submit.prevent="submitPassword">
            <h3 class="adm-card__title">Change password</h3>
            <FormField v-model="pwd.password" label="New password" type="password" required
                hint="At least 6 characters." :error="err('password')" />
            <div class="adm-form-actions">
                <button type="submit" class="adm-btn adm-btn--primary" :disabled="saving">
                    {{ saving ? 'Saving…' : 'Update password' }}
                </button>
            </div>
        </form>

        <!-- PIN -->
        <form v-if="isEdit && tab === 'pin'" class="adm-card" @submit.prevent="submitPin">
            <h3 class="adm-card__title">Staff PIN</h3>
            <p class="adm-text-muted" style="margin: -4px 0 16px; font-size: 0.88rem;">
                Status: <strong>{{ user.has_pin ? 'PIN is currently set' : 'No PIN on file' }}</strong>
            </p>
            <FormField v-model="pinVal.pin" label="New PIN" type="password"
                hint="3–20 characters. Leave empty and click Remove to clear."
                :error="err('pin')" />
            <div class="adm-form-actions">
                <button v-if="user.has_pin" type="button" class="adm-btn adm-btn--danger"
                    :disabled="saving" @click="removePin">
                    Remove PIN
                </button>
                <button type="submit" class="adm-btn adm-btn--primary"
                    :disabled="saving || !pinVal.pin">
                    {{ saving ? 'Saving…' : 'Save PIN' }}
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
import FormSelect from '../components/FormSelect.vue';
import FormCheckbox from '../components/FormCheckbox.vue';
import PageHeader from '../components/PageHeader.vue';
import { useToastStore } from '../stores/toast';

const props = defineProps({ id: { type: [String, Number], default: null } });
const router = useRouter();
const toast = useToastStore();

const isEdit = computed(() => !!props.id);
const tab = ref('general');
const saving = ref(false);
const errors = ref({});
const roles = ref([]);
const user = reactive({ name: '', email: '', has_pin: false });

const form = reactive({
    name: '',
    email: '',
    role_id: null,
    is_active: true,
    password: '',
    pin: '',
});
const pwd = reactive({ password: '' });
const pinVal = reactive({ pin: '' });

function err(key) {
    const v = errors.value[key];
    return Array.isArray(v) ? v[0] : v || '';
}

async function loadRoles() {
    try {
        const { data } = await api.get('/roles');
        roles.value = data.data ?? [];
    } catch (e) {
        toast.error('Could not load roles.');
    }
}

async function loadUser() {
    if (!isEdit.value) return;
    try {
        const { data } = await api.get(`/users/${props.id}`);
        const u = data.data ?? {};
        Object.assign(user, {
            name: u.name, email: u.email, has_pin: !!u.has_pin,
        });
        form.name = u.name ?? '';
        form.email = u.email ?? '';
        form.role_id = u.role_id ?? null;
        form.is_active = u.is_active ?? true;
    } catch (e) {
        toast.error('Could not load user.');
    }
}

async function submitGeneral() {
    saving.value = true;
    errors.value = {};
    try {
        if (isEdit.value) {
            const payload = {
                name: form.name, email: form.email,
                role_id: form.role_id, is_active: form.is_active,
            };
            const { data } = await api.put(`/users/${props.id}`, payload);
            Object.assign(user, { name: data.data?.name, email: data.data?.email });
            toast.success('User saved.');
        } else {
            const payload = { ...form };
            if (!payload.pin) delete payload.pin;
            const { data } = await api.post('/users', payload);
            toast.success('User created.');
            router.push({ name: 'dashboard.user.edit', params: { id: data.data.id } });
        }
    } catch (e) {
        handleErr(e, 'Could not save user.');
    } finally {
        saving.value = false;
    }
}

async function submitPassword() {
    saving.value = true;
    errors.value = {};
    try {
        await api.put(`/users/${props.id}/password`, pwd);
        pwd.password = '';
        toast.success('Password updated.');
    } catch (e) {
        handleErr(e, 'Could not update password.');
    } finally {
        saving.value = false;
    }
}

async function submitPin() {
    saving.value = true;
    errors.value = {};
    try {
        await api.put(`/users/${props.id}/pin`, { pin: pinVal.pin });
        pinVal.pin = '';
        user.has_pin = true;
        toast.success('PIN updated.');
    } catch (e) {
        handleErr(e, 'Could not update PIN.');
    } finally {
        saving.value = false;
    }
}

async function removePin() {
    saving.value = true;
    try {
        await api.put(`/users/${props.id}/pin`, { pin: '' });
        user.has_pin = false;
        pinVal.pin = '';
        toast.success('PIN removed.');
    } catch (e) {
        toast.error(e.response?.data?.message || 'Could not remove PIN.');
    } finally {
        saving.value = false;
    }
}

function handleErr(e, fallback) {
    if (e.response?.status === 422) {
        errors.value = e.response.data.errors || {};
    } else {
        toast.error(e.response?.data?.message || fallback);
    }
}

onMounted(async () => {
    await Promise.all([loadRoles(), loadUser()]);
});
watch(() => props.id, loadUser);
</script>
