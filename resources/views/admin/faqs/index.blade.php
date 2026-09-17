@extends('layouts.admin')
@section('title', 'FAQs')
@section('content')
<div class="toolbar"><p></p><a class="btn" href="{{ route('admin.faqs.create') }}">Add FAQ</a></div>
<div class="card">
<table class="table">
<tr><th>Question</th><th></th></tr>
@foreach($faqs as $faq)
<tr>
    <td>{{ $faq->question }}</td>
    <td class="row-actions">
        <a class="btn small secondary" href="{{ route('admin.faqs.edit', $faq) }}">Edit</a>
        <form method="POST" action="{{ route('admin.faqs.destroy', $faq) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn small danger">Delete</button></form>
    </td>
</tr>
@endforeach
</table>
</div>
@endsection
