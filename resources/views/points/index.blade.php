@extends('layouts.public')

@section('title', 'Poin & Voucher - 7PLAY')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-black py-10">
    <div class="max-w-6xl mx-auto px-4">
        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-2xl font-bold">Poin & Voucher</h1>
            <a href="{{ route('home') }}" class="text-sm text-cinema-600 dark:text-cinema-400 hover:underline">&larr; Kembali ke Beranda</a>
        </div>

        <!-- Points Summary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="text-sm text-gray-500 dark:text-gray-400">Total Poin</div>
                <div class="text-3xl font-extrabold mt-2">{{ number_format($user_points->total_points) }}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Membership: {{ ucfirst($user_points->membership_level) }}</div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="text-sm text-gray-500 dark:text-gray-400">Total Pesanan</div>
                <div class="text-3xl font-extrabold mt-2">{{ number_format($user_points->total_orders) }}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Pesanan terakhir: {{ optional($user_points->last_order_date)->diffForHumans() ?? '-' }}</div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="text-sm text-gray-500 dark:text-gray-400">Voucher Saya (Belum Dipakai)</div>
                <div class="text-3xl font-extrabold mt-2">{{ $user_vouchers->where('is_used', false)->count() }}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Total voucher: {{ $user_vouchers->count() }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Available Vouchers -->
            <div class="lg:col-span-2">
                <h2 class="text-xl font-semibold mb-4">Tukar Poin dengan Voucher</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($available_vouchers as $voucher)
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-5 border border-gray-100 dark:border-gray-700 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <div class="font-bold">{{ $voucher->name }}</div>
                                    <span class="text-xs px-2 py-1 rounded bg-blue-100 text-blue-700">{{ $voucher->type === 'percentage' ? $voucher->value . '% OFF' : 'Rp ' . number_format($voucher->value,0,',','.') }}</span>
                                </div>
                                <div class="text-xs text-gray-500">Kode: {{ $voucher->code }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-300 mt-2">{{ $voucher->description }}</div>
                                <div class="text-xs text-gray-500 mt-2">Berlaku: {{ $voucher->valid_from->format('d M Y') }} - {{ $voucher->valid_until->format('d M Y') }}</div>
                                @if($voucher->min_purchase)
                                    <div class="text-xs text-gray-500">Min. Pembelian: Rp {{ number_format($voucher->min_purchase,0,',','.') }}</div>
                                @endif
                            </div>
                            <div class="mt-4 flex items-center justify-between">
                                <div class="text-sm text-gray-700 dark:text-gray-300">
                                    <span class="font-semibold">{{ $voucher->points_required ?? 0 }}</span> poin diperlukan
                                </div>
                                <button 
                                    class="px-4 py-2 bg-cinema-600 hover:bg-cinema-700 text-white rounded-lg text-sm"
                                    onclick="redeemVoucher({{ $voucher->id }})"
                                >Tukar</button>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 text-center text-gray-500">Belum ada voucher yang tersedia</div>
                    @endforelse
                </div>
            </div>

            <!-- My Vouchers -->
            <div>
                <h2 class="text-xl font-semibold mb-4">Voucher Saya</h2>
                <div class="space-y-3">
                    @forelse($user_vouchers as $uv)
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-5 border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="font-bold">{{ $uv->voucher->name }}</div>
                                    <div class="text-xs text-gray-500">Kode: {{ $uv->voucher->code }}</div>
                                    <div class="text-xs text-gray-500">Ditukar: {{ $uv->redeemed_at->format('d M Y H:i') }}</div>
                                </div>
                                <div>
                                    @if($uv->is_used)
                                        <span class="text-xs px-2 py-1 rounded bg-gray-200 text-gray-700">Terpakai</span>
                                    @else
                                        <span class="text-xs px-2 py-1 rounded bg-green-100 text-green-700">Belum dipakai</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-gray-500">Belum ada voucher yang ditukar</div>
                    @endforelse
                </div>

                <h2 class="text-xl font-semibold mt-8 mb-4">Riwayat Poin</h2>
                <div class="space-y-3">
                    @forelse($transactions as $tx)
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-100 dark:border-gray-700 flex items-center justify-between">
                            <div>
                                <div class="font-medium text-sm">{{ ucfirst($tx->type) }}</div>
                                <div class="text-xs text-gray-500">{{ $tx->description }}</div>
                            </div>
                            <div class="font-bold {{ $tx->type === 'earned' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $tx->type === 'earned' ? '+' : '-' }}{{ $tx->points }}
                            </div>
                        </div>
                    @empty
                        <div class="text-gray-500">Belum ada transaksi poin</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
async function redeemVoucher(voucherId) {
    try {
        const resp = await fetch(`/points/redeem/${voucherId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        });
        const data = await resp.json();
        if (!resp.ok || !data.success) {
            alert(data.message || 'Gagal menukar voucher');
            return;
        }
        alert('Berhasil menukar voucher! Sisa poin: ' + data.remaining_points);
        window.location.reload();
    } catch (e) {
        console.error(e);
        alert('Terjadi kesalahan.');
    }
}
</script>
@endpush
@endsection


