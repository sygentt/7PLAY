@extends('admin.layouts.app')

@section('title', 'Notifikasi - 7PLAY Admin')
@section('page-title', 'Notifikasi')
@section('page-description', 'Kelola notifikasi untuk pengguna')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
	<div class="bg-white shadow-sm rounded-lg p-6">
		<div class="flex items-center justify-between mb-6">
			<form method="GET" class="flex items-center space-x-2">
				<input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul/pesan" class="border rounded px-3 py-2 text-sm" />
				<select name="type" class="border rounded px-3 py-2 text-sm">
					<option value="">Semua Tipe</option>
					@foreach(['order','movie','system','promo'] as $t)
						<option value="{{ $t }}" @selected(request('type')===$t)>{{ ucfirst($t) }}</option>
					@endforeach
				</select>
				<select name="status" class="border rounded px-3 py-2 text-sm">
					<option value="">Semua Status</option>
					<option value="unread" @selected(request('status')==='unread')>Belum Dibaca</option>
					<option value="read" @selected(request('status')==='read')>Sudah Dibaca</option>
				</select>
				<button class="px-4 py-2 bg-blue-600 text-white rounded">Filter</button>
			</form>
			<a href="{{ route('admin.notifications.create') }}" class="px-4 py-2 bg-green-600 text-white rounded">Buat Notifikasi</a>
		</div>

		<div class="overflow-x-auto">
			<table class="min-w-full divide-y divide-gray-200">
				<thead class="bg-gray-50">
					<tr>
						<th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Pengguna</th>
						<th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
						<th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
						<th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
						<th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Dibuat</th>
						<th class="px-4 py-2"/>
					</tr>
				</thead>
				<tbody class="bg-white divide-y divide-gray-200">
					@php $seenBroadcastBatches = []; @endphp
					@forelse($notifications as $n)
						@php $isBroadcast = $n->is_broadcast ?? false; $bk = $n->batch_key ?? null; @endphp
						@if($isBroadcast && $bk && in_array($bk, $seenBroadcastBatches))
							@continue
						@endif
						@if($isBroadcast && $bk)
							@php $seenBroadcastBatches[] = $bk; @endphp
						@endif
						<tr>
							<td class="px-4 py-2">{{ ($n->is_broadcast ?? false) ? 'Semua Pengguna' : ($n->user->name ?? '-') }}</td>
							<td class="px-4 py-2">{{ ucfirst($n->type) }}</td>
							<td class="px-4 py-2">{{ $n->title }}</td>
							<td class="px-4 py-2">
								<span class="px-2 py-1 text-xs rounded {{ $n->is_read ? 'bg-gray-100 text-gray-600' : 'bg-yellow-100 text-yellow-700' }}">
									{{ $n->is_read ? 'Sudah dibaca' : 'Belum dibaca' }}
								</span>
							</td>
							<td class="px-4 py-2 text-xs text-gray-600">{{ $n->created_at->format('d M Y H:i') }}</td>
							<td class="px-4 py-2 text-right space-x-2">
								<a href="{{ route('admin.notifications.edit', $n) }}" class="text-indigo-600 hover:underline">Edit</a>
								<form method="POST" action="{{ route('admin.notifications.destroy', $n) }}" class="inline" onsubmit="return confirm('Hapus notifikasi ini?')">
									@csrf
									@method('DELETE')
									<button class="text-red-600 hover:underline">Hapus</button>
								</form>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="6" class="px-4 py-6 text-center text-gray-500">Belum ada notifikasi.</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>

		@if($notifications->hasPages())
			<div class="mt-4">{{ $notifications->links() }}</div>
		@endif
	</div>
</div>
@endsection


