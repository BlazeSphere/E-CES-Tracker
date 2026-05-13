<x-layouts.dashboard>
    <div class="max-w-7xl mx-auto p-6 space-y-10">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <nav class="flex text-sm text-gray-500 mb-2 font-inter">
                    <span>Administration</span>
                    <span class="mx-2 text-gray-400">
                        <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </span>
                    <span class="text-[#1b8c00] font-semibold">User Management</span>
                </nav>
                <h1 class="text-4xl md:text-5xl font-bold text-black font-inter">User Management</h1>
            </div>

            <div>
                <button class="bg-[#1b8c00] px-6 py-2.5 rounded-lg text-sm font-bold text-white flex items-center gap-2 hover:bg-[#167000] transition-colors shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add User
                </button>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <x-stat-card label="Total Users" :value="$totalUsers" icon="users" />
            <x-stat-card label="Super Admins" :value="$systemAdminsCount" icon="users" />
            <x-stat-card label="Admins" :value="$adminsCount" icon="users" />
        </div>

        <!-- Users Table -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left font-inter">
                    <thead class="bg-[#1b8c00] text-white">
                        <tr>
                            <th class="px-6 py-4 font-semibold text-sm">Name</th>
                            <th class="px-6 py-4 font-semibold text-sm">Email</th>
                            <th class="px-6 py-4 font-semibold text-sm">Role</th>
                            <th class="px-6 py-4 font-semibold text-sm">Status</th>
                            <th class="px-6 py-4 font-semibold text-sm">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($users as $user)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-[#1b8c00] font-bold border border-gray-200">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <span class="text-sm font-bold text-gray-900">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-4 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 border border-gray-200">
                                    {{ $user->role_name }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-[#d9f99d] text-[#1b8c00]">
                                    Active
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <button class="text-[#1b8c00] font-bold text-sm hover:underline">Edit</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-layouts.dashboard>
