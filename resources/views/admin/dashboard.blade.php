@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
<div class="stats">
    <a class="stat-box" href="{{ route('admin.bookings.index', ['status' => 'pending']) }}">
        <span>Pending bookings</span><strong>{{ $pendingBookings }}</strong>
    </a>
    <a class="stat-box" href="{{ route('admin.bookings.index') }}">
        <span>All bookings</span><strong>{{ $totalBookings }}</strong>
    </a>
    <a class="stat-box" href="{{ route('admin.messages.index', ['unread' => 1]) }}">
        <span>Unread messages</span><strong>{{ $unreadMessages }}</strong>
    </a>
    <a class="stat-box" href="{{ route('admin.services.index') }}">
        <span>Services</span><strong>{{ $services }}</strong>
    </a>
    <a class="stat-box" href="{{ route('admin.customers.index', ['type' => 'new']) }}">
        <span>New customers</span><strong>{{ $newCustomers }}</strong>
    </a>
    <a class="stat-box" href="{{ route('admin.customers.index', ['type' => 'regular']) }}">
        <span>Regular customers</span><strong>{{ $regularCustomers }}</strong>
    </a>
</div>
<div class="toolbar" style="margin-top:4px">
    <h3 style="margin:0">Registered services</h3>
    <a class="btn small secondary" href="{{ route('admin.services.index') }}">Manage services</a>
</div>
@include('partials.service-cards', ['services' => $workshopServices, 'mode' => 'admin'])
<div class="form-grid" style="margin-top:24px">
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
