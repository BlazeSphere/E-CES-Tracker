<x-layouts.dashboard>
    <div class="max-w-7xl mx-auto p-6 space-y-10">
        <!-- Dashboard Header -->
        <div class="flex justify-between items-end">
            <div>
                <h1 class="text-5xl font-bold text-black font-inter tracking-tight">Dashboard</h1>
                <p class="text-emerald-900 font-semibold text-lg font-inter">Overview and Monitoring</p>
            </div>
            <div class="flex gap-4 mb-2">
                <button class="bg-white border border-gray-200 px-4 py-2 rounded-lg text-xs font-bold flex items-center gap-2 shadow-sm hover:bg-gray-50 transition-colors">
                    <img src="{{ asset('images/icons/audit.png') }}" class="w-4 h-4 opacity-70" alt="">
                    Filter View
                </button>
                <button class="bg-emerald-800 text-white px-4 py-2 rounded-lg text-xs font-bold flex items-center gap-2 shadow-sm hover:bg-emerald-900 transition-colors">
                    <img src="{{ asset('images/icons/plus-circle.png') }}" class="w-4 h-4 brightness-0 invert" alt="">
                    New Project
                </button>
            </div>
        </div>

        <!-- Top Row: 3 Stat cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <x-stat-card label="Active Projects" :value="$activeProjectsCount" trend="2" icon="projects" />
            <x-stat-card label="Communities Reached" :value="$communitiesCount" trend="4" icon="communities" />
            <x-stat-card label="Total Volunteers" :value="$volunteersCount" trend="78" icon="volunteers" />
        </div>

        <!-- Middle Section (2 Columns) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left (w-1/3): 'Active Projects' list -->
            <div class="lg:col-span-4 bg-white border border-emerald-700 rounded-lg shadow-sm overflow-hidden flex flex-col h-[500px]">
                <div class="bg-emerald-900 p-4 text-white flex justify-between items-center shadow-md">
                    <div>
                        <h3 class="font-bold text-sm">Active Projects</h3>
                        <p class="text-[9px] opacity-70">Consolidated survey and project metrics</p>
                    </div>
                    <img src="{{ asset('images/icons/notifications.png') }}" class="w-5 h-5 opacity-70" alt="">
                </div>
                <div class="flex-grow overflow-y-auto divide-y divide-gray-100">
                    @forelse($activeProjectsList as $project)
                    <div class="p-4 hover:bg-emerald-50 transition-colors cursor-pointer group">
                        <div class="flex justify-between items-start mb-1">
                            <span class="text-[8px] text-gray-400 font-medium">{{ $project->created_at->format('l, M d, Y') }}</span>
                            <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 text-[8px] font-bold rounded-full">In Progress</span>
                        </div>
                        <h4 class="text-sm font-bold text-gray-900 group-hover:text-emerald-700 transition-colors">{{ $project->project_name }}</h4>
                        <p class="text-[10px] text-gray-500">{{ $project->location ?? 'Pachoca, Calapan City' }}</p>
                    </div>
                    @empty
                    <div class="p-8 text-center">
                        <p class="text-sm text-gray-400 italic">No active projects found</p>
                    </div>
                    @endforelse
                </div>
                <div class="p-4 bg-gray-50 border-t border-gray-100">
                    <button class="w-full bg-emerald-900 text-white py-2 rounded-lg text-xs font-bold flex items-center justify-center gap-2 hover:bg-black transition-colors">
                        View All Projects
                        <img src="{{ asset('images/icons/chevron-right.png') }}" class="w-4 h-4 brightness-0 invert opacity-70" alt="">
                    </button>
                </div>
            </div>

            <!-- Right (w-2/3): 'Project Details' area -->
            <div class="lg:col-span-8 flex flex-col gap-8">
                <div class="bg-white border border-emerald-400 rounded-lg shadow-sm overflow-hidden flex flex-col flex-grow">
                    <div class="p-8 flex flex-col h-full relative">
                        @if($latestProject)
                        <div class="flex justify-between items-start mb-6">
                            <div class="flex gap-4 items-center">
                                <span class="bg-emerald-200 text-emerald-900 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">CES-Project #{{ str_pad($latestProject->id, 3, '0', STR_PAD_LEFT) }}</span>
                                <span class="text-[10px] text-gray-400 font-medium">Proposed on {{ $latestProject->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex gap-2">
                                <button class="bg-white border border-gray-200 px-4 py-2 rounded text-[10px] font-bold shadow-sm hover:bg-gray-50 transition-colors uppercase">Details</button>
                                <button class="bg-emerald-900 text-white px-4 py-2 rounded text-[10px] font-bold shadow-sm flex items-center gap-2 hover:bg-emerald-950 transition-colors uppercase">
                                    <img src="{{ asset('images/icons/audit.png') }}" class="w-3 h-3 brightness-0 invert opacity-70" alt="">
                                    Update Status
                                </button>
                            </div>
                        </div>

                        <h2 class="text-3xl font-bold text-gray-900 mb-4 tracking-tight">{{ $latestProject->project_name }}</h2>
                        <p class="text-base text-gray-600 mb-10 leading-relaxed font-inter">{{ $latestProject->description }}</p>

                        <div class="mt-auto flex justify-between items-end gap-8">
                            <div class="space-y-6 flex-grow">
                                <h5 class="text-sm font-bold text-gray-900 uppercase tracking-widest border-b border-emerald-100 pb-2">Attendees/Members</h5>
                                <div class="grid grid-cols-2 gap-4">
                                    @foreach($projectMembers as $member)
                                    <div class="flex items-center gap-3 bg-gray-50 p-2 rounded-lg border border-transparent hover:border-emerald-200 transition-colors">
                                        <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-xs font-bold text-emerald-700 shadow-inner">
                                            {{ strtoupper(substr($member->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-gray-900">{{ $member->name }}</p>
                                            <p class="text-[10px] text-emerald-600 font-semibold">Lead Organizer</p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="w-72 bg-emerald-100 rounded-xl p-6 self-stretch flex flex-col border border-emerald-200 shadow-inner">
                                <p class="text-[10px] font-bold text-emerald-900 mb-4 uppercase tracking-widest">Budget Utilization</p>
                                <div class="flex-grow flex items-center justify-center border-2 border-dashed border-emerald-300 rounded-lg bg-emerald-50/50">
                                    <span class="text-[10px] font-bold text-emerald-400 uppercase">Graph/computation</span>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="flex-grow flex items-center justify-center text-gray-400 italic">No active project selected</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Middle Row: Two wide cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white border-2 border-emerald-700 rounded-2xl p-8 shadow-md flex flex-col gap-3 group hover:border-emerald-500 transition-all">
                <h4 class="text-xl font-bold text-gray-900 tracking-tight">Create Survey</h4>
                <p class="text-sm text-gray-500 leading-relaxed mb-6 font-inter">Deploy a new survey to gather community feedback for this project</p>
                <button class="bg-emerald-800 text-emerald-100 text-[10px] font-black py-3 rounded-xl w-40 tracking-widest hover:bg-emerald-900 transition-colors uppercase shadow-sm">LAUNCH BUILDER</button>
            </div>
            <div class="bg-white border-2 border-emerald-700 rounded-2xl p-8 shadow-md flex flex-col gap-3 group hover:border-emerald-500 transition-all">
                <h4 class="text-xl font-bold text-gray-900 tracking-tight">Log Daily Attendance</h4>
                <p class="text-sm text-gray-500 leading-relaxed mb-6 font-inter">Quickly check-in volunteers and field staff for today’s session.</p>
                <button class="bg-emerald-800 text-emerald-100 text-[10px] font-black py-3 rounded-xl w-40 tracking-widest hover:bg-emerald-900 transition-colors uppercase shadow-sm">OPEN CHECK-IN</button>
            </div>
        </div>

        <!-- Bottom Row: 3 'Recent Survey Insights' cards -->
        <div class="space-y-8">
            <div class="flex items-center gap-4 border-b border-gray-100 pb-4">
                <img src="{{ asset('images/icons/stat-surveys.png') }}" class="w-8 h-8" alt="">
                <h3 class="text-2xl font-bold text-gray-900 tracking-tight">Recent Survey Insights</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($recentSurveys as $survey)
                <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-8 flex flex-col relative overflow-hidden group hover:shadow-lg transition-all">
                    <div class="flex justify-between items-start mb-6">
                        <h5 class="text-sm font-bold text-gray-900 w-2/3 leading-snug">{{ $survey->title }}</h5>
                        <div class="bg-white rounded-lg px-3 py-1.5 flex items-center gap-2 shadow-sm border border-emerald-100">
                            <span class="text-xs font-bold text-emerald-900">{{ number_format($survey->satisfaction_score, 1) }}/5.0</span>
                            <img src="{{ asset('images/icons/notifications.png') }}" class="w-3 h-3 opacity-50" alt="">
                        </div>
                    </div>
                    <div class="mt-auto">
                        <p class="text-[10px] font-black text-emerald-900 uppercase mb-2 tracking-widest">Respondents</p>
                        <div class="flex items-end justify-between gap-4">
                            <span class="text-5xl font-black text-emerald-900 tracking-tighter">{{ $survey->respondents_count }}</span>
                            <div class="flex-grow h-2.5 bg-emerald-200 rounded-full overflow-hidden relative shadow-inner">
                                <div class="absolute inset-0 bg-emerald-800 rounded-full" style="width: {{ ($survey->satisfaction_score / 5) * 100 }}%"></div>
                            </div>
                        </div>
                        <p class="text-[10px] font-bold text-emerald-700 mt-3 uppercase tracking-widest">Satisfaction Level</p>
                    </div>
                </div>
                @empty
                <div class="md:col-span-3 py-16 text-center bg-gray-50 rounded-2xl border-2 border-dashed border-emerald-200">
                    <p class="text-gray-400 font-medium font-inter italic">No recent survey data available for your department</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.dashboard>
