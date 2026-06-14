<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Staff Portal | SK Fitness' }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxStyles
</head>
<body class="min-h-screen bg-gray-900 font-sans antialiased selection:bg-red-500 selection:text-white">
    <div class="relative min-h-screen flex flex-col items-center justify-center pt-6 sm:pt-0 overflow-hidden">
        
        <div class="absolute inset-0 bg-gradient-to-br from-black via-gray-900 to-red-900 opacity-90 z-0"></div>
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-20 z-0"></div>

        <div class="relative z-10 w-full sm:max-w-md mt-6 px-8 py-10 bg-gray-900/80 backdrop-blur-md shadow-2xl sm:rounded-3xl border border-gray-800">
            {{ $slot }}
        </div>
        
    </div>
    @fluxScripts
</body>
</html>