// Scoped Schedule Integration for Index.php
(function() {
    'use strict';
    
    // Get the schedule integration container
    const scheduleContainer = document.querySelector('.schedule-integration');
    if (!scheduleContainer) {
        console.warn('Schedule integration container not found');
        return;
    }
    
    // Scoped query functions
    function scopedQuerySelector(selector) {
        return scheduleContainer.querySelector(selector);
    }
    
    function scopedQuerySelectorAll(selector) {
        return scheduleContainer.querySelectorAll(selector);
    }
    
    function scopedGetElementById(id) {
        return scheduleContainer.querySelector('#' + id);
    }

// Class data from the spreadsheet
const classData = [
    // Monday
    {
        time: "6:00 pm",
        day: "Monday",
        title: "All Belts",
        type: "youth",
        ageGroup: "all",
        beltLevel: "all",
        location: "Silver Spring MD",
        fullTitle: "Y-Calvary All Belts"
    },
    {
        time: "7:00 pm",
        day: "Monday",
        title: "All Belts",
        type: "youth",
        ageGroup: "all",
        beltLevel: "all",
        location: "Silver Spring MD",
        fullTitle: "Y-Calvary All Belts"
    },
    {
        time: "7:30 pm",
        day: "Monday",
        title: "",
        type: "adult",
        ageGroup: "all",
        beltLevel: "all",
        location: "Silver Spring MD",
        fullTitle: "A-East Silver Spring ES"
    },
    
    // Tuesday
    {
        time: "6:30 pm",
        day: "Tuesday",
        title: "All Belts",
        type: "youth",
        ageGroup: "all",
        beltLevel: "all",
        location: "NW DC",
        fullTitle: "Y-Cleveland Park Club All Belts"
    },
    {
        time: "7:30 pm",
        day: "Tuesday",
        title: "Fundamentals",
        type: "adult",
        ageGroup: "adult",
        beltLevel: "all",
        location: "Silver Spring MD",
        fullTitle: "A-Kemp Mill ES Fundamentals"
    },
    
    // Wednesday
    {
        time: "6:30 pm",
        day: "Wednesday",
        title: "Master Form / Jujitsu",
        type: "youth",
        ageGroup: "intermediate",
        beltLevel: "green-plus",
        location: "NW DC",
        fullTitle: "Y-Cleveland Park Club Master Form / Jujitsu"
    },
    {
        time: "6:30 pm",
        day: "Wednesday",
        title: "White-Green Belts",
        type: "youth",
        ageGroup: "all",
        beltLevel: "green-blue", // Assuming purple is included in green-blue
        location: "Arlington VA",
        fullTitle: "Y-ACC White-Green Belts"
    },
    {
        time: "6:30 pm",
        day: "Wednesday",
        title: "All Belts",
        type: "youth",
        ageGroup: "all",
        beltLevel: "all",
        location: "Rockville MD",
        fullTitle: "Y-Bayard Rustin ES All Belts"
    },
    {
        time: "7:30 pm",
        day: "Wednesday",
        title: "",
        type: "adult",
        ageGroup: "adult",
        beltLevel: "all",
        location: "Arlington VA",
        fullTitle: "A-ACC"
    },
    
    // Thursday
    {
        time: "6:00 pm",
        day: "Thursday",
        title: "All Belts",
        type: "youth",
        ageGroup: "all",
        beltLevel: "all",
        location: "Silver Spring MD",
        fullTitle: "Y-Calvary All Belts"
    },
    {
        time: "6:30 pm",
        day: "Thursday",
        title: "White-Green Belts",
        type: "youth",
        ageGroup: "all",
        beltLevel: "green-blue",
        location: "Arlington VA",
        fullTitle: "Y-ACC White-Green Belts"
    },
    {
        time: "7:00 pm",
        day: "Thursday",
        title: "Sparring",
        type: "mixed",
        ageGroup: "all",
        beltLevel: "all",
        location: "Silver Spring MD",
        fullTitle: "Y/A-Calvary Sparring"
    },
    
    // Friday
    {
        time: "6:30 pm",
        day: "Friday",
        title: "Open Mat",
        type: "adult",
        ageGroup: "adult",
        beltLevel: "all",
        location: "Silver Spring MD",
        fullTitle: "A-Calvary Open Mat"
    },
    
    // Saturday
    {
        time: "9:00 am",
        day: "Saturday",
        title: "Beginner #1",
        type: "youth",
        ageGroup: "beginner",
        beltLevel: "white-yellow",
        location: "Glenn Dale MD",
        fullTitle: "Y-Reid Temple AME Church Beginner #1"
    },
    {
        time: "10:00 am",
        day: "Saturday",
        title: "Beginner #1",
        type: "youth",
        ageGroup: "beginner",
        beltLevel: "white-yellow",
        location: "NW DC",
        fullTitle: "Y-St. Paul's Lutheran Beginner #1"
    },
    {
        time: "10:00 am",
        day: "Saturday",
        title: "Beginner #2 / Interm.",
        type: "youth",
        ageGroup: "beginner", // Primary age group for filtering
        ageGroups: ["beginner", "intermediate"], // Multiple age groups for badges
        beltLevel: "white-yellow",
        location: "Glenn Dale MD",
        fullTitle: "Y-St. Paul's Lutheran Beginner #2 / Interm."
    },
    {
        time: "11:00 am",
        day: "Saturday",
        title: "Beginner #2",
        type: "youth",
        ageGroup: "beginner",
        beltLevel: "white-yellow",
        location: "NW DC",
        fullTitle: "Y-St. Paul's Lutheran Beginner #2"
    },
    {
        time: "11:00 am",
        day: "Saturday",
        title: "Little Ninja / Beg.",
        type: "youth",
        ageGroup: "little-ninja", // Primary age group for filtering
        ageGroups: ["little-ninja", "beginner"], // Multiple age groups for badges
        beltLevel: "white-yellow",
        location: "Silver Spring MD",
        fullTitle: "Y-Pine Crest ES Little Ninja / Beg."
    },
    {
        time: "12:00 pm",
        day: "Saturday",
        title: "Interm. / Adv.",
        type: "youth",
        ageGroup: "intermediate", // Primary age group for filtering
        ageGroups: ["intermediate", "advanced"], // Multiple age groups for badges
        beltLevel: "green-blue",
        location: "NW DC",
        fullTitle: "Y-St. Paul's Lutheran Interm. / Adv."
    },
    {
        time: "12:00 pm",
        day: "Saturday",
        title: "Interm. / Adv.",
        type: "youth",
        ageGroup: "intermediate", // Primary age group for filtering
        ageGroups: ["intermediate", "advanced"], // Multiple age groups for badges
        beltLevel: "green-blue",
        location: "Silver Spring MD",
        fullTitle: "Y-Pine Crest ES Interm. / Adv."
    },
    {
        time: "12:00 pm",
        day: "Saturday",
        title: "Beginner",
        type: "youth",
        ageGroup: "beginner",
        beltLevel: "white-yellow",
        location: "Capitol Hill DC",
        fullTitle: "Y-Christ Church + Washington Parish Beginner"
    },
    {
        time: "1:00 pm",
        day: "Saturday",
        title: "Beginner",
        type: "youth",
        ageGroup: "beginner",
        beltLevel: "white-yellow",
        location: "Capitol Hill DC",
        fullTitle: "Y-Christ Church + Washington Parish Beginner"
    },
    {
        time: "1:00 pm",
        day: "Saturday",
        title: "",
        type: "adult",
        ageGroup: "adult",
        beltLevel: "all",
        location: "Silver Spring MD",
        fullTitle: "A-Pine Crest ES"
    },
    {
        time: "2:00 pm",
        day: "Saturday",
        title: "Interm. / Adv.",
        type: "youth",
        ageGroup: "advanced", // Primary age group for filtering
        ageGroups: ["intermediate", "advanced"], // Multiple age groups for badges
        beltLevel: "brown-red",
        location: "Capitol Hill DC",
        fullTitle: "Y-Christ Church + Washington Parish Interm. / Adv."
    },
    
    // Sunday
    {
        time: "10:00 am",
        day: "Sunday",
        title: "Little Ninja",
        type: "youth",
        ageGroup: "little-ninja",
        beltLevel: "all",
        location: "Silver Spring MD",
        fullTitle: "Y-East Silver Spring ES Little Ninja",
        shortClass: true // 30-minute class
    },
    {
        time: "10:00 am",
        day: "Sunday",
        title: "Beginner",
        type: "youth",
        ageGroup: "beginner",
        beltLevel: "white-yellow",
        location: "Silver Spring MD",
        fullTitle: "Y-East Silver Spring ES Beginner"
    },
    {
        time: "11:00 am",
        day: "Sunday",
        title: "Intermediate",
        type: "youth",
        ageGroup: "intermediate",
        beltLevel: "green-blue",
        location: "Silver Spring MD",
        fullTitle: "Y-East Silver Spring ES Intermediate"
    },
    {
        time: "12:00 pm",
        day: "Sunday",
        title: "Open Mat / Test Prep.",
        type: "mixed",
        ageGroup: "all",
        beltLevel: "all",
        location: "Silver Spring MD",
        fullTitle: "Y/A-East Silver Spring ES Open Mat / Test Prep."
    },
    {
        time: "1:00 pm",
        day: "Sunday",
        title: "Master Form / Kenpo",
        type: "mixed",
        ageGroup: "intermediate", // Green+
        beltLevel: "green-plus",
        location: "Silver Spring MD",
        fullTitle: "Y/A-East Silver Spring ES Master Form / Kenpo"
    },
    {
        time: "2:00 pm",
        day: "Sunday",
        title: "Brown & Red Belts",
        type: "mixed",
        ageGroup: "advanced",
        beltLevel: "brown-red",
        location: "Silver Spring MD",
        fullTitle: "Y/A-East Silver Spring ES Brown & Red Belts"
    }
];

// Global variables to track schedule state
let isScheduleExpanded = false;
let isToggleAction = false;
let expandedDays = new Set(); // Track which individual days are expanded

// Debug: Monitor all scroll events to catch unwanted scrolling
let isMonitoringScroll = false;
function startScrollMonitoring(context) {
    if (isMonitoringScroll) return;
    isMonitoringScroll = true;
    console.log(`🔍 Starting scroll monitoring for: ${context}`);
    
    const scrollHandler = (e) => {
        console.log(`🔄 SCROLL EVENT detected! New position: ${window.pageYOffset}, triggered by:`, e.target);
        console.log(`🔄 Event type:`, e.type, 'Context:', context);
    };
    
    window.addEventListener('scroll', scrollHandler, { passive: true });
    
    setTimeout(() => {
        window.removeEventListener('scroll', scrollHandler);
        isMonitoringScroll = false;
        console.log(`🏁 Scroll monitoring ended for: ${context}`);
    }, 2000); // Monitor for 2 seconds
}

// Helper function to create a class card element
function createClassCard(cls) {
    const classCard = document.createElement('div');
    classCard.className = 'class-card';
    
    // Generate badges
    const typeBadge = `<span class="class-type ${cls.type}">${cls.type.toUpperCase()}</span>`;
    
    let ageBadge = '';
    if (cls.ageGroup && cls.ageGroup !== 'all') {
        const ageGroupMap = {
            'little-ninja': 'Little Ninja (3-5)',
            'beginner': 'Beginner (6-9)',
            'intermediate': 'Intermediate (10-12)',
            'advanced': 'Advanced (13+)'
        };
        ageBadge = `<span class="age-group ${cls.ageGroup}">${ageGroupMap[cls.ageGroup] || cls.ageGroup}</span>`;
    }
    
    let beltBadges = '';
    if (cls.beltLevel && cls.beltLevel !== 'all') {
        if (cls.beltLevel === 'white-yellow') {
            beltBadges = '<span class="belt-level white">White</span><span class="belt-level yellow">Yellow</span>';
        } else if (cls.beltLevel === 'green-blue') {
            beltBadges = '<span class="belt-level white">White</span><span class="belt-level yellow">Yellow</span><span class="belt-level green">Green</span><span class="belt-level purple">Purple</span>';
        } else if (cls.beltLevel === 'brown-red') {
            beltBadges = '<span class="belt-level brown">Brown</span><span class="belt-level red">Red</span>';
        } else if (cls.beltLevel === 'green-plus') {
            // Check class title to determine if it's Kenpo or Jujitsu
            if (cls.title.includes('Jujitsu')) {
                beltBadges = '<span class="belt-level master-form">Master Form<br>/ Jujitsu</span>';
            } else {
                beltBadges = '<span class="belt-level master-form">Master Form<br>/ Kenpo</span>';
            }
        } else {
            // Fallback for any other belt levels
            beltBadges = `<span class="belt-level ${cls.beltLevel}">${cls.beltLevel}</span>`;
        }
    }
    
    classCard.innerHTML = `
        <div class="class-time">
            ${cls.time}
            ${cls.shortClass ? '<div class="class-end-time">ends at 10:30 am</div>' : ''}
        </div>
        <div class="class-title">${cleanTitle(cls.fullTitle)}</div>
        <div class="class-badges">
            ${typeBadge}
            ${ageBadge}
            ${beltBadges}
        </div>
        <div class="class-location">${cls.location}</div>
    `;
    
    return classCard;
}

// Function to expand a specific day without full DOM rebuild
function expandDayInPlace(day, dayColumn, dayClasses, currentlyShownClasses) {
    console.log(`🔍 Expanding ${day} in place...`);
    
    // Store current scroll position for stability
    const currentScrollY = window.pageYOffset;
    
    // Mark this day as expanded
    expandedDays.add(day);
    
    // Find the classes container and more indicator
    const classesContainer = dayColumn.querySelector('.classes-container');
    const moreIndicator = dayColumn.querySelector('.more-classes-indicator');
    
    if (classesContainer && moreIndicator) {
        // Remove the "more" indicator
        moreIndicator.remove();
        
        // Add the remaining classes
        const remainingClasses = dayClasses.slice(currentlyShownClasses.length);
        remainingClasses.forEach(cls => {
            const classCard = createClassCard(cls);
            classesContainer.appendChild(classCard);
        });
        
        // Add "Show Less" indicator
        const lessIndicator = document.createElement('div');
        lessIndicator.className = 'more-classes-indicator show-less';
        lessIndicator.innerHTML = `<span>Show Less</span>`;
        lessIndicator.style.cursor = 'pointer';
        lessIndicator.title = 'Click to show fewer classes for this day';
        lessIndicator.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            
            // Block all scroll events temporarily
            const originalScrollY = window.pageYOffset;
            const blockScroll = (scrollEvent) => {
                scrollEvent.preventDefault();
                scrollEvent.stopPropagation();
                window.scrollTo(0, originalScrollY);
                console.log(`🚫 Blocked unwanted scroll event`);
            };
            
            // Add scroll blocker
            window.addEventListener('scroll', blockScroll, { passive: false });
            
            // Remove blocker after collapse is complete
            setTimeout(() => {
                window.removeEventListener('scroll', blockScroll);
                console.log(`✅ Scroll blocker removed`);
            }, 500);
            
            collapseDayInPlace(day, dayColumn, dayClasses);
        });
        dayColumn.appendChild(lessIndicator);
        
        // Debug: Log scroll position after expansion (no adjustment)
        requestAnimationFrame(() => {
            console.log(`📏 After ${day} expansion: scroll position ${window.pageYOffset} (was ${currentScrollY})`);
        });
    }
}

