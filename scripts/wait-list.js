document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.contact-form');
    const thankYou = document.getElementById('waitlistThankYou');
    const submitBtn = form.querySelector('button[type="submit"]');
  
    form.addEventListener('submit', function (e) {
      e.preventDefault();
  
      submitBtn.disabled = true;
      submitBtn.innerHTML = 'Submitting...';
  
      const formData = new FormData(form);
  
      fetch(form.action, {
        method: 'POST',
        body: formData
      })
      .then(response => {
        if (response.status === 403) {
          alert('Session expired. Please refresh and try again.');
          return;
        }
        if (response.status === 429) {
          alert('Please wait a few minutes before submitting again.');
          return;
        }
        return response.json();
      })
      .then(data => {
        if (data && data.success) {
          form.style.display = 'none';
          thankYou.style.display = 'block';
        } else if (data && data.error) {
          alert(data.error);
        }
      })
      .catch(err => {
        console.error('Wait list form error:', err);
        alert('There was an error. Please try again.');
      })
      .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Submit';
      });
    });
  });
  