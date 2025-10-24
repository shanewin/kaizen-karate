// Dedicated Instructor Accordion Script
(function() {
    'use strict';
    
    function initAccordions() {
        console.log('🔧 Initializing all accordions...');
        console.log('🔍 Current page URL:', window.location.href);
        console.log('🔍 Document ready state:', document.readyState);
        
        // Debug: Check if any accordion elements exist
        const allAccordionElements = document.querySelectorAll('.master-instructor-accordion, .master-instructor-header, .instructor-header, .instructor-item');
        console.log(`🔍 Total accordion-related elements found: ${allAccordionElements.length}`);
        
        // Master Accordions (handle multiple)
        const masterHeaders = document.querySelectorAll('.master-instructor-header');
        console.log(`📋 Found ${masterHeaders.length} master accordion headers`);
        
        // Debug each master header
        masterHeaders.forEach((masterHeader, index) => {
            console.log(`🔍 Master header ${index + 1}:`, masterHeader);
            console.log(`🔍 Master header ${index + 1} text:`, masterHeader.textContent.trim());
            
            const masterAccordion = masterHeader.closest('.master-instructor-accordion');
            
            if (masterHeader && masterAccordion) {
                console.log(`✅ Master accordion ${index + 1} elements found and connected`);
                
                // Remove any existing listeners
                masterHeader.removeEventListener('click', handleMasterClick);
                masterHeader.addEventListener('click', handleMasterClick);
                
                console.log(`🎯 Added click listener to master header ${index + 1}`);
            } else {
                console.warn(`❌ Master accordion ${index + 1} elements not found properly`);
                console.warn(`❌ Master header exists:`, !!masterHeader);
                console.warn(`❌ Master accordion container exists:`, !!masterAccordion);
            }
        });
        
        // Individual Instructor/Camp Accordions
        const instructorHeaders = document.querySelectorAll('.instructor-header');
        console.log(`📋 Found ${instructorHeaders.length} individual accordion headers`);
        
        instructorHeaders.forEach((header, index) => {
            console.log(`🔍 Individual header ${index + 1}:`, header.textContent.trim());
            
            // Remove any existing listeners
            header.removeEventListener('click', handleInstructorClick);
            header.addEventListener('click', handleInstructorClick);
            
            console.log(`🎯 Added click listener to individual header ${index + 1}`);
        });
        
        // Final check
        console.log('🏁 Accordion initialization complete');
    }
    
    function handleMasterClick(e) {
        e.preventDefault();
        e.stopPropagation();
        
        console.log('🎯 Master accordion clicked');
        
        const masterAccordion = e.currentTarget.closest('.master-instructor-accordion');
        if (masterAccordion) {
            const wasActive = masterAccordion.classList.contains('active');
            masterAccordion.classList.toggle('active');
            
            console.log(`📊 Master accordion is now: ${masterAccordion.classList.contains('active') ? 'OPEN' : 'CLOSED'}`);
            
            // If closing master, close all individual accordions within this master accordion
            if (wasActive) {
                masterAccordion.querySelectorAll('.instructor-item').forEach(item => {
                    item.classList.remove('active');
                });
                console.log('🔒 Closed all individual accordions within this master accordion');
            }
        }
    }
    
    function handleInstructorClick(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const instructorItem = e.currentTarget.parentElement;
        const instructorName = e.currentTarget.querySelector('h3').textContent;
        const masterAccordion = instructorItem.closest('.master-instructor-accordion');
        
        console.log(`🎯 Accordion item clicked: ${instructorName}`);
        
        const wasActive = instructorItem.classList.contains('active');
        
        // Close all other accordion items within the same master accordion
        if (masterAccordion) {
            masterAccordion.querySelectorAll('.instructor-item').forEach(item => {
                if (item !== instructorItem) {
                    item.classList.remove('active');
                }
            });
        }
        
        // Toggle current accordion
        instructorItem.classList.toggle('active');
        
        console.log(`📊 ${instructorName} accordion is now: ${instructorItem.classList.contains('active') ? 'OPEN' : 'CLOSED'}`);
    }
    
    // Manual test function for debugging
    window.testAccordions = function() {
        console.log('🧪 Manual accordion test initiated...');
        initAccordions();
        
        // Test clicking the first master header
        const firstMaster = document.querySelector('.master-instructor-header');
        if (firstMaster) {
            console.log('🧪 Testing first master header click...');
            firstMaster.click();
        } else {
            console.log('🧪 No master header found for testing');
        }
    };
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        console.log('📱 DOM still loading, waiting for DOMContentLoaded...');
        document.addEventListener('DOMContentLoaded', function() {
            console.log('📱 DOMContentLoaded fired, initializing accordions...');
            initAccordions();
        });
    } else {
        console.log('📱 DOM already ready, initializing accordions immediately...');
        initAccordions();
    }
    
    // Backup initialization after short delay
    setTimeout(() => {
        console.log('⏰ Backup initialization check after 500ms...');
        const masterHeaders = document.querySelectorAll('.master-instructor-header');
        if (masterHeaders.length > 0) {
            console.log('⏰ Found master headers in backup check, re-initializing...');
            initAccordions();
        } else {
            console.log('⏰ No master headers found in backup check');
        }
    }, 500);
    
    // Additional backup after 2 seconds
    setTimeout(() => {
        console.log('⏰ Final backup check after 2 seconds...');
        const masterHeaders = document.querySelectorAll('.master-instructor-header');
        console.log(`⏰ Master headers found: ${masterHeaders.length}`);
        if (masterHeaders.length > 0) {
            console.log('⏰ Re-running initialization as final backup...');
            initAccordions();
        }
    }, 2000);
    
    // Make functions available globally for Pool Time icon click
    window.handleMasterClick = handleMasterClick;
    window.handleInstructorClick = handleInstructorClick;
    
})();

