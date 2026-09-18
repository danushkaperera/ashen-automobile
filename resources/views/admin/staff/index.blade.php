@extends('layouts.admin')
@section('title', 'Staff users')
@section('content')
@include('admin.staff._tabs')
<div class="toolbar">
    <p class="help" style="margin:0">Staff logins open the workshop desk. They cannot open the admin dashboard unless you grant that page.</p>
    <a class="btn" href="{{ route('admin.staff.create') }}">Add staff user</a>
</div>
<div class="card">
<table class="table">
<tr><th>Name</th><th>Email</th><th>Access</th><th>Status</th><th></th></tr>
@forelse($users as $user)
<tr>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>{{ count($user->permissionKeys()) }} page{{ count($user->permissionKeys()) === 1 ? '' : 's' }}</td>
    <td>{{ $user->is_active ? 'Active' : 'Disabled' }}</td>
    <td class="row-actions">
        <a class="btn small secondary" href="{{ route('admin.staff.edit', $user) }}">Edit</a>
        <a class="btn small" href="{{ route('admin.staff.access') }}#staff-{{ $user->id }}">Access</a>
        <form method="POST" action="{{ route('admin.staff.destroy', $user) }}" onsubmit="return confirm('Remove this staff login?')">@csrf @method('DELETE')<button class="btn small danger">Delete</button></form>
    </td>
</tr>
@empty
<tr><td colspan="5">No staff users yet. Create one so the workshop can register customers.</td></tr>
@endforelse
</table>
</div>
@endsection
