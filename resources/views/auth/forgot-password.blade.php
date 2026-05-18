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
<body class="bg-[#080d08] font-sans">
<div class="auth-container">
    <div class="hero-blob w-96 h-96 bg-emerald-500 top-0 left-0" style="opacity:0.12;"></div>
    <div class="auth-card animate-bounce-in relative z-10">
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center gap-2 mb-4">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-lime-400 flex items-center justify-center"><svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 3v1m0 16v1M4.22 4.22l.7.7M18.36 18.36l.7.7M1 12h1m20 0h1M4.22 19.78l.7-.7M18.36 5.64l.7-.7"/></svg></div>
                <span class="font-black text-2xl gradient-text">Soilytics</span>
            </a>
            <h2 class="text-2xl font-bold text-slate-100">Reset Password</h2>
            <p class="text-slate-400 text-sm mt-1">Enter your email to receive a reset link</p>
        </div>
        @if(session('success'))<div class="alert-success mb-4">{{ session('success') }}</div>@endif
        <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label for="email" class="label-soil">Email Address</label>
                <input id="email" name="email" type="email" required placeholder="you@example.com" class="input-soil">
            </div>
            <button type="submit" class="btn-primary w-full justify-center py-3.5">Send Reset Link</button>
        </form>
        <p class="text-center text-sm text-slate-400 mt-6"><a href="{{ route('login') }}" class="text-emerald-400 font-semibold">← Back to Sign In</a></p>
    </div>
</div>
</body>
</html>
