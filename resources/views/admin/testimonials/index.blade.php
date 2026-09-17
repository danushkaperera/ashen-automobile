@extends('layouts.admin')
@section('title', 'Testimonials')
@section('content')
<div class="toolbar"><p></p><a class="btn" href="{{ route('admin.testimonials.create') }}">Add testimonial</a></div>
<div class="card">
<table class="table">
<tr><th>Customer</th><th>Rating</th><th></th></tr>
@foreach($testimonials as $item)
<tr>
    <td>{{ $item->customer_name }}</td>
    <td>{{ $item->rating }}</td>
    <td class="row-actions">
        <a class="btn small secondary" href="{{ route('admin.testimonials.edit', $item) }}">Edit</a>
        <form method="POST" action="{{ route('admin.testimonials.destroy', $item) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn small danger">Delete</button></form>
    </td>
</tr>
@endforeach
</table>
</div>
@endsection
