// Video Controls Functionality

// Global functions for inline onclick handlers
function togglePlayPause() {
    const video = document.getElementById('hero-video');
    const pausePlayIcon = document.getElementById('pausePlayIcon');
    
    if (!video) return;
    
    if (video.paused) {
        video.play().then(() => {
            if (pausePlayIcon) {
                pausePlayIcon.className = 'fas fa-pause';
            }
        }).catch(e => console.error('Error playing video:', e));
    } else {
        video.pause();
        if (pausePlayIcon) {
            pausePlayIcon.className = 'fas fa-play';
        }
    }
}

function toggleMute() {
    const video = document.getElementById('hero-video');
    const muteUnmuteIcon = document.getElementById('muteUnmuteIcon');
    
    if (!video) return;
    
    if (video.muted) {
        video.muted = false;
        if (muteUnmuteIcon) {
            muteUnmuteIcon.className = 'fas fa-volume-up';
        }
    } else {
        video.muted = true;
        if (muteUnmuteIcon) {
            muteUnmuteIcon.className = 'fas fa-volume-mute';
        }
    }
}

function initVideoControls() {
    const video = document.getElementById('hero-video');
    const pausePlayBtn = document.getElementById('pausePlayBtn');
    const pausePlayIcon = document.getElementById('pausePlayIcon');
    const muteUnmuteBtn = document.getElementById('muteUnmuteBtn');
    const muteUnmuteIcon = document.getElementById('muteUnmuteIcon');
    
    // Ensure all elements exist before adding event listeners
    if (!video || !pausePlayBtn || !muteUnmuteBtn) {
        return false;
    }

    // Pause/Play functionality
    pausePlayBtn.addEventListener('click', function() {
        if (video.paused) {
            video.play().then(() => {
                pausePlayIcon.className = 'fas fa-pause';
                pausePlayBtn.title = 'Pause Video';
            }).catch(e => console.error('Error playing video:', e));
        } else {
            video.pause();
            pausePlayIcon.className = 'fas fa-play';
            pausePlayBtn.title = 'Play Video';
        }
    });

    // Mute/Unmute functionality
    muteUnmuteBtn.addEventListener('click', function() {
        if (video.muted) {
            video.muted = false;
            muteUnmuteIcon.className = 'fas fa-volume-up';
            muteUnmuteBtn.title = 'Mute Video';
        } else {
            video.muted = true;
            muteUnmuteIcon.className = 'fas fa-volume-mute';
            muteUnmuteBtn.title = 'Unmute Video';
        }
    });

    // Handle video events
    video.addEventListener('play', function() {
        pausePlayIcon.className = 'fas fa-pause';
        pausePlayBtn.title = 'Pause Video';
    });

    video.addEventListener('pause', function() {
        pausePlayIcon.className = 'fas fa-play';
        pausePlayBtn.title = 'Play Video';
    });

    // Auto-hide controls on mobile after 3 seconds of no interaction
    let controlsTimeout;
    const videoControls = document.querySelector('.video-controls');
    
    function showControls() {
        if (videoControls) {
            videoControls.style.opacity = '1';
            clearTimeout(controlsTimeout);
            controlsTimeout = setTimeout(() => {
                if (window.innerWidth <= 768) {
                    videoControls.style.opacity = '0.7';
                }
            }, 3000);
        }
    }

    // Show controls on interaction
    video.addEventListener('click', showControls);
    video.addEventListener('touchstart', showControls);
    
    // Keep controls visible on desktop
    if (window.innerWidth > 768 && videoControls) {
        videoControls.style.opacity = '1';
    }
    
    return true;
}

// Initialize video controls
document.addEventListener('DOMContentLoaded', initVideoControls);

// Also try after a short delay in case DOM isn't fully ready
setTimeout(initVideoControls, 500); 