@extends('admin.layouts.app')

@section('title', 'Reports & Analytics')

@section('content')
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">📊 Reports & Analytics</h1>
            <p class="text-gray-600">Comprehensive business insights and performance metrics</p>
        </div>
        
        <!-- Date Range Filter -->
        <div class="mt-4 sm:mt-0">
            <form method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex items-center space-x-2">
                    <label class="text-sm font-medium text-gray-700">From:</label>
                    <input type="date" name="date_from" value="{{ $dateFrom }}" 
                           class="border border-gray-300 rounded-md px-3 py-2 text-sm">
                </div>
                <div class="flex items-center space-x-2">
                    <label class="text-sm font-medium text-gray-700">To:</label>
                    <input type="date" name="date_to" value="{{ $dateTo }}" 
                           class="border border-gray-300 rounded-md px-3 py-2 text-sm">
                </div>
                <button type="submit" 
                        class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition-colors text-sm font-medium">
                    Apply Filter
                </button>
            </form>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Revenue -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <x-heroicon-s-currency-dollar class="w-5 h-5 text-green-600"/>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($kpis['total_revenue']) }}</p>
                    @if($growth['revenue_growth']['trend'] !== 'neutral')
                        <div class="flex items-center mt-1">
                            @if($growth['revenue_growth']['trend'] === 'up')
                                <x-heroicon-s-arrow-trending-up class="w-4 h-4 text-green-500"/>
                                <span class="text-green-500 text-sm font-medium ml-1">+{{ $growth['revenue_growth']['percentage'] }}%</span>
                            @else
                                <x-heroicon-s-arrow-trending-down class="w-4 h-4 text-red-500"/>
                                <span class="text-red-500 text-sm font-medium ml-1">-{{ $growth['revenue_growth']['percentage'] }}%</span>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <x-heroicon-s-shopping-bag class="w-5 h-5 text-blue-600"/>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Orders</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($kpis['total_orders']) }}</p>
                    @if($growth['orders_growth']['trend'] !== 'neutral')
                        <div class="flex items-center mt-1">
                            @if($growth['orders_growth']['trend'] === 'up')
                                <x-heroicon-s-arrow-trending-up class="w-4 h-4 text-green-500"/>
                                <span class="text-green-500 text-sm font-medium ml-1">+{{ $growth['orders_growth']['percentage'] }}%</span>
                            @else
                                <x-heroicon-s-arrow-trending-down class="w-4 h-4 text-red-500"/>
                                <span class="text-red-500 text-sm font-medium ml-1">-{{ $growth['orders_growth']['percentage'] }}%</span>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Total Tickets -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                        <x-heroicon-s-ticket class="w-5 h-5 text-purple-600"/>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Tickets Sold</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($kpis['total_tickets']) }}</p>
                    <p class="text-sm text-gray-500 mt-1">Avg: Rp {{ number_format($kpis['avg_order_value']) }}</p>
                </div>
            </div>
        </div>

        <!-- New Users -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <x-heroicon-s-users class="w-5 h-5 text-yellow-600"/>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">New Users</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($kpis['new_users']) }}</p>
                    @if($growth['users_growth']['trend'] !== 'neutral')
                        <div class="flex items-center mt-1">
                            @if($growth['users_growth']['trend'] === 'up')
                                <x-heroicon-s-arrow-trending-up class="w-4 h-4 text-green-500"/>
                                <span class="text-green-500 text-sm font-medium ml-1">+{{ $growth['users_growth']['percentage'] }}%</span>
                            @else
                                <x-heroicon-s-arrow-trending-down class="w-4 h-4 text-red-500"/>
                                <span class="text-red-500 text-sm font-medium ml-1">-{{ $growth['users_growth']['percentage'] }}%</span>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-4 rounded-lg border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Conversion Rate</p>
                    <p class="text-xl font-bold text-indigo-600">{{ number_format($kpis['conversion_rate'], 1) }}%</p>
                </div>
                <x-heroicon-o-chart-bar-square class="w-8 h-8 text-indigo-500"/>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Customer Retention</p>
                    <p class="text-xl font-bold text-green-600">{{ number_format($kpis['customer_retention'], 1) }}%</p>
                </div>
                <x-heroicon-o-arrow-path class="w-8 h-8 text-green-500"/>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Active Movies</p>
                    <p class="text-xl font-bold text-red-600">{{ $kpis['active_movies'] }}</p>
                </div>
                <x-heroicon-o-film class="w-8 h-8 text-red-500"/>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Avg Order Value</p>
                    <p class="text-xl font-bold text-yellow-600">Rp {{ number_format($kpis['avg_order_value']) }}</p>
                </div>
                <x-heroicon-o-calculator class="w-8 h-8 text-yellow-500"/>
            </div>
        </div>
    </div>

    <!-- Charts and Detailed Reports -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Revenue Trend Chart -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">📈 Revenue Trend</h3>
            <div class="h-64 flex items-center justify-center">
                <canvas id="revenueTrendChart"></canvas>
            </div>
        </div>

        <!-- Order Status Distribution -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">📊 Order Status Distribution</h3>
            <div class="h-64 flex items-center justify-center">
                <canvas id="orderStatusChart"></canvas>
            </div>
        </div>

        <!-- Movie Genre Performance -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">🎬 Movie Genre Performance</h3>
            <div class="h-64 flex items-center justify-center">
                <canvas id="genreChart"></canvas>
            </div>
        </div>

        <!-- Payment Methods -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">💳 Payment Methods</h3>
            <div class="h-64 flex items-center justify-center">
                <canvas id="paymentChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Quick Insights -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">🔍 Quick Insights</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @if($insights['top_movie'])
                <div class="p-4 bg-blue-50 rounded-lg">
                    <p class="text-sm font-medium text-blue-800">Top Performing Movie</p>
                    <p class="text-lg font-bold text-blue-900">{{ $insights['top_movie']['title'] }}</p>
                    <p class="text-sm text-blue-600">Rp {{ number_format($insights['top_movie']['revenue']) }}</p>
                </div>
            @endif

            @if($insights['top_cinema'])
                <div class="p-4 bg-green-50 rounded-lg">
                    <p class="text-sm font-medium text-green-800">Top Performing Cinema</p>
                    <p class="text-lg font-bold text-green-900">{{ $insights['top_cinema']['name'] }}</p>
                    <p class="text-sm text-green-600">Rp {{ number_format($insights['top_cinema']['revenue']) }}</p>
                </div>
            @endif

            @if($insights['peak_day'])
                <div class="p-4 bg-purple-50 rounded-lg">
                    <p class="text-sm font-medium text-purple-800">Peak Revenue Day</p>
                    <p class="text-lg font-bold text-purple-900">{{ $insights['peak_day']['date'] }}</p>
                    <p class="text-sm text-purple-600">Rp {{ number_format($insights['peak_day']['revenue']) }}</p>
                </div>
            @endif

            @if($insights['busiest_time'])
                <div class="p-4 bg-yellow-50 rounded-lg">
                    <p class="text-sm font-medium text-yellow-800">Busiest Hour</p>
                    <p class="text-lg font-bold text-yellow-900">{{ $insights['busiest_time']['hour'] }}</p>
                    <p class="text-sm text-yellow-600">{{ $insights['busiest_time']['orders'] }} orders</p>
                </div>
            @endif
        </div>
    </div>


