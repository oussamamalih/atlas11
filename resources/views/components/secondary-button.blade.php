<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-xs font-semibold text-[#0B1F33] uppercase tracking-wider shadow-sm hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0B1F33] focus:ring-offset-2 disabled:opacity-50 transition-colors duration-150']) }}>
    {{ $slot }}
</button>
