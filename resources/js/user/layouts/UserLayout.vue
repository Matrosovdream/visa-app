<template>
    <div class="body_wrap">
        <SiteHeader />
        <div class="body-overlay"></div>
        <main>
            <slot />
        </main>
        <SiteFooter />
    </div>
</template>

<script setup>
import SiteHeader from '../components/SiteHeader.vue';
import SiteFooter from '../components/SiteFooter.vue';
</script>
