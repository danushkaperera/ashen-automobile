@extends('layouts.public')

@section('content')
    @foreach($sections as $section)
        @if($section->is_enabled && view()->exists('public.partials.'.$section->key))
            @include('public.partials.'.$section->key, ['section' => $section])
        @endif
    @endforeach
@endsection
