<x-layouts.dashboard>
    <div class="max-w-7xl mx-auto p-6 space-y-10">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <nav class="flex text-sm text-gray-500 mb-2 font-inter">
                    <span>System</span>
                    <span class="mx-2 text-gray-400">
                        <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </span>
                    <span class="text-[#1b8c00] font-semibold">Audit Trails</span>
                </nav>
                <h1 class="text-4xl md:text-5xl font-bold text-black font-inter">Audit Trails</h1>
                <p class="text-gray-500 mt-2">Track all activities performed by system users.</p>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4">
            <form action="{{ route('audit-logs.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-grow">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Search by action or description..." 
                               class="w-full bg-gray-50 border-gray-200 rounded-xl px-10 py-3 text-sm focus:ring-[#1b8c00] focus:border-[#1b8c00] transition-all">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                @if($isSuperAdmin)
                    <div class="w-full md:w-64">
                        <select name="user_id" onchange="this.form.submit()" class="w-full bg-gray-50 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-[#1b8c00] focus:border-[#1b8c00] transition-all">
                            <option value="">All Users</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <button type="submit" class="bg-[#1b8c00] text-white px-8 py-3 rounded-xl font-bold text-sm hover:bg-[#167000] transition-all shadow-lg shadow-green-900/10">
                    Apply Filters
                </button>
                
                @if(request()->anyFilled(['search', 'user_id']))
                    <a href="{{ route('audit-logs.index') }}" class="flex items-center justify-center px-4 py-3 text-gray-500 hover:text-gray-700 font-semibold text-sm">
                        Clear
                    </a>
                @endif
            </form>
        </div>

        <!-- Audit Log Table -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left font-inter">
                    <thead class="bg-[#1b8c00] text-white">
                        <tr>
                            <th class="px-6 py-4 font-semibold text-sm">Timestamp</th>
                            <th class="px-6 py-4 font-semibold text-sm">User</th>
                            <th class="px-6 py-4 font-semibold text-sm">Action</th>
                            <th class="px-6 py-4 font-semibold text-sm">Description</th>
                            <th class="px-6 py-4 font-semibold text-sm">IP Address</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($logs as $log)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-xs text-gray-500">
                                <div class="font-bold text-gray-900">{{ $log->created_at->format('M d, Y') }}</div>
                                <div>{{ $log->created_at->format('h:i A') }}</div>
                                <div class="text-[10px]">{{ $log->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-[#1b8c00] font-bold border border-gray-200 text-xs">
                                        {{ substr($log->user->name ?? 'U', 0, 1) }}
                                    </div>
                                    <span class="text-sm font-bold text-gray-900">{{ $log->user->name ?? 'Unknown' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-[#d9f99d] text-[#1b8c00] uppercase tracking-wider">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate" title="{{ $log->description }}">
                                {{ $log->description }}
                            </td>
                            <td class="px-6 py-4 text-xs font-mono text-gray-400">
                                {{ $log->ip_address ?? '0.0.0.0' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-12 h-12 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p>No activity logs found matching your criteria.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($logs->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.dashboard>
