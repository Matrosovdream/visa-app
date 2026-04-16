import { describe, it, expect, beforeEach, vi } from 'vitest';
import { setActivePinia, createPinia } from 'pinia';
import { useToastStore } from '../stores/toast';

describe('dashboard toast store', () => {
    beforeEach(() => {
        setActivePinia(createPinia());
        vi.useFakeTimers();
    });

    it('starts empty and enqueues toasts via push/success/error', () => {
        const toast = useToastStore();
        expect(toast.items.length).toBe(0);

        toast.push('Hello', { timeout: 0 });
        toast.success('Saved.', { timeout: 0 });
        toast.error('Broken.', { timeout: 0 });

        expect(toast.items.length).toBe(3);
        expect(toast.items.map((t) => t.type)).toEqual(['info', 'success', 'error']);
        expect(toast.items.map((t) => t.message)).toEqual(['Hello', 'Saved.', 'Broken.']);
    });

    it('auto-dismisses after timeout', () => {
        const toast = useToastStore();
        toast.push('Flash', { timeout: 1000 });
        expect(toast.items.length).toBe(1);

        vi.advanceTimersByTime(1000);
        expect(toast.items.length).toBe(0);
    });

    it('dismiss(id) removes a specific toast', () => {
        const toast = useToastStore();
        toast.push('A', { timeout: 0 });
        toast.push('B', { timeout: 0 });
        const targetId = toast.items[0].id;

        toast.dismiss(targetId);

        expect(toast.items.length).toBe(1);
        expect(toast.items[0].message).toBe('B');
    });
});
