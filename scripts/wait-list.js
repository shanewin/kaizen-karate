document.addEventListener('DOMContentLoaded', function () {
    console.log('=== CONTACT FORM DEBUG ===');
    console.log('1. JavaScript loaded');
    
    const form = document.querySelector('.contact-form');

    // Not every page that loads this script has the contact form. Bail out
    // before dereferencing `form`, which previously threw a TypeError here.
    if (!form) {
        return;
    }

    const thankYou = document.getElementById('contactThankYou');
    const submitBtn = form.querySelector('button[type="submit"]');
    const errorDiv = document.getElementById('formError');

    console.log('2. Form element found:', !!form);
    console.log('3. Thank you element found:', !!thankYou);
    console.log('4. Submit button found:', !!submitBtn);
    console.log('5. Error div found:', !!errorDiv);
    
    if (!thankYou) {
        console.error('ERROR: No element with id="contactThankYou"');
    }
    
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        console.log('6. Form submit triggered');
        
        // Reset error display
        if (errorDiv) {
            errorDiv.style.display = 'none';
            errorDiv.textContent = '';
        }
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Submitting...';
        console.log('7. Button disabled, showing spinner');
        
        const formData = new FormData(form);
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            console.log('8. Got response, status:', response.status);
            console.log('9. Content-Type:', response.headers.get('content-type'));
            
            // Check if response is JSON
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                console.log('10. Response is JSON, parsing...');
                return response.json();
            } else {
                // If not JSON, get text response
                console.log('10. Response is NOT JSON, getting text...');
                return response.text().then(text => {
                    console.log('11. Non-JSON response text:', text.substring(0, 100));
                    throw new Error(text || 'Server returned non-JSON response');
                });
            }
        })
        .then(data => {
            console.log('12. Parsed data:', data);
            
            if (data && data.success) {
                console.log('13. Success! data.success = true');
                console.log('14. Hiding form, showing thank you...');
                form.style.display = 'none';
                thankYou.style.display = 'block';
                console.log('15. Form hidden:', form.style.display === 'none');
                console.log('16. Thank you shown:', thankYou.style.display === 'block');
            } else if (data && data.error) {
                console.log('13. Error received:', data.error);
                // Show error in form error div instead of alert
                if (errorDiv) {
                    errorDiv.textContent = data.error;
                    errorDiv.style.display = 'block';
                    console.log('14. Error displayed in error div');
                } else {
                    alert(data.error);
                }
            } else {
                console.error('13. UNEXPECTED: data exists but no success or error:', data);
            }
        })
        .catch(err => {
            console.error('CATCH ERROR:', err);
            console.error('Error message:', err.message);
            
            // Show error message
            const errorMessage = err.message.includes('Session expired') ? 
                'Session expired. Please refresh the page and try again.' :
                err.message.includes('Please wait') ? 
                'Please wait 5 minutes before submitting again.' :
                'There was an error sending your message. Please try again.';
            
            console.log('Error message to display:', errorMessage);
            
            if (errorDiv) {
                errorDiv.textContent = errorMessage;
                errorDiv.style.display = 'block';
            } else {
                alert(errorMessage);
            }
        })
        .finally(() => {
            console.log('FINALLY: Resetting button');
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Send Message';
        });
    });
    
    console.log('=== END DEBUG SETUP ===');
});
  