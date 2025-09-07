// Seat Count Modal JavaScript
class SeatCountModal {
    constructor() {
        this.modal = null;
        this.currentShowtime = null;
        this.seatCount = 1;
        this.maxSeats = 6;
        this.minSeats = 1;
        this.isOpen = false;
        this.init();
    }

    init() {
        // Wait for DOM to be ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => {
                this.initModal();
            });
        } else {
            this.initModal();
        }
    }
    
    initModal() {
        // Initialize modal elements
        this.modal = document.getElementById('seat-count-modal');
        console.log('Modal element found:', this.modal);
        
        if (!this.modal) {
            console.error('seat-count-modal element not found in DOM');
            return;
        }

        // Bind events
        this.bindEvents();
        this.updateSeatCount();
    }

    bindEvents() {
        // Close modal when clicking outside
        this.modal.addEventListener('click', (e) => {
            if (e.target === this.modal) {
                this.close();
            }
        });

        // Escape key to close
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isOpen) {
                this.close();
            }
        });
    }

    async open(showtimeId) {
        console.log('Opening seat count modal for showtime:', showtimeId);
        
        if (!this.modal) {
            console.error('Modal element not found');
            return;
        }

        this.currentShowtime = showtimeId;
        
        try {
            // Show modal immediately for better UX
            this.modal.classList.remove('hidden');
            this.modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
            
            // Trigger animation
            setTimeout(() => {
                const modalContent = this.modal.querySelector('.modal-content');
                if (modalContent) {
                    modalContent.classList.remove('opacity-0', 'scale-95');
                    modalContent.classList.add('opacity-100', 'scale-100');
                } else {
                    console.error('Modal content not found');
                }
            }, 10);
            
            this.isOpen = true;
            
            // Fetch showtime details
            const response = await fetch(`/api/showtimes/${showtimeId}`);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const result = await response.json();
            console.log('API Response:', result);
            
            if (result.success && result.data) {
                this.populateMovieInfo(result.data);
                this.resetSeatCount();
            } else {
                throw new Error(result.message || 'Failed to load showtime data');
            }
            
        } catch (error) {
            console.error('Error loading showtime details:', error);
            // Fallback - show modal anyway with basic info
            this.populateMovieInfo({
                movie: { title: 'Film Terpilih' },
                cinema: { full_name: 'Cinema XXI' },
                show_date: new Date().toISOString().split('T')[0],
                show_time: '12:00'
            });
            this.resetSeatCount();
        }
    }

    close() {
        if (!this.modal || !this.isOpen) return;

        const modalContent = this.modal.querySelector('.modal-content');
        if (modalContent) {
            modalContent.classList.remove('opacity-100', 'scale-100');
            modalContent.classList.add('opacity-0', 'scale-95');
        }

        setTimeout(() => {
            this.modal.classList.add('hidden');
            this.modal.classList.remove('flex');
            document.body.style.overflow = '';
        }, 300);

        this.isOpen = false;
    }

    populateMovieInfo(showtime) {
        // Update movie title
        const titleElement = document.getElementById('modal-movie-title');
        if (titleElement && showtime.movie) {
            titleElement.textContent = showtime.movie.title || 'Movie Title';
        }

        // Update brand name
        const brandElement = document.getElementById('modal-brand-name');
        if (brandElement && showtime.cinema) {
            brandElement.textContent = showtime.cinema.brand || showtime.cinema.full_name || '';
        }

        // Update cinema info
        const cinemaElement = document.getElementById('modal-cinema-info');
        if (cinemaElement && showtime.cinema) {
            cinemaElement.textContent = showtime.cinema.full_name || 'Cinema Name';
        }

        // Update showtime info
        const showtimeElement = document.getElementById('modal-showtime-info');
        const showtimeDisplay = document.getElementById('showtime-display');
        
        if (showtime.show_date && showtime.show_time) {
            const showDate = new Date(showtime.show_date).toLocaleDateString('id-ID', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
            
            if (showtimeElement) {
                showtimeElement.textContent = `${showDate}, ${showtime.show_time}`;
            }
            
            if (showtimeDisplay) {
                showtimeDisplay.textContent = showtime.show_time;
            }
        }
    }

    changeSeatCount(delta) {
        const newCount = this.seatCount + delta;
        
        if (newCount >= this.minSeats && newCount <= this.maxSeats) {
            this.seatCount = newCount;
            this.updateSeatCount();
        }
    }

    setSeatCount(count) {
        if (count >= this.minSeats && count <= this.maxSeats) {
            this.seatCount = count;
            this.updateSeatCount();
        }
    }

    updateSeatCount() {
        const seatCountElement = document.getElementById('seat-count');
        const seatStatusElement = document.getElementById('seat-status');
        const selectedSeatCountElement = document.getElementById('selected-seat-count');
        const decreaseBtn = document.getElementById('decrease-seats');
        const increaseBtn = document.getElementById('increase-seats');

        if (seatCountElement) {
            seatCountElement.textContent = this.seatCount;
        }

        if (seatStatusElement) {
            seatStatusElement.textContent = this.seatCount > 0 ? 
                'Kamu belum pilih kursi' : 
                'Kamu belum pilih kursi';
        }

        if (selectedSeatCountElement) {
            selectedSeatCountElement.textContent = this.seatCount;
        }

        // Update button states
        if (decreaseBtn) {
            decreaseBtn.disabled = this.seatCount <= this.minSeats;
        }
        
        if (increaseBtn) {
            increaseBtn.disabled = this.seatCount >= this.maxSeats;
        }
    }

    resetSeatCount() {
        this.seatCount = 1;
        this.updateSeatCount();
    }

    proceedToSeatSelection() {
        if (this.currentShowtime && this.seatCount > 0) {
            // Store selected seat count in session storage for later use
            sessionStorage.setItem('selectedSeatCount', this.seatCount);
            
            // Navigate to seat selection page
            window.location.href = `/booking/select-seats/${this.currentShowtime}?seats=${this.seatCount}`;
        }
    }
}

// Global functions - implemented in layout

function closeSeatCountModal() {
    if (window.seatCountModal) {
        window.seatCountModal.close();
    }
}

function changeSeatCount(delta) {
    if (window.seatCountModal) {
        window.seatCountModal.changeSeatCount(delta);
    }
}

function proceedToSeatSelection() {
    if (window.seatCountModal) {
        window.seatCountModal.proceedToSeatSelection();
    }
}

// Initialize seat count modal when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.seatCountModal = new SeatCountModal();
});
