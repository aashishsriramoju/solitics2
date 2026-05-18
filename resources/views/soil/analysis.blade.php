@extends('layouts.dashboard')
@section('title', 'Analysis — ' . $report->title)
@section('page-title', 'Soil Analysis')
@section('page-subtitle', $report->title . ' • ' . $report->created_at->format('d M Y'))

@section('dashboard-content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- ── Action Bar ──────────────────────────────────────────────────────── --}}
    <div class="flex items-center justify-between">
        <a href="{{ route('reports') }}" class="btn-secondary py-2 px-4 text-sm">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            Back to Reports
        </a>
        <div class="flex gap-3">
            <a href="{{ route('reports.pdf', $report->id) }}" target="_blank" class="btn-secondary py-2 px-4 text-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                Download Report
            </a>
            <form action="{{ route('soil.destroy', $report->id) }}" method="POST"
                  onsubmit="return confirm('Delete this report? This cannot be undone.')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger py-2 px-4">Delete</button>
            </form>
        </div>
    </div>

    {{-- ── Hero Score Card ──────────────────────────────────────────────────── --}}
    <div class="card-soil p-8 animate-fadeInUp" style="opacity:0; background: linear-gradient(135deg, rgba(16,185,129,0.08) 0%, rgba(132,204,22,0.04) 100%);">
        <div class="flex flex-col md:flex-row items-center gap-8">
            {{-- Score ring --}}
            <div class="relative flex-shrink-0">
                <svg class="w-40 h-40" viewBox="0 0 160 160">
                    <circle cx="80" cy="80" r="65" fill="none" stroke="rgba(255,255,255,0.06)" stroke-width="10"/>
                    <circle cx="80" cy="80" r="65" fill="none"
                        stroke="{{ $report->getScoreColor() }}"
                        stroke-width="10"
                        stroke-linecap="round"
                        stroke-dasharray="{{ 2 * pi() * 65 }}"
                        stroke-dashoffset="{{ 2 * pi() * 65 * (1 - $report->health_score / 100) }}"
                        transform="rotate(-90 80 80)"
                        class="progress-ring-circle"
                        style="filter: drop-shadow(0 0 8px {{ $report->getScoreColor() }})"/>
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-4xl font-black" style="color: {{ $report->getScoreColor() }}">{{ $report->health_score }}</span>
                    <span class="text-slate-500 text-sm">/ 100</span>
                </div>
            </div>

            <div class="flex-1 text-center md:text-left">
                <div class="flex items-center gap-3 mb-3 justify-center md:justify-start">
                    <span class="badge {{ $report->getHealthBadgeClass() }} text-sm px-4 py-1.5">● {{ $report->health_status }}</span>
                    <span class="badge bg-slate-100 border border-slate-200 text-slate-600">{{ $report->soil_type }}</span>
                </div>
                <h2 class="text-2xl font-bold text-slate-800 mb-2">{{ $report->title }}</h2>
                <p class="text-slate-600 leading-relaxed">{{ $report->soil_condition }}</p>
                <div class="flex flex-wrap gap-3 mt-4">
                    <div class="glass rounded-xl px-4 py-2 text-center">
                        <p class="text-[10px] text-slate-500 uppercase tracking-wider">pH</p>
                        <p class="text-lg font-bold text-slate-800">{{ $report->ph_level }}</p>
                        <p class="text-[10px] text-emerald-400">{{ $report->soil_ph_category }}</p>
                    </div>
                    <div class="glass rounded-xl px-4 py-2 text-center">
                        <p class="text-[10px] text-slate-500 uppercase tracking-wider">Nitrogen</p>
                        <p class="text-lg font-bold text-slate-800">{{ $report->nitrogen }}%</p>
                    </div>
                    <div class="glass rounded-xl px-4 py-2 text-center">
                        <p class="text-[10px] text-slate-500 uppercase tracking-wider">Phosphorus</p>
                        <p class="text-lg font-bold text-slate-800">{{ $report->phosphorus }}%</p>
                    </div>
                    <div class="glass rounded-xl px-4 py-2 text-center">
                        <p class="text-[10px] text-slate-500 uppercase tracking-wider">Potassium</p>
                        <p class="text-lg font-bold text-slate-800">{{ $report->potassium }}%</p>
                    </div>
                    <div class="glass rounded-xl px-4 py-2 text-center">
                        <p class="text-[10px] text-slate-500 uppercase tracking-wider">Moisture</p>
                        <p class="text-lg font-bold text-blue-600">{{ $report->moisture }}%</p>
                    </div>
                </div>
            </div>

            {{-- Soil image --}}
            @if($report->getImageUrl())
            <div class="flex-shrink-0">
                <img src="{{ $report->getImageUrl() }}" alt="Soil image"
                     class="w-36 h-36 rounded-2xl object-cover border border-[rgba(52,211,153,0.2)] shadow-lg">
            </div>
            @endif
        </div>
    </div>

    {{-- ── AI Analysis ─────────────────────────────────────────────────────── --}}
    @if($report->ai_analysis)
    <div class="card-soil p-6 animate-fadeInUp delay-100" style="opacity:0;">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-8 h-8 rounded-xl bg-purple-50 flex items-center justify-center border border-purple-200">
                <svg class="w-4 h-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.948V19a2 2 0 01-2 2h-1" /></svg>
            </div>
            <div>
                <p class="font-bold text-slate-800">Gemini AI Visual Analysis</p>
                <p class="text-xs text-slate-500">Powered by Google Gemini Vision</p>
            </div>
            @if($report->ai_soil_type)
                <span class="ml-auto badge" style="background:rgba(139,92,246,0.1);border:1px solid rgba(139,92,246,0.2);color:#7c3aed;">{{ $report->ai_soil_type }}</span>
            @endif
        </div>
        <div class="bg-purple-50/50 border border-purple-100 rounded-xl p-5">
            <p class="text-slate-700 text-sm leading-relaxed">{{ $report->ai_analysis }}</p>
        </div>
        @if($report->ai_recommendations)
        <div class="mt-4 p-4 bg-emerald-50/50 border border-emerald-100 rounded-xl">
            <p class="text-xs font-bold text-emerald-700 uppercase tracking-wider mb-2">AI Recommendations</p>
            <p class="text-slate-700 text-sm leading-relaxed">{{ $report->ai_recommendations }}</p>
        </div>
        @endif
    </div>
    @endif

    {{-- ── Nutrient Chart ───────────────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div class="card-soil p-6 animate-fadeInUp delay-200 shadow-sm" style="opacity:0;">
            <p class="font-bold text-slate-800 mb-4 uppercase tracking-wider text-xs">{{ __('Nutrient Levels') }}</p>
            <div class="space-y-4">
                @php
                $nutrients = [
                    ['label' => 'Nitrogen (N)',     'val' => $report->nitrogen     ?? 0, 'color' => 'from-emerald-500 to-lime-400'],
                    ['label' => 'Phosphorus (P)',   'val' => $report->phosphorus   ?? 0, 'color' => 'from-blue-500 to-cyan-400'],
                    ['label' => 'Potassium (K)',    'val' => $report->potassium    ?? 0, 'color' => 'from-violet-500 to-purple-400'],
                    ['label' => 'Moisture',         'val' => $report->moisture     ?? 0, 'color' => 'from-sky-500 to-blue-400'],
                    ['label' => 'Organic Matter',   'val' => min(100, ($report->organic_matter ?? 0) * 10), 'color' => 'from-amber-500 to-orange-400'],
                ];
                @endphp
                @foreach($nutrients as $i => $n)
                <div>
                    <div class="flex justify-between mb-1.5">
                        <span class="text-xs text-slate-500 font-medium">{{ __($n['label']) }}</span>
                        <span class="text-xs font-bold text-slate-700">{{ round($n['val']) }}%</span>
                    </div>
                    <div class="nutrient-bar-track">
                        <div class="nutrient-bar-fill" style="width: 0%; background: linear-gradient(90deg, var(--tw-gradient-stops)); transition: width 1.2s {{ $i * 0.12 }}s cubic-bezier(0.4,0,0.2,1);"
                             data-target="{{ $n['val'] }}"
                             class="bg-gradient-to-r {{ $n['color'] }}"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Deficiencies --}}
        <div class="card-soil p-6 animate-fadeInUp delay-300 shadow-sm" style="opacity:0;">
            <p class="font-bold text-slate-800 mb-4 uppercase tracking-wider text-xs">{{ __('Deficiency Report') }}</p>
            @if(!empty($report->deficiencies))
                <div class="space-y-3">
                    @foreach($report->deficiencies as $def)
                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-2.5 h-2.5 rounded-full {{ $def['severity'] === 'high' ? 'bg-red-500 shadow-sm' : 'bg-amber-500 shadow-sm' }}"></div>
                            <p class="text-xs font-bold text-slate-700">{{ $def['nutrient'] }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-slate-400 font-semibold">{{ $def['level'] }}</span>
                            <span class="badge {{ $def['severity'] === 'high' ? 'badge-poor' : 'badge-moderate' }} text-[9px]">{{ ucfirst($def['severity']) }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center h-32">
                    <span class="text-3xl mb-2">✅</span>
                    <p class="text-emerald-400 font-semibold">No major deficiencies detected!</p>
                    <p class="text-slate-500 text-sm">Your soil nutrient levels are well-balanced.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- ── Crop Recommendations ────────────────────────────────────────────── --}}
    @if(!empty($report->crop_recommendations))
    <div class="card-soil p-6 animate-fadeInUp delay-200 shadow-sm" style="opacity:0;">
        <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2 uppercase tracking-wider text-xs">
            <span>🌾</span> {{ __('Recommended Crops') }}
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($report->crop_recommendations as $crop)
            <div class="p-4 rounded-2xl bg-emerald-50/50 border border-emerald-100">
                <div class="flex items-center justify-between mb-2">
                    <p class="font-bold text-slate-800 text-sm">{{ $crop['name'] }}</p>
                    <span class="badge {{ $crop['suitability'] === 'Excellent' ? 'badge-healthy' : 'badge-moderate' }} text-[9px]">{{ $crop['suitability'] }}</span>
                </div>
                <p class="text-xs text-slate-500 font-semibold mb-1">📅 {{ $crop['season'] }}</p>
                <p class="text-xs text-slate-400 font-medium">💧 Water: {{ $crop['water'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ── Fertilizer Recommendations ──────────────────────────────────────── --}}
    @if(!empty($report->fertilizer_recommendations))
    <div class="card-soil p-6 overflow-hidden animate-fadeInUp delay-300 shadow-sm" style="opacity:0;">
        <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2 uppercase tracking-wider text-xs">
            <span>🧪</span> {{ __('Fertilizer Recommendations') }}
        </h3>
        <div class="overflow-x-auto -mx-6 -mb-6">
            <table class="table-soil w-full">
                <thead>
                    <tr>
                        <th>{{ __('Fertilizer') }}</th>
                        <th>{{ __('Dose') }}</th>
                        <th>{{ __('Timing') }}</th>
                        <th>{{ __('Type') }}</th>
                        <th>{{ __('Priority') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($report->fertilizer_recommendations as $fert)
                    <tr>
                        <td class="text-slate-800 font-bold">{{ $fert['name'] }}</td>
                        <td class="text-slate-600 font-semibold">{{ $fert['dose'] }}</td>
                        <td class="text-slate-500 text-xs font-semibold">{{ $fert['timing'] }}</td>
                        <td>
                            <span class="badge text-[9px]
                                @if($fert['type'] === 'Organic') badge-healthy
                                @elseif($fert['type'] === 'Chemical') badge-moderate
                                @else bg-purple-50 border border-purple-100 text-purple-600 @endif">
                                {{ $fert['type'] }}
                            </span>
                        </td>
                        <td>
                            <span class="badge text-[9px] {{ $fert['priority'] === 'High' ? 'badge-poor' : ($fert['priority'] === 'Medium' ? 'badge-moderate' : 'badge-healthy') }}">
                                {{ $fert['priority'] }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

</div>

@push('scripts')
<script>
window.addEventListener('load', () => {
    // Animate bars
    document.querySelectorAll('[data-target]').forEach(bar => {
        setTimeout(() => { bar.style.width = bar.dataset.target + '%'; }, 200);
    });
    // Fade-in
    document.querySelectorAll('.animate-fadeInUp').forEach(el => { el.style.opacity = '1'; });
});
</script>
@endpush
@endsection
