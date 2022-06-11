@php
    /** @var array[] $techs */
@endphp

<div>
    <div class="flex gap-x-7">
        @foreach ($techs as $tech)
            <div>
                <div>
                    <div>
                        <figure>
                            <img data-src="{{ asset($tech['image']) }}"
                                alt="{{ $tech['title'] }}"
                                class="smooth-loader max-w-[130px] mx-auto"
                            />
                        </figure>
                    </div>
                    <div class="p-3 text-center">
                        <div class="text-2xl py-4">{{ $tech['title'] }}</div>
                        <div class="text-lg font-light">{!! $tech['content'] !!}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
