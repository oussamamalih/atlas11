<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-5 py-2.5 bg-transparent border border-[#1a4030] rounded text-xs font-display font-semibold text-white uppercase tracking-[0.08em] hover:border-[#10b981] hover:text-[#10b981] hover:bg-[#10b981]/5 focus:outline-none focus:ring-2 focus:ring-[#10b981] focus:ring-offset-2 focus:ring-offset-[#0a1f14] disabled:opacity-50 transition-colors duration-150']) }}>
    {{ $slot }}
</button>
