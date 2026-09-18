<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') · Admin</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    @php $authUser = auth()->user(); @endphp
    <aside class="sidebar">
        <a class="sidebar-brand" href="{{ $authUser->hasPermission('admin.dashboard') ? route('admin.dashboard') : $authUser->homePath() }}">
            <img src="{{ asset('images/logo.png') }}" alt="Auto Bridge">
            <span>Auto Bridge</span>
            <small>Admin panel</small>
        </a>
        <nav>
            @if($authUser->hasPermission('admin.dashboard'))
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
            @endif
            @if($authUser->canAccessAny(['admin.settings', 'admin.sections', 'admin.heroes', 'admin.menus', 'admin.pages']))
                <p>Website</p>
            @endif
            @if($authUser->hasPermission('admin.settings'))
                <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">Site settings</a>
            @endif
            @if($authUser->hasPermission('admin.sections'))
                <a href="{{ route('admin.sections.index') }}" class="{{ request()->routeIs('admin.sections.*') ? 'active' : '' }}">Homepage sections</a>
            @endif
            @if($authUser->hasPermission('admin.heroes'))
                <a href="{{ route('admin.heroes.index') }}" class="{{ request()->routeIs('admin.heroes.*') ? 'active' : '' }}">Hero slides</a>
            @endif
            @if($authUser->hasPermission('admin.menus'))
                <a href="{{ route('admin.menus.index') }}" class="{{ request()->routeIs('admin.menus.*') ? 'active' : '' }}">Menus</a>
            @endif
            @if($authUser->hasPermission('admin.pages'))
                <a href="{{ route('admin.pages.index') }}" class="{{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">Pages</a>
            @endif
            @if($authUser->canAccessAny(['admin.services', 'admin.features', 'admin.stats', 'admin.team', 'admin.testimonials', 'admin.gallery', 'admin.faqs', 'admin.hours']))
                <p>Content</p>
            @endif
            @if($authUser->hasPermission('admin.services'))
                <a href="{{ route('admin.services.index') }}" class="{{ request()->routeIs('admin.services.*') ? 'active' : '' }}">Services</a>
            @endif
            @if($authUser->hasPermission('admin.features'))
                <a href="{{ route('admin.features.index') }}" class="{{ request()->routeIs('admin.features.*') ? 'active' : '' }}">Why choose us</a>
            @endif
            @if($authUser->hasPermission('admin.stats'))
                <a href="{{ route('admin.stats.index') }}" class="{{ request()->routeIs('admin.stats.*') ? 'active' : '' }}">Stats</a>
            @endif
            @if($authUser->hasPermission('admin.team'))
                <a href="{{ route('admin.team.index') }}" class="{{ request()->routeIs('admin.team.*') ? 'active' : '' }}">Team</a>
            @endif
            @if($authUser->hasPermission('admin.testimonials'))
                <a href="{{ route('admin.testimonials.index') }}" class="{{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">Testimonials</a>
            @endif
            @if($authUser->hasPermission('admin.gallery'))
                <a href="{{ route('admin.gallery.index') }}" class="{{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">Gallery</a>
            @endif
            @if($authUser->hasPermission('admin.faqs'))
                <a href="{{ route('admin.faqs.index') }}" class="{{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">FAQs</a>
            @endif
            @if($authUser->hasPermission('admin.hours'))
                <a href="{{ route('admin.hours.index') }}" class="{{ request()->routeIs('admin.hours.*') ? 'active' : '' }}">Working hours</a>
            @endif
            @if($authUser->canAccessAny(['admin.bookings', 'admin.messages']))
                <p>Inbox</p>
            @endif
            @if($authUser->hasPermission('admin.bookings'))
                <a href="{{ route('admin.bookings.index') }}" class="{{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">Bookings @if($pendingBookings)<em>{{ $pendingBookings }}</em>@endif</a>
            @endif
            @if($authUser->hasPermission('admin.messages'))
                <a href="{{ route('admin.messages.index') }}" class="{{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">Messages @if($unreadMessages)<em>{{ $unreadMessages }}</em>@endif</a>
            @endif
            @if($authUser->canAccessAny(['admin.staff', 'admin.customers', 'admin.jobs']) || $authUser->isAdmin())
                <p>Workshop</p>
            @endif
            @if($authUser->hasPermission('admin.staff'))
                <a href="{{ route('admin.staff.index') }}" class="{{ request()->routeIs('admin.staff.*') ? 'active' : '' }}">Staff users</a>
            @endif
            @if($authUser->hasPermission('admin.customers'))
                <a href="{{ route('admin.customers.index') }}" class="{{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">Customers</a>
            @endif
            @if($authUser->hasPermission('admin.jobs'))
                <a href="{{ route('admin.jobs.index') }}" class="{{ request()->routeIs('admin.jobs.*') ? 'active' : '' }}">Jobs</a>
            @endif
            @if($authUser->isAdmin() || $authUser->hasPermission('staff.desk') || $authUser->hasPermission('staff.services'))
                <a href="{{ $authUser->isAdmin() ? route('staff.dashboard') : $authUser->homePath() }}">Staff portal</a>
            @endif
        </nav>
    </aside>
    <div class="admin-main">
        <header class="admin-top">
            <h1>@yield('title', 'Dashboard')</h1>
            <div class="admin-top-actions">
                <a class="ghost" href="{{ route('home') }}" target="_blank">View website</a>
                @if($authUser->isAdmin() || $authUser->canAccessRoute('admin.profile.edit'))
                    <a href="{{ route('admin.profile.edit') }}">{{ $authUser->name }}</a>
                @else
                    <span>{{ $authUser->name }}</span>
                @endif
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
            @if(session('error'))
                <div class="notice error">{{ session('error') }}</div>
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
