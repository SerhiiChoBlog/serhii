@php
    /** @var array[] $techs */
@endphp

<div>
    <div class="grid grid-cols-1 {{ count($techs) === 3 ? 'lg:grid-cols-3' : 'lg:grid-cols-4' }} print:grid-cols-2 gap-7">
        @foreach ($techs as $tech)
            <div class="max-w-[420px] mx-auto">
                <div>
                    <figure>
                        <img
                            src="{{ asset($tech['image_xs']) }}"
                            data-src="{{ asset($tech['image']) }}"
                            alt="{{ $tech['title'] }}"
                            class="max-w-[130px] print:max-w-[50px] mx-auto drop-shadow-md"
                            width="130"
                            height="130"
                        />
                    </figure>
                </div>
                <div class="p-3 text-center">
                    <div class="text-2xl py-4">{{ $tech['title'] }}</div>
                    <div class="text-lg font-light">{!! $tech['content'] !!}</div>
                </div>
            </div>
        @endforeach
    </div>
</div>
