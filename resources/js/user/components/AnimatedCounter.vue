<template>
    <span ref="root">{{ display }}</span>
</template>

<script setup>
import { onBeforeUnmount, onMounted, ref } from 'vue';

const props = defineProps({
    target: { type: Number, required: true },
    duration: { type: Number, default: 1800 },
    suffix: { type: String, default: '' },
});

const display = ref(0);
const root = ref(null);
let observer = null;
let rafId = null;
let started = false;

function easeOutCubic(t) {
    return 1 - Math.pow(1 - t, 3);
}

function start() {
    if (started) return;
    started = true;
    const startTime = performance.now();

    const tick = (now) => {
        const elapsed = now - startTime;
        const t = Math.min(elapsed / props.duration, 1);
        display.value = Math.floor(props.target * easeOutCubic(t));
        if (t < 1) {
            rafId = requestAnimationFrame(tick);
        } else {
            display.value = props.target;
        }
    };

    rafId = requestAnimationFrame(tick);
}

onMounted(() => {
    observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    start();
                    observer.disconnect();
                }
            });
        },
        { threshold: 0.4 }
    );
    observer.observe(root.value);
});

onBeforeUnmount(() => {
    observer?.disconnect();
    if (rafId) cancelAnimationFrame(rafId);
});
</script>
