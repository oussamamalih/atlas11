<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-5 py-2.5 bg-transparent border border-red-500/30 rounded text-xs font-display font-semibold text-red-400 uppercase tracking-[0.08em] hover:bg-red-500/10 hover:border-red-500 hover:text-red-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-[#0a1f14] disabled:opacity-50 transition-colors duration-150']) }}>
    {{ $slot }}
</button>
