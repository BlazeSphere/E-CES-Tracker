<x-layouts.app>
    <div class="flex min-h-screen bg-[#f0f3f5]">
        <x-sidebar />

        <div class="flex-grow flex flex-col">
            <header class="bg-[#1b8c00] h-[59px] shadow-md flex items-center justify-between px-10 relative z-20">
                <div></div>
                <div class="flex items-center gap-6">
                    <button class="text-white relative">
                        <img src="https://www.figma.com/api/mcp/asset/a1c8481a-827d-4076-8bc0-790bba12b1e2" class="w-6 h-6" alt="Notifications">
                    </button>
                    <div class="h-10 w-0.5 bg-[#e9d88e] rounded-full"></div>
                    <div class="flex items-center gap-3">
                        <div class="text-right">
                            <p class="text-white font-semibold text-sm leading-none">{{ Auth::user()->name ?? 'Guest' }}</p>
                            <p class="text-white/80 text-[10px]">{{ Auth::user()->role_name ?? 'Super Admin' }}</p>
                        </div>
                        <img src="https://www.figma.com/api/mcp/asset/cb73a4f2-3974-4f1c-b1f7-5dc3911c941b" class="w-10 h-10 rounded-full" alt="User Profile">
                    </div>
                </div>
            </header>

            <main class="p-10 flex-grow">
                {{ $slot }}
            </main>

            <footer class="bg-[#1b8c00] text-white p-10 mt-auto">
                <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                     <!-- Footer content same as login but maybe smaller or different grid -->
                     <!-- I'll reuse the footer logic here -->
                     <div class="flex flex-col items-center lg:items-start">
                        <img src="https://www.figma.com/api/mcp/asset/76bfa99c-865a-4149-a2d8-c714156ffe01" class="w-24 h-24 mb-4 object-contain" alt="App Logo">
                        <h3 class="font-inter font-bold text-base">Divine Word College of Calapan</h3>
                        <p class="font-inter text-xs opacity-80">Community Extension Services</p>
                    </div>

                    <div>
                        <h3 class="font-afacad font-bold text-xl mb-4">Quick Links</h3>
                        <ul class="font-crimson space-y-1 text-xs">
                            <li><a href="#" class="underline hover:text-gray-200">LMS</a></li>
                            <li><a href="#" class="underline hover:text-gray-200">MAMS - STUDENTS</a></li>
                            <li><a href="#" class="underline hover:text-gray-200">MAMS - PARENTS</a></li>
                            <li><a href="#" class="underline hover:text-gray-200">MAMS - FACULTY</a></li>
                            <li><a href="#" class="underline hover:text-gray-200">DWCC E-LIBRARY</a></li>
                            <li><a href="#" class="underline hover:text-gray-200">DCWW WEBSITE</a></li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-crimson font-bold text-xl mb-4">Contact Us</h3>
                        <div class="space-y-3">
                            <a href="#" class="flex items-center gap-2 hover:text-gray-200 text-sm">
                                <img src="https://www.figma.com/api/mcp/asset/9d435cd9-2040-4f49-8058-0451fa2568bb" class="w-5 h-5" alt="Facebook">
                                <span class="font-crimson font-semibold">Facebook</span>
                            </a>
                            <a href="#" class="flex items-center gap-2 hover:text-gray-200 text-sm">
                                <img src="https://www.figma.com/api/mcp/asset/cd6e474a-332d-4b29-9c52-9428e4d7ff18" class="w-5 h-5" alt="Instagram">
                                <span class="font-crimson font-semibold">Instagram</span>
                            </a>
                        </div>
                    </div>

                    <div>
                        <h3 class="font-crimson font-bold text-xl mb-4">Address</h3>
                        <div class="space-y-3 font-crimson font-semibold text-xs leading-relaxed">
                            <p>Gov. Infantado St., Calapan City, Oriental Mindoro</p>
                            <div class="flex items-center gap-2">
                                <img src="https://www.figma.com/api/mcp/asset/c4776847-df37-4c30-8d76-8a558bbf6b80" class="w-5 h-5" alt="Phone">
                                <span>288-9311 - 288-9316</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <img src="https://www.figma.com/api/mcp/asset/dbeba99c-4019-44d7-9df2-df01bd359411" class="w-5 h-5" alt="Email">
                                <span class="break-all">communityextensionservicesoffice@gmail.com</span>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</x-layouts.app>
