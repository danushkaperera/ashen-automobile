@extends('layouts.staff')
@section('title', $job->exists ? 'Edit '.$job->number : 'New job')
@section('content')
<p class="help" style="margin-top:0">Add the customer, then add as many workshop services or other items as you need.</p>
<form class="card" method="POST" action="{{ $job->exists ? route('staff.jobs.update', $job) : route('staff.jobs.store') }}" data-lookup-form data-job-form>
    @csrf
    @if($job->exists) @method('PUT') @endif
    <div class="lookup-banner" data-lookup-banner hidden></div>
    <h3>Customer</h3>
    <div class="form-grid">
        <div><label>Name</label><input name="name" value="{{ old('name', $job->customer_name) }}" required></div>
        <div><label>Phone</label><input name="phone" value="{{ old('phone', $job->customer_phone) }}" required></div>
        <div><label>Email</label><input type="email" name="email" value="{{ old('email', $job->customer_email) }}"></div>
        <div><label>Address</label><input name="address" value="{{ old('address', $job->customer_address) }}"></div>
        <div><label>Vehicle make</label><input name="vehicle_make" value="{{ old('vehicle_make', $job->vehicle_make) }}"></div>
        <div><label>Vehicle model</label><input name="vehicle_model" value="{{ old('vehicle_model', $job->vehicle_model) }}"></div>
        <div><label>Year</label><input name="vehicle_year" value="{{ old('vehicle_year', $job->vehicle_year) }}"></div>
    </div>
    <label>Notes</label>
    <textarea name="notes">{{ old('notes', $job->notes) }}</textarea>

    <div class="toolbar" style="margin-top:20px">
        <h3 style="margin:0">Services on this job</h3>
        <div class="row-actions">
            <button class="btn small secondary" type="button" data-add-service>Add service</button>
            <button class="ghost" type="button" data-add-other>Add other service</button>
        </div>
    </div>
    <table class="table" data-job-lines>
        <tr><th>Service</th><th>Qty</th><th>Price</th><th>Line</th><th></th></tr>
        <tbody data-job-body>
            @foreach($items as $index => $item)
                @include('staff.jobs._line', ['index' => $index, 'item' => $item, 'services' => $services])
            @endforeach
        </tbody>
    </table>
    <p class="help" data-job-total>Subtotal $0.00 · GST $0.00 · Total $0.00</p>
    <div class="row-actions" style="margin-top:16px">
        <button class="btn">Save job</button>
        <a class="ghost" href="{{ route('staff.jobs.index') }}">Cancel</a>
    </div>
</form>
<template id="job-line-template">
    @include('staff.jobs._line', ['index' => '__INDEX__', 'item' => ['service_id' => '', 'title' => '', 'quantity' => 1, 'unit_price' => ''], 'services' => $services])
</template>
<script>
    const catalog = @json($services->map(fn ($service) => ['id' => $service->id, 'title' => $service->title, 'price' => (float) $service->price]));
    const form = document.querySelector('[data-job-form]');
    const body = form.querySelector('[data-job-body]');
    const template = document.getElementById('job-line-template');

    function money(value) {
        return '$' + (Number(value) || 0).toFixed(2);
    }
    function reindex() {
        [...body.querySelectorAll('[data-job-row]')].forEach((row, index) => {
            row.querySelectorAll('[name]').forEach((input) => {
                input.name = input.name.replace(/items\[\d+\]|items\[__INDEX__\]/, 'items[' + index + ']');
            });
        });
    }
    function totals() {
        let subtotal = 0;
        body.querySelectorAll('[data-job-row]').forEach((row) => {
            const qty = Number(row.querySelector('[data-qty]').value) || 0;
            const price = Number(row.querySelector('[data-price]').value) || 0;
            const line = qty * price;
            row.querySelector('[data-line]').textContent = money(line);
            subtotal += line;
        });
        const gst = subtotal * 0.15;
        form.querySelector('[data-job-total]').textContent = 'Subtotal ' + money(subtotal) + ' · GST ' + money(gst) + ' · Total ' + money(subtotal + gst);
    }
    function bindRow(row) {
        row.querySelector('[data-service]')?.addEventListener('change', (event) => {
            const service = catalog.find((item) => String(item.id) === event.target.value);
            if (!service) return;
            row.querySelector('[data-title]').value = service.title;
            row.querySelector('[data-price]').value = service.price;
            totals();
        });
        row.querySelectorAll('[data-qty], [data-price]').forEach((input) => input.addEventListener('input', totals));
        row.querySelector('[data-remove]')?.addEventListener('click', () => {
            if (body.querySelectorAll('[data-job-row]').length === 1) return;
            row.remove();
            reindex();
            totals();
        });
    }
    function addRow(other = false) {
        const wrap = document.createElement('tbody');
        wrap.innerHTML = template.innerHTML.replaceAll('__INDEX__', String(body.querySelectorAll('[data-job-row]').length));
        const row = wrap.querySelector('[data-job-row]');
        if (other) {
            row.querySelector('[data-service]').value = '';
            row.querySelector('[data-title]').value = '';
            row.querySelector('[data-title]').focus();
        }
        body.appendChild(row);
        bindRow(row);
        reindex();
        totals();
    }
    body.querySelectorAll('[data-job-row]').forEach(bindRow);
    form.querySelector('[data-add-service]').addEventListener('click', () => addRow(false));
    form.querySelector('[data-add-other]').addEventListener('click', () => addRow(true));
    totals();
</script>
@endsection
