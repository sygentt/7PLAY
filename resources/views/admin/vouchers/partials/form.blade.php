<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
	
	<div>
		<label class="block text-sm font-medium text-gray-700">Nama</label>
		<input type="text" name="name" value="{{ old('name', $voucher->name ?? '') }}" class="mt-1 block w-full border rounded px-3 py-2" required />
		@error('name')<div class="text-red-600 text-xs mt-1">{{ $message }}</div>@enderror
	</div>
	<div>
		<label class="block text-sm font-medium text-gray-700">Tipe</label>
		<select name="type" class="mt-1 block w-full border rounded px-3 py-2" required>
			<option value="percentage" @selected(old('type', $voucher->type ?? '')==='percentage')>Persentase</option>
			<option value="fixed" @selected(old('type', $voucher->type ?? '')==='fixed')>Nominal</option>
		</select>
		@error('type')<div class="text-red-600 text-xs mt-1">{{ $message }}</div>@enderror
	</div>
	<div>
		<label class="block text-sm font-medium text-gray-700">Nilai</label>
		<input type="number" step="0.01" name="value" value="{{ old('value', $voucher->value ?? '') }}" class="mt-1 block w-full border rounded px-3 py-2" required />
		@error('value')<div class="text-red-600 text-xs mt-1">{{ $message }}</div>@enderror
	</div>
	<div>
		<label class="block text-sm font-medium text-gray-700">Min Pembelian</label>
		<input type="number" step="0.01" name="min_purchase" value="{{ old('min_purchase', $voucher->min_purchase ?? '') }}" class="mt-1 block w-full border rounded px-3 py-2" />
		@error('min_purchase')<div class="text-red-600 text-xs mt-1">{{ $message }}</div>@enderror
	</div>
	<div>
		<label class="block text-sm font-medium text-gray-700">Max Diskon</label>
		<input type="number" step="0.01" name="max_discount" value="{{ old('max_discount', $voucher->max_discount ?? '') }}" class="mt-1 block w-full border rounded px-3 py-2" />
		@error('max_discount')<div class="text-red-600 text-xs mt-1">{{ $message }}</div>@enderror
	</div>
	
	<div>
		<label class="block text-sm font-medium text-gray-700">Poin Dibutuhkan</label>
		<input type="number" name="points_required" value="{{ old('points_required', $voucher->points_required ?? '') }}" class="mt-1 block w-full border rounded px-3 py-2" />
		@error('points_required')<div class="text-red-600 text-xs mt-1">{{ $message }}</div>@enderror
	</div>
	<div>
		<label class="block text-sm font-medium text-gray-700">Berlaku Dari</label>
		<input type="datetime-local" name="valid_from" value="{{ old('valid_from', isset($voucher) ? $voucher->valid_from?->format('Y-m-d\TH:i') : '') }}" class="mt-1 block w-full border rounded px-3 py-2" required />
		@error('valid_from')<div class="text-red-600 text-xs mt-1">{{ $message }}</div>@enderror
	</div>
	<div>
		<label class="block text-sm font-medium text-gray-700">Berlaku Sampai</label>
		<input type="datetime-local" name="valid_until" value="{{ old('valid_until', isset($voucher) ? $voucher->valid_until?->format('Y-m-d\TH:i') : '') }}" class="mt-1 block w-full border rounded px-3 py-2" required />
		@error('valid_until')<div class="text-red-600 text-xs mt-1">{{ $message }}</div>@enderror
	</div>
	<div class="md:col-span-2">
		<label class="block text-sm font-medium text-gray-700">Deskripsi</label>
		<textarea name="description" rows="3" class="mt-1 block w-full border rounded px-3 py-2">{{ old('description', $voucher->description ?? '') }}</textarea>
		@error('description')<div class="text-red-600 text-xs mt-1">{{ $message }}</div>@enderror
	</div>
	<div class="md:col-span-2">
		<label class="inline-flex items-center">
			<input type="checkbox" name="is_active" value="1" class="rounded" @checked(old('is_active', $voucher->is_active ?? true)) />
			<span class="ml-2">Aktif</span>
		</label>
	</div>
</div>


