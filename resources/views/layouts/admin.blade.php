<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') · Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <aside class="sidebar">
        <a class="sidebar-brand" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('images/logo.jpg') }}" alt="Auto Bridge">
            <span>Auto Bridge</span>
            <small>Admin panel</small>
        </a>
        <nav>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
            <p>Website</p>
            <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">Site settings</a>
            <a href="{{ route('admin.sections.index') }}" class="{{ request()->routeIs('admin.sections.*') ? 'active' : '' }}">Homepage sections</a>
            <a href="{{ route('admin.heroes.index') }}" class="{{ request()->routeIs('admin.heroes.*') ? 'active' : '' }}">Hero slides</a>
            <a href="{{ route('admin.menus.index') }}" class="{{ request()->routeIs('admin.menus.*') ? 'active' : '' }}">Menus</a>
            <a href="{{ route('admin.pages.index') }}" class="{{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">Pages</a>
            <p>Content</p>
            <a href="{{ route('admin.services.index') }}" class="{{ request()->routeIs('admin.services.*') ? 'active' : '' }}">Services</a>
            <a href="{{ route('admin.features.index') }}" class="{{ request()->routeIs('admin.features.*') ? 'active' : '' }}">Why choose us</a>
            <a href="{{ route('admin.stats.index') }}" class="{{ request()->routeIs('admin.stats.*') ? 'active' : '' }}">Stats</a>
            <a href="{{ route('admin.team.index') }}" class="{{ request()->routeIs('admin.team.*') ? 'active' : '' }}">Team</a>
            <a href="{{ route('admin.testimonials.index') }}" class="{{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">Testimonials</a>
            <a href="{{ route('admin.gallery.index') }}" class="{{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">Gallery</a>
            <a href="{{ route('admin.faqs.index') }}" class="{{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">FAQs</a>
            <a href="{{ route('admin.hours.index') }}" class="{{ request()->routeIs('admin.hours.*') ? 'active' : '' }}">Working hours</a>
            <p>Inbox</p>
            <a href="{{ route('admin.bookings.index') }}" class="{{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">Bookings @if($pendingBookings)<em>{{ $pendingBookings }}</em>@endif</a>
            <a href="{{ route('admin.messages.index') }}" class="{{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">Messages @if($unreadMessages)<em>{{ $unreadMessages }}</em>@endif</a>
        </nav>
    </aside>
    <div class="admin-main">
        <header class="admin-top">
            <h1>@yield('title', 'Dashboard')</h1>
            <div class="admin-top-actions">
                <a class="ghost" href="{{ route('home') }}" target="_blank">View website</a>
                <a href="{{ route('admin.profile.edit') }}">{{ auth()->user()->name }}</a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit">Log out</button>
                </form>
            </div>
        </header>
        <div class="admin-content">
            @if(session('success'))
                <div class="notice success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="notice error">
                    {{ $errors->first() }}
                </div>
            @endif
            @yield('content')
        </div>
    </div>
</body>
</html>
