import { mkdirSync, writeFileSync } from 'node:fs';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';

const root = dirname(fileURLToPath(import.meta.url));
const mapsUrl = 'https://www.google.com/maps/place/Auto+Bridge/@-43.5419295,172.5818326,553m/data=!3m1!1e3!4m6!3m5!1s0x6d31f559b16c7ad1:0x51f12fe80e2e3e07!8m2!3d-43.5419295!4d172.5818326!16s%2Fg%2F11y_gwd7lm';
const mapEmbed = 'https://maps.google.com/maps?q=-43.5419295,172.5818326&hl=en&z=17&output=embed';
const email = 'service@autobridge.co.nz';
const phone = '+64 29 020 16792';
const phoneTel = '+642902016792';
const address = '11a Midas Place, Middleton, Christchurch 8024, New Zealand';
const year = new Date().getFullYear();

const services = [
    {
        slug: 'diagnostics-repairs',
        title: 'Diagnostics & Repairs',
        short: 'Advanced vehicle repairs and fault diagnostics to keep your car performing at its best.',
        image: 'service-1.svg',
        html: '<p>Advanced vehicle repairs and fault diagnostics to keep your car performing at its best.</p><ul><li>Engine diagnostics</li><li>Mechanical repairs</li><li>Brake &amp; suspension</li><li>Cooling systems</li><li>Electrical faults</li></ul>',
    },
    {
        slug: 'ev-hybrid-specialists',
        title: 'EV & Hybrid Specialists',
        short: 'Specialist EV and hybrid mechanic, providing servicing and diagnostics using modern technology.',
        image: 'service-2.svg',
        html: '<p>Specialist EV and hybrid servicing and diagnostics using modern technology.</p><ul><li>Hybrid system diagnostics</li><li>EV servicing</li><li>Battery health checks</li><li>Hybrid repairs</li></ul>',
    },
    {
        slug: 'pre-purchase-inspections',
        title: 'Pre-Purchase Inspections',
        short: 'Detailed pre-purchase vehicle inspections to give you confidence and clarity before you buy.',
        image: 'service-3.svg',
        html: '<p>Detailed pre-purchase vehicle inspections to give you confidence and clarity before you buy.</p><ul><li>Pre-purchase inspections</li><li>Buyer reports</li><li>Fleet checks</li></ul>',
    },
    {
        slug: 'engine-diagnostics',
        title: 'Engine diagnostics',
        short: 'Scan and live-data diagnosis for warning lights, misfires and poor running.',
        image: 'service-4.svg',
        html: '<p>Scan and live-data diagnosis for warning lights, misfires and poor running.</p>',
    },
    {
        slug: 'mechanical-repairs',
        title: 'Mechanical repairs',
        short: 'Clutches, exhausts, driveline and general mechanical work for all makes and models.',
        image: 'service-5.svg',
        html: '<p>Clutches, exhausts, driveline and general mechanical work for all makes and models.</p>',
    },
    {
        slug: 'brake-suspension',
        title: 'Brake & suspension',
        short: 'Pads, rotors, shocks, bushes and steering repairs — measured, not guessed.',
        image: 'service-6.svg',
        html: '<p>Pads, rotors, shocks, bushes and steering repairs — measured, not guessed.</p>',
    },
    {
        slug: 'cooling-systems',
        title: 'Cooling systems',
        short: 'Overheating, radiator, thermostat and water-pump diagnosis and repair.',
        image: 'service-7.svg',
        html: '<p>Overheating, radiator, thermostat and water-pump diagnosis and repair.</p>',
    },
    {
        slug: 'electrical-faults',
        title: 'Electrical faults',
        short: 'Starting, charging, lighting, sensors and aftermarket wiring faults.',
        image: 'service-8.svg',
        html: '<p>Starting, charging, lighting, sensors and aftermarket wiring faults.</p>',
    },
    {
        slug: 'battery-health-checks',
        title: 'Battery health checks',
        short: 'Load-tested batteries, hybrid/EV battery health and charging-system checks.',
        image: 'service-9.svg',
        html: '<p>Load-tested batteries, hybrid/EV battery health and charging-system checks.</p>',
    },
];

