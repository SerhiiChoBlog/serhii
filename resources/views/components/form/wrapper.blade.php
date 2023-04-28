@php
    /**
     * @var string|null $title
     * @var string|null $intro
     * @var string|null $infoTitle
     * @var string|null $infoIntro
     * @var string|null $info
     * @var string|null $slot
     */
@endphp

<div class="py-10 lg:py-20 relative bg-page-second dark:bg-page">
    <div class="mx-4 lg:mx-10 text-center">
        <div class="inline-flex flex-col md:flex-row mx-auto text-left">
            @if(isset($infoTitle) || isset($infoIntro))
                <div
                    class="relative p-10 xl:p-16 md:translate-x-4 translate-y-4 rounded-xl shadow-lg bg-no-repeat bg-cover max-w-[500px] bg-gray-600"
                >
                    <div class="relative">
                        <div class="bg-black/70 p-5 rounded-lg">
                            @isset($infoTitle)
                                <h2 class="text-white text-2xl lg:text-3xl">
                                    {{ $infoTitle }}
                                </h2>
                            @endisset

                            @isset($infoIntro)
                                <h2 class="text-lg mt-2 text-white">
                                    {{ $infoIntro }}
                                </h2>
                            @endisset
                        </div>

                        @isset($info)
                            <div>{{ $info }}</div>
                        @endisset
                    </div>
                </div>
            @endif

            <div class="p-10 xl:p-20 w-auto bg-page dark:bg-page-second rounded-xl shadow-lg lg:min-w-[520px]">
                <div class="mb-9">
                    @isset($title)
                        <h1 class="text-2xl lg:text-4xl text-main">{{ $title }}</h1>
                    @endisset

                    @isset($intro)
                        <h2 class="text-font-second max-w-[430px]">{{ $intro }}</h2>
                    @endisset
                </div>

                {{ $slot }}
            </div>
        </div>
    </div>
</div>
