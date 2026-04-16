/**
 * v-reveal — adds a CSS class when the element scrolls into view.
 * Replaces the theme's WOW.js `skewIn` scroll-triggered animations.
 *
 * Usage:
 *   <div v-reveal>                         // default fade + translate
 *   <div v-reveal:up>                      // slide up
 *   <div v-reveal:skew="{ delay: 150 }">   // skew-in with delay
 */

const REVEAL_CLASS = 'reveal';
const ACTIVE_CLASS = 'reveal--in';

function apply(el, binding) {
    const variant = binding.arg || 'fade';
    el.classList.add(REVEAL_CLASS, `reveal--${variant}`);

    const delay = binding.value?.delay ?? 0;
    if (delay) el.style.setProperty('--reveal-delay', `${delay}ms`);

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    el.classList.add(ACTIVE_CLASS);
                    observer.unobserve(el);
                }
            });
        },
        { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
    );

    observer.observe(el);
    el.__revealObserver = observer;
}

export default {
    mounted(el, binding) {
        apply(el, binding);
    },
    unmounted(el) {
        el.__revealObserver?.disconnect();
    },
};
