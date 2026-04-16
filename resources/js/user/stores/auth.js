import { defineStore } from 'pinia';
import api from '../api';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        token: null,
        user: null,
    }),
    getters: {
        isAuthenticated: (state) => !!state.token,
    },
    actions: {
        init() {
            const token = localStorage.getItem('auth_token');
            const user = localStorage.getItem('auth_user');
            if (token) this.token = token;
            if (user) {
                try {
                    this.user = JSON.parse(user);
                } catch (e) {
                    this.user = null;
                }
            }
        },
        async login({ email, password }) {
            const { data } = await api.post('/auth/login', { email, password });
            this.token = data.token;
            this.user = data.user;
            localStorage.setItem('auth_token', data.token);
            localStorage.setItem('auth_user', JSON.stringify(data.user));
            return data;
        },
        async register({ name, email, password, password_confirmation }) {
            const { data } = await api.post('/auth/register', {
                name,
                email,
                password,
                password_confirmation,
            });
            this.token = data.token;
            this.user = data.user;
            localStorage.setItem('auth_token', data.token);
            localStorage.setItem('auth_user', JSON.stringify(data.user));
            return data;
        },
        async logout() {
            try {
                await api.post('/auth/logout');
            } catch (e) {
                // Even if the server call fails, clear local state.
            }
            this.token = null;
            this.user = null;
            localStorage.removeItem('auth_token');
            localStorage.removeItem('auth_user');
        },
        async fetchUser() {
            const { data } = await api.get('/auth/user');
            this.user = data;
            localStorage.setItem('auth_user', JSON.stringify(data));
            return data;
        },
    },
});
