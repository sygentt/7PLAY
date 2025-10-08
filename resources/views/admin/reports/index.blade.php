@extends('admin.layouts.app')

@section('title', 'Laporan & Analitik')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <x-heroicon-o-chart-bar class="w-8 h-8 text-indigo-600" />
                Laporan & Analitik
            </h1>
            <p class="mt-2 text-gray-600">Wawasan bisnis komprehensif dan metrik performa</p>
        </div>
    </div>

    <!-- Date Range Filter -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <form method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Date From -->
                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
                    <input type="date" 
                           name="date_from" 
                           id="date_from"
                           value="{{ $dateFrom }}"
                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <!-- Date To -->
                <div>
                    <label for="date_to" class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                    <input type="date" 
                           name="date_to" 
                           id="date_to"
                           value="{{ $dateTo }}"
                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <!-- Submit Button -->
                <div class="flex items-end">
                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 transition ease-in-out duration-150">
                        <x-heroicon-o-magnifying-glass class="w-4 h-4 mr-2" />
                        Terapkan Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Main KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Revenue -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <x-heroicon-o-currency-dollar class="w-7 h-7 text-green-600"/>
                        </div>
                    </div>
                    <div class="ml-4 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Pendapatan</dt>
                            <dd class="text-2xl font-bold text-gray-900">Rp {{ number_format($kpis['total_revenue'], 0, ',', '.') }}</dd>
                            @if($growth['revenue_growth']['trend'] !== 'neutral')
                                <dd class="flex items-center mt-1">
                                    @if($growth['revenue_growth']['trend'] === 'up')
                                        <x-heroicon-o-arrow-trending-up class="w-4 h-4 text-green-500"/>
                                        <span class="text-green-500 text-xs font-medium ml-1">+{{ $growth['revenue_growth']['percentage'] }}%</span>
                                    @else
                                        <x-heroicon-o-arrow-trending-down class="w-4 h-4 text-red-500"/>
                                        <span class="text-red-500 text-xs font-medium ml-1">-{{ $growth['revenue_growth']['percentage'] }}%</span>
                                    @endif
                                    <span class="text-gray-500 text-xs ml-1">vs periode lalu</span>
                                </dd>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <x-heroicon-o-shopping-bag class="w-7 h-7 text-blue-600"/>
                        </div>
                    </div>
                    <div class="ml-4 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Pesanan</dt>
                            <dd class="text-2xl font-bold text-gray-900">{{ number_format($kpis['total_orders']) }}</dd>
                            @if($growth['orders_growth']['trend'] !== 'neutral')
                                <dd class="flex items-center mt-1">
                                    @if($growth['orders_growth']['trend'] === 'up')
                                        <x-heroicon-o-arrow-trending-up class="w-4 h-4 text-green-500"/>
                                        <span class="text-green-500 text-xs font-medium ml-1">+{{ $growth['orders_growth']['percentage'] }}%</span>
                                    @else
                                        <x-heroicon-o-arrow-trending-down class="w-4 h-4 text-red-500"/>
                                        <span class="text-red-500 text-xs font-medium ml-1">-{{ $growth['orders_growth']['percentage'] }}%</span>
                                    @endif
                                    <span class="text-gray-500 text-xs ml-1">vs periode lalu</span>
                                </dd>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Tickets -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <x-heroicon-o-ticket class="w-7 h-7 text-purple-600"/>
                        </div>
                    </div>
                    <div class="ml-4 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Tiket Terjual</dt>
                            <dd class="text-2xl font-bold text-gray-900">{{ number_format($kpis['total_tickets']) }}</dd>
                            <dd class="text-xs text-gray-500 mt-1">Rata-rata: Rp {{ number_format($kpis['avg_order_value'], 0, ',', '.') }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- New Users -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <x-heroicon-o-user-plus class="w-7 h-7 text-yellow-600"/>
                        </div>
                    </div>
                    <div class="ml-4 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Pengguna Baru</dt>
                            <dd class="text-2xl font-bold text-gray-900">{{ number_format($kpis['new_users']) }}</dd>
                            @if($growth['users_growth']['trend'] !== 'neutral')
                                <dd class="flex items-center mt-1">
                                    @if($growth['users_growth']['trend'] === 'up')
                                        <x-heroicon-o-arrow-trending-up class="w-4 h-4 text-green-500"/>
                                        <span class="text-green-500 text-xs font-medium ml-1">+{{ $growth['users_growth']['percentage'] }}%</span>
                                    @else
                                        <x-heroicon-o-arrow-trending-down class="w-4 h-4 text-red-500"/>
                                        <span class="text-red-500 text-xs font-medium ml-1">-{{ $growth['users_growth']['percentage'] }}%</span>
                                    @endif
                                    <span class="text-gray-500 text-xs ml-1">vs periode lalu</span>
                                </dd>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Conversion Rate</p>
                        <p class="text-xl font-bold text-indigo-600">{{ number_format($kpis['conversion_rate'], 1) }}%</p>
                    </div>
                    <x-heroicon-o-chart-bar-square class="w-8 h-8 text-indigo-500"/>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Customer Retention</p>
                        <p class="text-xl font-bold text-green-600">{{ number_format($kpis['customer_retention'], 1) }}%</p>
                    </div>
                    <x-heroicon-o-arrow-path class="w-8 h-8 text-green-500"/>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Film Aktif</p>
                        <p class="text-xl font-bold text-red-600">{{ $kpis['active_movies'] }}</p>
                    </div>
                    <x-heroicon-o-film class="w-8 h-8 text-red-500"/>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Rata-rata Nilai Order</p>
                        <p class="text-xl font-bold text-yellow-600">Rp {{ number_format($kpis['avg_order_value'], 0, ',', '.') }}</p>
                    </div>
                    <x-heroicon-o-calculator class="w-8 h-8 text-yellow-500"/>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Revenue Trend Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <x-heroicon-o-chart-bar class="w-5 h-5 text-green-600" />
                Tren Pendapatan
            </h3>
            <div class="h-64">
                <canvas id="revenueTrendChart"></canvas>
            </div>
        </div>

        <!-- Order Status Distribution -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <x-heroicon-o-chart-bar-square class="w-5 h-5 text-blue-600" />
                Distribusi Status Pesanan
            </h3>
            <div class="h-64">
                <canvas id="orderStatusChart"></canvas>
            </div>
        </div>

        <!-- Movie Genre Performance -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <x-heroicon-o-film class="w-5 h-5 text-purple-600" />
                Performa Genre Film
            </h3>
            <div class="h-64">
                <canvas id="genreChart"></canvas>
            </div>
        </div>

        <!-- Payment Methods -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <x-heroicon-o-credit-card class="w-5 h-5 text-indigo-600" />
                Metode Pembayaran
            </h3>
            <div class="h-64">
                <canvas id="paymentChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Quick Insights -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
            <x-heroicon-o-light-bulb class="w-5 h-5 text-yellow-500" />
            Wawasan Cepat
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @if($insights['top_movie'])
                <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <div class="flex items-start gap-2 mb-2">
                        <x-heroicon-o-trophy class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" />
                        <p class="text-sm font-medium text-blue-800">Film Terbaik</p>
                    </div>
                    <p class="text-lg font-bold text-blue-900 mb-1">{{ $insights['top_movie']['title'] }}</p>
                    <p class="text-sm text-blue-600">Rp {{ number_format($insights['top_movie']['revenue'], 0, ',', '.') }}</p>
                </div>
            @endif

            @if($insights['top_cinema'])
                <div class="p-4 bg-green-50 rounded-lg border border-green-200">
                    <div class="flex items-start gap-2 mb-2">
                        <x-heroicon-o-building-office class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" />
                        <p class="text-sm font-medium text-green-800">Cinema Terbaik</p>
                    </div>
                    <p class="text-lg font-bold text-green-900 mb-1">{{ $insights['top_cinema']['name'] }}</p>
                    <p class="text-sm text-green-600">Rp {{ number_format($insights['top_cinema']['revenue'], 0, ',', '.') }}</p>
                </div>
            @endif

            @if($insights['peak_day'])
                <div class="p-4 bg-purple-50 rounded-lg border border-purple-200">
                    <div class="flex items-start gap-2 mb-2">
                        <x-heroicon-o-calendar-days class="w-5 h-5 text-purple-600 flex-shrink-0 mt-0.5" />
                        <p class="text-sm font-medium text-purple-800">Hari Puncak</p>
                    </div>
                    <p class="text-lg font-bold text-purple-900 mb-1">{{ $insights['peak_day']['date'] }}</p>
                    <p class="text-sm text-purple-600">Rp {{ number_format($insights['peak_day']['revenue'], 0, ',', '.') }}</p>
                </div>
            @endif

            @if($insights['busiest_time'])
                <div class="p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                    <div class="flex items-start gap-2 mb-2">
                        <x-heroicon-o-clock class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" />
                        <p class="text-sm font-medium text-yellow-800">Jam Tersibuk</p>
                    </div>
                    <p class="text-lg font-bold text-yellow-900 mb-1">{{ $insights['busiest_time']['hour'] }}</p>
                    <p class="text-sm text-yellow-600">{{ $insights['busiest_time']['orders'] }} pesanan</p>
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
                    label: 'Pendapatan (Rp)',
                    data: data.map(item => item.revenue),
                    borderColor: '#10B981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 3,
                    pointHoverRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + (value / 1000).toFixed(0) + 'K';
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
                    backgroundColor: ['#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#06B6D4'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15
                        }
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
                    label: 'Pendapatan (Rp)',
                    data: data.map(item => item.revenue),
                    backgroundColor: '#8B5CF6',
                    borderRadius: 6,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + (value / 1000).toFixed(0) + 'K';
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
                    backgroundColor: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': Rp ' + context.parsed.toLocaleString('id-ID');
                            }
                        }
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
            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Error fetching chart data:', error);
            return [];
        }
    }
});
</script>
@endpush
