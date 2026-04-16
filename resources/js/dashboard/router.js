import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/dashboard',
        component: () => import('./layouts/AdminLayout.vue'),
        children: [
            { path: '', name: 'dashboard.home', component: () => import('./views/HomeView.vue') },

            // Users
            { path: 'users',        name: 'dashboard.users',       component: () => import('./views/UsersView.vue') },
            { path: 'users/create', name: 'dashboard.user.create', component: () => import('./views/UserFormView.vue') },
            { path: 'users/:id',    name: 'dashboard.user.edit',   component: () => import('./views/UserFormView.vue'), props: true },

            // Orders (+ nested traveller CRUD)
            { path: 'orders',        name: 'dashboard.orders',       component: () => import('./views/OrdersView.vue') },
            { path: 'orders/create', name: 'dashboard.order.create', component: () => import('./views/OrderCreateView.vue') },
            { path: 'orders/:id',    name: 'dashboard.order.show',   component: () => import('./views/OrderShowView.vue'), props: true },
            {
                path: 'orders/:id/travellers/create',
                name: 'dashboard.order.traveller.create',
                component: () => import('./views/OrderTravellerFormView.vue'),
                props: true,
            },
            {
                path: 'orders/:id/travellers/:travellerId',
                name: 'dashboard.order.traveller.edit',
                component: () => import('./views/OrderTravellerFormView.vue'),
                props: true,
            },

            // Products
            { path: 'products',        name: 'dashboard.products',       component: () => import('./views/ProductsView.vue') },
            { path: 'products/create', name: 'dashboard.product.create', component: () => import('./views/ProductFormView.vue') },
            { path: 'products/:id',    name: 'dashboard.product.edit',   component: () => import('./views/ProductFormView.vue'), props: true },

            // Product offers / extras (standalone CRUD pages)
            { path: 'offers', name: 'dashboard.offers', component: () => import('./views/OffersView.vue') },
            { path: 'extras', name: 'dashboard.extras', component: () => import('./views/ExtrasView.vue') },

            // Articles
            { path: 'articles',        name: 'dashboard.articles',       component: () => import('./views/ArticlesView.vue') },
            { path: 'articles/create', name: 'dashboard.article.create', component: () => import('./views/ArticleFormView.vue') },
            { path: 'articles/:id',    name: 'dashboard.article.edit',   component: () => import('./views/ArticleFormView.vue'), props: true },

            // Reference data
            { path: 'countries',       name: 'dashboard.countries',      component: () => import('./views/CountriesView.vue') },
            { path: 'directions',      name: 'dashboard.directions',     component: () => import('./views/DirectionsView.vue') },
            { path: 'directions/:id',  name: 'dashboard.direction.show', component: () => import('./views/DirectionShowView.vue'), props: true },
            { path: 'gateways',        name: 'dashboard.gateways',       component: () => import('./views/GatewaysView.vue') },

            // Settings
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
