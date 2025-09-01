<!-- Edit Profile Modal -->
<div x-data="{ showEditModal: false }" 
     @open-edit-modal.window="showEditModal = true" 
     @close-edit-modal.window="showEditModal = false"
     x-cloak>
	<!-- Modal Overlay -->
	<div x-show="showEditModal" 
		 x-transition:enter="transition ease-out duration-300" 
		 x-transition:enter-start="opacity-0" 
		 x-transition:enter-end="opacity-100"
		 x-transition:leave="transition ease-in duration-200" 
		 x-transition:leave-start="opacity-100" 
		 x-transition:leave-end="opacity-0"
		 class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 modal-backdrop"
		 @click="showEditModal = false"
		 x-cloak>
		
		<!-- Modal Container -->
		<div x-transition:enter="transition ease-out duration-300" 
			 x-transition:enter-start="opacity-0 scale-95" 
			 x-transition:enter-end="opacity-100 scale-100"
			 x-transition:leave="transition ease-in duration-200" 
			 x-transition:leave-start="opacity-100 scale-100" 
			 x-transition:leave-end="opacity-0 scale-95"
			 @click.stop
			 class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-md mx-4 max-h-[90vh] overflow-y-auto ring-1 ring-black/10 dark:ring-white/10">
			
			<!-- Modal Header -->
			<div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
				<h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Edit Profil</h2>
				<button @click="showEditModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
					<x-heroicon-o-x-mark class="w-6 h-6" />
				</button>
			</div>

			<!-- Modal Body -->
			<div class="p-6">
				<form id="profile-edit-form" action="{{ route('profile.update') }}" method="post">
					@csrf
					@method('patch')
					
					<!-- Name -->
					<div class="mb-4">
						<label for="modal_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
							Nama Lengkap
						</label>
						<input type="text" id="modal_name" name="name" 
							   value="{{ old('name', $user->name) }}"
							   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-cinema-500 focus:border-cinema-500"
							   required autofocus autocomplete="name">
						<div id="modal_name_error" class="text-red-500 text-xs mt-1 hidden"></div>
					</div>

					<!-- Email -->
					<div class="mb-4">
						<label for="modal_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
							Email
						</label>
						<input type="email" id="modal_email" name="email" 
							   value="{{ old('email', $user->email) }}"
							   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-cinema-500 focus:border-cinema-500"
							   required autocomplete="username">
						<div id="modal_email_error" class="text-red-500 text-xs mt-1 hidden"></div>
					</div>

					<!-- Phone -->
					<div class="mb-4">
						<label for="modal_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
							Nomor Telepon
						</label>
						<input type="tel" id="modal_phone" name="phone" 
							   value="{{ old('phone', $user->phone) }}"
							   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-cinema-500 focus:border-cinema-500"
							   autocomplete="tel">
						<div id="modal_phone_error" class="text-red-500 text-xs mt-1 hidden"></div>
					</div>

					<!-- Birth Date -->
					<div class="mb-4">
						<label for="modal_birth_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
							Tanggal Lahir
						</label>
						<input type="date" id="modal_birth_date" name="birth_date" 
							   value="{{ old('birth_date', $user->birth_date) }}"
							   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-cinema-500 focus:border-cinema-500"
							   autocomplete="bday">
						<div id="modal_birth_date_error" class="text-red-500 text-xs mt-1 hidden"></div>
					</div>

					<!-- Gender -->
					<div class="mb-6">
						<label for="modal_gender" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
							Jenis Kelamin
						</label>
						<select id="modal_gender" name="gender" 
								class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-cinema-500 focus:border-cinema-500">
							<option value="">Pilih Jenis Kelamin</option>
							<option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
							<option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
						</select>
						<div id="modal_gender_error" class="text-red-500 text-xs mt-1 hidden"></div>
					</div>

					<!-- Submit Button -->
					<div class="flex gap-3">
						<button type="button" @click="showEditModal = false" 
								class="flex-1 px-4 py-2 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-lg transition-colors">
							Batal
						</button>
						<button type="submit" id="modal-profile-submit"
								class="flex-1 px-4 py-2 bg-cinema-600 hover:bg-cinema-700 text-white rounded-lg font-medium transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
							<span id="modal-profile-text">Simpan Perubahan</span>
							<span id="modal-profile-loading" class="hidden">
								<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
									<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
									<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
								</svg>
								Menyimpan...
							</span>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
	// Handle profile edit form submission
	const profileForm = document.getElementById('profile-edit-form');
	if (profileForm) {
		profileForm.addEventListener('submit', async function(e) {
			e.preventDefault();
			
			const submitBtn = document.getElementById('modal-profile-submit');
			const submitText = document.getElementById('modal-profile-text');
			const submitLoading = document.getElementById('modal-profile-loading');
			
			// Clear previous errors
			document.querySelectorAll('[id$="_error"]').forEach(el => {
				el.classList.add('hidden');
				el.textContent = '';
			});
			
			// Show loading state
			submitBtn.disabled = true;
			submitText.classList.add('hidden');
			submitLoading.classList.remove('hidden');
			
			try {
				const formData = new FormData(profileForm);
				const response = await fetch(profileForm.action, {
					method: 'POST',
					body: formData,
					headers: {
						'X-Requested-With': 'XMLHttpRequest',
						'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
						'Accept': 'application/json'
					}
				});
				
				const data = await response.json();
				
				if (response.ok) {
					// Show success message
					if (window.Toast) {
						window.Toast.show('Profil berhasil diperbarui!', 'success', 3000);
					}
					
					// Close modal
					window.dispatchEvent(new CustomEvent('close-edit-modal'));
					
					// Reload page to show updated data
					setTimeout(() => {
						window.location.reload();
					}, 1000);
				} else {
					// Handle validation errors
					if (data.errors) {
						Object.keys(data.errors).forEach(field => {
							const errorElement = document.getElementById(`modal_${field}_error`);
							if (errorElement) {
								errorElement.textContent = data.errors[field][0];
								errorElement.classList.remove('hidden');
							}
						});
					} else {
						if (window.Toast) {
							window.Toast.show(data.message || 'Terjadi kesalahan saat memperbarui profil.', 'error', 5000);
						}
					}
				}
			} catch (error) {
				console.error('Error:', error);
				if (window.Toast) {
					window.Toast.show('Terjadi kesalahan jaringan. Silakan coba lagi.', 'error', 5000);
				}
			} finally {
				// Reset loading state
				submitBtn.disabled = false;
				submitText.classList.remove('hidden');
				submitLoading.classList.add('hidden');
			}
		});
	}
});
</script>
