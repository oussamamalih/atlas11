<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-5 py-2.5 bg-[#10b981] hover:bg-[#34d399] active:bg-[#059669] text-[#0a1f14] text-xs font-display font-semibold uppercase tracking-[0.08em] rounded border border-transparent focus:outline-none focus:ring-2 focus:ring-[#10b981] focus:ring-offset-2 focus:ring-offset-[#0a1f14] transition-colors duration-150 disabled:opacity-50 disabled:cursor-not-allowed']) }}>
    {{ $slot }}
</button>
