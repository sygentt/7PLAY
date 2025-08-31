@props(['id' => 'auth-modal'])

<!-- Auth Modal Overlay -->
<div 
    id="{{ $id }}" 
    class="fixed inset-0 hidden"
    style="z-index: 9999;"
    aria-labelledby="modal-title" 
    role="dialog" 
    aria-modal="true"
>
    <!-- Backdrop -->
    <div 
        class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-75 backdrop-blur-sm"
        style="z-index: 9998;"
        onclick="closeAuthModal()"
    ></div>

    <!-- Modal container with perfect centering -->
    <div class="fixed inset-0 flex items-center justify-center p-4" style="z-index: 9999;">
        <!-- Modal panel with scrollable content -->
        <div class="relative w-full max-w-md max-h-[90vh] flex flex-col text-left transition-all transform bg-white dark:bg-gray-800 rounded-2xl shadow-2xl sm:max-w-lg border border-gray-200 dark:border-gray-700" style="z-index: 10000;">
            
            <!-- Close button - fixed at top -->
            <div class="absolute top-0 right-0 pt-4 pr-4 z-10">
                <button 
                    type="button" 
                    onclick="closeAuthModal()"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-200"
                >
                    <span class="sr-only">Tutup</span>
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Scrollable modal content -->
            <div class="flex-1 overflow-y-auto p-6 sm:p-8" id="modal-content">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>