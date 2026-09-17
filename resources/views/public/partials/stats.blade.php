<section class="stats-band">
    <div class="container grid-4">
        @foreach($stats as $stat)
            <div class="stat">
                <strong>{{ $stat->value }}</strong>
                <span>{{ $stat->label }}</span>
            </div>
        @endforeach
    </div>
</section>
