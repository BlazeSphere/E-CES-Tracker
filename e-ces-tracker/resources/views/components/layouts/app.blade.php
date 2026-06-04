<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Afacad:ital,wght@0,400..700;1,400..700&family=Crimson+Text:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&family=Inter:wght@100..900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#f0f3f5] text-gray-900">
        {{ $slot }}

        <!-- Lock Screen Overlay for Inactive Users -->
        @if(isset($is_deactivated) && $is_deactivated)
            <div class="fixed inset-0 z-[9999] bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4 overflow-hidden pointer-events-auto" 
                 x-data x-init="document.body.style.overflow = 'hidden'">
                <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-10 text-center transform transition-all">
                    <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    
                    <h2 class="text-3xl font-bold text-gray-900 mb-2 font-inter">Account Inactive</h2>
                    <p class="text-gray-500 mb-8 leading-relaxed font-inter">Your account has been deactivated. Please contact the Super Admin for assistance.</p>
                    
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-[#1b8c00] text-white font-bold py-4 rounded-2xl hover:bg-[#167000] transition-all shadow-lg shadow-green-900/20">
                            Logout and Exit
                        </button>
                    </form>
                </div>
            </div>
            <style>
                body { pointer-events: none !important; }
                .z-\[9999\] { pointer-events: auto !important; }
            </style>
        @endif
    </body>
</html>
