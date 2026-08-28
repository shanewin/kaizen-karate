// Kenpo Image Shuffle JavaScript
console.log('Kenpo shuffle script loaded');

let currentSlideIndex = 1;
let slides, dots, captionElement;

// Auto-advance timer
let autoSlideTimer;
const autoSlideInterval = 5000; // 5 seconds

// Initialize the shuffle when page loads
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content Loaded - initializing Kenpo shuffle...');
    
    // Delay initialization to ensure all elements are loaded
    setTimeout(function() {
        initKenpoShuffle();
    }, 100);
});

function initKenpoShuffle() {
    // Wait for tabs to be potentially loaded
    setTimeout(function() {
        // Get elements after DOM is loaded
        slides = document.querySelectorAll('.kenpo-image-shuffle .shuffle-slide');
        dots = document.querySelectorAll('.kenpo-image-shuffle .thumbnail-nav');
        captionElement = document.getElementById('current-caption');
        
        console.log('Kenpo shuffle initialized. Found', slides.length, 'slides');
        console.log('Found', dots.length, 'dots');
        console.log('Caption element:', captionElement);
        
        if (slides.length > 0) {
            // Reset to first slide since we only have 2 images now
            currentSlideIndex = 1;
            showSlide(currentSlideIndex);
            // Auto-slide disabled - manual navigation only
            
            console.log('Manual navigation mode - auto-slide disabled');
        } else {
            console.log('No slides found - may be in About tab');
        }
    }, 300);
}

// Re-initialize when gallery tab is shown and handle tab colors
document.addEventListener('DOMContentLoaded', function() {
    // Listen for tab changes
    const aboutTab = document.getElementById('about-tab');
    const ikcaTab = document.getElementById('ikca-tab');
    const galleryTab = document.getElementById('gallery-tab');
    const contactTab = document.getElementById('contact-tab');
    
    if (aboutTab && ikcaTab && galleryTab && contactTab) {
        // Function to set all tabs to inactive state
        function setAllTabsInactive() {
            aboutTab.style.color = '#333333';
            aboutTab.style.borderBottomColor = 'transparent';
            ikcaTab.style.color = '#333333';
            ikcaTab.style.borderBottomColor = 'transparent';
            galleryTab.style.color = '#333333';
            galleryTab.style.borderBottomColor = 'transparent';
            contactTab.style.color = '#333333';
            contactTab.style.borderBottomColor = 'transparent';
        }
        
        // Function to set a tab to active state
        function setTabActive(tab) {
            tab.style.color = '#dc3545';
            tab.style.borderBottomColor = '#dc3545';
        }
        
        // About tab event
        aboutTab.addEventListener('shown.bs.tab', function(e) {
            setAllTabsInactive();
            setTabActive(aboutTab);
        });
        
        // IKCA tab event
        ikcaTab.addEventListener('shown.bs.tab', function(e) {
            setAllTabsInactive();
            setTabActive(ikcaTab);
        });
        
        // Gallery tab event
        galleryTab.addEventListener('shown.bs.tab', function(e) {
            console.log('Gallery tab shown, re-initializing shuffle...');
            setAllTabsInactive();
            setTabActive(galleryTab);
            
            setTimeout(function() {
                initKenpoShuffle();
                // Also update caption immediately
                const currentCaptionElement = document.getElementById('current-caption');
                const firstSlide = document.querySelector('.kenpo-image-shuffle .shuffle-slide.active');
                if (currentCaptionElement && firstSlide) {
                    const caption = firstSlide.getAttribute('data-caption');
                    currentCaptionElement.textContent = caption;
                    console.log('Gallery tab - set initial caption:', caption);
                }
            }, 100);
        });
        
        // Contact tab event
        contactTab.addEventListener('shown.bs.tab', function(e) {
            setAllTabsInactive();
            setTabActive(contactTab);
        });
        
        // Add hover effects for all tabs
        [aboutTab, ikcaTab, galleryTab, contactTab].forEach(tab => {
            tab.addEventListener('mouseenter', function() {
                if (!tab.classList.contains('active')) {
                    tab.style.color = '#dc3545';
                    tab.style.borderBottomColor = 'rgba(220, 53, 69, 0.5)';
                }
            });
            
            tab.addEventListener('mouseleave', function() {
                if (!tab.classList.contains('active')) {
                    tab.style.color = '#333333';
                    tab.style.borderBottomColor = 'transparent';
                }
            });
        });
    }
});

