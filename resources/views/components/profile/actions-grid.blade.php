@props(['items' => []])

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
	@foreach($items as $item)
		<x-profile.action-card 
			:href="$item['href']"
			:title="$item['title']"
			:icon="$item['icon']"
			:subtitle="$item['subtitle'] ?? null"
			:method="$item['method'] ?? 'get'"
		/>
	@endforeach
</div>


