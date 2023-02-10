@php
    /**
     * @var string $title
     */
@endphp

<div class="flex justify-between items-center w-full text-lg lg:text-xl relative">
    <span class="bg-page inline-block z-10 pr-4">
        {{ $title }}:
    </span>

    <div class="border-b border-border top-1/2 -translate-y-1/2 border-dashed w-full absolute"></div>

    <div class="text-right leading-6 bg-page pl-4 z-10">
        {{ $slot }}
    </div>
</div>
