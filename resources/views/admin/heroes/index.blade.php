@extends('layouts.admin')
@section('title', 'Hero slides')
@section('content')
<div class="toolbar">
    <p class="help">Homepage banner slides. Upload images and set call-to-action buttons.</p>
    <a class="btn" href="{{ route('admin.heroes.create') }}">Add slide</a>
</div>
<div class="card">
    <table class="table">
        <tr><th></th><th>Title</th><th>Order</th><th>Active</th><th></th></tr>
        @foreach($slides as $slide)
            <tr>
                <td>@if($slide->image)<img class="thumb" src="{{ media_url($slide->image) }}" alt="">@endif</td>
                <td>{{ $slide->title }}</td>
                <td>{{ $slide->sort_order }}</td>
                <td>{{ $slide->is_active ? 'Yes' : 'No' }}</td>
                <td class="row-actions">
                    <a class="btn small secondary" href="{{ route('admin.heroes.edit', $slide) }}">Edit</a>
                    <form method="POST" action="{{ route('admin.heroes.destroy', $slide) }}" onsubmit="return confirm('Delete this slide?')">
                        @csrf @method('DELETE')
                        <button class="btn small danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
</div>
@endsection
