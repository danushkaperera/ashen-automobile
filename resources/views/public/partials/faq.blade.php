<section class="section">
    <div class="container">
        <div class="section-head">
            <h2>{{ $section->heading }}</h2>
            <p class="muted">{{ $section->subheading }}</p>
        </div>
        <div class="faq">
            @foreach($faqs as $faq)
                <details>
                    <summary>{{ $faq->question }}</summary>
                    <p>{{ $faq->answer }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>
