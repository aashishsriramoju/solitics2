@extends('layouts.dashboard')
@section('title', 'Market Prices')
@section('page-title', 'Market Prices')
@section('page-subtitle', 'Live crop prices from nearby agricultural markets')

@section('dashboard-content')
<div class="max-w-5xl mx-auto">

    {{-- ── Filter Bar ──────────────────────────────────────────────────────── --}}
    <div class="card-soil p-4 mb-6 animate-fadeInUp" style="opacity:0;">
        <form action="{{ route('markets') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input name="crop" type="text" value="{{ request('crop') }}"
                       placeholder="Search crop name…" class="input-soil">
            </div>
            @if($states->isNotEmpty())
            <select name="state" class="input-soil sm:w-44">
                <option value="">All States</option>
                @foreach($states as $state)
                    <option value="{{ $state }}" {{ request('state') === $state ? 'selected' : '' }}>{{ $state }}</option>
                @endforeach
            </select>
            @endif
            <button type="submit" class="btn-primary py-3 px-6">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                Search
            </button>
        </form>
    </div>

    {{-- ── Price Table ──────────────────────────────────────────────────────── --}}
    @if($prices->isNotEmpty())
        <div class="card-soil overflow-hidden animate-fadeInUp delay-100" style="opacity:0;">
            <div class="p-5 border-b border-slate-100">
                <p class="font-bold text-slate-800">{{ $prices->total() }} Crop Price Records</p>
                <p class="text-xs text-slate-500 mt-0.5">Prices in ₹ per Quintal unless stated</p>
            </div>
            <div class="overflow-x-auto">
                <table class="table-soil w-full">
                    <thead>
                        <tr>
                            <th>Crop</th>
                            <th>Market</th>
                            <th>State</th>
                            <th>Min Price</th>
                            <th>Max Price</th>
                            <th>Modal Price</th>
                            <th>Trend</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prices as $price)
                        <tr class="animate-fadeInUp" style="opacity:0; animation-delay: {{ $loop->index * 0.03 }}s;">
                            <td class="font-bold text-slate-800">{{ $price->crop_name }}</td>
                            <td>{{ $price->market_name }}</td>
                            <td>{{ $price->state }}</td>
                            <td>₹{{ number_format($price->min_price, 0) }}</td>
                            <td>₹{{ number_format($price->max_price, 0) }}</td>
                            <td class="font-extrabold text-slate-900">₹{{ number_format($price->modal_price, 0) }}</td>
                            <td>
                                <span class="{{ $price->getTrendClass() }} font-bold flex items-center gap-1">
                                    {{ $price->getTrendIcon() }}
                                    @if($price->change_pct != 0) {{ abs($price->change_pct) }}% @endif
                                </span>
                            </td>
                            <td>{{ $price->price_date?->format('d M Y') ?? '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-6">{{ $prices->links() }}</div>
    @else
        <div class="card-soil py-24 text-center animate-fadeInUp" style="opacity:0;">
            <p class="text-5xl mb-4">📈</p>
            <p class="text-xl font-bold text-slate-700 mb-2">No market data yet</p>
            <p class="text-slate-500">Market price data will appear here once seeded.</p>
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
