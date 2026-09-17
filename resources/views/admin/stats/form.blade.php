@extends('layouts.admin')
@section('title', $stat->exists ? 'Edit stat' : 'Add stat')
@section('content')
<form class="card" method="POST" action="{{ $stat->exists ? route('admin.stats.update', $stat) : route('admin.stats.store') }}">
    @csrf
    @if($stat->exists) @method('PUT') @endif
    <label>Value</label><input name="value" value="{{ old('value', $stat->value) }}" required>
    <label>Label</label><input name="label" value="{{ old('label', $stat->label) }}" required>
    <label>Icon</label><input name="icon" value="{{ old('icon', $stat->icon) }}">
    <label>Order</label><input name="sort_order" value="{{ old('sort_order', $stat->sort_order ?? 0) }}">
    <label class="check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $stat->is_active ?? true))> Active</label>
    <button class="btn" style="margin-top:16px">Save</button>
</form>
@endsection
