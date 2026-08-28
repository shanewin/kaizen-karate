// Calendar preview lightbox functions
window.openCalendarPreview = function() {
  const lightbox = document.getElementById('calendarLightbox');

  if (lightbox) {
    lightbox.style.display = 'flex';
    document.body.style.overflow = 'hidden';

    // Small delay to ensure smooth animation
    setTimeout(() => {
      lightbox.style.opacity = '1';
    }, 10);
  }
};

window.closeCalendarPreview = function() {
  const lightbox = document.getElementById('calendarLightbox');

  if (lightbox) {
    lightbox.style.opacity = '0';
    document.body.style.overflow = '';

    // Hide lightbox after animation completes
    setTimeout(() => {
      lightbox.style.display = 'none';
    }, 300);
  }
};

// Close lightbox with Escape key
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    closeCalendarPreview();
    closeWeekendCalendarPreview();
    closeMatrixLightbox();
    closeRequirementsLightbox();
    closeStripeLightbox();
    closeTestingTipsLightbox();
    closeVideoInstructionsLightbox();
    closeGreenBeltLightbox();
    closePurpleBeltLightbox();
    closeBlueBeltLightbox();
    closeBrownBeltLightbox();
    closeBrownStripeLightbox();
    closeRedBeltLightbox();
    closeRedStripeLightbox();
  }
});

// Weekend calendar preview lightbox functions
window.openWeekendCalendarPreview = function() {
  const lightbox = document.getElementById('weekendCalendarLightbox');

  if (lightbox) {
    lightbox.style.display = 'flex';
    document.body.style.overflow = 'hidden';

    // Small delay to ensure smooth animation
    setTimeout(() => {
      lightbox.style.opacity = '1';
    }, 10);
  }
};

window.closeWeekendCalendarPreview = function() {
  const lightbox = document.getElementById('weekendCalendarLightbox');

  if (lightbox) {
    lightbox.style.opacity = '0';
    document.body.style.overflow = '';

    // Hide lightbox after animation completes
    setTimeout(() => {
      lightbox.style.display = 'none';
    }, 300);
  }
};

// Belt Exam Requirements Lightbox Functions
window.openMatrixLightbox = function() {
  const lightbox = document.getElementById('matrixLightbox');

  if (lightbox) {
    lightbox.style.display = 'flex';
    document.body.style.overflow = 'hidden';

    // Small delay to ensure smooth animation
    setTimeout(() => {
      lightbox.style.opacity = '1';
    }, 10);
  }
};

window.closeMatrixLightbox = function() {
  const lightbox = document.getElementById('matrixLightbox');

  if (lightbox) {
    lightbox.style.opacity = '0';
    document.body.style.overflow = '';

    // Hide lightbox after animation completes
    setTimeout(() => {
      lightbox.style.display = 'none';
    }, 300);
  }
};

window.openRequirementsLightbox = function() {
  const lightbox = document.getElementById('requirementsLightbox');

  if (lightbox) {
    lightbox.style.display = 'flex';
    document.body.style.overflow = 'hidden';

    // Small delay to ensure smooth animation
    setTimeout(() => {
      lightbox.style.opacity = '1';
    }, 10);
  }
};

window.closeRequirementsLightbox = function() {
  const lightbox = document.getElementById('requirementsLightbox');

  if (lightbox) {
    lightbox.style.opacity = '0';
    document.body.style.overflow = '';

    // Hide lightbox after animation completes
    setTimeout(() => {
      lightbox.style.display = 'none';
    }, 300);
  }
};

window.openStripeLightbox = function() {
  const lightbox = document.getElementById('stripeLightbox');

  if (lightbox) {
    lightbox.style.display = 'flex';
    document.body.style.overflow = 'hidden';

    // Small delay to ensure smooth animation
    setTimeout(() => {
      lightbox.style.opacity = '1';
    }, 10);
  }
};

window.closeStripeLightbox = function() {
  const lightbox = document.getElementById('stripeLightbox');

  if (lightbox) {
    lightbox.style.opacity = '0';
    document.body.style.overflow = '';

    // Hide lightbox after animation completes
    setTimeout(() => {
      lightbox.style.display = 'none';
    }, 300);
  }
};

// Testing Scripts Lightbox Functions
window.openTestingTipsLightbox = function() {
  const lightbox = document.getElementById('testingTipsLightbox');

  if (lightbox) {
    lightbox.style.display = 'flex';
    document.body.style.overflow = 'hidden';

    setTimeout(() => {
      lightbox.style.opacity = '1';
    }, 10);
  }
};

window.closeTestingTipsLightbox = function() {
  const lightbox = document.getElementById('testingTipsLightbox');

  if (lightbox) {
    lightbox.style.opacity = '0';
    document.body.style.overflow = '';

    setTimeout(() => {
      lightbox.style.display = 'none';
    }, 300);
  }
};

