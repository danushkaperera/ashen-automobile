@extends('layouts.public')
@section('content')
<section class="page-hero"><div class="container"><h1>Services</h1><p>Licensed automotive repair and servicing.</p></div></section>
<section class="section">
    <div class="container grid-3">
        @foreach($services as $service)
            <article class="service-card">
                <div class="media"><img src="{{ media_url($service->image, asset('images/service-1.svg')) }}" alt="{{ $service->title }}"></div>
                <div class="body">
                    <h3>{{ $service->title }}</h3>
                    <p>{{ $service->short_description }}</p>
                    <a href="{{ route('services.show', $service) }}">View service →</a>
                </div>
            </article>
        @endforeach
    </div>
</section>
@endsection
