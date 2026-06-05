<x-layouts.app>
    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: true }">
        <!-- Sidebar: Push/Pull direct child -->
        <x-sidebar />

        <!-- Main Content Wrapper: Naturally expands/contracts -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden bg-[#f0f3f5]">
            <!-- Top Header: Inside flex-1 to expand with it -->
            <header class="bg-[#1b8c00] h-[59px] shadow-[0px_4px_4px_0px_rgba(0,0,0,0.25)] flex items-center justify-between px-6 flex-shrink-0 z-10 text-white">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-white hover:bg-white/10 p-2 rounded-lg transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" class="h-10 w-auto object-contain brightness-0 invert" alt="DWCC Logo">
                        <div class="flex flex-col leading-tight border-l border-white/20 pl-3">
                            <span class="text-sm font-bold tracking-tight">Divine Word College of Calapan</span>
                            <span class="text-[10px] font-medium opacity-80 uppercase tracking-widest">Community Extension Services</span>
                        </div>
                    </div>
                </div>

                <!-- Right Header Actions -->
                <div class="flex items-center gap-6">
                    <div class="max-w-md hidden md:block w-64 lg:w-96">
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                            <input type="text" class="block w-full bg-white/10 border-none text-white text-sm rounded-lg pl-10 py-1.5 focus:ring-[#d9f99d] placeholder-white/50" placeholder="Search projects...">
                        </div>
                    </div>

                    <button class="text-white hover:opacity-80 transition-opacity">
                        <img src="{{ asset('images/icons/notifications.png') }}" onerror="this.onerror=null; this.src='{{ asset('images/icons/plus-circle.png') }}';" class="w-6 h-6 brightness-0 invert" alt="Notifications">
                    </button>
                    <div class="h-10 w-[1px] bg-white/20"></div>
                    <div class="flex items-center gap-3">
                        <div class="text-right hidden sm:block">
                            <p class="text-white font-semibold text-sm leading-none">{{ Auth::user()->name ?? 'User' }}</p>
                            <p class="text-white/70 text-[10px] uppercase tracking-wider mt-1">{{ Auth::user()->role === 0 ? 'Super Admin' : 'Administrator' }}</p>
                        </div>
                        @php
                            $user = Auth::user();
                            $initials = strtoupper(substr($user->name ?? 'U', 0, 1));
                        @endphp
                        @if($user && $user->profile_photo_path)
                            <img src="{{ asset($user->profile_photo_path) }}" 
                                 onerror="this.onerror=null; this.src='{{ asset('images/user-profile.png') }}';"
                                 class="w-10 h-10 rounded-full border border-white/20 object-cover shadow-sm" 
                                 alt="{{ $user->name }}">
                        @else
                            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white font-bold border border-white/40 shadow-sm">
                                {{ $initials }}
                            </div>
                        @endif
                    </div>
                </div>
            </header>

            <!-- Scrollable Content Area -->
            <div class="flex-1 overflow-y-auto flex flex-col">
                <main class="p-6 md:p-10 flex-grow">
                    {{ $slot }}
                </main>

                <!-- Footer -->
                <footer class="bg-[#1b8c00] text-white p-10 flex-shrink-0">
                    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                        <div class="flex flex-col items-center lg:items-start">
                            <img src="{{ asset('images/logo.png') }}" onerror="this.onerror=null; this.src='{{ asset('images/logo.png') }}';" class="w-24 h-24 mb-4 object-contain brightness-0 invert" alt="DWCC Logo">
                            <h3 class="font-inter font-bold text-base">Divine Word College of Calapan</h3>
                            <p class="font-inter text-xs opacity-80 text-center lg:text-left uppercase tracking-widest">Community Extension Services</p>
                        </div>

                        <div>
                            <h3 class="font-afacad font-bold text-2xl mb-6">Quick Links</h3>
                            <ul class="font-crimson space-y-1 text-sm text-white/90">
                                <li><a href="#" class="underline hover:text-white">LMS</a></li>
                                <li><a href="#" class="underline hover:text-white">MAMS - STUDENTS</a></li>
                                <li><a href="#" class="underline hover:text-white">MAMS - PARENTS</a></li>
                                <li><a href="#" class="underline hover:text-white">MAMS - FACULTY</a></li>
                                <li><a href="#" class="underline hover:text-white">DWCC E-LIBRARY</a></li>
                                <li><a href="#" class="underline hover:text-white">DCWW WEBSITE</a></li>
                            </ul>
                        </div>

                        <div>
                            <h3 class="font-crimson font-bold text-2xl mb-6">Contact Us</h3>
                            <div class="space-y-4">
                                <a href="#" class="flex items-center gap-3 hover:text-white text-sm">
                                    <img src="{{ asset('images/icons/facebook.png') }}" onerror="this.onerror=null; this.src='{{ asset('images/icons/plus-circle.png') }}';" class="w-6 h-6 brightness-0 invert" alt="Facebook">
                                    <span class="font-crimson font-semibold text-lg">Facebook</span>
                                </a>
                                <a href="#" class="flex items-center gap-3 hover:text-white text-sm">
                                    <img src="{{ asset('images/icons/instagram.png') }}" onerror="this.onerror=null; this.src='{{ asset('images/icons/plus-circle.png') }}';" class="w-6 h-6 brightness-0 invert" alt="Instagram">
                                    <span class="font-crimson font-semibold text-lg">Instagram</span>
                                </a>
                            </div>
                        </div>

                        <div>
                            <h3 class="font-crimson font-bold text-2xl mb-6">Address</h3>
                            <div class="space-y-4 font-crimson font-semibold text-sm leading-relaxed text-white/90">
                                <p>Gov. Infantado St., Calapan City, Oriental Mindoro</p>
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('images/icons/phone.png') }}" onerror="this.onerror=null; this.src='{{ asset('images/icons/plus-circle.png') }}';" class="w-6 h-6 brightness-0 invert" alt="Phone">
                                    <span>288-9311 - 288-9316</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('images/icons/email.png') }}" onerror="this.onerror=null; this.src='{{ asset('images/icons/plus-circle.png') }}';" class="w-6 h-6 brightness-0 invert" alt="Email">
                                    <span class="break-all text-[12px]">communityextensionservicesoffice@gmail.com</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
</x-layouts.app>