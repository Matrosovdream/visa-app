import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/admin-panel',
        component: () => import('./layouts/AdminLayout.vue'),
        children: [
            { path: '', name: 'dashboard.home', component: () => import('./views/HomeView.vue') },
            { path: 'users', name: 'dashboard.users', component: () => import('./views/UsersView.vue') },
            { path: 'orders', name: 'dashboard.orders', component: () => import('./views/OrdersView.vue') },
            { path: 'products', name: 'dashboard.products', component: () => import('./views/ProductsView.vue') },
            { path: 'articles', name: 'dashboard.articles', component: () => import('./views/ArticlesView.vue') },
            { path: 'countries', name: 'dashboard.countries', component: () => import('./views/CountriesView.vue') },
            { path: 'settings', name: 'dashboard.settings', component: () => import('./views/SettingsView.vue') },
            {
                path: ':pathMatch(.*)*',
                name: 'dashboard.not-found',
                component: () => import('./views/NotFoundView.vue'),
            },
        ],
    },
];

const router = createRouter({
    history: createWebHistory('/'),
    routes,
    scrollBehavior() { return { top: 0 }; },
});

export default router;
