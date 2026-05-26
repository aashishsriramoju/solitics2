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
<body class="font-sans overflow-x-hidden">

{{-- ── Particle Canvas ──────────────────────────────────────────────────── --}}
<canvas id="particles-canvas"></canvas>

{{-- ── Navbar ────────────────────────────────────────────────────────────── --}}
<nav id="navbar" class="nav-welcome">
    <div class="max-w-7xl mx-auto w-full flex items-center justify-between">
        <a href="/" class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-lime-400 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 3v1m0 16v1M4.22 4.22l.7.7M18.36 18.36l.7.7M1 12h1m20 0h1M4.22 19.78l.7-.7M18.36 5.64l.7-.7"/>
                </svg>
            </div>
            <span class="font-bold text-xl gradient-text-shimmer">Soilytics</span>
        </a>

        <div class="hidden md:flex items-center gap-8 text-sm text-slate-500 font-medium">
            <a href="#features"     class="hover:text-emerald-600 transition-colors duration-300">Features</a>
            <a href="#how-it-works" class="hover:text-emerald-600 transition-colors duration-300">How It Works</a>
            <a href="#stats"        class="hover:text-emerald-600 transition-colors duration-300">Statistics</a>
            <a href="#testimonials" class="hover:text-emerald-600 transition-colors duration-300">Testimonials</a>
        </div>

        <div class="flex items-center gap-3">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-primary py-2.5 px-6 text-sm">Dashboard</a>
            @else
                <a href="{{ route('login') }}"    class="hidden sm:inline-flex btn-secondary py-2.5 px-5 text-sm">Sign In</a>
                <a href="{{ route('register') }}" class="btn-primary btn-magnetic py-2.5 px-6 text-sm">Get Started</a>
            @endauth
            <button id="menu-toggle" class="md:hidden text-slate-600 hover:text-emerald-600 transition-colors p-2">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>
</nav>

{{-- ── Mobile Menu ───────────────────────────────────────────────────────── --}}
<div id="mobile-overlay" class="mobile-overlay"></div>
<div id="mobile-menu" class="mobile-menu">
    <button id="menu-close" class="absolute top-5 right-5 text-slate-400 hover:text-emerald-600 transition-colors">
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
    <div class="flex flex-col gap-6">
        <a href="#features" class="text-slate-700 hover:text-emerald-600 transition-colors text-lg font-medium">Features</a>
        <a href="#how-it-works" class="text-slate-700 hover:text-emerald-600 transition-colors text-lg font-medium">How It Works</a>
        <a href="#stats" class="text-slate-700 hover:text-emerald-600 transition-colors text-lg font-medium">Statistics</a>
        <a href="#testimonials" class="text-slate-700 hover:text-emerald-600 transition-colors text-lg font-medium">Testimonials</a>
        <hr class="border-slate-200">
        @auth
            <a href="{{ route('dashboard') }}" class="btn-primary text-center py-3">Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="text-emerald-600 hover:text-emerald-700 transition-colors text-lg font-semibold">Sign In</a>
            <a href="{{ route('register') }}" class="btn-primary text-center py-3">Get Started</a>
        @endauth
    </div>
</div>

