<aside class="w-64 bg-white shadow-inner flex flex-col min-h-screen">
    <div class="p-6">
        <div class="flex items-center gap-3">
             <img src="https://www.figma.com/api/mcp/asset/2c6f52c7-ef2f-4a66-9663-3d277bbcf184" class="w-10 h-10 object-cover" alt="DWCC Logo">
             <div>
                <h2 class="text-[#1b8c00] font-bold text-sm leading-tight">E-CES Tracker</h2>
                <p class="text-[10px] text-gray-500">Divine Word College of Calapan</p>
             </div>
        </div>
    </div>

    <nav class="flex-grow px-4 space-y-2">
        <x-sidebar-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" icon="dashboard">
            Dashboard
        </x-sidebar-link>
        <x-sidebar-link href="#" icon="users">
            Users
        </x-sidebar-link>
        <x-sidebar-link href="#" icon="audit">
            Audit Trails
        </x-sidebar-link>
        <x-sidebar-link href="#" icon="reports">
            Reports
        </x-sidebar-link>
    </nav>

    <div class="bg-[#1a8a00] p-6 text-white space-y-4">
        <x-sidebar-action-link href="#" icon="settings">
            Settings
        </x-sidebar-action-link>
        <x-sidebar-action-link href="#" icon="support">
            Support
        </x-sidebar-action-link>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-sidebar-action-link href="{{ route('logout') }}" icon="logout" onclick="event.preventDefault(); this.closest('form').submit();">
                Logout
            </x-sidebar-action-link>
        </form>
    </div>
</aside>
