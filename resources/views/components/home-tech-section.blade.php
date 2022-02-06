@php
    /** @var string $header */
    /** @var array[] $techs */
@endphp

<div>
    <h2 class="home__title has-text-centered">{{ $header }}</h2>

    <div class="columns">
        @foreach ($techs as $tech)
            <div class="column">
                <div class="card is-shadowless tech-card">
                    <div class="card-image">
                        <figure class="image is-4by3 tech-image">
                            <img data-src="{{ asset($tech['image']) }}" alt="{{ $tech['title'] }}" class="smooth-loader" />
                        </figure>
                    </div>
                    <div class="card-content has-text-centered">
                        <div class="title is-size-4">{{ $tech['title'] }}</div>
                        <div class="content is-size-5 font-color">{!! $tech['content'] !!}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
