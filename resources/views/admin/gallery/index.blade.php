@extends('layouts.admin')
@section('title', 'Gallery')
@section('content')
<div class="toolbar"><p></p><a class="btn" href="{{ route('admin.gallery.create') }}">Add image</a></div>
<div class="card">
<table class="table">
<tr><th></th><th>Title</th><th>Category</th><th></th></tr>
@foreach($items as $item)
<tr>
    <td>@if($item->image)<img class="thumb" src="{{ media_url($item->image) }}" alt="">@endif</td>
    <td>{{ $item->title }}</td>
    <td>{{ $item->category }}</td>
    <td class="row-actions">
        <a class="btn small secondary" href="{{ route('admin.gallery.edit', $item) }}">Edit</a>
        <form method="POST" action="{{ route('admin.gallery.destroy', $item) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn small danger">Delete</button></form>
    </td>
</tr>
@endforeach
</table>
</div>
@endsection
