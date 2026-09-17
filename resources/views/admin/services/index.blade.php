@extends('layouts.admin')
@section('title', 'Services')
@section('content')
<div class="toolbar">
    <p class="help">Repair categories shown on the public website.</p>
    <a class="btn" href="{{ route('admin.services.create') }}">Add service</a>
</div>
<div class="card">
    <table class="table">
        <tr><th>Title</th><th>Price</th><th>Featured</th><th>Active</th><th></th></tr>
        @foreach($services as $service)
            <tr>
                <td>{{ $service->title }}</td>
                <td>{{ $service->price_label }}</td>
                <td>{{ $service->is_featured ? 'Yes' : 'No' }}</td>
                <td>{{ $service->is_active ? 'Yes' : 'No' }}</td>
                <td class="row-actions">
                    <a class="btn small secondary" href="{{ route('admin.services.edit', $service) }}">Edit</a>
                    <form method="POST" action="{{ route('admin.services.destroy', $service) }}" onsubmit="return confirm('Delete this service?')">
                        @csrf @method('DELETE')
                        <button class="btn small danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
</div>
@endsection
