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
        title: "White-Purple Belts",
        type: "youth",
        ageGroup: "all",
        beltLevel: "green-blue", // Assuming purple is included in green-blue
        location: "Arlington VA",
        fullTitle: "Y-ACC White-Purple Belts"
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
        title: "Master Form / Kenpo",
        type: "mixed",
        ageGroup: "intermediate", // Green-Blue
        beltLevel: "green-plus",
        location: "Arlington VA",
        fullTitle: "Y/A-ACC Master Form / Kenpo"
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

// Function to render classes based on filters
function renderClasses(filters = {}) {
    const scheduleContainer = document.getElementById('schedule-content');
    scheduleContainer.innerHTML = '';
    
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
        scheduleContainer.innerHTML = '<div class="no-results">No classes match your filters. Try adjusting your selections.</div>';
        return;
    }
    
    // Limit classes shown per day when collapsed (responsive: 1 on mobile, 2 on desktop)
    const isMobile = window.innerWidth <= 768;
    const classesPerDay = isScheduleExpanded ? null : (isMobile ? 1 : 2);
    
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
    // Use single-day layout when a specific day is selected
    if (filters.day && filters.day !== 'all') {
        weeklyCalendar.className = 'weekly-calendar single-day-view';
    } else {
        weeklyCalendar.className = 'weekly-calendar';
    }
    
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
            if (filters.day && filters.day !== 'all') {
                classesContainer.className = 'classes-container';
            }
            
            // Limit classes shown per day when collapsed
            const classesToShowForDay = classesPerDay ? dayClasses.slice(0, classesPerDay) : dayClasses;
            
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
                        beltBadges = '<span class="belt-level master-form">Master Form<br>/ Kenpo</span>';
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
                                // Master Form classes
                                beltBadges = '<span class="belt-level master-form">Master Form<br>/ Kenpo</span>';
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
                
                if (filters.day && filters.day !== 'all') {
                    classesContainer.appendChild(classCard);
                } else {
                    dayColumn.appendChild(classCard);
                }
            });
            
            // Append the classes container to day column if in single-day view
            if (filters.day && filters.day !== 'all') {
                dayColumn.appendChild(classesContainer);
            }
            
            // Add "more classes" indicator for this day if there are hidden classes
            if (classesPerDay && dayClasses.length > classesPerDay) {
                const moreIndicator = document.createElement('div');
                moreIndicator.className = 'more-classes-indicator';
                moreIndicator.innerHTML = `<span>+${dayClasses.length - classesPerDay} more class${dayClasses.length - classesPerDay === 1 ? '' : 'es'}</span>`;
                dayColumn.appendChild(moreIndicator);
            }
        }
        
        weeklyCalendar.appendChild(dayColumn);
    });
    
    scheduleContainer.appendChild(weeklyCalendar);
    
    // Calculate total hidden classes across all days
    let totalHiddenClasses = 0;
    if (classesPerDay) {
        daysToShow.forEach(day => {
            const dayClasses = classesByDay[day];
            if (dayClasses.length > classesPerDay) {
                totalHiddenClasses += dayClasses.length - classesPerDay;
            }
        });
    }
    
    // Add toggle button if there are more classes to show OR if currently expanded
    if (totalHiddenClasses > 0 || isScheduleExpanded) {
        const toggleButton = document.createElement('button');
        toggleButton.className = 'schedule-toggle-btn';
        toggleButton.innerHTML = isScheduleExpanded ? 
            '▲ Show Less' : 
            `▼ View Entire Schedule (${totalHiddenClasses} more class${totalHiddenClasses === 1 ? '' : 'es'})`;
        
        toggleButton.addEventListener('click', () => {
            isScheduleExpanded = !isScheduleExpanded;
            isToggleAction = true;
            updateFilters(); // Re-render with new expanded state
            isToggleAction = false;
        });
        
        scheduleContainer.appendChild(toggleButton);
    }
}

// Helper function to check if a class is valid for the selected individual belt level
function isClassValidForBeltLevel(cls, selectedBeltLevel) {
    // Master Form is specific - only show green-plus classes
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
    const dropdowns = document.querySelectorAll('.custom-dropdown');
    
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
    document.addEventListener('click', () => {
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
    const excludeMixedCheckbox = document.getElementById('exclude-mixed');
    if (excludeMixedCheckbox) {
        excludeMixedCheckbox.addEventListener('change', updateFilters);
    }
    
    // Reset filters button
    document.getElementById('reset-filters').addEventListener('click', resetFilters);
});

// Handle class type change to disable/enable youth group filter and show/hide exclude mixed checkbox
function handleClassTypeChange(classType) {
    const ageGroupDropdown = document.querySelector('[data-filter="age-group"]');
    const excludeMixedContainer = document.getElementById('exclude-mixed-container');
    const excludeMixedCheckbox = document.getElementById('exclude-mixed');
    
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
    document.querySelectorAll('.custom-dropdown').forEach(dropdown => {
        const selectedText = dropdown.querySelector('.selected-text');
        const options = dropdown.querySelectorAll('.dropdown-option');
        
        // Set to first option
        selectedText.textContent = options[0].textContent;
        options.forEach(opt => opt.classList.remove('active'));
        options[0].classList.add('active');
    });
    
    // Reset checkbox
    const excludeMixedCheckbox = document.getElementById('exclude-mixed');
    if (excludeMixedCheckbox) {
        excludeMixedCheckbox.checked = false;
    }
    
    // Hide exclude mixed container
    const excludeMixedContainer = document.getElementById('exclude-mixed-container');
    excludeMixedContainer.style.display = 'none';
    
    // Enable all dropdowns
    document.querySelectorAll('.custom-dropdown').forEach(dropdown => {
        dropdown.classList.remove('disabled');
    });
    
    // Render all classes
    renderClasses();
}

function updateFilters() {
    // Reset expanded state when filters change (but not when toggling)
    if (!isToggleAction) {
        isScheduleExpanded = false;
    }
    
    const filters = {};
    
    // Get values from custom dropdowns
    document.querySelectorAll('.custom-dropdown').forEach(dropdown => {
        const filterType = dropdown.getAttribute('data-filter');
        const activeOption = dropdown.querySelector('.dropdown-option.active');
        if (activeOption) {
            filters[filterType] = activeOption.getAttribute('data-value');
        }
    });
    
    // Get exclude mixed checkbox value
    const excludeMixedCheckbox = document.getElementById('exclude-mixed');
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
} 