<template>
    <div class="adm-page-header">
        <div class="adm-page-header__text">
            <div v-if="eyebrow" class="adm-page-header__eyebrow">{{ eyebrow }}</div>
            <h1 class="adm-page-header__title">{{ title }}</h1>
            <div v-if="subtitle" class="adm-page-header__subtitle">{{ subtitle }}</div>
        </div>
        <div class="adm-page-header__actions">
            <slot name="actions" />
        </div>
    </div>
</template>

<script setup>
defineProps({
    title: { type: String, required: true },
    subtitle: { type: String, default: '' },
    eyebrow: { type: String, default: '' },
});
</script>
