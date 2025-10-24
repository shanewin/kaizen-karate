gsap.registerPlugin(ScrollTrigger);

// Set initial states
gsap.set("#logo_white", { autoAlpha: 0, display: "none", height: 'auto', zIndex: 'auto' });
gsap.set("#logo_black", { autoAlpha: 0, display: "none", height: 'auto', zIndex: 'auto' });
gsap.set("#logo_main", { autoAlpha: 0, display: "none" });
gsap.set("#bg_grids", { autoAlpha: 1, display: "block" });
gsap.set("#bg_build", { autoAlpha: 1, display: "block", width: '100%' });
gsap.set("#bg_buildCropped", { autoAlpha: 1, display: "block", width: '51%' });

// Create a timeline for animations
let tl = gsap.timeline({
    scrollTrigger: {
        trigger: ".hero_section", // Fixed typo
        start: "top top",
        end: "+=1200px", // Pin for 1200 pixels of scroll
        scrub: true,
        pin: true,
    },
});

// Animate the main logo
tl.to("#logo_main", {
    autoAlpha: 1,
    display: "block",
    duration: 2,
})
.to("#bg_build", {
    width: '75.5%',
    duration: 2,
})
.set("#bg_build", {
    autoAlpha: 0,
})
.to('#logo_white', {
    autoAlpha: 1,
    zIndex: 99,
})
.to('#logo_main', {
    autoAlpha: 0,
    display: "none",
});

// Add parallax effect to amenity panels
document.querySelectorAll('.amenity-panel').forEach((panel, index) => {
    gsap.from(panel, {
        y: 30 * (index + 1), // Smaller parallax distance for smoother effect
        opacity: 0,
        duration: 1,
        scrollTrigger: {
            trigger: panel,
            start: "top 80%",
            end: "bottom 20%",
            scrub: true,
        },
    });
});

// Note: Instructor accordion functionality moved to dedicated scripts/accordion.js file

// Hero Close Button Functionality - Multiple approaches
function setupHeroCloseButton() {
    console.log('Setting up hero close button...');
    
    const heroCloseBtn = document.getElementById('heroCloseBtn');
    const heroContent = document.getElementById('heroContent');
    
    console.log('heroCloseBtn:', heroCloseBtn);
    console.log('heroContent:', heroContent);
    
    if (heroCloseBtn && heroContent) {
        console.log('Both elements found, adding event listener...');
        
        // Method 1: Regular event listener
        heroCloseBtn.addEventListener('click', function(e) {
            console.log('Close button clicked!');
            e.preventDefault();
            e.stopPropagation();
            heroContent.classList.add('hidden');
            console.log('Added hidden class to hero content');
        });
        
        // Method 2: Also add onclick attribute as backup
        heroCloseBtn.onclick = function(e) {
            console.log('Close button clicked via onclick!');
            e.preventDefault();
            e.stopPropagation();
            heroContent.classList.add('hidden');
            console.log('Added hidden class via onclick');
        };
        
        console.log('Event listeners added successfully');
    } else {
        console.log('Elements not found - heroCloseBtn:', heroCloseBtn, 'heroContent:', heroContent);
    }
}

// Try multiple loading methods
document.addEventListener('DOMContentLoaded', setupHeroCloseButton);

// Also try with window.onload as backup
window.addEventListener('load', function() {
    console.log('Window loaded, trying hero close button setup again...');
    setupHeroCloseButton();
});

// Try after a short delay as well
setTimeout(function() {
    console.log('Timeout reached, trying hero close button setup...');
    setupHeroCloseButton();
}, 1000);

console.log('Register Now JS loaded');
document.addEventListener('DOMContentLoaded', function() {
  var btn = document.getElementById('heroRegisterBtn');
  var panel = document.getElementById('heroRegisterPanel');
  if (btn && panel) {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      panel.classList.toggle('open');
      var row = document.querySelector('.hero-overlay-row');
      if (row) {
        if (panel.classList.contains('open')) row.classList.add('open');
        else row.classList.remove('open');
      }
    });
    document.addEventListener('click', function(e) {
      if (!panel.contains(e.target) && e.target !== btn) {
        panel.classList.remove('open');
        var row = document.querySelector('.hero-overlay-row');
        if (row) row.classList.remove('open');
      }
    });
  } else {
    console.log('Register Now button or panel not found:', btn, panel);
  }
});