{{-- ── Hero Section ──────────────────────────────────────────────────────── --}}
<section class="relative min-h-screen flex items-center justify-center overflow-hidden pt-20">
    <div class="hero-gradient-mesh"></div>
    <div class="grid-pattern"></div>
    <div class="morph-blob morph-blob-1"></div>
    <div class="morph-blob morph-blob-2"></div>
    <div class="morph-blob morph-blob-3"></div>

    <div class="relative z-10 max-w-6xl mx-auto px-6 py-24 text-center">
        {{-- Badge --}}
        <div class="reveal inline-flex items-center gap-2.5 glass rounded-full px-5 py-2.5 mb-10 text-sm text-emerald-600 font-semibold">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            AI-Powered Agriculture Platform
            <span class="w-2 h-2 rounded-full bg-lime-500 animate-pulse" style="animation-delay:0.4s"></span>
        </div>

        {{-- Headline --}}
        <h1 class="reveal text-5xl sm:text-6xl md:text-7xl lg:text-8xl font-black mb-8 leading-[1.05] tracking-tight text-slate-900">
            Smart Soil Analysis<br>
            <span class="gradient-text-shimmer">Powered by AI</span>
        </h1>

        {{-- Subtitle --}}
        <p class="reveal text-slate-500 text-lg md:text-xl max-w-2xl mx-auto mb-12 leading-relaxed">
            Upload soil images, analyse soil health, and receive intelligent crop &amp; fertilizer recommendations — all in seconds.
            <span class="typewriter-cursor"></span>
        </p>

        {{-- CTA Buttons --}}
        <div class="reveal flex flex-wrap items-center justify-center gap-5 mb-20">
            <a href="{{ route('register') }}" class="btn-primary btn-magnetic text-base py-4 px-10 transition-all duration-500 hover:scale-105 group">
                <svg class="w-5 h-5 transition-transform duration-300 group-hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                Get Started Free
            </a>
            <a href="{{ route('soil.upload') }}" class="btn-secondary btn-magnetic text-base py-4 px-10 transition-all duration-500 hover:scale-105 group">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                </svg>
                Analyse Soil Now
            </a>
        </div>

        {{-- Dashboard Preview --}}
        <div class="reveal-scale dashboard-preview float-medium">
            <div class="glass-strong rounded-2xl p-6 max-w-3xl mx-auto" style="box-shadow: 0 0 80px rgba(16,185,129,0.08), 0 40px 80px rgba(0,0,0,0.06);">
                <div class="flex items-center gap-2 mb-5">
                    <div class="w-3 h-3 rounded-full bg-red-400"></div>
                    <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                    <div class="w-3 h-3 rounded-full bg-emerald-400"></div>
                    <div class="flex-1 h-5 rounded-md ml-2 bg-slate-100"></div>
                </div>
                <div class="grid grid-cols-3 gap-3 mb-3">
                    <div class="card-soil rounded-xl p-4">
                        <p class="text-[10px] text-slate-400 uppercase tracking-wider mb-1">Health Score</p>
                        <p class="text-2xl font-black gradient-text-shimmer">87/100</p>
                        <span class="badge badge-healthy mt-1">● Healthy</span>
                    </div>
                    <div class="card-soil rounded-xl p-4">
                        <p class="text-[10px] text-slate-400 uppercase tracking-wider mb-1">Soil Type</p>
                        <p class="text-base font-bold text-slate-800">Red Loam</p>
                        <p class="text-xs text-emerald-600 mt-1">pH: 6.8 — Neutral</p>
                    </div>
                    <div class="card-soil rounded-xl p-4">
                        <p class="text-[10px] text-slate-400 uppercase tracking-wider mb-1">Top Crop</p>
                        <p class="text-base font-bold text-slate-800">🌾 Rice</p>
                        <p class="text-xs text-slate-500 mt-1">Kharif Season</p>
                    </div>
                </div>
                <div class="card-soil rounded-xl p-4">
                    <p class="text-[10px] text-slate-400 uppercase tracking-wider mb-3">Nutrient Profile</p>
                    <div class="space-y-2.5">
                        @foreach(['Nitrogen' => 72, 'Phosphorus' => 54, 'Potassium' => 68, 'Moisture' => 61] as $label => $val)
                        <div class="flex items-center gap-3">
                            <span class="text-[11px] text-slate-500 w-20">{{ $label }}</span>
                            <div class="flex-1 nutrient-bar-track">
                                <div class="nutrient-bar-fill" style="width: {{ $val }}%"></div>
                            </div>
                            <span class="text-[11px] text-emerald-600 w-8 text-right font-semibold">{{ $val }}%</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Scroll indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 z-10 scroll-indicator">
        <span class="text-slate-400 text-xs uppercase tracking-widest font-medium">Scroll</span>
        <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
        </svg>
    </div>
</section>

{{-- ── Features ──────────────────────────────────────────────────────────── --}}
<section id="features" class="py-28 px-6 max-w-7xl mx-auto">
    <div class="text-center mb-20">
        <div class="reveal"><span class="section-label-welcome">What We Offer</span></div>
        <h2 class="reveal text-4xl md:text-5xl lg:text-6xl font-black text-slate-900 mt-4">
            Intelligent Features for<br>
            <span class="gradient-text-shimmer">Modern Farming</span>
        </h2>
        <p class="reveal text-slate-500 mt-4 max-w-xl mx-auto">Everything you need to transform your agricultural practices with cutting-edge AI technology.</p>
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
        <div class="reveal feature-card-3d stagger-{{ $i + 1 }}">
            <div class="icon-wrap">{{ $f['icon'] }}</div>
            <h3 class="text-lg font-bold text-slate-800 mb-2">{{ $f['title'] }}</h3>
            <p class="text-slate-500 text-sm leading-relaxed">{{ $f['desc'] }}</p>
        </div>
        @endforeach
    </div>
