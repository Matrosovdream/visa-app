<template>
    <router-view v-slot="{ Component, route }">
        <transition name="adm-fade" mode="out-in">
            <component :is="Component" :key="route.fullPath" />
        </transition>
    </router-view>

    <ToastHost />
    <ConfirmDialog />
</template>

<script setup>
import ToastHost from './components/ToastHost.vue';
import ConfirmDialog from './components/ConfirmDialog.vue';
</script>
