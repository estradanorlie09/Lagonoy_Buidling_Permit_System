@extends('layout.applicant.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="min-h-screen p-6 bg-gray-100">
        <h1 class="text-3xl font-bold mb-6 text-red-600 flex items-center">
            <i class="fas fa-tachometer-alt mr-3"></i> Admin Dashboard
        </h1>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div class="flex items-center gap-4 bg-red-50 rounded-xl p-5 shadow border border-red-100">
                <div class="p-3 bg-red-100 text-red-600 rounded-lg"><i class="fas fa-users text-2xl"></i></div>
                <div>
                    <p class="text-sm text-gray-500">Total Users</p>
                    <h3 class="text-xl font-bold text-gray-800">{{ $records->count() }}</h3>
                </div>
            </div>

            <div class="flex items-center gap-4 bg-green-50 rounded-xl p-5 shadow border border-green-100">
                <div class="p-3 bg-green-100 text-green-600 rounded-lg"><i class="fas fa-user-edit text-2xl"></i></div>
                <div>
                    <p class="text-sm text-gray-500">Applicants</p>
                    <h3 class="text-xl font-bold text-gray-800">{{ $records->where('role', 'applicant')->count() }}</h3>
                </div>
            </div>

            <div class="flex items-center gap-4 bg-blue-50 rounded-xl p-5 shadow border border-blue-100">
                <div class="p-3 bg-blue-100 text-blue-600 rounded-lg"><i class="fas fa-map-marked-alt text-2xl"></i></div>
                <div>
                    <p class="text-sm text-gray-500">Zoning Officers</p>
                    <h3 class="text-xl font-bold text-gray-800">{{ $records->where('role', 'zoning_officer')->count() }}
                    </h3>
                </div>
            </div>

            <div class="flex items-center gap-4 bg-violet-50 rounded-xl p-5 shadow border border-violet-100">
                <div class="p-3 bg-violet-100 text-violet-600 rounded-lg"><i class="fas fa-hard-hat text-2xl"></i></div>
                <div>
                    <p class="text-sm text-gray-500">OBO Officers</p>
                    <h3 class="text-xl font-bold text-gray-800">{{ $records->where('role', 'obo')->count() }}</h3>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white shadow rounded-lg p-4 chart-container">
                <h2 class="text-lg font-semibold mb-3 text-gray-700">Users by Role</h2>
                <canvas id="usersByRoleChart"></canvas>
            </div>

            <div class="bg-white shadow rounded-lg p-4 chart-container">
                <h2 class="text-lg font-semibold mb-3 text-gray-700">Applicants by City</h2>
                <canvas id="applicantsByCityChart"></canvas>
            </div>

            <div class="bg-white shadow rounded-lg p-4 chart-container">
                <h2 class="text-lg font-semibold mb-3 text-gray-700">User Growth Over Time</h2>
                <canvas id="userGrowthChart"></canvas>
            </div>
        </div>

    </div>
    <!-- Charts Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white shadow rounded-lg p-4 chart-container">
            <h2 class="text-lg font-semibold mb-3 text-gray-700">Building Applications</h2>
            <canvas id="buildingChart"></canvas>
        </div>

        <div class="bg-white shadow rounded-lg p-4 chart-container">
            <h2 class="text-lg font-semibold mb-3 text-gray-700">Zoning</h2>
            <canvas id="zoningChart"></canvas>
        </div>

        <div class="bg-white shadow rounded-lg p-4 chart-container">
            <h2 class="text-lg font-semibold mb-3 text-gray-700">Sanitary</h2>
            <canvas id="sanitaryChart"></canvas>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Compact Chart Styling -->
    <style>
        .chart-container {
            height: 250px;
            /* Compact height */
            position: relative;
        }

        canvas {
            max-height: 200px !important;
            /* Prevent oversized canvas */
        }
    </style>

    <script>
        const chartOptions = {
            responsive: true,
            maintainAspectRatio: true, // keep chart compact
            plugins: {
                legend: {
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        };

        // Users by Role
        new Chart(document.getElementById('usersByRoleChart'), {
            type: 'bar',
            data: {
                labels: @json($roles),
                datasets: [{
                    label: 'Users',
                    data: @json($counts->values()),
                    backgroundColor: ['#ef4444cc', '#3b82f6cc', '#facc15cc', '#10b981cc', '#8b5cf6cc'],
                    borderRadius: 6
                }]
            },
            options: chartOptions
        });

        // Applicants by City
        new Chart(document.getElementById('applicantsByCityChart'), {
            type: 'doughnut',
            data: {
                labels: @json($cities),
                datasets: [{
                    label: 'Applicants',
                    data: @json($cityCounts->values()),
                    backgroundColor: ['#ef4444cc', '#3b82f6cc', '#facc15cc', '#10b981cc', '#8b5cf6cc'],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true
            }
        });

        // User Growth
        new Chart(document.getElementById('userGrowthChart'), {
            type: 'line',
            data: {
                labels: @json($months),
                datasets: [{
                    label: 'New Users',
                    data: @json($monthlyCounts),
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59,130,246,0.2)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: chartOptions
        });
    </script>
    <script>
        const chartOptions = {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        };

        // Building Applications Chart
        new Chart(document.getElementById('buildingChart'), {
            type: 'bar',
            data: {
                labels: ['Applicants'],
                datasets: [{
                    label: 'Building Applications',
                    data: [{{ $records->where('role', 'applicant')->count() }}],
                    backgroundColor: '#ef4444cc',
                    borderRadius: 6
                }]
            },
            options: chartOptions
        });

        // Zoning Chart
        new Chart(document.getElementById('zoningChart'), {
            type: 'bar',
            data: {
                labels: ['Zoning Officers'],
                datasets: [{
                    label: 'Zoning',
                    data: [{{ $records->where('role', 'zoning_officer')->count() }}],
                    backgroundColor: '#3b82f6cc',
                    borderRadius: 6
                }]
            },
            options: chartOptions
        });

        // Sanitary Chart
        new Chart(document.getElementById('sanitaryChart'), {
            type: 'bar',
            data: {
                labels: ['Sanitary Officers'],
                datasets: [{
                    label: 'Sanitary',
                    data: [{{ $records->where('role', 'sanitary_officer')->count() }}],
                    backgroundColor: '#facc15cc',
                    borderRadius: 6
                }]
            },
            options: chartOptions
        });
    </script>
@endsection
