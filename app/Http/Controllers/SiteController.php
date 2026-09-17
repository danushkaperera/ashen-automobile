<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Feature;
use App\Models\GalleryItem;
use App\Models\HeroSlide;
use App\Models\HomepageSection;
use App\Models\Page;
use App\Models\Service;
use App\Models\Stat;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\WorkingHour;
use Illuminate\View\View;

class SiteController extends Controller
{
    public function home(): View
    {
        $sections = HomepageSection::ordered()->get()->keyBy('key');

        return view('public.home', [
            'sections' => $sections,
            'slides' => HeroSlide::active()->get(),
            'services' => Service::active()->get(),
            'features' => Feature::active()->get(),
            'stats' => Stat::active()->get(),
            'team' => TeamMember::active()->get(),
            'testimonials' => Testimonial::active()->get(),
            'gallery' => GalleryItem::active()->take(8)->get(),
            'faqs' => Faq::active()->get(),
        ]);
    }

    public function about(): View
    {
        return view('public.about', [
            'team' => TeamMember::active()->get(),
            'features' => Feature::active()->get(),
            'stats' => Stat::active()->get(),
            'hours' => WorkingHour::ordered()->get(),
        ]);
    }

    public function services(): View
    {
        return view('public.services', [
            'services' => Service::active()->get(),
        ]);
    }

    public function service(Service $service): View
    {
        abort_unless($service->is_active, 404);

        return view('public.service', [
            'service' => $service,
            'others' => Service::active()->where('id', '!=', $service->id)->take(3)->get(),
        ]);
    }

    public function gallery(): View
    {
        $items = GalleryItem::active()->get();

        return view('public.gallery', [
            'items' => $items,
            'categories' => $items->pluck('category')->filter()->unique()->values(),
        ]);
    }

    public function faq(): View
    {
        return view('public.faq', [
            'faqs' => Faq::active()->get(),
        ]);
    }

    public function contact(): View
    {
        return view('public.contact', [
            'hours' => WorkingHour::ordered()->get(),
        ]);
    }

    public function booking(): View
    {
        return view('public.booking', [
            'services' => Service::active()->get(),
        ]);
    }

    public function page(Page $page): View
    {
        abort_unless($page->is_published, 404);

        return view('public.page', compact('page'));
    }
}
