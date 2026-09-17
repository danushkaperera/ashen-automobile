@extends('layouts.public')
@section('content')
<section class="page-hero"><div class="container"><h1>Contact</h1><p>{{ setting('contact_intro') }}</p></div></section>
<section class="section">
    <div class="container split">
        <form class="form-card" method="POST" action="{{ route('contact.store') }}">
            @csrf
            <label>Name</label>
            <input name="name" value="{{ old('name') }}" required>
            <div class="form-grid">
                <div>
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div>
                    <label>Phone</label>
                    <input name="phone" value="{{ old('phone') }}">
                </div>
            </div>
            <label>Subject</label>
            <input name="subject" value="{{ old('subject') }}">
            <label>Message</label>
            <textarea name="message" required>{{ old('message') }}</textarea>
            <button class="btn btn-primary" type="submit" style="margin-top:16px">Send message</button>
        </form>
        <div>
            <div class="feature-card">
                <h3>Workshop</h3>
                <p>{{ setting('address') }}</p>
                @if(setting('plus_code'))<p>{{ setting('plus_code') }}</p>@endif
                <p><a href="tel:{{ preg_replace('/\s+/', '', setting('phone')) }}">{{ setting('phone') }}</a></p>
                @if(setting('email'))<p><a href="mailto:{{ setting('email') }}">{{ setting('email') }}</a></p>@endif
                @if(setting('google_maps_url'))
                    <p><a href="{{ setting('google_maps_url') }}" target="_blank" rel="noopener">Open in Google Maps</a></p>
                @endif
                @php $uniqueHours = $hours->map->display()->unique(); @endphp
                @if($uniqueHours->count() === 1)
                    <p>{{ $uniqueHours->first() }}</p>
                @else
                    @foreach($hours as $hour)
                        <p class="hours-row"><span>{{ $hour->day_name }}</span><span>{{ $hour->display() }}</span></p>
                    @endforeach
                @endif
            </div>
            @if(setting('map_embed'))
                <div style="margin-top:18px;border-radius:16px;overflow:hidden;min-height:240px">
                    <iframe src="{{ setting('map_embed') }}" width="100%" height="260" style="border:0" loading="lazy"></iframe>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
