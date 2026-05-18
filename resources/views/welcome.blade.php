<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Soilytics — AI-powered smart soil analysis, crop recommendation, and fertilizer guidance platform for modern farming.">
    <title>Soilytics — AI-Powered Smart Soil Analysis Platform</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#080d08] text-slate-200 font-sans overflow-x-hidden">

{{-- ── Navbar ─────────────────────────────────────────────────────────────── --}}
<nav class="nav-public h-16 flex items-center px-6 md:px-12">
    <div class="max-w-7xl mx-auto w-full flex items-center justify-between">
        <a href="/" class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-500 to-lime-400 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 3v1m0 16v1M4.22 4.22l.7.7M18.36 18.36l.7.7M1 12h1m20 0h1M4.22 19.78l.7-.7M18.36 5.64l.7-.7"/>
                </svg>
            </div>
            <span class="font-bold text-xl gradient-text">Soilytics</span>
        </a>

        <div class="hidden md:flex items-center gap-8 text-sm text-slate-400">
            <a href="#features"     class="hover:text-emerald-400 transition-colors">Features</a>
            <a href="#how-it-works" class="hover:text-emerald-400 transition-colors">How It Works</a>
            <a href="#stats"        class="hover:text-emerald-400 transition-colors">Statistics</a>
        </div>

        <div class="flex items-center gap-3">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-primary py-2 px-5 text-sm">Dashboard</a>
            @else
                <a href="{{ route('login') }}"    class="btn-secondary py-2 px-5 text-sm">Sign In</a>
                <a href="{{ route('register') }}" class="btn-primary  py-2 px-5 text-sm">Get Started</a>
            @endauth
        </div>
    </div>
</nav>

