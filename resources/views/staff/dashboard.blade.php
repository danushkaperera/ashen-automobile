@extends('layouts.staff')
@section('title', 'Workshop desk')
@section('content')
<div class="stats">
    <div class="stat-box"><span>Today’s jobs</span><strong>{{ $todayVisits }}</strong></div>
    <div class="stat-box"><span>New customers</span><strong>{{ $newCustomers }}</strong></div>
    <div class="stat-box"><span>Regular customers</span><strong>{{ $regularCustomers }}</strong></div>
</div>
<div class="toolbar">
    <h3 style="margin:0">Register by service</h3>
    <div class="row-actions">
        <a class="btn secondary" href="{{ route('staff.services.index') }}">All services</a>
        @if(auth()->user()->hasPermission('staff.jobs'))
            <a class="btn" href="{{ route('staff.jobs.create') }}">New job</a>
        @endif
    </div>
</div>
@include('partials.service-cards', ['services' => $services, 'mode' => 'staff'])
<div class="card" style="margin-top:24px">
    <h3>Recent registrations</h3>
    <table class="table">
        <tr><th>Customer</th><th>Service</th><th>When</th></tr>
        @forelse($recentVisits as $visit)
            <tr>
                <td>
                    {{ $visit->customer->name }}
                    <span class="badge badge-{{ $visit->customer->customerType() }}">{{ $visit->customer->customerTypeLabel() }}</span>
                </td>
                <td>{{ $visit->categoryLabel() }}</td>
                <td>{{ $visit->visited_at?->format('d M Y H:i') }}</td>
            </tr>
        @empty
            <tr><td colspan="3">No workshop registrations yet.</td></tr>
        @endforelse
    </table>
</div>
@endsection
