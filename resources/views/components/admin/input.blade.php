<div>
    <label for="id-{{ $name }}" class="label">{{ $title }}</label>
    <input type="{{ $type }}"
        name="{{ $name }}"
        id="id-{{ $name }}"
        class="border py-2 px-3 rounded-md w-full max-w-[360px] min-h-[42px]"
        placeholder="{{ $placeholder ?? '' }}"
    >
</div>
