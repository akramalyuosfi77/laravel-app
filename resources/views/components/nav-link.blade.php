{{-- 📂 ملف: resources/views/components/nav-link.blade.php --}}
@props(['active' => false, 'href' => '#'])

@php
    $classes = ($active ?? false)
        ? 'menu-hover flex items-center gap-3 p-3 rounded-xl bg-accent/10 dark:bg-accent/20 text-accent dark:text-accent'
    : 'menu-hover flex items-center gap-3 p-3 rounded-xl text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700';@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }} wire:navigate>
    @if(isset($icon))
        {{-- هذا المكان مخصص للأيقونة SVG --}}
        <span class="flex-shrink-0 w-6 h-6">{{ $icon }}</span>
    @endif
    <span class="font-bold" style="font-family: 'Questv1', sans-serif;">{{ $slot }}</span>
</a>
