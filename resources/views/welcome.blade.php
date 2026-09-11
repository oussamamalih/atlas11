<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Atlas11 — Discover Morocco's Football Talent</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Teko:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#0a1f14] text-white">

        <!-- Navigation Header -->
        <header class="atlas-nav sticky top-0 z-40">
            <div class="atlas-nav-inner max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
                <div class="flex items-center space-x-8">
                    <a href="/" class="flex items-center">
                        <x-application-logo class="h-10 w-auto text-white" />
                    </a>
                    <nav class="hidden md:flex items-center space-x-2 text-sm font-semibold">
                        <a href="#about" class="atlas-nav-link hover:text-white transition">{{ __('About Platform') }}</a>
                        <a href="#talents" class="atlas-nav-link hover:text-white transition">{{ __('Discover Talent') }}</a>
                        <a href="#how-it-works" class="atlas-nav-link hover:text-white transition">{{ __('How It Works') }}</a>
                    </nav>
                </div>

                <div class="flex items-center space-x-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('dashboard') }}" class="atlas-btn-primary h-11 px-7 text-sm">
                                <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                {{ __('Dashboard') }}
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="atlas-nav-auth-login">
                                {{ __('Log in') }}
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="atlas-nav-auth-signup">
                                    {{ __('Sign up') }}
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section id="atlas-hero" class="atlas-hero-section relative w-full overflow-hidden flex items-center" style="min-height: calc(100vh - 80px) !important; min-height: 650px !important;">

            <!-- Oversized background word -->
            <span class="atlas-bg-text" style="top: 18%; left: -2%;">ATLAS11</span>

            <!-- Hero Image Layer -->
            <div class="atlas-hero-bg absolute inset-0 bg-cover bg-no-repeat"
                 style="background-image: url('{{ asset('images/hero-player.png') }}'); background-position: right center; background-repeat: no-repeat; background-size: cover;">
            </div>

            <!-- Desktop Directional Overlay: Solid dark on left for text legibility, transparent over player on right -->
            <div class="atlas-hero-overlay-desktop absolute inset-0 pointer-events-none hidden lg:block">
            </div>

            <!-- Mobile/Tablet Overlay -->
            <div class="atlas-hero-overlay-mobile absolute inset-0 pointer-events-none lg:hidden">
            </div>

            <!-- Subtle Bottom Edge Transition -->
            <div class="atlas-hero-bottom-fade absolute inset-x-0 bottom-0 pointer-events-none">
            </div>

            <!-- Content Container -->
            <div class="atlas-hero-inner relative z-10 mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8 flex items-center" style="min-height: calc(100vh - 80px) !important; min-height: 650px !important;">

                <div class="max-w-2xl text-left py-12 lg:py-0">

                    <!-- Main Headline -->
                    <h1 class="atlas-hero-heading text-5xl sm:text-7xl lg:text-8xl font-display uppercase tracking-wider mb-6" style="color: #ffffff !important;">
                        Discover The<br>
                        <span class="atlas-hero-emerald">Next Generation</span>
                    </h1>

                    <!-- Description -->
                    <p class="atlas-hero-desc text-base sm:text-lg lg:text-xl font-normal leading-relaxed max-w-xl mb-9" style="color: #8fa89c !important;">
                        {{ __('Discover, analyse and track football talent with Atlas11.') }}
                    </p>

                    <!-- Action CTAs -->
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 mb-12">
                        <a href="{{ route('register') }}"
                           class="atlas-btn-player inline-flex items-center justify-center px-8 py-4 text-sm font-display uppercase tracking-wider rounded"
                           style="background-color: #10b981 !important; color: #0a1f14 !important;">
                            {{ __('Create Player Profile') }}
                            <svg class="w-4 h-4 ml-2.5 -mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </a>

                        <a href="{{ route('register') }}?role=scout"
                           class="atlas-btn-scout inline-flex items-center justify-center px-8 py-4 text-sm font-display uppercase tracking-wider rounded"
                           style="color: #ffffff !important;">
                            {{ __('I\'m a Scout') }}
                        </a>
                    </div>

                    <!-- Subtle Stats Row -->
                    <div class="pt-8 border-t border-[#1a4030] flex flex-wrap items-center gap-6 sm:gap-10">
                        <div class="flex items-baseline gap-2.5">
                            <span class="atlas-stat-val text-2xl sm:text-3xl font-display" style="color: #ffffff !important;">16+</span>
                            <span class="text-xs font-semibold text-[#1a4030]">—</span>
                            <span class="text-[11px] sm:text-xs uppercase tracking-widest text-[#8fa89c] font-medium">{{ __('Regions') }}</span>
                        </div>

                        <div class="hidden sm:block h-5 w-px bg-[#1a4030]"></div>

                        <div class="flex items-baseline gap-2.5">
                            <span class="atlas-stat-val text-2xl sm:text-3xl font-display" style="color: #ffffff !important;">100%</span>
                            <span class="text-xs font-semibold text-[#1a4030]">—</span>
                            <span class="text-[11px] sm:text-xs uppercase tracking-widest text-[#8fa89c] font-medium">{{ __('Verified Profiles') }}</span>
                        </div>

                        <div class="hidden sm:block h-5 w-px bg-[#1a4030]"></div>

                        <div class="flex items-baseline gap-2.5">
                            <span class="atlas-stat-val text-2xl sm:text-3xl font-display" style="color: #ffffff !important;">{{ __('Direct') }}</span>
                            <span class="text-xs font-semibold text-[#1a4030]">—</span>
                            <span class="text-[11px] sm:text-xs uppercase tracking-widest text-[#8fa89c] font-medium">{{ __('Connections') }}</span>
                        </div>
                    </div>

                </div>
            </div>

        </section>

        <!-- Platform Pillars Section -->
        <section id="about" class="relative py-24 bg-[#0a1f14] overflow-hidden">
            <div class="atlas-plus-pattern"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center max-w-3xl mx-auto mb-14">
                    <span class="inline-block px-3 py-1 rounded text-xs font-display uppercase tracking-wider text-[#a3e635] bg-[#133323] border border-[#1a4030] mb-4">
                        {{ __('Purpose-Built Platform') }}
                    </span>
                    <h2 class="text-4xl sm:text-5xl font-display uppercase tracking-wider text-white">
                        {{ __('Revolutionizing Football Scouting Across Morocco') }}
                    </h2>
                    <p class="text-sm text-[#8fa89c] mt-4">
                        {{ __('From regional amateur divisions to top-tier academies, Atlas11 provides direct transparent visibility without middlemen.') }}
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Pillar 1 -->
                    <div class="atlas-card p-6 rounded">
                        <div class="w-12 h-12 rounded bg-[#133323] text-[#10b981] flex items-center justify-center mb-4 border border-[#1a4030]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-display uppercase tracking-wider text-white">{{ __('Verified Player Dossiers') }}</h3>
                        <p class="text-sm text-[#8fa89c] mt-2 leading-relaxed">
                            {{ __('Comprehensive records documenting positions, biometrics, preferred foot, current club affiliations, and match background in one structured place.') }}
                        </p>
                    </div>

                    <!-- Pillar 2 -->
                    <div class="atlas-card p-6 rounded">
                        <div class="w-12 h-12 rounded bg-[#133323] text-[#10b981] flex items-center justify-center mb-4 border border-[#1a4030]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-display uppercase tracking-wider text-white">{{ __('Smart Scout Search & Filters') }}</h3>
                        <p class="text-sm text-[#8fa89c] mt-2 leading-relaxed">
                            {{ __('Scouts can pinpoint players by tactical position, geographic city, age brackets, and foot preference to immediately discover roster fits.') }}
                        </p>
                    </div>

                    <!-- Pillar 3 -->
                    <div class="atlas-card p-6 rounded">
                        <div class="w-12 h-12 rounded bg-[#133323] text-[#10b981] flex items-center justify-center mb-4 border border-[#1a4030]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-display uppercase tracking-wider text-white">{{ __('Official Trial Inquiries') }}</h3>
                        <p class="text-sm text-[#8fa89c] mt-2 leading-relaxed">
                            {{ __('Direct, authenticated interest channel allowing scouts to send trial invitations and follow up with players without unverified intermediaries.') }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Talent Discovery Cards Section -->
        <section id="talents" class="relative py-24 bg-[#0d2919] overflow-hidden">
            <div class="atlas-plus-pattern"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                    <div>
                        <h2 class="text-xs font-bold text-[#10b981] uppercase tracking-widest">{{ __('Talent Showcase') }}</h2>
                        <p class="text-4xl sm:text-5xl font-display uppercase tracking-wider text-white mt-2">{{ __('Featured Moroccan Prospects') }}</p>
                    </div>
                    <a href="{{ route('register') }}" class="mt-4 md:mt-0 text-sm font-display uppercase tracking-wider text-[#10b981] hover:text-[#a3e635] transition flex items-center">
                        {{ __('Join to search the full talent database') }} &rarr;
                    </a>
                </div>

                <!-- Showcase Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Sample Player Card 1 -->
                    <div class="atlas-card rounded p-5 flex flex-col justify-between hover:border-[#1f4d38] transition">
                        <div>
                            <div class="flex items-start justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 rounded bg-[#133323] text-[#a3e635] font-display font-bold flex items-center justify-center text-lg border border-[#1a4030]">
                                        OH
                                    </div>
                                    <div>
                                        <h4 class="font-display uppercase tracking-wider text-white text-lg">Omar Hamdaoui</h4>
                                        <p class="text-xs text-[#8fa89c] flex items-center">
                                            <svg class="w-3.5 h-3.5 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            </svg>
                                            {{ __('Rabat, Salé-Kénitra') }}
                                        </p>
                                    </div>
                                </div>
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-[#133323] text-[#10b981] border border-[#10b981]/30">
                                    {{ __('Winger (LW)') }}
                                </span>
                            </div>

                            <div class="mt-4 grid grid-cols-3 gap-1 bg-[#0d2919] py-2 px-1 rounded text-center text-xs border border-[#1a4030]">
                                <div>
                                    <span class="text-[#8fa89c] text-[10px] font-bold uppercase">{{ __('Age') }}</span>
                                    <p class="font-display font-bold text-white text-base">{{ __('17 yrs') }}</p>
                                </div>
                                <div>
                                    <span class="text-[#8fa89c] text-[10px] font-bold uppercase">{{ __('Foot') }}</span>
                                    <p class="font-display font-bold text-white text-base">{{ __('Right') }}</p>
                                </div>
                                <div>
                                    <span class="text-[#8fa89c] text-[10px] font-bold uppercase">{{ __('Height') }}</span>
                                    <p class="font-display font-bold text-white text-base">{{ __('175 cm') }}</p>
                                </div>
                            </div>

                            <p class="mt-3 text-xs text-[#8fa89c] line-clamp-2">
                                {{ __('Direct, electric winger with 1v1 take-on ability and pinpoint crossing delivery from wide channels.') }}
                            </p>
                        </div>

                        <div class="mt-4 pt-3 border-t border-[#1a4030] flex items-center justify-between">
                            <span class="text-[11px] font-semibold text-[#8fa89c]">{{ __('FUS Youth') }}</span>
                            <a href="{{ route('register') }}" class="text-xs font-bold text-[#10b981] hover:text-[#a3e635] transition">
                                {{ __('View Profile') }} &rarr;
                            </a>
                        </div>
                    </div>

                    <!-- Sample Player Card 2 -->
                    <div class="atlas-card rounded p-5 flex flex-col justify-between hover:border-[#1f4d38] transition">
                        <div>
                            <div class="flex items-start justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 rounded bg-[#133323] text-[#a3e635] font-display font-bold flex items-center justify-center text-lg border border-[#1a4030]">
                                        SZ
                                    </div>
                                    <div>
                                        <h4 class="font-display uppercase tracking-wider text-white text-lg">Soufiane Zekri</h4>
                                        <p class="text-xs text-[#8fa89c] flex items-center">
                                            <svg class="w-3.5 h-3.5 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            </svg>
                                            {{ __('Tangier, Tangier-Tetouan') }}
                                        </p>
                                    </div>
                                </div>
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-[#133323] text-[#10b981] border border-[#10b981]/30">
                                    {{ __('Center Back (CB)') }}
                                </span>
                            </div>

                            <div class="mt-4 grid grid-cols-3 gap-1 bg-[#0d2919] py-2 px-1 rounded text-center text-xs border border-[#1a4030]">
                                <div>
                                    <span class="text-[#8fa89c] text-[10px] font-bold uppercase">{{ __('Age') }}</span>
                                    <p class="font-display font-bold text-white text-base">{{ __('19 yrs') }}</p>
                                </div>
                                <div>
                                    <span class="text-[#8fa89c] text-[10px] font-bold uppercase">{{ __('Foot') }}</span>
                                    <p class="font-display font-bold text-white text-base">{{ __('Left') }}</p>
                                </div>
                                <div>
                                    <span class="text-[#8fa89c] text-[10px] font-bold uppercase">{{ __('Height') }}</span>
                                    <p class="font-display font-bold text-white text-base">{{ __('188 cm') }}</p>
                                </div>
                            </div>

                            <p class="mt-3 text-xs text-[#8fa89c] line-clamp-2">
                                {{ __('Commanding left-footed center-back proficient in aerial duels and progressive ground passing from defensive thirds.') }}
                            </p>
                        </div>

                        <div class="mt-4 pt-3 border-t border-[#1a4030] flex items-center justify-between">
                            <span class="text-[11px] font-semibold text-[#8fa89c]">{{ __('IRT Academy') }}</span>
                            <a href="{{ route('register') }}" class="text-xs font-bold text-[#10b981] hover:text-[#a3e635] transition">
                                {{ __('View Profile') }} &rarr;
                            </a>
                        </div>
                    </div>

                    <!-- Sample Player Card 3 -->
                    <div class="atlas-card rounded p-5 flex flex-col justify-between hover:border-[#1f4d38] transition">
                        <div>
                            <div class="flex items-start justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 rounded bg-[#133323] text-[#a3e635] font-display font-bold flex items-center justify-center text-lg border border-[#1a4030]">
                                        KB
                                    </div>
                                    <div>
                                        <h4 class="font-display uppercase tracking-wider text-white text-lg">Karim Benchekroun</h4>
                                        <p class="text-xs text-[#8fa89c] flex items-center">
                                            <svg class="w-3.5 h-3.5 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            </svg>
                                            {{ __('Marrakech, Al Haouz') }}
                                        </p>
                                    </div>
                                </div>
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-[#133323] text-[#10b981] border border-[#10b981]/30">
                                    {{ __('Midfielder (CM)') }}
                                </span>
                            </div>

                            <div class="mt-4 grid grid-cols-3 gap-1 bg-[#0d2919] py-2 px-1 rounded text-center text-xs border border-[#1a4030]">
                                <div>
                                    <span class="text-[#8fa89c] text-[10px] font-bold uppercase">{{ __('Age') }}</span>
                                    <p class="font-display font-bold text-white text-base">{{ __('18 yrs') }}</p>
                                </div>
                                <div>
                                    <span class="text-[#8fa89c] text-[10px] font-bold uppercase">{{ __('Foot') }}</span>
                                    <p class="font-display font-bold text-white text-base">{{ __('Right') }}</p>
                                </div>
                                <div>
                                    <span class="text-[#8fa89c] text-[10px] font-bold uppercase">{{ __('Height') }}</span>
                                    <p class="font-display font-bold text-white text-base">{{ __('181 cm') }}</p>
                                </div>
                            </div>

                            <p class="mt-3 text-xs text-[#8fa89c] line-clamp-2">
                                {{ __('Box-to-box midfielder with high stamina, intercepting acumen, and transition ball-carrying capabilities.') }}
                            </p>
                        </div>

                        <div class="mt-4 pt-3 border-t border-[#1a4030] flex items-center justify-between">
                            <span class="text-[11px] font-semibold text-[#8fa89c]">{{ __('KACM Youth') }}</span>
                            <a href="{{ route('register') }}" class="text-xs font-bold text-[#10b981] hover:text-[#a3e635] transition">
                                {{ __('View Profile') }} &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- How It Works Section -->
        <section id="how-it-works" class="relative py-24 bg-[#0a1f14] overflow-hidden">
            <div class="atlas-plus-pattern"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center max-w-2xl mx-auto mb-14">
                    <h2 class="text-xs font-bold text-[#10b981] uppercase tracking-widest">{{ __('Step-by-Step Pathway') }}</h2>
                    <p class="text-4xl sm:text-5xl font-display uppercase tracking-wider text-white mt-2">{{ __('How Atlas11 Works') }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                    <!-- Step 1 -->
                    <div class="atlas-card rounded p-6">
                        <div class="w-14 h-14 rounded bg-[#10b981] text-[#0a1f14] text-xl font-display font-bold flex items-center justify-center mb-4">
                            1
                        </div>
                        <h3 class="text-xl font-display uppercase tracking-wider text-white">{{ __('Create Your Dossier') }}</h3>
                        <p class="text-sm text-[#8fa89c] mt-2 leading-relaxed">
                            {{ __('Sign up as a player and add your position, birth date, preferred foot, physical metrics, club history, and player bio.') }}
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="atlas-card rounded p-6">
                        <div class="w-14 h-14 rounded bg-[#10b981] text-[#0a1f14] text-xl font-display font-bold flex items-center justify-center mb-4">
                            2
                        </div>
                        <h3 class="text-xl font-display uppercase tracking-wider text-white">{{ __('Get Discovered') }}</h3>
                        <p class="text-sm text-[#8fa89c] mt-2 leading-relaxed">
                            {{ __('Certified scouts filter through regional profiles, track prospects, and review candidate dossiers matching club needs.') }}
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="atlas-card rounded p-6">
                        <div class="w-14 h-14 rounded bg-[#a3e635] text-[#0a1f14] text-xl font-display font-bold flex items-center justify-center mb-4">
                            3
                        </div>
                        <h3 class="text-xl font-display uppercase tracking-wider text-white">{{ __('Trial & Direct Connect') }}</h3>
                        <p class="text-sm text-[#8fa89c] mt-2 leading-relaxed">
                            {{ __('Receive official scouting interest notifications with trial invitation details directly on your dashboard.') }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- High-Impact Call to Action Banner -->
        <section class="relative py-24 bg-[#0d2919] overflow-hidden">
            <div class="atlas-plus-pattern"></div>
            <span class="atlas-bg-text" style="top: 50%; left: -4%;">ATLAS11</span>
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
                <span class="inline-block px-3 py-1 rounded text-xs font-display font-extrabold text-[#0a1f14] bg-[#a3e635] uppercase tracking-wider mb-6">
                    {{ __('Ready For Discovery?') }}
                </span>
                <h2 class="text-4xl sm:text-5xl font-display uppercase tracking-wider text-white">
                    {{ __('Join the Moroccan Football Talent Scouting Network Today') }}
                </h2>
                <p class="text-base text-[#8fa89c] max-w-2xl mx-auto mt-4 leading-relaxed">
                    {{ __('Whether you are an aspiring player seeking exposure or a scout looking for the next star, Atlas11 is your official scouting platform.') }}
                </p>

                <div class="mt-8 flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('register') }}" class="atlas-btn-player inline-flex items-center justify-center px-8 py-3.5 text-sm font-display uppercase tracking-wider rounded">
                        {{ __('Get Started Now') }}
                    </a>
                    <a href="{{ route('login') }}" class="atlas-btn-scout inline-flex items-center justify-center px-8 py-3.5 text-sm font-display uppercase tracking-wider rounded">
                        {{ __('Sign In to Account') }}
                    </a>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="atlas-footer bg-[#0d2919] border-t border-[#1a4030] py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center space-x-4">
                    <x-application-logo class="h-9 w-auto text-white" />
                    <span class="text-xs text-[#8fa89c] font-medium border-l border-[#1a4030] pl-4">
                        {{ __('Dedicated to Moroccan Football Talent Discovery') }}
                    </span>
                </div>

                <div class="flex items-center space-x-6 text-xs text-[#8fa89c]">
                    <span>&copy; {{ date('Y') }} Atlas11. {{ __('All rights reserved.') }}</span>
                    <span>{{ __('Built for Moroccan Football') }}</span>
                </div>
            </div>
        </footer>
    </body>
</html>