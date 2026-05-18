@extends('layouts.dashboard')
@section('title', 'Reports History')
@section('page-title', 'Report History')
@section('page-subtitle', 'All your previous soil analyses')

@section('dashboard-content')
<div class="max-w-5xl mx-auto">

    {{-- ── Filter Bar ──────────────────────────────────────────────────────── --}}
    <div class="card-soil p-4 mb-6 animate-fadeInUp" style="opacity:0;">
        <form action="{{ route('reports') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input name="search" type="text" value="{{ request('search') }}"
                       placeholder="Search by report title…"
                       class="input-soil">
            </div>
            <select name="status" class="input-soil sm:w-40">
                <option value="">All Status</option>
                <option value="Healthy"  {{ request('status') === 'Healthy'  ? 'selected' : '' }}>Healthy</option>
                <option value="Moderate" {{ request('status') === 'Moderate' ? 'selected' : '' }}>Moderate</option>
                <option value="Poor"     {{ request('status') === 'Poor'     ? 'selected' : '' }}>Poor</option>
            </select>
            <button type="submit" class="btn-primary py-3 px-6">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                Filter
            </button>
            @if(request()->hasAny(['search','status']))
                <a href="{{ route('reports') }}" class="btn-secondary py-3 px-4">Clear</a>
            @endif
        </form>
    </div>

    {{-- ── Reports List ─────────────────────────────────────────────────────── --}}
    @if($reports->isNotEmpty())
        <div class="space-y-4">
            @foreach($reports as $report)
            <div class="card-soil p-5 animate-fadeInUp" style="opacity:0; animation-delay: {{ $loop->index * 0.06 }}s;">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-4 flex-1 min-w-0">
                        {{-- Image or icon --}}
                        @if($report->getImageUrl())
                            <img src="{{ $report->getImageUrl() }}" alt="Soil"
                                 class="w-14 h-14 rounded-xl object-cover flex-shrink-0 border border-[rgba(52,211,153,0.15)]">
                        @else
                            <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-emerald-500/20 to-lime-500/10 flex items-center justify-center text-2xl flex-shrink-0">🪨</div>
                        @endif

                        <div class="min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <h3 class="font-bold text-slate-800 truncate">{{ $report->title }}</h3>
                                <span class="badge {{ $report->getHealthBadgeClass() }} text-[10px] flex-shrink-0">{{ $report->health_status }}</span>
                            </div>
                            <div class="flex flex-wrap gap-3 text-xs text-slate-500">
                                <span>🪨 {{ $report->soil_type ?? 'Unknown' }}</span>
                                <span>⚗️ pH: {{ $report->ph_level }}</span>
                                <span>📅 {{ $report->created_at->format('d M Y, h:i A') }}</span>
                                @if($report->location) <span>📍 {{ $report->location }}</span> @endif
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 flex-shrink-0">
                        {{-- Score badge --}}
                        <div class="text-center">
                            <p class="text-2xl font-black" style="color: {{ $report->getScoreColor() }}">{{ $report->health_score }}</p>
                            <p class="text-[10px] text-slate-500">Score</p>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('soil.analysis', $report->id) }}" class="btn-secondary py-2 px-4 text-sm">View</a>
                            <a href="{{ route('reports.pdf', $report->id) }}" target="_blank" class="btn-secondary py-2 px-3 text-sm" title="Download PDF">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            </a>
                            <form action="{{ route('soil.destroy', $report->id) }}" method="POST"
                                  onsubmit="return confirm('Delete this report?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger py-2 px-3" title="Delete">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-6">{{ $reports->links() }}</div>

    @else
        <div class="card-soil py-24 text-center animate-fadeInUp" style="opacity:0;">
            <p class="text-5xl mb-4">📋</p>
            <p class="text-xl font-bold text-slate-700 mb-2">No reports yet</p>
            <p class="text-slate-500 mb-6">Analyse your first soil sample to see your reports here.</p>
            <a href="{{ route('soil.upload') }}" class="btn-primary">Start Analysis</a>
        </div>
    @endif
</div>

@push('scripts')
<script>
window.addEventListener('load', () => {
    document.querySelectorAll('.animate-fadeInUp').forEach(el => { el.style.opacity = '1'; });
});
</script>
@endpush
@endsection
