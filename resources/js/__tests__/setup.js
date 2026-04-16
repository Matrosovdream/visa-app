// Shared Vitest setup. Runs before every test file.

// jsdom/happy-dom don't provide a matchMedia shim by default.
if (!window.matchMedia) {
    window.matchMedia = () => ({
        matches: false,
        addListener: () => {},
        removeListener: () => {},
        addEventListener: () => {},
        removeEventListener: () => {},
        dispatchEvent: () => false,
    });
}

// Clear localStorage between tests so auth state can't leak.
beforeEach(() => {
    localStorage.clear();
});
