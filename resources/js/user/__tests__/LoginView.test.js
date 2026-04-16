import { describe, it, expect, beforeEach, vi } from 'vitest';
import { mount, flushPromises } from '@vue/test-utils';
import { setActivePinia, createPinia } from 'pinia';
import { createI18n } from 'vue-i18n';
import { createRouter, createMemoryHistory } from 'vue-router';

vi.mock('../api', () => ({
    default: { post: vi.fn(), get: vi.fn() },
}));

import api from '../api';
import LoginView from '../views/LoginView.vue';

function buildRouter() {
    return createRouter({
        history: createMemoryHistory(),
        routes: [
            { path: '/',        name: 'home',   component: { template: '<div/>' } },
            { path: '/login',   name: 'login',  component: LoginView },
            { path: '/account', name: 'account', component: { template: '<div/>' } },
            { path: '/forgot-password', name: 'forgot', component: { template: '<div/>' } },
            { path: '/register',        name: 'register', component: { template: '<div/>' } },
        ],
    });
}

function buildI18n() {
    return createI18n({
        legacy: false,
        locale: 'en',
        fallbackLocale: 'en',
        messages: { en: {} },
        missingWarn: false,
        fallbackWarn: false,
    });
}

async function mountLogin({ route = '/login' } = {}) {
    const pinia = createPinia();
    setActivePinia(pinia);
    const router = buildRouter();
    const i18n = buildI18n();
    await router.push(route);
    await router.isReady();

    const wrapper = mount(LoginView, {
        global: {
            plugins: [pinia, router, i18n],
            stubs: { SmartLink: { template: '<a><slot/></a>' } },
        },
    });
    return { wrapper, router };
}

describe('LoginView', () => {
    beforeEach(() => {
        vi.clearAllMocks();
    });

    it('submits credentials and redirects home on success', async () => {
        api.post.mockResolvedValue({
            data: { token: 't', user: { id: 1 } },
        });

        const { wrapper, router } = await mountLogin();

        await wrapper.find('input[type="email"]').setValue('alice@example.com');
        await wrapper.find('input[type="password"]').setValue('secret');
        await wrapper.find('form').trigger('submit.prevent');
        await flushPromises();

        expect(api.post).toHaveBeenCalledWith('/auth/login', {
            email: 'alice@example.com', password: 'secret',
        });
        expect(router.currentRoute.value.path).toBe('/');
    });

    it('honours ?redirect= query on success', async () => {
        api.post.mockResolvedValue({ data: { token: 't', user: { id: 1 } } });

        const { wrapper, router } = await mountLogin({
            route: '/login?redirect=/account',
        });

        await wrapper.find('input[type="email"]').setValue('a@b.c');
        await wrapper.find('input[type="password"]').setValue('x');
        await wrapper.find('form').trigger('submit.prevent');
        await flushPromises();

        expect(router.currentRoute.value.path).toBe('/account');
    });

    it('shows field errors on 422', async () => {
        api.post.mockRejectedValue({
            response: {
                status: 422,
                data: { errors: { email: ['Email is invalid.'] } },
            },
        });

        const { wrapper } = await mountLogin();
        await wrapper.find('form').trigger('submit.prevent');
        await flushPromises();

        expect(wrapper.text()).toContain('Email is invalid.');
    });

    it('shows a general error on 401', async () => {
        api.post.mockRejectedValue({
            response: { status: 401, data: { message: 'Invalid credentials.' } },
        });

        const { wrapper } = await mountLogin();
        await wrapper.find('form').trigger('submit.prevent');
        await flushPromises();

        expect(wrapper.text()).toContain('Invalid credentials.');
    });
});
