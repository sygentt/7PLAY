// Auth Modal JavaScript
class AuthModal {
    constructor() {
        this.modal = null;
        this.isOpen = false;
        this.currentForm = 'login'; // 'login' or 'register'
        this.init();
    }

    init() {
        const ready = () => {
            this.modal = document.getElementById('auth-modal');
            if (!this.modal) return;
            this.bindEvents();
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', ready);
        } else {
            ready();
        }
    }

    bindEvents() {
        // Login form submission
        const loginForm = document.getElementById('modal-login-form');
        if (loginForm) {
            loginForm.addEventListener('submit', (e) => this.handleLoginSubmit(e));
        }

        // Register form submission
        const registerForm = document.getElementById('modal-register-form');
        if (registerForm) {
            registerForm.addEventListener('submit', (e) => this.handleRegisterSubmit(e));
        }

        // Real-time password confirmation validation
        const passwordConfirmation = document.getElementById('modal-password-confirmation');
        if (passwordConfirmation) {
            passwordConfirmation.addEventListener('input', () => this.validatePasswordConfirmation());
        }

        // Prevent form buttons from accidentally closing modal
        const formButtons = document.querySelectorAll('#modal-login-form button, #modal-register-form button');
        formButtons.forEach(btn => {
            if (btn.type === 'submit') return; // Skip submit buttons
            if (btn.onclick && btn.onclick.toString().includes('switch')) return; // Skip switch buttons
            if (btn.onclick && btn.onclick.toString().includes('toggleModalPassword')) return; // Skip password toggle
            if (btn.onclick && btn.onclick.toString().includes('showForgotPassword')) return; // Skip forgot password
        });

        // ESC key to close modal
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isOpen) {
                this.close();
            }
        });


    }

    open(formType = 'login') {
        if (!this.modal) {
            this.modal = document.getElementById('auth-modal');
            if (!this.modal) {
                return;
            }
        }

        this.currentForm = formType;
        
        // Immediately show modal
        this.modal.classList.remove('hidden');
        this.modal.style.display = 'block';
        this.modal.style.zIndex = '9999';
        
        // Show appropriate form
        if (formType === 'login') {
            this.showLoginForm();
        } else {
            this.showRegisterForm();
        }

        // Trigger fade-in after a brief delay
        setTimeout(() => {
            this.modal.classList.add('show');
            this.isOpen = true;
            document.body.style.overflow = 'hidden';
            
            // Bind close events after modal is fully shown
            this.bindCloseEvents();
        }, 10);

        this.isOpen = true;
        document.body.style.overflow = 'hidden';

        // Focus first input
        setTimeout(() => {
            const firstInput = this.modal.querySelector('input:not([type="hidden"])');
            if (firstInput) firstInput.focus();
        }, 100);
    }

    bindCloseEvents() {
        if (!this.modal) return;

        // Avoid replacing the modal element; that removes all child event listeners.
        // Instead, attach a single delegated click handler once.
        if (!this._closeHandlerBound) {
            this.modal.addEventListener('click', (e) => {
                const modalContent = e.target.closest('.modal-content');
                const isFormElement = e.target.closest('form, input, button, select, textarea, label');
                if (!modalContent && !isFormElement) {
                    this.close();
                }
            }, true);
            this._closeHandlerBound = true;
        }
    }

    close() {
        if (!this.modal || !this.isOpen) {
            return;
        }

        // Trigger CSS-based fade-out
        this.modal.classList.remove('show');

        setTimeout(() => {
            this.modal.classList.add('hidden');
            this.modal.style.display = 'none'; // Force hide
            this.isOpen = false;
            document.body.style.overflow = '';
            this.clearErrors();
            this.resetForms();
        }, 300);
    }

    showLoginForm() {
        const loginContent = document.getElementById('login-form-content');
        const registerContent = document.getElementById('register-form-content');
        
        if (loginContent) loginContent.classList.remove('hidden');
        if (registerContent) registerContent.classList.add('hidden');
    }

    showRegisterForm() {
        const loginContent = document.getElementById('login-form-content');
        const registerContent = document.getElementById('register-form-content');
        
        if (loginContent) loginContent.classList.add('hidden');
        if (registerContent) registerContent.classList.remove('hidden');
    }

    switchToRegister() {
        this.showRegisterForm();
        this.currentForm = 'register';
        this.clearErrors();
    }

    switchToLogin() {
        this.showLoginForm();
        this.currentForm = 'login';
        this.clearErrors();
    }

    async handleLoginSubmit(e) {
        e.preventDefault();
        
        const form = e.target;
        const submitBtn = document.getElementById('modal-login-submit');
        const submitText = document.getElementById('modal-login-text');
        const submitLoading = document.getElementById('modal-login-loading');
        
        // Clear previous errors
        this.clearErrors('login');
        
        // Show loading state
        submitBtn.disabled = true;
        submitText.classList.add('hidden');
        submitLoading.classList.remove('hidden');

        try {
            const formData = new FormData(form);
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                }
            });

            const result = await response.json();

            if (response.ok && result.success !== false) {
                // Success - reload page or redirect
                if (result.redirect) {
                    window.location.href = result.redirect;
                } else {
                    window.location.reload();
                }
            } else {
                // Handle validation errors
                this.displayErrors(result.errors || {}, 'login');
                
                if (result.message) {
                    this.showErrorMessage(result.message, 'login');
                }
            }
        } catch (error) {
            this.showErrorMessage('Terjadi kesalahan. Silakan coba lagi.', 'login');
        } finally {
            // Reset button state
            submitBtn.disabled = false;
            submitText.classList.remove('hidden');
            submitLoading.classList.add('hidden');
        }
    }

    async handleRegisterSubmit(e) {
        e.preventDefault();
        
        const form = e.target;
        const submitBtn = document.getElementById('modal-register-submit');
        const submitText = document.getElementById('modal-register-text');
        const submitLoading = document.getElementById('modal-register-loading');
        
        // Clear previous errors
        this.clearErrors('register');
        
        // Show loading state
        submitBtn.disabled = true;
        submitText.classList.add('hidden');
        submitLoading.classList.remove('hidden');

        try {
            const formData = new FormData(form);
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                }
            });

            const result = await response.json();

            if (response.ok && result.success !== false) {
                // Success - reload page or redirect
                if (result.redirect) {
                    window.location.href = result.redirect;
                } else {
                    window.location.reload();
                }
            } else {
                // Handle validation errors
                this.displayErrors(result.errors || {}, 'register');
                
                if (result.message) {
                    this.showErrorMessage(result.message, 'register');
                }
            }
        } catch (error) {
            this.showErrorMessage('Terjadi kesalahan. Silakan coba lagi.', 'register');
        } finally {
            // Reset button state
            submitBtn.disabled = false;
            submitText.classList.remove('hidden');
            submitLoading.classList.add('hidden');
        }
    }

    displayErrors(errors, formType) {
        Object.keys(errors).forEach(field => {
            const errorElement = document.getElementById(`modal-${formType === 'register' && field === 'email' ? 'register-' : ''}${field}-error`);
            if (errorElement && errors[field].length > 0) {
                errorElement.textContent = errors[field][0];
                errorElement.classList.remove('hidden');
            }
        });
    }

    showErrorMessage(message, formType) {
        const errorElement = document.getElementById(`modal-${formType}-error`);
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.classList.remove('hidden');
        }
    }

    clearErrors(formType) {
        const formTypes = formType ? [formType] : ['login', 'register'];
        
        formTypes.forEach(type => {
            // Clear field errors
            const fieldErrors = document.querySelectorAll(`[id*="modal-${type}"][id*="-error"]`);
            fieldErrors.forEach(error => {
                error.textContent = '';
                error.classList.add('hidden');
            });

            // Clear general error
            const generalError = document.getElementById(`modal-${type}-error`);
            if (generalError) {
                generalError.textContent = '';
                generalError.classList.add('hidden');
            }
        });
    }

    resetForms() {
        const loginForm = document.getElementById('modal-login-form');
        const registerForm = document.getElementById('modal-register-form');
        
        if (loginForm) loginForm.reset();
        if (registerForm) registerForm.reset();
    }

    validatePasswordConfirmation() {
        const password = document.getElementById('modal-register-password');
        const confirmation = document.getElementById('modal-password-confirmation');
        const errorElement = document.getElementById('modal-password-confirmation-error');
        
        if (!password || !confirmation || !errorElement) return;

        if (confirmation.value && password.value !== confirmation.value) {
            errorElement.textContent = 'Konfirmasi password tidak cocok';
            errorElement.classList.remove('hidden');
            confirmation.style.borderColor = '#ef4444';
        } else {
            errorElement.classList.add('hidden');
            confirmation.style.borderColor = '';
        }
    }
}

