@php
    $makes = array_values(array_filter(array_map('trim', explode(',', (string) setting('makes_we_service', '')))));
@endphp
@if(count($makes))
<section class="brand-marquee">
    <div class="container section-head" style="margin-bottom:18px">
        @if(!empty($section->heading))<h2 style="color:#fff">{{ $section->heading }}</h2>@endif
        @if(!empty($section->subheading))<p class="muted" style="color:#cbd5e1">{{ $section->subheading }}</p>@endif
    </div>
    <div class="brand-track">
        @foreach(array_merge($makes, $makes) as $make)
            <span>{{ $make }}</span>
        @endforeach
    </div>
</section>
@endif
