@extends('layouts.admin')
@section('title', 'Pages')
@section('content')
<div class="toolbar"><p class="help">Custom pages such as licence or privacy.</p><a class="btn" href="{{ route('admin.pages.create') }}">Add page</a></div>
<div class="card">
<table class="table">
<tr><th>Title</th><th>Slug</th><th>Published</th><th></th></tr>
@foreach($pages as $page)
<tr>
    <td>{{ $page->title }}</td>
    <td>/p/{{ $page->slug }}</td>
    <td>{{ $page->is_published ? 'Yes' : 'No' }}</td>
    <td class="row-actions">
        <a class="btn small secondary" href="{{ route('admin.pages.edit', $page) }}">Edit</a>
        <form method="POST" action="{{ route('admin.pages.destroy', $page) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn small danger">Delete</button></form>
    </td>
</tr>
@endforeach
</table>
</div>
@endsection
