@extends('layout.applicant.app')

@section('title', 'Officer Dashboard')

@section('content')
    <div class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen p-4 md:p-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-slate-900 mb-2">Permit Management Dashboard</h1>
                    <p class="text-slate-600">Manage and evaluate building permit applications</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <button
                        class="px-6 py-2 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition font-medium text-slate-700">
                        📥 Export Reports
                    </button>
                    <button class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                        + New Evaluation
                    </button>
                </div>
            </div>
        </div>

        <!-- Key Statistics -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Applications Card -->
            <div class="bg-white rounded-lg shadow-md border-l-4 border-blue-500 p-6 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-600 text-sm font-medium mb-1">Total Applications</p>
                        <div class="text-3xl font-bold text-slate-900">24</div>
                        <p class="text-xs text-slate-500 mt-2">This month</p>
                    </div>
                    <div class="bg-blue-100 p-4 rounded-full">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pending Evaluation Card -->
            <div class="bg-white rounded-lg shadow-md border-l-4 border-yellow-500 p-6 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-600 text-sm font-medium mb-1">Pending Evaluation</p>
                        <div class="text-3xl font-bold text-slate-900">8</div>
                        <p class="text-xs text-slate-500 mt-2">Awaiting review</p>
                    </div>
                    <div class="bg-yellow-100 p-4 rounded-full">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <a href="#pending" class="text-blue-600 text-sm mt-3 inline-block hover:underline">View applications →</a>
            </div>

            <!-- Approved Card -->
            <div class="bg-white rounded-lg shadow-md border-l-4 border-green-500 p-6 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-600 text-sm font-medium mb-1">Approved Permits</p>
                        <div class="text-3xl font-bold text-slate-900">12</div>
                        <p class="text-xs text-slate-500 mt-2">This month</p>
                    </div>
                    <div class="bg-green-100 p-4 rounded-full">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <a href="#approved" class="text-blue-600 text-sm mt-3 inline-block hover:underline">View permits →</a>
            </div>

            <!-- Rejected Card -->
            <div class="bg-white rounded-lg shadow-md border-l-4 border-red-500 p-6 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-600 text-sm font-medium mb-1">Rejected/Revisions</p>
                        <div class="text-3xl font-bold text-slate-900">4</div>
                        <p class="text-xs text-slate-500 mt-2">Requires action</p>
                    </div>
                    <div class="bg-red-100 p-4 rounded-full">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <a href="#rejected" class="text-blue-600 text-sm mt-3 inline-block hover:underline">View details →</a>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex flex-col md:flex-row gap-4 mb-4">
                <div class="flex-1">
                    <input type="text" placeholder="🔍 Search by Application No., Location, or Applicant Name..."
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <button class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition font-medium">
                    🔽 Advanced Filter
                </button>
            </div>

            <!-- Status Filter Tabs -->
            <div class="flex flex-wrap gap-2 pt-4 border-t border-slate-200">
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium transition hover:bg-blue-700">
                    📊 All (24)
                </button>
                <button
                    class="px-4 py-2 bg-yellow-50 text-yellow-700 border border-yellow-200 rounded-lg hover:bg-yellow-100 transition font-medium">
                    ⏳ Pending (8)
                </button>
                <button
                    class="px-4 py-2 bg-green-50 text-green-700 border border-green-200 rounded-lg hover:bg-green-100 transition font-medium">
                    ✅ Approved (12)
                </button>
                <button
                    class="px-4 py-2 bg-red-50 text-red-700 border border-red-200 rounded-lg hover:bg-red-100 transition font-medium">
                    ❌ Rejected (4)
                </button>
                <button
                    class="px-4 py-2 bg-purple-50 text-purple-700 border border-purple-200 rounded-lg hover:bg-purple-100 transition font-medium">
                    🔄 For Reconsideration (3)
                </button>
            </div>
        </div>

        <!-- Applications Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6 border-b border-slate-200">
                <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Permit Applications
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm" id="example">
                    <thead>
                        <tr class="border-b border-slate-200 bg-slate-50">
                            <th class="px-6 py-4 text-left font-semibold text-slate-700">Application No</th>
                            <th class="px-6 py-4 text-left font-semibold text-slate-700">Applicant Name</th>
                            <th class="px-6 py-4 text-left font-semibold text-slate-700">Project Location</th>
                            <th class="px-6 py-4 text-left font-semibold text-slate-700">Project Type</th>
                            <th class="px-6 py-4 text-left font-semibold text-slate-700">Status</th>
                            <th class="px-6 py-4 text-left font-semibold text-slate-700">Submitted Date</th>
                            <th class="px-6 py-4 text-left font-semibold text-slate-700">Evaluations</th>
                            <th class="px-6 py-4 text-left font-semibold text-slate-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Pending Application -->
                        <tr class="border-b border-slate-200 hover:bg-slate-50 transition">
                            <td class="px-6 py-4 font-medium text-slate-900">BP-2024-001</td>
                            <td class="px-6 py-4 text-slate-700">Juan Dela Cruz</td>
                            <td class="px-6 py-4 text-slate-700">San Ramon, Lapu-Lapu City</td>
                            <td class="px-6 py-4 text-slate-700">
                                <span
                                    class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">Residential
                                    Addition</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">⏳
                                    Pending</span>
                            </td>
                            <td class="px-6 py-4 text-slate-600">Aug 15, 2024</td>
                            <td class="px-6 py-4">
                                <div class="flex gap-1">
                                    <span
                                        class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center text-green-600"
                                        title="Structural">✓</span>
                                    <span
                                        class="w-6 h-6 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600"
                                        title="Safety">○</span>
                                    <span
                                        class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center text-slate-600"
                                        title="Environmental">-</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <button
                                        class="px-3 py-1 text-blue-600 hover:bg-blue-50 rounded border border-blue-200 text-xs font-medium transition">View</button>
                                    <button
                                        class="px-3 py-1 text-green-600 hover:bg-green-50 rounded border border-green-200 text-xs font-medium transition">Evaluate</button>
                                </div>
                            </td>
                        </tr>

                        <!-- Approved Application -->
                        <tr class="border-b border-slate-200 hover:bg-slate-50 transition">
                            <td class="px-6 py-4 font-medium text-slate-900">BP-2024-002</td>
                            <td class="px-6 py-4 text-slate-700">Maria Santos</td>
                            <td class="px-6 py-4 text-slate-700">Pusok, Lapu-Lapu City</td>
                            <td class="px-6 py-4 text-slate-700">
                                <span
                                    class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-xs font-medium">Commercial
                                    Renovation</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">✅
                                    Approved</span>
                            </td>
                            <td class="px-6 py-4 text-slate-600">Aug 10, 2024</td>
                            <td class="px-6 py-4">
                                <div class="flex gap-1">
                                    <span
                                        class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center text-green-600">✓</span>
                                    <span
                                        class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center text-green-600">✓</span>
                                    <span
                                        class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center text-green-600">✓</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <button
                                        class="px-3 py-1 text-blue-600 hover:bg-blue-50 rounded border border-blue-200 text-xs font-medium transition">View</button>
                                    <button
                                        class="px-3 py-1 text-purple-600 hover:bg-purple-50 rounded border border-purple-200 text-xs font-medium transition">Download</button>
                                </div>
                            </td>
                        </tr>

                        <!-- Rejected Application -->
                        <tr class="border-b border-slate-200 hover:bg-slate-50 transition">
                            <td class="px-6 py-4 font-medium text-slate-900">BP-2024-003</td>
                            <td class="px-6 py-4 text-slate-700">Jose Garcia</td>
                            <td class="px-6 py-4 text-slate-700">Mactan, Lapu-Lapu City</td>
                            <td class="px-6 py-4 text-slate-700">
                                <span
                                    class="px-3 py-1 bg-orange-100 text-orange-800 rounded-full text-xs font-medium">High-Rise
                                    Building</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">❌
                                    Rejected</span>
                            </td>
                            <td class="px-6 py-4 text-slate-600">Aug 05, 2024</td>
                            <td class="px-6 py-4">
                                <div class="flex gap-1">
                                    <span
                                        class="w-6 h-6 rounded-full bg-red-100 flex items-center justify-center text-red-600">✗</span>
                                    <span
                                        class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center text-green-600">✓</span>
                                    <span
                                        class="w-6 h-6 rounded-full bg-red-100 flex items-center justify-center text-red-600">✗</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <button
                                        class="px-3 py-1 text-blue-600 hover:bg-blue-50 rounded border border-blue-200 text-xs font-medium transition">View</button>
                                    <button
                                        class="px-3 py-1 text-slate-600 hover:bg-slate-50 rounded border border-slate-200 text-xs font-medium transition">Comments</button>
                                </div>
                            </td>
                        </tr>

                        <!-- For Reconsideration -->
                        <tr class="border-b border-slate-200 hover:bg-slate-50 transition">
                            <td class="px-6 py-4 font-medium text-slate-900">BP-2024-004</td>
                            <td class="px-6 py-4 text-slate-700">Ana Reyes</td>
                            <td class="px-6 py-4 text-slate-700">Opon, Lapu-Lapu City</td>
                            <td class="px-6 py-4 text-slate-700">
                                <span
                                    class="px-3 py-1 bg-teal-100 text-teal-800 rounded-full text-xs font-medium">Mixed-Use
                                    Development</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-semibold">🔄
                                    Reconsidering</span>
                            </td>
                            <td class="px-6 py-4 text-slate-600">Aug 20, 2024</td>
                            <td class="px-6 py-4">
                                <div class="flex gap-1">
                                    <span
                                        class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center text-green-600">✓</span>
                                    <span
                                        class="w-6 h-6 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">◐</span>
                                    <span
                                        class="w-6 h-6 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">◐</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <button
                                        class="px-3 py-1 text-blue-600 hover:bg-blue-50 rounded border border-blue-200 text-xs font-medium transition">View</button>
                                    <button
                                        class="px-3 py-1 text-green-600 hover:bg-green-50 rounded border border-green-200 text-xs font-medium transition">Re-evaluate</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-slate-200 flex items-center justify-between">
                <p class="text-sm text-slate-600">Showing <span class="font-semibold">1 to 4</span> of <span
                        class="font-semibold">24</span> applications</p>
                <div class="flex gap-2">
                    <button class="px-3 py-1 border border-slate-300 rounded hover:bg-slate-50 text-sm font-medium">←
                        Previous</button>
                    <button class="px-3 py-1 bg-blue-600 text-white rounded text-sm font-medium">1</button>
                    <button
                        class="px-3 py-1 border border-slate-300 rounded hover:bg-slate-50 text-sm font-medium">2</button>
                    <button class="px-3 py-1 border border-slate-300 rounded hover:bg-slate-50 text-sm font-medium">Next
                        →</button>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Activity Log -->
            <div class="lg:col-span-2 bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-slate-900 mb-4">Recent Activity</h3>
                <div class="space-y-4">
                    <div class="flex gap-4 pb-4 border-b border-slate-200">
                        <div class="w-2 h-2 bg-green-500 rounded-full mt-2 flex-shrink-0"></div>
                        <div>
                            <p class="font-medium text-slate-900">Application Approved</p>
                            <p class="text-sm text-slate-600">BP-2024-002 by Maria Santos</p>
                            <p class="text-xs text-slate-500">2 hours ago</p>
                        </div>
                    </div>
                    <div class="flex gap-4 pb-4 border-b border-slate-200">
                        <div class="w-2 h-2 bg-yellow-500 rounded-full mt-2 flex-shrink-0"></div>
                        <div>
                            <p class="font-medium text-slate-900">Evaluation Submitted</p>
                            <p class="text-sm text-slate-600">Structural review for BP-2024-001</p>
                            <p class="text-xs text-slate-500">5 hours ago</p>
                        </div>
                    </div>
                    <div class="flex gap-4 pb-4 border-b border-slate-200">
                        <div class="w-2 h-2 bg-red-500 rounded-full mt-2 flex-shrink-0"></div>
                        <div>
                            <p class="font-medium text-slate-900">Application Rejected</p>
                            <p class="text-sm text-slate-600">BP-2024-003 - Non-compliance with building codes</p>
                            <p class="text-xs text-slate-500">1 day ago</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-slate-900 mb-4">Performance Metrics</h3>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-sm font-medium text-slate-700">Avg. Processing Time</span>
                            <span class="text-sm font-bold text-blue-600">8.5 days</span>
                        </div>
                        <div class="w-full bg-slate-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: 75%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-sm font-medium text-slate-700">Approval Rate</span>
                            <span class="text-sm font-bold text-green-600">75%</span>
                        </div>
                        <div class="w-full bg-slate-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" style="width: 75%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-sm font-medium text-slate-700">Completion Rate</span>
                            <span class="text-sm font-bold text-purple-600">92%</span>
                        </div>
                        <div class="w-full bg-slate-200 rounded-full h-2">
                            <div class="bg-purple-600 h-2 rounded-full" style="width: 92%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <script src="{{ asset('asset/js/datatable.js') }}"></script> --}}
@endsection