// Function to collapse a specific day without DOM removal (CSS-based hiding)
function collapseDayInPlace(day, dayColumn, dayClasses) {
    console.log(`🔍 Collapsing ${day} with CSS hiding...`);
    
    // Mark this day as collapsed
    expandedDays.delete(day);
    
    // Find the classes container and less indicator
    const classesContainer = dayColumn.querySelector('.classes-container');
    const lessIndicator = dayColumn.querySelector('.more-classes-indicator.show-less');
    
    if (classesContainer && lessIndicator) {
        // Remove the "show less" indicator
        lessIndicator.remove();
        
        // Hide extra class cards with CSS instead of removing them (keep only first 2 visible)
        const classCards = classesContainer.querySelectorAll('.class-card');
        for (let i = 2; i < classCards.length; i++) {
            classCards[i].style.display = 'none';
            classCards[i].setAttribute('data-hidden-by-collapse', 'true');
        }
        
        // Add "more classes" indicator if needed
        const isMobile = window.innerWidth <= 768;
        const classesPerDay = isMobile ? null : 2;
        
        if (classesPerDay && dayClasses.length > classesPerDay) {
            const moreIndicator = document.createElement('div');
            moreIndicator.className = 'more-classes-indicator';
            moreIndicator.innerHTML = `<span>+${dayClasses.length - classesPerDay} more class${dayClasses.length - classesPerDay === 1 ? '' : 'es'}</span>`;
            moreIndicator.style.cursor = 'pointer';
            moreIndicator.title = 'Click to view all classes for this day';
            moreIndicator.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                expandDayFromCollapsed(day, dayColumn, dayClasses);
            });
            dayColumn.appendChild(moreIndicator);
        }
        
        console.log(`✅ ${day} collapsed using CSS hiding - no DOM layout shift`);
    }
}