// Function to scroll to and open Swimming information
function scrollToSwimmingInfo() {
    console.log('🏊‍♂️ Pool Time icon clicked - navigating to Swimming info...');
    
    // Find the Summer Camp 2025 accordion specifically by looking for the text content
    const summerCampHeader = Array.from(document.querySelectorAll('.master-instructor-header'))
        .find(header => header.textContent.includes('More Information about Summer Camp 2025'));
    
    const masterAccordion = summerCampHeader ? summerCampHeader.closest('.master-instructor-accordion') : null;
    
    if (!masterAccordion || !summerCampHeader) {
        console.error('❌ Summer Camp master accordion not found');
        console.log('Available master headers:', document.querySelectorAll('.master-instructor-header'));
        return;
    }
    
    console.log('✅ Found Summer Camp accordion:', masterAccordion);
    
    // Find the Swimming accordion item
    const swimmingAccordion = document.querySelector('[data-instructor="camp8"]');
    const swimmingItem = swimmingAccordion ? swimmingAccordion.parentElement : null;
    
    if (!swimmingAccordion || !swimmingItem) {
        console.error('❌ Swimming accordion not found');
        return;
    }
    
    // Step 1: Scroll to the master accordion with smooth scrolling
    masterAccordion.scrollIntoView({ 
        behavior: 'smooth', 
        block: 'start',
        inline: 'nearest'
    });
    
    // Step 2: Open master accordion if it's not already open
    setTimeout(() => {
        if (!masterAccordion.classList.contains('active')) {
            console.log('🔓 Opening master accordion...');
            masterAccordion.classList.add('active');
        }
        
        // Step 3: Open Swimming sub-accordion after a short delay
        setTimeout(() => {
            // Close any other open sub-accordions first
            masterAccordion.querySelectorAll('.instructor-item').forEach(item => {
                if (item !== swimmingItem) {
                    item.classList.remove('active');
                }
            });
            
            // Open the Swimming accordion
            console.log('🏊‍♂️ Opening Swimming accordion...');
            swimmingItem.classList.add('active');
            
            // Optional: Scroll to the swimming section specifically
            setTimeout(() => {
                swimmingItem.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'start',
                    inline: 'nearest'
                });
            }, 300);
            
        }, 500); // Wait for master accordion to open
        
    }, 800); // Wait for initial scroll to complete
}

