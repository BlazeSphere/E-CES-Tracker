<aside 
    class="bg-white border-r border-gray-200 flex flex-col transition-all duration-300 ease-in-out h-full flex-shrink-0 overflow-hidden"
    :class="sidebarOpen ? 'w-64' : 'w-20'"
>
    <nav class="flex-grow py-8 px-4 space-y-2">
        <x-sidebar-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" icon="dashboard">
            Dashboard
        </x-sidebar-link>
        <x-sidebar-link href="{{ route('users.index') }}" :active="request()->routeIs('users.index')" icon="users">
            Users
        </x-sidebar-link>
        <x-sidebar-link href="{{ route('audit.index') }}" :active="request()->routeIs('audit.index')" icon="audit">
            Audit Trails
        </x-sidebar-link>
        <x-sidebar-link href="{{ route('reports.index') }}" :active="request()->routeIs('reports.index')" icon="reports">
            Reports
        </x-sidebar-link>
    </nav>

    <div class="bg-[#15803d] p-6 text-white space-y-4 shadow-[0px_4px_4px_0px_rgba(0,0,0,0.25)] transition-all duration-300"
         :class="sidebarOpen ? 'px-6' : 'px-4'">
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