// Function to expand a day from collapsed state (show hidden cards)
function expandDayFromCollapsed(day, dayColumn, dayClasses) {
    console.log(`🔍 Expanding ${day} from collapsed state...`);
    
    // Mark this day as expanded
    expandedDays.add(day);
    
    // Find the classes container and more indicator
    const classesContainer = dayColumn.querySelector('.classes-container');
    const moreIndicator = dayColumn.querySelector('.more-classes-indicator');
    
    if (classesContainer && moreIndicator) {
        // Remove the "more" indicator
        moreIndicator.remove();
        
        // Show all hidden class cards
        const hiddenCards = classesContainer.querySelectorAll('.class-card[data-hidden-by-collapse="true"]');
        hiddenCards.forEach(card => {
            card.style.display = '';
            card.removeAttribute('data-hidden-by-collapse');
        });
        
        // Add "Show Less" indicator
        const lessIndicator = document.createElement('div');
        lessIndicator.className = 'more-classes-indicator show-less';
        lessIndicator.innerHTML = `<span>Show Less</span>`;
        lessIndicator.style.cursor = 'pointer';
        lessIndicator.title = 'Click to show fewer classes for this day';
        lessIndicator.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            
            // Block all scroll events temporarily
            const originalScrollY = window.pageYOffset;
            const blockScroll = (scrollEvent) => {
                scrollEvent.preventDefault();
                scrollEvent.stopPropagation();
                window.scrollTo(0, originalScrollY);
                console.log(`🚫 Blocked unwanted scroll event`);
            };
            
            // Add scroll blocker
            window.addEventListener('scroll', blockScroll, { passive: false });
            
            // Remove blocker after collapse is complete
            setTimeout(() => {
                window.removeEventListener('scroll', blockScroll);
                console.log(`✅ Scroll blocker removed`);
            }, 500);
            
            collapseDayInPlace(day, dayColumn, dayClasses);
        });
        dayColumn.appendChild(lessIndicator);
        
        console.log(`✅ ${day} expanded from collapsed state`);
    }
}

