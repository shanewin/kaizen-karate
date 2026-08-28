document.addEventListener('DOMContentLoaded', function () {
  const navbar = document.getElementById('uniqueNavbar');
  const mobileToggle = document.getElementById('mobileMenuToggle');
  const mobileOverlay = document.getElementById('mobileOverlayMenu');
  const mobileNavItems = document.querySelectorAll('.mobile-nav-item');

  if (!navbar || !mobileToggle || !mobileOverlay) {
    return;
  }

  function handleScroll() {
    if (window.scrollY > 50) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  }

  let ticking = false;
  window.addEventListener('scroll', function () {
    if (!ticking) {
      requestAnimationFrame(function () {
        handleScroll();
        ticking = false;
      });
      ticking = true;
    }
  });

  handleScroll();

  mobileToggle.addEventListener('click', function () {
    this.classList.toggle('active');
    mobileOverlay.classList.toggle('active');
  });

  mobileNavItems.forEach(item => {
    item.addEventListener('click', function () {
      if (!item.classList.contains('mobile-dropdown-toggle')) {
        mobileToggle.classList.remove('active');
        mobileOverlay.classList.remove('active');
      }
    });
  });

  document.addEventListener('click', function (e) {
    if (mobileOverlay.classList.contains('active') &&
        !mobileOverlay.contains(e.target) &&
        !mobileToggle.contains(e.target)) {
      mobileToggle.classList.remove('active');
      mobileOverlay.classList.remove('active');
    }
  });

  const mobileDropdownToggle = document.querySelector('.mobile-dropdown-toggle');
  const mobileDropdown = document.querySelector('.mobile-dropdown');

  if (mobileDropdownToggle && mobileDropdown) {
    mobileDropdownToggle.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      mobileDropdown.classList.toggle('show');
    });

    document.addEventListener('click', function (e) {
      if (mobileDropdown.classList.contains('show') &&
          !mobileDropdown.contains(e.target) &&
          !mobileDropdownToggle.contains(e.target)) {
        mobileDropdown.classList.remove('show');
      }
    });
  }
});
