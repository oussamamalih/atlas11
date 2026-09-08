<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-4 py-2.5 bg-[#16A34A] hover:bg-[#15803D] active:bg-[#14532D] text-white text-xs font-bold uppercase tracking-wider rounded-lg border border-transparent shadow-sm focus:outline-none focus:ring-2 focus:ring-[#16A34A] focus:ring-offset-2 transition-colors duration-150 disabled:opacity-50 disabled:cursor-not-allowed']) }}>
    {{ $slot }}
</button>
