<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\HandlesMedia;
use App\Support\Settings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    use HandlesMedia;

    public function index(Request $request): View
    {
        $tab = $request->get('tab', 'general');

        return view('admin.settings.index', [
            'tab' => $tab,
            'fonts' => [
                'Oswald', 'Barlow', 'Montserrat', 'Poppins', 'Inter', 'Roboto',
                'Rajdhani', 'Teko', 'Outfit', 'Playfair Display', 'Source Sans 3',
            ],
        ]);
    }

    public function update(Request $request, Settings $settings): RedirectResponse
    {
        $tab = $request->input('tab', 'general');

        $fields = match ($tab) {
            'appearance' => [
                'primary_color', 'secondary_color', 'accent_color', 'background_color',
                'surface_color', 'text_color', 'muted_color', 'header_background',
                'footer_background', 'heading_font', 'body_font', 'button_radius',
                'hero_overlay',
            ],
            'contact' => [
                'phone', 'email', 'address', 'map_embed', 'whatsapp', 'google_maps_url', 'plus_code',
            ],
            'social' => [
                'facebook', 'instagram', 'youtube', 'twitter',
            ],
            'seo' => [
                'meta_title', 'meta_description', 'copyright_text', 'footer_about',
            ],
            'content' => [
                'about_heading', 'about_content', 'cta_heading', 'cta_text',
                'cta_button_label', 'cta_button_url', 'booking_intro', 'contact_intro',
                'topbar_text', 'makes_we_service',
            ],
            default => [
                'site_name', 'tagline', 'topbar_text',
            ],
        };

        foreach ($fields as $field) {
            if ($request->has($field)) {
                $type = str_contains($field, 'color') ? 'color' : (str_contains($field, 'content') || str_contains($field, 'embed') || str_contains($field, 'intro') || str_contains($field, 'about') ? 'textarea' : 'text');
                $settings->put($field, $request->input($field), $tab, $type);
            }
        }

        if ($tab === 'general') {
            $settings->put('topbar_enabled', $request->boolean('topbar_enabled'), 'general', 'boolean');
            $logo = $this->uploadImage($request, 'logo', 'branding', setting('logo'));
            $favicon = $this->uploadImage($request, 'favicon', 'branding', setting('favicon'));
            if ($request->hasFile('logo')) {
                $settings->put('logo', $logo, 'general', 'image');
            }
            if ($request->hasFile('favicon')) {
                $settings->put('favicon', $favicon, 'general', 'image');
            }
        }

        if ($tab === 'content' && $request->hasFile('about_image')) {
            $aboutImage = $this->uploadImage($request, 'about_image', 'content', setting('about_image'));
            $settings->put('about_image', $aboutImage, 'content', 'image');
        }

        return back()->with('success', 'Settings saved. The live website will use these changes immediately.');
    }
}
