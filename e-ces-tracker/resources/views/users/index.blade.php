<x-layouts.dashboard>
    <div x-data="{ 
        showAddUserModal: {{ $errors->any() && !old('edit_user_id') ? 'true' : 'false' }}, 
        showEditUserModal: {{ $errors->any() && old('edit_user_id') ? 'true' : 'false' }},
        password: '',
        editUser: {
            id: '{{ old('edit_user_id', '') }}',
            name: '{{ old('name', '') }}',
            email: '{{ old('email', '') }}',
            role: '{{ old('role', '') }}',
            status: '{{ old('status', 'active') }}'
        },
        openEditModal(user) {
            this.editUser = { ...user };
            this.showEditUserModal = true;
        },
        generatePassword() {
            const chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
            let generated = '';
            for (let i = 0; i < 12; i++) {
                generated += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            this.password = generated;
        }
    }" class="max-w-7xl mx-auto p-6 space-y-10">
        <!-- Success Message -->
        @if(session('success'))
            <div x-data="{ show: true }" 
                 x-show="show" 
                 x-init="setTimeout(() => show = false, 5000)"
                 class="fixed top-24 right-6 z-[110] bg-[#1b8c00] text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-4 transition-all"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-x-8"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-x-0"
                 x-transition:leave-end="opacity-0 translate-x-8">
                <div class="bg-white/20 p-2 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <span class="font-bold text-sm">{{ session('success') }}</span>
                <button @click="show = false" class="text-white/60 hover:text-white">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

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
                <button @click="showAddUserModal = true" class="bg-[#1b8c00] px-6 py-2.5 rounded-lg text-sm font-bold text-white flex items-center gap-2 hover:bg-[#167000] transition-colors shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add User
                </button>
            </div>
        </div>

        <!-- Add User Modal -->
        <div x-show="showAddUserModal" 
             class="fixed inset-0 z-[100] overflow-y-auto" 
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="flex items-center justify-center min-h-screen p-4">
                <!-- Overlay -->
                <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="showAddUserModal = false"></div>

                <!-- Modal Content -->
                <div class="relative bg-white rounded-2xl shadow-2xl max-w-lg w-full p-8 overflow-hidden transform transition-all"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-95 translate-y-4">
                    
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 font-inter">Add New System User</h3>
                        <button @click="showAddUserModal = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest font-inter">Full Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" required class="block w-full bg-gray-50 border-gray-200 text-gray-900 text-sm rounded-xl px-4 py-3 focus:ring-[#1b8c00] focus:border-[#1b8c00] transition-all" placeholder="Enter full name">
                            <x-input-error :messages="$errors->get('name')" />
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest font-inter">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" required class="block w-full bg-gray-50 border-gray-200 text-gray-900 text-sm rounded-xl px-4 py-3 focus:ring-[#1b8c00] focus:border-[#1b8c00] transition-all" placeholder="name@dwcc.edu.ph">
                            <x-input-error :messages="$errors->get('email')" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest font-inter">Role</label>
                                <select name="role" required class="block w-full bg-gray-50 border-gray-200 text-gray-900 text-sm rounded-xl px-4 py-3 focus:ring-[#1b8c00] focus:border-[#1b8c00] transition-all">
                                    <option value="1" {{ old('role') == '1' ? 'selected' : '' }}>Admin</option>
                                    <option value="0" {{ old('role') == '0' ? 'selected' : '' }}>Super Admin</option>
                                </select>
                                <x-input-error :messages="$errors->get('role')" />
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest font-inter">Status</label>
                                <select name="status" required class="block w-full bg-gray-50 border-gray-200 text-gray-900 text-sm rounded-xl px-4 py-3 focus:ring-[#1b8c00] focus:border-[#1b8c00] transition-all">
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" />
                            </div>
                        </div>

                        <div x-data="{ showPassword: false }" class="space-y-6">
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest font-inter">Password</label>
                                <div class="relative">
                                    <input :type="showPassword ? 'text' : 'password'" 
                                           name="password" 
                                           x-model="password"
                                           required 
                                           class="block w-full bg-gray-50 border-gray-200 text-gray-900 text-sm rounded-xl px-4 py-3 focus:ring-[#1b8c00] focus:border-[#1b8c00] transition-all pr-32" 
                                           placeholder="••••••••">
                                    <div class="absolute right-2 top-2 bottom-2 flex gap-1">
                                        <button type="button" 
                                                @click="showPassword = !showPassword"
                                                class="px-2 text-gray-400 hover:text-[#1b8c00] transition-colors flex items-center justify-center"
                                                :class="showPassword ? 'text-[#1b8c00]' : ''">
                                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                            </svg>
                                        </button>
                                        <button type="button" 
                                                @click="generatePassword()"
                                                class="px-3 bg-[#d9f99d] text-[#15803d] text-[10px] font-bold rounded-lg hover:bg-[#cde98e] transition-colors uppercase tracking-tighter">
                                            Generate
                                        </button>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('password')" />
                            </div>

                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest font-inter">Confirm Password</label>
                                <div class="relative">
                                    <input :type="showPassword ? 'text' : 'password'" 
                                           name="password_confirmation" 
                                           required 
                                           class="block w-full bg-gray-50 border-gray-200 text-gray-900 text-sm rounded-xl px-4 py-3 focus:ring-[#1b8c00] focus:border-[#1b8c00] transition-all pr-12" 
                                           placeholder="••••••••">
                                    <button type="button" 
                                            @click="showPassword = !showPassword"
                                            class="absolute right-2 top-2 bottom-2 px-3 text-gray-400 hover:text-[#1b8c00] transition-colors flex items-center justify-center"
                                            :class="showPassword ? 'text-[#1b8c00]' : ''">
                                        <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-4 pt-4">
                            <button type="button" @click="showAddUserModal = false" class="flex-1 px-6 py-3 border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-colors">
                                Cancel
                            </button>
                            <button type="submit" class="flex-1 px-6 py-3 bg-[#1b8c00] text-white font-bold rounded-xl hover:bg-[#167000] shadow-lg shadow-green-900/20 transition-all">
                                Save User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit User Modal -->
        <div x-show="showEditUserModal" 
             class="fixed inset-0 z-[100] overflow-y-auto" 
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="flex items-center justify-center min-h-screen p-4">
                <!-- Overlay -->
                <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="showEditUserModal = false"></div>

                <!-- Modal Content -->
                <div class="relative bg-white rounded-2xl shadow-2xl max-w-lg w-full p-8 overflow-hidden transform transition-all"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-95 translate-y-4">
                    
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 font-inter">Edit System User</h3>
                        <button @click="showEditUserModal = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form :action="`/users/${editUser.id}`" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="edit_user_id" :value="editUser.id">
                        
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest font-inter">Full Name</label>
                            <input type="text" name="name" x-model="editUser.name" required class="block w-full bg-gray-50 border-gray-200 text-gray-900 text-sm rounded-xl px-4 py-3 focus:ring-[#1b8c00] focus:border-[#1b8c00] transition-all" placeholder="Enter full name">
                            <x-input-error :messages="$errors->get('name')" />
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest font-inter">Email Address</label>
                            <input type="email" name="email" x-model="editUser.email" required class="block w-full bg-gray-50 border-gray-200 text-gray-900 text-sm rounded-xl px-4 py-3 focus:ring-[#1b8c00] focus:border-[#1b8c00] transition-all" placeholder="name@dwcc.edu.ph">
                            <x-input-error :messages="$errors->get('email')" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest font-inter">Role</label>
                                <select name="role" x-model="editUser.role" required class="block w-full bg-gray-50 border-gray-200 text-gray-900 text-sm rounded-xl px-4 py-3 focus:ring-[#1b8c00] focus:border-[#1b8c00] transition-all">
                                    <option value="1">Admin</option>
                                    <option value="0">Super Admin</option>
                                </select>
                                <x-input-error :messages="$errors->get('role')" />
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest font-inter">Status</label>
                                <select name="status" x-model="editUser.status" required class="block w-full bg-gray-50 border-gray-200 text-gray-900 text-sm rounded-xl px-4 py-3 focus:ring-[#1b8c00] focus:border-[#1b8c00] transition-all">
                                    <option value="active">Active</option>
                                    <option value="inactive">Deactivated</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" />
                            </div>
                        </div>

                        <div x-data="{ showPassword: false }" class="space-y-6">
                            <div class="bg-blue-50 p-4 rounded-xl border border-blue-100 flex gap-3">
                                <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-[10px] text-blue-700 font-medium">Leave password fields blank to keep the current password.</p>
                            </div>

                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest font-inter">New Password</label>
                                <div class="relative">
                                    <input :type="showPassword ? 'text' : 'password'" 
                                           name="password" 
                                           class="block w-full bg-gray-50 border-gray-200 text-gray-900 text-sm rounded-xl px-4 py-3 focus:ring-[#1b8c00] focus:border-[#1b8c00] transition-all pr-12" 
                                           placeholder="••••••••">
                                    <button type="button" 
                                            @click="showPassword = !showPassword"
                                            class="absolute right-2 top-2 bottom-2 px-3 text-gray-400 hover:text-[#1b8c00] transition-colors flex items-center justify-center"
                                            :class="showPassword ? 'text-[#1b8c00]' : ''">
                                        <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                        </svg>
                                    </button>
                                </div>
                                <x-input-error :messages="$errors->get('password')" />
                            </div>

                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest font-inter">Confirm New Password</label>
                                <div class="relative">
                                    <input :type="showPassword ? 'text' : 'password'" 
                                           name="password_confirmation" 
                                           class="block w-full bg-gray-50 border-gray-200 text-gray-900 text-sm rounded-xl px-4 py-3 focus:ring-[#1b8c00] focus:border-[#1b8c00] transition-all pr-12" 
                                           placeholder="••••••••">
                                    <button type="button" 
                                            @click="showPassword = !showPassword"
                                            class="absolute right-2 top-2 bottom-2 px-3 text-gray-400 hover:text-[#1b8c00] transition-colors flex items-center justify-center"
                                            :class="showPassword ? 'text-[#1b8c00]' : ''">
                                        <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-4 pt-4">
                            <button type="button" @click="showEditUserModal = false" class="flex-1 px-6 py-3 border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-colors">
                                Cancel
                            </button>
                            <button type="submit" class="flex-1 px-6 py-3 bg-[#1b8c00] text-white font-bold rounded-xl hover:bg-[#167000] shadow-lg shadow-green-900/20 transition-all">
                                Update User
                            </button>
                        </div>
                    </form>
                </div>
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
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $user->status === 'active' ? 'bg-[#d9f99d] text-[#1b8c00]' : 'bg-red-100 text-red-700' }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <button @click="openEditModal({ 
                                            id: {{ $user->id }}, 
                                            name: '{{ addslashes($user->name) }}', 
                                            email: '{{ $user->email }}', 
                                            role: {{ $user->role }}, 
                                            status: '{{ $user->status }}' 
                                        })" 
                                        class="text-[#1b8c00] font-bold text-sm hover:underline">
                                    Edit
                                </button>
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
