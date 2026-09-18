@extends('layouts.admin')
@section('title', 'Jobs')
@section('content')
<p class="help" style="margin-top:0">Workshop jobs and invoices created from the staff portal.</p>
<div class="card">
<table class="table">
    <tr><th>Job</th><th>Invoice</th><th>Customer</th><th>Total</th><th>Status</th><th></th></tr>
    @forelse($jobs as $job)
        <tr>
            <td><a href="{{ route('admin.jobs.show', $job) }}">{{ $job->number }}</a></td>
            <td>{{ $job->invoice_number ?: '—' }}</td>
            <td>{{ $job->customer_name }}</td>
            <td>{{ money($job->total) }}</td>
            <td><span class="badge badge-{{ $job->status }}">{{ $job->statusLabel() }}</span></td>
            <td class="row-actions">
                @if($job->isInvoiced())
                    <a class="btn small" href="{{ route('admin.jobs.invoice', $job) }}">Invoice</a>
                @endif
            </td>
        </tr>
    @empty
        <tr><td colspan="6">No workshop jobs yet.</td></tr>
    @endforelse
</table>
{{ $jobs->links() }}
</div>
@endsection
