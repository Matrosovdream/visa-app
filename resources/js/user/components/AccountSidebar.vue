<template>
    <nav class="account-sidebar">
        <router-link v-for="link in links" :key="link.to" :to="link.to"
            class="account-sidebar__item"
            active-class="account-sidebar__item--active"
            exact-active-class="account-sidebar__item--active">
            {{ $t(link.label) }}
        </router-link>
        <a href="#" class="account-sidebar__item" @click.prevent="handleLogout">
            {{ $t('Log out') }}
        </a>
    </nav>
</template>

<script setup>
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';

const router = useRouter();
const auth = useAuthStore();

const links = [
    { to: '/account', label: 'Account' },
    { to: '/account/orders', label: 'Orders' },
];

async function handleLogout() {
    await auth.logout();
    router.push({ name: 'home' });
}
</script>

<style>
.account-sidebar {
    display: flex;
    flex-direction: column;
    background: #ffffff;
    border: 1px solid #e6e9ed;
    border-radius: 10px;
    padding: 8px;
}
.account-sidebar__item {
    padding: 10px 14px;
    border-radius: 8px;
    color: #495057;
    text-decoration: none;
    font-weight: 500;
    transition: background 140ms ease, color 140ms ease;
}
.account-sidebar__item:hover {
    background: rgba(32, 201, 151, 0.08);
    color: #0a7a57;
}
.account-sidebar__item--active {
    background: rgba(32, 201, 151, 0.15);
    color: #0a7a57;
    font-weight: 600;
}
</style>
