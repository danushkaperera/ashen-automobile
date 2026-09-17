@extends('layouts.admin')
@section('title', 'Stats')
@section('content')
<div class="toolbar"><p></p><a class="btn" href="{{ route('admin.stats.create') }}">Add stat</a></div>
<div class="card">
<table class="table">
<tr><th>Value</th><th>Label</th><th></th></tr>
@foreach($stats as $stat)
<tr>
    <td>{{ $stat->value }}</td>
    <td>{{ $stat->label }}</td>
    <td class="row-actions">
        <a class="btn small secondary" href="{{ route('admin.stats.edit', $stat) }}">Edit</a>
        <form method="POST" action="{{ route('admin.stats.destroy', $stat) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn small danger">Delete</button></form>
    </td>
</tr>
@endforeach
</table>
</div>
@endsection
