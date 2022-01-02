@php
    /** @var array $sites */
@endphp

@section('title', 'Professional software developer')

<div>
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
