import { defineStore } from 'pinia';

export const useConfirmStore = defineStore('confirm', {
    state: () => ({
        open: false,
        title: '',
        message: '',
        confirmLabel: 'Confirm',
        cancelLabel: 'Cancel',
        danger: false,
        resolver: null,
    }),
    actions: {
        ask(options = {}) {
            this.title        = options.title || 'Are you sure?';
            this.message      = options.message || '';
            this.confirmLabel = options.confirmLabel || 'Confirm';
            this.cancelLabel  = options.cancelLabel || 'Cancel';
            this.danger       = options.danger ?? false;
            this.open         = true;

            return new Promise((resolve) => {
                this.resolver = resolve;
            });
        },
        resolve(result) {
            this.open = false;
            const r = this.resolver;
            this.resolver = null;
            if (r) r(result);
        },
    },
});
