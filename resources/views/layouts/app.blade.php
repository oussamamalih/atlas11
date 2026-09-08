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
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="h-full font-sans antialiased" style="background-color: #F1F5F9; color: #111827;">
        <div class="min-h-screen flex flex-col" style="background-color: #F1F5F9;">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="atlas-header bg-white border-b border-slate-200 shadow-sm">
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
            <footer class="atlas-footer bg-white border-t border-slate-200 py-5 mt-auto">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-2">
                    <div class="flex items-center space-x-2">
                        <span class="font-extrabold text-navy-900 tracking-tight">Atlas11</span>
                        <span class="text-slate-300">&bull;</span>
                        <span>Morocco Football Talent Scouting Network</span>
                    </div>
                    <div class="text-slate-400">
                        &copy; {{ date('Y') }} Atlas11. Professional Scouting Platform.
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
