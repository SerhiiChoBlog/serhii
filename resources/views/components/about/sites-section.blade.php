@php
    /** @var array $sites */
@endphp

<div>
    <div class="flex flex-col lg:flex-row items-center justify-center py-7">
        @foreach ($sites as $site)
            <div class="skew-y-[-7deg] mb-5 lg:mb-0 lg:transition-transform lg:ml-[-80px] first:ml-0 hover:translate-y-[-10px] duration-300">
                <a href="{{ $site['href'] }}" target="_blank" class="max-w-[350px] block">
                    <img data-src="{{ asset($site['image']) }}"
                        alt="{{ $site['title'] }}"
                        class="smooth-loader rounded-lg shadow-[-19px_29px_13px_rgba(0,0,0,.1)]"
                    />

                    <span class="block text-font-second text-xl text-center drop-shadow-[-7px_7px_6px_rgba(0,0,0,.4)] mt-3 font-light">
                        {{ $site['title'] }}
                    </span>
                </a>
            </div>
        @endforeach
    </div>
</div>
