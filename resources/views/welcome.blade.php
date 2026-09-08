<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Atlas11 — Discover Morocco's Football Talent</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-[#111827] bg-[#F8FAFC]">
        <!-- Top Announcement Bar -->
        <div class="bg-[#0B1F33] text-white text-xs py-2 px-4 border-b border-[#05111D]">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <span class="inline-block w-2 h-2 rounded-full bg-[#A3E635] animate-pulse"></span>
                    <span class="font-medium text-slate-300">Morocco's Official Football Talent Scouting & Trial Platform</span>
                </div>
                <div class="hidden sm:flex items-center space-x-4 text-slate-400">
                    <span>Casablanca &bull; Rabat &bull; Tangier &bull; Marrakech &bull; Fes &bull; Agadir</span>
                </div>
            </div>
        </div>

        <!-- Navigation Header -->
        <header class="sticky top-0 z-40 bg-white/95 backdrop-blur border-b border-gray-200/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
                <div class="flex items-center space-x-8">
                    <a href="/" class="flex items-center">
                        <x-application-logo class="h-10 w-auto text-[#0B1F33]" />
                    </a>
                    <nav class="hidden md:flex items-center space-x-6 text-sm font-semibold text-[#0B1F33]">
                        <a href="#about" class="hover:text-[#16A34A] transition">About Platform</a>
                        <a href="#talents" class="hover:text-[#16A34A] transition">Discover Talent</a>
                        <a href="#scouts" class="hover:text-[#16A34A] transition">For Scouts</a>
                        <a href="#how-it-works" class="hover:text-[#16A34A] transition">How It Works</a>
                    </nav>
                </div>

                <div class="flex items-center space-x-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-[#16A34A] hover:bg-[#15803D] text-white text-xs font-bold uppercase tracking-wider rounded-lg shadow-sm transition">
                                <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                {{ __('Dashboard') }}
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center px-3.5 py-2 text-xs font-bold uppercase tracking-wider text-[#0B1F33] hover:text-[#16A34A] transition">
                                {{ __('Log in') }}
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-[#16A34A] hover:bg-[#15803D] text-white text-xs font-bold uppercase tracking-wider rounded-lg shadow-sm transition">
                                    {{ __('Join Atlas11') }}
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="relative pt-16 pb-20 lg:pt-24 lg:pb-28 overflow-hidden bg-gradient-to-b from-white via-[#F8FAFC] to-[#F8FAFC]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    <!-- Hero Content -->
                    <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                        <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-[#16A34A] border border-emerald-200">
                            <span class="w-2 h-2 rounded-full bg-[#16A34A] me-2"></span>
                            {{ __('Morocco Talent Scouting Network') }}
                        </div>

                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-[#0B1F33] leading-tight">
                            Discover Morocco's <br class="hidden sm:inline" />
                            <span class="text-[#16A34A]">Football Talent</span>
                        </h1>

                        <p class="text-base sm:text-lg text-[#64748B] max-w-2xl mx-auto lg:mx-0 leading-relaxed">
                            Atlas11 bridges the gap between ambitious Moroccan footballers and certified scouts, clubs, and youth academies. Build your scouting dossier, track prospects across all 16 regions, and facilitate official trial inquiries.
                        </p>

                        <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                            <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3.5 bg-[#16A34A] hover:bg-[#15803D] text-white text-sm font-bold uppercase tracking-wider rounded-xl shadow-md transition">
                                <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ __('Create Player Profile') }}
                            </a>
                            <a href="{{ route('register') }}?role=scout" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3.5 bg-white border border-gray-300 hover:border-gray-400 text-[#0B1F33] text-sm font-bold uppercase tracking-wider rounded-xl shadow-sm hover:bg-gray-50 transition">
                                <svg class="w-4 h-4 me-2 text-[#16A34A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                {{ __('Register as Scout') }}
                            </a>
                        </div>

                        <!-- Trust Metrics Bar -->
                        <div class="pt-6 border-t border-gray-200 grid grid-cols-3 gap-4 max-w-lg mx-auto lg:mx-0 text-left">
                            <div>
                                <p class="text-2xl font-extrabold text-[#0B1F33]">16+</p>
                                <p class="text-xs text-[#64748B] font-medium uppercase tracking-wider mt-0.5">Regions Covered</p>
                            </div>
                            <div>
                                <p class="text-2xl font-extrabold text-[#16A34A]">100%</p>
                                <p class="text-xs text-[#64748B] font-medium uppercase tracking-wider mt-0.5">Verified Profiles</p>
                            </div>
                            <div>
                                <p class="text-2xl font-extrabold text-[#0B1F33]">Direct</p>
                                <p class="text-xs text-[#64748B] font-medium uppercase tracking-wider mt-0.5">Trial Inquiries</p>
                            </div>
                        </div>
                    </div>

                    <!-- Hero Visual / Showcase Dossier Card -->
                    <div class="lg:col-span-5">
                        <div class="bg-white rounded-2xl border border-gray-200 shadow-xl p-6 relative">
                            <!-- Card Header -->
                            <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                                <div class="flex items-center space-x-2">
                                    <span class="w-3 h-3 rounded-full bg-[#16A34A]"></span>
                                    <span class="text-xs font-bold text-[#0B1F33] uppercase tracking-wider">Scouting Dossier Preview</span>
                                </div>
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-extrabold bg-[#A3E635]/30 text-[#0B1F33] border border-[#A3E635]">
                                    VERIFIED PROSPECT
                                </span>
                            </div>

                            <!-- Player Hero Card Details -->
                            <div class="mt-5 flex items-start space-x-4">
                                <div class="w-16 h-16 rounded-xl bg-[#0B1F33] text-white flex items-center justify-center text-2xl font-black shrink-0 border-2 border-[#16A34A]">
                                    A11
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-bold text-[#0B1F33] truncate">Yassine El Idrissi</h3>
                                    <p class="text-xs font-semibold text-[#16A34A]">Attacking Midfielder (CAM / RW)</p>
                                    <p class="text-xs text-[#64748B] flex items-center mt-1">
                                        <svg class="w-3.5 h-3.5 me-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        </svg>
                                        Casablanca, Grand Casablanca
                                    </p>
                                </div>
                            </div>

                            <!-- Key Metrics Grid -->
                            <div class="mt-5 grid grid-cols-4 gap-2 bg-[#F8FAFC] p-3 rounded-xl border border-gray-100 text-center">
                                <div>
                                    <p class="text-[10px] uppercase font-bold text-gray-400">Age</p>
                                    <p class="text-xs font-extrabold text-[#0B1F33] mt-0.5">18 yrs</p>
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase font-bold text-gray-400">Foot</p>
                                    <p class="text-xs font-extrabold text-[#0B1F33] mt-0.5">Left</p>
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase font-bold text-gray-400">Height</p>
                                    <p class="text-xs font-extrabold text-[#0B1F33] mt-0.5">178 cm</p>
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase font-bold text-gray-400">Weight</p>
                                    <p class="text-xs font-extrabold text-[#0B1F33] mt-0.5">71 kg</p>
                                </div>
                            </div>

                            <!-- Scout Notes snippet -->
                            <div class="mt-4 p-3 bg-emerald-50/70 rounded-xl border border-emerald-100 text-xs text-slate-700 leading-relaxed">
                                <span class="font-bold text-[#16A34A] block mb-1">Technical Assessment:</span>
                                Exceptional close control in high-tempo phases. Visionary distribution between lines with sharp final-third decision-making.
                            </div>

                            <div class="mt-5 pt-4 border-t border-gray-100 flex items-center justify-between">
                                <span class="text-xs font-medium text-[#64748B]">Club: Raja Youth Academy</span>
                                <span class="inline-flex items-center px-3 py-1.5 bg-[#16A34A] text-white text-xs font-bold rounded-lg">
                                    Express Interest &rarr;
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Platform Pillars Section -->
        <section id="about" class="py-16 bg-white border-y border-gray-200/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-12">
                    <h2 class="text-xs font-bold text-[#16A34A] uppercase tracking-widest">{{ __('Purpose-Built Platform') }}</h2>
                    <p class="text-3xl font-extrabold text-[#0B1F33] mt-2">Revolutionizing Football Scouting Across Morocco</p>
                    <p class="text-sm text-[#64748B] mt-2">From regional amateur divisions to top-tier academies, Atlas11 provides direct transparent visibility without middlemen.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Pillar 1 -->
                    <div class="p-6 bg-[#F8FAFC] rounded-xl border border-gray-200">
                        <div class="w-12 h-12 rounded-lg bg-[#0B1F33] text-white flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-[#A3E635]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-[#0B1F33]">{{ __('Verified Player Dossiers') }}</h3>
                        <p class="text-sm text-[#64748B] mt-2 leading-relaxed">
                            Comprehensive records documenting positions, biometrics, preferred foot, current club affiliations, and match background in one structured place.
                        </p>
                    </div>

                    <!-- Pillar 2 -->
                    <div class="p-6 bg-[#F8FAFC] rounded-xl border border-gray-200">
                        <div class="w-12 h-12 rounded-lg bg-[#16A34A] text-white flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-[#0B1F33]">{{ __('Smart Scout Search & Filters') }}</h3>
                        <p class="text-sm text-[#64748B] mt-2 leading-relaxed">
                            Scouts can pinpoint players by tactical position, geographic city, age brackets, and foot preference to immediately discover roster fits.
                        </p>
                    </div>

                    <!-- Pillar 3 -->
                    <div class="p-6 bg-[#F8FAFC] rounded-xl border border-gray-200">
                        <div class="w-12 h-12 rounded-lg bg-[#0B1F33] text-white flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-[#A3E635]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-[#0B1F33]">{{ __('Official Trial Inquiries') }}</h3>
                        <p class="text-sm text-[#64748B] mt-2 leading-relaxed">
                            Direct, authenticated interest channel allowing scouts to send trial invitations and follow up with players without unverified intermediaries.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Talent Discovery Cards Section -->
        <section id="talents" class="py-16 bg-[#F8FAFC]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-10">
                    <div>
                        <h2 class="text-xs font-bold text-[#16A34A] uppercase tracking-widest">{{ __('Talent Showcase') }}</h2>
                        <p class="text-3xl font-extrabold text-[#0B1F33] mt-1">Featured Moroccan Prospects</p>
                    </div>
                    <a href="{{ route('register') }}" class="mt-4 md:mt-0 text-sm font-bold text-[#16A34A] hover:underline flex items-center">
                        {{ __('Join to search the full talent database') }} &rarr;
                    </a>
                </div>

                <!-- Showcase Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Sample Player Card 1 -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 flex flex-col justify-between hover:shadow-md transition">
                        <div>
                            <div class="flex items-start justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 rounded-full bg-[#0B1F33] text-white font-bold flex items-center justify-center text-lg">
                                        OH
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-[#0B1F33] text-base">Omar Hamdaoui</h4>
                                        <p class="text-xs text-[#64748B] flex items-center">
                                            <svg class="w-3.5 h-3.5 me-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            </svg>
                                            Rabat, Salé-Kénitra
                                        </p>
                                    </div>
                                </div>
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-[#16A34A] border border-emerald-200">
                                    Winger (LW)
                                </span>
                            </div>

                            <div class="mt-4 grid grid-cols-3 gap-1 bg-[#F8FAFC] py-2 px-1 rounded-lg text-center text-xs border border-gray-100">
                                <div>
                                    <span class="text-gray-400 text-[10px] font-bold uppercase">Age</span>
                                    <p class="font-extrabold text-[#0B1F33]">17 yrs</p>
                                </div>
                                <div>
                                    <span class="text-gray-400 text-[10px] font-bold uppercase">Foot</span>
                                    <p class="font-extrabold text-[#0B1F33]">Right</p>
                                </div>
                                <div>
                                    <span class="text-gray-400 text-[10px] font-bold uppercase">Height</span>
                                    <p class="font-extrabold text-[#0B1F33]">175 cm</p>
                                </div>
                            </div>

                            <p class="mt-3 text-xs text-[#64748B] line-clamp-2">
                                Direct, electric winger with 1v1 take-on ability and pinpoint crossing delivery from wide channels.
                            </p>
                        </div>

                        <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-[11px] font-semibold text-gray-500">FUS Youth</span>
                            <a href="{{ route('register') }}" class="text-xs font-bold text-[#16A34A] hover:text-[#15803D]">
                                View Profile &rarr;
                            </a>
                        </div>
                    </div>

                    <!-- Sample Player Card 2 -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 flex flex-col justify-between hover:shadow-md transition">
                        <div>
                            <div class="flex items-start justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 rounded-full bg-[#0B1F33] text-white font-bold flex items-center justify-center text-lg">
                                        SZ
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-[#0B1F33] text-base">Soufiane Zekri</h4>
                                        <p class="text-xs text-[#64748B] flex items-center">
                                            <svg class="w-3.5 h-3.5 me-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            </svg>
                                            Tangier, Tangier-Tetouan
                                        </p>
                                    </div>
                                </div>
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-[#16A34A] border border-emerald-200">
                                    Center Back (CB)
                                </span>
                            </div>

                            <div class="mt-4 grid grid-cols-3 gap-1 bg-[#F8FAFC] py-2 px-1 rounded-lg text-center text-xs border border-gray-100">
                                <div>
                                    <span class="text-gray-400 text-[10px] font-bold uppercase">Age</span>
                                    <p class="font-extrabold text-[#0B1F33]">19 yrs</p>
                                </div>
                                <div>
                                    <span class="text-gray-400 text-[10px] font-bold uppercase">Foot</span>
                                    <p class="font-extrabold text-[#0B1F33]">Left</p>
                                </div>
                                <div>
                                    <span class="text-gray-400 text-[10px] font-bold uppercase">Height</span>
                                    <p class="font-extrabold text-[#0B1F33]">188 cm</p>
                                </div>
                            </div>

                            <p class="mt-3 text-xs text-[#64748B] line-clamp-2">
                                Commanding left-footed center-back proficient in aerial duels and progressive ground passing from defensive thirds.
                            </p>
                        </div>

                        <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-[11px] font-semibold text-gray-500">IRT Academy</span>
                            <a href="{{ route('register') }}" class="text-xs font-bold text-[#16A34A] hover:text-[#15803D]">
                                View Profile &rarr;
                            </a>
                        </div>
                    </div>

                    <!-- Sample Player Card 3 -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 flex flex-col justify-between hover:shadow-md transition">
                        <div>
                            <div class="flex items-start justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 rounded-full bg-[#0B1F33] text-white font-bold flex items-center justify-center text-lg">
                                        KB
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-[#0B1F33] text-base">Karim Benchekroun</h4>
                                        <p class="text-xs text-[#64748B] flex items-center">
                                            <svg class="w-3.5 h-3.5 me-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            </svg>
                                            Marrakech, Al Haouz
                                        </p>
                                    </div>
                                </div>
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-[#16A34A] border border-emerald-200">
                                    Midfielder (CM)
                                </span>
                            </div>

                            <div class="mt-4 grid grid-cols-3 gap-1 bg-[#F8FAFC] py-2 px-1 rounded-lg text-center text-xs border border-gray-100">
                                <div>
                                    <span class="text-gray-400 text-[10px] font-bold uppercase">Age</span>
                                    <p class="font-extrabold text-[#0B1F33]">18 yrs</p>
                                </div>
                                <div>
                                    <span class="text-gray-400 text-[10px] font-bold uppercase">Foot</span>
                                    <p class="font-extrabold text-[#0B1F33]">Right</p>
                                </div>
                                <div>
                                    <span class="text-gray-400 text-[10px] font-bold uppercase">Height</span>
                                    <p class="font-extrabold text-[#0B1F33]">181 cm</p>
                                </div>
                            </div>

                            <p class="mt-3 text-xs text-[#64748B] line-clamp-2">
                                Box-to-box midfielder with high stamina, intercepting acumen, and transition ball-carrying capabilities.
                            </p>
                        </div>

                        <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-[11px] font-semibold text-gray-500">KACM Youth</span>
                            <a href="{{ route('register') }}" class="text-xs font-bold text-[#16A34A] hover:text-[#15803D]">
                                View Profile &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- How It Works Section -->
        <section id="how-it-works" class="py-16 bg-white border-y border-gray-200/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-12">
                    <h2 class="text-xs font-bold text-[#16A34A] uppercase tracking-widest">{{ __('Step-by-Step Pathway') }}</h2>
                    <p class="text-3xl font-extrabold text-[#0B1F33] mt-1">How Atlas11 Works</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                    <!-- Step 1 -->
                    <div class="text-center p-6">
                        <div class="w-14 h-14 rounded-full bg-[#0B1F33] text-white text-xl font-extrabold flex items-center justify-center mx-auto mb-4 border-4 border-white shadow-md">
                            1
                        </div>
                        <h3 class="text-lg font-bold text-[#0B1F33]">{{ __('Create Your Dossier') }}</h3>
                        <p class="text-sm text-[#64748B] mt-2 leading-relaxed">
                            Sign up as a player and add your position, birth date, preferred foot, physical metrics, club history, and player bio.
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="text-center p-6">
                        <div class="w-14 h-14 rounded-full bg-[#16A34A] text-white text-xl font-extrabold flex items-center justify-center mx-auto mb-4 border-4 border-white shadow-md">
                            2
                        </div>
                        <h3 class="text-lg font-bold text-[#0B1F33]">{{ __('Get Discovered') }}</h3>
                        <p class="text-sm text-[#64748B] mt-2 leading-relaxed">
                            Certified scouts filter through regional profiles, track prospects, and review candidate dossiers matching club needs.
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="text-center p-6">
                        <div class="w-14 h-14 rounded-full bg-[#0B1F33] text-white text-xl font-extrabold flex items-center justify-center mx-auto mb-4 border-4 border-white shadow-md">
                            3
                        </div>
                        <h3 class="text-lg font-bold text-[#0B1F33]">{{ __('Trial & Direct Connect') }}</h3>
                        <p class="text-sm text-[#64748B] mt-2 leading-relaxed">
                            Receive official scouting interest notifications with trial invitation details directly on your dashboard.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- High-Impact Call to Action Banner -->
        <section class="py-16 bg-[#0B1F33] text-white relative overflow-hidden">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
                <span class="inline-block px-3 py-1 rounded-full text-xs font-extrabold bg-[#A3E635] text-[#0B1F33] uppercase tracking-wider mb-4">
                    Ready For Discovery?
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight">
                    Join the Moroccan Football Talent Scouting Network Today
                </h2>
                <p class="text-base text-slate-300 max-w-2xl mx-auto mt-4 leading-relaxed">
                    Whether you are an aspiring player seeking exposure or a scout looking for the next star, Atlas11 is your official scouting platform.
                </p>

                <div class="mt-8 flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-3.5 bg-[#16A34A] hover:bg-[#15803D] text-white text-sm font-bold uppercase tracking-wider rounded-xl shadow-lg transition">
                        {{ __('Get Started Now') }}
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-3.5 bg-[#061320] border border-[#102A43] hover:border-slate-400 text-white text-sm font-bold uppercase tracking-wider rounded-xl transition">
                        {{ __('Sign In to Account') }}
                    </a>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center space-x-4">
                    <x-application-logo class="h-9 w-auto text-[#0B1F33]" />
                    <span class="text-xs text-[#64748B] font-medium border-l border-gray-200 pl-4">
                        Dedicated to Moroccan Football Talent Discovery
                    </span>
                </div>

                <div class="flex items-center space-x-6 text-xs text-[#64748B]">
                    <span>&copy; {{ date('Y') }} Atlas11. All rights reserved.</span>
                    <span>Built for Moroccan Football</span>
                </div>
            </div>
        </footer>
    </body>
</html>
