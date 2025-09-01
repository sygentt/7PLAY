@props(['id' => 'auth-modal'])

<style>
#{{ $id }} {
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
}
#{{ $id }}.show {
    opacity: 1;
}
#{{ $id }} .modal-content {
    transform: scale(0.95) translateY(20px);
    transition: transform 0.3s ease-in-out;
}
#{{ $id }}.show .modal-content {
    transform: scale(1) translateY(0);
}
</style>

<!-- Auth Modal Overlay -->
<div 
    id="{{ $id }}" 
    class="fixed inset-0 hidden"
    style="z-index: 9999;"
    aria-labelledby="modal-title" 
    role="dialog" 
    aria-modal="true"
>
    <!-- Backdrop with modal container -->
    <div class="fixed inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm flex items-center justify-center p-4">
        <!-- Modal panel with scrollable content -->
        <div class="modal-content relative w-full max-w-md max-h-[90vh] flex flex-col text-left transform bg-white dark:bg-gray-800 rounded-2xl shadow-2xl sm:max-w-lg border border-gray-200 dark:border-gray-700">
            
            <!-- Scrollable modal content -->
            <div class="flex-1 overflow-y-auto p-6 sm:p-8" id="modal-content">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>