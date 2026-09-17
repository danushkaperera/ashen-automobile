@extends('layouts.public')
@php
    $pageTitle = $page->meta_title ?: $page->title.' | '.setting('site_name');
    $pageDescription = $page->meta_description;
@endphp
@section('content')
<section class="page-hero"><div class="container"><h1>{{ $page->title }}</h1></div></section>
<section class="section">
    <div class="container prose" style="max-width:860px">
        {!! $page->content !!}
    </div>
</section>
@endsection
