<div class="text-center">
    <button
        type="{{ $type ?? 'submit' }}"
        class="inline-block min-w-[200px] mx-auto px-5 py-3 text-main font-bold uppercase border-2 border-main rounded-full hover:border-decor hover:text-decor transition-colors text-sm lg:text-md"
    >
        {{ $slot }}
    </button>
</div>