// Function to render classes based on filters
function renderClasses(filters = {}) {
    const scheduleContent = scopedGetElementById('schedule-content');
    scheduleContent.innerHTML = '';
    
    // Filter classes based on selected filters
    const filteredClasses = classData.filter(cls => {
        // Class type filtering with inclusive logic
        if (filters.classType && filters.classType !== 'all') {
            const excludeMixed = filters.excludeMixed;
            
            if (filters.classType === 'youth') {
                if (excludeMixed) {
                    // Exclude mixed classes - only show pure youth classes
                    if (cls.type !== 'youth') {
                        return false;
                    }
                } else {
                    // Include mixed classes - show youth and mixed classes
                    if (cls.type !== 'youth' && cls.type !== 'mixed') {
                        return false;
                    }
                }
            }
            
            if (filters.classType === 'adult') {
                if (excludeMixed) {
                    // Exclude mixed classes - only show pure adult classes
                    if (cls.type !== 'adult') {
                        return false;
                    }
                } else {
                    // Include mixed classes - show adult and mixed classes
                    if (cls.type !== 'adult' && cls.type !== 'mixed') {
                        return false;
                    }
                }
            }
            
            if (filters.classType === 'mixed' && cls.type !== 'mixed') {
                return false;
            }
        }
        
        // Age group filtering (only applies to youth and mixed classes)
        if (filters.ageGroup && filters.ageGroup !== 'all') {
            // If a specific youth group is selected, NEVER show adult-only classes
            if (cls.type === 'adult') {
                return false; // Exclude all adult-only classes when youth group is selected
            } else {
                // Get all age groups for this class (single or multiple)
                const classAgeGroups = cls.ageGroups || [cls.ageGroup];
                
                // For Little Ninjas: only show exact matches (age-specific)
                if (filters.ageGroup === 'little-ninja') {
                    if (!classAgeGroups.includes('little-ninja')) {
                        return false;
                    }
                } else {
                    // For Beginner/Intermediate/Advanced: show exact matches AND "all" belt classes
                    if (!classAgeGroups.includes(filters.ageGroup) && !classAgeGroups.includes('all')) {
                        return false;
                    }
                }
            }
        }
        // Belt level filtering with individual belt colors
        if (filters.beltLevel && filters.beltLevel !== 'all' && filters.beltLevel !== 'separator') {
            if (!isClassValidForBeltLevel(cls, filters.beltLevel)) {
                return false;
            }
        }
        if (filters.location && filters.location !== 'all' && cls.location !== filters.location) {
            return false;
        }
        if (filters.day && filters.day !== 'all' && cls.day !== filters.day) {
            return false;
        }
        return true;
    });
    
    if (filteredClasses.length === 0) {
        scheduleContent.innerHTML = '<div class="no-results">No classes match your filters. Try adjusting your selections.</div>';
        return;
    }
    
    // Limit classes shown per day when collapsed (responsive: 1 on mobile, 2 on desktop)
    const isMobile = window.innerWidth <= 768;
    const classesPerDay = isScheduleExpanded ? null : (isMobile ? null : 2);
    
    // Define days of the week in order
    const daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    
    // Determine which days to show based on day filter
    const daysToShow = filters.day && filters.day !== 'all' ? [filters.day] : daysOfWeek;
    
    // Group classes by day
    const classesByDay = {};
    daysToShow.forEach(day => {
        classesByDay[day] = [];
    });
    
    filteredClasses.forEach(cls => {
        if (classesByDay[cls.day]) {
            classesByDay[cls.day].push(cls);
        }
    });
    
    // Sort classes within each day by time
    Object.keys(classesByDay).forEach(day => {
        classesByDay[day].sort((a, b) => {
            // Convert time to comparable format (24-hour) for accurate sorting
            const timeA = convertTo24Hour(a.time);
            const timeB = convertTo24Hour(b.time);
            
            // Convert to numbers for more reliable comparison
            const hourMinA = timeA.split(':').map(Number);
            const hourMinB = timeB.split(':').map(Number);
            
            // Compare hours first, then minutes
            if (hourMinA[0] !== hourMinB[0]) {
                return hourMinA[0] - hourMinB[0];
            }
            return hourMinA[1] - hourMinB[1];
        });
    });
    
    // Create the calendar layout
    const weeklyCalendar = document.createElement('div');
    // Always use single-day layout (vertical stacking) for all screen sizes
    weeklyCalendar.className = 'weekly-calendar single-day-view';
    
    daysToShow.forEach(day => {
        const dayColumn = document.createElement('div');
        dayColumn.className = 'day-column';
        
        // Day header
        const dayHeader = document.createElement('div');
        dayHeader.className = 'day-header';
        dayHeader.textContent = day;
        dayColumn.appendChild(dayHeader);
        
        // Classes for this day
        const dayClasses = classesByDay[day];
        
        if (dayClasses.length === 0) {
            const noClasses = document.createElement('div');
            noClasses.className = 'no-classes';
            noClasses.textContent = 'No classes';
            dayColumn.appendChild(noClasses);
        } else {
            // Create a container for class cards in single-day view for better desktop layout
            const classesContainer = document.createElement('div');
            classesContainer.className = 'classes-container';
            
            // Check if this specific day is expanded
            const isDayExpanded = expandedDays.has(day);
            const effectiveClassesPerDay = isDayExpanded ? null : classesPerDay;
            
            // Limit classes shown per day when collapsed
            const classesToShowForDay = effectiveClassesPerDay ? dayClasses.slice(0, effectiveClassesPerDay) : dayClasses;
            
            classesToShowForDay.forEach(cls => {
                const classCard = document.createElement('div');
                classCard.className = 'class-card';
                
                // Determine type badge
                let typeBadge = '';
                if (cls.type === 'youth') {
                    typeBadge = '<span class="class-type youth">Youth</span>';
                } else if (cls.type === 'adult') {
                    typeBadge = '<span class="class-type adult">Adult (13+)</span>';
                } else {
                    typeBadge = '<span class="class-type mixed">Mixed<br>(Youth & Adult)</span>';
                }
                
                // Determine age group badge(s) - handle both single and multiple age groups
                let ageBadge = '';
                if (cls.type !== 'adult') { // Only show youth age group badges for youth and mixed classes
                    // Check if class has multiple age groups
                    const ageGroupsToShow = cls.ageGroups || [cls.ageGroup];
                    
                    const ageBadges = ageGroupsToShow.map(group => {
                        if (group === 'little-ninja') {
                            return '<span class="age-group">Little<br>Ninjas</span>';
                        } else if (group === 'beginner') {
                            return '<span class="age-group">Beginner</span>';
                        } else if (group === 'intermediate') {
                            return '<span class="age-group">Interm.</span>';
                        } else if (group === 'advanced') {
                            return '<span class="age-group">Advanced</span>';
                        }
                        return '';
                    }).filter(badge => badge !== '');
                    
                    ageBadge = ageBadges.join('');
                }
                
                // Determine belt level badges - create individual badges for each applicable belt color
                // Never show belt badges for adult-only classes (they don't use structured belt system)
                let beltBadges = '';
                const isAdultOnlyClass = cls.type === 'adult';
                
                if (isAdultOnlyClass) {
                    // Never show belt badges for adult-only classes
                    beltBadges = '';
                } else {
                    // Show belt badges for youth and mixed classes based on age group(s) and belt level
                    
                    // Skip "All Belts" for mixed classes without specific age groups (redundant)
                    const isMixedWithoutSpecificAge = cls.type === 'mixed' && (cls.ageGroup === 'all' || !cls.ageGroups);
                    
                    if (cls.beltLevel === 'green-plus') {
                        // Master Form classes get special badge regardless of age group
                        // Check class title to determine if it's Kenpo or Jujitsu
                        if (cls.title.includes('Jujitsu')) {
                            beltBadges = '<span class="belt-level master-form">Master Form<br>/ Jujitsu</span>';
                        } else {
                            beltBadges = '<span class="belt-level master-form">Master Form<br>/ Kenpo</span>';
                        }
                    } else if (cls.beltLevel === 'all' && !isMixedWithoutSpecificAge) {
                        // Don't show "All Belts" for Little Ninjas classes (they have age-specific curriculum)
                        const isLittleNinjasClass = cls.ageGroup === 'little-ninja' || (cls.ageGroups && cls.ageGroups.includes('little-ninja'));
                        if (!isLittleNinjasClass) {
                            beltBadges = '<span class="belt-level all-belts">All Belts</span>';
                        }
                    } else {
                        // Get all age groups for this class (single or multiple)
                        const classAgeGroups = cls.ageGroups || [cls.ageGroup];
                        const beltSet = new Set(); // Use Set to avoid duplicate belts
                        
                        // Generate belt badges for each age group
                        classAgeGroups.forEach(group => {
                            if (group === 'beginner') {
                                // Beginner classes: White and Yellow belts only
                                beltSet.add('<span class="belt-level white">White</span>');
                                beltSet.add('<span class="belt-level yellow">Yellow</span>');
                            } else if (group === 'intermediate') {
                                // Intermediate classes: Green, Purple, and Blue belts only
                                beltSet.add('<span class="belt-level green">Green</span>');
                                beltSet.add('<span class="belt-level purple">Purple</span>');
                                beltSet.add('<span class="belt-level blue">Blue</span>');
                            } else if (group === 'advanced') {
                                // Advanced classes: Brown and Red belts only
                                beltSet.add('<span class="belt-level brown">Brown</span>');
                                beltSet.add('<span class="belt-level red">Red</span>');
                            }
                        });
                        
                        // If no age-group specific belts were added, use fallback belt level logic
                        // But skip fallback for mixed classes without specific age groups
                        if (beltSet.size === 0 && !isMixedWithoutSpecificAge) {
                            if (cls.beltLevel === 'white-yellow') {
                                // Fallback for white-yellow belt level grouping
                                beltBadges = '<span class="belt-level white">White</span><span class="belt-level yellow">Yellow</span>';
                            } else if (cls.beltLevel === 'green-blue') {
                                // Fallback for green-blue belt level grouping (like "White-Purple Belts" classes)
                                beltBadges = '<span class="belt-level white">White</span><span class="belt-level yellow">Yellow</span><span class="belt-level green">Green</span><span class="belt-level purple">Purple</span>';
                            } else if (cls.beltLevel === 'brown-red') {
                                // Fallback for brown-red belt level grouping
                                beltBadges = '<span class="belt-level brown">Brown</span><span class="belt-level red">Red</span>';
                            } else if (cls.beltLevel === 'green-plus') {
                                // Master Form classes - check if it's Kenpo or Jujitsu
                                if (cls.title.includes('Jujitsu')) {
                                    beltBadges = '<span class="belt-level master-form">Master Form<br>/ Jujitsu</span>';
                                } else {
                                    beltBadges = '<span class="belt-level master-form">Master Form<br>/ Kenpo</span>';
                                }
                            }
                        } else {
                            // Sort belt badges in proper order and join for multiple age groups
                            beltBadges = sortBeltBadges(beltSet).join('');
                        }
                    }
                }
                
                classCard.innerHTML = `
                    <div class="class-time">
                        ${cls.time}
                        ${cls.shortClass ? '<div class="class-end-time">ends at 10:30 am</div>' : ''}
                    </div>
                    <div class="class-title">${cleanTitle(cls.fullTitle)}</div>
                    <div class="class-badges">
                        ${typeBadge}
                        ${ageBadge}
                        ${beltBadges}
                    </div>
                    <div class="class-location">${cls.location}</div>
                `;
                
                // Always use classes container since we're always in single-day layout
                classesContainer.appendChild(classCard);
            });
            
            // Always append the classes container since we're always in single-day layout
            dayColumn.appendChild(classesContainer);
            
            // Add "more classes" or "show less" indicator for this day
            if (!isDayExpanded && effectiveClassesPerDay && dayClasses.length > effectiveClassesPerDay) {
                // Show "more classes" indicator
                const moreIndicator = document.createElement('div');
                moreIndicator.className = 'more-classes-indicator';
                moreIndicator.innerHTML = `<span>+${dayClasses.length - effectiveClassesPerDay} more class${dayClasses.length - effectiveClassesPerDay === 1 ? '' : 'es'}</span>`;
                moreIndicator.style.cursor = 'pointer';
                moreIndicator.title = 'Click to view all classes for this day';
                moreIndicator.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Expand this specific day without full DOM rebuild
                    expandDayInPlace(day, dayColumn, dayClasses, classesToShowForDay);
                });
                dayColumn.appendChild(moreIndicator);
            } else if (isDayExpanded && classesPerDay && dayClasses.length > classesPerDay) {
                // Show "show less" indicator
                const lessIndicator = document.createElement('div');
                lessIndicator.className = 'more-classes-indicator show-less';
                lessIndicator.innerHTML = `<span>Show Less</span>`;
                lessIndicator.style.cursor = 'pointer';
                lessIndicator.title = 'Click to show fewer classes for this day';
                lessIndicator.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Collapse this specific day without full DOM rebuild
                    collapseDayInPlace(day, dayColumn, dayClasses);
                });
                dayColumn.appendChild(lessIndicator);
            }
        }
        
        weeklyCalendar.appendChild(dayColumn);
    });
    
    scheduleContent.appendChild(weeklyCalendar);
    
    // Calculate total hidden classes across all days (considering individual expansions)
    let totalHiddenClasses = 0;
    let hasExpandedDays = false;
    if (classesPerDay) {
        daysToShow.forEach(day => {
            const dayClasses = classesByDay[day];
            const isDayExpanded = expandedDays.has(day);
            if (isDayExpanded) {
                hasExpandedDays = true;
            } else if (dayClasses.length > classesPerDay) {
                totalHiddenClasses += dayClasses.length - classesPerDay;
            }
        });
    }
    
    // Add global toggle button if there are more classes to show OR if any days are expanded
    if (totalHiddenClasses > 0 || hasExpandedDays || isScheduleExpanded) {
        const toggleButton = document.createElement('button');
        toggleButton.className = 'schedule-toggle-btn';
        
        if (hasExpandedDays || isScheduleExpanded) {
            toggleButton.innerHTML = '▲ Collapse All Days';
        } else {
            toggleButton.innerHTML = `▼ Expand All Days (${totalHiddenClasses} more class${totalHiddenClasses === 1 ? '' : 'es'})`;
        }
        
        toggleButton.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            
            if (hasExpandedDays || isScheduleExpanded) {
                // Collapse all days - use full rebuild for global action
                expandedDays.clear();
                isScheduleExpanded = false;
            } else {
                // Expand all days - use full rebuild for global action
                daysToShow.forEach(day => {
                    const dayClasses = classesByDay[day];
                    if (classesPerDay && dayClasses.length > classesPerDay) {
                        expandedDays.add(day);
                    }
                });
            }
            isToggleAction = true;
            updateFilters(); // Re-render with new expanded state
            isToggleAction = false;
        });
        
        scheduleContent.appendChild(toggleButton);
    }
}

