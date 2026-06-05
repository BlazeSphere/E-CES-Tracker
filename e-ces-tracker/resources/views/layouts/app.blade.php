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
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        @auth
            @if(Auth::check() && Auth::user()->status === 'inactive')
                <div style="position: fixed; inset: 0; background: rgba(0,0,0,0.8); backdrop-filter: blur(10px); z-index: 9999; display: flex; align-items: center; justify-content: center;">
                    <div style="background: white; padding: 2rem; border-radius: 1rem; text-align: center;">
                        <h1 style="color: red; font-size: 2rem; font-weight: bold;">ACCOUNT DEACTIVATED</h1>
                        <p>Please contact the Super Admin.</p>
                        <form method="POST" action="{{ route('logout') }}"> @csrf <button type="submit" style="text-decoration: underline; margin-top: 1rem;">Logout</button></form>
                    </div>
                </div>
            @endif
        @endauth
        
        <div class="min-h-screen">
            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
