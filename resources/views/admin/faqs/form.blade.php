@extends('layouts.admin')
@section('title', $faq->exists ? 'Edit FAQ' : 'Add FAQ')
@section('content')
<form class="card" method="POST" action="{{ $faq->exists ? route('admin.faqs.update', $faq) : route('admin.faqs.store') }}">
    @csrf
    @if($faq->exists) @method('PUT') @endif
    <label>Question</label><input name="question" value="{{ old('question', $faq->question) }}" required>
    <label>Answer</label><textarea name="answer" required>{{ old('answer', $faq->answer) }}</textarea>
    <label>Order</label><input name="sort_order" value="{{ old('sort_order', $faq->sort_order ?? 0) }}">
    <label class="check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $faq->is_active ?? true))> Active</label>
    <button class="btn" style="margin-top:16px">Save</button>
</form>
@endsection
