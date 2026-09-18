@extends('layouts.admin')
@section('title', $customer->name)
@section('content')
<p><span class="badge badge-{{ $customer->customerType() }}">{{ $customer->customerTypeLabel() }}</span> · {{ $customer->visit_count }} visit{{ $customer->visit_count === 1 ? '' : 's' }}</p>
<div class="form-grid">
    <div class="card">
        <h3>Contact</h3>
        <p>{{ $customer->phone }}</p>
        <p>{{ $customer->email ?: 'No email' }}</p>
        <p>{{ $customer->address ?: 'No address' }}</p>
        <p class="help">{{ $customer->vehicle_make }} {{ $customer->vehicle_model }} {{ $customer->vehicle_year }}</p>
    </div>
    <div class="card">
        <h3>Visit history</h3>
        <table class="table">
            <tr><th>When</th><th>Service</th><th>Recorded by</th></tr>
            @foreach($customer->visits as $visit)
                <tr>
                    <td>{{ $visit->visited_at?->format('d M Y H:i') }}</td>
                    <td>{{ $visit->categoryLabel() }}@if($visit->notes)<br><span class="help">{{ $visit->notes }}</span>@endif</td>
                    <td>{{ $visit->staff->name ?? '—' }}</td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection
