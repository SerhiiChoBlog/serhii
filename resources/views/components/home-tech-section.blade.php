<div>
    <h2 class="title has-text-centered">{{ $header }}</h2>

    <div class="columns">
        @foreach ($techs as $tech)
            <div class="column">
                <div class="card is-shadowless tech-card">
                    <div class="card-image">
                        <figure class="image is-4by3 tech-image">
                            <img src="{{ asset($tech['image']) }}" alt="{{ $tech['title'] }}" />
                        </figure>
                    </div>
                    <div class="card-content has-text-centered">
                        <div class="title is-size-4">{{ $tech['title'] }}</div>
                        <div class="content is-size-5">{{ $tech['content'] }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
