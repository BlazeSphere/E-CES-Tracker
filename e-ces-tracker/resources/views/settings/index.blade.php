<x-layouts.dashboard>
    <div x-data="{ 
        activeTab: 'schools',
        showSchoolModal: false,
        showCommunityModal: false,
        schoolForm: { id: '', name: '', code: '', description: '' },
        communityForm: { id: '', name: '', code: '', address: '' },
        
        openSchoolModal(school = null) {
            if (school) {
                this.schoolForm = { ...school };
            } else {
                this.schoolForm = { id: '', name: '', code: '', description: '' };
            }
            this.showSchoolModal = true;
        },
        
        openCommunityModal(community = null) {
            if (community) {
                this.communityForm = { ...community };
            } else {
                this.communityForm = { id: '', name: '', code: '', address: '' };
            }
            this.showCommunityModal = true;
        }
    }" class="max-w-7xl mx-auto p-6 space-y-8">
        
        <!-- Header Section -->
        <div>
            <nav class="flex text-sm text-gray-500 mb-2 font-inter">
                <span>System</span>
                <span class="mx-2 text-gray-400">
                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </span>
                <span class="text-[#1b8c00] font-semibold">Settings</span>
            </nav>
            <h1 class="text-4xl md:text-5xl font-bold text-black font-inter">System Settings</h1>
            <p class="text-gray-500 mt-2">Manage organizational entities and community partners.</p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                 class="bg-[#1b8c00] text-white px-6 py-4 rounded-xl shadow-lg flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="text-white/80 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        <!-- Tab System -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="flex border-b border-gray-100">
                <button @click="activeTab = 'schools'" 
                        :class="activeTab === 'schools' ? 'border-b-2 border-[#1b8c00] text-[#1b8c00] font-bold' : 'text-gray-400 font-medium'"
                        class="px-8 py-4 text-sm transition-all hover:bg-gray-50">
                    School Management
                </button>
                <button @click="activeTab = 'communities'" 
                        :class="activeTab === 'communities' ? 'border-b-2 border-[#1b8c00] text-[#1b8c00] font-bold' : 'text-gray-400 font-medium'"
                        class="px-8 py-4 text-sm transition-all hover:bg-gray-50">
                    Adopted Communities
                </button>
            </div>

            <!-- School Management Tab -->
            <div x-show="activeTab === 'schools'" class="p-6 space-y-6">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900 font-inter">Registered Schools</h3>
                    <button @click="openSchoolModal()" class="bg-[#1b8c00] text-white px-4 py-2 rounded-lg text-sm font-bold flex items-center gap-2 hover:bg-[#167000] transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add School
                    </button>
                </div>

                <div class="overflow-x-auto border border-gray-100 rounded-xl">
                    <table class="w-full text-left font-inter">
                        <thead class="bg-gray-50 text-gray-500 uppercase text-[10px] font-bold tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Name</th>
                                <th class="px-6 py-4">Code</th>
                                <th class="px-6 py-4">Description</th>
                                <th class="px-6 py-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            @forelse($schools as $school)
                            <tr class="hover:bg-gray-50/50">
                                <td class="px-6 py-4 font-semibold text-gray-900">{{ $school->name }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $school->code }}</td>
                                <td class="px-6 py-4 text-gray-500 max-w-xs truncate">{{ $school->description ?? 'N/A' }}</td>
                                <td class="px-6 py-4">
                                    <button @click="openSchoolModal({ id: {{ $school->id }}, name: '{{ addslashes($school->name) }}', code: '{{ $school->code }}', description: '{{ addslashes($school->description ?? '') }}' })" 
                                            class="text-[#1b8c00] font-bold hover:underline">
                                        Modify
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="px-6 py-8 text-center text-gray-400 italic">No schools registered yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Adopted Communities Tab -->
            <div x-show="activeTab === 'communities'" class="p-6 space-y-6" x-cloak>
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900 font-inter">Partner Communities</h3>
                    <button @click="openCommunityModal()" class="bg-[#1b8c00] text-white px-4 py-2 rounded-lg text-sm font-bold flex items-center gap-2 hover:bg-[#167000] transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Community
                    </button>
                </div>

                <div class="overflow-x-auto border border-gray-100 rounded-xl">
                    <table class="w-full text-left font-inter">
                        <thead class="bg-gray-50 text-gray-500 uppercase text-[10px] font-bold tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Name</th>
                                <th class="px-6 py-4">Code</th>
                                <th class="px-6 py-4">Address</th>
                                <th class="px-6 py-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            @forelse($communities as $community)
                            <tr class="hover:bg-gray-50/50">
                                <td class="px-6 py-4 font-semibold text-gray-900">{{ $community->name }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $community->code }}</td>
                                <td class="px-6 py-4 text-gray-500 max-w-xs truncate">{{ $community->address }}</td>
                                <td class="px-6 py-4">
                                    <button @click="openCommunityModal({ id: {{ $community->id }}, name: '{{ addslashes($community->name) }}', code: '{{ $community->code }}', address: '{{ addslashes($community->address) }}' })"
                                            class="text-[#1b8c00] font-bold hover:underline">
                                        Modify
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="px-6 py-8 text-center text-gray-400 italic">No communities registered yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- School Modal -->
        <template x-if="showSchoolModal">
            <div class="fixed inset-0 z-[100] overflow-y-auto flex items-center justify-center p-4">
                <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="showSchoolModal = false"></div>
                <div class="relative bg-white rounded-2xl shadow-2xl max-w-lg w-full p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold text-gray-900 font-inter" x-text="schoolForm.id ? 'Modify School' : 'Add New School'"></h3>
                        <button @click="showSchoolModal = false" class="text-gray-400 hover:text-gray-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
                    </div>
                    <form action="{{ route('settings.school.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="id" x-model="schoolForm.id">
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider font-inter">School Name</label>
                            <input type="text" name="name" x-model="schoolForm.name" required class="w-full bg-gray-50 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-[#1b8c00] focus:border-[#1b8c00]">
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider font-inter">Code</label>
                            <input type="text" name="code" x-model="schoolForm.code" required class="w-full bg-gray-50 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-[#1b8c00] focus:border-[#1b8c00]">
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider font-inter">Description</label>
                            <textarea name="description" x-model="schoolForm.description" rows="3" class="w-full bg-gray-50 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-[#1b8c00] focus:border-[#1b8c00]"></textarea>
                        </div>
                        <div class="flex gap-4 pt-4">
                            <button type="button" @click="showSchoolModal = false" class="flex-1 py-3 border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-colors">Cancel</button>
                            <button type="submit" class="flex-1 py-3 bg-[#1b8c00] text-white font-bold rounded-xl hover:bg-[#167000] shadow-md transition-all">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

        <!-- Community Modal -->
        <template x-if="showCommunityModal">
            <div class="fixed inset-0 z-[100] overflow-y-auto flex items-center justify-center p-4">
                <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="showCommunityModal = false"></div>
                <div class="relative bg-white rounded-2xl shadow-2xl max-w-lg w-full p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold text-gray-900 font-inter" x-text="communityForm.id ? 'Modify Community' : 'Add New Community'"></h3>
                        <button @click="showCommunityModal = false" class="text-gray-400 hover:text-gray-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
                    </div>
                    <form action="{{ route('settings.community.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="id" x-model="communityForm.id">
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider font-inter">Community Name</label>
                            <input type="text" name="name" x-model="communityForm.name" required class="w-full bg-gray-50 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-[#1b8c00] focus:border-[#1b8c00]">
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider font-inter">Code</label>
                            <input type="text" name="code" x-model="communityForm.code" required class="w-full bg-gray-50 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-[#1b8c00] focus:border-[#1b8c00]">
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider font-inter">Address</label>
                            <input type="text" name="address" x-model="communityForm.address" required class="w-full bg-gray-50 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-[#1b8c00] focus:border-[#1b8c00]">
                        </div>
                        <div class="flex gap-4 pt-4">
                            <button type="button" @click="showCommunityModal = false" class="flex-1 py-3 border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-colors">Cancel</button>
                            <button type="submit" class="flex-1 py-3 bg-[#1b8c00] text-white font-bold rounded-xl hover:bg-[#167000] shadow-md transition-all">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

    </div>
</x-layouts.dashboard>
