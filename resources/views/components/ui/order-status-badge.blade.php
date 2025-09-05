@props(['order'])

@php
	$expired = method_exists($order, 'isExpired') ? $order->isExpired() : false;
	if ($expired) {
		$config = ['text' => 'Kadaluarsa', 'class' => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100'];
	} else {
		$statusConfig = [
			'pending' => ['text' => 'Menunggu Pembayaran', 'class' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100'],
			'paid' => ['text' => 'Dibayar', 'class' => 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100'],
			'confirmed' => ['text' => 'Dikonfirmasi', 'class' => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100'],
			'cancelled' => ['text' => 'Dibatalkan', 'class' => 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100'],
		];
		$config = $statusConfig[$order->status] ?? ['text' => ucfirst($order->status), 'class' => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100'];
	}
@endphp

<span class="px-3 py-1 {{ $config['class'] }} text-sm rounded-full">
	{{ $config['text'] }}
</span>