</section>

{{-- ── How It Works ──────────────────────────────────────────────────────── --}}
<section id="how-it-works" class="py-28 px-6 relative hero-accent-bg">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-20">
            <div class="reveal"><span class="section-label-welcome">Simple Process</span></div>
            <h2 class="reveal text-4xl md:text-5xl lg:text-6xl font-black text-slate-900 mt-4">
                How <span class="gradient-text-shimmer">Soilytics</span> Works
            </h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 relative">
            @php
            $steps = [
                ['n' => '01', 'title' => 'Register',    'desc' => 'Create your free account in 30 seconds.',                   'icon' => '👤'],
                ['n' => '02', 'title' => 'Upload Soil',  'desc' => 'Drag & drop your soil image or enter NPK values.',         'icon' => '📷'],
                ['n' => '03', 'title' => 'AI Analyses',  'desc' => 'Our AI processes your soil data and generates insights.', 'icon' => '🤖'],
                ['n' => '04', 'title' => 'Get Report',   'desc' => 'Receive detailed crop, fertilizer, and health reports.',  'icon' => '📋'],
            ];
            @endphp

            @foreach($steps as $i => $step)
            <div class="reveal timeline-step stagger-{{ $i + 1 }}">
                @if($i < 3)
                <div class="timeline-connector hidden md:block"></div>
                @endif
                <div class="step-number">{{ $step['n'] }}</div>
                <div class="text-3xl mb-3">{{ $step['icon'] }}</div>
                <h3 class="font-bold text-slate-800 mb-2 text-lg">{{ $step['title'] }}</h3>
                <p class="text-slate-500 text-sm">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Stats ─────────────────────────────────────────────────────────────── --}}