// Helper function to check if a class is valid for the selected individual belt level
function isClassValidForBeltLevel(cls, selectedBeltLevel) {
    // Master Form is specific - only show green-plus classes with title matching
    if (selectedBeltLevel === 'master-form-kenpo') {
        return cls.beltLevel === 'green-plus' && cls.title.includes('Kenpo');
    }
    if (selectedBeltLevel === 'master-form-jujitsu') {
        return cls.beltLevel === 'green-plus' && cls.title.includes('Jujitsu');
    }
    // Legacy support for old 'master-form' filter (show both)
    if (selectedBeltLevel === 'master-form') {
        return cls.beltLevel === 'green-plus';
    }
    
    // For individual belt colors, map them to the grouped belt levels in the data
    const beltLevelMapping = {
        'white': ['white-yellow', 'all'],
        'yellow': ['white-yellow', 'all'],
        'green': ['green-blue', 'green-plus', 'all'],
        'purple': ['green-blue', 'all'],
        'blue': ['green-blue', 'all'],
        'brown': ['brown-red', 'all'],
        'red': ['brown-red', 'all']
    };
    
    const validBeltLevels = beltLevelMapping[selectedBeltLevel];
    return validBeltLevels && validBeltLevels.includes(cls.beltLevel);
}

// Helper function to clean up class titles by removing prefixes
function cleanTitle(title) {
    // Remove prefixes like "Y-", "A-", "Y/A-" from the beginning of titles
    return title.replace(/^(Y-|A-|Y\/A-)/g, '');
}

