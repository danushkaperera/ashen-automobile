@extends('layouts.admin')
@section('title', 'Message')
@section('content')
<div class="card">
    <p><strong>{{ $message->name }}</strong> · {{ $message->email }} · {{ $message->phone }}</p>
    <p>{{ $message->subject }}</p>
    <p>{{ $message->message }}</p>
    <p class="help">{{ $message->created_at->format('d M Y H:i') }}</p>
    <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Delete this message?')">
        @csrf @method('DELETE')
        <button class="btn danger">Delete</button>
    </form>
</div>
@endsection
