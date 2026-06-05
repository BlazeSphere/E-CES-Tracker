<x-layouts.dashboard>
    <div class="max-w-7xl mx-auto p-6 space-y-8" x-data="{ 
        isCreateModalOpen: false, 
        isEditModalOpen: false,
        isViewModalOpen: false,
        editingProject: {
            id: '',
            project_name: '',
            description: '',
            category: 'Outreach',
            status: 'Planned',
            user_id: '',
            department: '',
            budget: 0,
            start_date: '',
            end_date: ''
        },
        viewingProject: {},
        openEditModal(project) {
            this.editingProject = {
                id: project.id,
                project_name: project.project_name,
                description: project.description,
                category: project.category,
                status: project.status,
                user_id: project.user_id,
                department: project.department,
                budget: project.budget,
                start_date: project.start_date,
                end_date: project.end_date
            };
            this.isEditModalOpen = true;
        },
        openViewModal(project) {
            this.viewingProject = project;
            this.isViewModalOpen = true;
        }
    }">
        <!-- Success Toast -->
        @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
             class="fixed bottom-10 right-10 z-[100] bg-emerald-800 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-4 animate-fade-in">
            <div class="bg-white/20 p-2 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
            </div>
            <div>
                <p class="text-xs font-black uppercase tracking-widest opacity-60">System Notification</p>
                <p class="font-bold">{{ session('success') }}</p>
            </div>
            <button @click="show = false" class="ml-4 opacity-40 hover:opacity-100 transition-opacity">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        @endif

        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-4xl font-bold text-black font-inter tracking-tight">Institutional Projects</h1>
                <p class="text-emerald-900 font-semibold text-base font-inter">Manage and monitor your department's community service initiatives.</p>
            </div>
            <button @click="isCreateModalOpen = true" class="bg-emerald-800 text-white px-6 py-3 rounded-xl text-sm font-bold flex items-center gap-2 shadow-lg hover:bg-emerald-900 transition-all transform hover:-translate-y-0.5">
                <img src="{{ asset('images/icons/plus-circle.png') }}" class="w-5 h-5 brightness-0 invert" alt="">
                New Project
            </button>
        </div>

        <!-- Top Stats: 4 Stat cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <x-stat-card label="Total Projects" :value="$stats['total']" trend="2" icon="projects" />
            <x-stat-card label="Completed" :value="$stats['completed']" trend="5" icon="projects" />
            <x-stat-card label="In Progress" :value="$stats['ongoing']" trend="3" icon="projects" />
            <x-stat-card label="Pending/Planned" :value="$stats['pending']" trend="1" icon="projects" />
        </div>

        <!-- Filter Bar -->
        <form action="{{ route('projects.index') }}" method="GET" class="bg-white border border-emerald-100 rounded-2xl p-4 shadow-sm flex flex-wrap gap-4 items-center">
            <div class="flex-grow max-w-md relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </span>
                <input type="text" name="search" value="{{ $search }}" placeholder="Search projects..." class="block w-full pl-10 bg-gray-50 border-emerald-50 rounded-xl py-2.5 text-sm focus:ring-emerald-500 focus:border-emerald-500 font-medium border-2">
            </div>
            
            <div class="flex items-center gap-4">
                <select name="status" class="bg-gray-50 border-emerald-50 rounded-xl px-4 py-2.5 text-sm font-bold text-gray-700 focus:ring-emerald-500 focus:border-emerald-500 border-2">
                    <option value="">All Statuses</option>
                    <option value="Planned" {{ $status == 'Planned' ? 'selected' : '' }}>Planned</option>
                    <option value="In Progress" {{ $status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="Completed" {{ $status == 'Completed' ? 'selected' : '' }}>Completed</option>
                </select>

                <select name="department" class="bg-gray-50 border-emerald-50 rounded-xl px-4 py-2.5 text-sm font-bold text-gray-700 focus:ring-emerald-500 focus:border-emerald-500 border-2">
                    <option value="">All Departments</option>
                    @foreach($schools as $school)
                        <option value="{{ $school->code }}" {{ $department == $school->code ? 'selected' : '' }}>{{ $school->code }}</option>
                    @endforeach
                </select>

                <button type="submit" class="p-2.5 bg-emerald-800 text-white rounded-xl hover:bg-emerald-900 transition-all shadow-md group">
                    <img src="{{ asset('images/icons/audit.png') }}" class="w-5 h-5 brightness-0 invert group-hover:scale-110 transition-transform" alt="Filter">
                </button>
            </div>
        </form>

        <!-- Project Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($projects as $project)
            <div class="bg-gray-50 border border-emerald-100 rounded-3xl overflow-hidden flex flex-col hover:shadow-xl transition-all group hover:-translate-y-1">
                <!-- Card Header -->
                <div class="p-6 pb-4">
                    <div class="flex justify-between items-start mb-4">
                        <span class="inline-flex px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest
                            @switch($project->status)
                                @case('Completed') bg-emerald-100 text-emerald-700 @break
                                @case('In Progress') bg-green-100 text-green-700 @break
                                @case('Planned') bg-yellow-100 text-yellow-700 @break
                                @default bg-gray-200 text-gray-700
                            @endswitch">
                            {{ $project->status }}
                        </span>
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">CES-Project #{{ str_pad($project->id, 3, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 group-hover:text-emerald-800 transition-colors tracking-tight line-clamp-2 h-14">{{ $project->project_name }}</h3>
                </div>

                <!-- Card Body -->
                <div class="px-6 py-4 flex-grow space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-emerald-100 border-2 border-white shadow-sm flex items-center justify-center text-emerald-800 font-black text-sm">
                            {{ strtoupper(substr($project->user->name ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-emerald-600 uppercase tracking-widest mb-0.5">Person in Charge</p>
                            <p class="text-sm font-bold text-gray-800">{{ $project->user->name ?? 'Unassigned' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-white rounded-lg shadow-inner border border-emerald-50">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Project Date</p>
                            <p class="text-xs font-bold text-gray-700">{{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('M d, Y') : 'TBA' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Card Footer -->
                <div class="p-6 bg-white border-t border-emerald-50 flex gap-3">
                    <button @click.prevent="openViewModal({{ json_encode($project) }})" class="flex-grow bg-gray-50 text-gray-700 py-3 rounded-xl text-[10px] font-black text-center uppercase tracking-widest hover:bg-emerald-50 transition-colors border border-emerald-50">
                        View Details
                    </button>
                    <button @click="openEditModal({{ json_encode($project) }})" class="flex-grow bg-emerald-800 text-white py-3 rounded-xl text-[10px] font-black text-center uppercase tracking-widest hover:bg-emerald-900 transition-all shadow-md">
                        Edit Info
                    </button>
                </div>
            </div>
            @empty
            <div class="col-span-full py-24 text-center">
                <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <img src="{{ asset('images/icons/stat-projects.png') }}" class="w-10 h-10 opacity-30" alt="">
                </div>
                <h3 class="text-lg font-bold text-gray-900">No projects discovered</h3>
                <p class="text-sm text-gray-500 mt-1 max-w-xs mx-auto">It looks like your department hasn't registered any community service projects yet.</p>
                <button @click="isCreateModalOpen = true" class="inline-flex mt-8 bg-emerald-800 text-white px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-emerald-900 transition-all shadow-lg">
                    Register First Project
                </button>
            </div>
            @endforelse
        </div>

        @if($projects->hasPages())
        <div class="pt-8">
            {{ $projects->links() }}
        </div>
        @endif

        <!-- Create Project Modal -->
        <div x-show="isCreateModalOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
            <div class="fixed inset-0 z-40 bg-gray-600 bg-opacity-50" x-show="isCreateModalOpen"></div>
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0 relative z-50">

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="isCreateModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <form action="{{ route('projects.store') }}" method="POST">
                        @csrf
                        <div class="bg-emerald-900 p-8 text-white">
                            <h3 class="text-2xl font-bold font-inter tracking-tight">Register New Project</h3>
                            <p class="text-emerald-200 text-xs font-semibold mt-1">Fill in the institutional project parameters</p>
                        </div>
                        <div class="p-8 space-y-6">
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Project Title</label>
                                <input type="text" name="project_name" required class="w-full bg-gray-50 border-2 border-emerald-50 rounded-xl px-4 py-3 text-sm font-bold focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Project Description</label>
                                <textarea name="description" required rows="3" class="w-full bg-gray-50 border-2 border-emerald-50 rounded-xl px-4 py-3 text-sm font-bold focus:ring-emerald-500 focus:border-emerald-500 transition-all"></textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Lead Organizer</label>
                                    <select name="user_id" required class="w-full bg-gray-50 border-2 border-emerald-50 rounded-xl px-4 py-3 text-sm font-bold focus:ring-emerald-500 focus:border-emerald-500">
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Department</label>
                                    <select name="department" required class="w-full bg-gray-50 border-2 border-emerald-50 rounded-xl px-4 py-3 text-sm font-bold focus:ring-emerald-500 focus:border-emerald-500">
                                        @foreach($schools as $school)
                                            <option value="{{ $school->code }}">{{ $school->name }} ({{ $school->code }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Project Category</label>
                                <select name="category" required class="w-full bg-gray-50 border-2 border-emerald-50 rounded-xl px-4 py-3 text-sm font-bold focus:ring-emerald-500 focus:border-emerald-500">
                                    <option value="Outreach">Outreach</option>
                                    <option value="Environmental">Environmental</option>
                                    <option value="Educational">Educational</option>
                                    <option value="Health">Health</option>
                                </select>
                            </div>
                            <div class="grid grid-cols-3 gap-6">
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Initial Status</label>
                                    <select name="status" required class="w-full bg-gray-50 border-2 border-emerald-50 rounded-xl px-4 py-3 text-sm font-bold focus:ring-emerald-500 focus:border-emerald-500">
                                        <option value="Planned">Planned</option>
                                        <option value="In Progress">In Progress</option>
                                        <option value="Completed">Completed</option>
                                    </select>
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Budget Allocation</label>
                                    <input type="number" name="budget" step="0.01" class="w-full bg-gray-50 border-2 border-emerald-50 rounded-xl px-4 py-3 text-sm font-bold focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Start Date</label>
                                    <input type="date" name="start_date" class="w-full bg-gray-50 border-2 border-emerald-50 rounded-xl px-4 py-3 text-sm font-bold focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-8 flex justify-end gap-4 border-t border-gray-100">
                            <button type="button" @click="isCreateModalOpen = false" class="px-6 py-3 text-sm font-bold text-gray-400 uppercase tracking-widest hover:text-gray-600 transition-colors">Discard</button>
                            <button type="submit" class="bg-emerald-800 text-white px-10 py-3 rounded-2xl text-sm font-black shadow-xl hover:bg-emerald-900 transition-all uppercase tracking-widest">Finalize and Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Project Modal -->
        <div x-show="isEditModalOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
            <div class="fixed inset-0 bg-gray-600 bg-opacity-50" x-show="isEditModalOpen" @click="isEditModalOpen = false"></div>
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0 relative z-50">

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="isEditModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <form :action="'/projects/' + editingProject.id" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="bg-emerald-800 p-8 text-white">
                            <h3 class="text-2xl font-bold font-inter tracking-tight">Edit Project Information</h3>
                            <p class="text-emerald-100 text-xs font-semibold mt-1">Updating ID: CES-PRJ-<span x-text="String(editingProject.id).padStart(3, '0')"></span></p>
                        </div>
                        <div class="p-8 space-y-6">
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Project Title</label>
                                <input type="text" name="project_name" required x-model="editingProject.project_name" class="w-full bg-gray-50 border-2 border-emerald-50 rounded-xl px-4 py-3 text-sm font-bold focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Project Description</label>
                                <textarea name="description" required rows="3" x-model="editingProject.description" class="w-full bg-gray-50 border-2 border-emerald-50 rounded-xl px-4 py-3 text-sm font-bold focus:ring-emerald-500 focus:border-emerald-500 transition-all"></textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Lead Organizer</label>
                                    <select name="user_id" required x-model="editingProject.user_id" class="w-full bg-gray-50 border-2 border-emerald-50 rounded-xl px-4 py-3 text-sm font-bold focus:ring-emerald-500 focus:border-emerald-500">
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Department</label>
                                    <select name="department" required x-model="editingProject.department" class="w-full bg-gray-50 border-2 border-emerald-50 rounded-xl px-4 py-3 text-sm font-bold focus:ring-emerald-500 focus:border-emerald-500">
                                        @foreach($schools as $school)
                                            <option value="{{ $school->code }}">{{ $school->name }} ({{ $school->code }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Project Category</label>
                                <select name="category" required x-model="editingProject.category" class="w-full bg-gray-50 border-2 border-emerald-50 rounded-xl px-4 py-3 text-sm font-bold focus:ring-emerald-500 focus:border-emerald-500">
                                    <option value="Outreach">Outreach</option>
                                    <option value="Environmental">Environmental</option>
                                    <option value="Educational">Educational</option>
                                    <option value="Health">Health</option>
                                </select>
                            </div>
                            <div class="grid grid-cols-3 gap-6">
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</label>
                                    <select name="status" required x-model="editingProject.status" class="w-full bg-gray-50 border-2 border-emerald-50 rounded-xl px-4 py-3 text-sm font-bold focus:ring-emerald-500 focus:border-emerald-500">
                                        <option value="Planned">Planned</option>
                                        <option value="In Progress">In Progress</option>
                                        <option value="Completed">Completed</option>
                                    </select>
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Budget Allocation</label>
                                    <input type="number" name="budget" step="0.01" x-model="editingProject.budget" class="w-full bg-gray-50 border-2 border-emerald-50 rounded-xl px-4 py-3 text-sm font-bold focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Start Date</label>
                                    <input type="date" name="start_date" x-model="editingProject.start_date" class="w-full bg-gray-50 border-2 border-emerald-50 rounded-xl px-4 py-3 text-sm font-bold focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-8 flex justify-end gap-4 border-t border-gray-100">
                            <button type="button" @click="isEditModalOpen = false" class="px-6 py-3 text-sm font-bold text-gray-400 uppercase tracking-widest hover:text-gray-600 transition-colors">Discard</button>
                            <button type="submit" class="bg-emerald-800 text-white px-10 py-3 rounded-2xl text-sm font-black shadow-xl hover:bg-emerald-900 transition-all uppercase tracking-widest">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- View Project Modal -->
        <div x-show="isViewModalOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
            <div class="fixed inset-0 bg-gray-600 bg-opacity-50" x-show="isViewModalOpen" @click="isViewModalOpen = false"></div>
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0 relative z-50">

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="isViewModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    
                    <!-- Header -->
                    <div class="bg-emerald-800 p-8 text-white flex justify-between items-start">
                        <div>
                            <h3 class="text-3xl font-bold font-inter tracking-tight" x-text="viewingProject.project_name"></h3>
                            <p class="text-emerald-100 text-sm font-semibold mt-2">CES-Project #<span x-text="String(viewingProject.id).padStart(3, '0')"></span></p>
                        </div>
                    </div>
                    
                    <!-- Body: 2 Column Grid -->
                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Description</p>
                                <p class="text-gray-800 text-lg leading-relaxed font-medium" x-text="viewingProject.description"></p>
                            </div>
                            <div class="flex gap-6">
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Category</p>
                                    <p class="font-bold text-gray-900" x-text="viewingProject.category"></p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Department</p>
                                    <p class="font-bold text-gray-900" x-text="viewingProject.department"></p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Column -->
                        <div class="bg-gray-50 p-6 rounded-2xl border border-emerald-50 space-y-6">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1">Status</p>
                                    <span class="inline-flex px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest"
                                          :class="{
                                              'bg-emerald-100 text-emerald-700': viewingProject.status === 'Completed',
                                              'bg-green-100 text-green-700': viewingProject.status === 'In Progress',
                                              'bg-yellow-100 text-yellow-700': viewingProject.status === 'Planned'
                                          }" x-text="viewingProject.status">
                                    </span>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 text-right">Lead Organizer</p>
                                    <p class="font-bold text-gray-900 text-right" x-text="viewingProject.user ? viewingProject.user.name : 'Unassigned'"></p>
                                </div>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Budget Allocation</p>
                                <p class="font-bold text-gray-900 text-xl">₱<span x-text="Number(viewingProject.budget).toLocaleString(undefined, {minimumFractionDigits: 2})"></span></p>
                            </div>
                            <div class="flex gap-6 border-t border-gray-200 pt-4">
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Start Date</p>
                                    <p class="font-bold text-gray-900" x-text="viewingProject.start_date ? viewingProject.start_date : 'TBA'"></p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">End Date</p>
                                    <p class="font-bold text-gray-900" x-text="viewingProject.end_date ? viewingProject.end_date : 'TBA'"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Footer Actions -->
                    <div class="bg-gray-50 p-8 flex justify-end gap-4 border-t border-gray-100">
                        <button type="button" @click="isViewModalOpen = false" class="px-6 py-3 text-sm font-bold text-gray-400 uppercase tracking-widest hover:text-gray-600 transition-colors">Close</button>
                        <button type="button" @click="isViewModalOpen = false; openEditModal(viewingProject)" class="bg-emerald-800 text-white px-10 py-3 rounded-2xl text-sm font-black shadow-xl hover:bg-emerald-900 transition-all uppercase tracking-widest flex items-center gap-2">
                            Edit Project
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .animate-fade-in {
            animation: fadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</x-layouts.dashboard>
