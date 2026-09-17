@extends('layouts.admin')
@section('title', $slide->exists ? 'Edit slide' : 'Add slide')
@section('content')
<form class="card" method="POST" action="{{ $slide->exists ? route('admin.heroes.update', $slide) : route('admin.heroes.store') }}" enctype="multipart/form-data">
    @csrf
    @if($slide->exists) @method('PUT') @endif
    <label>Title</label>
    <input name="title" value="{{ old('title', $slide->title) }}" required>
    <label>Subtitle</label>
    <input name="subtitle" value="{{ old('subtitle', $slide->subtitle) }}">
    <label>Description</label>
    <textarea name="description">{{ old('description', $slide->description) }}</textarea>
    <div class="form-grid">
        <div><label>Button text</label><input name="cta_text" value="{{ old('cta_text', $slide->cta_text) }}"></div>
        <div><label>Button URL</label><input name="cta_url" value="{{ old('cta_url', $slide->cta_url) }}"></div>
        <div><label>Second button text</label><input name="secondary_cta_text" value="{{ old('secondary_cta_text', $slide->secondary_cta_text) }}"></div>
        <div><label>Second button URL</label><input name="secondary_cta_url" value="{{ old('secondary_cta_url', $slide->secondary_cta_url) }}"></div>
        <div><label>Order</label><input name="sort_order" value="{{ old('sort_order', $slide->sort_order ?? 0) }}"></div>
    </div>
    <label>Image</label>
    <input type="file" name="image" accept="image/*">
    @if($slide->image)<img class="thumb" src="{{ media_url($slide->image) }}" alt="">@endif
    <label class="check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $slide->is_active ?? true))> Active</label>
    <button class="btn" type="submit" style="margin-top:16px">Save</button>
</form>
@endsection
