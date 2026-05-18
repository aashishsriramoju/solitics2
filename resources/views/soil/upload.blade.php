@extends('layouts.dashboard')
@section('title', __('Upload Soil'))
@section('page-title', __('Upload Soil'))
@section('page-subtitle', __('Upload an image and enter nutrient values for AI analysis'))

@section('dashboard-content')
<div class="max-w-4xl mx-auto">

    <form action="{{ route('soil.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
        @csrf

        {{-- ── Image Upload Zone ──────────────────────────────────────────── --}}
        <div class="card-soil p-6 mb-6 rounded-3xl animate-fadeInUp" style="opacity:0;">
            <h2 class="font-bold text-slate-200 mb-1 flex items-center gap-2 text-base">
                <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                {{ __('Soil Image (Optional)') }}
            </h2>
            <p class="text-xs text-slate-500 mb-4">{{ __('Upload a clear photo of your soil for AI-powered visual analysis via Gemini Vision.') }}</p>

            <div class="upload-zone rounded-2xl" id="dropZone" onclick="document.getElementById('soilImage').click()">
                <div id="uploadPlaceholder">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>
                    </div>
                    <p class="text-slate-300 font-semibold mb-1 text-sm">{{ __('Drag & drop your soil image here') }}</p>
                    <p class="text-slate-500 text-xs">{{ __('or click to browse — JPG, PNG up to 8 MB') }}</p>
                </div>
                <div id="imagePreviewWrapper" class="hidden">
                    <img id="imagePreview" class="max-h-48 mx-auto rounded-xl shadow-lg object-cover" alt="Preview" />
                    <p class="text-emerald-400 text-xs mt-3 font-semibold">{{ __('Image ready for upload') }}</p>
                </div>
            </div>
            <input type="file" name="soil_image" id="soilImage" accept="image/*" class="hidden">
        </div>

        {{-- ── Report Title ────────────────────────────────────────────────── --}}
        <div class="card-soil p-6 mb-6 rounded-3xl animate-fadeInUp delay-100" style="opacity:0;">
            <label for="title" class="label-soil">{{ __('Report Title (optional)') }}</label>
            {{-- ── Nutrient Values ─────────────────────────────────────────────── --}}
        <div class="card-soil p-6 mb-6 rounded-3xl animate-fadeInUp delay-200" style="opacity:0;">
            <h2 class="font-bold text-slate-200 mb-1 flex items-center gap-2 text-base">
                <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18" /></svg>
                {{ __('Soil Nutrient Override (Optional)') }}
            </h2>
            <p class="text-xs text-slate-500 mb-6">{{ __('If you uploaded a soil photo above, the AI will automatically estimate all chemical and nutrient properties directly from the photo! You can optionally use these sliders as a manual override if no photo is available.') }}</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- pH --}}
                <div class="p-4 rounded-2xl bg-white/5 border border-white/[0.04]">
                    <div class="flex justify-between items-center mb-2">
                        <label for="ph_level" class="text-xs font-bold text-slate-300">{{ __('Soil pH Level') }}</label>
                        <input id="ph_level" name="ph_level" type="number" step="0.1" min="0" max="14"
                               value="{{ old('ph_level') }}" class="input-soil w-20 text-center py-1 text-xs" placeholder="e.g. 6.5">
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="range" min="0" max="14" step="0.1" value="{{ old('ph_level', 6.5) }}"
                               oninput="document.getElementById('ph_level').value = this.value"
                               class="w-full h-1.5 bg-slate-800 rounded-lg appearance-none cursor-pointer accent-emerald-400">
                    </div>
                    <div class="flex justify-between text-[9px] text-slate-600 mt-2">
                        <span>0 ({{ __('Acidic') }})</span>
                        <span>7 ({{ __('Neutral') }})</span>
                        <span>14 ({{ __('Alkaline') }})</span>
                    </div>
                    @error('ph_level')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Nitrogen --}}
                <div class="p-4 rounded-2xl bg-white/5 border border-white/[0.04]">
                    <div class="flex justify-between items-center mb-2">
                        <label for="nitrogen" class="text-xs font-bold text-slate-300">{{ __('Nitrogen') }} (N)</label>
                        <div class="flex items-center gap-1">
                            <input id="nitrogen" name="nitrogen" type="number" step="1" min="0" max="100"
                                   value="{{ old('nitrogen') }}" class="input-soil w-16 text-center py-1 text-xs" placeholder="50">
                            <span class="text-xs text-slate-500">%</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="range" min="0" max="100" step="1" value="{{ old('nitrogen', 50) }}"
                               oninput="document.getElementById('nitrogen').value = this.value"
                               class="w-full h-1.5 bg-slate-800 rounded-lg appearance-none cursor-pointer accent-emerald-400">
                    </div>
                    <div class="flex justify-between text-[9px] text-slate-600 mt-2">
                        <span>0% ({{ __('Deficient') }})</span>
                        <span>100% ({{ __('Saturated') }})</span>
                    </div>
                    @error('nitrogen')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Phosphorus --}}
                <div class="p-4 rounded-2xl bg-white/5 border border-white/[0.04]">
                    <div class="flex justify-between items-center mb-2">
                        <label for="phosphorus" class="text-xs font-bold text-slate-300">{{ __('Phosphorus') }} (P)</label>
                        <div class="flex items-center gap-1">
                            <input id="phosphorus" name="phosphorus" type="number" step="1" min="0" max="100"
                                   value="{{ old('phosphorus') }}" class="input-soil w-16 text-center py-1 text-xs" placeholder="50">
                            <span class="text-xs text-slate-500">%</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="range" min="0" max="100" step="1" value="{{ old('phosphorus', 50) }}"
                               oninput="document.getElementById('phosphorus').value = this.value"
                               class="w-full h-1.5 bg-slate-800 rounded-lg appearance-none cursor-pointer accent-emerald-400">
                    </div>
                    <div class="flex justify-between text-[9px] text-slate-600 mt-2">
                        <span>0% ({{ __('Deficient') }})</span>
                        <span>100% ({{ __('Saturated') }})</span>
                    </div>
                    @error('phosphorus')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Potassium --}}
                <div class="p-4 rounded-2xl bg-white/5 border border-white/[0.04]">
                    <div class="flex justify-between items-center mb-2">
                        <label for="potassium" class="text-xs font-bold text-slate-300">{{ __('Potassium') }} (K)</label>
                        <div class="flex items-center gap-1">
                            <input id="potassium" name="potassium" type="number" step="1" min="0" max="100"
                                   value="{{ old('potassium') }}" class="input-soil w-16 text-center py-1 text-xs" placeholder="50">
                            <span class="text-xs text-slate-500">%</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="range" min="0" max="100" step="1" value="{{ old('potassium', 50) }}"
                               oninput="document.getElementById('potassium').value = this.value"
                               class="w-full h-1.5 bg-slate-800 rounded-lg appearance-none cursor-pointer accent-emerald-400">
                    </div>
                    <div class="flex justify-between text-[9px] text-slate-600 mt-2">
                        <span>0% ({{ __('Deficient') }})</span>
                        <span>100% ({{ __('Saturated') }})</span>
                    </div>
                    @error('potassium')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Moisture --}}
                <div class="p-4 rounded-2xl bg-white/5 border border-white/[0.04]">
                    <div class="flex justify-between items-center mb-2">
                        <label for="moisture" class="text-xs font-bold text-slate-300">{{ __('Moisture Level') }}</label>
                        <div class="flex items-center gap-1">
                            <input id="moisture" name="moisture" type="number" step="1" min="0" max="100"
                                   value="{{ old('moisture') }}" class="input-soil w-16 text-center py-1 text-xs" placeholder="45">
                            <span class="text-xs text-slate-500">%</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="range" min="0" max="100" step="1" value="{{ old('moisture', 45) }}"
                               oninput="document.getElementById('moisture').value = this.value"
                               class="w-full h-1.5 bg-slate-800 rounded-lg appearance-none cursor-pointer accent-emerald-400">
                    </div>
                    <div class="flex justify-between text-[9px] text-slate-600 mt-2">
                        <span>0% ({{ __('Dry') }})</span>
                        <span>100% ({{ __('Wet') }})</span>
                    </div>
                    @error('moisture')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Organic Matter --}}
                <div class="p-4 rounded-2xl bg-white/5 border border-white/[0.04]">
                    <div class="flex justify-between items-center mb-2">
                        <label for="organic_matter" class="text-xs font-bold text-slate-300">{{ __('Organic Matter') }}</label>
                        <div class="flex items-center gap-1">
                            <input id="organic_matter" name="organic_matter" type="number" step="0.1" min="0" max="20"
                                   value="{{ old('organic_matter') }}" class="input-soil w-16 text-center py-1 text-xs" placeholder="3.0">
                            <span class="text-xs text-slate-500">%</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="range" min="0" max="20" step="0.1" value="{{ old('organic_matter', 3) }}"
                               oninput="document.getElementById('organic_matter').value = this.value"
                               class="w-full h-1.5 bg-slate-800 rounded-lg appearance-none cursor-pointer accent-emerald-400">
                    </div>
                    <div class="flex justify-between text-[9px] text-slate-600 mt-2">
                        <span>0%</span>
                        <span>20% ({{ __('Rich') }})</span>
                    </div>
                    @error('organic_matter')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Location --}}
                <div class="md:col-span-2">
                    <label for="location" class="label-soil">{{ __('Field Location') }}</label>
                    <input id="location" name="location" type="text" value="{{ old('location') }}"
                           placeholder="e.g. Karimnagar, Telangana"
                           class="input-soil mt-1">
                </div>
            </div>
        </div>

        {{-- ── Submit ──────────────────────────────────────────────────────── --}}
        <div class="flex items-center justify-end gap-4 animate-fadeInUp delay-300" style="opacity:0;">
            <a href="{{ route('dashboard') }}" class="btn-secondary">{{ __('Cancel') }}</a>
            <button type="submit" id="submitBtn" class="btn-primary py-3.5 px-8 text-sm font-bold">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                {{ __('Analyse Soil') }}
            </button>
        </div>
    </form>
