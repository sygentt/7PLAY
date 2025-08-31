<!-- Auth Modal Container -->
<x-auth.modal id="auth-modal">
    <!-- Login Form -->
    <x-auth.login-form />
    
    <!-- Register Form -->
    <x-auth.register-form />
</x-auth.modal>

<!-- Include Auth Modal JavaScript -->
<script src="{{ asset('js/auth-modal.js') }}"></script>

<!-- Add meta tag for authentication status -->
<meta name="user-authenticated" content="{{ auth()->check() ? 'true' : 'false' }}">
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
/* Modal animation styles */
#auth-modal { 
    opacity: 0; 
    transition: opacity 0.2s ease-in-out;
    z-index: 9999 !important;
}
#auth-modal.show { 
    opacity: 1 !important; 
    display: block !important;
}
#auth-modal.hidden {
    display: none !important;
}

/* Backdrop blur */
#auth-modal .backdrop-blur-sm {
    backdrop-filter: blur(4px);
}

/* Smooth transitions for form switching */
#login-form-content,
#register-form-content {
    transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
}

#login-form-content.hidden,
#register-form-content.hidden {
    opacity: 0;
    transform: translateY(10px);
}

/* Loading animation */
@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

.animate-spin {
    animation: spin 1s linear infinite;
}

/* Focus styles */
#auth-modal input:focus {
    box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
}

/* Custom scrollbar for modal */
#auth-modal::-webkit-scrollbar {
    width: 6px;
}

#auth-modal::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

#auth-modal::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
}

#auth-modal::-webkit-scrollbar-thumb:hover {
    background: #555;
}

/* Mobile responsive adjustments */
@media (max-width: 640px) {
    #auth-modal .sm\\:max-w-lg,
    #auth-modal .md\\:max-w-xl,
    #auth-modal .lg\\:max-w-2xl {
        max-width: 95vw;
        margin: 0.5rem;
    }
    
    #auth-modal .sm\\:p-8 {
        padding: 1rem;
    }
}

@media (max-width: 480px) {
    #auth-modal .sm\\:max-w-lg,
    #auth-modal .md\\:max-w-xl,
    #auth-modal .lg\\:max-w-2xl {
        max-width: 98vw;
        margin: 0.25rem;
    }
    
    #auth-modal .sm\\:p-8 {
        padding: 0.75rem;
    }
}

/* Enhanced centering and vertical scrolling */
#auth-modal:not(.hidden) {
    display: block !important;
}

/* Force high z-index for all modal elements */
#auth-modal, 
#auth-modal * {
    z-index: 9999 !important;
}

/* Perfect modal centering */
#auth-modal .fixed.inset-0.flex.items-center.justify-center {
    min-height: 100vh;
    min-height: 100dvh; /* Dynamic viewport height for mobile */
}

/* Vertical scrolling for modal content */
#modal-content {
    scrollbar-width: thin;
    scrollbar-color: rgba(156, 163, 175, 0.5) transparent;
}

#modal-content::-webkit-scrollbar {
    width: 6px;
}

#modal-content::-webkit-scrollbar-track {
    background: transparent;
}

#modal-content::-webkit-scrollbar-thumb {
    background-color: rgba(156, 163, 175, 0.5);
    border-radius: 3px;
}

#modal-content::-webkit-scrollbar-thumb:hover {
    background-color: rgba(156, 163, 175, 0.7);
}

/* Responsive adjustments for small screens */
@media (max-width: 640px) {
    #auth-modal .fixed.inset-0.flex.items-center.justify-center {
        padding: 1rem;
    }
}

@media (max-height: 640px) and (orientation: landscape) {
    #auth-modal .fixed.inset-0.flex.items-center.justify-center {
        padding-top: 1rem;
        padding-bottom: 1rem;
    }
}
</style>