{{-- ── Hero ────────────────────────────────────────────────────────────────── --}}
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    {{-- Background blobs --}}
    <div class="hero-blob w-[600px] h-[600px] bg-emerald-500 top-[-200px] left-[-100px]"></div>
    <div class="hero-blob w-[400px] h-[400px] bg-lime-500   bottom-[-100px] right-[-100px]" style="opacity:0.1;"></div>
    <div class="hero-blob w-[300px] h-[300px] bg-emerald-700 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2" style="opacity:0.08;"></div>

    {{-- Grid overlay --}}
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: linear-gradient(rgba(52,211,153,1) 1px, transparent 1px), linear-gradient(90deg, rgba(52,211,153,1) 1px, transparent 1px); background-size: 40px 40px;"></div>

    <div class="relative z-10 max-w-6xl mx-auto px-6 py-24 text-center">
        {{-- Badge --}}
        <div class="inline-flex items-center gap-2 glass rounded-full px-4 py-2 mb-8 text-sm text-emerald-400 animate-fadeInUp">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            AI-Powered Agriculture Platform
        </div>

        {{-- Headline --}}
        <h1 class="text-5xl md:text-7xl font-black mb-6 leading-tight animate-fadeInUp delay-100" style="opacity:0;">
            Smart Soil Analysis<br>
            <span class="gradient-text">Powered by AI</span>
        </h1>

        <p class="text-slate-400 text-lg md:text-xl max-w-2xl mx-auto mb-10 leading-relaxed animate-fadeInUp delay-200" style="opacity:0;">
            Upload soil images, analyse soil health, and receive intelligent crop &amp; fertilizer recommendations — all in seconds.
        </p>

        {{-- CTA Buttons --}}
        <div class="flex flex-wrap items-center justify-center gap-4 mb-20 animate-fadeInUp delay-300" style="opacity:0;">
            <a href="{{ route('register') }}" class="btn-primary text-base py-3.5 px-8">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                Get Started Free
            </a>
            <a href="{{ route('soil.upload') }}" class="btn-secondary text-base py-3.5 px-8">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>
                Analyse Soil Now
            </a>
        </div>

        {{-- Floating Dashboard Preview --}}
        <div class="relative animate-float animate-fadeInUp delay-400" style="opacity:0;">
            <div class="glass-strong rounded-2xl p-6 max-w-3xl mx-auto" style="box-shadow: 0 0 60px rgba(16,185,129,0.15), 0 40px 80px rgba(0,0,0,0.5);">
                {{-- Fake dashboard bar --}}
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-3 h-3 rounded-full bg-red-500/70"></div>
                    <div class="w-3 h-3 rounded-full bg-yellow-500/70"></div>
                    <div class="w-3 h-3 rounded-full bg-emerald-500/70"></div>
                    <div class="flex-1 h-5 rounded-md ml-2" style="background:rgba(255,255,255,0.04)"></div>
                </div>
                {{-- Cards row --}}
                <div class="grid grid-cols-3 gap-3 mb-3">
                    <div class="card-soil p-4">
                        <p class="text-[10px] text-slate-500 uppercase tracking-wider mb-1">Health Score</p>
                        <p class="text-2xl font-black gradient-text">87/100</p>
                        <span class="badge badge-healthy mt-1">● Healthy</span>
                    </div>
                    <div class="card-soil p-4">
                        <p class="text-[10px] text-slate-500 uppercase tracking-wider mb-1">Soil Type</p>
                        <p class="text-base font-bold text-slate-200">Red Loam</p>
                        <p class="text-xs text-emerald-400 mt-1">pH: 6.8 — Neutral</p>
                    </div>
                    <div class="card-soil p-4">
                        <p class="text-[10px] text-slate-500 uppercase tracking-wider mb-1">Top Crop</p>
                        <p class="text-base font-bold text-slate-200">🌾 Rice</p>
                        <p class="text-xs text-slate-400 mt-1">Kharif Season</p>
                    </div>
                </div>
                {{-- Bar chart preview --}}
                <div class="card-soil p-4">
                    <p class="text-[10px] text-slate-500 uppercase tracking-wider mb-3">Nutrient Profile</p>
                    <div class="space-y-2">
                        @foreach(['Nitrogen' => 72, 'Phosphorus' => 54, 'Potassium' => 68, 'Moisture' => 61] as $label => $val)
                        <div class="flex items-center gap-3">
                            <span class="text-[11px] text-slate-400 w-20">{{ $label }}</span>
                            <div class="flex-1 nutrient-bar-track">
                                <div class="nutrient-bar-fill" style="width: {{ $val }}%"></div>
                            </div>
                            <span class="text-[11px] text-emerald-400 w-8 text-right">{{ $val }}%</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── Features ────────────────────────────────────────────────────────────── --}}
<section id="features" class="py-24 px-6 max-w-7xl mx-auto">
    <div class="text-center mb-16">
        <p class="section-label">What We Offer</p>
        <h2 class="text-4xl md:text-5xl font-bold text-slate-100">Intelligent Features for<br><span class="gradient-text">Modern Farming</span></h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @php
        $features = [
            ['icon' => '🔬', 'title' => 'AI Soil Analysis',       'desc' => 'Upload soil images and get instant AI-powered analysis using Google Gemini Vision — texture, type, and health assessment.'],
            ['icon' => '🌾', 'title' => 'Crop Recommendations',   'desc' => 'Get intelligent crop suggestions based on your soil pH, nutrients, and seasonal climate suitability.'],
            ['icon' => '🧪', 'title' => 'Fertilizer Guidance',    'desc' => 'Receive precise fertilizer recommendations — Urea, DAP, MOP, organic compost — with dosage and timing.'],
            ['icon' => '📊', 'title' => 'Soil Health Score',      'desc' => 'A comprehensive 0–100 health score with Healthy / Moderate / Poor status and actionable insights.'],
            ['icon' => '📈', 'title' => 'Market Prices',          'desc' => 'Track real-time nearby crop market prices so you can plan your harvest and selling strategy effectively.'],
            ['icon' => '📄', 'title' => 'PDF Report Download',    'desc' => 'Download complete printable reports including all analysis data, charts, and recommendations.'],
        ];
        @endphp

        @foreach($features as $i => $f)
        <div class="feature-card animate-fadeInUp" style="animation-delay: {{ $i * 0.08 }}s; opacity: 0;">
            <div class="text-4xl mb-4">{{ $f['icon'] }}</div>
            <h3 class="text-lg font-bold text-slate-100 mb-2">{{ $f['title'] }}</h3>
            <p class="text-slate-400 text-sm leading-relaxed">{{ $f['desc'] }}</p>
        </div>
        @endforeach
    </div>
