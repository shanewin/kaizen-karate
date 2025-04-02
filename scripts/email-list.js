document.getElementById('emailSignupForm').addEventListener('submit', async function(e) {
  e.preventDefault();
  
  const form = e.target;
  const emailInput = form.email;
  const email = emailInput.value.trim();
  const submitBtn = form.querySelector('button[type="submit"]');
  
  // Clear previous errors and reset UI
  emailInput.classList.remove('is-invalid', 'error');
  submitBtn.disabled = true;
  submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Submitting...';

  // Enhanced validation
  if (!email) {
      showValidationError(emailInput, 'Email is required');
      return resetSubmitButton(submitBtn);
  }

  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
      showValidationError(emailInput, 'Please enter a valid email address');
      return resetSubmitButton(submitBtn);
  }

  try {
      const response = await fetch('email-list.php', {
          method: 'POST',
          body: new FormData(form),
          credentials: 'include',
          headers: {
              'X-Requested-With': 'XMLHttpRequest' // Identify AJAX requests
          }
      });

      // Handle specific HTTP errors
      if (response.status === 403) {
          window.location.reload(); // Force refresh on CSRF issues
          return;
      }

      if (response.status === 429) {
          throw new Error('Please wait before submitting again');
      }

      const data = await response.json();
      
      if (!response.ok) {
          throw new Error(data.error || 'Submission failed. Please try again.');
      }

      // Successful submission
      showSuccessState(form);

  } catch (error) {
      console.error('Submission error:', error);
      showError(error.message || 'An unexpected error occurred');
  } finally {
      resetSubmitButton(submitBtn);
  }
});

// Helper functions
function showValidationError(input, message) {
  input.classList.add('is-invalid');
  const feedback = input.nextElementSibling || document.createElement('div');
  feedback.className = 'invalid-feedback';
  feedback.textContent = message;
  input.insertAdjacentElement('afterend', feedback);
  input.focus();
}

function showError(message) {
  const errorAlert = document.getElementById('formError') || createErrorAlert();
  errorAlert.textContent = message;
  errorAlert.style.display = 'block';
}

function createErrorAlert() {
  const alert = document.createElement('div');
  alert.id = 'formError';
  alert.className = 'alert alert-danger mt-3';
  alert.style.display = 'none';
  document.querySelector('#formSection').appendChild(alert);
  return alert;
}

function showSuccessState(form) {
  document.getElementById('formSection').style.display = 'none';
  document.getElementById('thankYouSection').style.display = 'block';
  form.reset(); // Clear form fields
}

function resetSubmitButton(button) {
  button.disabled = false;
  button.textContent = 'Subscribe';
}