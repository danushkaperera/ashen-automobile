<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Workshop desk') · Staff</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    @php $authUser = auth()->user(); @endphp
    <aside class="sidebar">
        <a class="sidebar-brand" href="{{ $authUser->homePath() }}">
            <img src="{{ asset('images/logo.png') }}" alt="Auto Bridge">
            <span>Auto Bridge</span>
            <small>Workshop desk</small>
        </a>
        <nav>
            @if($authUser->hasPermission('staff.desk'))
                <a href="{{ route('staff.dashboard') }}" class="{{ request()->routeIs('staff.dashboard') ? 'active' : '' }}">Desk</a>
            @endif
            @if($authUser->hasPermission('staff.services'))
                <a href="{{ route('staff.services.index') }}" class="{{ request()->routeIs('staff.services.*') || request()->routeIs('staff.visits.*') ? 'active' : '' }}">Services</a>
            @endif
            @if($authUser->hasPermission('staff.jobs'))
                <a href="{{ route('staff.jobs.index') }}" class="{{ request()->routeIs('staff.jobs.*') ? 'active' : '' }}">Jobs</a>
            @endif
            @if(! $authUser->isAdmin())
                @php $adminLinks = \App\Support\StaffPermissions::grantedAdminLinks($authUser); @endphp
                @if(count($adminLinks))
                    <p>Admin pages</p>
                    @foreach($adminLinks as $link)
                        <a href="{{ route($link['entry']) }}" class="{{ request()->routeIs($link['routes'][0]) ? 'active' : '' }}">{{ $link['label'] }}</a>
                    @endforeach
                @endif
            @endif
        </nav>
    </aside>
    <div class="admin-main">
        <header class="admin-top">
            <h1>@yield('title', 'Workshop desk')</h1>
            <div class="admin-top-actions">
                @if($authUser->isAdmin())
                    <a class="ghost" href="{{ route('admin.dashboard') }}">Admin panel</a>
                @endif
                <span>{{ $authUser->name }}</span>
                <form method="POST" action="{{ route('staff.logout') }}">
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
                <div class="notice error">{{ $errors->first() }}</div>
            @endif
            @yield('content')
        </div>
    </div>
    <script>
        document.querySelectorAll('[data-lookup-form]').forEach((form) => {
            const banner = form.querySelector('[data-lookup-banner]');
            const fields = ['phone', 'email'];
            const fill = ['name', 'email', 'address', 'vehicle_make', 'vehicle_model', 'vehicle_year'];
            async function lookup() {
                if (!banner) return;
                const phone = form.querySelector('[name=phone]')?.value || '';
                const email = form.querySelector('[name=email]')?.value || '';
                if (!phone && !email) {
                    banner.hidden = true;
                    return;
                }
                const url = @json(route('staff.customers.lookup')) + '?phone=' + encodeURIComponent(phone) + '&email=' + encodeURIComponent(email);
                const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
                const data = await res.json();
                banner.hidden = false;
                banner.className = 'lookup-banner ' + data.type;
                banner.textContent = data.found
                    ? data.label + ' · ' + data.visit_count + ' previous visit' + (data.visit_count === 1 ? '' : 's')
                    : 'New customer — no matching phone or email yet.';
                if (data.found && data.customer) {
                    fill.forEach((key) => {
                        const input = form.querySelector('[name="' + key + '"]');
                        if (input && !input.value && data.customer[key]) input.value = data.customer[key];
                    });
                }
            }
            fields.forEach((name) => {
                form.querySelector('[name="' + name + '"]')?.addEventListener('blur', lookup);
            });
        });
    </script>
</body>
</html>
