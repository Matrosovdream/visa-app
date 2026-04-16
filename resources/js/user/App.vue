<template>
    <UserLayout>
        <TopProgress />
        <router-view v-slot="{ Component, route }">
            <transition name="page" mode="out-in">
                <component :is="Component" :key="route.fullPath" />
            </transition>
        </router-view>
    </UserLayout>
</template>

<script setup>
import UserLayout from './layouts/UserLayout.vue';
import TopProgress from './components/TopProgress.vue';
</script>
