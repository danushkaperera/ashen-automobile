@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
<div class="stats">
    <div class="stat-box"><span>Pending bookings</span><strong>{{ $pendingBookings }}</strong></div>
    <div class="stat-box"><span>All bookings</span><strong>{{ $totalBookings }}</strong></div>
    <div class="stat-box"><span>Unread messages</span><strong>{{ $unreadMessages }}</strong></div>
    <div class="stat-box"><span>Services</span><strong>{{ $services }}</strong></div>
</div>
<div class="form-grid">
    <div class="card">
        <h3>Recent bookings</h3>
        <table class="table">
            <tr><th>Customer</th><th>Service</th><th>Status</th></tr>
            @forelse($recentBookings as $booking)
                <tr>
                    <td><a href="{{ route('admin.bookings.show', $booking) }}">{{ $booking->name }}</a></td>
                    <td>{{ $booking->service->title ?? '—' }}</td>
                    <td>{{ $booking->status }}</td>
                </tr>
            @empty
                <tr><td colspan="3">No bookings yet.</td></tr>
            @endforelse
        </table>
    </div>
    <div class="card">
        <h3>Recent messages</h3>
        <table class="table">
            <tr><th>From</th><th>Subject</th></tr>
            @forelse($recentMessages as $message)
                <tr>
                    <td><a href="{{ route('admin.messages.show', $message) }}">{{ $message->name }}</a></td>
                    <td>{{ $message->subject ?: '—' }}</td>
                </tr>
            @empty
                <tr><td colspan="2">No messages yet.</td></tr>
            @endforelse
        </table>
    </div>
</div>
@endsection
