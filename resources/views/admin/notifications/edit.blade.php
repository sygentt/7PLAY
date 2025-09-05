@extends('admin.layouts.app')

@section('title', 'Edit Notifikasi - 7PLAY Admin')
@section('page-title', 'Edit Notifikasi')
@section('page-description', 'Perbarui konten notifikasi')

@section('content')
<div class="max-w-4xl mx-auto px-4">
	<div class="bg-white shadow-sm rounded-lg p-6">
		<form method="POST" action="{{ route('admin.notifications.update', $notification) }}" class="space-y-4">
			@csrf
			@method('PUT')
			@include('admin.notifications.partials.form')
			<div class="pt-4">
				<button class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
				<a href="{{ route('admin.notifications.index') }}" class="ml-2 px-4 py-2 bg-gray-100 text-gray-700 rounded">Batal</a>
			</div>
		</form>
	</div>
</div>
@endsection