const features = [
    ['Professional & expert', 'Modern diagnostic technology with practical mechanical expertise — everyday cars through to EV and hybrid systems.'],
    ['Honesty', 'No upsells, no surprises. Clear quotes before any work begins.'],
    ['Quality', 'OEM-grade parts and meticulous workmanship on every job.'],
    ['Trust', 'A 5.0-rated Christchurch car repair shop, open 24 hours when you need us.'],
];

const stats = [
    ['24/7', 'Open hours'],
    ['5.0', 'Google rating'],
    ['3', 'Core service streams'],
    ['All', 'Makes & models'],
];

const team = [
    ['Workshop team', 'Mechanical repairs', 'Diagnostics, brakes, suspension, cooling and general mechanical work at the Middleton workshop.', 'team-1.svg'],
    ['EV & hybrid', 'Specialist servicing', 'Hybrid system diagnostics, EV servicing, battery health checks and hybrid repairs.', 'team-2.svg'],
    ['Service desk', 'Bookings & quotes', 'Call +64 29 020 16792 anytime — Auto Bridge is listed as open 24 hours.', 'team-3.svg'],
];

const testimonials = [
    ['yu bb', 'Google review', 'The mechanic was very patient and thorough when checking my car. Really appreciate his help and would definitely recommend him!'],
    ['Trevor Keohane', 'Toyota RAV4 · Google review', 'I recently had the steering rack and gearbox replaced on my Toyota RAV4 by Auto Bridge Automotive and couldn\'t be happier with the service. The team was friendly, professional, and kept me informed throughout the process. I especially appreciated them dropping my car off at home when the work was completed, which made things so much easier. Great customer service and quality workmanship. I\'ll definitely be using Auto Bridge Automotive for all my future servicing and maintenance. Highly recommended!'],
    ['Garry', 'Google review', 'These guys are the real deal, had problems with my trailer lights which they solved very quickly. Highly recommend to try out this business.'],
    ['Thomas Devereux', 'Google review', 'Great customer service. Came very quick and fixed my car within an hour of contacting them and extremely well priced!'],
    ['Oli Stewart', 'Audi S3 · Google review', 'Had a great experience with Auto Bridge. They worked around my schedule and got my Audi S3 fixed very quickly after I reached out. The team was careful, polite, and the pricing was fantastic—a level above those expensive auto shops and dealerships. Haven’t had any issues since the ignition barrel replacement—highly recommend!'],
    ['Dj Crax', 'Google review', 'Amazing and really impressive service at genuine pricing.. Highly recommended'],
];

const gallery = [
    ['Diagnostics bay', 'workshop', 'gallery-1.svg'],
    ['Mechanical repairs', 'repairs', 'gallery-2.svg'],
    ['EV & hybrid work', 'workshop', 'gallery-3.svg'],
    ['Battery health check', 'repairs', 'gallery-4.svg'],
    ['Workshop floor, Midas Place', 'workshop', 'gallery-5.svg'],
    ['Cooling system service', 'repairs', 'gallery-6.svg'],
];

const faqs = [
    ['Do I need an appointment?', 'Booking is preferred so we can put you in a bay. Call +64 29 020 16792 — Auto Bridge is listed as open 24 hours at 11a Midas Place, Middleton.'],
    ['How do quotes work?', 'Inspection and diagnosis come first. We then send a written quote. Extra work is not started without your approval. No upsells, no surprises.'],
    ['Do you do WOF inspections?', 'No. We do not offer WOF or compliance inspections. We focus on diagnostics, repairs, EV & hybrid servicing and pre-purchase inspections.'],
    ['Can you service EV and hybrid vehicles?', 'Yes. We provide hybrid system diagnostics, EV servicing, battery health checks and hybrid repairs using modern diagnostic equipment.'],
    ['Which makes do you work on?', 'All common makes and models — European, Japanese, Korean, American and EV platforms including Tesla, BYD, Toyota, Ford, BMW and more.'],
    ['Where are you?', '11a Midas Place, Middleton, Christchurch 8024, New Zealand. Wheelchair accessible. View the listing on Google Maps.'],
];

const makes = 'Alfa Romeo, Audi, BMW, BYD, Chery, Dodge, Ferrari, Fiat, Ford, Honda, Hyundai, Isuzu, Iveco, Jaguar, Jeep, Kia, Lexus, Mazda, MG, Mini, Mitsubishi, Nissan, Peugeot, Porsche, Renault, Subaru, Suzuki, Tesla, Toyota, Volkswagen'
    .split(',').map((s) => s.trim());