// Helper function to sort belt badges in proper order
function sortBeltBadges(beltSet) {
    const beltOrder = ['white', 'yellow', 'green', 'purple', 'blue', 'brown', 'red'];
    const badges = Array.from(beltSet);
    
    return badges.sort((a, b) => {
        // Extract belt color from badge HTML
        const getColor = (badge) => {
            const match = badge.match(/belt-level (\w+)/);
            return match ? match[1] : '';
        };
        
        const colorA = getColor(a);
        const colorB = getColor(b);
        
        return beltOrder.indexOf(colorA) - beltOrder.indexOf(colorB);
    });
}

// Helper function to convert time to 24-hour format for sorting
function convertTo24Hour(timeStr) {
    // Handle cases like "6:00 pm" or "10:00 am"
    const startTime = timeStr.trim();
    const period = timeStr.includes('pm') ? 'pm' : 'am';
    
    // Split time and remove am/pm from minutes part
    let [hours, minutesPart] = startTime.split(':');
    let minutes = minutesPart.replace(/\s*(am|pm)/, '').trim();
    
    hours = parseInt(hours);
    
    if (period === 'pm' && hours !== 12) {
        hours += 12;
    } else if (period === 'am' && hours === 12) {
        hours = 0;
    }
    
    return `${hours.toString().padStart(2, '0')}:${minutes.padStart(2, '0')}`;
}

