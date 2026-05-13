<x-layouts.dashboard>
    <div class="max-w-7xl mx-auto p-6 space-y-10">
        <!-- Header Section -->
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

        <!-- Audit Log List -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
            <div class="p-4 bg-gray-50 border-b border-gray-100">
                <h3 class="font-bold text-gray-700 font-inter">Recent Activity</h3>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($logs as $log)
                <div class="p-6 hover:bg-gray-50 transition-colors flex items-start gap-6">
                    <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center text-[#1b8c00] font-bold border border-gray-200 flex-shrink-0">
                        {{ substr($log->user->name ?? 'U', 0, 1) }}
                    </div>
                    
                    <div class="flex-grow">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-inter">
                                    <span class="font-bold text-gray-900">{{ $log->user->name ?? 'Unknown User' }}</span>
                                    <span class="text-gray-600">{{ $log->action }}</span>
                                </p>
                                @if($log->description)
                                    <p class="text-sm text-[#1b8c00] font-semibold mt-1 font-inter">{{ $log->description }}</p>
                                @endif
                                <div class="mt-2 flex items-center gap-4 text-[10px] text-gray-400 font-inter">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                        {{ $log->created_at->diffForHumans() }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                        {{ $log->ip_address ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-12 text-center text-gray-500 font-inter">
                    No activity logs found.
                </div>
                @endforelse
            </div>

            @if($logs->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.dashboard>
