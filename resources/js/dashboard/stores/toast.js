import { defineStore } from 'pinia';

let seq = 0;

export const useToastStore = defineStore('toast', {
    state: () => ({ items: [] }),
    actions: {
        push(message, { type = 'info', timeout = 4000 } = {}) {
            const id = ++seq;
            this.items.push({ id, message, type });
            if (timeout) {
                setTimeout(() => this.dismiss(id), timeout);
            }
        },
        success(message, opts) { this.push(message, { ...opts, type: 'success' }); },
        error(message, opts)   { this.push(message, { ...opts, type: 'error' }); },
        warn(message, opts)    { this.push(message, { ...opts, type: 'warn' }); },
        info(message, opts)    { this.push(message, { ...opts, type: 'info' }); },
        dismiss(id) {
            this.items = this.items.filter((t) => t.id !== id);
        },
    },
});
