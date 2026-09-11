<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Atlas11') }} — Moroccan Football Talent Scouting</title>
        <meta name="description" content="Atlas11 — Morocco's professional football talent scouting platform.">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Teko:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="atlas-auth-shell h-full font-sans antialiased" style="background-color: #0a1f14; color: #ffffff;">
        <!-- Top Accent Bar -->
        <div class="fixed top-0 left-0 right-0 h-[3px] z-50" style="background: linear-gradient(to right, #0a1f14, #10b981, #a3e635);"></div>

        <div class="min-h-screen flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8">

            <!-- Logo & Branding -->
            <div class="w-full sm:max-w-md flex flex-col items-center mb-8">
                <a href="/" class="transition-transform hover:scale-105 focus:outline-none">
                    <x-application-logo class="h-12 w-auto text-white" />
                </a>
                <p class="text-xs text-[#8fa89c] mt-3 font-display uppercase tracking-[0.15em]">
                    {{ __('Moroccan Football Talent Scouting Network') }}
                </p>
            </div>

            <!-- Auth Card -->
            <div class="atlas-auth-card w-full sm:max-w-md px-8 py-8">
                {{ $slot }}
            </div>

            <!-- Footer Link -->
            <div class="mt-8 text-center">
                <a href="/" class="text-xs font-display uppercase tracking-wider text-[#8fa89c] hover:text-[#10b981] transition-colors">
                    &larr; {{ __('Back to Atlas11') }}
                </a>
            </div>
        </div>
    </body>
</html>