function paths(depth) {
    const p = depth ? '../' : '';
    return {
        css: `${p}css/site.css`,
        js: `${p}js/site.js`,
        favicon: `${p}images/logo.png`,
        logo: `${p}images/logo.png`,
        img: (file) => `${p}images/${file}`,
        home: `${p}index.html`,
        about: `${p}about.html`,
        services: `${p}services.html`,
        gallery: `${p}gallery.html`,
        faq: `${p}faq.html`,
        contact: `${p}contact.html`,
        book: `${p}book.html`,
        findUs: `${p}find-us.html`,
        privacy: `${p}privacy.html`,
        service: (slug) => `${p}services/${slug}.html`,
    };
}

function layout({ title, description, depth = 0, active, content, extra = '' }) {
    const a = paths(depth);
    const nav = [
        ['Home', a.home, 'home'],
        ['Services', a.services, 'services'],
        ['About', a.about, 'about'],
        ['Gallery', a.gallery, 'gallery'],
        ['FAQ', a.faq, 'faq'],
        ['Contact', a.contact, 'contact'],
    ];
    return `<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>${title}</title>
    <meta name="description" content="${description}">
    <link rel="icon" href="${a.favicon}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Barlow:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="${a.css}">
</head>
<body>
    <div class="topbar">
        <div class="container topbar-inner">
            <span>Open 24 hours · 11a Midas Place, Middleton, Christchurch</span>
            <a href="tel:${phoneTel}">${phone}</a>
        </div>
    </div>
    <header class="site-header">
        <div class="container header-inner">
            <a class="brand" href="${a.home}">
                <img src="${a.logo}" alt="Auto Bridge">
            </a>
            <button class="nav-toggle" type="button" aria-label="Menu">Menu</button>
            <nav class="site-nav">
                ${nav.map(([label, href, key]) => `<a href="${href}"${key === active ? ' aria-current="page"' : ''}>${label}</a>`).join('\n                ')}
                <a class="btn btn-primary" href="${a.book}">Book now</a>
            </nav>
        </div>
    </header>
    <main>
        ${content}
    </main>
    <footer class="site-footer">
        <div class="container footer-grid">
            <div>
                <img class="footer-logo" src="${a.logo}" alt="Auto Bridge">
                <p>Auto Bridge is a car repair shop in Middleton, Christchurch. Open 24 hours for diagnostics, mechanical repairs, EV &amp; hybrid servicing and pre-purchase inspections.</p>
            </div>
            <div>
                <h4>Explore</h4>
                <a href="${a.services}">Services</a>
                <a href="${a.about}">About</a>
                <a href="${a.book}">Book now</a>
                <a href="${a.findUs}">Find us</a>
                <a href="${a.privacy}">Privacy</a>
            </div>
            <div>
                <h4>Workshop</h4>
                <p>${address}</p>
                <p><a href="tel:${phoneTel}">${phone}</a></p>
                <p><a href="mailto:${email}">${email}</a></p>
                <p><a href="${mapsUrl}" target="_blank" rel="noopener">Google Maps</a></p>
            </div>
            <div>
                <h4>Hours</h4>
                <p>Every day · Open 24 hours</p>
            </div>
        </div>
        <div class="container footer-bottom">
            <span>© ${year} Auto Bridge. All rights reserved.</span>
            <div class="socials"></div>
        </div>
    </footer>
    ${extra}
    <script src="${a.js}"></script>
</body>
</html>
`;
}

function serviceCards(linkFn, list = services) {
    return list.map((service) => `
                <article class="service-card">
                    <div class="media"><img src="${linkFn.img(service.image)}" alt="${service.title}"></div>
                    <div class="body">
                        <h3>${service.title}</h3>
                        <p>${service.short}</p>
                        <p class="price">Quote</p>
                        <a href="${linkFn.service(service.slug)}">View service →</a>
                    </div>
                </article>`).join('');
}

function write(rel, html) {
    const file = join(root, rel);
    mkdirSync(dirname(file), { recursive: true });
    writeFileSync(file, html.trim() + '\n');
}

