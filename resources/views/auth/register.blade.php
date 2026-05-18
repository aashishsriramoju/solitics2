<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account — Soilytics</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans">

<div class="auth-container">
    <div class="hero-blob w-96 h-96 bg-emerald-500/10 top-0 right-0"></div>
    <div class="hero-blob w-64 h-64 bg-lime-500/5 bottom-0 left-0"></div>

    <div class="auth-card animate-bounce-in relative z-10 w-full shadow-lg border border-slate-200/80" style="max-width:480px;">
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center gap-2 mb-4">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-lime-400 flex items-center justify-center shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 3v1m0 16v1M4.22 4.22l.7.7M18.36 18.36l.7.7M1 12h1m20 0h1M4.22 19.78l.7-.7M18.36 5.64l.7-.7"/></svg>
                </div>
                <span class="font-black text-2xl gradient-text">Soilytics</span>
            </a>
            <h2 class="text-2xl font-bold text-slate-800">Create your account</h2>
            <p class="text-slate-500 text-sm mt-1">Start analysing your soil in minutes</p>
        </div>

        <form action="{{ route('register') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="label-soil">Full Name</label>
                <input id="name" name="name" type="text" required autocomplete="name"
                       value="{{ old('name') }}" placeholder="Your full name"
                       class="input-soil @error('name') border-red-500/50 @enderror">
                @error('name')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="email" class="label-soil">Email Address</label>
                <input id="email" name="email" type="email" required autocomplete="email"
                       value="{{ old('email') }}" placeholder="you@example.com"
                       class="input-soil @error('email') border-red-500/50 @enderror">
                @error('email')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="password" class="label-soil">Password</label>
                <input id="password" name="password" type="password" required autocomplete="new-password"
                       placeholder="Min. 8 characters"
                       class="input-soil @error('password') border-red-500/50 @enderror">
                @error('password')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="password_confirmation" class="label-soil">Confirm Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required
                       placeholder="Repeat password"
                       class="input-soil">
            </div>

            <button type="submit" class="btn-primary w-full justify-center py-3.5 text-base">
                Create Account
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
            </button>
        </form>

        <p class="text-center text-sm text-slate-500 mt-6 font-medium">
            Already have an account?
            <a href="{{ route('login') }}" class="text-emerald-600 font-bold hover:text-emerald-700 transition-colors">Sign in</a>
        </p>
    </div>
</div>

</body>
</html>
