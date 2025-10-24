// Smooth scroll with navigation offset
document.addEventListener('DOMContentLoaded', function() {
    console.log('🧭 Initializing navigation scroll with offset...');
    
    // Get navigation height dynamically
    function getNavigationHeight() {
        const nav = document.querySelector('.floating-pills-nav');
        return nav ? nav.offsetHeight : 100; // fallback to 100px if nav not found
    }
    
    // Smooth scroll to target with offset
    function scrollToSection(targetId) {
        const targetElement = document.getElementById(targetId);
        if (!targetElement) {
            console.warn(`❌ Target element #${targetId} not found`);
            return;
        }
        
        const navHeight = getNavigationHeight();
        const targetPosition = targetElement.offsetTop - navHeight - 20; // 20px extra padding
        
        console.log(`🎯 Scrolling to #${targetId}:`);
        console.log(`  - Target element top: ${targetElement.offsetTop}px`);
        console.log(`  - Navigation height: ${navHeight}px`);
        console.log(`  - Final scroll position: ${targetPosition}px`);
        
        window.scrollTo({
            top: targetPosition,
            behavior: 'smooth'
        });
    }
    
    // Handle all navigation links (both desktop and mobile)
    function setupNavigationLinks() {
        // Desktop navigation pills
        const navLinks = document.querySelectorAll('.nav-pill a[href^="#"]');
        console.log(`📱 Found ${navLinks.length} desktop navigation links`);
        
        // Mobile navigation links
        const mobileNavLinks = document.querySelectorAll('.mobile-nav-item[href^="#"]');
        console.log(`📱 Found ${mobileNavLinks.length} mobile navigation links`);
        
        // Other anchor links (like "Shop Now" buttons)
        const otherLinks = document.querySelectorAll('a[href^="#"]:not(.nav-pill a):not(.mobile-nav-item)');
        console.log(`🔗 Found ${otherLinks.length} other anchor links`);
        
        // Combine all links
        const allLinks = [...navLinks, ...mobileNavLinks, ...otherLinks];
        
        allLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                const href = this.getAttribute('href');
                const targetId = href.substring(1); // Remove the #
                
                console.log(`🔗 Navigation link clicked: ${href}`);
                scrollToSection(targetId);
            });
        });
        
        console.log(`✅ Set up scroll offset for ${allLinks.length} navigation links`);
    }
    
    // Initialize after DOM is ready
    setupNavigationLinks();
    
    // Re-setup after a delay to catch any dynamically added links
    setTimeout(setupNavigationLinks, 1000);
    
    console.log('🧭 Navigation scroll initialization complete');
}); 