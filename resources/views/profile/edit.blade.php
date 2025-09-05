@extends('layouts.public')

@section('title', 'Profil - ' . config('app.name', '7PLAY'))

@section('content')
	<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
		<!-- Breadcrumb -->
		<x-ui.breadcrumb :items="[
			['title' => 'Beranda', 'url' => route('home')],
			['title' => 'Profil']
		]" />

		<!-- Header + Edit Button -->
		<div class="flex items-center justify-between mb-6">
					<div>
			<h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Halo, {{ $user->name }}</h1>
			<p class="text-sm text-gray-500 dark:text-gray-400">Kelola akun dan preferensi Anda</p>
		</div>
		<button x-data @click="$dispatch('open-edit-modal')" 
		        class="inline-flex items-center px-4 py-2 rounded-lg bg-cinema-600 hover:bg-cinema-700 text-white shadow">
			<x-heroicon-o-pencil class="w-5 h-5 mr-2" /> Edit Profil
		</button>
		</div>

		<!-- Actions Grid -->
		<x-profile.actions-grid :items="[
			['href' => route('profile.settings'), 'title' => 'Pengaturan', 'icon' => 'cog-6-tooth', 'subtitle' => 'Bahasa, tema, notifikasi'],
			['href' => route('profile.notifications'), 'title' => 'Notifikasi', 'icon' => 'bell', 'subtitle' => 'Semua pemberitahuan'],
			['href' => route('profile.tickets'), 'title' => 'Tiket Saya', 'icon' => 'ticket', 'subtitle' => 'Tiket aktif & kadarluarsa'],
			['href' => route('profile.orders-history'), 'title' => 'Riwayat Pesanan', 'icon' => 'clock', 'subtitle' => 'Transaksi sebelumnya'],
			['href' => route('profile.favorites'), 'title' => 'Film Saya (Favorit)', 'icon' => 'heart', 'subtitle' => 'Daftar favorit'],
			['href' => route('logout'), 'title' => 'Logout', 'icon' => 'arrow-right-on-rectangle', 'subtitle' => 'Keluar dari akun', 'method' => 'post']
		]" />

		<!-- Edit Profile Modal -->
		<x-profile.edit-modal :user="$user" />
		

	</section>
@endsection


