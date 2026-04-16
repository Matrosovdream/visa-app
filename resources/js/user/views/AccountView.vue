<template>
    <section class="blog pt-30 pb-120">
        <div class="container">
            <div class="row">
                <aside class="col-lg-3 mb-4">
                    <AccountSidebar />
                </aside>

                <div class="col-lg-9">
                    <div class="p-4 p-md-5 bg-light rounded shadow-sm" v-reveal:up>
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <h2 class="mb-1">{{ $t('Account') }}</h2>
                                <p class="text-muted mb-0">
                                    {{ $t('Manage your profile and preferences.') }}
                                </p>
                            </div>
                            <div class="text-end">
                                <div class="fw-semibold">{{ auth.user?.name }}</div>
                                <div class="small text-muted">{{ auth.user?.email }}</div>
                            </div>
                        </div>

                        <transition name="fade">
                            <div v-if="successMessage" class="alert alert-success">{{ successMessage }}</div>
                        </transition>
                        <transition name="fade">
                            <div v-if="generalError" class="alert alert-danger">{{ generalError }}</div>
                        </transition>

                        <form @submit.prevent="save" novalidate>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">{{ $t('Name') }}</label>
                                    <input id="name" v-model="form.name" type="text" required
                                        class="form-control" :class="{ 'is-invalid': fieldErrors.name }"
                                        @input="clearError('name')">
                                    <div v-if="fieldErrors.name" class="invalid-feedback d-block">
                                        {{ fieldErrors.name[0] }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">{{ $t('Email') }}</label>
                                    <input id="email" v-model="form.email" type="email" required
                                        class="form-control" :class="{ 'is-invalid': fieldErrors.email }"
                                        @input="clearError('email')">
                                    <div v-if="fieldErrors.email" class="invalid-feedback d-block">
                                        {{ fieldErrors.email[0] }}
                                    </div>
                                </div>

                                <div class="col-12">
                                    <hr class="my-3">
                                    <p class="text-muted small mb-3">
                                        {{ $t('Leave password fields empty to keep the current password.') }}
                                    </p>
                                </div>

                                <div class="col-md-6">
                                    <label for="password" class="form-label">{{ $t('Password') }}</label>
                                    <input id="password" v-model="form.password" type="password"
                                        autocomplete="new-password"
                                        class="form-control" :class="{ 'is-invalid': fieldErrors.password }">
                                    <div v-if="fieldErrors.password" class="invalid-feedback d-block">
                                        {{ fieldErrors.password[0] }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label">
                                        {{ $t('Confirm Password') }}
                                    </label>
                                    <input id="password_confirmation" v-model="form.password_confirmation"
                                        type="password" autocomplete="new-password" class="form-control">
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
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { onMounted, reactive, ref } from 'vue';
import { useI18n } from 'vue-i18n';
import api from '../api';
import { useAuthStore } from '../stores/auth';
import AccountSidebar from '../components/AccountSidebar.vue';

const auth = useAuthStore();
const { t } = useI18n();

const form = reactive({ name: '', email: '', password: '', password_confirmation: '' });
const fieldErrors = ref({});
const generalError = ref('');
const successMessage = ref('');
const saving = ref(false);

function clearError(field) {
    if (fieldErrors.value[field]) {
        const next = { ...fieldErrors.value };
        delete next[field];
        fieldErrors.value = next;
    }
    if (generalError.value) generalError.value = '';
}

async function load() {
    try {
        const { data } = await api.get('/account');
        const user = data.data ?? data;
        form.name = user.name ?? '';
        form.email = user.email ?? '';
    } catch (err) {
        generalError.value = t('Could not load account.');
    }
}

async function save() {
    saving.value = true;
    fieldErrors.value = {};
    generalError.value = '';
    successMessage.value = '';
    try {
        const payload = { name: form.name, email: form.email };
        if (form.password) {
            payload.password = form.password;
            payload.password_confirmation = form.password_confirmation;
        }
        const { data } = await api.put('/account/settings', payload);
        auth.user = data.data ?? auth.user;
        localStorage.setItem('auth_user', JSON.stringify(auth.user));
        successMessage.value = t('Your account has been updated.');
        form.password = '';
        form.password_confirmation = '';
    } catch (err) {
        const res = err.response;
        if (res?.status === 422) {
            fieldErrors.value = res.data.errors || {};
        } else {
            generalError.value = t('Something went wrong. Please try again.');
        }
    } finally {
        saving.value = false;
    }
}

onMounted(load);
</script>
