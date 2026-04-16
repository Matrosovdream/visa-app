import { defineStore } from 'pinia';
import api from '../api';

export const useAdminStore = defineStore('admin', {
    state: () => ({
        user: null,
        loaded: false,
        loading: false,
    }),
    getters: {
        displayName: (state) => state.user?.name || state.user?.email || 'Admin',
        roleLabel: (state) => {
            const slugs = (state.user?.roles || []).map((r) => r.slug);
            if (slugs.includes('admin')) return 'Administrator';
            if (slugs.includes('manager')) return 'Manager';
            return 'Staff';
        },
    },
    actions: {
        async load() {
            if (this.loaded || this.loading) return;
            this.loading = true;
            try {
                const { data } = await api.get('/me');
                this.user = data.data ?? null;
                this.loaded = true;
            } catch (e) {
                this.user = null;
            } finally {
                this.loading = false;
            }
        },
    },
});
