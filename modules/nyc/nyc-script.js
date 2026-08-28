document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('nycContactForm');
    const responseDiv = document.getElementById('formResponse');
    
    // --- Close Button Logic ---
    const closeBtn = document.getElementById('nycCloseBtn');
    const nycSection = document.getElementById('NYC');
    
    if (closeBtn && nycSection) {
        closeBtn.addEventListener('click', function() {
            // Instead of hiding, we dock it to the page
            nycSection.classList.remove('nyc-fullscreen');
            nycSection.classList.add('nyc-inline');
            
            // Allow scrolling on body again if it was locked (optional, but good practice)
            document.body.style.overflow = '';
        });
    }

    // --- Dynamic Form Fields Logic ---
    if (form) {
        const roleRadios = document.querySelectorAll('input[name="role"]');
        const adminFields = document.getElementById('admin-fields');
        const parentFields = document.getElementById('parent-fields');
        const adminInputs = adminFields ? adminFields.querySelectorAll('input') : [];
        const parentInputs = parentFields ? parentFields.querySelectorAll('select, input') : [];

        function updateRoleFields() {
            const selectedRoleRadio = document.querySelector('input[name="role"]:checked');
            if (!selectedRoleRadio) return; 

            const selectedRole = selectedRoleRadio.value;
            
            if (selectedRole === 'Administrator' && adminFields && parentFields) {
                adminFields.classList.remove('d-none');
                setTimeout(() => adminFields.classList.add('visible'), 10);
                
                parentFields.classList.remove('visible');
                setTimeout(() => parentFields.classList.add('d-none'), 300); // Wait for transition
    
                // Toggle required attributes
                adminInputs.forEach(input => input.setAttribute('required', ''));
                parentInputs.forEach(input => input.removeAttribute('required'));
            } else if (parentFields && adminFields) {
                parentFields.classList.remove('d-none');
                setTimeout(() => parentFields.classList.add('visible'), 10);
    
                adminFields.classList.remove('visible');
                setTimeout(() => adminFields.classList.add('d-none'), 300);
    
                // Toggle required attributes
                parentInputs.forEach(input => input.setAttribute('required', ''));
                adminInputs.forEach(input => input.removeAttribute('required'));
            }
        }
    
        // Initial check
        updateRoleFields();
    
        // Listen for changes
        roleRadios.forEach(radio => {
            radio.addEventListener('change', updateRoleFields);
        });
    }


    // --- Custom Dropdown Logic ---
    const customSelects = document.querySelectorAll('.nyc-custom-select');

    customSelects.forEach(select => {
        const trigger = select.querySelector('.nyc-select-trigger');
        const optionsContainer = select.querySelector('.nyc-select-options');
        const options = select.querySelectorAll('.nyc-option');
        const hiddenInput = select.querySelector('input[type="hidden"]');
        const label = select.closest('.form-floating')?.querySelector('label'); // Optional label interaction

        // Toggle Open
        trigger.addEventListener('click', (e) => {
            select.classList.toggle('open');
            e.stopPropagation(); // Prevent document click from closing immediately
        });

        // Select Option
        options.forEach(option => {
            option.addEventListener('click', (e) => {
                const value = option.getAttribute('data-value');
                const text = option.textContent;

                // Update Trigger Text
                trigger.textContent = text;
                trigger.classList.add('has-value');

                // Update Input
                hiddenInput.value = value;
                
                // Trigger change event if needed for validation
                hiddenInput.dispatchEvent(new Event('change'));

                // Visually select
                options.forEach(opt => opt.classList.remove('selected'));
                option.classList.add('selected');

                // Close
                select.classList.remove('open');
                e.stopPropagation();

                // If floating label exists, float it
                if(label) label.classList.add('float-active');
            });
        });

        // Close on Click Outside
        document.addEventListener('click', (e) => {
            if (!select.contains(e.target)) {
                select.classList.remove('open');
            }
        });
    });


    // --- Form Submission ---
    // --- Form Submission ---
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Basic validation
            if (!form.checkValidity()) {
                e.stopPropagation();
                form.classList.add('was-validated');
                return;
            }

            // Show loading state
            const btn = form.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
            btn.disabled = true;

            const formData = new FormData(form);

            fetch('modules/nyc/nyc-form-handler.php', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                responseDiv.style.display = 'block';
                if (data.success) {
                    responseDiv.innerHTML = '<div class="alert alert-success">' + data.message + '</div>';
                    form.reset();
                    form.classList.remove('was-validated');
                    // Reset custom selects visual state
                    customSelects.forEach(s => {
                        s.querySelector('.nyc-select-trigger').textContent = s.getAttribute('data-placeholder') || 'Select...';
                        s.querySelector('.nyc-select-trigger').classList.remove('has-value');
                        s.querySelectorAll('.nyc-option').forEach(o => o.classList.remove('selected'));
                    });
                } else {
                    responseDiv.innerHTML = '<div class="alert alert-danger">' + (data.error || 'Something went wrong.') + '</div>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                responseDiv.style.display = 'block';
                responseDiv.innerHTML = '<div class="alert alert-danger">An error occurred. Please try again later.</div>';
            })
            .finally(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
        });
    }
    
    // --- Video Lazy Loading ---
    const lazyVideos = document.querySelectorAll('video.lazy-video');
    
    if ('IntersectionObserver' in window) {
        const videoObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const video = entry.target;
                    const sources = video.querySelectorAll('source');
                    
                    sources.forEach(source => {
                        if (source.dataset.src) {
                            source.src = source.dataset.src;
                        }
                    });
                    
                    video.load();
                    video.classList.remove('lazy-video');
                    observer.unobserve(video);
                }
            });
        });
        
        lazyVideos.forEach(video => {
            videoObserver.observe(video);
        });
    } else {
        // Fallback for older browsers
        lazyVideos.forEach(video => {
            const sources = video.querySelectorAll('source');
            sources.forEach(source => {
                if (source.dataset.src) {
                    source.src = source.dataset.src;
                }
            });
            video.load();
        });
    }
});
