@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-[#16A34A] focus:ring-1 focus:ring-[#16A34A] rounded-lg shadow-sm text-sm text-[#111827] placeholder:text-gray-400 disabled:bg-gray-100 disabled:text-gray-500 transition-colors']) }}>