// Function to scroll to Belt Exam section and open register accordion
function scrollToBeltExamRegister() {
  // First, scroll to the Belt Exam section
  const beltExamSection = document.getElementById('belt-exam');
  if (beltExamSection) {
    beltExamSection.scrollIntoView({ 
      behavior: 'smooth',
      block: 'start'
    });
    
    // After scrolling, open the register accordion and then scroll to it
    setTimeout(function() {
      const registerContent = document.getElementById('register-content');
      const registerIcon = document.getElementById('register-icon');
      
      // Only open if it's currently closed
      if (registerContent && (registerContent.style.display === 'none' || registerContent.style.display === '')) {
        toggleAccordion('register');
        
        // After accordion opens, scroll to show the accordion button and content
        setTimeout(function() {
          const registerButton = document.getElementById('register-btn');
          if (registerButton) {
            registerButton.scrollIntoView({ 
              behavior: 'smooth',
              block: 'start'
            });
          } else {
            registerContent.scrollIntoView({ 
              behavior: 'smooth',
              block: 'start'
            });
          }
        }, 100); // Small delay to let accordion animation complete
      } else if (registerContent) {
        // If accordion is already open, scroll to show the button and content
        const registerButton = document.getElementById('register-btn');
        if (registerButton) {
          registerButton.scrollIntoView({ 
            behavior: 'smooth',
            block: 'start'
          });
        } else {
          registerContent.scrollIntoView({ 
            behavior: 'smooth',
            block: 'start'
          });
        }
      }
    }, 800); // Wait 800ms for smooth scroll to complete
  } else {
    console.log('Belt Exam section not found');
  }
}

// Scroll to Top Functionality
document.addEventListener('DOMContentLoaded', function() {
  const scrollToTopBtn = document.getElementById('scrollToTopBtn');
  const headerLogos = document.querySelectorAll('.brand-logo-prominent, .navbar-brand img');
  
  console.log('Scroll to top button found:', scrollToTopBtn);
  
  if (!scrollToTopBtn) {
    console.error('Scroll to top button not found!');
    return;
  }
  
  // Show/hide scroll to top button based on scroll position
  function toggleScrollButton() {
    const scrolled = window.pageYOffset || document.documentElement.scrollTop;
    
    if (scrolled > 300) {
      scrollToTopBtn.classList.add('show');
      scrollToTopBtn.style.opacity = '1 !important';
      scrollToTopBtn.style.visibility = 'visible !important';
      scrollToTopBtn.style.transform = 'translateY(0) !important';
    } else {
      scrollToTopBtn.classList.remove('show');
      scrollToTopBtn.style.opacity = '0 !important';
      scrollToTopBtn.style.visibility = 'hidden !important';
      scrollToTopBtn.style.transform = 'translateY(100px) !important';
    }
  }
  
  // Smooth scroll to top function
  function scrollToTop() {
    console.log('Scrolling to top');
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  }
  
  // Event listeners
  window.addEventListener('scroll', toggleScrollButton);
  
  if (scrollToTopBtn) {
    scrollToTopBtn.addEventListener('click', function(e) {
      e.preventDefault();
      scrollToTop();
    });
  }
  
  // Make header logos clickable to scroll to top
  headerLogos.forEach(logo => {
    logo.addEventListener('click', function(e) {
      e.preventDefault();
      scrollToTop();
    });
    
    // Add cursor pointer style
    logo.style.cursor = 'pointer';
  });
  
  // Initial check
  toggleScrollButton();
  
  // Apply hollow button with red border and transparent white background
  if (scrollToTopBtn) {
    scrollToTopBtn.style.cssText = `
      position: fixed !important;
      bottom: 30px !important;
      right: 30px !important;
      width: 50px !important;
      height: 50px !important;
      background: rgba(255, 255, 255, 0.9) !important;
      color: #dc3545 !important;
      border: 2px solid #dc3545 !important;
      border-radius: 50% !important;
      font-size: 1.2rem !important;
      cursor: pointer !important;
      z-index: 99999 !important;
      display: flex !important;
      align-items: center !important;
      justify-content: center !important;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
      backdrop-filter: blur(10px) !important;
      transition: all 0.3s ease !important;
      opacity: 1 !important;
      visibility: visible !important;
      transform: translateY(0) !important;
    `;
    
    // Add hover effect
    scrollToTopBtn.addEventListener('mouseenter', function() {
      this.style.background = 'rgba(220, 53, 69, 0.1) !important';
      this.style.transform = 'translateY(-2px) scale(1.05) !important';
      this.style.boxShadow = '0 6px 20px rgba(220, 53, 69, 0.2) !important';
    });
    
    scrollToTopBtn.addEventListener('mouseleave', function() {
      this.style.background = 'rgba(255, 255, 255, 0.9) !important';
      this.style.transform = 'translateY(0) scale(1) !important';
      this.style.boxShadow = '0 4px 15px rgba(0, 0, 0, 0.1) !important';
    });
  }
});