@php
    use Illuminate\Support\HtmlString;

    /**
     * @var HtmlString $slot
     * @var ?string $id
     * @var string $name
     * @var ?string $type
     * @var ?string $value
     * @var ?string $message
     * @var ?string $placeholder
     * @var ?string $class
     */
@endphp

<div class="inline-block w-full">
    @if (!$slot->isEmpty())
        <label @isset($id) for="{{ $id }}" @else for="id-{{ $name }}" @endisset
        class="font-bold text-sm mb-2 text-font-second block"
        >
            {{ $slot }}
        </label>
    @endif

    <div class="inline-block relative w-full">
        @isset($textarea)
            <textarea
        @else
            <input
        @endisset

            @isset($id) type="{{ $type }}" @endisset
            name="{{ $name }}"
            @isset($id) id="{{ $id }}" @else id="id-{{ $name }}" @endisset
            class="border py-3 px-4 rounded-md w-full min-h-[42px] {{ $class ?? '' }}"
            placeholder="{{ $placeholder ?? '' }}"
            value="{{ $value ?? '' }}"
            @isset($required) required @endisset
            maxlength="{{ $maxlength ?? 0 }}"

        @isset($textarea)
            >{{ $value ?? '' }}</textarea>
        @else
            />
        @endisset

        @error($name)
            <span class="text-sm text-red-700">{{ $message }}</span>
        @enderror

        @if(isset($class) && str_contains($class, '_letter-counter'))
            @isset($textarea)
                <span class="_counter absolute top-0 bg-white -right-3 border p-1 rounded-full text-gray-400 text-sm"></span>
            @else
                <span class="_counter absolute bg-white rounded-full border p-1 top-1/2 -translate-y-1/2 -right-3 text-gray-400 text-sm"></span>
            @endisset
        @endif
    </div>
</div>
