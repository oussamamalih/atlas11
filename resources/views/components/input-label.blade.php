@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-xs font-display font-medium text-[#8fa89c] uppercase tracking-[0.08em]']) }}>
    {{ $value ?? $slot }}
</label>
