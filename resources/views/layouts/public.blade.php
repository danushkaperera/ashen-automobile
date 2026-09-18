@php
    $headingFont = setting('heading_font', 'CBABeaconSans');
    $bodyFont = setting('body_font', 'CBABeaconSans');
    $googleFonts = collect([$headingFont, $bodyFont])
        ->filter(fn ($font) => $font && $font !== 'CBABeaconSans')
        ->unique()
        ->values();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle ?? setting('meta_title', setting('site_name')) }}</title>
    <meta name="description" content="{{ $pageDescription ?? setting('meta_description') }}">
    <link rel="icon" href="{{ media_url(setting('favicon'), asset('images/logo.png')) }}">
    @if($googleFonts->isNotEmpty())
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family={{ $googleFonts->map(fn ($font) => urlencode($font).':wght@400;500;600;700')->implode('&family=') }}&display=swap" rel="stylesheet">
    @endif
    <link rel="stylesheet" href="{{ asset('css/site.css') }}?v=7">
    <style>
        :root {
            --primary: {{ setting('primary_color', '#4BA8E8') }};
            --secondary: {{ setting('secondary_color', '#002856') }};
            --accent: {{ setting('accent_color', '#7DD3FC') }};
            --bg: {{ setting('background_color', '#E8F4FC') }};
            --surface: {{ setting('surface_color', '#ffffff') }};
            --text: {{ setting('text_color', '#002856') }};
            --muted: {{ setting('muted_color', '#5A7A90') }};
            --header: {{ setting('header_background', '#002856') }};
            --footer: {{ setting('footer_background', '#002856') }};
            --radius: {{ setting('button_radius', '6') }}px;
            --overlay: {{ setting('hero_overlay', '0.55') }};
            --font-heading: "{{ $headingFont }}", sans-serif;
            --font-body: "{{ $bodyFont }}", sans-serif;
        }
    </style>
</head>
<body>
    @if(setting('topbar_enabled') && setting('topbar_text'))
        <div class="topbar">
            <div class="container topbar-inner">
                <span>{{ setting('topbar_text') }}</span>
                @if(setting('phone'))
                    <a href="tel:{{ preg_replace('/\s+/', '', setting('phone')) }}">{{ setting('phone') }}</a>
                @endif
            </div>
        </div>
    @endif

    <header class="site-header">
        <div class="container header-inner">
            <a class="brand" href="{{ route('home') }}">
                <img src="{{ media_url(setting('logo'), asset('images/logo.png')) }}" alt="{{ setting('site_name') ?: 'Auto Bridge' }}">
                @if(filled(setting('site_name')) || filled(setting('tagline')))
                    <span>
                        @if(filled(setting('site_name')))
                            <strong>{{ setting('site_name') }}</strong>
                        @endif
                        @if(filled(setting('tagline')))
                            <small>{{ setting('tagline') }}</small>
                        @endif
                    </span>
                @endif
            </a>
            <button class="nav-toggle" type="button" aria-label="Menu">Menu</button>
            <nav class="site-nav">
                @foreach($headerMenu as $item)
                    <a href="{{ $item->url }}" @if($item->open_in_new_tab) target="_blank" rel="noopener" @endif>{{ $item->label }}</a>
                @endforeach
                <a class="btn btn-primary" href="{{ url('/book') }}">Book now</a>
            </nav>
        </div>
    </header>

    <main>
        @if(session('success'))
            <div class="flash-success">{{ session('success') }}</div>
        @endif
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container footer-grid">
            <div>
                <img class="footer-logo" src="{{ media_url(setting('logo'), asset('images/logo.png')) }}" alt="{{ setting('site_name') ?: 'Auto Bridge' }}">
                @if(filled(setting('site_name')))
                    <h3>{{ setting('site_name') }}</h3>
                @endif
                <p>{{ setting('footer_about') }}</p>
            </div>
            <div>
                <h4>Explore</h4>
                @foreach($footerMenu as $item)
                    <a href="{{ $item->url }}">{{ $item->label }}</a>
                @endforeach
            </div>
            <div>
                <h4>Workshop</h4>
                <p>{{ setting('address') }}</p>
                <p><a href="tel:{{ preg_replace('/\s+/', '', setting('phone')) }}">{{ setting('phone') }}</a></p>
                @if(setting('email'))
                    <p><a href="mailto:{{ setting('email') }}">{{ setting('email') }}</a></p>
                @endif
                @if(setting('google_maps_url'))
                    <p><a href="{{ setting('google_maps_url') }}" target="_blank" rel="noopener">Google Maps</a></p>
                @endif
            </div>
            <div>
                <h4>Hours</h4>
                @php $uniqueHours = $workingHours->map->display()->unique(); @endphp
                @if($uniqueHours->count() === 1)
                    <p>Every day · {{ $uniqueHours->first() }}</p>
                @else
                    @foreach($workingHours as $hour)
                        <p class="hours-row"><span>{{ $hour->day_name }}</span><span>{{ $hour->display() }}</span></p>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="container footer-bottom">
            <span>{{ setting('copyright_text') }}</span>
            <div class="socials">
                @foreach(['facebook','instagram','youtube','twitter'] as $network)
                    @if(setting($network))
                        <a href="{{ setting($network) }}" target="_blank" rel="noopener">{{ ucfirst($network) }}</a>
                    @endif
                @endforeach
            </div>
        </div>
    </footer>
    <script src="{{ asset('js/site.js') }}?v=4"></script>
</body>
</html>
