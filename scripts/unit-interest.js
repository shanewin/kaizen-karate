document.addEventListener('DOMContentLoaded', function () {
  const unitForm = document.getElementById('unitInterestForm');
  const thankYouSection = document.getElementById('unitThankYou');
  const detailsSection = document.getElementById('unitDetailsContent');
  const submitBtn = unitForm.querySelector('button[type="submit"]');

  unitForm.addEventListener('submit', function (e) {
    e.preventDefault();

    submitBtn.disabled = true;
    submitBtn.innerHTML = 'Submitting...';

    const formData = new FormData(unitForm);

    fetch(unitForm.action, {
      method: 'POST',
      body: formData
    })
      .then(handleUnitResponse)
      .catch(handleUnitError)
      .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Submit';
      });
  });

  function handleUnitResponse(response) {
    if (response.status === 403) {
      alert('Session expired. Please refresh the page and try again.');
      window.location.reload();
      return;
    }

    if (response.status === 429) {
      alert('Please wait a few minutes before submitting again.');
      return;
    }

    return response.json().then(data => {
      if (!response.ok || !data.success) {
        throw new Error(data.error || 'Submission failed');
      }

      // ✅ Hide form + description, show thank you
      detailsSection.style.display = 'none';
      thankYouSection.style.display = 'block';

      unitForm.reset();
    });
  }

  function handleUnitError(error) {
    console.error('Unit interest form error:', error);
    alert(error.message || 'There was an error. Please try again.');
  }
});
