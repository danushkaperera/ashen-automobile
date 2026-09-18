<div class="service-cards">
    @forelse($services as $service)
        @php
            $mode = $mode ?? 'staff';
            $href = $mode === 'admin'
                ? route('admin.customers.index', ['service' => $service->id])
                : ($service->is_active ? route('staff.visits.create', $service) : null);
        @endphp
        @if($href)
            <a class="service-tile" href="{{ $href }}">
                @include('partials.service-card-body', ['service' => $service, 'mode' => $mode])
            </a>
        @else
            <div class="service-tile is-inactive">
                @include('partials.service-card-body', ['service' => $service, 'mode' => $mode])
            </div>
        @endif
    @empty
        <p class="help">{{ ($mode ?? 'staff') === 'staff' ? 'No active services are available to register yet.' : 'No services have been added in the admin dashboard yet.' }}</p>
    @endforelse
</div>
