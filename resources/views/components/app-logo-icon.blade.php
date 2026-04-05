{{-- Brand mark (replaces default Laravel SVG) --}}
<img
    src="{{ asset('lujalogo.jpeg') }}"
    alt=""
    {{ $attributes->merge(['class' => 'h-full w-full object-cover']) }}
    loading="lazy"
    decoding="async"
/>
