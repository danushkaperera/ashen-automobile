@extends('layouts.public')
@section('content')
<section class="page-hero"><div class="container"><h1>Gallery</h1><p>Workshop, tooling and jobs in progress.</p></div></section>
<section class="section">
    <div class="container">
        <div class="filters">
            <button class="chip active" type="button" data-filter="all">All</button>
            @foreach($categories as $category)
                <button class="chip" type="button" data-filter="{{ $category }}">{{ ucfirst($category) }}</button>
            @endforeach
        </div>
        <div class="gallery-grid">
            @foreach($items as $item)
                <div class="gallery-item" data-category="{{ $item->category }}" data-full="{{ media_url($item->image) }}">
                    <img src="{{ media_url($item->image, asset('images/gallery-1.svg')) }}" alt="{{ $item->title }}">
                    <span>{{ $item->title }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>
<div class="lightbox"><img alt=""></div>
@endsection
