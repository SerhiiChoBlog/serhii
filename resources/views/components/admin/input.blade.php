@php
    use Illuminate\Support\HtmlString;
    use Illuminate\View\ComponentAttributeBag;

    /**
     * @var HtmlString $slot
     * @var string|null $message
     * @var ComponentAttributeBag $attributes
     */

    $custom_classes = 'border py-3 px-4 rounded-md w-full';
    $id = $attributes->get('id');
    $value = $attributes->get('value');
@endphp

<div class="inline-block w-full">
    @if (!$slot->isEmpty())
        <label for="{{ $id ?? '' }}" class="font-bold text-sm mb-2 text-font-second block">
            {{ $slot }}
        </label>
    @endif

    <div class="inline-block relative w-full">
        @isset($textarea)
            <textarea {{ $attributes->merge(['class' => $custom_classes]) }}>{!! $value !!}</textarea>
        @else
            <input {{ $attributes->merge(['class' => $custom_classes]) }} />
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
