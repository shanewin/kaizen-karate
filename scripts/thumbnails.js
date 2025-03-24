document.addEventListener('DOMContentLoaded', function() {
    // Get all thumbnail items
    const thumbnails = document.querySelectorAll('.thumbnail-item');
    
    // Add click event to each thumbnail
    thumbnails.forEach(thumbnail => {
      thumbnail.addEventListener('click', function() {
        const mediaData = JSON.parse(this.getAttribute('data-media'));
        const modal = new bootstrap.Modal(document.getElementById('mediaModal'));
        const carouselInner = document.getElementById('carouselMedia');
        const modalTitle = document.getElementById('mediaModalLabel');
        
        // Clear previous carousel items
        carouselInner.innerHTML = '';
        
        // Create new carousel items from media data
        mediaData.forEach((media, index) => {
          const carouselItem = document.createElement('div');
          carouselItem.className = `carousel-item ${index === 0 ? 'active' : ''}`;
          
          if (media.type === 'image') {
            carouselItem.innerHTML = `<img src="${media.src}" class="d-block w-100" alt="${media.caption}">`;
          } else if (media.type === 'video') {
            carouselItem.innerHTML = `
              <video class="d-block w-100" controls autoplay muted loop>
                <source src="${media.src}" type="video/mp4">
                Your browser does not support the video tag.
              </video>
            `;
          }
          
          carouselInner.appendChild(carouselItem);
        });
        
        // Set the first caption
        if (mediaData.length > 0) {
          document.getElementById('mediaCaption').textContent = mediaData[0].caption;
        }
        
        // Update caption when carousel slides
        const mediaCarousel = document.getElementById('mediaCarousel');
        mediaCarousel.addEventListener('slid.bs.carousel', function(event) {
          const activeIndex = event.to;
          document.getElementById('mediaCaption').textContent = mediaData[activeIndex].caption;
        });
        
        // Show the modal
        modal.show();
      });
    });
  });