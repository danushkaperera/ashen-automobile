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

    initReviewSlider();
    initScrollReveal();
    initStaticForms();
});

function initStaticForms() {
    const flash = document.getElementById('form-success');
    document.querySelectorAll('form[data-static-form]').forEach((form) => {
        form.addEventListener('submit', (event) => {
            event.preventDefault();
            const type = form.dataset.staticForm;
            const data = new FormData(form);
            const lines = [...data.entries()]
                .filter(([, value]) => String(value).trim())
                .map(([key, value]) => `${key}: ${value}`);
            const subject = type === 'booking'
                ? 'Booking request — Auto Bridge'
                : (data.get('subject') || 'Website enquiry — Auto Bridge');
            const mail = document.createElement('a');
            mail.href = `mailto:service@autobridge.co.nz?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(lines.join('\n'))}`;
            mail.click();
            form.reset();
            if (flash) {
                flash.hidden = false;
                flash.textContent = type === 'booking'
                    ? 'Your booking request is ready to send from your email app. If it did not open, call +64 29 020 16792.'
                    : 'Thanks for getting in touch. If your email app did not open, call +64 29 020 16792.';
                flash.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    });
}

function initReviewSlider() {
    const root = document.querySelector('.review-slider');
    if (!root) return;

    const viewport = root.querySelector('.review-viewport');
    const track = root.querySelector('.review-track');
    const cards = [...track.children];
    const dotsWrap = root.querySelector('.review-dots');
    const prev = root.querySelector('.review-nav.prev');
    const next = root.querySelector('.review-nav.next');
    if (!viewport || !track || cards.length === 0) return;

    const gap = 22;
    const interval = Number(root.dataset.interval || 5000);
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    let index = 0;
    let timer = null;

    function perView() {
        if (window.innerWidth < 700) return 1;
        if (window.innerWidth < 1024) return 2;
        return Math.min(3, cards.length);
    }

    function maxIndex() {
        return Math.max(0, cards.length - perView());
    }

    function render() {
        const n = perView();
        const width = viewport.clientWidth;
        const cardWidth = (width - gap * (n - 1)) / n;
        cards.forEach((card) => {
            card.style.flex = `0 0 ${cardWidth}px`;
            card.style.width = `${cardWidth}px`;
        });
        if (index > maxIndex()) index = 0;
        track.style.transform = `translateX(-${index * (cardWidth + gap)}px)`;
        if (dotsWrap) {
            const pages = maxIndex() + 1;
            if (dotsWrap.children.length !== pages) {
                dotsWrap.innerHTML = '';
                for (let i = 0; i < pages; i += 1) {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.addEventListener('click', () => go(i));
                    dotsWrap.appendChild(btn);
                }
            }
            [...dotsWrap.children].forEach((dot, i) => dot.classList.toggle('active', i === index));
        }
    }

    function go(nextIndex) {
        const max = maxIndex();
        index = nextIndex;
        if (index > max) index = 0;
        if (index < 0) index = max;
        render();
        restart();
    }

    function restart() {
        if (timer) clearInterval(timer);
        if (reduceMotion || cards.length <= perView()) return;
        timer = setInterval(() => go(index + 1), interval);
    }

    if (prev) prev.addEventListener('click', () => go(index - 1));
    if (next) next.addEventListener('click', () => go(index + 1));
    root.addEventListener('mouseenter', () => { if (timer) clearInterval(timer); });
    root.addEventListener('mouseleave', restart);
    window.addEventListener('resize', render);

    const startWhenVisible = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                render();
                restart();
            } else if (timer) {
                clearInterval(timer);
                timer = null;
            }
        });
    }, { threshold: 0.25 });
    startWhenVisible.observe(root);

    render();
}

function initScrollReveal() {
    const selector = [
        '.section-head',
        '.service-card',
        '.feature-card',
        '.team-card',
        '.stat',
        '.faq details',
        '.about-grid > *',
        '.gallery-item',
        '.cta-band .container',
        '.form-card',
        '.page-hero .container',
        '.split > *',
    ].join(',');

    const nodes = [...document.querySelectorAll(selector)];
    if (!nodes.length) return;

    nodes.forEach((el, i) => {
        el.classList.add('reveal');
        el.classList.add(`reveal-delay-${(i % 3) + 1}`);
    });

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        nodes.forEach((el) => el.classList.add('in-view'));
        return;
    }

    const revealNow = (el) => el.classList.add('in-view');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                revealNow(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.08, rootMargin: '0px 0px -8% 0px' });

    nodes.forEach((el) => {
        const rect = el.getBoundingClientRect();
        if (rect.top < window.innerHeight * 0.92 && rect.bottom > 80) {
            revealNow(el);
            return;
        }
        observer.observe(el);
    });
}