const home = paths(0);
write('index.html', layout({
    title: 'Auto Bridge | Car Repair Shop, Middleton Christchurch',
    description: 'Auto Bridge is a 24-hour car repair shop at 11a Midas Place, Middleton, Christchurch. Diagnostics, repairs, EV & hybrid servicing and pre-purchase inspections.',
    active: 'home',
    extra: '<div class="lightbox"><img alt=""></div>',
    content: `
<section class="hero">
    <div class="hero-slide active" style="background-image:url('${home.img('hero-1.svg')}')">
        <div class="container hero-copy">
            <span>Auto Bridge · Middleton, Christchurch</span>
            <h1>Your local mechanic in Middleton, Christchurch</h1>
            <p>Your local mechanic for diagnostics, repairs, and EV &amp; hybrid servicing you can trust. Open 24 hours at 11a Midas Place.</p>
            <div class="hero-actions">
                <a class="btn btn-primary" href="${home.book}">Book now</a>
                <a class="btn btn-outline" href="${home.services}">View services</a>
            </div>
        </div>
    </div>
    <div class="hero-slide" style="background-image:url('${home.img('hero-2.svg')}')">
        <div class="container hero-copy">
            <span>Open 24 hours</span>
            <h1>Diagnostics, repairs and hybrid specialists</h1>
            <p>Engine diagnostics, mechanical repairs, brake and suspension, cooling, electrical faults, EV servicing and pre-purchase inspections.</p>
            <div class="hero-actions">
                <a class="btn btn-primary" href="${home.book}">Request a timeslot</a>
                <a class="btn btn-outline" href="tel:${phoneTel}">Call the workshop</a>
            </div>
        </div>
    </div>
    <div class="hero-dots"></div>
</section>
<section class="section">
    <div class="container">
        <div class="section-head">
            <h2>Our services</h2>
            <p class="muted">From diagnostics to EV servicing, we keep your vehicle running at its best with honest, precision care.</p>
        </div>
        <div class="grid-3">${serviceCards(home)}</div>
    </div>
</section>
<section class="section">
    <div class="container about-grid">
        <div class="prose">
            <h2>Best place for your auto care</h2>
            <p class="muted">A Middleton workshop combining modern diagnostics with practical mechanical expertise.</p>
            <p>Auto Bridge is a car repair shop at <strong>${address}</strong>. We combine modern diagnostic technology with practical mechanical expertise — from everyday cars to EV and hybrid systems.</p>
            <p>Our focus is safety, precision and long-term performance. Honest advice, transparent service, and workmanship you can trust. No upsells, no surprises. Clear quotes before any work begins.</p>
            <p>Find us on Google Maps or call <strong>${phone}</strong>. We are listed as open 24 hours.</p>
            <a class="btn btn-dark" href="${home.about}">About the workshop</a>
        </div>
        <div class="about-media">
            <img src="${home.img('about.svg')}" alt="Workshop">
        </div>
    </div>
</section>
<section class="section">
    <div class="container">
        <div class="section-head">
            <h2>Why Christchurch drivers choose Auto Bridge</h2>
            <p class="muted">Honest advice, transparent service and workmanship you can trust.</p>
        </div>
        <div class="grid-4">
            ${features.map(([title, desc]) => `<article class="feature-card"><h3>${title}</h3><p>${desc}</p></article>`).join('\n            ')}
        </div>
    </div>
</section>
<section class="stats-band">
    <div class="container grid-4">
        ${stats.map(([value, label]) => `<div class="stat"><strong>${value}</strong><span>${label}</span></div>`).join('\n        ')}
    </div>
</section>
<section class="brand-marquee">
    <div class="container section-head" style="margin-bottom:18px">
        <h2 style="color:#fff">All makes and models</h2>
        <p class="muted" style="color:#cbd5e1">European, Japanese, Korean, American and EV platforms.</p>
    </div>
    <div class="brand-track">
        ${[...makes, ...makes].map((make) => `<span>${make}</span>`).join('\n        ')}
    </div>
</section>
<section class="section">
    <div class="container">
        <div class="section-head">
            <h2>Technicians on the tools</h2>
            <p class="muted">Methodical, used to explaining the job in plain English.</p>
        </div>
        <div class="grid-3">
            ${team.map(([name, role, bio, photo]) => `
            <article class="team-card">
                <img src="${home.img(photo)}" alt="${name}">
                <h3>${name}</h3>
                <p class="muted">${role}</p>
                <p>${bio}</p>
            </article>`).join('')}
        </div>
    </div>
</section>
<section class="section reviews-section">
    <div class="container">
        <div class="section-head">
            <h2>What customers say after pickup</h2>
            <p class="muted">5.0 from 6 Google reviews for Auto Bridge in Middleton, Christchurch.</p>
        </div>
        <div class="review-slider" data-interval="5000">
            <button class="review-nav prev" type="button" aria-label="Previous review">‹</button>
            <div class="review-viewport">
                <div class="review-track">
                    ${testimonials.map(([name, vehicle, quote]) => `
                    <article class="quote-card">
                        <p class="quote-stars">★★★★★</p>
                        <p class="quote-text">${quote}</p>
                        <strong>${name}</strong>
                        <div class="muted">${vehicle}</div>
                    </article>`).join('')}
                </div>
            </div>
            <button class="review-nav next" type="button" aria-label="Next review">›</button>
            <div class="review-dots" aria-hidden="true"></div>
        </div>
        <p class="review-cta"><a class="btn btn-dark" href="${mapsUrl}" target="_blank" rel="noopener">Read Google reviews</a></p>
    </div>
</section>
<section class="section">
    <div class="container">
        <div class="section-head">
            <h2>Inside the workshop</h2>
            <p class="muted">Bays, tooling and jobs in progress at Midas Place.</p>
        </div>
        <div class="gallery-grid">
            ${gallery.map(([title, category, image]) => `
            <div class="gallery-item" data-full="${home.img(image)}" data-category="${category}">
                <img src="${home.img(image)}" alt="${title}">
                <span>${title}</span>
            </div>`).join('')}
        </div>
        <p style="margin-top:18px"><a class="btn btn-dark" href="${home.gallery}">Open gallery</a></p>
    </div>
</section>
<section class="section">
    <div class="container">
        <div class="section-head">
            <h2>Before you book</h2>
            <p class="muted">Straight answers on timing, quotes and what to bring.</p>
        </div>
        <div class="faq">
            ${faqs.map(([q, a]) => `<details><summary>${q}</summary><p>${a}</p></details>`).join('\n            ')}
        </div>
    </div>
</section>
<section class="cta-band">
    <div class="container">
        <h2>Ready when you are</h2>
        <p>Book a service or talk to the workshop today — we are open 24 hours.</p>
        <a class="btn btn-primary" href="${home.book}">Book now</a>
    </div>
</section>
`,
}));

