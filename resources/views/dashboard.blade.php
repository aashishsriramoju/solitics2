@extends('layouts.dashboard')

@section('title', __('Dashboard'))

@section('page-title', __('Dashboard'))
@section('page-subtitle', __('Your Live Farm Analytics'))

@section('dashboard-content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- ── 1. Hero Focal CTA Banner ────────────────────────────────────────── --}}
    <div class="card-soil p-8 rounded-3xl relative overflow-hidden animate-fadeInUp shadow-sm" style="opacity:0; background: linear-gradient(135deg, rgba(16,185,129,0.12) 0%, rgba(132,204,22,0.04) 100%); border: 1px solid rgba(16,185,129,0.2);">
        <div class="absolute -top-24 -right-24 w-48 h-48 rounded-full bg-emerald-500/10 blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-48 h-48 rounded-full bg-lime-500/10 blur-3xl"></div>

        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 relative z-10">
            <div class="max-w-xl">
                <span class="badge badge-healthy text-[10px] uppercase tracking-widest px-3 py-1 mb-3 inline-block">✨ {{ __('AI & Data Driven') }}</span>
                <h2 class="text-2xl md:text-3xl font-black text-slate-800 mb-2 leading-tight">
                    {{ __('Analyse Soil & Customise Crops') }}
                </h2>
                <p class="text-slate-600 text-sm leading-relaxed">
                    {{ __('Upload a soil image or enter manual nutrient parameters to instantly determine crop suitability, potential fertilizer needs, and Gemini AI health insights.') }}
                </p>
            </div>
            <a href="{{ route('soil.upload') }}" class="btn-primary py-4 px-8 rounded-2xl text-base font-bold shadow-lg shadow-emerald-500/10 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center gap-2 shrink-0 group">
                <span>⚡ {{ __('Analyse Soil Now') }}</span>
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
            </a>
        </div>
    </div>

    {{-- ── 2. Interactive "How it Works" + Key Metric Summary ────────────── --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        {{-- Total Reports Card --}}
        <div class="card-soil p-6 rounded-3xl animate-fadeInUp delay-75 shadow-sm" style="opacity:0;">
            <div class="flex items-center justify-between mb-2">
                <p class="text-[11px] uppercase tracking-widest text-slate-500 font-bold">{{ __('Total Reports') }}</p>
                <span class="text-xl">📋</span>
            </div>
            <p class="text-4xl font-black text-slate-800">{{ $totalReports }}</p>
            <p class="text-xs text-slate-500 mt-1">{{ __('Previous analyses recorded in your log') }}</p>
        </div>

        {{-- Latest Soil Score Card --}}
        <div class="card-soil p-6 rounded-3xl animate-fadeInUp delay-100 shadow-sm" style="opacity:0;">
            <div class="flex items-center justify-between mb-2">
                <p class="text-[11px] uppercase tracking-widest text-slate-500 font-bold">{{ __('Latest Soil Score') }}</p>
                @if($latestReport)
                    <span class="text-xs font-semibold text-emerald-600" style="color: {{ $latestReport->getScoreColor() }}">● {{ __($latestReport->health_status) }}</span>
                @else
                    <span class="text-xs text-slate-500">● {{ __('No data') }}</span>
                @endif
            </div>
            <p class="text-4xl font-black text-slate-800">
                {{ $latestReport->health_score ?? '--' }}<span class="text-sm text-slate-500 font-normal">/100</span>
            </p>
            <p class="text-xs text-slate-500 mt-1">
                @if($latestReport)
                    {{ __('Calculated pH') }}: {{ $latestReport->ph_level }} ({{ __($latestReport->soil_ph_category) }})
                @else
                    {{ __('Launch your first analysis above') }}
                @endif
            </p>
        </div>

        {{-- Guide Card --}}
        <div class="card-soil p-6 rounded-3xl animate-fadeInUp delay-150 shadow-sm" style="opacity:0;">
            <div class="flex items-center justify-between mb-2">
                <p class="text-[11px] uppercase tracking-widest text-slate-500 font-bold">{{ __('Visual Guide') }}</p>
                <span class="text-xs text-emerald-600 font-bold">❓ {{ __('Help') }}</span>
            </div>
            <div class="text-xs text-slate-600 space-y-1.5 mt-2">
                <div class="flex gap-2">
                    <span class="text-emerald-600 font-bold">1.</span>
                    <span>{{ __('Upload soil sample image (optional).') }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="text-emerald-600 font-bold">2.</span>
                    <span>{{ __('Input pH, NPK, moisture values.') }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="text-emerald-600 font-bold">3.</span>
                    <span>{{ __('Get customized local recommendations.') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ── 3. Chart & Analytical Progress Timeline ────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Health Score Progression (Line Chart) --}}
        <div class="lg:col-span-2 card-soil p-6 rounded-3xl animate-fadeInUp delay-200 shadow-sm" style="opacity:0;">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="font-bold text-slate-800 text-base">{{ __('Soil Health History') }}</h3>
                    <p class="text-xs text-slate-500">{{ __('Track evolution of soil parameters across multiple samples') }}</p>
                </div>
                @if($reports->isNotEmpty())
                    <a href="{{ route('reports') }}" class="text-xs text-emerald-600 hover:text-emerald-700 transition-colors font-semibold">{{ __('View All') }} →</a>
                @endif
            </div>
            @if($reports->isNotEmpty())
                <div class="h-[220px]">
                    <canvas id="scoreChart"></canvas>
                </div>
            @else
                <div class="h-[220px] flex flex-col items-center justify-center text-center">
                    <span class="text-3xl mb-2">📈</span>
                    <p class="text-slate-500 text-sm">{{ __('History charts will update when analyses are recorded.') }}</p>
                </div>
            @endif
        </div>

        {{-- Latest Nutrient Levels Breakdown --}}
        <div class="card-soil p-6 rounded-3xl animate-fadeInUp delay-300 shadow-sm" style="opacity:0;">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="font-bold text-slate-800 text-base">{{ __('Latest Nutrient Breakdown') }}</h3>
                    <p class="text-xs text-slate-500">{{ __('Key soil parameters') }}</p>
                </div>
                @if($latestReport)
                    <a href="{{ route('soil.analysis', $latestReport->id) }}" class="text-xs text-emerald-600 hover:text-emerald-700 transition-colors font-semibold">{{ __('View details') }} →</a>
                @endif
            </div>
            @if($latestReport)
                <div class="space-y-4">
                    @php
                    $latestNutrients = [
                        ['label' => 'Nitrogen (N)',     'val' => $latestReport->nitrogen     ?? 0, 'color' => 'from-emerald-500 to-lime-400'],
                        ['label' => 'Phosphorus (P)',   'val' => $latestReport->phosphorus   ?? 0, 'color' => 'from-blue-500 to-cyan-400'],
                        ['label' => 'Potassium (K)',    'val' => $latestReport->potassium    ?? 0, 'color' => 'from-violet-500 to-purple-400'],
                        ['label' => 'Moisture',         'val' => $latestReport->moisture     ?? 0, 'color' => 'from-sky-500 to-blue-400'],
                        ['label' => 'Organic Matter',   'val' => min(100, ($latestReport->organic_matter ?? 0) * 10), 'color' => 'from-amber-500 to-orange-400'],
                    ];
                    @endphp
                    @foreach($latestNutrients as $n)
                    <div>
                        <div class="flex justify-between mb-1.5">
                            <span class="text-xs text-slate-500 font-medium">{{ __($n['label']) }}</span>
                            <span class="text-xs font-bold text-slate-700">{{ round($n['val']) }}%</span>
                        </div>
                        <div class="nutrient-bar-track">
                            <div class="nutrient-bar-fill" style="width: 0%; background: linear-gradient(90deg, var(--tw-gradient-stops)); transition: width 1.2s {{ $loop->index * 0.1 }}s cubic-bezier(0.4,0,0.2,1);"
                                 data-target="{{ $n['val'] }}"
                                 class="bg-gradient-to-r {{ $n['color'] }}"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="h-[220px] flex flex-col items-center justify-center text-center">
                    <span class="text-3xl mb-2">🌿</span>
                    <p class="text-slate-500 text-sm">{{ __('No parameters loaded.') }}</p>
                </div>
            @endif
        </div>
    </div>

    {{-- ── 4. Detailed History Log & Data Timeline ───────────────────────── --}}
    <div class="card-soil overflow-hidden rounded-3xl animate-fadeInUp delay-200 shadow-sm" style="opacity:0;">
        <div class="flex items-center justify-between p-6 border-b border-slate-100">
            <div>
                <h3 class="font-bold text-slate-800 text-base">{{ __('Previous Analyses') }}</h3>
                <p class="text-xs text-slate-500">{{ __('Detailed history of your fields and soil quality trends') }}</p>
            </div>
            <a href="{{ route('soil.upload') }}" class="btn-secondary py-2.5 px-4 text-xs font-bold">{{ __('+ New Analysis') }}</a>
        </div>
        @if($reports->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="table-soil w-full">
                    <thead>
                        <tr>
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('Soil Type') }}</th>
                            <th>{{ __('pH') }}</th>
                            <th>{{ __('Health Score') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Date') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $report)
                        <tr>
                            <td class="text-slate-800 font-bold">{{ $report->title }}</td>
                            <td class="text-slate-600 font-semibold">{{ $report->soil_type ?? '—' }}</td>
                            <td class="text-slate-600 font-semibold">{{ $report->ph_level ?? '—' }}</td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <div class="w-16 nutrient-bar-track">
                                        <div class="nutrient-bar-fill" style="width: {{ $report->health_score ?? 0 }}%; background: {{ $report->getScoreColor() }};"></div>
                                    </div>
                                    <span class="text-sm font-bold" style="color: {{ $report->getScoreColor() }}">{{ $report->health_score ?? '—' }}</span>
                                </div>
                            </td>
                            <td><span class="badge {{ $report->getHealthBadgeClass() }} text-[10px]">{{ __($report->health_status) }}</span></td>
                            <td class="text-slate-500 text-xs font-semibold">{{ $report->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('soil.analysis', $report->id) }}" class="text-emerald-600 hover:text-emerald-700 text-xs font-bold transition-colors">
                                    {{ __('View Report') }} →
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="py-20 text-center">
                <p class="text-5xl mb-4">🌱</p>
                <p class="text-slate-600 font-bold mb-2">{{ __('No analyses recorded yet') }}</p>
                <p class="text-slate-500 text-sm mb-6">{{ __('Upload your first soil image or enter parameters to see records here.') }}</p>
                <a href="{{ route('soil.upload') }}" class="btn-primary py-3 px-6 rounded-xl font-bold">{{ __('Analyse Your Soil') }}</a>
            </div>
        @endif
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// ── Line chart progression ────────────────────────────────────────────────────
const ctx = document.getElementById('scoreChart');
if (ctx) {
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels->values()->toArray()) !!},
            datasets: [{
                label: 'Health Score',
                data:  {!! json_encode($chartScores->values()->toArray()) !!},
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.05)',
                borderWidth: 3,
                fill: true,
                tension: 0.45,
                pointBackgroundColor: '#10b981',
                pointBorderColor: '#ffffff',
                pointRadius: 5,
                pointHoverRadius: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#ffffff',
                    borderColor: 'rgba(16, 185, 129, 0.2)',
                    borderWidth: 1,
                    titleColor: '#64748b',
                    bodyColor: '#059669',
                    bodyFont: { weight: 'bold' },
                    shadowColor: 'rgba(0,0,0,0.1)',
                }
            },
            scales: {
                x: { grid: { color: 'rgba(15, 23, 42, 0.05)' }, ticks: { color: '#64748b', font: { size: 10 } } },
                y: {
                    min: 0, max: 100,
                    grid: { color: 'rgba(15, 23, 42, 0.05)' },
                    ticks: { color: '#64748b', font: { size: 10 } }
                }
            }
        }
    });
}

// ── Animate bars & fade-in ────────────────────────────────────────────────────
window.addEventListener('load', () => {
    document.querySelectorAll('[data-target]').forEach(bar => {
        setTimeout(() => { bar.style.width = bar.dataset.target + '%'; }, 100);
    });

    document.querySelectorAll('.animate-fadeInUp').forEach(el => {
        el.style.opacity = '1';
    });
});
</script>
@endpush

@endsection
