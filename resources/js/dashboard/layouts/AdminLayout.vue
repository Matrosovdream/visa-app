<template>
    <div class="adm-shell">
        <aside class="adm-sidebar" :class="{ 'adm-sidebar--open': sidebarOpen }">
            <div class="adm-sidebar__brand">
                <span class="adm-sidebar__brand-mark">V</span>
                <span>Visa Admin</span>
            </div>
            <nav class="adm-sidebar__nav">
                <div class="adm-sidebar__section">Overview</div>
                <router-link v-for="item in topNav" :key="item.name" :to="{ name: item.name }"
                    class="adm-nav-item" active-class="adm-nav-item--active" exact-active-class="adm-nav-item--active"
                    @click="sidebarOpen = false">
                    <span class="adm-nav-icon" v-html="item.icon"></span>
                    <span>{{ item.label }}</span>
                </router-link>

                <div class="adm-sidebar__section">Catalogue</div>
                <router-link v-for="item in catalogueNav" :key="item.name" :to="{ name: item.name }"
                    class="adm-nav-item" active-class="adm-nav-item--active" exact-active-class="adm-nav-item--active"
                    @click="sidebarOpen = false">
                    <span class="adm-nav-icon" v-html="item.icon"></span>
                    <span>{{ item.label }}</span>
                </router-link>

                <div class="adm-sidebar__section">System</div>
                <router-link :to="{ name: 'dashboard.settings' }" class="adm-nav-item"
                    active-class="adm-nav-item--active" exact-active-class="adm-nav-item--active"
                    @click="sidebarOpen = false">
                    <span class="adm-nav-icon" v-html="icons.settings"></span>
                    <span>Settings</span>
                </router-link>
                <a href="/backend-logout" class="adm-nav-item" @click.prevent="logout">
                    <span class="adm-nav-icon" v-html="icons.logout"></span>
                    <span>Log out</span>
                </a>
            </nav>
        </aside>

        <div class="adm-main">
            <header class="adm-topbar">
                <div class="adm-flex adm-center adm-gap-12">
                    <button class="adm-btn" aria-label="Toggle sidebar"
                        style="padding: 6px 10px;" @click="sidebarOpen = !sidebarOpen">
                        <span v-html="icons.menu"></span>
                    </button>
                    <div class="adm-topbar__title">{{ pageTitle }}</div>
                </div>
                <div class="adm-topbar__actions">
                    <div class="adm-topbar__user">
                        <div class="adm-topbar__avatar">{{ initials }}</div>
                        <div>
                            <div class="adm-topbar__user-name">{{ admin.displayName }}</div>
                            <div class="adm-topbar__user-role">{{ admin.roleLabel }}</div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="adm-content">
                <router-view />
            </main>
        </div>
    </div>
</template>

<script setup>
import { computed, ref } from 'vue';
import { useRoute } from 'vue-router';
import { useAdminStore } from '../stores/admin';

const admin = useAdminStore();
const route = useRoute();
const sidebarOpen = ref(false);

const icons = {
    home: '<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 10l7-6 7 6M5 9v8h4v-5h2v5h4V9"/></svg>',
    users: '<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="10" cy="7" r="3.2"/><path d="M3.5 17c.7-3 3.3-5 6.5-5s5.8 2 6.5 5"/></svg>',
    orders: '<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="3" width="12" height="14" rx="1.5"/><path d="M7 7h6M7 10h6M7 13h4"/></svg>',
    products: '<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 7l7-4 7 4-7 4-7-4z"/><path d="M3 7v7l7 4 7-4V7"/></svg>',
    articles: '<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="4" width="14" height="12" rx="1.5"/><path d="M6 8h8M6 11h8M6 14h5"/></svg>',
    countries: '<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="10" cy="10" r="7"/><path d="M3 10h14M10 3c2.5 3 2.5 11 0 14M10 3c-2.5 3-2.5 11 0 14"/></svg>',
    settings: '<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="10" cy="10" r="2.5"/><path d="M10 3v2M10 15v2M17 10h-2M5 10H3M15 5l-1.4 1.4M6.4 13.6L5 15M15 15l-1.4-1.4M6.4 6.4L5 5"/></svg>',
    logout: '<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 4h3a2 2 0 012 2v8a2 2 0 01-2 2h-3"/><path d="M8 10h8M13 7l3 3-3 3"/></svg>',
    menu: '<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" width="16" height="16"><path d="M3 6h14M3 10h14M3 14h14"/></svg>',
};

const topNav = [
    { name: 'dashboard.home', label: 'Home', icon: icons.home },
    { name: 'dashboard.users', label: 'Users', icon: icons.users },
    { name: 'dashboard.orders', label: 'Orders', icon: icons.orders },
];

const catalogueNav = [
    { name: 'dashboard.products', label: 'Products', icon: icons.products },
    { name: 'dashboard.articles', label: 'Articles', icon: icons.articles },
    { name: 'dashboard.countries', label: 'Countries', icon: icons.countries },
];

const titles = {
    'dashboard.home': 'Dashboard',
    'dashboard.users': 'Users',
    'dashboard.orders': 'Orders',
    'dashboard.products': 'Products',
    'dashboard.articles': 'Articles',
    'dashboard.countries': 'Countries',
    'dashboard.settings': 'Settings',
};

const pageTitle = computed(() => titles[route.name] || 'Dashboard');

const initials = computed(() => {
    const name = admin.user?.name || admin.user?.email || 'A';
    return name.trim().split(/\s+/).slice(0, 2).map((s) => s[0]?.toUpperCase()).join('');
});

async function logout() {
    try {
        // POST to the session logout endpoint; Laravel will destroy the session.
        const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';
        await fetch('/logout', {
            method: 'POST',
            credentials: 'include',
            headers: { 'X-CSRF-TOKEN': csrf },
        });
    } finally {
        window.location.href = '/backend-login';
    }
}
</script>
