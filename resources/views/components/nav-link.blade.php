@props(['active'])

@php
$classes = ($active ?? false)
            ? 'atlas-nav-link inline-flex items-center px-1 pt-1 border-b-2 border-[#10b981] text-sm font-display font-medium leading-5 text-white focus:outline-none transition duration-150 ease-in-out'
            : 'atlas-nav-link inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-display font-medium leading-5 text-[#8fa89c] hover:text-white focus:outline-none focus:text-white transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
