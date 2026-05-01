<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>APAS Admin | Agricultural Price Advisor</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
            .glass { background: rgba(255, 255, 255, 0.06); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.08); }
            .aurora { filter: blur(100px); opacity: 0.5; }
            @keyframes pulse-glow {
                0%, 100% { box-shadow: 0 0 30px rgba(99, 102, 241, 0.2); }
                50% { box-shadow: 0 0 60px rgba(99, 102, 241, 0.4); }
            }
            .input-glass {
                @apply glass rounded-lg px-4 py-3 text-white/90 placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/20 transition-all duration-200;
            }
            .btn-primary {
                @apply rounded-2xl bg-gradient-to-r from-indigo-500 via-blue-500 to-purple-500 px-6 py-3 text-white font-semibold text-slate-950 shadow-2xl shadow-indigo-500/30 hover:from-indigo-400 hover:to-blue-400 transition-all duration-200;
            }
            .btn-primary-glow {
                box-shadow: 0 0 60px rgba(99, 102, 241, 0.3);
                animation: pulse-glow 2s ease-in-out infinite;
            }
            .btn-secondary {
                @apply glass rounded-2xl border border-white/20 px-6 py-3 text-white font-semibold hover:bg-white/10 transition-all duration-200;
            }
            .checkbox-custom {
                @apply rounded border-gray-600 text-indigo-500 shadow-sm focus:ring-indigo-500;
            }
            .gradient-text-admin {
                background: linear-gradient(135deg, #6366f1 0%, #3b82f6 50%, #a855f7 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }
        </style>
    </head>
    <body class="min-h-screen bg-[#0f172a] text-slate-100 antialiased selection:bg-indigo-500/30">
        <!-- Animated Background - Blue/Indigo theme -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
            <div class="absolute -top-[20%] -left-[15%] w-[50%] h-[50%] bg-indigo-600/30 aurora rounded-full"></div>
            <div class="absolute top-[10%] -right-[10%] w-[45%] h-[45%] bg-blue-500/25 aurora rounded-full"></div>
            <div class="absolute bottom-[0%] left-[20%] w-[35%] h-[35%] bg-purple-500/20 aurora rounded-full"></div>
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-15 mix-blend-overlay"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-[#0f172a]"></div>
        </div>

        <!-- Main Content -->
        <main class="relative z-10 flex min-h-screen items-center justify-center px-6">
            <div class="max-w-7xl w-full grid gap-8 lg:grid-cols-[1fr_1fr] items-center">
                <!-- Left Hero Section -->
                <div class="hidden lg:flex flex-col items-center space-y-12">
                    <div class="text-center">
                        <div class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-indigo-500/20 to-blue-500/20 border border-indigo-400/30 px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-indigo-300">
                            <span class="flex h-1.5 w-1.5 rounded-full bg-indigo-400"></span>
                            Administrator Access
                        </div>
                        <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl">
                            <span class="gradient-text-admin">Admin Portal</span><br>
                            <span class="text-white">Management Dashboard</span>
                        </h1>
                        <p class="max-w-xl text-lg leading-8 text-slate-300">
                            Manage products, view market prices, track farmers, and configure system alerts.
                        </p>
                    </div>

                    <!-- Admin-themed Icons -->
                    <div class="flex items-center gap-8">
                        <div class="relative w-20 h-20">
                            <div class="absolute inset-0 rounded-full bg-gradient-to-br from-indigo-500/20 via-blue-500/10 to-purple-500/5 blur-xl"></div>
                            <div class="absolute inset-0 rounded-full bg-gradient-to-br from-indigo-400/20 to-blue-400/10 flex items-center justify-center w-12 h-12">
                                <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="relative w-24 h-24">
                            <div class="absolute inset-0 rounded-full bg-gradient-to-br from-indigo-500/15 via-blue-500/10 to-purple-500/5 blur-2xl"></div>
                            <div class="absolute inset-0 rounded-full border-2 border-white/10 flex items-center justify-center w-16 h-16">
                                <svg class="w-8 h-8 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="relative w-28 h-28">
                            <div class="absolute inset-0 rounded-full bg-gradient-to-br from-indigo-500/25 via-blue-500/15 to-purple-500/10 blur-3xl"></div>
                            <div class="absolute inset-0 rounded-full border border-white/15 flex items-center justify-center w-20 h-20">
                                <svg class="w-10 h-10 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Form Section -->
                <div class="w-full max-w-lg space-y-6">
                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('admin.login.store') }}">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <x-input-label for="email" :value="__('Email Address')" class="block text-sm font-medium text-slate-200 mb-2" />
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
                            />
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-rose-400" />
                        </div>

                        <!-- Remember Me -->
                        <div class="block mt-4">
                            <label for="remember_me" class="inline-flex items-center">
                                <input
                                    id="remember_me"
                                    type="checkbox"
                                    class="checkbox-custom h-4 w-4 text-indigo-600 border-gray-300 rounded"
                                    name="remember"
                                >
                                <span class="ms-2 text-sm text-slate-200">{{ __('Remember me') }}</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-3 btn-primary btn-primary-glow">
                                {{ __('Sign in as Admin') }}
                            </x-primary-button>
                        </div>

                        <div class="flex items-center justify-between mt-6 text-sm text-slate-400 border-t border-white/10 pt-4">
                            <span>
                                <a href="{{ route('home') }}" class="underline hover:text-slate-100 font-medium">
                                    {{ __('Back to Home') }}
                                </a>
                            </span>
                            <span>
                                Farmer login? 
                                <a
                                    href="{{ route('login') }}"
                                    class="underline hover:text-slate-100 font-medium"
                                >
                                    {{ __('Switch to Farmer') }}
                                </a>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </body>
</html>