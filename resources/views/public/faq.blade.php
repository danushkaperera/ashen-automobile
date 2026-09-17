@extends('layouts.public')
@section('content')
<section class="page-hero"><div class="container"><h1>FAQ</h1><p>Straight answers before you book a bay.</p></div></section>
<section class="section">
    <div class="container faq">
        @foreach($faqs as $faq)
            <details><summary>{{ $faq->question }}</summary><p>{{ $faq->answer }}</p></details>
        @endforeach
    </div>
</section>
@endsection
