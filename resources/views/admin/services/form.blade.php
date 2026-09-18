@extends('layouts.admin')
@section('title', $service->exists ? 'Edit service' : 'Add service')
@section('content')
<form class="card" method="POST" action="{{ $service->exists ? route('admin.services.update', $service) : route('admin.services.store') }}" enctype="multipart/form-data">
    @csrf
    @if($service->exists) @method('PUT') @endif
    <label>Title</label>
    <input name="title" value="{{ old('title', $service->title) }}" required>
    <label>Slug</label>
    <input name="slug" value="{{ old('slug', $service->slug) }}">
    <label>Short description</label>
    <input name="short_description" value="{{ old('short_description', $service->short_description) }}">
    <label>Full description (HTML allowed)</label>
    <textarea name="description" style="min-height:180px">{{ old('description', $service->description) }}</textarea>
    <div class="form-grid">
        <div><label>Price (NZD, GST exclusive)</label><input type="number" step="0.01" min="0" name="price" value="{{ old('price', $service->price ?? 0) }}"></div>
        <div><label>Price label</label><input name="price_label" value="{{ old('price_label', $service->price_label) }}" placeholder="Shown on website if set"></div>
        <div><label>Icon key</label><input name="icon" value="{{ old('icon', $service->icon) }}"></div>
        <div><label>Order</label><input name="sort_order" value="{{ old('sort_order', $service->sort_order ?? 0) }}"></div>
    </div>
    <label>Image</label>
    <input type="file" name="image" accept="image/*">
    <label class="check"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $service->is_featured))> Featured</label>
    <label class="check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $service->is_active ?? true))> Active</label>
    <button class="btn" type="submit" style="margin-top:16px">Save</button>
</form>
@endsection
