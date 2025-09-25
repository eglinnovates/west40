<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Student Roster') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">
    {{-- Top bar with logo at top-left --}}
    <x-top-nav />

    {{-- Main layout: left sidebar + main content --}}
    <div class="flex">
        {{-- Sidebar (left nav) --}}
        <x-sidebar-nav />

        {{-- Content area --}}
        <main class="flex-1 px-4 py-6">
            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