// Show specific slide
function showSlide(n) {
    if (!slides || slides.length === 0) {
        console.log('No slides found');
        return;
    }
    
    if (n > slides.length) { currentSlideIndex = 1; }
    if (n < 1) { currentSlideIndex = slides.length; }
    
    console.log('Showing slide:', currentSlideIndex, 'of', slides.length);
    
    // Hide all slides
    slides.forEach((slide, index) => {
        slide.classList.remove('active');
        slide.style.display = 'none';
        console.log('Hiding slide', index + 1);
    });
    
    // Remove active class from all thumbnails
    if (dots) {
        dots.forEach((thumb, index) => {
            thumb.classList.remove('active');
            thumb.style.border = '2px solid rgba(255, 255, 255, 0.5)';
            thumb.style.opacity = '0.7';
        });
    }
    
    // Show current slide
    if (slides[currentSlideIndex - 1]) {
        slides[currentSlideIndex - 1].classList.add('active');
        slides[currentSlideIndex - 1].style.display = 'block';
        console.log('Showing slide', currentSlideIndex);
        
        // Update caption
        const caption = slides[currentSlideIndex - 1].getAttribute('data-caption');
        const currentCaptionElement = document.getElementById('current-caption');
        console.log('Caption element found:', currentCaptionElement);
        console.log('Caption text:', caption);
        
        if (currentCaptionElement && caption) {
            currentCaptionElement.textContent = caption;
            console.log('Updated caption to:', caption);
        } else {
            console.log('Caption update failed - element or caption missing');
        }
    }
    
    // Activate current thumbnail
    if (dots && dots[currentSlideIndex - 1]) {
        dots[currentSlideIndex - 1].classList.add('active');
        dots[currentSlideIndex - 1].style.border = '2px solid rgba(220, 53, 69, 0.8)';
        dots[currentSlideIndex - 1].style.opacity = '1';
    }
}

// Change slide (previous/next buttons)
function changeSlide(n) {
    console.log('changeSlide called with:', n);
    currentSlideIndex += n;
    showSlide(currentSlideIndex);
}

// Go to specific slide (thumbnail navigation)
function currentSlide(n) {
    console.log('currentSlide called with:', n);
    currentSlideIndex = n;
    showSlide(currentSlideIndex);
}

// Make functions available globally
window.changeSlide = changeSlide;
window.currentSlide = currentSlide;

// Auto-slide functions
function startAutoSlide() {
    stopAutoSlide(); // Clear any existing timer
    autoSlideTimer = setInterval(function() {
        currentSlideIndex++;
        showSlide(currentSlideIndex);
    }, autoSlideInterval);
}

function stopAutoSlide() {
    if (autoSlideTimer) {
        clearInterval(autoSlideTimer);
        autoSlideTimer = null;
    }
}

// Add new image to shuffle (for easy expansion)
function addShuffleImage(imagePath, caption, altText) {
    const shuffleContainer = document.querySelector('.kenpo-image-shuffle .shuffle-container');
    const shuffleDots = document.querySelector('.kenpo-image-shuffle .shuffle-dots');
    
    if (!shuffleContainer || !shuffleDots) return;
    
    // Create new slide
    const newSlide = document.createElement('div');
    newSlide.className = 'shuffle-slide';
    newSlide.setAttribute('data-caption', caption);
    newSlide.innerHTML = `
        <img src="${imagePath}" 
             alt="${altText}" 
             style="width: 100%; height: 400px; object-fit: cover;">
    `;
    
    // Insert before navigation dots
    shuffleContainer.insertBefore(newSlide, shuffleDots);
    
    // Create new dot
    const newDot = document.createElement('span');
    newDot.className = 'shuffle-dot';
    newDot.style.cssText = 'width: 12px; height: 12px; border-radius: 50%; background: rgba(255, 255, 255, 0.5); cursor: pointer; transition: all 0.3s ease;';
    newDot.onclick = function() { 
        currentSlide(document.querySelectorAll('.kenpo-image-shuffle .shuffle-slide').length); 
    };
    
    shuffleDots.appendChild(newDot);
    
    // Update arrays
    const updatedSlides = document.querySelectorAll('.kenpo-image-shuffle .shuffle-slide');
    const updatedDots = document.querySelectorAll('.kenpo-image-shuffle .shuffle-dot');
    
    console.log(`Added new image: ${imagePath} with caption: ${caption}`);
} 