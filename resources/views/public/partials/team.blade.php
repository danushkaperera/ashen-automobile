<section class="section">
    <div class="container">
        <div class="section-head">
            <h2>{{ $section->heading }}</h2>
            <p class="muted">{{ $section->subheading }}</p>
        </div>
        <div class="grid-3">
            @foreach($team as $member)
                <article class="team-card">
                    <img src="{{ media_url($member->photo, asset('images/team-1.svg')) }}" alt="{{ $member->name }}">
                    <h3>{{ $member->name }}</h3>
                    <p class="muted">{{ $member->role }}</p>
                    <p>{{ $member->bio }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
