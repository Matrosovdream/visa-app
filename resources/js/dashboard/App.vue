<template>
    <router-view v-slot="{ Component, route }">
        <transition name="adm-fade" mode="out-in">
            <component :is="Component" :key="route.fullPath" />
        </transition>
    </router-view>
</template>
