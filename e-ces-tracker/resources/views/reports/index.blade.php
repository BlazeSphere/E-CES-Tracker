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
            <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm flex flex-wrap gap-4 items-end">
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider font-inter">Date Range</label>
                    <select class="block w-48 bg-gray-50 border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-[#1b8c00] focus:border-[#1b8c00]">
                        <option>Last 30 Days</option>
                        <option>Last Quarter</option>
                        <option>Current Year</option>
                        <option>Custom Range</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider font-inter">Category</label>
                    <select class="block w-48 bg-gray-50 border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-[#1b8c00] focus:border-[#1b8c00]">
                        <option>All Projects</option>
                        <option>Outreach</option>
                        <option>Environmental</option>
                        <option>Educational</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider font-inter">Department</label>
                    <select class="block w-48 bg-gray-50 border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-[#1b8c00] focus:border-[#1b8c00]">
                        <option>All Departments</option>
                        <option>CS Department</option>
                        <option>Nursing Department</option>
                        <option>Business Department</option>
                    </select>
                </div>
                <button class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-6 py-2 rounded-lg text-sm font-bold transition-colors">
                    Apply Filters
                </button>
            </div>
        </div>

        <!-- Summary Cards Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <x-stat-card label="Total Projects" value="124" trend="12" icon="projects" />
            <x-stat-card label="Completed Surveys" value="850" trend="8" icon="surveys" />
            <x-stat-card label="Total Volunteers" value="1,205" trend="15" icon="volunteers" />
            <x-stat-card label="Active Communities" value="12" trend="2" icon="communities" />
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
                new Chart(pieCtx, {
                    type: 'pie',
                    data: {
                        labels: ['Outreach', 'Environmental', 'Educational', 'Health'],
                        datasets: [{
                            data: [40, 25, 20, 15],
                            backgroundColor: [
                                '#15803d', // Dark Green
                                '#d9f99d', // Light Green
                                '#1b8c00', // Figma Green
                                '#f0f3f5'  // Neutral Gray
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
                new Chart(barCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        datasets: [{
                            label: 'Surveys Conducted',
                            data: [45, 59, 80, 81, 56, 55, 40, 95, 75, 60, 85, 100],
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
                                grid: { color: '#f3f4f6' }
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
                <span class="text-xs text-gray-500 font-inter">Showing results for 2026 Fiscal Year</span>
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
                        @foreach([
                            ['Coastal Clean-up', 'CS Dept', '150 Households', '100%', '4.8/5'],
                            ['Literacy Program', 'Education', '85 Students', '75%', '4.5/5'],
                            ['Health Caravan', 'Nursing', '300 Seniors', '100%', '4.9/5'],
                            ['Waste Management', 'Engineering', '12 Barangays', '40%', '4.2/5']
                        ] as $row)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-bold text-gray-900 text-sm">{{ $row[0] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $row[1] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $row[2] }}</td>
                            <td class="px-6 py-4">
                                <div class="w-full bg-gray-100 rounded-full h-1.5 max-w-[100px]">
                                    <div class="bg-[#1b8c00] h-1.5 rounded-full" style="width: {{ $row[3] }}"></div>
                                </div>
                                <span class="text-[10px] text-gray-400 mt-1 block">{{ $row[3] }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-[#1b8c00]">{{ $row[4] }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 text-center">
                <button class="text-sm text-[#1b8c00] font-bold hover:underline">View Full Detailed Analytics</button>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
