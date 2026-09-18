<section class="section reviews-section">
    <div class="container">
        <div class="section-head">
            <h2>{{ $section->heading }}</h2>
            <p class="muted">{{ $section->subheading }}</p>
        </div>
        <div class="review-slider" data-interval="5000">
            <button class="review-nav prev" type="button" aria-label="Previous review">‹</button>
            <div class="review-viewport">
                <div class="review-track">
                    @foreach($testimonials as $item)
                        <article class="quote-card">
                            <p class="quote-stars">{{ str_repeat('★', $item->rating) }}</p>
                            <p class="quote-text">{{ $item->content }}</p>
                            <strong>{{ $item->customer_name }}</strong>
                            <div class="muted">{{ $item->vehicle }}</div>
                        </article>
                    @endforeach
                </div>
            </div>
            <button class="review-nav next" type="button" aria-label="Next review">›</button>
            <div class="review-dots" aria-hidden="true"></div>
        </div>
        @if(setting('google_maps_url'))
            <p class="review-cta"><a class="btn btn-dark" href="{{ setting('google_maps_url') }}" target="_blank" rel="noopener">Read Google reviews</a></p>
        @endif
    </div>
</section>
