@props([
    'sidebar' => false,
])

@if($sidebar)
    <flux:sidebar.brand name="Luja Talks" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center overflow-hidden rounded-full bg-black p-0.5 ring-2 ring-[#FDE047]/80 shadow-md">
            <x-app-logo-icon class="rounded-full" />
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand name="Luja Talks" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center overflow-hidden rounded-full bg-black p-0.5 ring-2 ring-[#FDE047]/80 shadow-md">
            <x-app-logo-icon class="rounded-full" />
        </x-slot>
    </flux:brand>
@endif
