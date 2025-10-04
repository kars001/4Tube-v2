@php
    $activeClasses = $active ? 'bg-272727 font-bold' : 'bg-main';
@endphp

<a target="{{ $target }}" {{ $attributes->merge(['class' => "flex items-center gap-5 text-white p-2 px-3 rounded-[10px] text-sm hover:bg-third $activeClasses"]) }}>
    @if ($active)
        <x-dynamic-component :component="'heroicon-s-' . $icon" class="size-6" />
    @else
        <x-dynamic-component :component="'heroicon-o-' . $icon" class="size-6" />
    @endif
    {{ $slot }}
</a>
