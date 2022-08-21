@php
    /** @var array $sites */
@endphp

<div>
    <div class="flex flex-col lg:flex-row items-center justify-center py-7">
        @foreach ($sites as $site)
            <div class="
            lg:skew-y-[-3deg] mb-12 first:ml-0 hover:translate-y-[-20px] duration-300 relative lg:transition-transform
            lg:ml-[-100px] lg:mb-0 before:left-0 before:absolute before:right-0 before:h-3 before:bg-[#282829]
            before:top-[-11px] before:rounded-t-lg
            ">
                <a href="{{ $site['href'] }}" target="_blank" class="max-w-[350px] block">
                    <img src="{{ asset('storage/tools/mac-buttons.webp') }}"
                        class="absolute top-[-8px] left-2"
                        width="18"
                        alt="mac buttons"
                    >

                    <img data-src="{{ asset($site['image']) }}"
                        alt="{{ $site['title'] }}"
                        class="rounded-b-lg shadow-[-10px_10px_5px_rgba(0,0,0,.05)]"
                        width="350"
                        height="251"
                    />

                    <span class="block text-font-second text-xl text-center mt-3 font-light">
                        {{ $site['title'] }}
                    </span>

                    <div class="flex gap-3 justify-center mt-3">
                        @foreach ($site['technologies'] as $tech)
                            <img
                                src="{{ asset("storage/languages/$tech.webp") }}"
                                alt="{{ $tech }}"
                                width="80"
                                height="80"
                                class="w-8 h-8 filter"
                            />
                        @endforeach
                    </div>

                </a>
            </div>
        @endforeach
    </div>
</div>
