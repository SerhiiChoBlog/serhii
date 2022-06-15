<div class="inline-block w-full">
    @isset ($title)
        <label @isset($id) for="{{ $id }}" @else for="id-{{ $name }}" @endisset
            class="font-bold text-sm mb-2 text-font-second block"
        >
            {{ $title }}
            {{ $slot }}
        </label>
    @endisset

    <input type="{{ $type }}"
        name="{{ $name }}"
        @isset($id) id="{{ $id }}" @else id="id-{{ $name }}" @endisset
        class="border py-2 px-3 rounded-md w-full min-h-[42px]"
        placeholder="{{ $placeholder ?? '' }}"
        value="{{ $value ?? '' }}"
        @isset($required) required @endisset
    />

    @error($name)
        <span class="text-sm text-red-700">{{ $message }}</span>
    @enderror
</div>
