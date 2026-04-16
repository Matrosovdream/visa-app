<template>
    <router-link v-if="isSpa" :to="to" :class="$attrs.class">
        <slot />
    </router-link>
    <a v-else :href="href" :class="$attrs.class" :target="target" :rel="rel">
        <slot />
    </a>
</template>

<script setup>
import { computed } from 'vue';
import router from '../router';

/**
 * Renders <router-link> if the target resolves to a known SPA route,
 * otherwise falls back to a plain <a> (legacy Blade pages, external URLs).
 */
const props = defineProps({
    href: { type: String, required: true },
    target: { type: String, default: null },
    rel: { type: String, default: null },
});

defineOptions({ inheritAttrs: false });

const isExternal = computed(() => /^(https?:)?\/\//i.test(props.href) || props.href.startsWith('mailto:'));

const to = computed(() => props.href);

const isSpa = computed(() => {
    if (isExternal.value) return false;
    if (!props.href.startsWith('/')) return false;
    try {
        const match = router.resolve(props.href);
        return match.matched.length > 0 && match.name !== 'not-found';
    } catch (e) {
        return false;
    }
});
</script>
