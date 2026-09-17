@extends('layouts.admin')
@section('title', 'Team')
@section('content')
<div class="toolbar"><p></p><a class="btn" href="{{ route('admin.team.create') }}">Add member</a></div>
<div class="card">
<table class="table">
<tr><th>Name</th><th>Role</th><th></th></tr>
@foreach($members as $member)
<tr>
    <td>{{ $member->name }}</td>
    <td>{{ $member->role }}</td>
    <td class="row-actions">
        <a class="btn small secondary" href="{{ route('admin.team.edit', $member) }}">Edit</a>
        <form method="POST" action="{{ route('admin.team.destroy', $member) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn small danger">Delete</button></form>
    </td>
</tr>
@endforeach
</table>
</div>
@endsection