</div>

{{-- Loading overlay --}}
<div id="loadingOverlay" class="fixed inset-0 z-50 hidden flex items-center justify-center" style="background: rgba(8,13,8,0.85); backdrop-filter: blur(8px);">
    <div class="text-center">
        <div class="spinner mx-auto mb-6"></div>
        <p class="text-xl font-bold gradient-text mb-2">{{ __('Analysing Your Soil…') }}</p>
        <p class="text-slate-400 text-sm">{{ __('AI is processing your data. This takes a few seconds.') }}</p>
    </div>
</div>

@push('scripts')
<script>
// ── Double bind range & number inputs ─────────────────────────────────────────
document.querySelectorAll('input[type="range"]').forEach(range => {
    const numInput = document.getElementById(range.getAttribute('oninput').match(/'([^']+)'/)[1]);
    numInput.addEventListener('input', function() {
        range.value = this.value;
    });
});

// ── Image drag & drop ─────────────────────────────────────────────────────────
const dropZone  = document.getElementById('dropZone');
const fileInput = document.getElementById('soilImage');
const preview   = document.getElementById('imagePreview');
const wrapper   = document.getElementById('imagePreviewWrapper');
const placeholder = document.getElementById('uploadPlaceholder');

fileInput.addEventListener('change', function () {
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            placeholder.classList.add('hidden');
            wrapper.classList.remove('hidden');
        };
        reader.readAsDataURL(this.files[0]);
    }
});

['dragover','dragenter'].forEach(ev => {
    dropZone.addEventListener(ev, e => { e.preventDefault(); dropZone.classList.add('dragover'); });
});
['dragleave','drop'].forEach(ev => {
    dropZone.addEventListener(ev, e => {
        e.preventDefault();
        dropZone.classList.remove('dragover');
        if (ev === 'drop' && e.dataTransfer.files.length) {
            const dt = new DataTransfer();
            dt.items.add(e.dataTransfer.files[0]);
            fileInput.files = dt.files;
            fileInput.dispatchEvent(new Event('change'));
        }
    });
});

// ── Loading overlay on submit ─────────────────────────────────────────────────
document.getElementById('uploadForm').addEventListener('submit', function() {
    document.getElementById('loadingOverlay').classList.remove('hidden');
    document.getElementById('submitBtn').disabled = true;
});

// ── Fade-in animations ────────────────────────────────────────────────────────
window.addEventListener('load', () => {
    document.querySelectorAll('.animate-fadeInUp').forEach(el => { el.style.opacity = '1'; });
});
</script>
@endpush
@endsection
