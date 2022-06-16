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

    @isset($textarea)
        <textarea
    @else
        <input
    @endisset

        @isset($id) type="{{ $type }}" @endisset
        name="{{ $name }}"
        @isset($id) id="{{ $id }}" @else id="id-{{ $name }}" @endisset
        class="border py-2 px-3 rounded-md w-full min-h-[42px] {{ $class ?? '' }}"
        placeholder="{{ $placeholder ?? '' }}"
        value="{{ $value ?? '' }}"
        @isset($required) required @endisset

    @isset($textarea)
        >{{ $value ?? '' }}</textarea>
    @else
        />
    @endisset

    @error($name)
        <span class="text-sm text-red-700">{{ $message }}</span>
    @enderror
</div>
