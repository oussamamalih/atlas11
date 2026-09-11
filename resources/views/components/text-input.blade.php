@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'block w-full border border-[#1a4030] bg-[#133323] text-white focus:border-[#10b981] focus:ring-1 focus:ring-[#10b981] rounded text-sm placeholder:text-[#8fa89c]/60 disabled:bg-[#0d2919] disabled:text-[#8fa89c] transition-colors']) }}>
