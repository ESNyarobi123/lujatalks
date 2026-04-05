@props([
    'size' => 'md',
])

@php
    $box = match ($size) {
        'xs' => 'h-8 w-8',
        'sm' => 'h-9 w-9',
        'sidebar' => 'h-8 w-8',
        'md' => 'h-10 w-10 sm:h-12 sm:w-12',
        'lg' => 'h-12 w-12',
        'xl' => 'h-16 w-16 sm:h-20 sm:w-20',
        default => 'h-10 w-10 sm:h-12 sm:w-12',
    };
@endphp

<span
    {{ $attributes->class('inline-flex shrink-0 rounded-full p-[3px] bg-gradient-to-br from-[#FDE047] via-[#EAB308] to-[#CA8A04] shadow-lg shadow-black/25 dark:shadow-black/50') }}>
    <span class="block overflow-hidden rounded-full bg-black ring-2 ring-black/20 {{ $box }}">
        <img
            src="{{ asset('lujalogo.jpeg') }}"
            alt="{{ config('app.name', 'Luja Talks') }}"
            class="h-full w-full object-cover object-center scale-[1.08]"
            width="160"
            height="160"
            loading="eager"
            decoding="async"
        />
    </span>
</span>
