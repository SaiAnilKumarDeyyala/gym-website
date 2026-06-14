<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SK Fitness Gym | Stronger Faster Better</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 selection:bg-red-500 selection:text-white">

    <nav class="absolute top-0 w-full z-50 bg-transparent">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-24">
                
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-red-600 rounded-lg shadow-lg shadow-red-600/30">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span class="text-3xl font-extrabold tracking-widest text-white drop-shadow-md">
                        SK<span class="text-red-500">FITNESS</span>
                    </span>
                </div>
                
                @if (Route::has('login'))
                    <div>
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-6 py-2.5 border border-transparent text-sm font-bold rounded-full text-white bg-red-600 hover:bg-red-700 transition shadow-lg">
                                Go to Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-300 hover:text-white transition">
                                Staff Login &rarr;
                            </a>
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <div class="relative bg-gray-900 h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-black via-gray-900 to-red-900 opacity-90"></div>
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-20"></div>
        
        <div class="relative z-10 text-center px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto">
            <h1 class="text-5xl md:text-7xl font-extrabold text-white tracking-tight uppercase mb-6 drop-shadow-xl">
                Stronger <span class="text-red-600">&bull;</span> Faster <span class="text-red-600">&bull;</span> Better
            </h1>
            <p class="mt-4 text-xl md:text-2xl text-gray-300 max-w-3xl mx-auto mb-10 font-light tracking-wide">
                Discipline. Focus. Consistency. Success. <br/> Your fitness journey starts right here.
            </p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="#pricing" class="bg-red-600 hover:bg-red-700 text-white font-bold py-4 px-10 rounded-full transition duration-300 transform hover:-translate-y-1 shadow-lg shadow-red-600/50 text-lg uppercase tracking-wider">
                    View Offers
                </a>
                <a href="tel:+919492666993" class="bg-transparent border-2 border-gray-400 hover:border-white text-gray-300 hover:text-white font-bold py-4 px-10 rounded-full transition duration-300 text-lg uppercase tracking-wider">
                    Call Now
                </a>
            </div>
        </div>
    </div>

    <div id="pricing" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-base text-red-600 font-semibold tracking-wide uppercase">First 50 Members Only</h2>
                <p class="mt-2 text-4xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-5xl uppercase">
                    Limited Opening Offer
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
                
                <div class="bg-gray-50 rounded-3xl shadow-xl border border-gray-100 p-8 transform transition hover:-translate-y-2">
                    <h3 class="text-3xl font-extrabold text-gray-900 mb-6 text-center uppercase tracking-wide">1 Month</h3>
                    <div class="space-y-6 mb-8">
                        <div class="flex justify-between items-center border-b border-gray-200 pb-4">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">💪</span>
                                <span class="font-bold text-gray-700 text-lg">Strength</span>
                            </div>
                            <span class="font-extrabold text-red-600 text-2xl">₹1299</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-gray-200 pb-4">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">❤️</span>
                                <span class="font-bold text-gray-700 text-lg">Cardio + Strength</span>
                            </div>
                            <span class="font-extrabold text-red-600 text-2xl">₹1599</span>
                        </div>
                    </div>
                    <ul class="text-sm text-gray-500 font-medium space-y-3">
                        <li class="flex items-center justify-center gap-2">✓ Premium Equipment</li>
                        <li class="flex items-center justify-center gap-2">✓ Clean Showers & Secure Lockers</li>
                    </ul>
                </div>

                <div class="bg-gray-900 rounded-3xl shadow-2xl border border-gray-800 p-8 transform transition hover:-translate-y-2 relative overflow-hidden">
                    <div class="absolute top-0 right-0 bg-red-600 text-white text-xs font-bold px-4 py-2 rounded-bl-xl uppercase tracking-widest">
                        Grand Opening
                    </div>
                    <h3 class="text-3xl font-extrabold text-white mb-6 text-center uppercase tracking-wide">3 Months</h3>
                    <div class="space-y-6 mb-8">
                        <div class="flex justify-between items-center border-b border-gray-700 pb-4">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">💪</span>
                                <span class="font-bold text-gray-300 text-lg">Strength</span>
                            </div>
                            <span class="font-extrabold text-red-500 text-2xl">₹3499</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-gray-700 pb-4">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">❤️</span>
                                <span class="font-bold text-gray-300 text-lg">Cardio + Strength</span>
                            </div>
                            <span class="font-extrabold text-red-500 text-2xl">₹4499</span>
                        </div>
                    </div>
                    <ul class="text-sm text-gray-400 font-medium space-y-3">
                        <li class="flex items-center justify-center gap-2">✓ Certified Trainers</li>
                        <li class="flex items-center justify-center gap-2">✓ Personalized Workout Plan</li>
                    </ul>
                </div>

            </div>
            
            <div class="mt-16 text-center">
                <p class="text-gray-600 font-medium">📍 First Floor, SBI Bank, Karapa</p>
            </div>
        </div>
    </div>

</body>
</html>