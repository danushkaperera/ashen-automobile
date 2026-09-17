<section class="cta-band">
    <div class="container">
        <h2>{{ $section->heading ?: setting('cta_heading') }}</h2>
        <p>{{ $section->subheading ?: setting('cta_text') }}</p>
        <a class="btn btn-primary" href="{{ setting('cta_button_url', '/book') }}">{{ setting('cta_button_label', 'Book a repair') }}</a>
    </div>
</section>
