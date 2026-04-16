import { describe, it, expect, beforeEach, vi } from 'vitest';
import { setActivePinia, createPinia } from 'pinia';

// Mock the axios api module before importing the store.
vi.mock('../api', () => ({
    default: {
        post: vi.fn(),
        get: vi.fn(),
    },
}));

import api from '../api';
import { useAuthStore } from '../stores/auth';

describe('auth store', () => {
    beforeEach(() => {
        setActivePinia(createPinia());
        vi.clearAllMocks();
    });

    it('starts unauthenticated', () => {
        const auth = useAuthStore();
        expect(auth.isAuthenticated).toBe(false);
        expect(auth.token).toBeNull();
        expect(auth.user).toBeNull();
    });

    it('login stores token and user in state + localStorage', async () => {
        api.post.mockResolvedValue({
            data: { token: 'abc123', user: { id: 1, name: 'Alice' } },
        });

        const auth = useAuthStore();
        await auth.login({ email: 'alice@example.com', password: 'secret' });

        expect(auth.token).toBe('abc123');
        expect(auth.user.name).toBe('Alice');
        expect(auth.isAuthenticated).toBe(true);
        expect(localStorage.getItem('auth_token')).toBe('abc123');
        expect(JSON.parse(localStorage.getItem('auth_user')).id).toBe(1);
    });

    it('register behaves like login on success', async () => {
        api.post.mockResolvedValue({
            data: { token: 'new-token', user: { id: 2 } },
        });

        const auth = useAuthStore();
        await auth.register({
            name: 'Bob',
            email: 'bob@example.com',
            password: 'pw',
            password_confirmation: 'pw',
        });

        expect(auth.token).toBe('new-token');
        expect(localStorage.getItem('auth_token')).toBe('new-token');
    });

    it('logout clears state even when server call fails', async () => {
        localStorage.setItem('auth_token', 'stale');
        localStorage.setItem('auth_user', '{"id":1}');
        api.post.mockRejectedValue(new Error('network'));

        const auth = useAuthStore();
        auth.token = 'stale';
        auth.user = { id: 1 };

        await auth.logout();

        expect(auth.token).toBeNull();
        expect(auth.user).toBeNull();
        expect(localStorage.getItem('auth_token')).toBeNull();
        expect(localStorage.getItem('auth_user')).toBeNull();
    });

    it('init() rehydrates state from localStorage', () => {
        localStorage.setItem('auth_token', 'persisted');
        localStorage.setItem('auth_user', JSON.stringify({ id: 7, name: 'Carol' }));

        const auth = useAuthStore();
        auth.init();

        expect(auth.token).toBe('persisted');
        expect(auth.user.name).toBe('Carol');
    });

    it('init() gracefully handles malformed user JSON', () => {
        localStorage.setItem('auth_token', 'x');
        localStorage.setItem('auth_user', '{not-json');

        const auth = useAuthStore();
        auth.init();

        expect(auth.token).toBe('x');
        expect(auth.user).toBeNull();
    });

    it('fetchUser updates user from API', async () => {
        api.get.mockResolvedValue({ data: { id: 9, name: 'Dan' } });

        const auth = useAuthStore();
        await auth.fetchUser();

        expect(auth.user.id).toBe(9);
        expect(JSON.parse(localStorage.getItem('auth_user')).id).toBe(9);
    });
});
