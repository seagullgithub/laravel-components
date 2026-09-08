<a href="{{ $href }}" target="_blank" {{ $attributes->merge(['class'=>'hover:underline']) }}>
    {{ $slot }}
    <x-icon icon="external-link" class="{{ $classIcon }}" />
</a>