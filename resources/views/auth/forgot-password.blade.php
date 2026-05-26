<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password — Soilytics</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans">

<div class="auth-split">
    {{-- ── Left: Form Side ──────────────────────────────────────────────── --}}
    <div class="auth-form-side">
        <div class="auth-card-split">
            <div class="text-center mb-8">
                <a href="/" class="inline-flex items-center gap-2 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-lime-400 flex items-center justify-center shadow-md">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 3v1m0 16v1M4.22 4.22l.7.7M18.36 18.36l.7.7M1 12h1m20 0h1M4.22 19.78l.7-.7M18.36 5.64l.7-.7"/></svg>
                    </div>
                    <span class="font-black text-2xl gradient-text">Soilytics</span>
                </a>
                <h2 class="text-2xl font-bold text-slate-800">Reset Password</h2>
                <p class="text-slate-500 text-sm mt-1">Enter your email to receive a reset link</p>
            </div>

            @if(session('success'))
                <div class="alert-success mb-4">{{ session('success') }}</div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="label-soil">Email Address</label>
                    <input id="email" name="email" type="email" required placeholder="you@example.com" class="input-soil">
                </div>
                <button type="submit" class="btn-primary btn-magnetic w-full justify-center py-3.5 mt-2">Send Reset Link</button>
            </form>

            <p class="text-center text-sm text-slate-500 mt-6">
                <a href="{{ route('login') }}" class="text-emerald-600 font-semibold hover:text-emerald-700 transition-colors">← Back to Sign In</a>
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
            <div class="auth-float-1 auth-illust-card mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-lime-400 flex items-center justify-center text-white text-lg">🔒</div>
                    <div class="text-left">
                        <p class="text-sm font-bold text-slate-700">Secure Recovery</p>
                        <p class="text-xs text-slate-500">Your data is safe with us</p>
                    </div>
                </div>
            </div>
            
            <h3 class="text-2xl font-black text-slate-800 mb-2">Regain Access to<br><span class="gradient-text">Your Data</span></h3>
            <p class="text-slate-500 text-sm">We'll help you get back to managing your farm with intelligent AI insights.</p>
        </div>
    </div>
</div>

</body>
</html>
