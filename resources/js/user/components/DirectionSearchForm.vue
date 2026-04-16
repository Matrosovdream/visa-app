<template>
    <section class="hero hero__style-one bg_img"
        :style="{
            backgroundImage: `url(${asset('user/assets/img/hero/homepage-hero.webp')})`,
            minHeight: '600px',
        }">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-10 col-lg-7">
                    <div class="hero__content">
                        <h1 class="fs-1" v-reveal:skew>
                            Get your travel visa for <br> <span>ANY COUNTRY</span>
                        </h1>

                        <div class="p-4 bg-light rounded shadow w-100" v-reveal:up="{ delay: 150 }">
                            <form @submit.prevent="submit">
                                <div class="row g-3">
                                    <div class="col-md-5">
                                        <label class="form-label">Where am I from?</label>
                                        <select v-model="form.from" class="form-control" required>
                                            <option value="" disabled></option>
                                            <option v-for="country in globals.countries" :key="country.id"
                                                :value="country.code">
                                                {{ country.name }} - {{ country.code }}
                                            </option>
                                        </select>
                                        <div v-if="errors.from" class="text-danger small mt-1">{{ errors.from }}</div>
                                    </div>

                                    <div class="col-md-5">
                                        <label class="form-label">Where am I going?</label>
                                        <select v-model="form.to" class="form-control" required>
                                            <option value="" disabled></option>
                                            <option v-for="country in globals.countries" :key="country.id"
                                                :value="country.code">
                                                {{ country.name }} - {{ country.code }}
                                            </option>
                                        </select>
                                        <div v-if="errors.to" class="text-danger small mt-1">{{ errors.to }}</div>
                                    </div>

                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-success w-100"
                                            style="height: 50px;" :disabled="loading">
                                            {{ loading ? 'Searching…' : 'Get started!' }}
                                        </button>
                                    </div>
                                </div>

                                <div v-if="serverError" class="alert alert-warning mt-3 mb-0">
                                    {{ serverError }}
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import api from '../api';
import { useGlobalsStore } from '../stores/globals';

const globals = useGlobalsStore();
const router = useRouter();

const form = reactive({ from: '', to: '' });
const errors = reactive({ from: '', to: '' });
const loading = ref(false);
const serverError = ref('');

const asset = (path) => `/${path.replace(/^\/+/, '')}`;

async function submit() {
    errors.from = form.from ? '' : 'Please select your country of origin';
    errors.to = form.to ? '' : 'Please select your destination country';
    if (errors.from || errors.to) return;

    loading.value = true;
    serverError.value = '';
    try {
        const { data } = await api.get('/directions/search', {
            params: { from: form.from, to: form.to },
        });
        const payload = data?.data;
        const toSlug = payload?.countryTo?.slug ?? payload?.Model?.countryTo?.slug;
        const fromSlug = payload?.countryFrom?.slug ?? payload?.Model?.countryFrom?.slug;
        if (toSlug) {
            // In-SPA navigation — no full page reload.
            router.push({
                name: 'country',
                params: { slug: toSlug },
                query: fromSlug ? { nationality: fromSlug } : {},
            });
        } else {
            serverError.value = 'No visa information found for this route.';
        }
    } catch (err) {
        serverError.value = err.response?.status === 404
            ? 'No visa information found for this route.'
            : 'Something went wrong. Please try again.';
    } finally {
        loading.value = false;
    }
}
</script>
