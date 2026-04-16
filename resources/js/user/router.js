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
        path: '/register',
        name: 'register',
        component: () => import('./views/RegisterView.vue'),
        meta: { layout: 'user', guestOnly: true },
    },
    {
        path: '/forgot-password',
        name: 'password.request',
        component: () => import('./views/ForgotPasswordView.vue'),
        meta: { layout: 'user', guestOnly: true },
    },
    {
        path: '/reset-password/:token',
        name: 'password.reset',
        component: () => import('./views/ResetPasswordView.vue'),
        meta: { layout: 'user', guestOnly: true },
        props: true,
    },
    {
        path: '/orders/:hash',
        name: 'order.preview',
        component: () => import('./views/OrderPreviewView.vue'),
        meta: { layout: 'user' },
        props: true,
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
        path: '/account/orders/:id/trip',
        name: 'account.order.trip',
        component: () => import('./views/OrderTripView.vue'),
        meta: { layout: 'user', requiresAuth: true },
        props: true,
    },
    {
        path: '/account/orders/:id/documents',
        name: 'account.order.documents',
        component: () => import('./views/OrderDocumentsView.vue'),
        meta: { layout: 'user', requiresAuth: true },
        props: true,
    },
    // Applicant sub-pages — one shared component, section drives the fields.
    ...['personal', 'passport', 'family', 'past-travel', 'declarations'].map((section) => ({
        path: `/account/orders/:id/applicants/:applicantId/${section}`,
        name: `account.order.applicant.${section}`,
        component: () => import('./views/ApplicantFormView.vue'),
        meta: { layout: 'user', requiresAuth: true },
        props: (route) => ({
            id: route.params.id,
            applicantId: route.params.applicantId,
            section,
        }),
    })),
    {
        path: '/account/orders/:id/applicants/:applicantId/documents',
        name: 'account.order.applicant.documents',
        component: () => import('./views/ApplicantDocumentsView.vue'),
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
