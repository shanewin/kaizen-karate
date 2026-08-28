// Floating pills navigation functionality
document.addEventListener('DOMContentLoaded', function() {
  const navbar = document.getElementById('uniqueNavbar');
  const mobileToggle = document.getElementById('mobileMenuToggle');
  const mobileOverlay = document.getElementById('mobileOverlayMenu');
  const mobileNavItems = document.querySelectorAll('.mobile-nav-item');

  function handleScroll() {
    const currentScrollY = window.scrollY;

    // Navbar scroll effect
    if (currentScrollY > 50) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }

    // Hero overlay now stays visible - no scrolling effects
  }

  // Throttled scroll listener
  let ticking = false;
  window.addEventListener('scroll', function() {
    if (!ticking) {
      requestAnimationFrame(function() {
        handleScroll();
        ticking = false;
      });
      ticking = true;
    }
  });

  // Mobile menu toggle
  mobileToggle.addEventListener('click', function() {
    this.classList.toggle('active');
    mobileOverlay.classList.toggle('active');
  });

  // Close mobile menu when clicking nav items (except dropdown toggles)
  mobileNavItems.forEach(item => {
    item.addEventListener('click', function(e) {
      // Don't close menu if this is a dropdown toggle
      if (!item.classList.contains('mobile-dropdown-toggle')) {
      mobileToggle.classList.remove('active');
      mobileOverlay.classList.remove('active');
      }
    });
  });

  // Close mobile menu when clicking outside
  document.addEventListener('click', function(e) {
    if (mobileOverlay.classList.contains('active') && 
        !mobileOverlay.contains(e.target) && 
        !mobileToggle.contains(e.target)) {
      mobileToggle.classList.remove('active');
      mobileOverlay.classList.remove('active');
    }
  });

  // Mobile dropdown functionality
  const mobileDropdownToggle = document.querySelector('.mobile-dropdown-toggle');
  const mobileDropdown = document.querySelector('.mobile-dropdown');

  if (mobileDropdownToggle && mobileDropdown) {
    mobileDropdownToggle.addEventListener('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      mobileDropdown.classList.toggle('show');
    });

    // Close mobile dropdown when clicking outside
    document.addEventListener('click', function(e) {
      if (mobileDropdown.classList.contains('show') && 
          !mobileDropdown.contains(e.target)) {
        mobileDropdown.classList.remove('show');
      }
    });
  }

});
