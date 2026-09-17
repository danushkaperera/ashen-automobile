<section class="section">
    <div class="container">
        <div class="section-head">
            <h2>{{ $section->heading }}</h2>
            <p class="muted">{{ $section->subheading }}</p>
        </div>
        <div class="grid-3">
            @foreach($testimonials as $item)
                <article class="quote-card">
                    <p>{{ str_repeat('★', $item->rating) }}</p>
                    <p>{{ $item->content }}</p>
                    <strong>{{ $item->customer_name }}</strong>
                    <div class="muted">{{ $item->vehicle }}</div>
                </article>
            @endforeach
        </div>
        @if(setting('google_maps_url'))
            <p style="margin-top:22px"><a class="btn btn-dark" href="{{ setting('google_maps_url') }}" target="_blank" rel="noopener">Read Google reviews</a></p>
        @endif
    </div>
</section>
