document.getElementById('emailSignupForm').addEventListener('submit', function(e) {
  e.preventDefault();
  
  // Get form elements
  const form = e.target;
  const emailInput = form.email;
  const csrfToken = form.csrf_token.value;
  const email = emailInput.value.trim();
  
  // Clear previous errors
  emailInput.classList.remove('error');
  
  // Enhanced validation
  if (!email) {
      showError(emailInput, 'Please enter your email');
      return;
  }
  
  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
      showError(emailInput, 'Please enter a valid email address');
      return;
  }
  
  // Create form data
  const formData = new FormData();
  formData.append('email', email);
  formData.append('csrf_token', csrfToken);
  
  // Submit with feedback
  showLoading(true);
  
  fetch('email-list.php', {
      method: 'POST',
      body: formData  // Let browser set Content-Type with boundary
  })
  .then(handleResponse)
  .catch(handleError)
  .finally(() => showLoading(false));
});

// Response handler
function handleResponse(response) {
  if (response.status === 403) {
      // CSRF token expired
      alert('Session expired. Please refresh the page and try again.');
      window.location.reload();
      return;
  }
  
  if (response.status === 429) {
      // Rate limited
      alert('Please wait a few minutes before trying again.');
      return;
  }
  
  return response.json().then(data => {
      if (!response.ok) {
          throw new Error(data.error || 'Submission failed');
      }
      
      // Success
      document.getElementById('formSection').style.display = 'none';
      document.getElementById('thankYouSection').style.display = 'block';
      
      // Optional: Reset form
      document.getElementById('emailSignupForm').reset();

      // In handleResponse() after reset():
      setTimeout(() => {
        document.getElementById('formSection').style.display = 'none';
        document.getElementById('thankYouSection').style.display = 'block';
      }, 300);

  });
}

// Error handler
function handleError(error) {
  console.error('Submission error:', error);
  alert(error.message || 'There was an error submitting your email. Please try again.');
}

// UI helpers
function showError(input, message) {
  input.classList.add('error');
  alert(message);
  input.focus();
}

function showLoading(show) {
  const btn = document.querySelector('#emailSignupForm button[type="submit"]');
  if (show) {
      btn.disabled = true;
      btn.innerHTML = 'Submitting...';
  } else {
      btn.disabled = false;
      btn.innerHTML = 'Subscribe';
  }
}