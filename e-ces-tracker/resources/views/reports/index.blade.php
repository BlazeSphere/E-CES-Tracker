<x-layouts.dashboard>
    <div class="max-w-7xl mx-auto p-6 space-y-10">
        <!-- Header & Filter Bar Section -->
        <div class="space-y-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <nav class="flex text-sm text-gray-500 mb-2 font-inter">
                        <span>Analytics</span>
                        <span class="mx-2 text-gray-400">
                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                        <span class="text-[#1b8c00] font-semibold">Reports</span>
                    </nav>
                    <h1 class="text-4xl md:text-5xl font-bold text-black font-inter">System Reports</h1>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('reports.pdf') }}" class="bg-white border border-gray-200 px-4 py-2 rounded-lg text-sm font-semibold text-gray-700 flex items-center gap-2 hover:bg-gray-50 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Export PDF
                    </a>
                    <a href="{{ route('reports.excel') }}" class="bg-[#1b8c00] px-4 py-2 rounded-lg text-sm font-bold text-white flex items-center gap-2 hover:bg-[#167000] transition-colors shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Export Excel
                    </a>
                </div>
            </div>

            <!-- Filter Bar -->
            <form action="{{ route('reports.index') }}" method="GET" class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm flex flex-wrap gap-4 items-end">
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider font-inter">Date Range</label>
                    <select name="date_range" class="block w-48 bg-gray-50 border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-[#1b8c00] focus:border-[#1b8c00]">
                        <option value="">Select Range</option>
                        <option value="Last 30 Days" {{ $dateRange == 'Last 30 Days' ? 'selected' : '' }}>Last 30 Days</option>
                        <option value="Last Quarter" {{ $dateRange == 'Last Quarter' ? 'selected' : '' }}>Last Quarter</option>
                        <option value="Current Year" {{ $dateRange == 'Current Year' ? 'selected' : '' }}>Current Year</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider font-inter">Category</label>
                    <select name="category" class="block w-48 bg-gray-50 border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-[#1b8c00] focus:border-[#1b8c00]">
                        <option value="All Projects">All Projects</option>
                        <option value="Outreach" {{ $category == 'Outreach' ? 'selected' : '' }}>Outreach</option>
                        <option value="Environmental" {{ $category == 'Environmental' ? 'selected' : '' }}>Environmental</option>
                        <option value="Educational" {{ $category == 'Educational' ? 'selected' : '' }}>Educational</option>
                        <option value="Health" {{ $category == 'Health' ? 'selected' : '' }}>Health</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider font-inter">Department</label>
                    <select name="department" class="block w-48 bg-gray-50 border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-[#1b8c00] focus:border-[#1b8c00]">
                        <option value="All Departments">All Departments</option>
                        @foreach($schools as $school)
                            <option value="{{ $school->code }}" {{ $department == $school->code ? 'selected' : '' }}>
                                {{ $school->name }} ({{ $school->code }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-6 py-2 rounded-lg text-sm font-bold transition-colors">
                    Apply Filters
                </button>
            </form>
        </div>

        <!-- Summary Cards Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <x-stat-card label="Total Projects" :value="$stats['totalProjects']" icon="projects" />
            <x-stat-card label="Completed Surveys" :value="$stats['completedSurveys']" icon="surveys" />
            <x-stat-card label="Total Volunteers" :value="$stats['totalVolunteers']" icon="volunteers" />
            <x-stat-card label="Active Communities" :value="$stats['activeCommunities']" icon="communities" />
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Project Distribution -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden flex flex-col h-[450px]">
                <div class="bg-[#1b8c00] p-4 text-white">
                    <h3 class="font-bold text-sm font-inter">Project Distribution by Category</h3>
                </div>
                <div class="flex-grow p-8 flex items-center justify-center">
                    <canvas id="projectDistributionChart"></canvas>
                </div>
            </div>

            <!-- Activity Trends -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden flex flex-col h-[450px]">
                <div class="bg-[#1b8c00] p-4 text-white">
                    <h3 class="font-bold text-sm font-inter">Monthly Activity Trends</h3>
                </div>
                <div class="flex-grow p-8 flex items-center justify-center">
                    <canvas id="activityTrendsChart"></canvas>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Pie Chart: Project Distribution
                const pieCtx = document.getElementById('projectDistributionChart').getContext('2d');
                const distData = @json($distributionData);
                
                new Chart(pieCtx, {
                    type: 'pie',
                    data: {
                        labels: distData.map(item => item.category),
                        datasets: [{
                            data: distData.map(item => item.count),
                            backgroundColor: [
                                '#15803d', // Dark Green
                                '#d9f99d', // Light Green
                                '#1b8c00', // Figma Green
                                '#6366f1', // Blue
                                '#f59e0b', // Amber
                                '#ec4899'  // Pink
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    font: { family: 'Inter', size: 12 }
                                }
                            }
                        }
                    }
                });

                // Bar Chart: Activity Trends
                const barCtx = document.getElementById('activityTrendsChart').getContext('2d');
                const monthlyData = @json($monthlyData);

                new Chart(barCtx, {
                    type: 'bar',
                    data: {
                        labels: monthlyData.map(item => item.month),
                        datasets: [{
                            label: 'Projects Started',
                            data: monthlyData.map(item => item.count),
                            backgroundColor: '#d9f99d',
                            borderColor: '#15803d',
                            borderWidth: 1,
                            borderRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { color: '#f3f4f6' },
                                ticks: { stepSize: 1 }
                            },
                            x: {
                                grid: { display: false }
                            }
                        },
                        plugins: {
                            legend: { display: false }
                        }
                    }
                });
            });
        </script>

        <!-- Detailed Report Table -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900 font-inter">Detailed Project Impact Report</h3>
                <span class="text-xs text-gray-500 font-inter">Showing results for {{ date('Y') }} Fiscal Year</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left font-inter">
                    <thead class="bg-gray-50 text-gray-500">
                        <tr>
                            <th class="px-6 py-4 font-bold text-[10px] uppercase tracking-wider">Project Name</th>
                            <th class="px-6 py-4 font-bold text-[10px] uppercase tracking-wider">Department</th>
                            <th class="px-6 py-4 font-bold text-[10px] uppercase tracking-wider">Beneficiaries</th>
                            <th class="px-6 py-4 font-bold text-[10px] uppercase tracking-wider">Completion</th>
                            <th class="px-6 py-4 font-bold text-[10px] uppercase tracking-wider">Impact Score</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($projects as $project)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-bold text-gray-900 text-sm">{{ $project->project_name }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-600 border border-gray-200">
                                    {{ $project->department ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ number_format($project->beneficiaries_count) }} People</td>
                            <td class="px-6 py-4">
                                <div class="w-full bg-gray-100 rounded-full h-1.5 max-w-[100px]">
                                    <div class="bg-[#1b8c00] h-1.5 rounded-full" style="width: {{ $project->completion_percentage }}%"></div>
                                </div>
                                <span class="text-[10px] text-gray-400 mt-1 block">{{ number_format($project->completion_percentage, 0) }}%</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-[#1b8c00]">{{ number_format($project->impact_score, 1) }}/5</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500 italic">No projects found for the current report period.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 text-center">
                <button class="text-sm text-[#1b8c00] font-bold hover:underline">View Full Detailed Analytics</button>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