<section id="stats" class="py-28 px-6 max-w-5xl mx-auto">
    <div class="reveal-scale stats-glass p-10 md:p-16" style="box-shadow: 0 8px 40px rgba(16,185,129,0.06);">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            @php
            $stats = [
                ['value' => '50000', 'suffix' => '+',  'label' => 'Soil Analyses'],
                ['value' => '98',    'suffix' => '%',  'label' => 'Accuracy Rate'],
                ['value' => '12',    'suffix' => '+',  'label' => 'Crop Types'],
                ['value' => '3',     'suffix' => '',   'label' => 'Languages'],
            ];
            @endphp
            @foreach($stats as $s)
            <div class="stat-item">
                <div class="stat-glow"></div>
                <p class="stat-value gradient-text-shimmer">
                    <span class="counter" data-target="{{ $s['value'] }}">0</span>{{ $s['suffix'] }}
                </p>
                <p class="text-slate-500 text-sm font-medium">{{ $s['label'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Testimonials ──────────────────────────────────────────────────────── --}}
<section id="testimonials" class="py-28 overflow-hidden">
    <div class="text-center mb-16 px-6">
        <div class="reveal"><span class="section-label-welcome">Testimonials</span></div>
        <h2 class="reveal text-4xl md:text-5xl font-black text-slate-900 mt-4">Trusted by <span class="gradient-text-shimmer">Farmers</span></h2>
        <p class="reveal text-slate-500 mt-4 max-w-lg mx-auto">Hear from farmers who transformed their yields with Soilytics.</p>
    </div>
    <div class="overflow-hidden">
        <div class="testimonial-track">
            @php
            $testimonials = [
                ['name' => 'Ravi Kumar',    'role' => 'Paddy Farmer, Telangana',    'quote' => 'Soilytics helped me understand my soil deficiencies and increase my paddy yield by 30% in one season.', 'avatar' => 'R'],
                ['name' => 'Lakshmi Devi',  'role' => 'Horticulture Farmer, AP',     'quote' => 'The fertilizer recommendations were spot on. My tomato crop has never looked healthier. Highly recommended!', 'avatar' => 'L'],
                ['name' => 'Suresh Patel',  'role' => 'Cotton Grower, Gujarat',      'quote' => 'The market price tracker alone saves me thousands every season. Plus the AI analysis is incredibly accurate.', 'avatar' => 'S'],
                ['name' => 'Anil Sharma',   'role' => 'Wheat Farmer, Punjab',        'quote' => 'With the pH level adjustments suggested, I saw a massive difference in plant health and output. Best tool out there.', 'avatar' => 'A'],
                ['name' => 'Priya Reddy',   'role' => 'Organic Farmer, Karnataka',   'quote' => 'The organic recommendations are perfect for my farm. I use this every time before a new crop cycle.', 'avatar' => 'P'],
                ['name' => 'John D.',       'role' => 'Orchard Owner, Maharashtra',  'quote' => 'Analyzing soil health without expensive lab tests was a dream, until Soilytics made it a reality.', 'avatar' => 'J'],
            ];
            @endphp
            @for($loop_i = 0; $loop_i < 2; $loop_i++)
                @foreach($testimonials as $t)
                <div class="testimonial-card">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-11 h-11 rounded-full bg-gradient-to-br from-emerald-500 to-lime-400 flex items-center justify-center text-white font-bold text-sm shadow-lg shadow-emerald-500/20">{{ $t['avatar'] }}</div>
                        <div>
                            <p class="font-semibold text-slate-800 text-sm">{{ $t['name'] }}</p>
                            <p class="text-xs text-slate-400">{{ $t['role'] }}</p>
                        </div>
                    </div>
                    <p class="text-slate-500 text-sm leading-relaxed mb-3">"{{ $t['quote'] }}"</p>
                    <div class="flex gap-1">@for($i=0;$i<5;$i++)<span class="text-yellow-400 text-sm">★</span>@endfor</div>
                </div>
                @endforeach
            @endfor
        </div>
    </div>
</section>

{{-- ── CTA Banner ────────────────────────────────────────────────────────── --}}
<section class="py-28 px-6">
    <div class="max-w-4xl mx-auto reveal-scale">
        <div class="cta-section">
            <div class="cta-inner">
                <div class="cta-blob" style="width:200px;height:200px;top:-50px;left:-50px;background:rgba(16,185,129,0.3);"></div>
                <div class="cta-blob" style="width:150px;height:150px;bottom:-30px;right:-30px;background:rgba(132,204,22,0.2);animation-delay:-4s;"></div>
                <span class="section-label-welcome relative z-10">Start Today</span>
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-black text-slate-900 mt-4 mb-5 relative z-10">
                    Ready to Transform<br>
                    <span class="gradient-text-shimmer">Your Farming?</span>
                </h2>
                <p class="text-slate-500 mb-10 max-w-lg mx-auto text-lg relative z-10">Join thousands of farmers already using Soilytics for smarter agriculture decisions.</p>
                <a href="{{ route('register') }}" class="btn-primary btn-magnetic text-base py-4 px-12 transition-all duration-500 hover:scale-110 group relative z-10">
                    Start Free Analysis
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ── Footer ────────────────────────────────────────────────────────────── --}}
<footer class="border-t border-slate-200 py-14 px-6">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-500 to-lime-400 flex items-center justify-center shadow-lg shadow-emerald-500/15">
                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 3v1m0 16v1M4.22 4.22l.7.7M18.36 18.36l.7.7M1 12h1m20 0h1M4.22 19.78l.7-.7M18.36 5.64l.7-.7"/>
                    </svg>
                </div>
                <span class="font-bold gradient-text text-lg">Soilytics</span>
                <span class="text-slate-400 text-sm hidden sm:inline">— Smart Soil Analysis Platform</span>
            </div>
            <p class="text-slate-400 text-sm">© {{ date('Y') }} Soilytics. Built with Laravel &amp; Gemini AI.</p>
            <div class="flex items-center gap-6 text-sm text-slate-500">
                <a href="{{ route('login') }}"    class="hover:text-emerald-600 transition-colors duration-300">Login</a>
                <a href="{{ route('register') }}" class="hover:text-emerald-600 transition-colors duration-300">Register</a>
                <a href="{{ route('markets') }}"  class="hover:text-emerald-600 transition-colors duration-300">Markets</a>
            </div>
        </div>
    </div>
</footer>

