@extends('layouts.admin')
@section('title', $feature->exists ? 'Edit feature' : 'Add feature')
@section('content')
<form class="card" method="POST" action="{{ $feature->exists ? route('admin.features.update', $feature) : route('admin.features.store') }}">
    @csrf
    @if($feature->exists) @method('PUT') @endif
    <label>Title</label><input name="title" value="{{ old('title', $feature->title) }}" required>
    <label>Description</label><textarea name="description">{{ old('description', $feature->description) }}</textarea>
    <label>Icon key</label><input name="icon" value="{{ old('icon', $feature->icon) }}">
    <label>Order</label><input name="sort_order" value="{{ old('sort_order', $feature->sort_order ?? 0) }}">
    <label class="check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $feature->is_active ?? true))> Active</label>
    <button class="btn" style="margin-top:16px">Save</button>
</form>
@endsection
