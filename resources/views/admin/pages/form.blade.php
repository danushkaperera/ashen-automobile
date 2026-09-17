@extends('layouts.admin')
@section('title', $page->exists ? 'Edit page' : 'Add page')
@section('content')
<form class="card" method="POST" action="{{ $page->exists ? route('admin.pages.update', $page) : route('admin.pages.store') }}">
    @csrf
    @if($page->exists) @method('PUT') @endif
    <label>Title</label><input name="title" value="{{ old('title', $page->title) }}" required>
    <label>Slug</label><input name="slug" value="{{ old('slug', $page->slug) }}">
    <label>Content (HTML allowed)</label><textarea name="content" style="min-height:240px">{{ old('content', $page->content) }}</textarea>
    <label>Meta title</label><input name="meta_title" value="{{ old('meta_title', $page->meta_title) }}">
    <label>Meta description</label><textarea name="meta_description">{{ old('meta_description', $page->meta_description) }}</textarea>
    <label class="check"><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $page->is_published ?? true))> Published</label>
    <button class="btn" style="margin-top:16px">Save</button>
</form>
@endsection