window.openVideoInstructionsLightbox = function() {
  const lightbox = document.getElementById('videoInstructionsLightbox');

  if (lightbox) {
    lightbox.style.display = 'flex';
    document.body.style.overflow = 'hidden';

    setTimeout(() => {
      lightbox.style.opacity = '1';
    }, 10);
  }
};

window.closeVideoInstructionsLightbox = function() {
  const lightbox = document.getElementById('videoInstructionsLightbox');

  if (lightbox) {
    lightbox.style.opacity = '0';
    document.body.style.overflow = '';

    setTimeout(() => {
      lightbox.style.display = 'none';
    }, 300);
  }
};

window.openGreenBeltLightbox = function() {
  const lightbox = document.getElementById('greenBeltLightbox');

  if (lightbox) {
    lightbox.style.display = 'flex';
    document.body.style.overflow = 'hidden';

    setTimeout(() => {
      lightbox.style.opacity = '1';
    }, 10);
  }
};

window.closeGreenBeltLightbox = function() {
  const lightbox = document.getElementById('greenBeltLightbox');

  if (lightbox) {
    lightbox.style.opacity = '0';
    document.body.style.overflow = '';

    setTimeout(() => {
      lightbox.style.display = 'none';
    }, 300);
  }
};

window.openPurpleBeltLightbox = function() {
  const lightbox = document.getElementById('purpleBeltLightbox');

  if (lightbox) {
    lightbox.style.display = 'flex';
    document.body.style.overflow = 'hidden';

    setTimeout(() => {
      lightbox.style.opacity = '1';
    }, 10);
  }
};

window.closePurpleBeltLightbox = function() {
  const lightbox = document.getElementById('purpleBeltLightbox');

  if (lightbox) {
    lightbox.style.opacity = '0';
    document.body.style.overflow = '';

    setTimeout(() => {
      lightbox.style.display = 'none';
    }, 300);
  }
};

window.openBlueBeltLightbox = function() {
  const lightbox = document.getElementById('blueBeltLightbox');

  if (lightbox) {
    lightbox.style.display = 'flex';
    document.body.style.overflow = 'hidden';

    setTimeout(() => {
      lightbox.style.opacity = '1';
    }, 10);
  }
};

window.closeBlueBeltLightbox = function() {
  const lightbox = document.getElementById('blueBeltLightbox');

  if (lightbox) {
    lightbox.style.opacity = '0';
    document.body.style.overflow = '';

    setTimeout(() => {
      lightbox.style.display = 'none';
    }, 300);
  }
};

window.openBrownBeltLightbox = function() {
  const lightbox = document.getElementById('brownBeltLightbox');

  if (lightbox) {
    lightbox.style.display = 'flex';
    document.body.style.overflow = 'hidden';

    setTimeout(() => {
      lightbox.style.opacity = '1';
    }, 10);
  }
};

window.closeBrownBeltLightbox = function() {
  const lightbox = document.getElementById('brownBeltLightbox');

  if (lightbox) {
    lightbox.style.opacity = '0';
    document.body.style.overflow = '';

    setTimeout(() => {
      lightbox.style.display = 'none';
    }, 300);
  }
};

window.openBrownStripeLightbox = function() {
  const lightbox = document.getElementById('brownStripeLightbox');
  if (lightbox) {
    lightbox.style.opacity = '0';
    lightbox.style.display = 'flex';
    document.body.style.overflow = 'hidden';

    setTimeout(() => {
      lightbox.style.opacity = '1';
    }, 10);
  }
};

window.closeBrownStripeLightbox = function() {
  const lightbox = document.getElementById('brownStripeLightbox');

  if (lightbox) {
    lightbox.style.opacity = '0';
    document.body.style.overflow = '';

    setTimeout(() => {
      lightbox.style.display = 'none';
    }, 300);
  }
};

window.openRedBeltLightbox = function() {
  const lightbox = document.getElementById('redBeltLightbox');
  if (lightbox) {
    lightbox.style.opacity = '0';
    lightbox.style.display = 'flex';
    document.body.style.overflow = 'hidden';

    setTimeout(() => {
      lightbox.style.opacity = '1';
    }, 10);
  }
};

window.closeRedBeltLightbox = function() {
  const lightbox = document.getElementById('redBeltLightbox');

  if (lightbox) {
    lightbox.style.opacity = '0';
    document.body.style.overflow = '';

    setTimeout(() => {
      lightbox.style.display = 'none';
    }, 300);
  }
};

window.openRedStripeLightbox = function() {
  const lightbox = document.getElementById('redStripeLightbox');

  if (lightbox) {
    lightbox.style.display = 'flex';
    document.body.style.overflow = 'hidden';

    setTimeout(() => {
      lightbox.style.opacity = '1';
    }, 10);
  }
};

window.closeRedStripeLightbox = function() {
  const lightbox = document.getElementById('redStripeLightbox');

  if (lightbox) {
    lightbox.style.opacity = '0';
    document.body.style.overflow = '';

    setTimeout(() => {
      lightbox.style.display = 'none';
    }, 300);
  }
};
