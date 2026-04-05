@props([
    'title',
    'description',
])

<div {{ $attributes->class('flex w-full flex-col text-center') }}>
    <h1 class="text-xl font-black tracking-tight text-[#282427] sm:text-2xl">{{ $title }}</h1>
    <p class="mt-0.5 text-xs leading-relaxed text-[#282427]/60 sm:mt-1 sm:text-sm">{{ $description }}</p>
</div>
