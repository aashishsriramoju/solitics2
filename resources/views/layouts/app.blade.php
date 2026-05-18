<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Soilytics — AI-Powered Smart Soil Analysis & Crop Recommendation Platform">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Soilytics') — Smart Soil Analysis</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-sans">

    {{-- App layout is chosen by child views --}}
    @yield('content')

    @stack('scripts')
</body>
</html>