// Initialize custom dropdowns
function initializeCustomDropdowns() {
    const dropdowns = scopedQuerySelectorAll('.custom-dropdown');
    
    dropdowns.forEach(dropdown => {
        const selected = dropdown.querySelector('.dropdown-selected');
        const options = dropdown.querySelector('.dropdown-options');
        const optionElements = dropdown.querySelectorAll('.dropdown-option');
        
        // Toggle dropdown on click
        selected.addEventListener('click', (e) => {
            e.stopPropagation();
            
            // Don't open if disabled
            if (dropdown.classList.contains('disabled')) {
                return;
            }
            
            // Close other dropdowns
            dropdowns.forEach(otherDropdown => {
                if (otherDropdown !== dropdown) {
                    otherDropdown.querySelector('.dropdown-selected').classList.remove('active');
                    otherDropdown.querySelector('.dropdown-options').classList.remove('open');
                }
            });
            
            // Toggle current dropdown
            selected.classList.toggle('active');
            options.classList.toggle('open');
        });
        
        // Handle option selection
        optionElements.forEach(option => {
            option.addEventListener('click', (e) => {
                e.stopPropagation();
                
                // Skip separators
                if (option.classList.contains('dropdown-separator')) {
                    return;
                }
                
                // Update selected text
                const selectedText = dropdown.querySelector('.selected-text');
                selectedText.textContent = option.textContent;
                
                // Update active states
                optionElements.forEach(opt => opt.classList.remove('active'));
                option.classList.add('active');
                
                // Close dropdown
                selected.classList.remove('active');
                options.classList.remove('open');
                
                // Handle class type changes first
                const filterType = dropdown.getAttribute('data-filter');
                if (filterType === 'class-type') {
                    handleClassTypeChange(option.getAttribute('data-value'));
                }
                
                // Trigger filter update
                updateFilters();
            });
        });
    });
    
    // Close dropdowns when clicking outside
    scheduleContainer.addEventListener('click', () => {
        dropdowns.forEach(dropdown => {
            dropdown.querySelector('.dropdown-selected').classList.remove('active');
            dropdown.querySelector('.dropdown-options').classList.remove('open');
        });
    });
}

