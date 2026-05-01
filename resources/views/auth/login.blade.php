<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>APAS | Agricultural Price Advisor - Sign In</title>
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
            .input-glass {
                @apply glass rounded-lg px-4 py-3 text-black placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/20 transition-all duration-200;
            }
            .btn-primary {
                @apply rounded-2xl bg-gradient-to-r from-emerald-400 via-cyan-400 to-violet-400 px-6 py-3 text-white font-semibold text-slate-950 shadow-2xl shadow-emerald-500/30 hover:from-emerald-300 hover:to-cyan-300 transition-all duration-200 glow pulse-glow;
            }
            .btn-secondary {
                @apply glass rounded-2xl border border-white/20 px-6 py-3 text-white font-semibold hover:bg-white/10 transition-all duration-200;
            }
            .checkbox-custom {
                @apply rounded border-gray-600 text-emerald-400 shadow-sm focus:ring-emerald-500;
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

        <!-- Main Content -->
        <main class="relative z-10 flex min-h-screen items-center justify-center px-6">
            <div class="max-w-7xl w-full grid gap-8 lg:grid-cols-[1fr_1fr] items-center">
                <!-- Left Hero Section -->
                <div class="hidden lg:flex flex-col items-center space-y-12">
                    <div class="text-center">
                        <div class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-emerald-500/20 to-cyan-500/20 border border-emerald-400/30 px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-emerald-300">
                            <span class="flex h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                            Welcome Back
                        </div>
                        <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl">
                            <span class="gradient-text">Smart Pricing</span><br>
                            for <span class="text-white">Smarter Profits</span>
                        </h1>
                        <p class="max-w-xl text-lg leading-8 text-slate-300">
                            Track agricultural prices across districts, receive smart alerts, and make data-driven decisions for maximum profitability.
                        </p>
                    </div>
                    
                    <!-- Agri-themed Illustrations -->
                    <div class="flex items-center gap-8">
                        <div class="relative w-20 h-20">
                            <div class="absolute inset-0 rounded-full bg-gradient-to-br from-emerald-500/20 via-cyan-500/10 to-violet-500/5 blur-xl"></div>
                            <div class="absolute inset-0 rounded-full bg-gradient-to-br from-emerald-400/20 to-cyan-400/10 flex items-center justify-center w-12 h-12">
                                <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <div class="relative w-24 h-24">
                            <div class="absolute inset-0 rounded-full bg-gradient-to-br from-emerald-500/15 via-cyan-500/10 to-violet-500/5 blur-2xl"></div>
                            <div class="absolute inset-0 rounded-full border-2 border-white/10 flex items-center justify-center w-16 h-16">
                                <svg class="w-8 h-8 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2.252a8.988 8.988 0 014.913 6.374l1 1h-3l-.224 2.252h-3l1-1c.036-.256.058-.526.064-.802zm-9.756 7.506a8.988 8.988 0 004.913 6.374l1 1H7.81l-.224 2.252h-3l1-1a8.988 8.988 0 004.913-6.374zM16.5 3.75a2.25 2.25 0 01-.056 4.5h1.056a2.25 2.25 0 01-.056-4.5zM5.25 7.5a2.25 2.25 0 01-4.5 0v-.056a2.25 2.25 0 014.5.056v-.938a2.25 2.25 0 01-2.25-2.25h1.056v1.938zm12.75-.056a2.25 2.25 0 00-4.5 0v.056a2.25 2.25 0 004.5.056v-.938a2.25 2.25 0 00-2.25-2.25h1.056v1.938z"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <div class="relative w-28 h-28">
                            <div class="absolute inset-0 rounded-full bg-gradient-to-br from-emerald-500/25 via-cyan-500/15 to-violet-500/10 blur-3xl"></div>
                            <div class="absolute inset-0 rounded-full border border-white/15 flex items-center justify-center w-20 h-20">
                                <svg class="w-10 h-10 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2H5a2 2 0 00-2 2v2m14 0h-3m3 0V9a2 2 0 00-2-2H5a2 2 0 00-2 2v2m14 0v2a4 4 0 01-4 4H5a4 4 0 01-4-4v-2m14 0h-3"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Form Section -->
                <div class="w-full max-w-lg space-y-6">
                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />
                    
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <!-- Email Address -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-slate-200 mb-2" />
                            <x-text-input 
                                id="email" 
                                type="email" 
                                name="email" 
                                :value="old('email')" 
                                required 
                                autofocus 
                                autocomplete="username"
                                class="input-glass w-full"
                            />
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-rose-400" />
                        </div>
                        
                        <!-- Password -->
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-slate-200 mb-2" />
                            
                             <x-text-input 
                                 id="password" 
                                 class="block mt-1 w-full input-glass"
                                 type="password"
                                 name="password"
                                 required 
                                 autocomplete="current-password"
                                 placeholder="Minimum 8 characters"
                             />
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-rose-400" />
                        </div>
                        
                        <!-- Remember Me -->
                        <div class="block mt-4">
                            <label for="remember_me" class="inline-flex items-center">
                                <input 
                                    id="remember_me" 
                                    type="checkbox" 
                                    class="checkbox-custom h-4 w-4 text-emerald-600 border-gray-300 rounded" 
                                    name="remember"
                                >
                                <span class="ms-2 text-sm text-slate-200">{{ __('Remember me') }}</span>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-end mt-4">
                            @if (Route::has('password.request'))
                                <a 
                                    class="underline text-sm text-slate-300 hover:text-slate-100 rounded-md focus:outline-none focus:ring-2 focus-ring-offset-2 focus-ring-emerald-500" 
                                    href="{{ route('password.request') }}"
                                >
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif
                            
                            <x-primary-button class="ms-3 btn-primary">
                                {{ __('Log in') }}
                            </x-primary-button>
                        </div>
                        
                        <div class="flex items-center justify-between mt-6 text-sm text-slate-400 border-t border-white/10 pt-4">
                            <span>
                                Don't have an account? 
                                <a 
                                    href="{{ route('register') }}" 
                                    class="underline hover:text-slate-100 font-medium"
                                >
                                    {{ __('Register') }}
                                </a>
                            </span>
                            {{-- 
                            <span>
                                Admin? 
                                <a 
                                    href="{{ route('admin.login') }}" 
                                    class="underline hover:text-slate-100 font-medium"
                                >
                                    {{ __('Admin Login') }}
                                </a>
                            </span>
                            --}}
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </body>
</html>