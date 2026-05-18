@extends('layouts.dashboard')
@section('title', 'Profile Settings')
@section('page-title', 'Profile & Settings')
@section('page-subtitle', 'Manage your account and preferences')

@section('dashboard-content')
<div class="max-w-3xl mx-auto space-y-6">

    {{-- ── Profile Card ─────────────────────────────────────────────────────── --}}
    <div class="card-soil p-6 animate-fadeInUp" style="opacity:0;">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-500 to-lime-400 flex items-center justify-center text-white text-2xl font-black shadow-lg shadow-emerald-500/20">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
             <div>
                <h2 class="text-xl font-bold text-slate-800">{{ $user->name }}</h2>
                <p class="text-slate-500 text-sm font-semibold">{{ $user->email }}</p>
                <p class="text-[11px] text-emerald-600 font-bold mt-0.5">Member since {{ $user->created_at->format('F Y') }}</p>
            </div>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" class="space-y-5">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="name" class="label-soil">Full Name</label>
                    <input id="name" name="name" type="text" required
                           value="{{ old('name', $user->name) }}" class="input-soil">
                    @error('name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="email" class="label-soil">Email Address</label>
                    <input id="email" name="email" type="email" required
                           value="{{ old('email', $user->email) }}" class="input-soil">
                    @error('email')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="preferred_language" class="label-soil">Preferred Language</label>
                    <select id="preferred_language" name="preferred_language" class="input-soil">
                        <option value="en" {{ ($user->preferred_language ?? 'en') === 'en' ? 'selected' : '' }}>🇬🇧 English</option>
                        <option value="hi" {{ ($user->preferred_language ?? 'en') === 'hi' ? 'selected' : '' }}>🇮🇳 Hindi</option>
                        <option value="te" {{ ($user->preferred_language ?? 'en') === 'te' ? 'selected' : '' }}>🇮🇳 Telugu</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="btn-primary">Save Changes</button>
            </div>
        </form>
    </div>

    {{-- ── Change Password ──────────────────────────────────────────────────── --}}
    <div class="card-soil p-6 animate-fadeInUp delay-100" style="opacity:0;">
        <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2 uppercase tracking-wider text-xs">
            <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
            Change Password
        </h3>
        <form action="{{ route('profile.password') }}" method="POST" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label for="current_password" class="label-soil">Current Password</label>
                <input id="current_password" name="current_password" type="password" placeholder="••••••••" class="input-soil">
                @error('current_password')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="new_password" class="label-soil">New Password</label>
                    <input id="new_password" name="password" type="password" placeholder="Min. 8 characters" class="input-soil">
                    @error('password')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="password_confirmation" class="label-soil">Confirm New Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Repeat password" class="input-soil">
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="btn-primary">Update Password</button>
            </div>
        </form>
    </div>

    {{-- ── Stats ────────────────────────────────────────────────────────────── --}}
    <div class="card-soil p-6 animate-fadeInUp delay-200" style="opacity:0;">
        <h3 class="font-bold text-slate-800 mb-4 uppercase tracking-wider text-xs">Your Statistics</h3>
        <div class="grid grid-cols-3 gap-4 text-center">
            <div>
                <p class="text-3xl font-black gradient-text">{{ $user->soilReports()->count() }}</p>
                <p class="text-xs text-slate-500 mt-1">Total Analyses</p>
            </div>
            <div>
                <p class="text-3xl font-black gradient-text">
                    {{ $user->soilReports()->where('health_status','Healthy')->count() }}
                </p>
                <p class="text-xs text-slate-500 mt-1">Healthy Soils</p>
            </div>
            <div>
                <p class="text-3xl font-black gradient-text">
                    {{ round($user->soilReports()->whereNotNull('health_score')->avg('health_score') ?? 0) }}
                </p>
                <p class="text-xs text-slate-500 mt-1">Avg Score</p>
            </div>
        </div>
    </div>

    {{-- ── Danger Zone ──────────────────────────────────────────────────────── --}}
    <div class="rounded-2xl p-6 animate-fadeInUp delay-300" style="opacity:0; background: rgba(239,68,68,0.05); border: 1px solid rgba(239,68,68,0.15);">
        <h3 class="font-bold text-red-600 mb-2 uppercase tracking-wider text-xs">Danger Zone</h3>
        <p class="text-sm text-slate-600 font-semibold mb-4">Logging out will clear your session. Your data is saved.</p>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-danger">Sign Out of Account</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
window.addEventListener('load', () => {
    document.querySelectorAll('.animate-fadeInUp').forEach(el => { el.style.opacity = '1'; });
});
</script>
@endpush
@endsection