write('about.html', layout({
    title: 'About | Auto Bridge Christchurch',
    description: 'Your local mechanic in Middleton, Christchurch — diagnostics, repairs, and EV & hybrid servicing.',
    active: 'about',
    content: `
<section class="page-hero">
    <div class="container">
        <h1>About the workshop</h1>
        <p>Your local mechanic in Middleton, Christchurch — diagnostics, repairs, and EV &amp; hybrid servicing.</p>
    </div>
</section>
<section class="section">
    <div class="container about-grid">
        <div class="prose">
            <h2>Best place for your auto care in Middleton.</h2>
            <p>Auto Bridge is a car repair shop at <strong>${address}</strong>. We combine modern diagnostic technology with practical mechanical expertise — from everyday cars to EV and hybrid systems.</p>
            <p>Our focus is safety, precision and long-term performance. Honest advice, transparent service, and workmanship you can trust. No upsells, no surprises. Clear quotes before any work begins.</p>
            <p>Find us on Google Maps or call <strong>${phone}</strong>. We are listed as open 24 hours.</p>
        </div>
        <div class="about-media">
            <img src="${home.img('about.svg')}" alt="About">
        </div>
    </div>
</section>
<section class="stats-band">
    <div class="container grid-4">
        ${stats.map(([value, label]) => `<div class="stat"><strong>${value}</strong><span>${label}</span></div>`).join('\n        ')}
    </div>
</section>
<section class="section">
    <div class="container">
        <div class="grid-4">
            ${features.map(([title, desc]) => `<article class="feature-card"><h3>${title}</h3><p>${desc}</p></article>`).join('\n            ')}
        </div>
    </div>
</section>
<section class="section">
    <div class="container">
        <h2>Technicians</h2>
        <div class="grid-3">
            ${team.map(([name, role, bio, photo]) => `
            <article class="team-card">
                <img src="${home.img(photo)}" alt="${name}">
                <h3>${name}</h3>
                <p class="muted">${role}</p>
                <p>${bio}</p>
            </article>`).join('')}
        </div>
    </div>
</section>
`,
}));

