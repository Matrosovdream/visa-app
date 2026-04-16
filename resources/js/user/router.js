import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from './stores/auth';

const routes = [
    {
        path: '/',
        name: 'home',
        component: () => import('./views/HomeView.vue'),
        meta: { layout: 'user' },
    },
    {
        path: '/articles',
        name: 'articles',
        component: () => import('./views/ArticlesView.vue'),
        meta: { layout: 'user' },
    },
    {
        path: '/articles/:slug',
        name: 'article',
        component: () => import('./views/ArticleView.vue'),
        meta: { layout: 'user' },
        props: true,
    },
    {
        path: '/country/:slug',
        name: 'country',
        component: () => import('./views/CountryView.vue'),
        meta: { layout: 'user' },
        props: true,
    },
    {
        path: '/login',
        name: 'login',
        component: () => import('./views/LoginView.vue'),
        meta: { layout: 'user', guestOnly: true },
    },
    {
        path: '/account',
        name: 'account',
        component: () => import('./views/AccountView.vue'),
        meta: { layout: 'user', requiresAuth: true },
    },
    {
        path: '/account/orders',
        name: 'account.orders',
        component: () => import('./views/OrdersView.vue'),
        meta: { layout: 'user', requiresAuth: true },
    },
    {
        path: '/account/orders/:id',
        name: 'account.order',
        component: () => import('./views/OrderView.vue'),
        meta: { layout: 'user', requiresAuth: true },
        props: true,
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'not-found',
        component: () => import('./views/NotFoundView.vue'),
        meta: { layout: 'user' },
    },
];

const router = createRouter({
    history: createWebHistory('/'),
    routes,
    scrollBehavior() {
        return { top: 0 };
    },
});

router.beforeEach((to) => {
    const auth = useAuthStore();
    if (to.meta.guestOnly && auth.isAuthenticated) {
        return { name: 'home' };
    }
    if (to.meta.requiresAuth && !auth.isAuthenticated) {
        return { name: 'login', query: { redirect: to.fullPath } };
    }
    return true;
});

export default router;
