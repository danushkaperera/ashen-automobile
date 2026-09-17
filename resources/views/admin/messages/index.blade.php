@extends('layouts.admin')
@section('title', 'Messages')
@section('content')
<div class="card">
<table class="table">
<tr><th>From</th><th>Subject</th><th>Read</th><th></th></tr>
@forelse($messages as $message)
<tr>
    <td>{{ $message->name }}</td>
    <td>{{ $message->subject ?: '—' }}</td>
    <td>{{ $message->is_read ? 'Yes' : 'No' }}</td>
    <td><a class="btn small secondary" href="{{ route('admin.messages.show', $message) }}">Open</a></td>
</tr>
@empty
<tr><td colspan="4">No messages yet.</td></tr>
@endforelse
</table>
{{ $messages->links() }}
</div>
@endsection
