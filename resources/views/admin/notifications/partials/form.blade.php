<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
	<div>
		<label class="block text-sm font-medium text-gray-700">Pengguna</label>
		<select name="user_id" class="mt-1 block w-full border rounded px-3 py-2" required>
			<option value="">Pilih pengguna</option>
			@if(!isset($notification))
				<option value="all" @selected(old('user_id')==='all')>Semua Pengguna</option>
			@endif
			@foreach($users as $u)
				<option value="{{ $u->id }}" @selected(old('user_id', $notification->user_id ?? '')==$u->id)>{{ $u->name }}</option>
			@endforeach
		</select>
		@error('user_id')<div class="text-red-600 text-xs mt-1">{{ $message }}</div>@enderror
	</div>
	<div>
		<label class="block text-sm font-medium text-gray-700">Tipe</label>
		<select name="type" class="mt-1 block w-full border rounded px-3 py-2" required>
			@foreach(['order','movie','system','promo'] as $t)
				<option value="{{ $t }}" @selected(old('type', $notification->type ?? '')===$t)>{{ ucfirst($t) }}</option>
			@endforeach
		</select>
		@error('type')<div class="text-red-600 text-xs mt-1">{{ $message }}</div>@enderror
	</div>
	<div class="md:col-span-2">
		<label class="block text-sm font-medium text-gray-700">Judul</label>
		<input type="text" name="title" value="{{ old('title', $notification->title ?? '') }}" class="mt-1 block w-full border rounded px-3 py-2" required />
		@error('title')<div class="text-red-600 text-xs mt-1">{{ $message }}</div>@enderror
	</div>
	<div class="md:col-span-2">
		<label class="block text-sm font-medium text-gray-700">Pesan</label>
		<textarea name="message" rows="4" class="mt-1 block w-full border rounded px-3 py-2" required>{{ old('message', $notification->message ?? '') }}</textarea>
		@error('message')<div class="text-red-600 text-xs mt-1">{{ $message }}</div>@enderror
	</div>
	<div class="md:col-span-2">
		<label class="block text-sm font-medium text-gray-700">Data Tambahan (JSON)</label>
		<textarea name="data" rows="3" class="mt-1 block w-full border rounded px-3 py-2" placeholder='{"action_url":"/orders/1"}'>{{ old('data', isset($notification) && $notification->data ? json_encode($notification->data) : '') }}</textarea>
		@error('data')<div class="text-red-600 text-xs mt-1">{{ $message }}</div>@enderror
	</div>
	@if(isset($notification))
	<div class="md:col-span-2">
		<label class="inline-flex items-center">
			<input type="checkbox" name="is_read" value="1" class="rounded" @checked(old('is_read', $notification->is_read ?? false)) />
			<span class="ml-2">Tandai sebagai sudah dibaca</span>
		</label>
	</div>
	@endif
</div>


