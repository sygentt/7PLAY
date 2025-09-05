@props(['payment', 'size' => 'normal'])

@php
	if (!$payment || !$payment->payment_method) {
		$issuerInfo = ['name' => '-', 'issuer' => '-', 'logo' => '💳'];
	} else {
		$issuerInfo = $payment->getIssuerInfo();
	}
	
	$sizeClasses = match($size) {
		'small' => 'text-sm',
		'large' => 'text-lg',
		default => 'text-base'
	};
	
	$logoSizes = match($size) {
		'small' => 'text-base',
		'large' => 'text-xl',
		default => 'text-lg'
	};
@endphp

<div class="flex items-center gap-2 {{ $sizeClasses }}">
	<span class="{{ $logoSizes }}">{{ $issuerInfo['logo'] }}</span>
	<div>
		<p class="font-medium text-gray-900 dark:text-gray-100">{{ $issuerInfo['name'] }}</p>
		@if($issuerInfo['issuer'] !== '-' && $issuerInfo['issuer'] !== 'Unknown')
			<p class="text-xs text-gray-500 dark:text-gray-400">via {{ $issuerInfo['issuer'] }}</p>
		@endif
	</div>
</div>
