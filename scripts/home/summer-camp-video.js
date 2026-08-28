// Summer camp video lightbox functions
window.openSummerCampVideo = function() {
  const lightbox = document.getElementById('summerCampVideoLightbox');
  const video = document.getElementById('summerCampVideo');

  if (lightbox && video) {
    lightbox.style.display = 'flex';
    document.body.style.overflow = 'hidden';

    // Small delay to ensure smooth animation
    setTimeout(() => {
      lightbox.classList.add('active');
    }, 10);

    // Reset video and ensure volume settings
    video.currentTime = 0;
    video.volume = 0.8;
    video.muted = false;

    // Simple approach: just play the video and let browser controls handle volume
    video.play().catch(e => {
      // If autoplay fails, that's ok - user can click play button
      console.log('Autoplay blocked, user needs to click play:', e);
    });

    // Ensure volume is set correctly when video loads
    video.addEventListener('loadeddata', function() {
      video.volume = 0.8;
      video.muted = false;
    });

    // Ensure volume when user starts playback
    video.addEventListener('play', function() {
      video.volume = 0.8;
      video.muted = false;
      // Alert instead of console.log to bypass CSP
      // alert('Video playing - Volume: ' + video.volume + ', Muted: ' + video.muted);
    });

    // Check if video has audio after 2 seconds of playing
    video.addEventListener('timeupdate', function() {
      if (video.currentTime > 2) {
        // Remove this listener after first check
        video.removeEventListener('timeupdate', arguments.callee);
        // Simple audio check - if webkitAudioDecodedByteCount exists and is 0, no audio
        if (typeof video.webkitAudioDecodedByteCount !== 'undefined') {
          if (video.webkitAudioDecodedByteCount === 0) {
            alert('WARNING: Video file appears to have no audio track!');
          }
        }
      }
    });
  }
};

window.closeSummerCampVideo = function() {
  const lightbox = document.getElementById('summerCampVideoLightbox');
  const video = document.getElementById('summerCampVideo');

  if (lightbox && video) {
    lightbox.classList.remove('active');
    video.pause();
    document.body.style.overflow = '';

    // Hide lightbox after animation completes
    setTimeout(() => {
      lightbox.style.display = 'none';
    }, 300);
  }
};

// Close lightbox when clicking outside video
document.addEventListener('DOMContentLoaded', function() {
  const lightbox = document.getElementById('summerCampVideoLightbox');

  if (lightbox) {
    lightbox.addEventListener('click', function(e) {
      if (e.target === this) {
        closeSummerCampVideo();
      }
    });
  }

  // Close with Escape key
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      closeSummerCampVideo();
    }
  });
});