write('services.html', layout({
    title: 'Services | Auto Bridge Christchurch',
    description: 'Diagnostics, repairs, EV & hybrid servicing and pre-purchase inspections at Auto Bridge, Middleton.',
    active: 'services',
    content: `
<section class="page-hero"><div class="container"><h1>Services</h1><p>Licensed automotive repair and servicing.</p></div></section>
<section class="section">
    <div class="container grid-3">${serviceCards(home)}</div>
</section>
`,
}));

write('gallery.html', layout({
    title: 'Gallery | Auto Bridge Christchurch',
    description: 'Workshop, tooling and jobs in progress at Auto Bridge, Midas Place, Middleton.',
    active: 'gallery',
    extra: '<div class="lightbox"><img alt=""></div>',
    content: `
<section class="page-hero"><div class="container"><h1>Gallery</h1><p>Workshop, tooling and jobs in progress.</p></div></section>
<section class="section">
    <div class="container">
        <div class="filters">
            <button class="chip active" type="button" data-filter="all">All</button>
            <button class="chip" type="button" data-filter="workshop">Workshop</button>
            <button class="chip" type="button" data-filter="repairs">Repairs</button>
        </div>
        <div class="gallery-grid">
            ${gallery.map(([title, category, image]) => `
            <div class="gallery-item" data-category="${category}" data-full="${home.img(image)}">
                <img src="${home.img(image)}" alt="${title}">
                <span>${title}</span>
            </div>`).join('')}
        </div>
    </div>
</section>
`,
}));

write('faq.html', layout({
    title: 'FAQ | Auto Bridge Christchurch',
    description: 'Straight answers before you book a bay at Auto Bridge in Middleton, Christchurch.',
    active: 'faq',
    content: `
<section class="page-hero"><div class="container"><h1>FAQ</h1><p>Straight answers before you book a bay.</p></div></section>
<section class="section">
    <div class="container faq">
        ${faqs.map(([q, a]) => `<details><summary>${q}</summary><p>${a}</p></details>`).join('\n        ')}
    </div>
</section>
`,
}));

write('contact.html', layout({
    title: 'Contact | Auto Bridge Christchurch',
    description: 'Call, visit or send a message. Auto Bridge, 11a Midas Place, Middleton, Christchurch — open 24 hours.',
    active: 'contact',
    content: `
<section class="page-hero"><div class="container"><h1>Contact</h1><p>Call, visit or send a message. Find us at 11a Midas Place, Middleton, Christchurch — open 24 hours.</p></div></section>
<section class="section">
    <div class="container split">
        <form class="form-card" data-mailto="contact" data-subject="Website message">
            <label>Name</label>
            <input name="name" required>
            <div class="form-grid">
                <div>
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
                <div>
                    <label>Phone</label>
                    <input name="phone">
                </div>
            </div>
            <label>Subject</label>
            <input name="subject">
            <label>Message</label>
            <textarea name="message" required></textarea>
            <button class="btn btn-primary" type="submit" style="margin-top:16px">Send message</button>
        </form>
        <div>
            <div class="feature-card">
                <h3>Workshop</h3>
                <p>${address}</p>
                <p><a href="tel:${phoneTel}">${phone}</a></p>
                <p><a href="mailto:${email}">${email}</a></p>
                <p><a href="${mapsUrl}" target="_blank" rel="noopener">Open in Google Maps</a></p>
                <p>Open 24 hours</p>
            </div>
            <div style="margin-top:18px;border-radius:16px;overflow:hidden;min-height:240px">
                <iframe src="${mapEmbed}" width="100%" height="260" style="border:0" loading="lazy"></iframe>
            </div>
        </div>
    </div>
</section>
`,
}));

