import { createI18n } from 'vue-i18n';

export const i18n = createI18n({
    legacy: false,
    globalInjection: true,
    locale: 'en',
    fallbackLocale: 'en',
    messages: { en: {} },
    missingWarn: false,
    fallbackWarn: false,
});

export function setTranslations(locale, messages) {
    i18n.global.setLocaleMessage(locale, messages || {});
    i18n.global.locale.value = locale;
}