// Password toggle functions
function toggleModalPassword(fieldId) {
    const passwordInput = document.getElementById(fieldId);
    if (!passwordInput) return;

    let eyeOpenId, eyeClosedId;
    
    if (fieldId === 'modal-password') {
        eyeOpenId = 'modal-eye-open';
        eyeClosedId = 'modal-eye-closed';
    } else if (fieldId === 'modal-register-password') {
        eyeOpenId = 'modal-register-eye-open';
        eyeClosedId = 'modal-register-eye-closed';
    } else if (fieldId === 'modal-password-confirmation') {
        eyeOpenId = 'modal-confirmation-eye-open';
        eyeClosedId = 'modal-confirmation-eye-closed';
    }

    const eyeOpen = document.getElementById(eyeOpenId);
    const eyeClosed = document.getElementById(eyeClosedId);
    
    if (!eyeOpen || !eyeClosed) return;

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeOpen.classList.add('hidden');
        eyeClosed.classList.remove('hidden');
    } else {
        passwordInput.type = 'password';
        eyeOpen.classList.remove('hidden');
        eyeClosed.classList.add('hidden');
    }
}

// Global functions
function openAuthModal(formType = 'login') {
    if (window.authModal) {
        window.authModal.open(formType);
    } else {
        // Fallback initialization
        window.authModal = new AuthModal();
        setTimeout(() => {
            window.authModal.open(formType);
        }, 100);
    }
}

// closeAuthModal function - kept for compatibility
function closeAuthModal() {
    if (window.authModal && typeof window.authModal.close === 'function') {
        window.authModal.close();
    } else {
        // Fallback direct closure
        const modal = document.getElementById('auth-modal');
        if (modal) {
            modal.classList.remove('show');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.style.display = 'none';
                document.body.style.overflow = '';
            }, 300);
        }
    }
}

function switchToLogin() {
    if (window.authModal && typeof window.authModal.switchToLogin === 'function') {
        window.authModal.switchToLogin();
    }
}

function switchToRegister() {
    if (window.authModal && typeof window.authModal.switchToRegister === 'function') {
        window.authModal.switchToRegister();
    }
}

function showForgotPassword() {
    // For now, redirect to forgot password page
    window.location.href = '/forgot-password';
}

function requireAuth(callback) {
    // Check if user is authenticated
    const isAuthenticated = document.querySelector('meta[name="user-authenticated"]')?.getAttribute('content') === 'true';
    
    if (isAuthenticated) {
        // User is authenticated, execute callback
        if (typeof callback === 'function') {
            callback();
        }
    } else {
        // User not authenticated, show login modal
        openAuthModal('login');
    }
}

// Initialize auth modal
window.authModal = new AuthModal();

