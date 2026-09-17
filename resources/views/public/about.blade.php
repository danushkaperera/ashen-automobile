@extends('layouts.public')
@section('content')
<section class="page-hero">
    <div class="container">
        <h1>About the workshop</h1>
        <p>{{ setting('tagline') }}</p>
    </div>
</section>
<section class="section">
    <div class="container about-grid">
        <div class="prose">
            <h2>{{ setting('about_heading') }}</h2>
            {!! setting('about_content') !!}
        </div>
        <div class="about-media">
            <img src="{{ media_url(setting('about_image'), asset('images/about.svg')) }}" alt="About">
        </div>
    </div>
</section>
<section class="stats-band">
    <div class="container grid-4">
        @foreach($stats as $stat)
            <div class="stat"><strong>{{ $stat->value }}</strong><span>{{ $stat->label }}</span></div>
        @endforeach
    </div>
</section>
<section class="section">
    <div class="container">
        <div class="grid-4">
            @foreach($features as $feature)
                <article class="feature-card"><h3>{{ $feature->title }}</h3><p>{{ $feature->description }}</p></article>
            @endforeach
        </div>
    </div>
</section>
<section class="section">
    <div class="container">
        <h2>Technicians</h2>
        <div class="grid-3">
            @foreach($team as $member)
                <article class="team-card">
                    <img src="{{ media_url($member->photo, asset('images/team-1.svg')) }}" alt="{{ $member->name }}">
                    <h3>{{ $member->name }}</h3>
                    <p class="muted">{{ $member->role }}</p>
                    <p>{{ $member->bio }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endsection
