<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Atlas11') }} — Moroccan Football Talent Scouting</title>
        <meta name="description" content="Atlas11 — Morocco's professional football talent scouting platform connecting players, scouts, and clubs.">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Teko:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="h-full font-sans antialiased" style="background-color: #0a1f14; color: #ffffff;">
        <div class="min-h-screen flex flex-col" style="background-color: #0a1f14;">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="atlas-header border-b border-[#1a4030]">
                    <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-1">
                {{ $slot }}
            </main>

            <!-- Atlas11 Footer -->
            <footer class="atlas-footer border-t border-[#1a4030] py-6 mt-auto">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between text-xs gap-3">
                    <div class="flex items-center space-x-3">
                        <span class="font-display text-lg tracking-wider text-white">ATLAS<span class="text-[#10b981]">11</span></span>
                        <span class="text-[#1a4030]">&bull;</span>
                        <span class="text-[#8fa89c]">Morocco Football Talent Scouting Network</span>
                    </div>
                    <div class="text-[#8fa89c]">
                        &copy; {{ date('Y') }} Atlas11. Professional Scouting Platform.
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
