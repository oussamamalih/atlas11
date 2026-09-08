<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Atlas11') }} - Moroccan Football Talent Scouting</title>
        <meta name="description" content="Atlas11 – Morocco's professional football talent scouting platform connecting players, scouts, and clubs.">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="h-full font-sans antialiased" style="background-color: #F1F5F9; color: #111827;">
        <!-- Top Accent Bar -->
        <div class="fixed top-0 left-0 right-0 h-1 z-50" style="background: linear-gradient(to right, #0B1F33, #16A34A, #A3E635);"></div>

        <div class="min-h-screen flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8">

            <!-- Logo & Branding -->
            <div class="w-full sm:max-w-md flex flex-col items-center mb-8">
                <a href="/" class="transition-transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-pitch-600 focus:ring-offset-2 rounded-xl">
                    <x-application-logo class="h-12 w-auto" style="color: #0B1F33;" />
                </a>
                <p class="text-xs text-slate-500 mt-3 font-medium tracking-wide uppercase">
                    {{ __('Moroccan Football Talent Scouting Network') }}
                </p>
            </div>

            <!-- Auth Card -->
            <div class="w-full sm:max-w-md bg-white rounded-2xl shadow-sm border border-slate-200 px-8 py-8">
                {{ $slot }}
            </div>

            <!-- Footer Link -->
            <div class="mt-8 text-center">
                <a href="/" class="text-xs font-semibold text-slate-500 hover:text-navy-900 transition-colors">
                    &larr; {{ __('Back to Atlas11') }}
                </a>
            </div>
        </div>
    </body>
</html>
