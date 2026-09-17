@extends('layouts.admin')
@section('title', $item->exists ? 'Edit gallery item' : 'Add gallery item')
@section('content')
<form class="card" method="POST" action="{{ $item->exists ? route('admin.gallery.update', $item) : route('admin.gallery.store') }}" enctype="multipart/form-data">
    @csrf
    @if($item->exists) @method('PUT') @endif
    <label>Title</label><input name="title" value="{{ old('title', $item->title) }}" required>
    <label>Category</label><input name="category" value="{{ old('category', $item->category) }}" placeholder="workshop, repairs">
    <label>Caption</label><input name="caption" value="{{ old('caption', $item->caption) }}">
    <label>Order</label><input name="sort_order" value="{{ old('sort_order', $item->sort_order ?? 0) }}">
    <label>Image</label><input type="file" name="image" accept="image/*">
    <label class="check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $item->is_active ?? true))> Active</label>
    <button class="btn" style="margin-top:16px">Save</button>
</form>
@endsection
