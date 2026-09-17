<section class="hero">
    @forelse($slides as $i => $slide)
        <div class="hero-slide {{ $i === 0 ? 'active' : '' }}" style="background-image:url('{{ media_url($slide->image, asset('images/hero-1.svg')) }}')">
            <div class="container hero-copy">
                @if($slide->subtitle)<span>{{ $slide->subtitle }}</span>@endif
                <h1>{{ $slide->title }}</h1>
                <p>{{ $slide->description }}</p>
                <div class="hero-actions">
                    @if($slide->cta_text)<a class="btn btn-primary" href="{{ $slide->cta_url }}">{{ $slide->cta_text }}</a>@endif
                    @if($slide->secondary_cta_text)<a class="btn btn-outline" href="{{ $slide->secondary_cta_url }}">{{ $slide->secondary_cta_text }}</a>@endif
                </div>
            </div>
        </div>
    @empty
        <div class="hero-slide active" style="background-image:url('{{ asset('images/hero-1.svg') }}')">
            <div class="container hero-copy">
                <h1>{{ setting('site_name') }}</h1>
                <p>{{ setting('tagline') }}</p>
            </div>
        </div>
    @endforelse
    <div class="hero-dots"></div>
</section>
