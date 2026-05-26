<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — Soilytics</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans">

<div class="auth-split">
    {{-- ── Left: Form Side ──────────────────────────────────────────────── --}}
    <div class="auth-form-side">
        <div class="auth-card-split">
            {{-- Logo --}}
            <div class="text-center mb-8">
                <a href="/" class="inline-flex items-center gap-2 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-lime-400 flex items-center justify-center shadow-md">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 3v1m0 16v1M4.22 4.22l.7.7M18.36 18.36l.7.7M1 12h1m20 0h1M4.22 19.78l.7-.7M18.36 5.64l.7-.7"/>
                        </svg>
                    </div>
                    <span class="font-black text-2xl gradient-text">Soilytics</span>
                </a>
                <h2 class="text-2xl font-bold text-slate-800">Welcome back</h2>
                <p class="text-slate-500 text-sm mt-1">Sign in to your account to continue</p>
            </div>

            {{-- Flash --}}
            @if(session('success'))
                <div class="alert-success mb-4">{{ session('success') }}</div>
            @endif

            {{-- Form --}}
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="label-soil">Email Address</label>
                    <input id="email" name="email" type="email" autocomplete="email" required
                           value="{{ old('email') }}"
                           placeholder="you@example.com"
                           class="input-soil @error('email') border-red-500/50 @enderror">
                    @error('email')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="label-soil mb-0">Password</label>
                        <a href="{{ route('password.request') }}" class="text-xs text-emerald-600 hover:text-emerald-700 font-bold transition-colors">Forgot password?</a>
                    </div>
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                           placeholder="••••••••"
                           class="input-soil @error('password') border-red-500/50 @enderror">
                    @error('password')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-2">
                    <input id="remember" name="remember" type="checkbox"
                           class="w-4 h-4 rounded border-slate-300 text-emerald-500 focus:ring-emerald-500/20">
                    <label for="remember" class="text-sm text-slate-600 font-medium">Remember me for 30 days</label>
                </div>

                <button type="submit" class="btn-primary btn-magnetic w-full justify-center py-3.5 text-base">
                    Sign In
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                </button>
            </form>

            <p class="text-center text-sm text-slate-500 mt-6 font-medium">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-emerald-600 font-bold hover:text-emerald-700 transition-colors">Create account</a>
            </p>
        </div>
    </div>

    {{-- ── Right: Illustration Side ─────────────────────────────────────── --}}
    <div class="auth-illustration-side">
        {{-- Animated blobs --}}
        <div class="auth-blob" style="width:300px;height:300px;background:rgba(16,185,129,0.25);top:10%;left:10%;"></div>
        <div class="auth-blob" style="width:200px;height:200px;background:rgba(132,204,22,0.2);bottom:15%;right:10%;animation-delay:-5s;"></div>

        {{-- Orbiting rings --}}
        <div class="auth-orbit" style="width:400px;height:400px;top:50%;left:50%;margin-top:-200px;margin-left:-200px;"></div>
        <div class="auth-orbit" style="width:280px;height:280px;top:50%;left:50%;margin-top:-140px;margin-left:-140px;animation-direction:reverse;animation-duration:20s;"></div>

        {{-- Pulse ring --}}
        <div class="auth-pulse-ring" style="width:160px;height:160px;top:50%;left:50%;margin-top:-80px;margin-left:-80px;"></div>

        {{-- Central illustration content --}}
        <div class="relative z-10 text-center px-12 max-w-md">
            {{-- Floating cards --}}
            <div class="auth-float-1 auth-illust-card mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-lime-400 flex items-center justify-center text-white text-lg">🔬</div>
                    <div class="text-left">
                        <p class="text-sm font-bold text-slate-700">AI Analysis Complete</p>
                        <p class="text-xs text-slate-500">Soil Type: Red Loam • pH 6.8</p>
                    </div>
                </div>
            </div>

            <div class="auth-float-2 auth-illust-card mb-6" style="animation-delay: 0.3s;">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-lime-400 to-emerald-500 flex items-center justify-center text-white text-lg">🌾</div>
                    <div class="text-left">
                        <p class="text-sm font-bold text-slate-700">Top Crop: Rice</p>
                        <p class="text-xs text-emerald-600 font-semibold">Health Score: 87/100 ✓</p>
                    </div>
                </div>
            </div>

            <div class="auth-float-3 auth-illust-card mb-8" style="animation-delay: 0.6s;">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-400 to-lime-500 flex items-center justify-center text-white text-lg">📊</div>
                    <div class="text-left">
                        <p class="text-sm font-bold text-slate-700">Nutrient Report</p>
                        <div class="flex gap-2 mt-1">
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 font-bold">N: 72%</span>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-lime-100 text-lime-700 font-bold">P: 54%</span>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 font-bold">K: 68%</span>
                        </div>
                    </div>
                </div>
            </div>

            <h3 class="text-2xl font-black text-slate-800 mb-2">Smart Farming<br><span class="gradient-text">Starts Here</span></h3>
            <p class="text-slate-500 text-sm">Analyze your soil and get AI-powered recommendations in seconds.</p>
        </div>
    </div>
</div>

</body>
</html>
