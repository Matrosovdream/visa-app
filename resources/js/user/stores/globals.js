import { defineStore } from 'pinia';
import api from '../api';
import { setTranslations } from '../i18n';

export const useGlobalsStore = defineStore('globals', {
    state: () => ({
        loaded: false,
        loading: false,
        siteSettings: {},
        menuTop: [],
        languages: [],
        currencies: [],
        countries: [],
        activeLanguage: null,
        activeCurrency: null,
        locale: 'en',
    }),
    actions: {
        async load() {
            if (this.loaded || this.loading) return;
            this.loading = true;
            try {
                const { data } = await api.get('/site/bootstrap');
                const payload = data.data ?? {};
                this.siteSettings = payload.site_settings ?? {};
                this.menuTop = payload.menu_top ?? [];
                this.languages = payload.languages ?? [];
                this.currencies = payload.currencies ?? [];
                this.countries = payload.countries ?? [];
                this.activeLanguage = payload.active_language ?? null;
                this.activeCurrency = payload.active_currency ?? null;
                this.locale = payload.locale ?? 'en';
                setTranslations(this.locale, payload.translations ?? {});
                this.loaded = true;
            } finally {
                this.loading = false;
            }
        },
    },
});
