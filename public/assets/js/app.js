(function () {
    'use strict';

    const Modal = {
        current: null,
        previousFocus: null,

        init() {
            document.addEventListener('click', (event) => {
                const opener = event.target.closest('[data-modal-open]');
                if (opener) {
                    event.preventDefault();
                    this.open(opener.getAttribute('data-modal-open'));
                    return;
                }

                const closer = event.target.closest('[data-modal-close]');
                if (closer) {
                    const modal = closer.closest('[data-modal]');
                    if (modal) {
                        this.close(modal.id);
                    }
                    return;
                }

                if (event.target.matches('[data-modal-backdrop]')) {
                    const modal = event.target.closest('[data-modal]');
                    if (modal) {
                        this.close(modal.id);
                    }
                }
            });

            document.addEventListener('keydown', (event) => {
                if (!this.current) {
                    return;
                }

                if (event.key === 'Escape') {
                    this.close(this.current.id);
                    return;
                }

                if (event.key === 'Tab') {
                    this.trapFocus(event);
                }
            });
        },

        open(id) {
            const modal = document.getElementById(id);
            if (!modal) {
                return;
            }

            this.previousFocus = document.activeElement;
            this.current = modal;
            modal.classList.add('is-open');
            modal.setAttribute('aria-hidden', 'false');

            const focusable = modal.querySelector('input:not([type="hidden"]):not([disabled])')
                || modal.querySelector('textarea, select')
                || modal.querySelector('button:not([disabled]), [href]');
            if (focusable) {
                focusable.focus();
            }
        },

        close(id) {
            const modal = document.getElementById(id);
            if (!modal) {
                return;
            }

            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
            this.current = null;

            if (this.previousFocus && typeof this.previousFocus.focus === 'function') {
                this.previousFocus.focus();
            }
            this.previousFocus = null;
        },

        trapFocus(event) {
            const modal = this.current;
            if (!modal) {
                return;
            }

            const focusables = modal.querySelectorAll(
                'input:not([type="hidden"]):not([disabled]), button:not([disabled]), [href], select, textarea'
            );
            if (focusables.length === 0) {
                return;
            }

            const first = focusables[0];
            const last = focusables[focusables.length - 1];
            if (event.shiftKey && document.activeElement === first) {
                event.preventDefault();
                last.focus();
            } else if (!event.shiftKey && document.activeElement === last) {
                event.preventDefault();
                first.focus();
            }
        }
    };

    const App = {
        init() {
            this.initMobileNav();
            this.initSmoothScroll();
            this.initScrollReveal();
            Modal.init();
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

    App.Modal = Modal;
    document.addEventListener('DOMContentLoaded', () => App.init());
})();