write('book.html', layout({
    title: 'Book a bay | Auto Bridge Christchurch',
    description: 'Choose a service, share a few vehicle details and we will confirm a workshop timeslot. Auto Bridge is open 24 hours.',
    active: 'book',
    content: `
<section class="page-hero"><div class="container"><h1>Book a bay</h1><p>Choose a service, share a few vehicle details and we will confirm a workshop timeslot. Auto Bridge is open 24 hours.</p></div></section>
<section class="section">
    <div class="container" style="max-width:820px">
        <form class="form-card" data-mailto="booking" data-subject="Booking request">
            <div class="form-grid">
                <div><label>Name</label><input name="name" required></div>
                <div><label>Email</label><input type="email" name="email" required></div>
                <div><label>Phone</label><input name="phone" required></div>
                <div>
                    <label>Service</label>
                    <select name="service">
                        <option value="">General enquiry</option>
                        ${services.map((s) => `<option value="${s.title}">${s.title}</option>`).join('\n                        ')}
                    </select>
                </div>
                <div><label>Vehicle make</label><input name="vehicle_make"></div>
                <div><label>Vehicle model</label><input name="vehicle_model"></div>
                <div><label>Year</label><input name="vehicle_year"></div>
                <div><label>Preferred date</label><input type="date" name="preferred_date"></div>
                <div><label>Preferred time</label><input name="preferred_time" placeholder="e.g. 9:00am"></div>
            </div>
            <label>Notes</label>
            <textarea name="message"></textarea>
            <button class="btn btn-primary" type="submit" style="margin-top:16px">Request booking</button>
        </form>
    </div>
</section>
`,
}));

write('find-us.html', layout({
    title: 'Find us | Auto Bridge Christchurch',
    description: 'Auto Bridge car repair shop, 11a Midas Place, Middleton, Christchurch 8024. Open 24 hours. Phone +64 29 020 16792.',
    active: 'contact',
    content: `
<section class="page-hero"><div class="container"><h1>Find Auto Bridge</h1></div></section>
<section class="section">
    <div class="container prose" style="max-width:860px">
        <p><strong>Auto Bridge</strong> is a car repair shop in Middleton, Christchurch.</p>
        <p><strong>Address:</strong> ${address}<br>
        <strong>Phone:</strong> <a href="tel:${phoneTel}">${phone}</a><br>
        <strong>Hours:</strong> Open 24 hours<br>
        <strong>Category:</strong> Car repair shop · Wheelchair accessible</p>
        <p><a href="${mapsUrl}" target="_blank" rel="noopener">Open in Google Maps</a></p>
        <p>Services: diagnostics and repairs, EV &amp; hybrid specialists, and pre-purchase inspections. We do not offer WOF inspections.</p>
        <div style="margin-top:18px;border-radius:16px;overflow:hidden;min-height:240px">
            <iframe src="${mapEmbed}" width="100%" height="320" style="border:0" loading="lazy"></iframe>
        </div>
    </div>
</section>
`,
}));

write('privacy.html', layout({
    title: 'Privacy | Auto Bridge Christchurch',
    description: 'How Auto Bridge handles booking and contact details.',
    active: '',
    content: `
<section class="page-hero"><div class="container"><h1>Privacy</h1></div></section>
<section class="section">
    <div class="container prose" style="max-width:860px">
        <p>Booking and contact forms collect your name, contact details and vehicle information so Auto Bridge can respond to your request. We do not sell this information. You can ask us to delete a stored enquiry by calling the workshop on ${phone}.</p>
    </div>
</section>
`,
}));

services.forEach((service, index) => {
    const nested = paths(1);
    const others = services.filter((_, i) => i !== index).slice(0, 3);
    write(`services/${service.slug}.html`, layout({
        title: `${service.title} | Auto Bridge`,
        description: service.short,
        depth: 1,
        active: 'services',
        content: `
<section class="page-hero"><div class="container"><h1>${service.title}</h1><p>${service.short}</p></div></section>
<section class="section">
    <div class="container split">
        <div class="prose">
            ${service.html}
            <p>We quote before extra work and only proceed with your approval. Visit Auto Bridge at 11a Midas Place, Middleton, or call ${phone} — open 24 hours.</p>
            <p class="price">Quote</p>
            <a class="btn btn-primary" href="${nested.book}">Book this service</a>
        </div>
        <div class="about-media">
            <img src="${nested.img(service.image)}" alt="${service.title}">
        </div>
    </div>
</section>
<section class="section">
    <div class="container">
        <h2>Related services</h2>
        <div class="grid-3">
            ${others.map((item) => `
            <article class="service-card">
                <div class="body">
                    <h3>${item.title}</h3>
                    <p>${item.short}</p>
                    <a href="${nested.service(item.slug)}">View →</a>
                </div>
            </article>`).join('')}
        </div>
    </div>
</section>
`,
    }));
});

console.log('Static pages written.');
