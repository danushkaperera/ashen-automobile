@extends('layouts.admin')
@section('title', $job->number)
@section('content')
<div class="toolbar">
    <p><span class="badge badge-{{ $job->status }}">{{ $job->statusLabel() }}</span> · {{ $job->customer_name }}</p>
    <div class="row-actions">
        @if($job->isInvoiced())
            <a class="btn" href="{{ route('admin.jobs.invoice', $job) }}">View invoice</a>
        @endif
        <a class="ghost" href="{{ route('admin.jobs.index') }}">All jobs</a>
    </div>
</div>
<div class="card">
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
    <p>Subtotal {{ money($job->subtotal) }} · GST {{ money($job->gst_amount) }} · <strong>Total {{ money($job->total) }}</strong></p>
</div>
@endsection
