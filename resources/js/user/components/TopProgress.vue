<template>
    <div class="top-progress" :class="{ active: visible }">
        <div class="top-progress__bar" :style="{ width: `${progress}%` }"></div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import api from '../api';

const progress = ref(0);
const visible = ref(false);
let pending = 0;
let timer = null;

function start() {
    pending += 1;
    visible.value = true;
    progress.value = 20;
    clearInterval(timer);
    timer = setInterval(() => {
        if (progress.value < 90) progress.value += Math.max(1, (90 - progress.value) / 10);
    }, 120);
}

function finish() {
    pending = Math.max(0, pending - 1);
    if (pending > 0) return;
    clearInterval(timer);
    progress.value = 100;
    setTimeout(() => {
        visible.value = false;
        progress.value = 0;
    }, 250);
}

const router = useRouter();

router.beforeEach((to, from, next) => {
    if (to.fullPath !== from.fullPath) start();
    next();
});
router.afterEach(() => finish());
router.onError(() => finish());

// Hook into axios for data fetches outside of route changes.
api.interceptors.request.use((config) => {
    start();
    return config;
});
api.interceptors.response.use(
    (res) => { finish(); return res; },
    (err) => { finish(); return Promise.reject(err); }
);

onMounted(() => {
    // Safety: clear on mount in case a previous nav left it stuck.
    finish();
});
</script>

<style>
.top-progress {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    z-index: 9999;
    pointer-events: none;
    opacity: 0;
    transition: opacity 200ms ease;
}
.top-progress.active {
    opacity: 1;
}
.top-progress__bar {
    height: 100%;
    width: 0;
    background: linear-gradient(90deg, #12b886, #20c997);
    box-shadow: 0 0 10px rgba(32, 201, 151, 0.6);
    transition: width 180ms ease;
}
</style>