// Event listeners for filters
document.addEventListener('DOMContentLoaded', () => {
    // Initialize custom dropdowns
    initializeCustomDropdowns();
    
    // Initial render
    renderClasses();
    
    // Exclude mixed checkbox event
    const excludeMixedCheckbox = scopedGetElementById('exclude-mixed');
    if (excludeMixedCheckbox) {
        excludeMixedCheckbox.addEventListener('change', updateFilters);
    }
    
    // Reset filters button
    scopedGetElementById('reset-filters').addEventListener('click', resetFilters);
});

// Handle class type change to disable/enable youth group filter and show/hide exclude mixed checkbox
function handleClassTypeChange(classType) {
    const ageGroupDropdown = scopedQuerySelector('[data-filter="age-group"]');
    const excludeMixedContainer = scopedGetElementById('exclude-mixed-container');
    const excludeMixedCheckbox = scopedGetElementById('exclude-mixed');
    
    // Handle youth group filter
    if (classType === 'adult') {
        // Disable youth group dropdown for adult classes
        ageGroupDropdown.classList.add('disabled');
        // Reset to "All Youth Groups"
        const ageGroupSelected = ageGroupDropdown.querySelector('.selected-text');
        const ageGroupOptions = ageGroupDropdown.querySelectorAll('.dropdown-option');
        ageGroupSelected.textContent = 'All Youth Groups';
        ageGroupOptions.forEach(opt => opt.classList.remove('active'));
        ageGroupOptions[0].classList.add('active'); // First option is "All Youth Groups"
    } else {
        // Enable youth group dropdown for youth, mixed, or all classes
        ageGroupDropdown.classList.remove('disabled');
    }
    
    // Handle exclude mixed checkbox
    if (classType === 'youth' || classType === 'adult') {
        // Show checkbox for youth or adult selections
        excludeMixedContainer.style.display = 'block';
        excludeMixedCheckbox.checked = false; // Reset to unchecked (include mixed by default)
    } else {
        // Hide checkbox for "all" or "mixed" selections
        excludeMixedContainer.style.display = 'none';
        excludeMixedCheckbox.checked = false;
    }
}

// Reset all filters
function resetFilters() {
    // Reset all custom dropdowns to first option
    scopedQuerySelectorAll('.custom-dropdown').forEach(dropdown => {
        const selectedText = dropdown.querySelector('.selected-text');
        const options = dropdown.querySelectorAll('.dropdown-option');
        
        // Set to first option
        selectedText.textContent = options[0].textContent;
        options.forEach(opt => opt.classList.remove('active'));
        options[0].classList.add('active');
    });
    
    // Reset checkbox
    const excludeMixedCheckbox = scopedGetElementById('exclude-mixed');
    if (excludeMixedCheckbox) {
        excludeMixedCheckbox.checked = false;
    }
    
    // Hide exclude mixed container
    const excludeMixedContainer = scopedGetElementById('exclude-mixed-container');
    excludeMixedContainer.style.display = 'none';
    
    // Enable all dropdowns
    scopedQuerySelectorAll('.custom-dropdown').forEach(dropdown => {
        dropdown.classList.remove('disabled');
    });
    
    // Render all classes
    renderClasses();
}

function updateFilters() {
    // Store scroll position before any DOM changes
    const scrollBeforeUpdate = window.pageYOffset;
    console.log('🔄 updateFilters called, current scroll:', scrollBeforeUpdate);
    
    // Reset expanded state when filters change (but not when toggling)
    if (!isToggleAction) {
        isScheduleExpanded = false;
    }
    
    const filters = {};
    
    // Get values from custom dropdowns
    scopedQuerySelectorAll('.custom-dropdown').forEach(dropdown => {
        const filterType = dropdown.getAttribute('data-filter');
        const activeOption = dropdown.querySelector('.dropdown-option.active');
        if (activeOption) {
            filters[filterType] = activeOption.getAttribute('data-value');
        }
    });
    
    // Get exclude mixed checkbox value
    const excludeMixedCheckbox = scopedGetElementById('exclude-mixed');
    filters.excludeMixed = excludeMixedCheckbox ? excludeMixedCheckbox.checked : false;
    
    // Convert filter names to match existing code
    const normalizedFilters = {
        classType: filters['class-type'] || 'all',
        ageGroup: filters['age-group'] || 'all',
        beltLevel: filters['belt-level'] || 'all',
        location: filters.location || 'all',
        day: filters.day || 'all',
        excludeMixed: filters.excludeMixed
    };
    
    renderClasses(normalizedFilters);
    
    // Additional scroll preservation attempt in updateFilters
    if (isToggleAction) {
        console.log('🔄 Restoring scroll to:', scrollBeforeUpdate);
        setTimeout(() => {
            window.scrollTo({
                top: scrollBeforeUpdate,
                behavior: 'instant'
            });
        }, 10);
    }
} 

})();
