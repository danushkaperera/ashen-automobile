@extends('layouts.public')
@php $pageTitle = $service->title.' | '.setting('site_name'); @endphp
@section('content')
<section class="page-hero"><div class="container"><h1>{{ $service->title }}</h1><p>{{ $service->short_description }}</p></div></section>
<section class="section">
    <div class="container split">
        <div class="prose">
            {!! $service->description !!}
            <a class="btn btn-primary" href="{{ route('booking') }}">Book this service</a>
        </div>
        <div class="about-media">
            <img src="{{ media_url($service->image, asset('images/service-1.svg')) }}" alt="{{ $service->title }}">
        </div>
    </div>
</section>
@if($others->count())
<section class="section">
    <div class="container">
        <h2>Related services</h2>
        <div class="grid-3">
            @foreach($others as $item)
                <article class="service-card">
                    <div class="body">
                        <h3>{{ $item->title }}</h3>
                        <p>{{ $item->short_description }}</p>
                        <a href="{{ route('services.show', $item) }}">View →</a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
