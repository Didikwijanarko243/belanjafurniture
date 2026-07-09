export function initMegaMenu() {
    const canHover = window.matchMedia('(hover: hover)').matches;

    document.querySelectorAll('[data-mega-menu]').forEach((wrapper) => {
        const trigger = wrapper.querySelector('.mega-menu-trigger');
        const panel = wrapper.querySelector('.mega-menu-panel');
        const chevron = wrapper.querySelector('.mega-menu-chevron');
        if (!trigger || !panel) return;

        const open = () => {
            panel.classList.remove('hidden');
            trigger.setAttribute('aria-expanded', 'true');
            chevron?.classList.add('rotate-180');
        };

        const close = () => {
            panel.classList.add('hidden');
            trigger.setAttribute('aria-expanded', 'false');
            chevron?.classList.remove('rotate-180');
        };

        if (canHover) {
            wrapper.addEventListener('mouseenter', open);
            wrapper.addEventListener('mouseleave', close);
        } else {
            trigger.addEventListener('click', (e) => {
                e.preventDefault();
                panel.classList.contains('hidden') ? open() : close();
            });
        }

        document.addEventListener('click', (e) => {
            if (!wrapper.contains(e.target)) close();
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') close();
        });
    });
}