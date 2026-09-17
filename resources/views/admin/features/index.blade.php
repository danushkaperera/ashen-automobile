@extends('layouts.admin')
@section('title', 'Why choose us')
@section('content')
<div class="toolbar"><p></p><a class="btn" href="{{ route('admin.features.create') }}">Add feature</a></div>
<div class="card">
<table class="table">
<tr><th>Title</th><th>Active</th><th></th></tr>
@foreach($features as $feature)
<tr>
    <td>{{ $feature->title }}</td>
    <td>{{ $feature->is_active ? 'Yes' : 'No' }}</td>
    <td class="row-actions">
        <a class="btn small secondary" href="{{ route('admin.features.edit', $feature) }}">Edit</a>
        <form method="POST" action="{{ route('admin.features.destroy', $feature) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn small danger">Delete</button></form>
    </td>
</tr>
@endforeach
</table>
</div>
@endsection
