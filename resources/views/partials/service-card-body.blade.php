@if(($mode ?? 'staff') === 'staff')
    <div class="service-tile-name">{{ $service->title }}</div>
    <div class="service-tile-body">
        @if($service->short_description)
            <p class="help">{{ $service->short_description }}</p>
        @endif
        <div class="service-tile-meta">
            @if($service->displayPrice())
                <span>{{ $service->displayPrice() }}</span>
            @endif
            <span>{{ $service->visits_count ?? 0 }} registration{{ ($service->visits_count ?? 0) === 1 ? '' : 's' }}</span>
            <span>Register customer</span>
        </div>
    </div>
@else
    <div class="service-tile-media">
        <img src="{{ media_url($service->image, asset('images/service-1.svg')) }}" alt="{{ $service->title }}">
    </div>
    <div class="service-tile-body">
        <h3>{{ $service->title }}</h3>
        @if($service->short_description)
            <p class="help">{{ $service->short_description }}</p>
        @endif
        <div class="service-tile-meta">
            @if($service->displayPrice())
                <span>{{ $service->displayPrice() }}</span>
            @endif
            <span>{{ $service->visits_count ?? 0 }} registration{{ ($service->visits_count ?? 0) === 1 ? '' : 's' }}</span>
            @if(! $service->is_active)
                <span class="badge">Inactive</span>
            @endif
        </div>
    </div>
@endif
