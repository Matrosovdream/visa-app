import { describe, it, expect, beforeEach, vi } from 'vitest';
import { setActivePinia, createPinia } from 'pinia';

// The real router imports all view files. We stub them so tests stay light.
vi.mock('../views/HomeView.vue',            () => ({ default: { template: '<div/>' } }));
vi.mock('../views/ArticlesView.vue',        () => ({ default: { template: '<div/>' } }));
vi.mock('../views/ArticleView.vue',         () => ({ default: { template: '<div/>' } }));
vi.mock('../views/CountryView.vue',         () => ({ default: { template: '<div/>' } }));
vi.mock('../views/LoginView.vue',           () => ({ default: { template: '<div/>' } }));
vi.mock('../views/RegisterView.vue',        () => ({ default: { template: '<div/>' } }));
vi.mock('../views/ForgotPasswordView.vue',  () => ({ default: { template: '<div/>' } }));
vi.mock('../views/ResetPasswordView.vue',   () => ({ default: { template: '<div/>' } }));
vi.mock('../views/OrderPreviewView.vue',    () => ({ default: { template: '<div/>' } }));
vi.mock('../views/AccountView.vue',         () => ({ default: { template: '<div/>' } }));
vi.mock('../views/OrdersView.vue',          () => ({ default: { template: '<div/>' } }));
vi.mock('../views/OrderView.vue',           () => ({ default: { template: '<div/>' } }));
vi.mock('../views/OrderTripView.vue',       () => ({ default: { template: '<div/>' } }));
vi.mock('../views/OrderDocumentsView.vue',  () => ({ default: { template: '<div/>' } }));
vi.mock('../views/ApplicantFormView.vue',   () => ({ default: { template: '<div/>' } }));
vi.mock('../views/ApplicantDocumentsView.vue', () => ({ default: { template: '<div/>' } }));
vi.mock('../views/NotFoundView.vue',        () => ({ default: { template: '<div/>' } }));
vi.mock('../api', () => ({ default: { post: vi.fn(), get: vi.fn() } }));

import router from '../router';
import { useAuthStore } from '../stores/auth';

describe('user SPA router guards', () => {
    beforeEach(() => {
        setActivePinia(createPinia());
    });

    it('redirects guests away from /account to /login', async () => {
        await router.push('/account');
        await router.isReady();

        expect(router.currentRoute.value.name).toBe('login');
        expect(router.currentRoute.value.query.redirect).toBe('/account');
    });

    it('redirects authenticated users away from /login to home', async () => {
        const auth = useAuthStore();
        auth.token = 'present';
        auth.user = { id: 1 };

        await router.push('/login');
        await router.isReady();

        expect(router.currentRoute.value.name).toBe('home');
    });

    it('falls back to not-found for unknown routes', async () => {
        await router.push('/this-does-not-exist-xyz');
        await router.isReady();

        expect(router.currentRoute.value.name).toBe('not-found');
    });

    it('generates one route per applicant section', () => {
        const names = router.getRoutes().map((r) => r.name);
        expect(names).toContain('account.order.applicant.personal');
        expect(names).toContain('account.order.applicant.passport');
        expect(names).toContain('account.order.applicant.family');
        expect(names).toContain('account.order.applicant.past-travel');
        expect(names).toContain('account.order.applicant.declarations');
    });
});
