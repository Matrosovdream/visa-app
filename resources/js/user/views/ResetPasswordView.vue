<template>
    <section class="blog pt-60 pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="p-5 bg-light rounded shadow">
                        <div class="text-center mb-4">
                            <h1 class="fw-bolder mb-2">{{ $t('Reset password') }}</h1>
                            <p class="text-muted mb-0">{{ $t('Choose a new password for your account.') }}</p>
                        </div>

                        <transition name="fade">
                            <div v-if="successMessage" class="alert alert-success">{{ successMessage }}</div>
                        </transition>
                        <transition name="fade">
                            <div v-if="generalError" class="alert alert-danger">{{ generalError }}</div>
                        </transition>

                        <form @submit.prevent="submit" novalidate>
                            <div class="mb-3">
                                <label class="form-label">{{ $t('Email') }}</label>
                                <input v-model="form.email" type="email" required autocomplete="email"
                                    class="form-control" :class="{ 'is-invalid': fieldErrors.email }"
                                    @input="clear('email')">
                                <transition name="fade">
                                    <div v-if="fieldErrors.email" class="invalid-feedback d-block">
                                        {{ fieldErrors.email[0] }}
                                    </div>
                                </transition>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ $t('New Password') }}</label>
                                <input v-model="form.password" type="password" required
                                    autocomplete="new-password" class="form-control"
                                    :class="{ 'is-invalid': fieldErrors.password }"
                                    @input="clear('password')">
                                <transition name="fade">
                                    <div v-if="fieldErrors.password" class="invalid-feedback d-block">
                                        {{ fieldErrors.password[0] }}
                                    </div>
                                </transition>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">{{ $t('Confirm Password') }}</label>
                                <input v-model="form.password_confirmation" type="password" required
                                    autocomplete="new-password" class="form-control">
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-success" :disabled="loading">
                                    <span v-if="loading" class="spinner-border spinner-border-sm me-2"
                                        role="status" aria-hidden="true"></span>
                                    {{ loading ? $t('Saving…') : $t('Reset password') }}
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
import { useRoute, useRouter } from 'vue-router';
import { useI18n } from 'vue-i18n';
import api from '../api';

const { t } = useI18n();
const route = useRoute();
const router = useRouter();

const form = reactive({
    token: '',
    email: '',
    password: '',
    password_confirmation: '',
});
const fieldErrors = ref({});
const generalError = ref('');
const successMessage = ref('');
const loading = ref(false);

function clear(key) {
    if (fieldErrors.value[key]) {
        const next = { ...fieldErrors.value };
        delete next[key];
        fieldErrors.value = next;
    }
    if (generalError.value) generalError.value = '';
}

async function submit() {
    loading.value = true;
    fieldErrors.value = {};
    generalError.value = '';
    successMessage.value = '';
    try {
        const { data } = await api.post('/auth/reset-password', { ...form });
        successMessage.value = data.message || t('Password reset.');
        setTimeout(() => router.push({ name: 'login', query: { status: successMessage.value } }), 1500);
    } catch (e) {
        const res = e.response;
        if (res?.status === 422) {
            fieldErrors.value = res.data.errors || {};
        } else {
            generalError.value = t('Something went wrong. Please try again.');
        }
    } finally {
        loading.value = false;
    }
}

onMounted(() => {
    form.token = route.params.token || '';
    form.email = route.query.email?.toString() || '';
});
</script>
