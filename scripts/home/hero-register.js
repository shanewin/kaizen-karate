document.addEventListener('DOMContentLoaded', function() {
  const mobileRegisterBtn = document.getElementById('mobileHeroRegisterBtn');
  const mobileRegisterPanel = document.getElementById('mobileHeroRegisterPanel');

  if (mobileRegisterBtn && mobileRegisterPanel) {
    console.log('Mobile register elements found'); // Debug log

    mobileRegisterBtn.addEventListener('click', function(e) {
      e.preventDefault();
      console.log('Mobile register button clicked'); // Debug log

      // Check current display state
      const currentDisplay = window.getComputedStyle(mobileRegisterPanel).display;
      console.log('Current display:', currentDisplay); // Debug log

      if (currentDisplay === 'none') {
        mobileRegisterPanel.style.display = 'flex';
        console.log('Showing panel'); // Debug log
      } else {
        mobileRegisterPanel.style.display = 'none';
        console.log('Hiding panel'); // Debug log
      }
    });
  } else {
    console.log('Mobile register elements not found'); // Debug log
  }
});
