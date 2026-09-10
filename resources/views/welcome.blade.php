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
                                    {{ __('Sign up') }}
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section id="atlas-hero" class="atlas-hero-section relative w-full overflow-hidden bg-[#060d17] flex items-center" style="min-height: calc(100vh - 80px) !important; min-height: 650px !important;">

            <!-- Hero Image Layer -->
            <div class="atlas-hero-bg absolute inset-0 bg-cover bg-no-repeat"
                 style="background-image: url('{{ asset('images/hero-player.png') }}'); background-position: right center; background-repeat: no-repeat; background-size: cover;">
            </div>

            <!-- Desktop Directional Overlay: Solid dark on left for text legibility, transparent over player on right -->
            <div class="atlas-hero-overlay-desktop absolute inset-0 pointer-events-none hidden lg:block"
                 style="background: linear-gradient(90deg, #060d17 0%, rgba(6,13,23,0.96) 28%, rgba(6,13,23,0.82) 46%, rgba(6,13,23,0.25) 64%, rgba(6,13,23,0.0) 78%, transparent 100%);">
            </div>

            <!-- Mobile/Tablet Overlay -->
            <div class="atlas-hero-overlay-mobile absolute inset-0 pointer-events-none lg:hidden"
                 style="background: linear-gradient(180deg, rgba(6,13,23,0.88) 0%, rgba(6,13,23,0.76) 45%, rgba(6,13,23,0.45) 75%, #060d17 100%);">
            </div>

            <!-- Subtle Bottom Edge Transition -->
            <div class="atlas-hero-bottom-fade absolute inset-x-0 bottom-0 pointer-events-none"
                 style="height: 70px; background: linear-gradient(to top, #060d17 0%, transparent 100%);">
            </div>

            <!-- Content Container -->
            <div class="atlas-hero-inner relative z-10 mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8 flex items-center" style="min-height: calc(100vh - 80px) !important; min-height: 650px !important;">

                <div class="max-w-2xl text-left py-12 lg:py-0">

                    <!-- Small Eyebrow -->
                    <div class="inline-flex items-center gap-2.5 mb-5">
                        <span class="h-px w-6 bg-emerald-400"></span>
                        <span class="text-xs font-bold uppercase tracking-[0.25em] text-emerald-400 font-mono">
                            FOOTBALL SCOUTING PLATFORM
                        </span>
                    </div>

                    <!-- Main Headline -->
                    <h1 class="atlas-hero-heading text-4xl sm:text-6xl lg:text-7xl font-black tracking-tight leading-[1.05] mb-6" style="color: #ffffff !important; letter-spacing: -0.04em !important;">
                        Discover the<br>
                        <span class="atlas-hero-emerald text-emerald-400" style="color: #34d399 !important;">next generation.</span>
                    </h1>

                    <!-- Description -->
                    <p class="atlas-hero-desc text-base sm:text-lg lg:text-xl font-normal leading-relaxed max-w-xl mb-9" style="color: #cbd5e1 !important;">
                        Discover, analyse and track football talent with Atlas11.
                    </p>

                    <!-- Action CTAs -->
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 mb-12">
                        <a href="{{ route('register') }}"
                           class="atlas-btn-player inline-flex items-center justify-center px-8 py-4 text-xs sm:text-sm font-bold uppercase tracking-wider text-[#060d17] bg-emerald-400 hover:bg-emerald-300 transition duration-150 rounded"
                           style="background-color: #10b981 !important; color: #060d17 !important;">
                            Create Player Profile
                            <svg class="w-4 h-4 ml-2.5 -mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </a>

                        <a href="{{ route('register') }}?role=scout"
                           class="atlas-btn-scout inline-flex items-center justify-center px-8 py-4 text-xs sm:text-sm font-bold uppercase tracking-wider text-white border border-white/25 hover:border-white/60 bg-white/5 hover:bg-white/10 transition duration-150 rounded"
                           style="color: #ffffff !important;">
                            I'm a Scout
                        </a>
                    </div>

                    <!-- Subtle Stats Row -->
                    <div class="pt-8 border-t border-white/10 flex flex-wrap items-center gap-6 sm:gap-10">
                        <div class="flex items-baseline gap-2.5">
                            <span class="atlas-stat-val text-2xl sm:text-3xl font-black tracking-tight" style="color: #ffffff !important;">16+</span>
                            <span class="text-xs font-semibold text-slate-500">—</span>
                            <span class="text-[11px] sm:text-xs uppercase tracking-widest text-slate-300 font-medium">Regions</span>
                        </div>

                        <div class="hidden sm:block h-5 w-px bg-white/15"></div>

                        <div class="flex items-baseline gap-2.5">
                            <span class="atlas-stat-val text-2xl sm:text-3xl font-black tracking-tight" style="color: #ffffff !important;">100%</span>
                            <span class="text-xs font-semibold text-slate-500">—</span>
                            <span class="text-[11px] sm:text-xs uppercase tracking-widest text-slate-300 font-medium">Verified Profiles</span>
                        </div>

                        <div class="hidden sm:block h-5 w-px bg-white/15"></div>

                        <div class="flex items-baseline gap-2.5">
                            <span class="atlas-stat-val text-2xl sm:text-3xl font-black tracking-tight" style="color: #ffffff !important;">Direct</span>
                            <span class="text-xs font-semibold text-slate-500">—</span>
                            <span class="text-[11px] sm:text-xs uppercase tracking-widest text-slate-300 font-medium">Connections</span>
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
