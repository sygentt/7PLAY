<!-- YouTube Video Modal -->
<div id="youtubeModal" class="fixed inset-0 z-[9999] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop - Click to close -->
    <div class="fixed inset-0 bg-black/80 backdrop-blur-sm transition-opacity cursor-pointer" onclick="closeYoutubeModal()"></div>
    
    <!-- Modal Container -->
    <div class="flex min-h-full items-center justify-center p-4" onclick="closeYoutubeModal()">
        <div class="relative w-full max-w-5xl transform transition-all" onclick="event.stopPropagation()">
            <!-- Video Container -->
            <div class="relative bg-black rounded-xl overflow-hidden shadow-2xl" style="padding-bottom: 56.25%;">
                <iframe 
                    id="youtubeIframe"
                    class="absolute inset-0 w-full h-full"
                    src=""
                    title="YouTube video player" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                    allowfullscreen
                ></iframe>
            </div>
            
            <!-- Video Info (Optional) -->
            <div class="mt-4 text-center">
                <p class="text-white/80 text-sm" id="videoTitle">Trailer Film</p>
            </div>
        </div>
    </div>
</div>

<script>
/**
 * Open YouTube Modal
 * @param {string} youtubeUrl - Full YouTube URL (youtu.be or youtube.com)
 * @param {string} movieTitle - Optional movie title for display
 */
function openYoutubeModal(youtubeUrl, movieTitle = 'Trailer Film') {
    const modal = document.getElementById('youtubeModal');
    const iframe = document.getElementById('youtubeIframe');
    const videoTitle = document.getElementById('videoTitle');
    
    if (!modal || !iframe) return;
    
    // Extract video ID from URL
    const videoId = extractYoutubeVideoId(youtubeUrl);
    
    if (!videoId) {
        console.error('Invalid YouTube URL:', youtubeUrl);
        return;
    }
    
    // Set iframe src with autoplay
    iframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0&modestbranding=1`;
    
    // Set video title
    if (videoTitle) {
        videoTitle.textContent = movieTitle;
    }
    
    // Show modal
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    // Add escape key listener
    document.addEventListener('keydown', handleEscapeKey);
}

/**
 * Close YouTube Modal
 */
function closeYoutubeModal() {
    const modal = document.getElementById('youtubeModal');
    const iframe = document.getElementById('youtubeIframe');
    
    if (!modal || !iframe) return;
    
    // Stop video by clearing src
    iframe.src = '';
    
    // Hide modal
    modal.classList.add('hidden');
    document.body.style.overflow = '';
    
    // Remove escape key listener
    document.removeEventListener('keydown', handleEscapeKey);
}

/**
 * Extract YouTube Video ID from various URL formats
 * @param {string} url - YouTube URL
 * @returns {string|null} Video ID or null if invalid
 */
function extractYoutubeVideoId(url) {
    if (!url) return null;
    
    // Patterns for different YouTube URL formats
    const patterns = [
        /(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([^&\?\/\s]{11})/,
        /youtube\.com\/watch\?.*v=([^&\?\/\s]{11})/,
    ];
    
    for (const pattern of patterns) {
        const match = url.match(pattern);
        if (match && match[1]) {
            return match[1];
        }
    }
    
    return null;
}

/**
 * Handle Escape key press
 */
function handleEscapeKey(event) {
    if (event.key === 'Escape') {
        closeYoutubeModal();
    }
}

// Prevent modal background scroll on mobile
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('youtubeModal');
    if (modal) {
        modal.addEventListener('touchmove', function(e) {
            if (e.target === modal) {
                e.preventDefault();
            }
        }, { passive: false });
    }
});
</script>

<style>
/* Modal animation */
#youtubeModal {
    animation: fadeIn 0.3s ease-in-out;
}

#youtubeModal.hidden {
    animation: fadeOut 0.3s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes fadeOut {
    from {
        opacity: 1;
    }
    to {
        opacity: 0;
    }
}

/* Responsive adjustments */
@media (max-width: 640px) {
    #youtubeModal .max-w-5xl {
        max-width: 95%;
    }
}
</style>

