<section class="section">
    <div class="container about-grid">
        <div class="prose">
            <h2>{{ $section->heading ?: setting('about_heading') }}</h2>
            <p class="muted">{{ $section->subheading }}</p>
            {!! setting('about_content') !!}
            <a class="btn btn-dark" href="{{ route('about') }}">About the workshop</a>
        </div>
        <div class="about-media">
            <img src="{{ media_url(setting('about_image'), asset('images/about.svg')) }}" alt="Workshop">
        </div>
    </div>
</section>
