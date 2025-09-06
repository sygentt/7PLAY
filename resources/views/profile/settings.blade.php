@extends('layouts.public')

@section('title', 'Pengaturan - ' . config('app.name', '7PLAY'))

@section('content')
	<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="settingsPage()">
			<x-ui.breadcrumb :items="[
		['title' => 'Beranda', 'url' => route('home')],
		['title' => 'Profil', 'url' => route('profile.edit')],
		['title' => 'Pengaturan']
	]" />

		<h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Pengaturan</h1>

		<div class="space-y-6">
			<!-- Bahasa section removed -->

			<!-- Tema -->
			<div class="p-4 rounded-xl bg-white/80 dark:bg-gray-800/80 border border-gray-200 dark:border-gray-700">
				<h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Tema</h2>
				<div class="flex items-center space-x-3">
					<select x-model="theme" class="px-3 py-2 rounded-lg bg-gray-100 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100">
						<option value="light">Light</option>
						<option value="dark">Dark</option>
						<option value="system">System</option>
					</select>
					<button @click="applyTheme(); save('theme')" class="px-3 py-2 rounded-lg bg-cinema-600 text-white">Terapkan</button>
				</div>
			</div>

			<!-- Notifikasi -->
			<div class="p-4 rounded-xl bg-white/80 dark:bg-gray-800/80 border border-gray-200 dark:border-gray-700">
				<h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Notifikasi</h2>
				<div class="space-y-2">
					<label class="flex items-center space-x-3">
						<input type="checkbox" x-model="emailNotif" class="rounded border-gray-300 text-cinema-600 focus:ring-cinema-500">
						<span class="text-gray-700 dark:text-gray-300">Email Notification</span>
					</label>
					<label class="flex items-center space-x-3">
						<input type="checkbox" x-model="pushNotif" class="rounded border-gray-300 text-cinema-600 focus:ring-cinema-500">
						<span class="text-gray-700 dark:text-gray-300">Push Notification</span>
					</label>
					<div>
						<button @click="save('notifications')" class="px-3 py-2 rounded-lg bg-cinema-600 text-white">Simpan</button>
					</div>
				</div>
			</div>
		</div>
	</section>

	@push('scripts')
	<script>
		function settingsPage() {
			return {
				// language removed
				theme: @json(($settings->theme ?? 'system') ?? 'system'),
				emailNotif: @json(($settings->email_notif ?? true) ?? true),
				pushNotif: @json(($settings->push_notif ?? false) ?? false),
				async save(type) {
					try {
						const payload = {
							// language removed
							theme: this.theme,
							email_notif: !!this.emailNotif,
							push_notif: !!this.pushNotif,
						};

						const response = await fetch('{{ route('profile.settings.update') }}', {
							method: 'POST',
							headers: {
								'Content-Type': 'application/json',
								'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
							},
							body: JSON.stringify(payload)
						});

						const data = await response.json();
						if (data.success) {
							if (window.Toast) {
								window.Toast.show('Pengaturan disimpan', 'success', 2500);
							}
						} else {
							if (window.Toast) {
								window.Toast.show('Gagal menyimpan pengaturan', 'error', 4000);
							}
						}
					} catch (e) {
						console.error(e);
						if (window.Toast) {
							window.Toast.show('Terjadi kesalahan', 'error', 4000);
						}
					}
				},
				applyTheme() {
					if (this.theme === 'dark') {
						document.documentElement.classList.add('dark');
					} else if (this.theme === 'light') {
						document.documentElement.classList.remove('dark');
					} else {
						if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
							document.documentElement.classList.add('dark');
						} else {
							document.documentElement.classList.remove('dark');
						}
					}
				}
			}
		}
	</script>
	@endpush
@endsection

