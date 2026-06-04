<x-layouts.dashboard>
    <div class="max-w-7xl mx-auto p-6 space-y-10">
        <!-- Dashboard Header -->
        <div>
            <h1 class="text-5xl font-bold text-black font-inter">Dashboard</h1>
            <p class="text-[#0c4010] font-semibold text-lg font-inter">Overview and Monitoring</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <x-stat-card label="Active Projects" :value="$activeProjectsCount ?? 50" trend="5" icon="projects" />
            <x-stat-card label="Surveys Conducted" :value="$surveysCount ?? 32" trend="5" icon="surveys" />
            <x-stat-card label="Volunteers" :value="$volunteersCount ?? 50" trend="5" icon="volunteers" />
            <x-stat-card label="Adopted Communities" :value="$communitiesCount ?? 50" trend="5" icon="communities" />
        </div>

        <!-- Middle Section -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Institutional Growth Trends -->
            <div class="lg:col-span-8 bg-white border border-[#15803d] rounded-lg shadow-sm overflow-hidden flex flex-col">
                <div class="bg-[#15803d] p-4 text-white shadow-md">
                    <h3 class="font-bold text-sm">Institutional Growth Trends</h3>
                    <p class="text-[10px] opacity-80">Consolidated survey and project metrics</p>
                </div>
                <div class="flex-grow flex items-center justify-center p-6 text-center">
                    <div class="w-full h-[300px]">
                        <canvas id="growthChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Right Side Tools & Logs -->
            <div class="lg:col-span-4 space-y-8">
                <!-- Quick Access Tools -->
                <div class="bg-white border border-[#15803d] rounded-lg shadow-sm overflow-hidden">
                    <div class="bg-[#15803d] p-4 text-white shadow-md">
                        <h3 class="font-bold text-sm">Quick Access Tools</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <button class="w-full bg-[#f7f9ec] p-3 rounded-lg shadow-sm flex items-center gap-3 hover:bg-[#eef2d8] transition-colors border border-transparent hover:border-[#15803d]">
                            <img src="{{ asset('images/icons/plus-circle.png') }}" class="w-6 h-6" alt="">
                            <span class="font-semibold text-sm">Add System User</span>
                        </button>
                        <button class="w-full bg-[#f7f9ec] p-3 rounded-lg shadow-sm flex items-center gap-3 hover:bg-[#eef2d8] transition-colors border border-transparent hover:border-[#15803d]">
                            <img src="{{ asset('images/icons/plus-circle.png') }}" class="w-6 h-6" alt="">
                            <span class="font-semibold text-sm">Create New Survey</span>
                        </button>
                        <button class="w-full bg-[#f7f9ec] p-3 rounded-lg shadow-sm flex items-center gap-3 hover:bg-[#eef2d8] transition-colors border border-transparent hover:border-[#15803d]">
                            <img src="{{ asset('images/icons/audit.png') }}" class="w-5 h-5 ml-0.5" alt="">
                            <span class="font-semibold text-sm">Audit Logs</span>
                        </button>
                        <button class="w-full bg-[#f7f9ec] p-3 rounded-lg shadow-sm flex items-center gap-3 hover:bg-[#eef2d8] transition-colors border border-transparent hover:border-[#15803d]">
                            <img src="{{ asset('images/icons/reports.png') }}" class="w-6 h-6" alt="">
                            <span class="font-semibold text-sm">Generate Summary Report</span>
                        </button>
                    </div>
                </div>

                <!-- Audit Log -->
                <div class="bg-white border border-[#15803d] rounded-lg shadow-sm overflow-hidden">
                    <div class="bg-[#15803d] p-4 text-white shadow-md flex justify-between items-center">
                        <h3 class="font-bold text-sm">Audit Log</h3>
                        <a href="{{ route('audit.index') }}" class="text-[10px] font-medium hover:underline">View All</a>
                    </div>
                    <div class="p-4 space-y-6">
                        @forelse($auditLogs ?? [] as $log)
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center flex-shrink-0 text-gray-500 font-bold text-xs">
                                {{ strtoupper(substr($log->user->name ?? 'U', 0, 1)) }}{{ strtoupper(substr(explode(' ', $log->user->name ?? ' ')[1] ?? '', 0, 1)) }}
                            </div>
                            <div class="flex-grow">
                                <p class="text-[11px] leading-tight">
                                    <span class="font-semibold">{{ $log->user->name ?? 'System' }}</span>
                                    <span class="font-light">{{ $log->action }}</span>
                                </p>
                                <p class="text-[11px] text-[#15803d] font-semibold leading-tight mt-0.5">{{ $log->description }}</p>
                                <p class="text-[8px] text-gray-400 mt-1">{{ $log->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @empty
                            <div class="py-10 text-center">
                                <p class="text-xs text-gray-400 italic">No recent activity</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Latest Institutional Projects -->
        <div class="bg-white border border-[#15803d] rounded-lg shadow-sm overflow-hidden">
            <div class="bg-[#15803d] p-4 text-white shadow-md">
                <h3 class="font-bold text-sm">Latest Institutional Projects</h3>
                <p class="text-[10px] opacity-80">Newly registered or updated service-learning initiatives</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-white border-b shadow-sm">
                        <tr>
                            <th class="px-6 py-4 font-semibold text-xs">Project Title/Name</th>
                            <th class="px-6 py-4 font-semibold text-xs">Lead Organizer</th>
                            <th class="px-6 py-4 font-semibold text-xs">Community Partner</th>
                            <th class="px-6 py-4 font-semibold text-xs">Status</th>
                            <th class="px-6 py-4 font-semibold text-xs">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($projects as $project)
                            <tr>
                                <td class="px-6 py-4">
                                    <p class="text-[#0c4010] font-semibold text-xs">{{ $project->title }}</p>
                                    <p class="text-[8px] text-[#0c4010] font-light">Project Date: {{ $project->created_at->format('m-d-Y') }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        @php
                                            $organizerName = $project->user->name ?? 'N/A';
                                            $organizerInitials = strtoupper(substr($organizerName, 0, 1));
                                        @endphp
                                        <div class="w-6 h-6 rounded-full bg-[#d9f99d] flex items-center justify-center text-[#15803d] font-bold text-[10px] flex-shrink-0">
                                            {{ $organizerInitials }}
                                        </div>
                                        <span class="text-xs font-semibold">{{ $organizerName }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-xs font-semibold text-[#44341d]">{{ $project->partner_name ?? 'N/A' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-xs font-semibold 
                                        @switch($project->status)
                                            @case('Completed') text-green-600 @break
                                            @case('In Progress') text-yellow-600 @break
                                            @case('Cancelled') text-red-600 @break
                                            @default text-black
                                        @endswitch">
                                        {{ $project->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="#" class="text-[#44341d] font-semibold text-xs flex items-center gap-2 hover:underline">
                                        See Details
                                        <img src="{{ asset('images/icons/chevron-right.png') }}" class="w-4 h-4" alt="">
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
