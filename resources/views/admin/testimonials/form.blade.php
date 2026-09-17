@extends('layouts.admin')
@section('title', $testimonial->exists ? 'Edit testimonial' : 'Add testimonial')
@section('content')
<form class="card" method="POST" action="{{ $testimonial->exists ? route('admin.testimonials.update', $testimonial) : route('admin.testimonials.store') }}" enctype="multipart/form-data">
    @csrf
    @if($testimonial->exists) @method('PUT') @endif
    <label>Customer name</label><input name="customer_name" value="{{ old('customer_name', $testimonial->customer_name) }}" required>
    <label>Vehicle</label><input name="vehicle" value="{{ old('vehicle', $testimonial->vehicle) }}">
    <label>Rating (1-5)</label><input type="number" min="1" max="5" name="rating" value="{{ old('rating', $testimonial->rating ?? 5) }}">
    <label>Quote</label><textarea name="content" required>{{ old('content', $testimonial->content) }}</textarea>
    <label>Order</label><input name="sort_order" value="{{ old('sort_order', $testimonial->sort_order ?? 0) }}">
    <label>Avatar</label><input type="file" name="avatar" accept="image/*">
    <label class="check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $testimonial->is_active ?? true))> Active</label>
    <button class="btn" style="margin-top:16px">Save</button>
</form>
@endsection
