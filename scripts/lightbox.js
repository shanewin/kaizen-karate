document.addEventListener('DOMContentLoaded', () => {
  // Get all panels and the lightbox
  const panels = document.querySelectorAll('.panel');
  const lightbox = document.getElementById('lightbox');
  const lightboxContent = document.querySelector('.lightbox-content');
  const lightboxVideo = document.getElementById('lightbox-video');
  const lightboxImage = document.getElementById('lightbox-image');
  const lightboxCaption = document.querySelector('.lightbox-caption');
  const closeBtn = document.querySelector('.close-btn');
  const prevBtn = document.querySelector('.lightbox-nav.prev');
  const nextBtn = document.querySelector('.lightbox-nav.next');

  let currentPanelMedia = []; // Array to store media items for the current panel
  let currentIndex = 0; // Index of the currently displayed media item

  // Add click event listeners to panels
  panels.forEach(panel => {
    panel.addEventListener('click', () => {
      console.log('Panel clicked'); // Debugging
      currentPanelMedia = JSON.parse(panel.getAttribute('data-media'));
      console.log('Media items:', currentPanelMedia); // Debugging
      currentIndex = 0; // Start with the first media item
      openLightbox(currentIndex);
    });
  });

  // Function to open the lightbox
  function openLightbox(index) {
    console.log('Opening lightbox with index:', index); // Debugging
    const media = currentPanelMedia[index];
    console.log('Current media:', media); // Debugging
    if (media.type === 'video') {
      lightboxVideo.src = media.src;
      lightboxVideo.style.display = 'block';
      lightboxImage.style.display = 'none';
    } else {
      lightboxImage.src = media.src;
      lightboxImage.style.display = 'block';
      lightboxVideo.style.display = 'none';
    }
    lightboxCaption.textContent = media.caption;
    lightbox.style.display = 'flex';
  }

  // Function to close the lightbox
  function closeLightbox() {
    lightbox.style.display = 'none';
    lightboxVideo.pause(); // Pause the video when closing
  }

  // Function to navigate to the previous media item
  function prevMedia() {
    currentIndex = (currentIndex - 1 + currentPanelMedia.length) % currentPanelMedia.length;
    openLightbox(currentIndex);
  }

  // Function to navigate to the next media item
  function nextMedia() {
    currentIndex = (currentIndex + 1) % currentPanelMedia.length;
    openLightbox(currentIndex);
  }

  // Close lightbox when the close button is clicked
  closeBtn.addEventListener('click', closeLightbox);

  // Close lightbox when clicking outside the video
  lightbox.addEventListener('click', (e) => {
    if (e.target === lightbox) {
      closeLightbox();
    }
  });

  // Navigate to previous media item
  prevBtn.addEventListener('click', (e) => {
    e.stopPropagation(); // Prevent event from bubbling up to the lightbox
    prevMedia();
  });

  // Navigate to next media item
  nextBtn.addEventListener('click', (e) => {
    e.stopPropagation(); // Prevent event from bubbling up to the lightbox
    nextMedia();
  });
});