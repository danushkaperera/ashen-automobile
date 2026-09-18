@extends('layouts.staff')
@section('title', $job->number)
@section('content')
<div class="toolbar">
    <p>
        <span class="badge badge-{{ $job->status }}">{{ $job->statusLabel() }}</span>
        @if($job->invoice_number)
            · {{ $job->invoice_number }}
        @endif
    </p>
    <div class="row-actions">
        @if($job->isDraft())
            <a class="btn secondary" href="{{ route('staff.jobs.edit', $job) }}">Edit job</a>
            <form method="POST" action="{{ route('staff.jobs.invoice.store', $job) }}">
                @csrf
                <button class="btn">Create invoice</button>
            </form>
            <form method="POST" action="{{ route('staff.jobs.destroy', $job) }}" onsubmit="return confirm('Remove this draft job?')">
                @csrf @method('DELETE')
                <button class="btn danger">Delete</button>
            </form>
        @else
            <a class="btn" href="{{ route('staff.jobs.invoice', $job) }}">View invoice</a>
        @endif
        <a class="ghost" href="{{ route('staff.jobs.index') }}">All jobs</a>
    </div>
</div>
<div class="form-grid">
    <div class="card">
        <h3>Customer</h3>
        <p>{{ $job->customer_name }}</p>
        <p>{{ $job->customer_phone }}</p>
        <p>{{ $job->customer_email ?: 'No email' }}</p>
        <p>{{ $job->customer_address ?: 'No address' }}</p>
        <p class="help">{{ $job->vehicleLabel() }}</p>
    </div>
    <div class="card">
        <h3>Totals</h3>
        <p>Subtotal {{ money($job->subtotal) }}</p>
        <p>GST {{ number_format((float) $job->gst_rate, 0) }}% {{ money($job->gst_amount) }}</p>
        <p><strong>Total {{ money($job->total) }}</strong></p>
        @if($job->notes)
            <p class="help">{{ $job->notes }}</p>
        @endif
    </div>
</div>
<div class="card" style="margin-top:16px">
    <h3>Services</h3>
    <table class="table">
        <tr><th>Item</th><th>Qty</th><th>Price</th><th>Line</th></tr>
        @foreach($job->items as $item)
            <tr>
                <td>{{ $item->title }}</td>
                <td>{{ rtrim(rtrim(number_format((float) $item->quantity, 2), '0'), '.') }}</td>
                <td>{{ money($item->unit_price) }}</td>
                <td>{{ money($item->line_total) }}</td>
            </tr>
        @endforeach
    </table>
</div>
@endsection
