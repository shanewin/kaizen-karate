// Video control functions
window.togglePlayPause = function() {
    const video = document.getElementById('hero-video');
    const pausePlayIcon = document.getElementById('pausePlayIcon');

    if (!video) return;

    if (video.paused) {
        video.play().then(() => {
            if (pausePlayIcon) {
                pausePlayIcon.className = 'fas fa-pause';
            }
        }).catch(e => {
            console.error('Error playing video:', e);
        });
    } else {
        video.pause();
        if (pausePlayIcon) {
            pausePlayIcon.className = 'fas fa-play';
        }
    }
};

window.toggleMute = function() {
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
};
