@extends('layouts.admin')
@section('title', 'Site settings')
@section('content')
<div class="tabs">
    @foreach(['general'=>'General','appearance'=>'Appearance','content'=>'Homepage copy','contact'=>'Contact','social'=>'Social','seo'=>'SEO & footer'] as $key => $label)
        <a class="{{ $tab === $key ? 'active' : '' }}" href="{{ route('admin.settings.index', ['tab' => $key]) }}">{{ $label }}</a>
    @endforeach
</div>
<form class="card" method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <input type="hidden" name="tab" value="{{ $tab }}">

    @if($tab === 'general')
        <label>Site name</label>
        <input name="site_name" value="{{ setting('site_name') }}">
        <label>Tagline</label>
        <input name="tagline" value="{{ setting('tagline') }}">
        <label>Top bar text</label>
        <input name="topbar_text" value="{{ setting('topbar_text') }}">
        <label class="check"><input type="checkbox" name="topbar_enabled" value="1" @checked(setting('topbar_enabled'))> Show top bar</label>
        <label>Logo</label>
        <input type="file" name="logo" accept="image/*">
        @if(setting('logo'))<img class="thumb" src="{{ media_url(setting('logo')) }}" alt="Logo">@endif
        <label>Favicon</label>
        <input type="file" name="favicon" accept="image/*">
    @elseif($tab === 'appearance')
        <p class="help">These colours and fonts update the live website immediately.</p>
        @foreach([
            'primary_color'=>'Primary',
            'secondary_color'=>'Secondary',
            'accent_color'=>'Accent',
            'background_color'=>'Page background',
            'surface_color'=>'Card background',
            'text_color'=>'Text',
            'muted_color'=>'Muted text',
            'header_background'=>'Header',
            'footer_background'=>'Footer',
        ] as $key => $label)
            <label>{{ $label }}</label>
            <div class="color-row">
                <input type="color" value="{{ setting($key, '#000000') }}" oninput="this.nextElementSibling.value=this.value">
                <input name="{{ $key }}" value="{{ setting($key) }}">
            </div>
        @endforeach
        <div class="form-grid">
            <div>
                <label>Heading font</label>
                <select name="heading_font">
                    @foreach($fonts as $font)
                        <option value="{{ $font }}" @selected(setting('heading_font') === $font)>{{ $font }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label>Body font</label>
                <select name="body_font">
                    @foreach($fonts as $font)
                        <option value="{{ $font }}" @selected(setting('body_font') === $font)>{{ $font }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label>Button radius (px)</label>
                <input name="button_radius" value="{{ setting('button_radius', 6) }}">
            </div>
            <div>
                <label>Hero overlay (0–1)</label>
                <input name="hero_overlay" value="{{ setting('hero_overlay', '0.55') }}">
            </div>
        </div>
    @elseif($tab === 'content')
        <label>About heading</label>
        <input name="about_heading" value="{{ setting('about_heading') }}">
        <label>About content (HTML allowed)</label>
        <textarea name="about_content" style="min-height:180px">{{ setting('about_content') }}</textarea>
        <label>About image</label>
        <input type="file" name="about_image" accept="image/*">
        <label>CTA heading</label>
        <input name="cta_heading" value="{{ setting('cta_heading') }}">
        <label>CTA text</label>
        <textarea name="cta_text">{{ setting('cta_text') }}</textarea>
        <div class="form-grid">
            <div><label>CTA button label</label><input name="cta_button_label" value="{{ setting('cta_button_label') }}"></div>
            <div><label>CTA button URL</label><input name="cta_button_url" value="{{ setting('cta_button_url') }}"></div>
        </div>
        <label>Booking intro</label>
        <textarea name="booking_intro">{{ setting('booking_intro') }}</textarea>
        <label>Contact intro</label>
        <textarea name="contact_intro">{{ setting('contact_intro') }}</textarea>
        <label>Makes we service (comma separated)</label>
        <textarea name="makes_we_service">{{ setting('makes_we_service') }}</textarea>
    @elseif($tab === 'contact')
        <div class="form-grid">
            <div><label>Phone</label><input name="phone" value="{{ setting('phone') }}"></div>
            <div><label>Email</label><input name="email" value="{{ setting('email') }}"></div>
        </div>
        <label>Address</label>
        <input name="address" value="{{ setting('address') }}">
        <label>WhatsApp number</label>
        <input name="whatsapp" value="{{ setting('whatsapp') }}">
        <label>Google Maps listing URL</label>
        <input name="google_maps_url" value="{{ setting('google_maps_url') }}">
        <label>Plus Code</label>
        <input name="plus_code" value="{{ setting('plus_code') }}">
        <label>Google Maps embed URL</label>
        <textarea name="map_embed">{{ setting('map_embed') }}</textarea>
    @elseif($tab === 'social')
        @foreach(['facebook','instagram','youtube','twitter'] as $network)
            <label>{{ ucfirst($network) }} URL</label>
            <input name="{{ $network }}" value="{{ setting($network) }}">
        @endforeach
    @else
        <label>Meta title</label>
        <input name="meta_title" value="{{ setting('meta_title') }}">
        <label>Meta description</label>
        <textarea name="meta_description">{{ setting('meta_description') }}</textarea>
        <label>Footer about text</label>
        <textarea name="footer_about">{{ setting('footer_about') }}</textarea>
        <label>Copyright text</label>
        <input name="copyright_text" value="{{ setting('copyright_text') }}">
    @endif

    <button class="btn" type="submit" style="margin-top:20px">Save settings</button>
</form>
@endsection
