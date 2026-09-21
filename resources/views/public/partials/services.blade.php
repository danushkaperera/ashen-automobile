<section class="section">
    <div class="container">
        <div class="section-head">
            <h2>{{ $section->heading ?: 'Services' }}</h2>
            <p class="muted">{{ $section->subheading }}</p>
        </div>
        <div class="grid-3">
            @foreach($services as $service)
                <article class="service-card">
                    <div class="media">
                        <img src="{{ media_url($service->image, asset('images/service-1.svg')) }}" alt="{{ $service->title }}">
                    </div>
                    <div class="body">
                        <h3>{{ $service->title }}</h3>
                        <p>{{ $service->short_description }}</p>
                        <a href="{{ route('services.show', $service) }}">View service →</a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
