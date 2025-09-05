@extends('admin.layouts.app')

@section('title', 'Buat Voucher - 7PLAY Admin')
@section('page-title', 'Buat Voucher')
@section('page-description', 'Form membuat voucher baru')

@section('content')
<div class="max-w-4xl mx-auto px-4">
	<div class="bg-white shadow-sm rounded-lg p-6">
		<form method="POST" action="{{ route('admin.vouchers.store') }}" class="space-y-4">
			@csrf
			@include('admin.vouchers.partials.form')
			<div class="pt-4">
				<button class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
				<a href="{{ route('admin.vouchers.index') }}" class="ml-2 px-4 py-2 bg-gray-100 text-gray-700 rounded">Batal</a>
			</div>
		</form>
	</div>
</div>
@endsection


