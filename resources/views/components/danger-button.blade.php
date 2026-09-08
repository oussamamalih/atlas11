<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-4 py-2.5 bg-[#DC2626] hover:bg-red-700 active:bg-red-800 text-white text-xs font-bold uppercase tracking-wider rounded-lg border border-transparent shadow-sm focus:outline-none focus:ring-2 focus:ring-[#DC2626] focus:ring-offset-2 disabled:opacity-50 transition-colors duration-150']) }}>
    {{ $slot }}
</button>
