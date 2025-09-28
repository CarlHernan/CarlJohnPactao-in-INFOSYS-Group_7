@extends('layouts.master')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Admin Dashboard</h1>
                <p class="text-gray-600">Overview of system activities</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.dashboard.menus') }}" class="px-3 py-2 bg-gray-700 text-white rounded-md text-sm hover:bg-gray-800">Manage Products</a>
                <a href="{{ route('admin.dashboard.orders') }}" class="px-3 py-2 bg-gray-700 text-white rounded-md text-sm hover:bg-gray-800">Manage Orders</a>
                <a href="{{ route('admin.dashboard.reports.sales') }}" class="px-3 py-2 bg-gray-700 text-white rounded-md text-sm hover:bg-gray-800">Reports</a>
            </div>
        </div>

        <!-- Stat Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <p class="text-sm text-gray-500">Pending Orders</p>
                <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $orders['pending'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <p class="text-sm text-gray-500">Processing (Confirmed/Preparing/Ready)</p>
                <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $orders['confirmed'] + $orders['preparing'] + $orders['ready'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <p class="text-sm text-gray-500">Completed (Delivered)</p>
                <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $orders['delivered'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <p class="text-sm text-gray-500">Cancelled Orders</p>
                <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $orders['cancelled'] }}</p>
            </div>
        </div>

        <!-- Secondary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Sales</p>
                        <p class="mt-2 text-3xl font-semibold text-gray-900">₱{{ number_format($totalSales, 2) }}</p>
                    </div>
                </div>
                <div class="mt-6 h-48">
                    <canvas id="miniSalesChart"></canvas>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <p class="text-sm text-gray-500">Total Customers</p>
                <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $totalCustomers }}</p>
                <p class="mt-1 text-sm text-gray-500">Non-admin users</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('miniSalesChart').getContext('2d');
            const labels = @json($chart['labels']);
            const data = @json($chart['data']);
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels,
                    datasets: [{
                        label: 'Revenue (₱)',
                        data,
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true,
                        pointRadius: 0
                    }]
                },
                options: {
                    plugins: { legend: { display: false } },
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: { grid: { display: false } },
                        y: { grid: { display: false } }
                    }
                }
            });
        });
    </script>
@endsection
