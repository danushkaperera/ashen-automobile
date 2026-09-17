@extends('layouts.admin')
@section('title', 'Profile')
@section('content')
<form class="card" method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    <label>Name</label><input name="name" value="{{ old('name', $user->name) }}" required>
    <label>Email</label><input type="email" name="email" value="{{ old('email', $user->email) }}" required>
    <label>Phone</label><input name="phone" value="{{ old('phone', $user->phone) }}">
    <label>New password</label><input type="password" name="password">
    <label>Confirm password</label><input type="password" name="password_confirmation">
    <label>Avatar</label><input type="file" name="avatar" accept="image/*">
    <button class="btn" style="margin-top:16px">Save profile</button>
</form>
@endsection
