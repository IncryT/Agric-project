<x-guest-layout>
    <div class="min-h-screen bg-[#020617] flex font-['Plus_Jakarta_Sans'] selection:bg-emerald-500/30">
        <!-- Left Side: Decorative Hero Section -->
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden items-center justify-center p-12">
            <!-- Animated Background Elements -->
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/10 to-cyan-500/10"></div>
            <div class="absolute top-[-10%] right-[-10%] w-[500px] h-[500px] bg-emerald-500/10 blur-[120px] rounded-full animate-pulse"></div>
            <div class="absolute bottom-[-10%] left-[-10%] w-[500px] h-[500px] bg-cyan-500/10 blur-[120px] rounded-full animate-pulse" style="animation-delay: 2s"></div>

            <div class="relative z-10 p-12 text-center">
                <div class="inline-flex p-3 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 mb-6">
                    <x-application-logo class="w-16 h-16 fill-current text-emerald-400" />
                </div>
                <h2 class="text-4xl font-bold text-white mb-4">Join our Agri-Community</h2>
                <p class="text-slate-400 text-lg max-w-md mx-auto">
                    Start tracking market prices, managing products, and connecting with farmers across the district.
                </p>
            </div>
        </div>

        <!-- Right Side: Register Form Section -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 relative">
            <!-- Mobile Background Blobs -->
            <div class="lg:hidden absolute top-0 left-0 w-full h-full overflow-hidden -z-10">
                <div class="absolute top-[-10%] right-[-10%] w-64 h-64 bg-emerald-500/10 blur-[80px] rounded-full"></div>
                <div class="absolute bottom-[-10%] left-[-10%] w-64 h-64 bg-cyan-500/10 blur-[80px] rounded-full"></div>
            </div>

            <div class="w-full max-w-md">
                <div class="bg-white/5 backdrop-blur-2xl border border-white/10 p-10 rounded-[2.5rem] shadow-2xl relative overflow-hidden group">
                    <!-- Form Top Glow -->
                    <div class="absolute -top-24 -left-24 w-48 h-48 bg-emerald-400/10 blur-[60px] group-hover:bg-emerald-400/20 transition-colors duration-700"></div>

                    <div class="mb-10 relative">
                        <h2 class="text-4xl font-bold text-white mb-3">Create Account</h2>
                        <p class="text-gray-400">Join our growing community of farmers.</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="space-y-6 relative">
                        @csrf

                        <!-- Name -->
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-300 ml-1">Full Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                                class="w-full bg-white/5 border border-white/10 rounded-2xl px-5 py-4 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-400/50 focus:border-emerald-400/50 transition-all duration-300"
                                placeholder="Enter your full name">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email Address -->
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-300 ml-1">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                                class="w-full bg-white/5 border border-white/10 rounded-2xl px-5 py-4 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-400/50 focus:border-emerald-400/50 transition-all duration-300"
                                placeholder="farmer@example.com">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-300 ml-1">Password</label>
                            <input type="password" name="password" required autocomplete="new-password"
                                class="w-full bg-white/5 border border-white/10 rounded-2xl px-5 py-4 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-400/50 focus:border-emerald-400/50 transition-all duration-300"
                                placeholder="••••••••">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-300 ml-1">Confirm Password</label>
                            <input type="password" name="password_confirmation" required autocomplete="new-password"
                                class="w-full bg-white/5 border border-white/10 rounded-2xl px-5 py-4 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-400/50 focus:border-emerald-400/50 transition-all duration-300"
                                placeholder="••••••••">
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <button type="submit" 
                            class="w-full mt-4 bg-gradient-to-r from-emerald-400 to-cyan-400 hover:from-emerald-500 hover:to-cyan-500 text-[#020617] font-bold py-4 rounded-2xl shadow-[0_0_20px_rgba(52,211,153,0.3)] hover:shadow-[0_0_35px_rgba(52,211,153,0.5)] transition-all duration-300 transform hover:-translate-y-1">
                            Create Account
                        </button>
                    </form>

                    <div class="mt-10 text-center">
                        <p class="text-gray-400">
                            Already part of the community? 
                            <a href="{{ route('login') }}" class="text-emerald-400 hover:text-emerald-300 font-bold transition-colors underline decoration-emerald-400/30 underline-offset-4">
                                Sign In
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>