</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart.js configuration
    Chart.defaults.font.family = 'Inter, system-ui, sans-serif';
    Chart.defaults.color = '#6B7280';

    // Revenue Trend Chart
    const revenueTrendCtx = document.getElementById('revenueTrendChart').getContext('2d');
    fetchChartData('revenue_trend').then(data => {
        new Chart(revenueTrendCtx, {
            type: 'line',
            data: {
                labels: data.map(item => item.date),
                datasets: [{
                    label: 'Revenue (Rp)',
                    data: data.map(item => item.revenue),
                    borderColor: '#10B981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    });

    // Order Status Chart
    const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
    fetchChartData('order_status').then(data => {
        new Chart(orderStatusCtx, {
            type: 'doughnut',
            data: {
                labels: data.map(item => item.status),
                datasets: [{
                    data: data.map(item => item.count),
                    backgroundColor: ['#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#06B6D4']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    });

    // Genre Performance Chart
    const genreCtx = document.getElementById('genreChart').getContext('2d');
    fetchChartData('movie_genre').then(data => {
        new Chart(genreCtx, {
            type: 'bar',
            data: {
                labels: data.map(item => item.genre),
                datasets: [{
                    label: 'Revenue (Rp)',
                    data: data.map(item => item.revenue),
                    backgroundColor: '#8B5CF6',
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    });

    // Payment Methods Chart
    const paymentCtx = document.getElementById('paymentChart').getContext('2d');
    fetchChartData('payment_methods').then(data => {
        new Chart(paymentCtx, {
            type: 'pie',
            data: {
                labels: data.map(item => item.method),
                datasets: [{
                    data: data.map(item => item.revenue),
                    backgroundColor: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    });

    // Function to fetch chart data
    async function fetchChartData(type) {
        try {
            const params = new URLSearchParams({
                type: type,
                date_from: '{{ $dateFrom }}',
                date_to: '{{ $dateTo }}'
            });

            const response = await fetch('{{ route("admin.reports.chart-data") }}?' + params);
            if (!response.ok) throw new Error('Network response was not ok');
            return await response.json();
        } catch (error) {
            console.error('Error fetching chart data:', error);
            return [];
        }
    }
});
</script>
@endpush
