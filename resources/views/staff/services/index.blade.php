@extends('layouts.staff')
@section('title', 'Services')
@section('content')
<div class="toolbar">
    <p class="help" style="margin:0">Choose an active service to register a customer, or start a multi-service job.</p>
    @if(auth()->user()->hasPermission('staff.jobs'))
        <a class="btn" href="{{ route('staff.jobs.create') }}">New job</a>
    @endif
</div>
@include('partials.service-cards', ['services' => $services, 'mode' => 'staff'])
@endsection
