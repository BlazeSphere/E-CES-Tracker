<x-layouts.dashboard>
    <div class="max-w-7xl mx-auto p-6 space-y-8">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-4xl font-bold text-black font-inter tracking-tight">Survey Management</h1>
                <p class="text-emerald-900 font-semibold text-base font-inter">Manage and monitor community assessments for your department.</p>
            </div>
            <a href="{{ route('surveys.create') }}" class="bg-emerald-800 text-white px-6 py-3 rounded-xl text-sm font-bold flex items-center gap-2 shadow-lg hover:bg-emerald-900 transition-all transform hover:-translate-y-0.5">
                <img src="{{ asset('images/icons/plus-circle.png') }}" class="w-5 h-5 brightness-0 invert" alt="">
                Create New Survey
            </a>
        </div>

        <!-- Survey List Card -->
        <div class="bg-white border border-emerald-100 rounded-2xl shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900 font-inter">Recent Surveys</h3>
                <span class="text-xs text-gray-500 font-medium font-inter">Total: {{ $surveys->total() }} Surveys</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left font-inter">
                    <thead class="bg-white border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 font-bold text-[10px] text-gray-400 uppercase tracking-widest">Survey Details</th>
                            <th class="px-6 py-4 font-bold text-[10px] text-gray-400 uppercase tracking-widest">Status</th>
                            <th class="px-6 py-4 font-bold text-[10px] text-gray-400 uppercase tracking-widest">Questions</th>
                            <th class="px-6 py-4 font-bold text-[10px] text-gray-400 uppercase tracking-widest">Created Date</th>
                            <th class="px-6 py-4 font-bold text-[10px] text-gray-400 uppercase tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($surveys as $survey)
                        <tr class="hover:bg-emerald-50/30 transition-colors group">
                            <td class="px-6 py-5">
                                <p class="text-sm font-bold text-gray-900 group-hover:text-emerald-800 transition-colors">{{ $survey->title }}</p>
                                <p class="text-xs text-gray-500 line-clamp-1 mt-0.5">{{ $survey->description ?? 'No description provided' }}</p>
                            </td>
                            <td class="px-6 py-5">
                                <span class="inline-flex px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest
                                    @switch($survey->status)
                                        @case('active') bg-emerald-100 text-emerald-700 @break
                                        @case('closed') bg-red-100 text-red-700 @break
                                        @default bg-gray-100 text-gray-600
                                    @endswitch">
                                    {{ $survey->status }}
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-bold text-gray-700">{{ $survey->questions_count ?? 0 }}</span>
                                    <span class="text-[10px] text-gray-400 font-medium">Fields</span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <span class="text-xs text-gray-600 font-medium">{{ $survey->created_at->format('M d, Y') }}</span>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex justify-end items-center gap-3">
                                    <a href="{{ route('surveys.show', $survey) }}" class="p-2 hover:bg-white rounded-lg transition-colors group/btn shadow-sm border border-transparent hover:border-emerald-200" title="View Results">
                                        <img src="{{ asset('images/icons/trend-up.png') }}" class="w-4 h-4 opacity-60 group-hover/btn:opacity-100" alt="">
                                    </a>
                                    <a href="{{ route('surveys.edit', $survey) }}" class="p-2 hover:bg-white rounded-lg transition-colors group/btn shadow-sm border border-transparent hover:border-emerald-200" title="Edit Survey">
                                        <img src="{{ asset('images/icons/settings.png') }}" class="w-4 h-4 opacity-60 group-hover/btn:opacity-100" alt="">
                                    </a>
                                    <form action="{{ route('surveys.destroy', $survey) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this survey?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 hover:bg-red-50 rounded-lg transition-colors group/btn shadow-sm border border-transparent hover:border-red-200" title="Delete">
                                            <svg class="w-4 h-4 text-gray-400 group-hover/btn:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center">
                                <div class="max-w-xs mx-auto space-y-4">
                                    <div class="w-16 h-16 bg-emerald-50 rounded-full flex items-center justify-center mx-auto">
                                        <img src="{{ asset('images/icons/stat-surveys.png') }}" class="w-8 h-8 opacity-40" alt="">
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-900">No surveys found</p>
                                        <p class="text-xs text-gray-500 mt-1">Get started by creating your first community assessment survey.</p>
                                    </div>
                                    <a href="{{ route('surveys.create') }}" class="inline-flex items-center text-xs font-bold text-emerald-700 hover:underline">
                                        Create New Survey &rarr;
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($surveys->hasPages())
            <div class="p-6 bg-gray-50/50 border-t border-gray-100">
                {{ $surveys->links() }}
            </div>
            @endif
        </div>
    </div>
</x-layouts.dashboard>
