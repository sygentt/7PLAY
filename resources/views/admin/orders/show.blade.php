@extends('admin.layouts.app')

@section('title', 'Detail Order - ' . $order->order_number)

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ route('admin.orders.index') }}" 
               class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors">
                <x-heroicon-o-arrow-left class="w-5 h-5 mr-2" />
                Kembali ke Daftar Order
            </a>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <x-heroicon-o-eye class="w-8 h-8 text-indigo-600" />
                    {{ $order->order_number }}
                </h1>
                <p class="mt-2 text-gray-600">Detail informasi order dan transaksi</p>
            </div>
            <div class="mt-4 sm:mt-0 flex gap-2">
                @php $badge = $order->getStatusBadge() @endphp
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $badge['class'] }}">
                    {{ $badge['text'] }}
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Order Details -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Detail Order</h2>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Customer Information -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Customer</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $order->user->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $order->user->email }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Phone</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $order->user->phone ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Member Since</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $order->user->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Movie & Show Information -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Film & Jadwal</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Film</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $order->showtime->movie->title }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Genre & Rating</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $order->showtime->movie->genre }} - {{ $order->showtime->movie->rating }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Bioskop</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $order->showtime->cinemaHall->cinema->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kota</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $order->showtime->cinemaHall->cinema->city->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Studio</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $order->showtime->cinemaHall->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tipe Studio</label>
                                @php $hallType = $order->showtime->cinemaHall->getTypeLabel() @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $hallType['class'] }}">
                                    {{ $hallType['text'] }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal & Waktu</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $order->showtime->getFormattedDateTime() }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Durasi Film</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $order->showtime->movie->getFormattedDuration() }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Seat Information -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Kursi</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jumlah Tiket</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $order->getTicketCount() }} tiket</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nomor Kursi</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $order->getSeatNumbers() }}</p>
                            </div>
                        </div>

                        <!-- Seat Details Table -->
                        <div class="mt-4">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kursi</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($order->orderItems as $item)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $item->getSeatLabel() }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ ucfirst($item->seat->type) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $item->getFormattedPrice() }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item->status === 'booked' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ ucfirst($item->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Pembayaran</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Subtotal</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $order->getFormattedSubtotal() }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Diskon</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $order->getFormattedDiscount() }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Total</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $order->getFormattedTotal() }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $order->payment_method ? ucwords(str_replace('_', ' ', $order->payment_method)) : '-' }}</p>
                            </div>
                            @if($order->payment_reference)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Referensi Pembayaran</label>
                                    <p class="mt-1 text-sm text-gray-900 font-mono">{{ $order->payment_reference }}</p>
                                </div>
                            @endif
                            @if($order->payment_date)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Pembayaran</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $order->payment_date->format('d M Y H:i') }}</p>
                                </div>
                            @endif
                            @if($order->points_used > 0 || $order->points_earned > 0)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Points</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        @if($order->points_used > 0)
                                            Digunakan: {{ $order->points_used }} points
                                        @endif
                                        @if($order->points_earned > 0)
                                            Didapat: {{ $order->points_earned }} points
                                        @endif
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status & Actions -->
        <div class="lg:col-span-1">
            <!-- Status Update -->
            @if($order->canBeCancelled() || $order->canBeConfirmed())
                <div class="bg-white shadow rounded-lg mb-6">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900">Update Status</h2>
                    </div>
                    <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="p-6">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status Baru</label>
                            <select name="status" id="status" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                                @foreach(App\Models\Order::getStatuses() as $statusKey => $statusLabel)
                                    @if(
                                        ($order->status === 'pending' && in_array($statusKey, ['paid', 'cancelled'])) ||
                                        ($order->status === 'paid' && in_array($statusKey, ['confirmed', 'cancelled']))
                                    )
                                        <option value="{{ $statusKey }}" {{ $order->status === $statusKey ? 'selected' : '' }}>
                                            {{ $statusLabel }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">Catatan (opsional)</label>
                            <textarea name="reason" id="reason" rows="3" 
                                      class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                      placeholder="Catatan untuk perubahan status..."></textarea>
                        </div>

                        <button type="submit" 
                                class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <x-heroicon-o-check class="w-4 h-4 mr-2" />
                            Update Status
                        </button>
                    </form>
                </div>
            @endif

            <!-- Order Timeline -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Timeline Order</h2>
                </div>
                <div class="p-6">
                    <div class="flow-root">
                        <ul class="-mb-8">
                            <li class="relative pb-8">
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                            <x-heroicon-o-shopping-cart class="w-4 h-4 text-white" />
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Order dibuat</p>
                                        </div>
                                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                            {{ $order->created_at->format('d M Y H:i') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute top-0 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></div>
                            </li>

                            @if($order->payment_date)
                                <li class="relative pb-8">
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                                <x-heroicon-o-credit-card class="w-4 h-4 text-white" />
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-500">Pembayaran berhasil</p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                {{ $order->payment_date->format('d M Y H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                    @if($order->status !== 'paid')
                                        <div class="absolute top-0 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></div>
                                    @endif
                                </li>
                            @endif

                            @if($order->status === 'confirmed')
                                <li class="relative">
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-green-600 flex items-center justify-center ring-8 ring-white">
                                                <x-heroicon-o-check-circle class="w-4 h-4 text-white" />
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-500">Order dikonfirmasi</p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                {{ $order->updated_at->format('d M Y H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif

                            @if($order->status === 'cancelled')
                                <li class="relative">
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-red-500 flex items-center justify-center ring-8 ring-white">
                                                <x-heroicon-o-x-circle class="w-4 h-4 text-white" />
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-500">Order dibatalkan</p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                {{ $order->updated_at->format('d M Y H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            <!-- QR Code -->
            @if($order->qr_code && in_array($order->status, ['confirmed', 'paid']))
                <div class="bg-white shadow rounded-lg mt-6">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900">E-Ticket</h2>
                    </div>
                    <div class="p-6 text-center">
                        <!-- QR Code would be displayed here -->
                        <div class="w-32 h-32 bg-gray-200 mx-auto rounded-lg flex items-center justify-center">
                            <x-heroicon-o-qr-code class="w-16 h-16 text-gray-400" />
                        </div>
                        <p class="mt-2 text-sm text-gray-600">QR Code untuk masuk bioskop</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
