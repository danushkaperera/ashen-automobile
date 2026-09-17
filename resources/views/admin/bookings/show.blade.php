@extends('layouts.admin')
@section('title', 'Booking')
@section('content')
<div class="card">
    <p><strong>{{ $booking->name }}</strong> · {{ $booking->email }} · {{ $booking->phone }}</p>
    <p>{{ $booking->vehicle_year }} {{ $booking->vehicle_make }} {{ $booking->vehicle_model }}</p>
    <p>Service: {{ $booking->service->title ?? 'General' }}</p>
    <p>Preferred: {{ optional($booking->preferred_date)->format('d M Y') }} {{ $booking->preferred_time }}</p>
    <p>{{ $booking->message }}</p>
    <form method="POST" action="{{ route('admin.bookings.update', $booking) }}">
        @csrf @method('PUT')
        <label>Status</label>
        <select name="status">
            @foreach(['pending','confirmed','completed','cancelled'] as $status)
                <option value="{{ $status }}" @selected($booking->status === $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
        <label>Admin notes</label>
        <textarea name="admin_notes">{{ $booking->admin_notes }}</textarea>
        <button class="btn" style="margin-top:12px">Update booking</button>
    </form>
    <form method="POST" action="{{ route('admin.bookings.destroy', $booking) }}" onsubmit="return confirm('Delete this booking?')" style="margin-top:12px">
        @csrf @method('DELETE')
        <button class="btn danger">Delete</button>
    </form>
</div>
@endsection
