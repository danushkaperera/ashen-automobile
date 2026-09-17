@extends('layouts.admin')
@section('title', 'Bookings')
@section('content')
<div class="card">
<table class="table">
<tr><th>Customer</th><th>Service</th><th>Date</th><th>Status</th><th></th></tr>
@forelse($bookings as $booking)
<tr>
    <td>{{ $booking->name }}<br><small>{{ $booking->phone }}</small></td>
    <td>{{ $booking->service->title ?? '—' }}</td>
    <td>{{ optional($booking->preferred_date)->format('d M Y') }} {{ $booking->preferred_time }}</td>
    <td>{{ $booking->status }}</td>
    <td><a class="btn small secondary" href="{{ route('admin.bookings.show', $booking) }}">Open</a></td>
</tr>
@empty
<tr><td colspan="5">No bookings yet.</td></tr>
@endforelse
</table>
{{ $bookings->links() }}
</div>
@endsection
