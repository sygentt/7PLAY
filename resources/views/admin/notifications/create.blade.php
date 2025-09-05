@extends('admin.layouts.app')

@section('title', 'Buat Notifikasi - 7PLAY Admin')
@section('page-title', 'Buat Notifikasi')
@section('page-description', 'Kirim notifikasi ke pengguna tertentu')

@section('content')
<div class="max-w-4xl mx-auto px-4">
	<div class="bg-white shadow-sm rounded-lg p-6">
		<form method="POST" action="{{ route('admin.notifications.store') }}" class="space-y-4">
			@csrf
			@include('admin.notifications.partials.form')
			<div class="pt-4">
				<button class="px-4 py-2 bg-blue-600 text-white rounded">Kirim</button>
				<a href="{{ route('admin.notifications.index') }}" class="ml-2 px-4 py-2 bg-gray-100 text-gray-700 rounded">Batal</a>
			</div>
		</form>
	</div>
</div>
@endsection


