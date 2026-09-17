<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\GalleryItem;
use App\Models\HeroSlide;
use App\Models\HomepageSection;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Stat;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\WorkingHour;
use App\Support\Settings;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->where('email', 'admin@ashenauto.com')->update([
            'email' => 'admin@autobridge.co.nz',
            'name' => 'Auto Bridge Admin',
            'phone' => '+64 29 020 16792',
        ]);

        User::query()->updateOrCreate(
            ['email' => 'admin@autobridge.co.nz'],
            [
                'name' => 'Auto Bridge Admin',
                'password' => 'Admin@123',
                'is_admin' => true,
                'phone' => '+64 29 020 16792',
            ]
        );

        $settings = [
            'site_name' => ['Auto Bridge', 'general', 'text'],
            'tagline' => ['Your local mechanic in Middleton, Christchurch — diagnostics, repairs, and EV & hybrid servicing.', 'general', 'text'],
            'logo' => ['/images/logo.jpg', 'general', 'image'],
            'favicon' => ['/images/logo.jpg', 'general', 'image'],
            'topbar_enabled' => ['1', 'general', 'boolean'],
            'topbar_text' => ['Open 24 hours · 11a Midas Place, Middleton, Christchurch', 'general', 'text'],
            'phone' => ['+64 29 020 16792', 'contact', 'text'],
            'email' => ['service@autobridge.co.nz', 'contact', 'text'],
            'address' => ['11a Midas Place, Middleton, Christchurch 8024, New Zealand', 'contact', 'text'],
            'whatsapp' => ['642902016792', 'contact', 'text'],
            'map_embed' => ['https://maps.google.com/maps?q=-43.5419295,172.5818326&hl=en&z=17&output=embed', 'contact', 'textarea'],
            'google_maps_url' => ['https://www.google.com/maps/place/Auto+Bridge/@-43.5419295,172.5818326,553m/data=!3m1!1e3!4m6!3m5!1s0x6d31f559b16c7ad1:0x51f12fe80e2e3e07!8m2!3d-43.5419295!4d172.5818326!16s%2Fg%2F11y_gwd7lm?entry=ttu&g_ep=EgoyMDI2MDkxNS4wIKXMDSoASAFQAw%3D%3D', 'contact', 'text'],
            'plus_code' => ['FH5J+6P Christchurch, New Zealand', 'contact', 'text'],
            'facebook' => ['', 'social', 'text'],
            'instagram' => ['', 'social', 'text'],
            'youtube' => ['', 'social', 'text'],
            'twitter' => ['', 'social', 'text'],
            'primary_color' => ['#c9a227', 'appearance', 'color'],
            'secondary_color' => ['#111111', 'appearance', 'color'],
            'accent_color' => ['#e8c547', 'appearance', 'color'],
            'background_color' => ['#f4f1ea', 'appearance', 'color'],
            'surface_color' => ['#ffffff', 'appearance', 'color'],
            'text_color' => ['#111111', 'appearance', 'color'],
            'muted_color' => ['#6b7280', 'appearance', 'color'],
            'header_background' => ['#0a0a0a', 'appearance', 'color'],
            'footer_background' => ['#0a0a0a', 'appearance', 'color'],
            'heading_font' => ['Oswald', 'appearance', 'text'],
            'body_font' => ['Barlow', 'appearance', 'text'],
            'button_radius' => ['6', 'appearance', 'text'],
            'hero_overlay' => ['0.55', 'appearance', 'text'],
            'meta_title' => ['Auto Bridge | Car Repair Shop, Middleton Christchurch', 'seo', 'text'],
            'meta_description' => ['Auto Bridge is a 24-hour car repair shop at 11a Midas Place, Middleton, Christchurch. Diagnostics, repairs, EV & hybrid servicing and pre-purchase inspections.', 'seo', 'textarea'],
            'copyright_text' => ['© '.date('Y').' Auto Bridge. All rights reserved.', 'seo', 'text'],
            'footer_about' => ['Auto Bridge is a car repair shop in Middleton, Christchurch. Open 24 hours for diagnostics, mechanical repairs, EV & hybrid servicing and pre-purchase inspections.', 'seo', 'textarea'],
            'about_heading' => ['Best place for your auto care in Middleton.', 'content', 'text'],
            'about_content' => ['<p>Auto Bridge is a car repair shop at <strong>11a Midas Place, Middleton, Christchurch 8024</strong>. We combine modern diagnostic technology with practical mechanical expertise — from everyday cars to EV and hybrid systems.</p><p>Our focus is safety, precision and long-term performance. Honest advice, transparent service, and workmanship you can trust. No upsells, no surprises. Clear quotes before any work begins.</p><p>Find us on Google Maps (Plus Code <strong>FH5J+6P</strong>) or call <strong>+64 29 020 16792</strong>. We are listed as open 24 hours.</p>', 'content', 'textarea'],
            'about_image' => ['/images/about.svg', 'content', 'image'],
            'cta_heading' => ['Book a service. We will take it from there.', 'content', 'text'],
            'cta_text' => ['Tell us the vehicle, the symptom and a preferred time. Open 24 hours at 11a Midas Place, Middleton.', 'content', 'textarea'],
            'cta_button_label' => ['Book now', 'content', 'text'],
            'cta_button_url' => ['/book', 'content', 'text'],
            'booking_intro' => ['Choose a service, share a few vehicle details and we will confirm a workshop timeslot. Auto Bridge is open 24 hours.', 'content', 'textarea'],
            'contact_intro' => ['Call, visit or send a message. Find us at 11a Midas Place, Middleton, Christchurch — open 24 hours.', 'content', 'textarea'],
            'makes_we_service' => ['Alfa Romeo, Audi, BMW, BYD, Chery, Dodge, Ferrari, Fiat, Ford, Honda, Hyundai, Isuzu, Iveco, Jaguar, Jeep, Kia, Lexus, Mazda, MG, Mini, Mitsubishi, Nissan, Peugeot, Porsche, Renault, Subaru, Suzuki, Tesla, Toyota, Volkswagen', 'content', 'textarea'],
        ];

        foreach ($settings as $key => [$value, $group, $type]) {
            SiteSetting::query()->updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'group' => $group, 'type' => $type]
            );
        }

        app(Settings::class)->flush();

        MenuItem::query()->delete();
        $menus = [
            ['Home', '/', 'header', 1],
            ['Services', '/services', 'header', 2],
            ['About', '/about', 'header', 3],
            ['Gallery', '/gallery', 'header', 4],
            ['FAQ', '/faq', 'header', 5],
            ['Contact', '/contact', 'header', 6],
            ['Services', '/services', 'footer', 1],
            ['About', '/about', 'footer', 2],
            ['Book now', '/book', 'footer', 3],
            ['Find us', '/p/find-us', 'footer', 4],
            ['Privacy', '/p/privacy', 'footer', 5],
        ];

        foreach ($menus as [$label, $url, $location, $order]) {
            MenuItem::query()->create([
                'label' => $label,
                'url' => $url,
                'location' => $location,
                'sort_order' => $order,
                'is_active' => true,
            ]);
        }

        HeroSlide::query()->delete();
        HeroSlide::query()->create([
            'title' => 'Your local mechanic in Middleton, Christchurch',
            'subtitle' => 'Auto Bridge · Middleton, Christchurch',
            'description' => 'Your local mechanic for diagnostics, repairs, and EV & hybrid servicing you can trust. Open 24 hours at 11a Midas Place.',
            'image' => '/images/hero-1.svg',
            'cta_text' => 'Book now',
            'cta_url' => '/book',
            'secondary_cta_text' => 'View services',
            'secondary_cta_url' => '/services',
            'sort_order' => 1,
            'is_active' => true,
        ]);
        HeroSlide::query()->create([
            'title' => 'Diagnostics, repairs and hybrid specialists',
            'subtitle' => 'Open 24 hours',
            'description' => 'Engine diagnostics, mechanical repairs, brake and suspension, cooling, electrical faults, EV servicing and pre-purchase inspections.',
            'image' => '/images/hero-2.svg',
            'cta_text' => 'Request a timeslot',
            'cta_url' => '/book',
            'secondary_cta_text' => 'Call the workshop',
            'secondary_cta_url' => 'tel:+642902016792',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $sectionDefs = [
            ['hero', 'Hero slider', '', '', 1],
            ['services', 'Services', 'Our services', 'From diagnostics to EV servicing, we keep your vehicle running at its best with honest, precision care.', 2],
            ['about', 'About', 'Best place for your auto care', 'A Middleton workshop combining modern diagnostics with practical mechanical expertise.', 3],
            ['features', 'Why choose us', 'Why Christchurch drivers choose Auto Bridge', 'Honest advice, transparent service and workmanship you can trust.', 4],
            ['stats', 'Stats', '', '', 5],
            ['brands', 'Makes we service', 'All makes and models', 'European, Japanese, Korean, American and EV platforms.', 6],
            ['team', 'Team', 'Technicians on the tools', 'Methodical, used to explaining the job in plain English.', 7],
            ['testimonials', 'Testimonials', 'What customers say after pickup', '5.0 from 6 Google reviews for Auto Bridge in Middleton, Christchurch.', 8],
            ['gallery', 'Gallery', 'Inside the workshop', 'Bays, tooling and jobs in progress at Midas Place.', 9],
            ['faq', 'FAQ', 'Before you book', 'Straight answers on timing, quotes and what to bring.', 10],
            ['cta', 'Call to action', 'Ready when you are', 'Book a service or talk to the workshop today — we are open 24 hours.', 11],
        ];

        foreach ($sectionDefs as [$key, $label, $heading, $sub, $order]) {
            HomepageSection::query()->updateOrCreate(
                ['key' => $key],
                ['label' => $label, 'heading' => $heading, 'subheading' => $sub, 'is_enabled' => true, 'sort_order' => $order]
            );
        }

        Booking::query()->delete();
        Service::query()->delete();

        $services = [
            ['Diagnostics & Repairs', 'Advanced vehicle repairs and fault diagnostics to keep your car performing at its best.', 'Quote', 'search', 1, true, '<p>Advanced vehicle repairs and fault diagnostics to keep your car performing at its best.</p><ul><li>Engine diagnostics</li><li>Mechanical repairs</li><li>Brake &amp; suspension</li><li>Cooling systems</li><li>Electrical faults</li></ul>'],
            ['EV & Hybrid Specialists', 'Specialist EV and hybrid mechanic, providing servicing and diagnostics using modern technology.', 'Quote', 'battery', 2, true, '<p>Specialist EV and hybrid servicing and diagnostics using modern technology.</p><ul><li>Hybrid system diagnostics</li><li>EV servicing</li><li>Battery health checks</li><li>Hybrid repairs</li></ul>'],
            ['Pre-Purchase Inspections', 'Detailed pre-purchase vehicle inspections to give you confidence and clarity before you buy.', 'Quote', 'clipboard', 3, true, '<p>Detailed pre-purchase vehicle inspections to give you confidence and clarity before you buy.</p><ul><li>Pre-purchase inspections</li><li>Buyer reports</li><li>Fleet checks</li></ul>'],
            ['Engine diagnostics', 'Scan and live-data diagnosis for warning lights, misfires and poor running.', 'Quote', 'cpu', 4, true, '<p>Scan and live-data diagnosis for warning lights, misfires and poor running.</p>'],
            ['Mechanical repairs', 'Clutches, exhausts, driveline and general mechanical work for all makes and models.', 'Quote', 'cog', 5, true, '<p>Clutches, exhausts, driveline and general mechanical work for all makes and models.</p>'],
            ['Brake & suspension', 'Pads, rotors, shocks, bushes and steering repairs — measured, not guessed.', 'Quote', 'disc', 6, true, '<p>Pads, rotors, shocks, bushes and steering repairs — measured, not guessed.</p>'],
            ['Cooling systems', 'Overheating, radiator, thermostat and water-pump diagnosis and repair.', 'Quote', 'snowflake', 7, true, '<p>Overheating, radiator, thermostat and water-pump diagnosis and repair.</p>'],
            ['Electrical faults', 'Starting, charging, lighting, sensors and aftermarket wiring faults.', 'Quote', 'bolt', 8, true, '<p>Starting, charging, lighting, sensors and aftermarket wiring faults.</p>'],
            ['Battery health checks', 'Load-tested batteries, hybrid/EV battery health and charging-system checks.', 'Quote', 'battery', 9, true, '<p>Load-tested batteries, hybrid/EV battery health and charging-system checks.</p>'],
        ];

        foreach ($services as $i => [$title, $short, $price, $icon, $order, $featured, $html]) {
            Service::query()->create([
                'title' => $title,
                'slug' => Str::slug($title),
                'icon' => $icon,
                'image' => '/images/service-'.($i + 1).'.svg',
                'short_description' => $short,
                'description' => $html.'<p>We quote before extra work and only proceed with your approval. Visit Auto Bridge at 11a Midas Place, Middleton, or call +64 29 020 16792 — open 24 hours.</p>',
                'price_label' => $price,
                'is_featured' => $featured,
                'is_active' => true,
                'sort_order' => $order,
            ]);
        }

        Feature::query()->delete();
        foreach ([
            ['Professional & expert', 'Modern diagnostic technology with practical mechanical expertise — everyday cars through to EV and hybrid systems.', 'shield'],
            ['Honesty', 'No upsells, no surprises. Clear quotes before any work begins.', 'file'],
            ['Quality', 'OEM-grade parts and meticulous workmanship on every job.', 'tool'],
            ['Trust', 'A 5.0-rated Christchurch car repair shop, open 24 hours when you need us.', 'star'],
        ] as $i => [$title, $desc, $icon]) {
            Feature::query()->create([
                'title' => $title,
                'description' => $desc,
                'icon' => $icon,
                'is_active' => true,
                'sort_order' => $i + 1,
            ]);
        }

        Stat::query()->delete();
        foreach ([
            ['24/7', 'Open hours', 'clock'],
            ['5.0', 'Google rating', 'star'],
            ['3', 'Core service streams', 'grid'],
            ['All', 'Makes & models', 'car'],
        ] as $i => [$value, $label, $icon]) {
            Stat::query()->create([
                'value' => $value,
                'label' => $label,
                'icon' => $icon,
                'is_active' => true,
                'sort_order' => $i + 1,
            ]);
        }

        TeamMember::query()->delete();
        foreach ([
            ['Workshop team', 'Mechanical repairs', 'Diagnostics, brakes, suspension, cooling and general mechanical work at the Middleton workshop.', '/images/team-1.svg'],
            ['EV & hybrid', 'Specialist servicing', 'Hybrid system diagnostics, EV servicing, battery health checks and hybrid repairs.', '/images/team-2.svg'],
            ['Service desk', 'Bookings & quotes', 'Call +64 29 020 16792 anytime — Auto Bridge is listed as open 24 hours.', '/images/team-3.svg'],
        ] as $i => [$name, $role, $bio, $photo]) {
            TeamMember::query()->create([
                'name' => $name,
                'role' => $role,
                'bio' => $bio,
                'photo' => $photo,
                'is_active' => true,
                'sort_order' => $i + 1,
            ]);
        }

        Testimonial::query()->delete();
        foreach ([
            ['yu bb', 'Google review', 'The mechanic was very patient and thorough when checking my car. Really appreciate his help and would definitely recommend him!', 5],
            ['Trevor Keohane', 'Toyota RAV4 · Google review', 'I recently had the steering rack and gearbox replaced on my Toyota RAV4 by Auto Bridge Automotive and couldn\'t be happier with the service. The team was friendly, professional, and kept me informed throughout the process. I especially appreciated them dropping my car off at home when the work was completed, which made things so much easier. Great customer service and quality workmanship. I\'ll definitely be using Auto Bridge Automotive for all my future servicing and maintenance. Highly recommended!', 5],
            ['Garry', 'Google review', 'These guys are the real deal, had problems with my trailer lights which they solved very quickly. Highly recommend to try out this business.', 5],
            ['Thomas Devereux', 'Google review', 'Great customer service. Came very quick and fixed my car within an hour of contacting them and extremely well priced!', 5],
            ['Oli Stewart', 'Audi S3 · Google review', 'Had a great experience with Auto Bridge. They worked around my schedule and got my Audi S3 fixed very quickly after I reached out. The team was careful, polite, and the pricing was fantastic—a level above those expensive auto shops and dealerships. Haven’t had any issues since the ignition barrel replacement—highly recommend!', 5],
            ['Dj Crax', 'Google review', 'Amazing and really impressive service at genuine pricing.. Highly recommended', 5],
        ] as $i => [$name, $vehicle, $content, $rating]) {
            Testimonial::query()->create([
                'customer_name' => $name,
                'vehicle' => $vehicle,
                'content' => $content,
                'rating' => $rating,
                'is_active' => true,
                'sort_order' => $i + 1,
            ]);
        }

        GalleryItem::query()->delete();
        foreach ([
            ['Diagnostics bay', 'workshop', '/images/gallery-1.svg'],
            ['Mechanical repairs', 'repairs', '/images/gallery-2.svg'],
            ['EV & hybrid work', 'workshop', '/images/gallery-3.svg'],
            ['Battery health check', 'repairs', '/images/gallery-4.svg'],
            ['Workshop floor, Midas Place', 'workshop', '/images/gallery-5.svg'],
            ['Cooling system service', 'repairs', '/images/gallery-6.svg'],
        ] as $i => [$title, $category, $image]) {
            GalleryItem::query()->create([
                'title' => $title,
                'category' => $category,
                'image' => $image,
                'caption' => $title,
                'is_active' => true,
                'sort_order' => $i + 1,
            ]);
        }

        Faq::query()->delete();
        foreach ([
            ['Do I need an appointment?', 'Booking is preferred so we can put you in a bay. Call +64 29 020 16792 — Auto Bridge is listed as open 24 hours at 11a Midas Place, Middleton.'],
            ['How do quotes work?', 'Inspection and diagnosis come first. We then send a written quote. Extra work is not started without your approval. No upsells, no surprises.'],
            ['Do you do WOF inspections?', 'No. We do not offer WOF or compliance inspections. We focus on diagnostics, repairs, EV & hybrid servicing and pre-purchase inspections.'],
            ['Can you service EV and hybrid vehicles?', 'Yes. We provide hybrid system diagnostics, EV servicing, battery health checks and hybrid repairs using modern diagnostic equipment.'],
            ['Which makes do you work on?', 'All common makes and models — European, Japanese, Korean, American and EV platforms including Tesla, BYD, Toyota, Ford, BMW and more.'],
            ['Where are you?', '11a Midas Place, Middleton, Christchurch 8024, New Zealand. Plus Code FH5J+6P. Wheelchair accessible. View the listing on Google Maps.'],
        ] as $i => [$q, $a]) {
            Faq::query()->create([
                'question' => $q,
                'answer' => $a,
                'is_active' => true,
                'sort_order' => $i + 1,
            ]);
        }

        WorkingHour::query()->delete();
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        foreach ($days as $i => $name) {
            WorkingHour::query()->create([
                'day_of_week' => $i === 6 ? 0 : $i + 1,
                'day_name' => $name,
                'open_time' => '00:00',
                'close_time' => '24:00',
                'is_closed' => false,
                'sort_order' => $i + 1,
            ]);
        }

        Page::query()->where('slug', 'repairer-licence')->delete();
        Page::query()->updateOrCreate(
            ['slug' => 'find-us'],
            [
                'title' => 'Find Auto Bridge',
                'is_published' => true,
                'meta_title' => 'Find us | Auto Bridge Christchurch',
                'meta_description' => 'Auto Bridge car repair shop, 11a Midas Place, Middleton, Christchurch 8024. Open 24 hours. Phone +64 29 020 16792.',
                'content' => '<p><strong>Auto Bridge</strong> is a car repair shop in Middleton, Christchurch.</p><p><strong>Address:</strong> 11a Midas Place, Middleton, Christchurch 8024, New Zealand<br><strong>Phone:</strong> <a href="tel:+642902016792">+64 29 020 16792</a><br><strong>Hours:</strong> Open 24 hours<br><strong>Plus Code:</strong> FH5J+6P Christchurch, New Zealand<br><strong>Category:</strong> Car repair shop · Wheelchair accessible</p><p><a href="https://www.google.com/maps/place/Auto+Bridge/@-43.5419295,172.5818326,553m/data=!3m1!1e3!4m6!3m5!1s0x6d31f559b16c7ad1:0x51f12fe80e2e3e07!8m2!3d-43.5419295!4d172.5818326!16s%2Fg%2F11y_gwd7lm?entry=ttu&g_ep=EgoyMDI2MDkxNS4wIKXMDSoASAFQAw%3D%3D" target="_blank" rel="noopener">Open in Google Maps</a></p><p>Services: diagnostics and repairs, EV &amp; hybrid specialists, and pre-purchase inspections. We do not offer WOF inspections.</p>',
            ]
        );

        Page::query()->updateOrCreate(
            ['slug' => 'privacy'],
            [
                'title' => 'Privacy',
                'is_published' => true,
                'content' => '<p>Booking and contact forms collect your name, contact details and vehicle information so Auto Bridge can respond to your request. We do not sell this information. You can ask us to delete a stored enquiry by calling the workshop on +64 29 020 16792.</p>',
            ]
        );
    }
}