</section>

{{-- ── How It Works ────────────────────────────────────────────────────────── --}}
<section id="how-it-works" class="py-24 px-6" style="background: linear-gradient(180deg, transparent 0%, rgba(16,185,129,0.04) 50%, transparent 100%);">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-16">
            <p class="section-label">Simple Process</p>
            <h2 class="text-4xl md:text-5xl font-bold">How <span class="gradient-text">Soilytics</span> Works</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @php
            $steps = [
                ['n' => '01', 'title' => 'Register',      'desc' => 'Create your free account in 30 seconds.',                    'icon' => '👤'],
                ['n' => '02', 'title' => 'Upload Soil',   'desc' => 'Drag & drop your soil image or enter NPK values manually.',  'icon' => '📷'],
                ['n' => '03', 'title' => 'AI Analyses',   'desc' => 'Our AI processes your soil data and generates insights.',    'icon' => '🤖'],
                ['n' => '04', 'title' => 'Get Report',    'desc' => 'Receive detailed crop, fertilizer, and health reports.',     'icon' => '📋'],
            ];
            @endphp

            @foreach($steps as $i => $step)
            <div class="text-center animate-fadeInUp" style="animation-delay: {{ $i * 0.12 }}s; opacity: 0;">
                <div class="relative inline-flex mb-4">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-500/20 to-lime-500/10 border border-emerald-500/20 flex items-center justify-center text-3xl">
                        {{ $step['icon'] }}
                    </div>
                    <span class="absolute -top-2 -right-2 w-6 h-6 rounded-full bg-emerald-500 text-white text-[10px] font-bold flex items-center justify-center">{{ $step['n'] }}</span>
                </div>
                <h3 class="font-bold text-slate-200 mb-1">{{ $step['title'] }}</h3>
                <p class="text-slate-400 text-sm">{{ $step['desc'] }}</p>
                @if($i < 3)
                <div class="hidden md:block absolute" style="width:60px;height:2px;background:linear-gradient(90deg,rgba(52,211,153,0.3),transparent);top:32px;right:-30px;"></div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Stats ───────────────────────────────────────────────────────────────── --}}
