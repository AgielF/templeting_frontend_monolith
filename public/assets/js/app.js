(function () {
    'use strict';

    const App = {
        init() {
            this.initMobileNav();
            this.initSmoothScroll();
            this.initScrollReveal();
        },

        initMobileNav() {
            const toggle = document.querySelector('[data-nav-toggle]');
            const links = document.querySelector('[data-nav-links]');

            if (!toggle || !links) {
                return;
            }

            toggle.addEventListener('click', () => {
                const isOpen = links.classList.toggle('is-open');
                toggle.setAttribute('aria-expanded', String(isOpen));
            });
        },

        initSmoothScroll() {
            document.querySelectorAll('a[href^="#"]').forEach((link) => {
                link.addEventListener('click', (event) => {
                    const target = document.querySelector(link.getAttribute('href'));

                    if (!target) {
                        return;
                    }

                    event.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    target.setAttribute('tabindex', '-1');
                    target.focus({ preventScroll: true });
                });
            });
        },

        initScrollReveal() {
            const revealItems = document.querySelectorAll('[data-reveal]');

            if (!revealItems.length || !('IntersectionObserver' in window)) {
                revealItems.forEach((item) => item.classList.add('is-visible'));
                return;
            }

            const observer = new IntersectionObserver((entries, observerInstance) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) {
                        return;
                    }

                    entry.target.classList.add('is-visible');
                    observerInstance.unobserve(entry.target);
                });
            }, { threshold: 0.15 });

            revealItems.forEach((item) => observer.observe(item));
        }
    };

    document.addEventListener('DOMContentLoaded', () => App.init());
})();
