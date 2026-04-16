<template>
    <section class="blog pt-60 pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="p-5 bg-light rounded shadow">
                        <div class="text-center mb-4">
                            <h1 class="fw-bolder mb-2">{{ $t('Create your account') }}</h1>
                            <p class="text-muted mb-0">{{ $t('Takes less than a minute.') }}</p>
                        </div>

                        <transition name="fade">
                            <div v-if="generalError" class="alert alert-danger">{{ generalError }}</div>
                        </transition>

                        <form @submit.prevent="submit" novalidate>
                            <div class="mb-3">
                                <label class="form-label">{{ $t('Name') }}</label>
                                <input v-model="form.name" type="text" required class="form-control"
                                    :class="{ 'is-invalid': err('name') }" @input="clear('name')">
                                <transition name="fade">
                                    <div v-if="err('name')" class="invalid-feedback d-block">{{ err('name') }}</div>
                                </transition>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ $t('Email') }}</label>
                                <input v-model="form.email" type="email" required autocomplete="email"
                                    class="form-control" :class="{ 'is-invalid': err('email') }"
                                    @input="clear('email')">
                                <transition name="fade">
                                    <div v-if="err('email')" class="invalid-feedback d-block">{{ err('email') }}</div>
                                </transition>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ $t('Password') }}</label>
                                <input v-model="form.password" type="password" required autocomplete="new-password"
                                    class="form-control" :class="{ 'is-invalid': err('password') }"
                                    @input="clear('password')">
                                <transition name="fade">
                                    <div v-if="err('password')" class="invalid-feedback d-block">{{ err('password') }}</div>
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
                                    {{ loading ? $t('Creating…') : $t('Sign up') }}
                                </button>
                            </div>

                            <div class="text-center text-muted small">
                                {{ $t('Already have an account?') }}
                                <router-link to="/login" class="text-success">{{ $t('Log in') }}</router-link>
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
import { useRouter } from 'vue-router';
import { useI18n } from 'vue-i18n';
import { useAuthStore } from '../stores/auth';

const { t } = useI18n();
const router = useRouter();
const auth = useAuthStore();

const form = reactive({ name: '', email: '', password: '', password_confirmation: '' });
const fieldErrors = ref({});
const generalError = ref('');
const loading = ref(false);

function err(key) {
    const v = fieldErrors.value[key];
    return Array.isArray(v) ? v[0] : v || '';
}
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
    try {
        await auth.register({ ...form });
        router.push('/');
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
</script>
