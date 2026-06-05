<aside 
    class="bg-white border-r border-gray-200 flex flex-col transition-all duration-300 ease-in-out h-full flex-shrink-0 overflow-hidden"
    :class="sidebarOpen ? 'w-64' : 'w-20'"
>
    <nav class="flex-grow py-8 px-4 space-y-2">
        <x-sidebar-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" icon="home">
            Dashboard {{ auth()->user()->role === 0 ? '(Global)' : '' }}
        </x-sidebar-link>

        @if(auth()->user()->role === 0)
            <x-sidebar-link href="{{ route('users.index') }}" :active="request()->routeIs('users.index')" icon="users">
                User Management
            </x-sidebar-link>
            <x-sidebar-link href="{{ route('projects.index') }}" :active="request()->routeIs('projects.*')" icon="briefcase">
                Institutional Projects
            </x-sidebar-link>
            <x-sidebar-link href="{{ route('audit-logs.index') }}" :active="request()->routeIs('audit-logs.index')" icon="clock">
                Audit Trails
            </x-sidebar-link>
            <x-sidebar-link href="{{ route('reports.index') }}" :active="request()->routeIs('reports.index')" icon="chart-bar">
                System Reports
            </x-sidebar-link>
            <x-sidebar-link href="{{ route('settings.index') }}" :active="request()->routeIs('settings.index')" icon="settings">
                Settings
            </x-sidebar-link>
        @endif

        @if(auth()->user()->role === 1)
            <x-sidebar-link href="{{ route('surveys.create') }}" :active="request()->routeIs('surveys.create')" icon="document-add">
                Survey Builder
            </x-sidebar-link>
            <x-sidebar-link href="{{ route('surveys.index') }}" :active="request()->routeIs('surveys.index')" icon="chart-bar">
                Survey Results
            </x-sidebar-link>
            <x-sidebar-link href="{{ route('projects.index') }}" :active="request()->routeIs('projects.*')" icon="briefcase">
                Projects
            </x-sidebar-link>
            <x-sidebar-link href="#" :active="false" icon="user-group">
                Attendance Tracking
            </x-sidebar-link>
        @endif
    </nav>

    <div class="bg-[#15803d] p-6 text-white space-y-4 shadow-[0px_4px_4px_0px_rgba(0,0,0,0.25)] transition-all duration-300"
         :class="sidebarOpen ? 'px-6' : 'px-4'">
        <x-sidebar-action-link href="#" icon="support">
            Support Center
        </x-sidebar-action-link>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-sidebar-action-link href="{{ route('logout') }}" icon="logout" onclick="event.preventDefault(); this.closest('form').submit();">
                Logout
            </x-sidebar-action-link>
        </form>
    </div>
</aside>
