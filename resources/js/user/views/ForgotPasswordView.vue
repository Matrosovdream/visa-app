<template>
    <section class="blog pt-60 pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="p-5 bg-light rounded shadow">
                        <div class="text-center mb-4">
                            <h1 class="fw-bolder mb-2">{{ $t('Forgot password?') }}</h1>
                            <p class="text-muted mb-0">
                                {{ $t('Enter your email and we\'ll send you a reset link.') }}
                            </p>
                        </div>

                        <transition name="fade">
                            <div v-if="successMessage" class="alert alert-success">{{ successMessage }}</div>
                        </transition>
                        <transition name="fade">
                            <div v-if="generalError" class="alert alert-danger">{{ generalError }}</div>
                        </transition>

                        <form @submit.prevent="submit" novalidate>
                            <div class="mb-4">
                                <label class="form-label">{{ $t('Email') }}</label>
                                <input v-model="email" type="email" required autocomplete="email"
                                    class="form-control" :class="{ 'is-invalid': err }"
                                    @input="err = ''">
                                <transition name="fade">
                                    <div v-if="err" class="invalid-feedback d-block">{{ err }}</div>
                                </transition>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-success" :disabled="loading">
                                    <span v-if="loading" class="spinner-border spinner-border-sm me-2"
                                        role="status" aria-hidden="true"></span>
                                    {{ loading ? $t('Sending…') : $t('Send reset link') }}
                                </button>
                            </div>

                            <div class="text-center text-muted small">
                                <router-link to="/login" class="text-success">← {{ $t('Back to login') }}</router-link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';
import api from '../api';

const { t } = useI18n();

const email = ref('');
const err = ref('');
const generalError = ref('');
const successMessage = ref('');
const loading = ref(false);

async function submit() {
    loading.value = true;
    err.value = '';
    generalError.value = '';
    successMessage.value = '';
    try {
        const { data } = await api.post('/auth/forgot-password', { email: email.value });
        successMessage.value = data.message || t('Reset link sent if the account exists.');
        email.value = '';
    } catch (e) {
        const res = e.response;
        if (res?.status === 422) {
            err.value = (res.data.errors?.email?.[0]) || t('Invalid email.');
        } else {
            generalError.value = t('Something went wrong. Please try again.');
        }
    } finally {
        loading.value = false;
    }
}
</script>
