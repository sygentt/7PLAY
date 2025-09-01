@extends('layouts.public')

@section('title', 'Test Modal - Debug')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-12">
    <div class="max-w-4xl mx-auto px-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold mb-8 text-gray-900 dark:text-white">Modal Debug Test</h1>
            
            <!-- Test Buttons -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg">
                    <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Main Modal Test</h2>
                    <button 
                        onclick="openSeatCountModal(123)"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors"
                    >
                        Test Main Modal (Showtime ID: 123)
                    </button>
                </div>
                
                <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg">
                    <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Fallback Modal Test</h2>
                    <button 
                        onclick="openSimpleModal(456)"
                        class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors"
                    >
                        Test Fallback Modal (Showtime ID: 456)
                    </button>
                </div>
            </div>
            
            <!-- Debug Info -->
            <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-6 mb-8">
                <h3 class="text-lg font-semibold mb-4 text-yellow-800 dark:text-yellow-200">Debug Information</h3>
                <button 
                    onclick="debugModal()"
                    class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded font-medium mr-4 mb-2"
                >
                    Run Debug Check
                </button>
                <button 
                    onclick="console.clear()"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded font-medium mb-2"
                >
                    Clear Console
                </button>
                <div class="text-sm text-yellow-700 dark:text-yellow-300 mt-4">
                    <strong>Instruksi:</strong>
                    <ol class="list-decimal list-inside mt-2 space-y-1">
                        <li>Buka Developer Tools (F12)</li>
                        <li>Lihat tab Console</li>
                        <li>Klik "Run Debug Check" untuk melihat status modal</li>
                        <li>Klik "Test Main Modal" untuk test modal utama</li>
                        <li>Jika gagal, otomatis akan menggunakan fallback modal</li>
                    </ol>
                </div>
            </div>
            
            <!-- Modal Elements Check -->
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4 text-blue-800 dark:text-blue-200">Modal Elements Status</h3>
                <div id="modal-status" class="font-mono text-sm text-gray-700 dark:text-gray-300">
                    Loading...
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update modal status
    function updateModalStatus() {
        const statusDiv = document.getElementById('modal-status');
        const modalElement = document.getElementById('seat-count-modal');
        const seatCountModal = window.seatCountModal;
        
        let status = '';
        status += `DOM Ready State: ${document.readyState}\n`;
        status += `Modal Element Found: ${modalElement ? 'YES' : 'NO'}\n`;
        status += `Modal Element ID: ${modalElement ? modalElement.id : 'N/A'}\n`;
        status += `SeatCountModal Class: ${typeof SeatCountModal !== 'undefined' ? 'LOADED' : 'NOT LOADED'}\n`;
        status += `Window seatCountModal: ${seatCountModal ? 'INITIALIZED' : 'NOT INITIALIZED'}\n`;
        
        if (seatCountModal) {
            status += `Modal Instance Has Element: ${seatCountModal.modal ? 'YES' : 'NO'}\n`;
        }
        
        status += `\nAvailable Global Functions:\n`;
        status += `- openSeatCountModal: ${typeof openSeatCountModal !== 'undefined' ? 'YES' : 'NO'}\n`;
        status += `- openSimpleModal: ${typeof openSimpleModal !== 'undefined' ? 'YES' : 'NO'}\n`;
        status += `- debugModal: ${typeof debugModal !== 'undefined' ? 'YES' : 'NO'}\n`;
        
        statusDiv.textContent = status;
    }
    
    // Update status immediately and every 2 seconds
    updateModalStatus();
    setInterval(updateModalStatus, 2000);
});
</script>
@endpush
