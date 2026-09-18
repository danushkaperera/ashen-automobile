@extends('layouts.admin')
@section('title', 'Customers')
@section('content')
<div class="stats">
    <div class="stat-box"><span>All customers</span><strong>{{ $total }}</strong></div>
    <a class="stat-box" href="{{ route('admin.customers.index', ['type' => 'new']) }}"><span>New</span><strong>{{ $newCount }}</strong></a>
    <a class="stat-box" href="{{ route('admin.customers.index', ['type' => 'regular']) }}"><span>Regular</span><strong>{{ $regularCount }}</strong></a>
    <div class="stat-box"><span>Service registrations</span><strong>{{ $visitCount }}</strong></div>
</div>
<div class="toolbar">
    <form class="row-actions" method="GET">
        <input name="q" value="{{ request('q') }}" placeholder="Search name, phone or email" style="min-width:240px">
        <input type="hidden" name="type" value="{{ request('type') }}">
        <input type="hidden" name="service" value="{{ request('service') }}">
        <button class="btn secondary" type="submit">Search</button>
    </form>
</div>
<div class="tabs">
    <a href="{{ route('admin.customers.index') }}" class="{{ !request('type') && !request('service') ? 'active' : '' }}">All</a>
    <a href="{{ route('admin.customers.index', ['type' => 'new']) }}" class="{{ request('type') === 'new' ? 'active' : '' }}">New</a>
    <a href="{{ route('admin.customers.index', ['type' => 'regular']) }}" class="{{ request('type') === 'regular' ? 'active' : '' }}">Regular</a>
    @foreach($services as $service)
        <a href="{{ route('admin.customers.index', ['service' => $service->id]) }}" class="{{ (string) request('service') === (string) $service->id ? 'active' : '' }}">{{ $service->title }}</a>
    @endforeach
</div>
<div class="card">
<table class="table">
    <tr><th>Customer</th><th>Contact</th><th>Type</th><th>Visits</th><th>Last visit</th></tr>
    @forelse($customers as $customer)
        <tr>
            <td><a href="{{ route('admin.customers.show', $customer) }}">{{ $customer->name }}</a></td>
            <td>{{ $customer->phone }}@if($customer->email)<br><span class="help">{{ $customer->email }}</span>@endif</td>
            <td><span class="badge badge-{{ $customer->customerType() }}">{{ $customer->customerTypeLabel() }}</span></td>
            <td>{{ $customer->visit_count }}</td>
            <td>{{ $customer->last_visited_at?->format('d M Y') ?: '—' }}</td>
        </tr>
    @empty
        <tr><td colspan="5">No workshop customers yet.</td></tr>
    @endforelse
</table>
{{ $customers->links() }}
</div>
@endsection
