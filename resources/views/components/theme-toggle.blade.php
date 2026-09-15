<button type="button"
        x-data
        @click="$store.theme.toggle()"
        :aria-pressed="String($store.theme.theme === 'light')"
        aria-label="{{ __('Toggle color scheme') }}"
        title="{{ __('Toggle color scheme') }}"
        class="inline-flex items-center justify-center h-10 w-10 rounded bg-[#133323] text-[#8fa89c] hover:text-white hover:bg-[#1a4030] border border-[#1a4030] focus:outline-none focus:ring-2 focus:ring-[#10b981]/50 transition">
    <svg x-show="$store.theme.theme === 'dark'" x-cloak class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
    </svg>
    <svg x-show="$store.theme.theme === 'light'" x-cloak class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
    </svg>
</button>