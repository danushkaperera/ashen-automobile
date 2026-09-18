@extends('layouts.staff')
@section('title', 'Register · '.$service->title)
@section('content')
<p class="help" style="margin-top:0">Register this customer for <strong>{{ $service->title }}</strong>. Enter phone or email first to see if they are new or regular.</p>
<form class="card" method="POST" action="{{ route('staff.visits.store', $service) }}" data-lookup-form>
    @csrf
    <div class="lookup-banner" data-lookup-banner hidden></div>
    <div class="form-grid">
        <div><label>Name</label><input name="name" value="{{ old('name') }}" required></div>
        <div><label>Phone</label><input name="phone" value="{{ old('phone') }}" required></div>
        <div><label>Email</label><input type="email" name="email" value="{{ old('email') }}"></div>
        <div><label>Address</label><input name="address" value="{{ old('address') }}"></div>
        <div><label>Vehicle make</label><input name="vehicle_make" value="{{ old('vehicle_make') }}"></div>
        <div><label>Vehicle model</label><input name="vehicle_model" value="{{ old('vehicle_model') }}"></div>
        <div><label>Year</label><input name="vehicle_year" value="{{ old('vehicle_year') }}"></div>
        <div><label>Job title</label><input name="job_title" value="{{ old('job_title', $service->title) }}"></div>
        <div><label>Visit date</label><input type="datetime-local" name="visited_at" value="{{ old('visited_at', now()->format('Y-m-d\TH:i')) }}"></div>
    </div>
    <label>Notes</label>
    <textarea name="notes">{{ old('notes') }}</textarea>
    <div class="row-actions" style="margin-top:16px">
        <button class="btn">Register for {{ $service->title }}</button>
        <a class="ghost" href="{{ route('staff.services.index') }}">Back to services</a>
    </div>
</form>
@endsection
