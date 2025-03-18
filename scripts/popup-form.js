document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('openPopupBtn').addEventListener('click', function() {
      document.getElementById('popupForm').style.display = 'flex';
    });
  
    document.getElementById('closePopupBtn').addEventListener('click', function() {
      document.getElementById('popupForm').style.display = 'none';
    });
  
    // Optional: Close pop-up when clicking outside the form
    window.addEventListener('click', function(e) {
      const popupForm = document.getElementById('popupForm');
      if (e.target === popupForm) {
        popupForm.style.display = 'none';
      }
    });
  });
  