@extends('layouts.admin')
@section('title', $member->exists ? 'Edit team member' : 'Add team member')
@section('content')
<form class="card" method="POST" action="{{ $member->exists ? route('admin.team.update', $member) : route('admin.team.store') }}" enctype="multipart/form-data">
    @csrf
    @if($member->exists) @method('PUT') @endif
    <label>Name</label><input name="name" value="{{ old('name', $member->name) }}" required>
    <label>Role</label><input name="role" value="{{ old('role', $member->role) }}">
    <label>Bio</label><textarea name="bio">{{ old('bio', $member->bio) }}</textarea>
    <div class="form-grid">
        <div><label>Phone</label><input name="phone" value="{{ old('phone', $member->phone) }}"></div>
        <div><label>Email</label><input name="email" value="{{ old('email', $member->email) }}"></div>
        <div><label>Order</label><input name="sort_order" value="{{ old('sort_order', $member->sort_order ?? 0) }}"></div>
    </div>
    <label>Photo</label><input type="file" name="photo" accept="image/*">
    <label class="check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $member->is_active ?? true))> Active</label>
    <button class="btn" style="margin-top:16px">Save</button>
</form>
@endsection
