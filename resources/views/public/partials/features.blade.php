<section class="section">
    <div class="container">
        <div class="section-head">
            <h2>{{ $section->heading }}</h2>
            <p class="muted">{{ $section->subheading }}</p>
        </div>
        <div class="grid-4">
            @foreach($features as $feature)
                <article class="feature-card">
                    <h3>{{ $feature->title }}</h3>
                    <p>{{ $feature->description }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
