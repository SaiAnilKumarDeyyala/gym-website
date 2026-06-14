<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Staff Login | SK Fitness</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased selection:bg-red-500 selection:text-white">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative overflow-hidden bg-gray-900">
        
        <div class="absolute inset-0 bg-gradient-to-br from-black via-gray-900 to-red-900 opacity-90 z-0"></div>
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-20 z-0"></div>

        <div class="relative z-10 text-center mb-6 mt-10 sm:mt-0">
            <a href="/" class="flex flex-col items-center gap-3">
                <div class="p-3 bg-red-600 rounded-xl shadow-lg shadow-red-600/30">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <span class="text-4xl font-extrabold tracking-widest text-white drop-shadow-md">
                    SK<span class="text-red-500">FITNESS</span>
                </span>
            </a>
        </div>

        <div class="relative z-10 w-full sm:max-w-md mt-6 px-8 py-10 bg-gray-900/80 backdrop-blur-md shadow-2xl overflow-hidden sm:rounded-2xl border border-gray-700">
            {{ $slot }}
        </div>
        
    </div>
</body>
</html>