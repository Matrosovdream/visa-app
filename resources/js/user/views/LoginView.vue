<template>
    <section class="blog pt-60 pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="p-5 bg-light rounded shadow">
                        <div class="text-center mb-4">
                            <h1 class="fw-bolder mb-2">{{ $t('Sign In') }}</h1>
                            <p class="text-muted mb-0">{{ $t('Welcome back — please enter your details.') }}</p>
                        </div>

                        <transition name="fade">
                            <div v-if="sessionStatus" class="alert alert-success">{{ sessionStatus }}</div>
                        </transition>
                        <transition name="fade">
                            <div v-if="generalError" class="alert alert-danger">{{ generalError }}</div>
                        </transition>

                        <form @submit.prevent="submit" novalidate>
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ $t('Email') }}</label>
                                <input id="email" v-model="form.email" type="email" autocomplete="username" required
                                    class="form-control" :class="{ 'is-invalid': fieldErrors.email }"
                                    @input="clearFieldError('email')">
                                <transition name="fade">
                                    <div v-if="fieldErrors.email" class="invalid-feedback d-block">
                                        {{ fieldErrors.email[0] }}
                                    </div>
                                </transition>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">{{ $t('Password') }}</label>
                                <input id="password" v-model="form.password" type="password" required
                                    autocomplete="current-password"
                                    class="form-control" :class="{ 'is-invalid': fieldErrors.password }"
                                    @input="clearFieldError('password')">
                                <transition name="fade">
                                    <div v-if="fieldErrors.password" class="invalid-feedback d-block">
                                        {{ fieldErrors.password[0] }}
                                    </div>
                                </transition>
                            </div>

                            <div class="d-flex justify-content-end mb-4">
                                <SmartLink href="/forgot-password" class="small text-muted">
                                    {{ $t('Forgot password?') }}
                                </SmartLink>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-success" :disabled="loading">
                                    <span v-if="loading" class="spinner-border spinner-border-sm me-2"
                                        role="status" aria-hidden="true"></span>
                                    {{ loading ? $t('Signing in…') : $t('Log in') }}
                                </button>
                            </div>

                            <div class="text-center text-muted small">
                                {{ $t('Not a member yet?') }}
                                <SmartLink href="/register" class="text-success">{{ $t('Sign up') }}</SmartLink>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useI18n } from 'vue-i18n';
import { useAuthStore } from '../stores/auth';
import SmartLink from '../components/SmartLink.vue';

const auth = useAuthStore();
const router = useRouter();
const route = useRoute();
const { t } = useI18n();

const form = reactive({ email: '', password: '' });
const fieldErrors = ref({});
const generalError = ref('');
const sessionStatus = ref(route.query.status || '');
const loading = ref(false);

function clearFieldError(field) {
    if (fieldErrors.value[field]) {
        const next = { ...fieldErrors.value };
        delete next[field];
        fieldErrors.value = next;
    }
    if (generalError.value) generalError.value = '';
}

async function submit() {
    fieldErrors.value = {};
    generalError.value = '';
    loading.value = true;
    try {
        await auth.login({ email: form.email, password: form.password });
        const redirect = route.query.redirect?.toString() || '/';
        router.push(redirect);
    } catch (err) {
        const res = err.response;
        if (res?.status === 422) {
            fieldErrors.value = res.data.errors || {};
        } else if (res?.status === 401) {
            generalError.value = res.data?.message || t('Invalid credentials.');
        } else {
            generalError.value = t('Something went wrong. Please try again.');
        }
    } finally {
        loading.value = false;
    }
}
</script>
