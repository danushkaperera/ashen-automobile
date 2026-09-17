<section class="section">
    <div class="container">
        <div class="section-head">
            <h2>{{ $section->heading }}</h2>
            <p class="muted">{{ $section->subheading }}</p>
        </div>
        <div class="gallery-grid">
            @foreach($gallery as $item)
                <div class="gallery-item" data-full="{{ media_url($item->image) }}" data-category="{{ $item->category }}">
                    <img src="{{ media_url($item->image, asset('images/gallery-1.svg')) }}" alt="{{ $item->title }}">
                    <span>{{ $item->title }}</span>
                </div>
            @endforeach
        </div>
        <p style="margin-top:18px"><a class="btn btn-dark" href="{{ route('gallery') }}">Open gallery</a></p>
    </div>
</section>
