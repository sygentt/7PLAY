<!-- Seat Count Selection Modal -->
<div id="seat-count-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-gray-900 bg-opacity-75 backdrop-blur-sm">
    <div class="modal-content relative w-full max-w-md transform overflow-hidden rounded-2xl bg-white dark:bg-gray-900 text-left align-middle shadow-2xl border border-gray-200 dark:border-gray-700 transition-all opacity-0 scale-95 duration-300">
        
        <!-- Close Button -->
        <button type="button" class="absolute right-4 top-4 text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300" onclick="closeSeatCountModal()">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Modal Content -->
        <div class="p-8">
            <!-- Header -->
            <div class="mb-6">
                <!-- Cinema XXI Logo placeholder -->
                <div class="flex items-center mb-4">
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">Cinema XXI</div>
                </div>
                
                <!-- Movie Info -->
                <div id="modal-movie-info" class="mb-6">
                    <h3 id="modal-movie-title" class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                        <!-- Movie title will be populated by JavaScript -->
                    </h3>
                    <div class="text-gray-600 dark:text-gray-400 space-y-1">
                        <div id="modal-cinema-info">
                            <!-- Cinema info will be populated by JavaScript -->
                        </div>
                        <div id="modal-showtime-info">
                            <!-- Showtime info will be populated by JavaScript -->
                        </div>
                    </div>
                </div>

                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    How many seats needed?
                </h2>
            </div>

            <!-- Important Notes -->
            <div class="mb-6 space-y-2">
                <div class="flex items-center text-sm text-orange-600 dark:text-orange-400">
                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    Tiket yang sudah dibeli tidak bisa di-refund atau ditukar
                </div>
                <div class="flex items-center text-sm text-orange-600 dark:text-orange-400">
                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    Kamu wajib membeli tiket untuk anak berumur 2 tahun dan lebih.
                </div>
            </div>

            <!-- Showtime Display -->
            <div id="modal-selected-showtime" class="mb-6 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg">
                <div class="text-2xl font-bold text-gray-900 dark:text-white" id="showtime-display">
                    <!-- Selected showtime will be populated -->
                </div>
            </div>

            <!-- Seat Counter -->
            <div class="mb-8">
                <div class="flex items-center justify-center space-x-6">
                    <button 
                        type="button" 
                        id="decrease-seats" 
                        class="flex items-center justify-center w-12 h-12 bg-gray-300 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-full hover:bg-gray-400 dark:hover:bg-gray-600 transition-colors disabled:opacity-50"
                        onclick="changeSeatCount(-1)"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                        </svg>
                    </button>
                    
                    <div class="text-6xl font-bold text-gray-900 dark:text-white min-w-[80px] text-center" id="seat-count">1</div>
                    
                    <button 
                        type="button" 
                        id="increase-seats" 
                        class="flex items-center justify-center w-12 h-12 bg-gray-300 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-full hover:bg-gray-400 dark:hover:bg-gray-600 transition-colors disabled:opacity-50"
                        onclick="changeSeatCount(1)"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Seat count status -->
                <div class="text-center mt-4">
                    <div class="text-gray-600 dark:text-gray-400">
                        <span id="seat-status">Kamu belum pilih kursi</span>
                    </div>
                    <div class="mt-2">
                        <span id="selected-seat-count">0</span> kursi terpilih
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-4">
                <button 
                    type="button" 
                    onclick="closeSeatCountModal()" 
                    class="flex-1 px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg font-medium hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors"
                >
                    Hapus pilihan
                </button>
                <button 
                    type="button" 
                    onclick="proceedToSeatSelection()" 
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 text-white rounded-lg font-semibold transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2"
                >
                    Lanjutkan
                </button>
            </div>
        </div>
    </div>
</div>
