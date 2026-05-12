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
                <div class="flex-grow flex items-center justify-center p-12 text-center">
                    <div class="space-y-4 w-full">
                        <p class="text-2xl font-bold text-black font-inter mx-auto max-w-sm">graph about surveys conducted, volunteers and proposed projects</p>
                        <!-- Placeholder for Chart.js or similar -->
                        <div class="h-64 w-full bg-gray-50 border-2 border-dashed border-gray-200 rounded-xl flex items-center justify-center italic text-gray-400">
                            Chart visualization will be rendered here
                        </div>
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
                            <img src="https://www.figma.com/api/mcp/asset/295aa847-aed2-40a1-84a2-6f86fc5e217f" class="w-6 h-6" alt="">
                            <span class="font-semibold text-sm">Add System User</span>
                        </button>
                        <button class="w-full bg-[#f7f9ec] p-3 rounded-lg shadow-sm flex items-center gap-3 hover:bg-[#eef2d8] transition-colors border border-transparent hover:border-[#15803d]">
                            <img src="https://www.figma.com/api/mcp/asset/295aa847-aed2-40a1-84a2-6f86fc5e217f" class="w-6 h-6" alt="">
                            <span class="font-semibold text-sm">Create New Survey</span>
                        </button>
                        <button class="w-full bg-[#f7f9ec] p-3 rounded-lg shadow-sm flex items-center gap-3 hover:bg-[#eef2d8] transition-colors border border-transparent hover:border-[#15803d]">
                            <img src="https://www.figma.com/api/mcp/asset/184e0d6a-f5c6-4cd6-8820-3511cf7438ef" class="w-5 h-5 ml-0.5" alt="">
                            <span class="font-semibold text-sm">Audit Logs</span>
                        </button>
                        <button class="w-full bg-[#f7f9ec] p-3 rounded-lg shadow-sm flex items-center gap-3 hover:bg-[#eef2d8] transition-colors border border-transparent hover:border-[#15803d]">
                            <img src="https://www.figma.com/api/mcp/asset/8bac872c-95d4-43f6-8333-5e3ed146d2bd" class="w-6 h-6" alt="">
                            <span class="font-semibold text-sm">Generate Summary Report</span>
                        </button>
                    </div>
                </div>

                <!-- Audit Log -->
                <div class="bg-white border border-[#15803d] rounded-lg shadow-sm overflow-hidden">
                    <div class="bg-[#15803d] p-4 text-white shadow-md flex justify-between items-center">
                        <h3 class="font-bold text-sm">Audit Log</h3>
                        <a href="#" class="text-[10px] font-medium hover:underline">View All</a>
                    </div>
                    <div class="p-4 space-y-6">
                        @foreach(range(1, 4) as $i)
                        <div class="flex gap-4">
                            <img src="https://www.figma.com/api/mcp/asset/0bbd0c1e-a731-48ab-8b09-4fed4fe7180e" class="w-10 h-10 rounded-full" alt="">
                            <div class="flex-grow">
                                <p class="text-[11px] leading-tight">
                                    <span class="font-semibold">Maria Santos</span>
                                    <span class="font-light">published a new survey</span>
                                </p>
                                <p class="text-[11px] text-[#15803d] font-semibold leading-tight mt-0.5">Evaluation for Community Service in Pachoca for Graduating Students</p>
                                <p class="text-[8px] text-gray-400 mt-1">2 hours ago</p>
                            </div>
                        </div>
                        @endforeach
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
                        @forelse($projects ?? [] as $project)
                            <tr>
                                <td class="px-6 py-4">
                                    <p class="text-[#0c4010] font-semibold text-xs">{{ $project->name }}</p>
                                    <p class="text-[8px] text-[#0c4010] font-light">Project Date: {{ $project->created_at->format('m-d-Y') }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <img src="https://www.figma.com/api/mcp/asset/f5a35d75-9714-4dd7-adf2-4bcacd2d2ee6" class="w-6 h-6" alt="">
                                        <span class="text-xs font-semibold">{{ $project->lead_organizer ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-xs font-semibold text-[#44341d]">{{ $project->events->first()?->community?->name ?? 'N/A' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-xs font-semibold text-black">{{ $project->status ?? 'In Progress' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="#" class="text-[#44341d] font-semibold text-xs flex items-center gap-2 hover:underline">
                                        See Details
                                        <img src="https://www.figma.com/api/mcp/asset/18fd20d8-7256-4f39-8f7f-c9a4933eacd0" class="w-4 h-4" alt="">
                                    </a>
                                </td>
                            </tr>
                        @empty
                            @foreach(range(1, 5) as $i)
                            <tr>
                                <td class="px-6 py-4">
                                    <p class="text-[#0c4010] font-semibold text-xs">Coastal Clean-up Drive</p>
                                    <p class="text-[8px] text-[#0c4010] font-light">Project Date: 05-05-2026</p>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <img src="https://www.figma.com/api/mcp/asset/f5a35d75-9714-4dd7-adf2-4bcacd2d2ee6" class="w-6 h-6" alt="">
                                        <span class="text-xs font-semibold">Mr. Abu Dabi</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-xs font-semibold text-[#44341d]">Mindoro State University</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-xs font-semibold text-black">In Progress</span>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="#" class="text-[#44341d] font-semibold text-xs flex items-center gap-2 hover:underline">
                                        See Details
                                        <img src="https://www.figma.com/api/mcp/asset/18fd20d8-7256-4f39-8f7f-c9a4933eacd0" class="w-4 h-4" alt="">
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
