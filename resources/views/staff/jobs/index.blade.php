@extends('layouts.staff')
@section('title', 'Jobs')
@section('content')
<div class="toolbar">
    <p class="help" style="margin:0">Build a job from multiple services, then create the invoice.</p>
    <a class="btn" href="{{ route('staff.jobs.create') }}">New job</a>
</div>
<div class="card">
<table class="table">
    <tr><th>Job</th><th>Customer</th><th>Services</th><th>Total</th><th>Status</th><th></th></tr>
    @forelse($jobs as $job)
        <tr>
            <td><a href="{{ route('staff.jobs.show', $job) }}">{{ $job->number }}</a></td>
            <td>{{ $job->customer_name }}<br><span class="help">{{ $job->customer_phone }}</span></td>
            <td>{{ $job->items->pluck('title')->join(', ') }}</td>
            <td>{{ money($job->total) }}</td>
            <td><span class="badge badge-{{ $job->status }}">{{ $job->statusLabel() }}</span></td>
            <td class="row-actions">
                @if($job->isInvoiced())
                    <a class="btn small" href="{{ route('staff.jobs.invoice', $job) }}">Invoice</a>
                @endif
                @if($job->isDraft())
                    <a class="btn small secondary" href="{{ route('staff.jobs.edit', $job) }}">Edit</a>
                @endif
            </td>
        </tr>
    @empty
        <tr><td colspan="6">No jobs yet. Create one and add the services that were done.</td></tr>
    @endforelse
</table>
{{ $jobs->links() }}
</div>
@endsection
