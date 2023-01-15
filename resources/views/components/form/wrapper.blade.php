@php
    /**
     * @var string|null $image
     * @var string|null $title
     * @var string|null $intro
     * @var string|null $infoTitle
     * @var string|null $infoIntro
     * @var string|null $info
     * @var string|null $slot
     */
@endphp

<div class="py-10 lg:py-20 relative bg-gray-50">
    <div class="mx-4 lg:mx-10 text-center">
        <div class="inline-flex flex-col md:flex-row mx-auto text-left">
            @if(isset($img) || isset($infoTitle) || isset($infoIntro))
                <div
                    class="relative p-10 xl:p-20 md:translate-x-4 translate-y-4 rounded-xl shadow-lg bg-no-repeat bg-cover max-w-[500px] bg-gray-600"
                    @isset ($img)
                        style="background-image: url({{ asset("storage/form-images/{$img}") }})"
                    @endisset
                >
                    <div class="relative">
                        @isset($infoTitle)
                            <h1 class="text-white text-2xl lg:text-3xl">
                                {{ $infoTitle }}
                            </h1>
                        @endisset

                        @isset($infoIntro)
                            <h2 class="text-lg mt-2 text-white">
                                {{ $infoIntro }}
                            </h2>
                        @endisset

                        @isset($info)
                            <div>{{ $info }}</div>
                        @endisset
                    </div>
                </div>
            @endif

            <div class="p-10 xl:p-20 w-auto bg-page rounded-xl shadow-lg lg:min-w-[520px]">
                <div class="mb-9">
                    @isset($title)
                        <h1 class="text-2xl text-main">{{ $title }}</h1>
                    @endisset

                    @isset($intro)
                        <h2 class="text-font-second">{{ $intro }}</h2>
                    @endisset
                </div>

                {{ $slot }}
            </div>
        </div>
    </div>
</div>
