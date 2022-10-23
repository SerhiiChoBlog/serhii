<button
    onclick="window.print();return false;"
    type="button"
    {{ $attributes->merge(['class' => "bg-page rounded-full px-10 py-2 text-font print:hidden inline-flex items-center justify-center border border-border transition-colors hover:bg-page-second"]) }}
>
    <img
        src="{{ asset('storage/icons/pdf.svg') }}"
        class="w-6 h-6 m-0 mr-3"
        aria-hidden="true"
        alt="Download icon"
    />

    <span class="tracking-wide">Download PDF</span>
</button>