// Function to scroll to and open Field Trips & Belt Exam information
function scrollToFieldTripsInfo() {
    console.log('🚌🏅 Field Trips/Belt Exams icon clicked - navigating to Field Trips & Belt Exam info...');
    
    // Find the Summer Camp 2025 accordion specifically by looking for the text content
    const summerCampHeader = Array.from(document.querySelectorAll('.master-instructor-header'))
        .find(header => header.textContent.includes('More Information about Summer Camp 2025'));
    
    const masterAccordion = summerCampHeader ? summerCampHeader.closest('.master-instructor-accordion') : null;
    
    if (!masterAccordion || !summerCampHeader) {
        console.error('❌ Summer Camp master accordion not found');
        console.log('Available master headers:', document.querySelectorAll('.master-instructor-header'));
        return;
    }
    
    console.log('✅ Found Summer Camp accordion:', masterAccordion);
    
    // Find the Field Trips & Belt Exam accordion item
    const fieldTripsAccordion = document.querySelector('[data-instructor="camp6"]');
    const fieldTripsItem = fieldTripsAccordion ? fieldTripsAccordion.parentElement : null;
    
    if (!fieldTripsAccordion || !fieldTripsItem) {
        console.error('❌ Field Trips & Belt Exam accordion not found');
        return;
    }
    
    // Step 1: Scroll to the master accordion with smooth scrolling
    masterAccordion.scrollIntoView({ 
        behavior: 'smooth', 
        block: 'start',
        inline: 'nearest'
    });
    
    // Step 2: Open master accordion if it's not already open
    setTimeout(() => {
        if (!masterAccordion.classList.contains('active')) {
            console.log('🔓 Opening master accordion...');
            masterAccordion.classList.add('active');
        }
        
        // Step 3: Open Field Trips & Belt Exam sub-accordion after a short delay
        setTimeout(() => {
            // Close any other open sub-accordions first
            masterAccordion.querySelectorAll('.instructor-item').forEach(item => {
                if (item !== fieldTripsItem) {
                    item.classList.remove('active');
                }
            });
            
            // Open the Field Trips & Belt Exam accordion
            console.log('🚌🏅 Opening Field Trips & Belt Exam accordion...');
            fieldTripsItem.classList.add('active');
            
            // Optional: Scroll to the field trips section specifically
            setTimeout(() => {
                fieldTripsItem.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'start',
                    inline: 'nearest'
                });
            }, 300);
            
        }, 500); // Wait for master accordion to open
        
    }, 800); // Wait for initial scroll to complete
}

// Function to scroll to and open Daily Schedule information  
function scrollToDailyScheduleInfo() {
    console.log('🥋 Karate Instruction icon clicked - navigating to Daily Schedule info...');
    
    // Find the Summer Camp 2025 accordion specifically by looking for the text content
    const summerCampHeader = Array.from(document.querySelectorAll('.master-instructor-header'))
        .find(header => header.textContent.includes('More Information about Summer Camp 2025'));
    
    const masterAccordion = summerCampHeader ? summerCampHeader.closest('.master-instructor-accordion') : null;
    
    if (!masterAccordion || !summerCampHeader) {
        console.error('❌ Summer Camp master accordion not found');
        console.log('Available master headers:', document.querySelectorAll('.master-instructor-header'));
        return;
    }
    
    console.log('✅ Found Summer Camp accordion:', masterAccordion);
    
    // Find the Daily Schedule accordion item
    const dailyScheduleAccordion = document.querySelector('[data-instructor="camp3"]');
    const dailyScheduleItem = dailyScheduleAccordion ? dailyScheduleAccordion.parentElement : null;
    
    if (!dailyScheduleAccordion || !dailyScheduleItem) {
        console.error('❌ Daily Schedule accordion not found');
        return;
    }
    
    // Step 1: Scroll to the master accordion with smooth scrolling
    masterAccordion.scrollIntoView({ 
        behavior: 'smooth', 
        block: 'start',
        inline: 'nearest'
    });
    
    // Step 2: Open master accordion if it's not already open
    setTimeout(() => {
        if (!masterAccordion.classList.contains('active')) {
            console.log('🔓 Opening master accordion...');
            masterAccordion.classList.add('active');
        }
        
        // Step 3: Open Daily Schedule sub-accordion after a short delay
        setTimeout(() => {
            // Close any other open sub-accordions first
            masterAccordion.querySelectorAll('.instructor-item').forEach(item => {
                if (item !== dailyScheduleItem) {
                    item.classList.remove('active');
                }
            });
            
            // Open the Daily Schedule accordion
            console.log('🥋 Opening Daily Schedule accordion...');
            dailyScheduleItem.classList.add('active');
            
            // Optional: Scroll to the daily schedule section specifically
            setTimeout(() => {
                dailyScheduleItem.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'start',
                    inline: 'nearest'
                });
            }, 300);
            
        }, 500); // Wait for master accordion to open
        
    }, 800); // Wait for initial scroll to complete
} 