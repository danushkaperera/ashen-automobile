<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $job->invoice_number }} · Invoice</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="invoice-page">
    <div class="invoice-toolbar no-print">
        @if(request()->routeIs('admin.*'))
            <a class="ghost" href="{{ route('admin.jobs.show', $job) }}">Back</a>
        @else
            <a class="ghost" href="{{ route('staff.jobs.show', $job) }}">Back</a>
        @endif
        <button class="btn" type="button" onclick="window.print()">Print invoice</button>
        @if($job->status !== 'paid' && ! request()->routeIs('admin.*'))
            <form method="POST" action="{{ route('staff.jobs.paid', $job) }}">
                @csrf
                <button class="btn secondary">Mark paid</button>
            </form>
        @endif
    </div>
    @if(session('success'))
        <div class="notice success no-print">{{ session('success') }}</div>
    @endif
    <article class="invoice">
        <header class="invoice-head">
            <div>
                <img src="{{ asset('images/logo.png') }}" alt="Auto Bridge">
                <h1>Tax invoice</h1>
                <p>{{ $job->invoice_number }}</p>
            </div>
            <div class="invoice-meta">
                <strong>{{ setting('site_name', 'Auto Bridge') }}</strong>
                <p>{{ setting('address', '11a Midas Place, Middleton, Christchurch 8024') }}</p>
                <p>{{ setting('phone', '+64 29 020 16792') }}</p>
                <p>{{ setting('email', 'service@autobridge.co.nz') }}</p>
                <p>Date {{ $job->invoiced_at?->format('d M Y') }}</p>
                <p>Job {{ $job->number }}</p>
                <p>Status {{ $job->statusLabel() }}</p>
            </div>
        </header>
        <section class="invoice-parties">
            <div>
                <h2>Bill to</h2>
                <p><strong>{{ $job->customer_name }}</strong></p>
                <p>{{ $job->customer_phone }}</p>
                @if($job->customer_email)<p>{{ $job->customer_email }}</p>@endif
                @if($job->customer_address)<p>{{ $job->customer_address }}</p>@endif
                <p class="help">{{ $job->vehicleLabel() }}</p>
            </div>
        </section>
        <table class="table">
            <tr><th>Description</th><th>Qty</th><th>Unit price</th><th>Amount</th></tr>
            @foreach($job->items as $item)
                <tr>
                    <td>{{ $item->title }}</td>
                    <td>{{ rtrim(rtrim(number_format((float) $item->quantity, 2), '0'), '.') }}</td>
                    <td>{{ money($item->unit_price) }}</td>
                    <td>{{ money($item->line_total) }}</td>
                </tr>
            @endforeach
        </table>
        <div class="invoice-totals">
            <p>Subtotal <strong>{{ money($job->subtotal) }}</strong></p>
            <p>GST {{ number_format((float) $job->gst_rate, 0) }}% <strong>{{ money($job->gst_amount) }}</strong></p>
            <p class="invoice-grand">Total due <strong>{{ money($job->total) }}</strong></p>
        </div>
        @if($job->notes)
            <p class="help">Notes: {{ $job->notes }}</p>
        @endif
        <p class="help">Prices are GST exclusive. Please pay {{ money($job->total) }} to Auto Bridge.</p>
    </article>
</body>
</html>
