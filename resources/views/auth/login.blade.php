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

<div class="auth-container">
    {{-- Blobs --}}
    <div class="hero-blob w-96 h-96 bg-emerald-500/10 top-0 left-0"></div>
    <div class="hero-blob w-64 h-64 bg-lime-500/5 bottom-0 right-0"></div>

    <div class="auth-card animate-bounce-in relative z-10 w-full shadow-lg border border-slate-200/80">
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

            <button type="submit" class="btn-primary w-full justify-center py-3.5 text-base">
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

</body>
</html>
