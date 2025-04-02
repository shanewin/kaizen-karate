document.addEventListener('DOMContentLoaded', function() {
  const unitForm = document.getElementById('unitInterestForm');
  const submitBtn = unitForm.querySelector('button[type="submit"]');
  
  unitForm.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    // UI Feedback
    submitBtn.disabled = true;
    submitBtn.innerHTML = `
      <span class="spinner-border spinner-border-sm" role="status"></span>
      Submitting...
    `;
    
    try {
      const response = await fetch(unitForm.action, {
        method: 'POST',
        body: new FormData(unitForm),
        credentials: 'include',
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      });
      
      if (response.status === 403) {
        window.location.reload(); // Force refresh on CSRF issues
        return;
      }
      
      const data = await response.json();
      
      if (!response.ok) {
        throw new Error(data.error || 'Submission failed. Please try again.');
      }
      
      // Success handling
      document.getElementById('unitDetailsContent').style.display = 'none';
      document.getElementById('unitThankYou').style.display = 'block';
      unitForm.reset();
      
    } catch (error) {
      console.error('Error:', error);
      
      // Enhanced error display
      const errorDisplay = document.getElementById('formError') || createErrorDisplay();
      errorDisplay.textContent = error.message;
      errorDisplay.style.display = 'block';
      
    } finally {
      submitBtn.disabled = false;
      submitBtn.textContent = 'Submit';
    }
  });
  
  function createErrorDisplay() {
    const div = document.createElement('div');
    div.id = 'formError';
    div.className = 'alert alert-danger mt-3';
    div.style.display = 'none';
    unitForm.appendChild(div);
    return div;
  }
});