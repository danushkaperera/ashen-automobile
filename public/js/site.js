document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.querySelector('.nav-toggle');
    const nav = document.querySelector('.site-nav');
    if (toggle && nav) {
        toggle.addEventListener('click', () => nav.classList.toggle('open'));
    }

    const slides = [...document.querySelectorAll('.hero-slide')];
    const dotsWrap = document.querySelector('.hero-dots');
    if (slides.length > 1 && dotsWrap) {
        slides.forEach((_, i) => {
            const btn = document.createElement('button');
            btn.type = 'button';
            if (i === 0) btn.classList.add('active');
            btn.addEventListener('click', () => show(i));
            dotsWrap.appendChild(btn);
        });
        let current = 0;
        function show(index) {
            current = index;
            slides.forEach((slide, i) => slide.classList.toggle('active', i === index));
            [...dotsWrap.children].forEach((dot, i) => dot.classList.toggle('active', i === index));
        }
        setInterval(() => show((current + 1) % slides.length), 6000);
    }

    const chips = [...document.querySelectorAll('.chip[data-filter]')];
    const items = [...document.querySelectorAll('.gallery-item')];
    chips.forEach((chip) => {
        chip.addEventListener('click', () => {
            chips.forEach((c) => c.classList.toggle('active', c === chip));
            const filter = chip.dataset.filter;
            items.forEach((item) => {
                item.style.display = filter === 'all' || item.dataset.category === filter ? '' : 'none';
            });
        });
    });

    const lightbox = document.querySelector('.lightbox');
    const lightboxImg = lightbox ? lightbox.querySelector('img') : null;
    document.querySelectorAll('.gallery-item[data-full]').forEach((item) => {
        item.addEventListener('click', () => {
            if (!lightbox || !lightboxImg) return;
            lightboxImg.src = item.dataset.full;
            lightbox.classList.add('open');
        });
    });
    if (lightbox) {
        lightbox.addEventListener('click', () => lightbox.classList.remove('open'));
    }
});
