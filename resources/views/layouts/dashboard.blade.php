@extends('layouts.app')

@section('content')
{{-- Premium Top Navigation Bar --}}
<header class="w-full sticky top-0 z-50 bg-white/85 backdrop-blur-md border-b border-slate-200/80 shadow-sm shadow-slate-100/50">
    <div class="max-w-6xl mx-auto px-6 h-20 flex items-center justify-between">
        
        {{-- Logo --}}
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-500 to-lime-400 flex items-center justify-center shadow-md">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 3v1m0 16v1M4.22 4.22l.7.7M18.36 18.36l.7.7M1 12h1m20 0h1M4.22 19.78l.7-.7M18.36 5.64l.7-.7" />
                </svg>
            </div>
            <div>
                <span class="font-black text-slate-800 text-lg tracking-tight">Soilytics</span>
                <p class="text-[9px] text-slate-400 font-bold uppercase tracking-wider -mt-1">{{ __('Smart Soil Analysis') }}</p>
            </div>
        </a>

        {{-- Center Navigation Menu (Horizontal Sidebar replacement!) --}}
        <nav class="hidden md:flex items-center gap-1">
            <a href="{{ route('dashboard') }}"
               class="nav-tab {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                {{ __('Dashboard') }}
            </a>

            <a href="{{ route('soil.upload') }}"
               class="nav-tab {{ request()->routeIs('soil.upload') ? 'active' : '' }}">
                {{ __('Upload Soil') }}
            </a>

            <a href="{{ route('reports') }}"
               class="nav-tab {{ request()->routeIs('reports*') ? 'active' : '' }}">
                {{ __('Reports') }}
            </a>

            <a href="{{ route('markets') }}"
               class="nav-tab {{ request()->routeIs('markets') ? 'active' : '' }}">
                {{ __('Market Prices') }}
            </a>

            <a href="{{ route('profile') }}"
               class="nav-tab {{ request()->routeIs('profile') ? 'active' : '' }}">
                {{ __('Profile') }}
            </a>
        </nav>

        {{-- Right Controls --}}
        <div class="flex items-center gap-4">
            {{-- Language Switcher --}}
            <form action="{{ route('language.set') }}" method="POST" class="flex items-center">
                @csrf
                <select name="lang" onchange="this.form.submit()"
                    class="bg-slate-100/80 border border-slate-200 text-slate-600 text-xs font-semibold rounded-xl py-1.5 px-2.5 focus:outline-none focus:border-emerald-500 cursor-pointer">
                    <option value="en" {{ session('locale','en') === 'en' ? 'selected' : '' }}>🇬🇧 EN</option>
                    <option value="hi" {{ session('locale','en') === 'hi' ? 'selected' : '' }}>🇮🇳 HI</option>
                    <option value="te" {{ session('locale','en') === 'te' ? 'selected' : '' }}>🇮🇳 TE</option>
                </select>
            </form>

            {{-- User avatar dropdown / info --}}
            <div class="flex items-center gap-3 pl-2 border-l border-slate-200">
                <div class="hidden lg:block text-right">
                    <p class="text-xs font-bold text-slate-800">{{ auth()->user()->name }}</p>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-[10px] font-bold text-slate-400 hover:text-red-500 transition-colors">
                            {{ __('Sign Out') }}
                        </button>
                    </form>
                </div>
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-500 to-lime-400 flex items-center justify-center text-white font-black text-sm shadow-sm">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
        </div>

    </div>
</header>

{{-- Main Page Wrapper --}}
<div class="max-w-6xl mx-auto px-6 py-8 min-h-[calc(100vh-80px)]">
    
    {{-- Page Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-black text-slate-800 tracking-tight">@yield('page-title', __('Dashboard'))</h1>
        <p class="text-xs text-slate-400 font-medium">@yield('page-subtitle', __('Welcome to Soilytics'))</p>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="alert-success mb-6 animate-fadeInUp">
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
            {{ session('success') }}
        </div>
    </div>
    @endif

    @if($errors->any())
    <div class="alert-error mb-6 animate-fadeInUp">
        <ul class="list-none">
            @foreach($errors->all() as $error)
            <li class="flex items-center gap-2 text-xs"><svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Page Content --}}
    <main>
        @yield('dashboard-content')
    </main>
</div>
@endsection