<section id="stats" class="py-24 px-6 max-w-5xl mx-auto">
    <div class="glass rounded-2xl p-12" style="border-color: rgba(52,211,153,0.15);">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            @php
            $stats = [
                ['value' => '50K+',  'label' => 'Soil Analyses'],
                ['value' => '98%',   'label' => 'Accuracy Rate'],
                ['value' => '12+',   'label' => 'Crop Types'],
                ['value' => '3',     'label' => 'Languages'],
            ];
            @endphp
            @foreach($stats as $s)
            <div>
                <p class="text-4xl md:text-5xl font-black gradient-text mb-2">{{ $s['value'] }}</p>
                <p class="text-slate-400 text-sm">{{ $s['label'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Testimonials ────────────────────────────────────────────────────────── --}}
<section class="py-24 px-6 max-w-7xl mx-auto">
    <div class="text-center mb-12">
        <p class="section-label">Testimonials</p>
        <h2 class="text-4xl font-bold">Trusted by <span class="gradient-text">Farmers</span></h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @php
        $testimonials = [
            ['name' => 'Ravi Kumar', 'role' => 'Paddy Farmer, Telangana', 'quote' => 'Soilytics helped me understand my soil deficiencies and increase my paddy yield by 30% in one season.', 'avatar' => 'R'],
            ['name' => 'Lakshmi Devi', 'role' => 'Horticulture Farmer, AP', 'quote' => 'The fertilizer recommendations were spot on. My tomato crop has never looked healthier. Highly recommended!', 'avatar' => 'L'],
            ['name' => 'Suresh Patel', 'role' => 'Cotton Grower, Gujarat', 'quote' => 'The market price tracker alone saves me thousands every season. Plus the AI analysis is incredibly accurate.', 'avatar' => 'S'],
        ];
        @endphp
        @foreach($testimonials as $t)
        <div class="card-soil p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-500 to-lime-400 flex items-center justify-center text-white font-bold">{{ $t['avatar'] }}</div>
                <div>
                    <p class="font-semibold text-slate-200 text-sm">{{ $t['name'] }}</p>
                    <p class="text-xs text-slate-500">{{ $t['role'] }}</p>
                </div>
            </div>
            <p class="text-slate-400 text-sm leading-relaxed">"{{ $t['quote'] }}"</p>
            <div class="flex gap-1 mt-3">@for($i=0;$i<5;$i++)<span class="text-yellow-400 text-sm">★</span>@endfor</div>
        </div>
        @endforeach
    </div>
</section>

{{-- ── CTA Banner ──────────────────────────────────────────────────────────── --}}
<section class="py-24 px-6">
    <div class="max-w-4xl mx-auto text-center glass rounded-2xl p-16 relative overflow-hidden" style="border-color:rgba(52,211,153,0.2); background: linear-gradient(135deg, rgba(16,185,129,0.08) 0%, rgba(132,204,22,0.05) 100%);">
        <div class="hero-blob w-64 h-64 bg-emerald-500 top-0 left-0" style="opacity:0.08;filter:blur(60px);"></div>
        <p class="section-label mb-3">Start Today</p>
        <h2 class="text-4xl md:text-5xl font-black text-slate-100 mb-4">Ready to Transform<br><span class="gradient-text">Your Farming?</span></h2>
        <p class="text-slate-400 mb-8">Join thousands of farmers already using Soilytics for smarter agriculture decisions.</p>
        <a href="{{ route('register') }}" class="btn-primary text-base py-4 px-10">
            Start Free Analysis
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
        </a>
    </div>
</section>

{{-- ── Footer ──────────────────────────────────────────────────────────────── --}}
<footer class="border-t border-[rgba(52,211,153,0.08)] py-12 px-6">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-emerald-500 to-lime-400 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 3v1m0 16v1M4.22 4.22l.7.7M18.36 18.36l.7.7M1 12h1m20 0h1M4.22 19.78l.7-.7M18.36 5.64l.7-.7"/></svg>
            </div>
            <span class="font-bold gradient-text">Soilytics</span>
            <span class="text-slate-600 text-sm">— Smart Soil Analysis Platform</span>
        </div>
        <p class="text-slate-600 text-sm">© {{ date('Y') }} Soilytics. Built with Laravel &amp; Gemini AI.</p>
        <div class="flex items-center gap-6 text-sm text-slate-500">
            <a href="{{ route('login') }}"    class="hover:text-emerald-400 transition-colors">Login</a>
            <a href="{{ route('register') }}" class="hover:text-emerald-400 transition-colors">Register</a>
            <a href="{{ route('markets') }}"  class="hover:text-emerald-400 transition-colors">Markets</a>
        </div>
    </div>
</footer>

<script>
// Intersection Observer for scroll animations
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.animationPlayState = 'running';
        }
    });
}, { threshold: 0.1 });

document.querySelectorAll('.animate-fadeInUp').forEach(el => {
    el.style.animationPlayState = 'paused';
    observer.observe(el);
});
</script>
</body>
</html>
