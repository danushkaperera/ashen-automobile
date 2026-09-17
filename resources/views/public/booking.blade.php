@extends('layouts.public')
@section('content')
<section class="page-hero"><div class="container"><h1>Book a bay</h1><p>{{ setting('booking_intro') }}</p></div></section>
<section class="section">
    <div class="container" style="max-width:820px">
        <form class="form-card" method="POST" action="{{ route('booking.store') }}">
            @csrf
            <div class="form-grid">
                <div><label>Name</label><input name="name" value="{{ old('name') }}" required></div>
                <div><label>Email</label><input type="email" name="email" value="{{ old('email') }}" required></div>
                <div><label>Phone</label><input name="phone" value="{{ old('phone') }}" required></div>
                <div>
                    <label>Service</label>
                    <select name="service_id">
                        <option value="">General enquiry</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" @selected(old('service_id') == $service->id)>{{ $service->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div><label>Vehicle make</label><input name="vehicle_make" value="{{ old('vehicle_make') }}"></div>
                <div><label>Vehicle model</label><input name="vehicle_model" value="{{ old('vehicle_model') }}"></div>
                <div><label>Year</label><input name="vehicle_year" value="{{ old('vehicle_year') }}"></div>
                <div><label>Preferred date</label><input type="date" name="preferred_date" value="{{ old('preferred_date') }}"></div>
                <div><label>Preferred time</label><input name="preferred_time" value="{{ old('preferred_time') }}" placeholder="e.g. 9:00am"></div>
            </div>
            <label>Notes</label>
            <textarea name="message">{{ old('message') }}</textarea>
            <button class="btn btn-primary" type="submit" style="margin-top:16px">Request booking</button>
        </form>
    </div>
</section>
@endsection
