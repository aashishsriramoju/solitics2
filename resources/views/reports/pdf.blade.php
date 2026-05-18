<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Soilytics Report — {{ $report->title }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Georgia, serif; background: #fff; color: #1a1a1a; padding: 40px; }
        .header { display: flex; align-items: center; justify-content: space-between; border-bottom: 3px solid #059669; padding-bottom: 20px; margin-bottom: 30px; }
        .logo { font-size: 28px; font-weight: 900; color: #059669; }
        .logo span { color: #84cc16; }
        .subtitle { color: #666; font-size: 12px; }
        .title { font-size: 22px; font-weight: bold; color: #111; margin-bottom: 4px; }
        .date  { color: #888; font-size: 12px; }
        .section { margin-bottom: 28px; }
        .section-title { font-size: 14px; font-weight: bold; color: #059669; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #e5e7eb; padding-bottom: 6px; margin-bottom: 14px; }
        .grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .stat-box { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px; }
        .stat-label { font-size: 11px; color: #888; text-transform: uppercase; margin-bottom: 4px; }
        .stat-value { font-size: 20px; font-weight: 900; color: #059669; }
        .stat-sub   { font-size: 11px; color: #666; }
        .score-big { font-size: 48px; font-weight: 900; }
        .healthy  { color: #059669; }
        .moderate { color: #d97706; }
        .poor     { color: #dc2626; }
        .badge    { display: inline-block; padding: 2px 10px; border-radius: 100px; font-size: 11px; font-weight: bold; }
        .badge-h  { background: #d1fae5; color: #065f46; }
        .badge-m  { background: #fef3c7; color: #92400e; }
        .badge-p  { background: #fee2e2; color: #991b1b; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th { background: #f0fdf4; color: #059669; padding: 8px 10px; text-align: left; font-size: 11px; text-transform: uppercase; }
        td { padding: 8px 10px; border-bottom: 1px solid #f3f4f6; }
        .bar-track { background: #e5e7eb; border-radius: 100px; height: 8px; }
        .bar-fill  { background: #059669; border-radius: 100px; height: 8px; }
        .ai-box    { background: #f5f3ff; border: 1px solid #ddd6fe; border-radius: 8px; padding: 14px; }
        .ai-title  { font-size: 12px; font-weight: bold; color: #7c3aed; margin-bottom: 8px; }
        .footer    { margin-top: 40px; border-top: 1px solid #e5e7eb; padding-top: 14px; color: #aaa; font-size: 11px; display: flex; justify-content: space-between; }
        .condition { background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 14px; font-size: 13px; line-height: 1.6; color: #374151; }
        img.soil-img { max-width: 200px; max-height: 160px; border-radius: 10px; object-fit: cover; }
        @media print { body { padding: 20px; } }
    </style>
</head>
<body>

<div class="header">
    <div>
        <div class="logo">Soil<span>ytics</span></div>
        <div class="subtitle">AI-Powered Smart Soil Analysis Platform</div>
    </div>
    <div style="text-align:right;">
        <div class="title">{{ $report->title }}</div>
        <div class="date">Generated: {{ now()->format('d F Y, h:i A') }}</div>
        <div class="date">User: {{ $report->user->name }} &lt;{{ $report->user->email }}&gt;</div>
        @if($report->location) <div class="date">Location: {{ $report->location }}</div> @endif
    </div>
</div>

{{-- Score section --}}
<div class="section">
    <div class="section-title">Soil Health Overview</div>
    <div class="grid2">
        <div class="stat-box">
            <div class="stat-label">Health Score</div>
            <div class="score-big
                {{ $report->health_score >= 75 ? 'healthy' : ($report->health_score >= 45 ? 'moderate' : 'poor') }}">
                {{ $report->health_score }}<span style="font-size:20px;color:#888;">/100</span>
            </div>
            <span class="badge {{ $report->health_status === 'Healthy' ? 'badge-h' : ($report->health_status === 'Moderate' ? 'badge-m' : 'badge-p') }}">
                {{ $report->health_status }}
            </span>
        </div>
        <div class="stat-box">
            <div class="stat-label">Soil Type</div>
            <div style="font-size:18px;font-weight:bold;">{{ $report->soil_type }}</div>
            <div class="stat-sub">pH: {{ $report->ph_level }} — {{ $report->soil_ph_category }}</div>
            @if($report->getImageUrl())
                <img src="{{ $report->getImageUrl() }}" alt="Soil" class="soil-img" style="margin-top:10px;">
            @endif
        </div>
    </div>
</div>

{{-- Nutrient values --}}
<div class="section">
    <div class="section-title">Nutrient Analysis</div>
    <div class="grid2">
        @foreach(['Nitrogen' => $report->nitrogen, 'Phosphorus' => $report->phosphorus, 'Potassium' => $report->potassium, 'Moisture' => $report->moisture, 'Organic Matter' => $report->organic_matter, 'pH Level' => $report->ph_level] as $label => $val)
        <div class="stat-box">
            <div class="stat-label">{{ $label }}</div>
            <div style="font-size:18px;font-weight:bold;color:#1a1a1a;">{{ $val }}{{ $label === 'pH Level' ? '' : '%' }}</div>
            @if($label !== 'pH Level')
            <div class="bar-track" style="margin-top:6px;"><div class="bar-fill" style="width:{{ min(100,$val) }}%;"></div></div>
            @endif
        </div>
        @endforeach
    </div>
</div>

{{-- Soil condition --}}
<div class="section">
    <div class="section-title">Soil Condition Summary</div>
    <div class="condition">{{ $report->soil_condition }}</div>
</div>

{{-- Deficiencies --}}
@if(!empty($report->deficiencies))
<div class="section">
    <div class="section-title">Deficiencies Detected</div>
    <table>
        <thead><tr><th>Nutrient</th><th>Level</th><th>Severity</th></tr></thead>
        <tbody>
            @foreach($report->deficiencies as $def)
            <tr>
                <td>{{ $def['nutrient'] }}</td>
                <td>{{ $def['level'] }}</td>
                <td style="color: {{ $def['severity'] === 'high' ? '#dc2626' : '#d97706' }}; font-weight: bold;">{{ ucfirst($def['severity']) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

{{-- Crop recommendations --}}
@if(!empty($report->crop_recommendations))
<div class="section">
    <div class="section-title">Recommended Crops</div>
    <table>
        <thead><tr><th>Crop</th><th>Season</th><th>Water Needs</th><th>Suitability</th></tr></thead>
        <tbody>
            @foreach($report->crop_recommendations as $crop)
            <tr>
                <td style="font-weight:bold;">{{ $crop['name'] }}</td>
                <td>{{ $crop['season'] }}</td>
                <td>{{ $crop['water'] }}</td>
                <td style="color: {{ $crop['suitability'] === 'Excellent' ? '#059669' : '#d97706' }}; font-weight: bold;">{{ $crop['suitability'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

{{-- Fertilizer recommendations --}}
@if(!empty($report->fertilizer_recommendations))
<div class="section">
    <div class="section-title">Fertilizer Recommendations</div>
    <table>
        <thead><tr><th>Fertilizer</th><th>Dose</th><th>Timing</th><th>Type</th><th>Priority</th></tr></thead>
        <tbody>
            @foreach($report->fertilizer_recommendations as $fert)
            <tr>
                <td style="font-weight:bold;">{{ $fert['name'] }}</td>
                <td>{{ $fert['dose'] }}</td>
                <td>{{ $fert['timing'] }}</td>
                <td>{{ $fert['type'] }}</td>
                <td style="color: {{ $fert['priority'] === 'High' ? '#dc2626' : ($fert['priority'] === 'Medium' ? '#d97706' : '#059669') }}; font-weight:bold;">{{ $fert['priority'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

{{-- AI Analysis --}}
@if($report->ai_analysis)
<div class="section">
    <div class="section-title">AI Visual Analysis (Gemini Vision)</div>
    <div class="ai-box">
        <div class="ai-title">🤖 AI-Generated Insights</div>
        <p style="font-size:13px;line-height:1.6;color:#374151;">{{ $report->ai_analysis }}</p>
        @if($report->ai_recommendations)
        <div style="margin-top:12px;padding-top:12px;border-top:1px solid #ddd6fe;">
            <strong style="font-size:12px;color:#7c3aed;">AI Recommendations:</strong>
            <p style="font-size:13px;line-height:1.6;color:#374151;margin-top:6px;">{{ $report->ai_recommendations }}</p>
        </div>
        @endif
    </div>
</div>
@endif

<div class="footer">
    <span>Soilytics — AI-Powered Smart Soil Analysis | soilytics.app</span>
    <span>Report ID: #{{ $report->id }} | {{ now()->format('d M Y') }}</span>
</div>

<script>window.print();</script>
</body>
</html>
