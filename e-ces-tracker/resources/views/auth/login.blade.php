<x-layouts.app>
    <div class="min-h-screen flex flex-col bg-gradient-to-b from-[#1b8c00] to-[#e9f0fa] relative overflow-hidden">
        <!-- Background Overlay Image -->
        <div class="absolute inset-0 z-0 pointer-events-none">
             <img src="https://www.figma.com/api/mcp/asset/2b91f14b-87a0-43f9-8a23-ae9d4bd26616" class="w-full h-full object-cover opacity-80 mix-blend-overlay" alt="Background">
        </div>

        <!-- Header -->
        <header class="relative z-10 flex items-center p-4 px-10">
            <img src="https://www.figma.com/api/mcp/asset/dc44bb1e-e6b7-4a2e-840e-8de3a1528610" class="w-16 h-16 mr-4" alt="DWCC Logo">
            <div>
                <h1 class="text-white font-bold text-lg leading-tight font-inter">Divine Word College of Calapan</h1>
                <p class="text-white text-xs font-inter">Gov. Infantado St., Calapan City, Oriental Mindoro</p>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow relative z-10 flex flex-col lg:flex-row items-center justify-center gap-12 px-10 py-20">
            <!-- Left Info Card -->
            <div class="bg-white/70 rounded-xl p-10 max-w-xl shadow-lg backdrop-blur-sm">
                <h2 class="font-afacad font-bold text-4xl text-black mb-2">E-CES Tracker:</h2>
                <h3 class="font-afacad font-bold text-2xl text-black mb-6 leading-tight">Digital Survey and Monitor Platform</h3>
                <p class="font-afacad text-black text-lg leading-relaxed">
                    A centralized web-based platform designed to enhance the efficiency and effectiveness of the Community Extension Services (CES) office. This system will serve as a comprehensive tool to manage CES operations, including survey collection, event tracking, and data organization, in a more streamlined and reliable manner.
                </p>
            </div>

            <!-- Right Login Card -->
            <div class="bg-[#1b8c00] bg-opacity-90 rounded-xl p-12 w-full max-w-md shadow-2xl flex flex-col items-center">
                <div class="mb-6 flex flex-col items-center">
                    <div class="w-20 h-20 mb-4 flex items-center justify-center">
                        <img src="https://www.figma.com/api/mcp/asset/08b70f61-9a06-47f0-b871-679ca4fc1d05" class="w-full h-full object-contain" alt="App Logo">
                    </div>
                    <h2 class="text-white font-afacad font-bold text-4xl">E-CES Tracker</h2>
                </div>

                <form method="POST" action="{{ route('login') }}" class="w-full space-y-6">
                    @csrf

                    <div>
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Email" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" placeholder="Password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center">
                            <x-checkbox id="remember_me" name="remember" />
                            <span class="ms-2 text-sm text-white font-afacad">Remember me</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-white hover:text-gray-200 font-afacad" href="{{ route('password.request') }}">
                                Forgot Password?
                            </a>
                        @endif
                    </div>

                    <div class="flex items-center justify-center mt-8">
                        <x-primary-button>
                            Login
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </main>

        <!-- Footer -->
        <footer class="relative z-10 bg-[#1b8c00] text-white p-10 mt-auto">
            <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 text-center md:text-left">
                <!-- DWCC Logo/Info -->
                <div class="flex flex-col items-center lg:items-start">
                    <img src="https://www.figma.com/api/mcp/asset/08b70f61-9a06-47f0-b871-679ca4fc1d05" class="w-32 h-32 mb-4 object-contain" alt="DWCC Logo Large">
                    <h3 class="font-inter font-bold text-lg">Divine Word College of Calapan</h3>
                    <p class="font-inter text-sm opacity-80">Community Extension Services</p>
                </div>

                <!-- Quick Links -->
                <div class="flex flex-col items-center lg:items-start">
                    <h3 class="font-afacad font-bold text-2xl mb-6">Quick Links</h3>
                    <ul class="font-crimson space-y-2 text-sm">
                        <li><a href="#" class="underline hover:text-gray-200">LMS</a></li>
                        <li><a href="#" class="underline hover:text-gray-200">MAMS - STUDENTS</a></li>
                        <li><a href="#" class="underline hover:text-gray-200">MAMS - PARENTS</a></li>
                        <li><a href="#" class="underline hover:text-gray-200">MAMS - FACULTY</a></li>
                        <li><a href="#" class="underline hover:text-gray-200">DWCC E-LIBRARY</a></li>
                        <li><a href="#" class="underline hover:text-gray-200">DCWW WEBSITE</a></li>
                    </ul>
                </div>

                <!-- Contact Us -->
                <div class="flex flex-col items-center lg:items-start">
                    <h3 class="font-crimson font-bold text-2xl mb-6">Contact Us</h3>
                    <div class="space-y-4">
                        <a href="#" class="flex items-center justify-center lg:justify-start gap-3 hover:text-gray-200">
                            <img src="https://www.figma.com/api/mcp/asset/d1b50287-247b-49d3-a0f4-46dec7866b41" class="w-6 h-6" alt="Facebook">
                            <span class="font-crimson font-semibold text-lg">Facebook</span>
                        </a>
                        <a href="#" class="flex items-center justify-center lg:justify-start gap-3 hover:text-gray-200">
                            <img src="https://www.figma.com/api/mcp/asset/0adc0ee1-ccf2-4063-89dc-b0a409de5af9" class="w-6 h-6" alt="Instagram">
                            <span class="font-crimson font-semibold text-lg">Instagram</span>
                        </a>
                    </div>
                </div>

                <!-- Address -->
                <div class="flex flex-col items-center lg:items-start">
                    <h3 class="font-crimson font-bold text-2xl mb-6">Address</h3>
                    <div class="space-y-4 font-crimson font-semibold">
                        <p class="text-sm">Gov. Infantado St., Calapan City, Oriental Mindoro</p>
                        <div class="flex items-center justify-center lg:justify-start gap-3 text-sm">
                            <img src="https://www.figma.com/api/mcp/asset/5b63bc05-4961-4ac2-ad4e-f254e9de1e8a" class="w-6 h-6" alt="Phone">
                            <span>288-9311 - 288-9316</span>
                        </div>
                        <div class="flex items-center justify-center lg:justify-start gap-3 text-sm">
                            <img src="https://www.figma.com/api/mcp/asset/77d14545-5c50-4022-bc5a-58f9f073c7e0" class="w-6 h-6" alt="Email">
                            <span class="break-all">communityextensionservicesoffice@gmail.com</span>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</x-layouts.app>