<script>
// ── Particle System ──
const canvas = document.getElementById('particles-canvas');
const ctx = canvas.getContext('2d');
let particles = [];
const PARTICLE_COUNT = 50;

function resizeCanvas() {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
}

class Particle {
    constructor() { this.reset(); }
    reset() {
        this.x = Math.random() * canvas.width;
        this.y = Math.random() * canvas.height;
        this.size = Math.random() * 2.5 + 0.5;
        this.speedX = (Math.random() - 0.5) * 0.3;
        this.speedY = (Math.random() - 0.5) * 0.3;
        this.opacity = Math.random() * 0.4 + 0.1;
        this.pulse = Math.random() * Math.PI * 2;
    }
    update() {
        this.x += this.speedX;
        this.y += this.speedY;
        this.pulse += 0.015;
        this.opacity = 0.1 + Math.sin(this.pulse) * 0.12;
        if (this.x < 0 || this.x > canvas.width || this.y < 0 || this.y > canvas.height) this.reset();
    }
    draw() {
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
        ctx.fillStyle = `rgba(16, 185, 129, ${this.opacity})`;
        ctx.fill();
    }
}

function initParticles() {
    particles = [];
    for (let i = 0; i < PARTICLE_COUNT; i++) particles.push(new Particle());
}

function connectParticles() {
    for (let a = 0; a < particles.length; a++) {
        for (let b = a + 1; b < particles.length; b++) {
            const dx = particles[a].x - particles[b].x;
            const dy = particles[a].y - particles[b].y;
            const dist = Math.sqrt(dx * dx + dy * dy);
            if (dist < 130) {
                ctx.beginPath();
                ctx.strokeStyle = `rgba(16, 185, 129, ${0.04 * (1 - dist / 130)})`;
                ctx.lineWidth = 0.5;
                ctx.moveTo(particles[a].x, particles[a].y);
                ctx.lineTo(particles[b].x, particles[b].y);
                ctx.stroke();
            }
        }
    }
}

function animateParticles() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    particles.forEach(p => { p.update(); p.draw(); });
    connectParticles();
    requestAnimationFrame(animateParticles);
}

resizeCanvas();
initParticles();
animateParticles();
window.addEventListener('resize', () => { resizeCanvas(); initParticles(); });

// ── Navbar scroll effect ──
const navbar = document.getElementById('navbar');
window.addEventListener('scroll', () => {
    navbar.classList.toggle('scrolled', window.scrollY > 50);
});

// ── Scroll Reveal ──
const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) entry.target.classList.add('visible');
    });
}, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale').forEach(el => {
    revealObserver.observe(el);
});

// ── Counter Animation ──
const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const counter = entry.target;
            const target = parseInt(counter.dataset.target);
            const duration = 2000;
            const start = performance.now();

            function updateCounter(currentTime) {
                const elapsed = currentTime - start;
                const progress = Math.min(elapsed / duration, 1);
                const eased = 1 - Math.pow(1 - progress, 3);
                const current = Math.floor(eased * target);

                if (target >= 1000) {
                    counter.textContent = Math.floor(current / 1000) + 'K';
                } else {
                    counter.textContent = current;
                }

                if (progress < 1) {
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.textContent = target >= 1000 ? Math.floor(target / 1000) + 'K' : target;
                }
            }
            requestAnimationFrame(updateCounter);
            counterObserver.unobserve(counter);
        }
    });
}, { threshold: 0.5 });

document.querySelectorAll('.counter').forEach(el => counterObserver.observe(el));

// ── Mobile Menu ──
const menuToggle = document.getElementById('menu-toggle');
const menuClose = document.getElementById('menu-close');
const mobileMenu = document.getElementById('mobile-menu');
const mobileOverlay = document.getElementById('mobile-overlay');

function openMenu() { mobileMenu.classList.add('open'); mobileOverlay.classList.add('open'); document.body.style.overflow = 'hidden'; }
function closeMenu() { mobileMenu.classList.remove('open'); mobileOverlay.classList.remove('open'); document.body.style.overflow = ''; }

menuToggle.addEventListener('click', openMenu);
menuClose.addEventListener('click', closeMenu);
mobileOverlay.addEventListener('click', closeMenu);
mobileMenu.querySelectorAll('a').forEach(link => link.addEventListener('click', closeMenu));

// ── Smooth Scroll ──
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
});
</script>
</body>
</html>
