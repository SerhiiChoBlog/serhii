@php
    /** @var array $sites */
@endphp

<div>
    <h2 class="home__title has-text-centered">Latest projects</h2>

    <div class="sites">
        @foreach ($sites as $site)
            <div class="site">
                <a href="{{ $site['href'] }}" target="_blank" class="site-image">
                    <img data-src="{{ asset($site['image']) }}"
                        alt="{{ $site['title'] }}"
                        class="smooth-loader"
                    />

                    <span class="site-title">{{ $site['title'] }}</span>
                </a>
            </div>
        @endforeach
    </div>
</div>
