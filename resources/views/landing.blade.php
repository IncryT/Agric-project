<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>APAS | Agricultural Price Advisor</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
            .glass { background: rgba(255, 255, 255, 0.06); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.08); }
            .aurora { filter: blur(100px); opacity: 0.5; }
            .marquee {
                animation: marquee 25s linear infinite;
            }
            @keyframes marquee {
                0% { transform: translateX(0); }
                100% { transform: translateX(-50%); }
            }
            .gradient-text {
                background: linear-gradient(135deg, #34d399 0%, #22d3ee 50%, #a78bfa 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }
            .glow {
                box-shadow: 0 0 60px rgba(52, 211, 153, 0.3);
            }
            .pulse-glow {
                animation: pulse-glow 2s ease-in-out infinite;
            }
            @keyframes pulse-glow {
                0%, 100% { box-shadow: 0 0 30px rgba(52, 211, 153, 0.2); }
                50% { box-shadow: 0 0 60px rgba(52, 211, 153, 0.4); }
            }
        </style>
    </head>
    <body class="min-h-screen bg-[#020617] text-slate-100 antialiased selection:bg-emerald-500/30">
        <!-- Animated Background -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
            <div class="absolute -top-[20%] -left-[15%] w-[50%] h-[50%] bg-emerald-600/30 aurora rounded-full"></div>
            <div class="absolute top-[10%] -right-[10%] w-[45%] h-[45%] bg-cyan-500/25 aurora rounded-full"></div>
            <div class="absolute bottom-[0%] left-[20%] w-[35%] h-[35%] bg-violet-500/20 aurora rounded-full"></div>
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-15 mix-blend-overlay"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-[#020617]"></div>
        </div>

        <!-- Navigation -->
        <div class="sticky top-0 z-50 glass border-b border-white/10 backdrop-blur-2xl">
            <div class="mx-auto max-w-7xl px-6 py-4 flex flex-wrap items-center justify-between gap-4">
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-400 via-cyan-400 to-violet-400 shadow-2xl shadow-emerald-500/30 flex items-center justify-center text-slate-950 font-bold text-xl group-hover:scale-110 transition-transform">A</div>
                    <div>
                        <p class="text-xl font-bold text-white">APAS</p>
                        <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Agri Price Advisor</p>
                    </div>
                </a>
                <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-300">
                  
                </nav>
                <div class="flex items-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('dashboard') }}" class="rounded-full bg-gradient-to-r from-emerald-400 to-cyan-400 px-5 py-2.5 text-sm font-bold text-slate-950 shadow-2xl shadow-cyan-500/20 hover:from-emerald-300 hover:to-cyan-300 transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-200 hover:text-white transition">Sign In</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="rounded-full bg-gradient-to-r from-emerald-400 to-cyan-400 px-5 py-2.5 text-sm font-bold text-slate-950 shadow-2xl shadow-cyan-500/20 hover:from-emerald-300 hover:to-cyan-300 transition">Get Started</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>

        <!-- Live Market Ticker Marquee -->
        <section id="ticker" class="relative py-6 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-emerald-900/20 via-cyan-900/20 to-violet-900/20"></div>
            <div class="relative">
                <div class="flex items-center gap-2 mb-4 ml-6">
                    <span class="flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-2 w-2 rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-400"></span>
                    </span>
                    <span class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-300">Live Market Prices</span>
                </div>
                <div class="overflow-hidden bg-slate-900/60 border-y border-white/5">
                    <div class="flex min-w-full gap-6 py-3 marquee">
                        @foreach ($marketData as $item)
                            <div class="flex items-center gap-4 rounded-2xl border border-white/10 bg-gradient-to-r from-white/5 to-white/[0.02] px-6 py-3 hover:from-emerald-500/20 hover:to-cyan-500/20 transition-all cursor-pointer">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-400/20 to-cyan-400/20 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs uppercase tracking-[0.15em] text-slate-400">{{ $item['crop'] }}</p>
                                    <p class="text-lg font-bold text-white">{{ $item['price'] }}</p>
                                </div>
                                <div class="flex items-center gap-1 text-sm font-semibold {{ $item['status'] === 'up' ? 'text-emerald-400' : 'text-rose-400' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['status'] === 'up' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"></path></svg>
                                    <span>{{ $item['change'] }}</span>
                                </div>
                            </div>
                        @endforeach
                        <!-- Duplicate for seamless loop -->
                        @foreach ($marketData as $item)
                            <div class="flex items-center gap-4 rounded-2xl border border-white/10 bg-gradient-to-r from-white/5 to-white/[0.02] px-6 py-3 hover:from-emerald-500/20 hover:to-cyan-500/20 transition-all cursor-pointer">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-400/20 to-cyan-400/20 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs uppercase tracking-[0.15em] text-slate-400">{{ $item['crop'] }}</p>
                                    <p class="text-lg font-bold text-white">{{ $item['price'] }}</p>
                                </div>
                                <div class="flex items-center gap-1 text-sm font-semibold {{ $item['status'] === 'up' ? 'text-emerald-400' : 'text-rose-400' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['status'] === 'up' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"></path></svg>
                                    <span>{{ $item['change'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <main class="mx-auto max-w-7xl px-6 py-12 lg:py-20">
            <!-- Hero Section -->
            <div class="grid gap-12 lg:grid-cols-[1.1fr_0.9fr] items-center mb-20">
                <div class="space-y-8">
                    <div class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-emerald-500/20 to-cyan-500/20 border border-emerald-400/30 px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-emerald-300">
                        <span class="flex h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                        Real-time Market Intelligence
                    </div>
                    <h1 class="text-5xl font-extrabold tracking-tight text-white sm:text-6xl lg:text-7xl leading-[1.1]">
                        <span class="gradient-text">Smart Pricing</span><br>
                        for <span class="text-white">Smarter Profits</span>
                    </h1>
                    <p class="max-w-xl text-lg leading-8 text-slate-300">Track agricultural prices across districts, receive smart alerts, and make data-driven decisions for maximum profitability.</p>
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                        <a href="{{ Route::has('register') ? route('register') : url('/register') }}" class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-emerald-400 via-cyan-400 to-violet-400 px-8 py-4 text-lg font-bold text-slate-950 shadow-2xl shadow-emerald-500/30 hover:scale-[1.02] transition-all glow">
                            Start Free Trial
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                        <a href="{{ Route::has('login') ? route('login') : url('/login') }}" class="inline-flex items-center justify-center rounded-2xl glass border border-white/20 px-8 py-4 text-lg font-semibold text-white hover:bg-white/10 transition-all">
                            Sign In
                        </a>
                    </div>
                </div>

                <!-- Hero Visual -->
                <div class="relative">
                    <div class="absolute inset-0 rounded-[3rem] bg-gradient-to-br from-emerald-500/30 via-cyan-500/20 to-violet-500/10 blur-3xl"></div>
                    <div class="glass relative rounded-[3rem] p-8 shadow-2xl shadow-slate-950/30 border border-white/10">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Next Update</p>
                                <p class="text-2xl font-bold text-white mt-1">06:00 AM</p>
                            </div>
                            <div class="flex items-center gap-2 rounded-full bg-emerald-500/20 px-4 py-2 text-sm font-semibold text-emerald-300">
                                <span class="flex h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                Live
                            </div>
                        </div>
                       
            <!-- Stats Section -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-20">
                <div class="glass rounded-2xl border border-white/10 p-6 text-center hover:border-emerald-400/30 transition-colors">
                    <p class="text-3xl font-bold gradient-text">5+</p>
                    <p class="text-sm text-slate-400 mt-2">Crop Types</p>
                </div>
                <div class="glass rounded-2xl border border-white/10 p-6 text-center hover:border-cyan-400/30 transition-colors">
                    <p class="text-3xl font-bold gradient-text">10+</p>
                    <p class="text-sm text-slate-400 mt-2">Districts</p>
                </div>
                <div class="glass rounded-2xl border border-white/10 p-6 text-center hover:border-violet-400/30 transition-colors">
                    <p class="text-3xl font-bold gradient-text">24/7</p>
                    <p class="text-sm text-slate-400 mt-2">Live Updates</p>
                </div>
                <div class="glass rounded-2xl border border-white/10 p-6 text-center hover:border-emerald-400/30 transition-colors">
                    <p class="text-3xl font-bold gradient-text">100%</p>
                    <p class="text-sm text-slate-400 mt-2">Accurate Data</p>
                </div>
            </div>

            

        <!-- Footer -->
        <footer class="border-t border-white/10 py-12">
            <div class="mx-auto max-w-7xl px-6 flex flex-col gap-8 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-400 to-cyan-400 flex items-center justify-center text-slate-950 font-bold text-xl">A</div>
                    <div>
                        <p class="font-semibold text-white">Agri Price Advisor System</p>
                        <p class="text-sm text-slate-400">Modern pricing intelligence for agriculture.</p>
                    </div>
                </div>
                <div class="flex items-center gap-6 text-sm text-slate-400">
                    <a href="#" class="hover:text-emerald-400 transition-colors">Terms</a>
                    <a href="#" class="hover:text-cyan-400 transition-colors">Privacy</a>
                    <a href="#" class="hover:text-violet-400 transition-colors">Contact</a>
                </div>
                <p class="text-sm text-slate-500">&copy; {{ date('Y') }} APAS. All rights reserved.</p>
            </div>
        </footer>
    </body>
</html>
