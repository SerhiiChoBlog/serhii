<div class="mx-auto max-w-md">
    <label for="id-{{ $name }}" class="font-bold text-sm mb-2 text-gray-600 block">
        {{ $title }}
    </label>

    <input type="{{ $type }}"
        name="{{ $name }}"
        id="id-{{ $name }}"
        class="border py-2 px-3 rounded-md w-full min-h-[42px]"
        placeholder="{{ $placeholder ?? '' }}"
        value="{{ $value ?? '' }}"
    />

    @error($name)
        <span class="text-sm text-red-700">{{ $message }}</span>
    @enderror
</div>
