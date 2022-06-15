<div class="inline-block w-full">
    @isset ($title)
        <label for="id-{{ $name }}" class="font-bold text-sm mb-2 text-font-second block">
            {{ $title }}
        </label>
    @endisset

    <input type="{{ $type }}"
        name="{{ $name }}"
        id="id-{{ $name }}"
        class="border py-2 px-3 rounded-md w-full min-h-[42px]"
        placeholder="{{ $placeholder ?? '' }}"
        value="{{ $value ?? '' }}"
        {{ isset($required) ? 'required' : '' }}
    />

    @error($name)
        <span class="text-sm text-red-700">{{ $message }}</span>
    @enderror
</div>
