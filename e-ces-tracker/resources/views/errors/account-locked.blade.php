<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Account Inactive - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (via Vite) -->
    @vite(['resources/css/app.css'])
</head>
<body class="font-inter antialiased bg-[#15803d] min-h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-10 text-center transform transition-all">
        <!-- Lock Icon -->
        <div class="w-24 h-24 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-8 border-4 border-red-100">
            <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
        </div>
        
        <h1 class="text-3xl font-black text-gray-900 mb-4 tracking-tight">Your Account is Inactive</h1>
        <p class="text-gray-500 mb-8 leading-relaxed font-medium">
            Your access to the E-CES Tracker system has been restricted. Please contact the Super Admin for reactivation or further assistance.
        </p>
        
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full bg-red-600 text-white font-bold py-4 rounded-xl hover:bg-red-700 transition-colors shadow-lg shadow-red-900/20 uppercase tracking-widest text-sm">
                LOGOUT AND EXIT
            </button>
        </form>
    </div>

</body>
</html>
