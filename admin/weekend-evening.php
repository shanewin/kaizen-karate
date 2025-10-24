<?php
define('KAIZEN_ADMIN', true);
session_start();
require_once 'config.php';

// Require login
require_login();

$message = '';

// Helper function to convert time to minutes for sorting
function convertTimeToMinutes($timeStr) {
    $timeStr = trim($timeStr);
    $period = (stripos($timeStr, 'pm') !== false) ? 'pm' : 'am';
    
    // Extract time part and split
    $timePart = preg_replace('/\s*(am|pm)/i', '', $timeStr);
    $parts = explode(':', $timePart);
    $hours = intval($parts[0]);
    $minutes = isset($parts[1]) ? intval($parts[1]) : 0;
    
    // Convert to 24-hour format
    if ($period === 'pm' && $hours !== 12) {
        $hours += 12;
    } elseif ($period === 'am' && $hours === 12) {
        $hours = 0;
    }
    
    return $hours * 60 + $minutes;
}

// Handle form submissions
if ($_POST) {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $message = error_message('Security token invalid. Please try again.');
    } else {
        // Handle class management actions
        if (isset($_POST['class_action'])) {
            $class_data = load_json_data('class-schedule', 'draft');
            $classes = $class_data['classes'] ?? [];
            
            switch ($_POST['class_action']) {
                case 'add_class':
                    // Create new class object
                    $new_class = [
                        'time' => sanitize_input($_POST['class_time']),
                        'day' => sanitize_input($_POST['class_day']),
                        'title' => sanitize_input($_POST['class_title']),
                        'type' => sanitize_input($_POST['class_type']),
                        'ageGroup' => sanitize_input($_POST['class_age_group']),
                        'beltLevel' => sanitize_input($_POST['class_belt_level']),
                        'location' => sanitize_input($_POST['class_location']),
                        'fullTitle' => sanitize_input($_POST['class_full_title'])
                    ];
                    
                    // Handle optional fields
                    if (!empty($_POST['class_age_groups'])) {
                        $new_class['ageGroups'] = array_map('sanitize_input', $_POST['class_age_groups']);
                    }
                    if (isset($_POST['class_short'])) {
                        $new_class['shortClass'] = true;
                    }
                    
                    $classes[] = $new_class;
                    $message = success_message('Class added to draft successfully!');
                    break;
                    
                case 'edit_class':
                    $index = intval($_POST['class_index']);
                    if (isset($classes[$index])) {
                        $classes[$index] = [
                            'time' => sanitize_input($_POST['class_time']),
                            'day' => sanitize_input($_POST['class_day']),
                            'title' => sanitize_input($_POST['class_title']),
                            'type' => sanitize_input($_POST['class_type']),
                            'ageGroup' => sanitize_input($_POST['class_age_group']),
                            'beltLevel' => sanitize_input($_POST['class_belt_level']),
                            'location' => sanitize_input($_POST['class_location']),
                            'fullTitle' => sanitize_input($_POST['class_full_title'])
                        ];
                        
                        // Handle optional fields
                        if (!empty($_POST['class_age_groups'])) {
                            $classes[$index]['ageGroups'] = array_map('sanitize_input', $_POST['class_age_groups']);
                        }
                        if (isset($_POST['class_short'])) {
                            $classes[$index]['shortClass'] = true;
                        }
                        
                        $message = success_message('Class updated in draft successfully!');
                    }
                    break;
                    
                case 'delete_class':
                    $index = intval($_POST['class_index']);
                    if (isset($classes[$index])) {
                        array_splice($classes, $index, 1);
                        $message = success_message('Class deleted from draft successfully!');
                    }
                    break;
            }
            
            // Sort classes by day then time before saving
            usort($classes, function($a, $b) {
                $dayOrder = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                $dayA = array_search($a['day'], $dayOrder);
                $dayB = array_search($b['day'], $dayOrder);
                
                // First sort by day
                if ($dayA !== $dayB) {
                    return $dayA - $dayB;
                }
                
                // Then sort by time within same day
                $timeA = convertTimeToMinutes($a['time']);
                $timeB = convertTimeToMinutes($b['time']);
                return $timeA - $timeB;
            });
            
            // Update metadata
            $class_data['classes'] = $classes;
            $class_data['metadata']['total_classes'] = count($classes);
            $class_data['metadata']['last_updated'] = date('Y-m-d');
            
            // Regenerate dynamic metadata
            $locations = array_unique(array_column($classes, 'location'));
            sort($locations);
            $class_data['metadata']['locations'] = $locations;
            
            $types = array_unique(array_column($classes, 'type'));
            sort($types);
            $class_data['metadata']['types'] = $types;
            
            $age_groups = [];
            foreach ($classes as $cls) {
                $age_groups[] = $cls['ageGroup'];
                if (isset($cls['ageGroups'])) {
                    $age_groups = array_merge($age_groups, $cls['ageGroups']);
                }
            }
            $age_groups = array_unique($age_groups);
            sort($age_groups);
            $class_data['metadata']['age_groups'] = $age_groups;
            
            $belt_levels = array_unique(array_column($classes, 'beltLevel'));
            sort($belt_levels);
            $class_data['metadata']['belt_levels'] = $belt_levels;
            
            // Save updated class data to draft
            if (save_json_data('class-schedule', $class_data, 'draft')) {
                // Message already set above
            } else {
                $message = error_message('Failed to save class changes.');
            }
        }
        
        $content = load_json_data('site-content', 'draft');
        
        // Update After School section
        if (isset($_POST['after_school_section'])) {
            // Handle file uploads first
            $schedule_pdf = sanitize_input($_POST['schedule_pdf']);
            $schedule_image = sanitize_input($_POST['schedule_image']);
            
            // Handle PDF upload
            if (isset($_FILES['schedule_pdf_upload']) && $_FILES['schedule_pdf_upload']['error'] === UPLOAD_ERR_OK) {
                $upload_result = handle_file_upload('schedule_pdf_upload', 'pdf', '../assets/images/aftersschool/');
                if ($upload_result['success']) {
                    $schedule_pdf = $upload_result['path'];
                    $message = success_message('Schedule PDF uploaded successfully!');
                } else {
                    $message = error_message('PDF upload failed: ' . $upload_result['error']);
                }
            }
            
            // Handle preview image upload
            if (isset($_FILES['schedule_image_upload']) && $_FILES['schedule_image_upload']['error'] === UPLOAD_ERR_OK) {
                $upload_result = handle_file_upload('schedule_image_upload', 'image', '../assets/images/aftersschool/');
                if ($upload_result['success']) {
                    $schedule_image = $upload_result['path'];
                    $message = success_message('Preview image uploaded successfully!');
                } else {
                    $message = error_message('Image upload failed: ' . $upload_result['error']);
                }
            }
            
            $content['after_school'] = [
                'title' => sanitize_input($_POST['after_school_title']),
                
                'calendar_section' => [
                    'header' => sanitize_input($_POST['calendar_header']),
                    'info_badges' => [
                        'duration' => sanitize_input($_POST['duration_badge']),
                        'location_type' => sanitize_input($_POST['location_badge'])
                    ]
                ],
                
                'schedule' => [
                    'title' => sanitize_input($_POST['schedule_title']),
                    'pdf_file' => $schedule_pdf,
                    'preview_image' => $schedule_image,
                    'download_text' => sanitize_input($_POST['download_text'])
                ],
                
                'registration' => [
                    'title' => sanitize_input($_POST['registration_title']),
                    'button_text' => sanitize_input($_POST['registration_button']),
                    'button_url' => sanitize_input($_POST['registration_url']),
                    'subtext' => sanitize_input($_POST['registration_subtext'])
                ],
                
                'disclaimer' => [
                    'text' => sanitize_input($_POST['disclaimer_text']),
                    'link_text' => sanitize_input($_POST['disclaimer_link_text']),
                    'link_url' => sanitize_input($_POST['disclaimer_link_url']),
                    'end_text' => sanitize_input($_POST['disclaimer_end_text'])
                ]
            ];
            
            if (save_json_data('site-content', $content, 'draft')) {
                $message = success_message('Weekend & Evening section saved to draft successfully!');
            } else {
                $message = error_message('Failed to save changes.');
            }
        }
    }
}

// Load current content from draft
$content = load_json_data('site-content', 'draft');
$after_school = $content['after_school'] ?? [];

// Load class schedule data from draft
$class_data = load_json_data('class-schedule', 'draft');
$classes = $class_data['classes'] ?? [];
$class_metadata = $class_data['metadata'] ?? [];

// Default values based on ACTUAL content from index.php
$defaults = [
    'title' => 'Weekend & Evening',
    'calendar_section' => [
        'header' => '2025 September / October Class Calendar',
        'info_badges' => [
            'duration' => 'One-hour classes unless stated otherwise',
            'location_type' => 'All Classes Held Indoors/In-Person'
        ]
    ],
    'schedule' => [
        'title' => 'September - October Schedule',
        'pdf_file' => 'assets/images/aftersschool/2025-Sep-Oct-Karate-Class-Calendar-v2.pdf',
        'preview_image' => 'assets/images/aftersschool/sep-oct-karate.png',
        'download_text' => 'Download Schedule'
    ],
    'registration' => [
        'title' => 'Ready to Enroll?',
        'button_text' => 'Register Now',
        'button_url' => 'https://www.gomotionapp.com/team/mdkfu/page/class-registration',
        'subtext' => 'Secure your spot in our programs'
    ],
    'disclaimer' => [
        'text' => 'Not all classes are listed. If you do not see your program listed then please',
        'link_text' => 'contact our office',
        'link_url' => '#contact',
        'end_text' => 'directly for more information.'
    ]
];

// Merge defaults with existing data
$after_school = array_merge($defaults, $after_school);

// Set page variables for template
$page_title = 'Weekend & Evening';
$page_icon = 'fas fa-calendar-week';
ob_start();
?>

<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
    <input type="hidden" name="after_school_section" value="1">

    <!-- Section 1: Basic Information -->
    <div class="content-section">
        <h2 class="section-title"><i class="fas fa-info-circle me-2"></i>Basic Information</h2>
        
        <div class="mb-3">
            <label for="after_school_title" class="form-label">Section Title</label>
            <input type="text" class="form-control" id="after_school_title" name="after_school_title" 
                   value="<?php echo htmlspecialchars($after_school['title']); ?>" required>
            <div class="form-text">Main title displayed at the top of the Weekend & Evening section</div>
        </div>
    </div>

    <!-- Section 2: Calendar Header -->
    <div class="content-section">
        <h2 class="section-title"><i class="fas fa-calendar-alt me-2"></i>Calendar Header</h2>
        
        <div class="mb-3">
            <label for="calendar_header" class="form-label">Calendar Header Text</label>
            <input type="text" class="form-control" id="calendar_header" name="calendar_header" 
                   value="<?php echo htmlspecialchars($after_school['calendar_section']['header']); ?>" required>
            <div class="form-text">Header text above the schedule filters (e.g., "2025 September / October Class Calendar")</div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="duration_badge" class="form-label">Duration Badge Text</label>
                    <input type="text" class="form-control" id="duration_badge" name="duration_badge" 
                           value="<?php echo htmlspecialchars($after_school['calendar_section']['info_badges']['duration']); ?>" required>
                    <div class="form-text">Badge with clock icon showing class duration info</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="location_badge" class="form-label">Location Type Badge Text</label>
                    <input type="text" class="form-control" id="location_badge" name="location_badge" 
                           value="<?php echo htmlspecialchars($after_school['calendar_section']['info_badges']['location_type']); ?>" required>
                    <div class="form-text">Badge with home icon showing location type info</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 3: Schedule Management -->
    <div class="content-section">
        <h2 class="section-title"><i class="fas fa-file-pdf me-2"></i>Schedule Management</h2>
        
        <div class="mb-3">
            <label for="schedule_title" class="form-label">Schedule Section Title</label>
            <input type="text" class="form-control" id="schedule_title" name="schedule_title" 
                   value="<?php echo htmlspecialchars($after_school['schedule']['title']); ?>" required>
            <div class="form-text">Title above the schedule image and download button</div>
        </div>
        
        <div class="row">
            <!-- PDF Upload -->
            <div class="col-md-6">
                <div class="file-upload-group">
                    <label for="schedule_pdf_upload" class="form-label">
                        <i class="fas fa-file-pdf text-danger"></i> Schedule PDF File
                    </label>
                    <input type="file" class="form-control" id="schedule_pdf_upload" name="schedule_pdf_upload" accept=".pdf">
                    <input type="text" class="form-control mt-2" name="schedule_pdf" 
                           value="<?php echo htmlspecialchars($after_school['schedule']['pdf_file']); ?>" 
                           placeholder="assets/images/aftersschool/schedule.pdf">
                    <div class="current-file">
                        <strong>Current:</strong> <?php echo htmlspecialchars($after_school['schedule']['pdf_file'] ?: 'No file uploaded'); ?>
                    </div>
                    <div class="form-text">PDF file that users can download when clicking the download button</div>
                </div>
            </div>
            
            <!-- Image Upload -->
            <div class="col-md-6">
                <div class="file-upload-group">
                    <label for="schedule_image_upload" class="form-label">
                        <i class="fas fa-image text-success"></i> Preview Image
                    </label>
                    <input type="file" class="form-control" id="schedule_image_upload" name="schedule_image_upload" accept="image/*">
                    <input type="text" class="form-control mt-2" name="schedule_image" 
                           value="<?php echo htmlspecialchars($after_school['schedule']['preview_image']); ?>" 
                           placeholder="assets/images/aftersschool/preview.png">
                    <div class="current-file">
                        <strong>Current:</strong> <?php echo htmlspecialchars($after_school['schedule']['preview_image'] ?: 'No image uploaded'); ?>
                    </div>
                    <div class="form-text">Image preview of the schedule displayed on the page</div>
                </div>
            </div>
        </div>
        
        <div class="mb-3">
            <label for="download_text" class="form-label">Download Button Text</label>
            <input type="text" class="form-control" id="download_text" name="download_text" 
                   value="<?php echo htmlspecialchars($after_school['schedule']['download_text']); ?>" required>
            <div class="form-text">Text displayed on the download button (with download icon)</div>
        </div>
    </div>

    <!-- Section 4: Registration & Disclaimer -->
    <div class="content-section">
        <h2 class="section-title"><i class="fas fa-user-plus me-2"></i>Registration & Disclaimer</h2>
        
        <h5 class="text-secondary mb-3">Registration Section</h5>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="registration_title" class="form-label">Registration Title</label>
                    <input type="text" class="form-control" id="registration_title" name="registration_title" 
                           value="<?php echo htmlspecialchars($after_school['registration']['title']); ?>" required>
                    <div class="form-text">Large white title above the registration button</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="registration_button" class="form-label">Button Text</label>
                    <input type="text" class="form-control" id="registration_button" name="registration_button" 
                           value="<?php echo htmlspecialchars($after_school['registration']['button_text']); ?>" required>
                    <div class="form-text">Text on the red registration button (with user-plus icon)</div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-8">
                <div class="mb-3">
                    <label for="registration_url" class="form-label">Registration URL</label>
                    <input type="url" class="form-control" id="registration_url" name="registration_url" 
                           value="<?php echo htmlspecialchars($after_school['registration']['button_url']); ?>" required>
                    <div class="form-text">URL where the registration button links to</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="registration_subtext" class="form-label">Subtext</label>
                    <input type="text" class="form-control" id="registration_subtext" name="registration_subtext" 
                           value="<?php echo htmlspecialchars($after_school['registration']['subtext']); ?>">
                    <div class="form-text">Small text below the registration button</div>
                </div>
            </div>
        </div>
        
        <hr class="my-4">
        
        <h5 class="text-secondary mb-3">Disclaimer Section</h5>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="disclaimer_text" class="form-label">Main Disclaimer Text</label>
                    <textarea class="form-control" id="disclaimer_text" name="disclaimer_text" 
                              rows="2" required><?php echo htmlspecialchars($after_school['disclaimer']['text']); ?></textarea>
                    <div class="form-text">Text before the contact link</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="disclaimer_end_text" class="form-label">End Text</label>
                    <textarea class="form-control" id="disclaimer_end_text" name="disclaimer_end_text" 
                              rows="2"><?php echo htmlspecialchars($after_school['disclaimer']['end_text']); ?></textarea>
                    <div class="form-text">Text after the contact link</div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="disclaimer_link_text" class="form-label">Link Text</label>
                    <input type="text" class="form-control" id="disclaimer_link_text" name="disclaimer_link_text" 
                           value="<?php echo htmlspecialchars($after_school['disclaimer']['link_text']); ?>" required>
                    <div class="form-text">Clickable link text (styled in red)</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="disclaimer_link_url" class="form-label">Link URL</label>
                    <input type="text" class="form-control" id="disclaimer_link_url" name="disclaimer_link_url" 
                           value="<?php echo htmlspecialchars($after_school['disclaimer']['link_url']); ?>" required>
                    <div class="form-text">URL where the disclaimer link points to</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Submit Button -->
    <div class="text-center mb-5">
        <button type="submit" class="btn btn-kaizen btn-lg">
            <i class="fas fa-save me-2"></i>Save Weekend & Evening Settings
        </button>
    </div>
</form>

<!-- Section 5: Class Management -->
<div class="content-section">
    <h2 class="section-title"><i class="fas fa-calendar-check me-2"></i>Class Schedule Management</h2>
    
    <!-- Action Buttons and Search Bar -->
    <div class="row mb-4">
        <div class="col-md-6">
            <button type="button" class="btn btn-success" onclick="showAddClassForm()">
                <i class="fas fa-plus me-2"></i>Add New Class
            </button>
            <span class="text-muted ms-3">Total Classes: <?php echo count($classes); ?></span>
        </div>
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control" id="classSearch" placeholder="Search classes..." onkeyup="filterClasses()">
            </div>
        </div>
    </div>
    
    <!-- Class List Table -->
    <div class="table-responsive">
        <table class="table table-hover" id="classTable">
            <thead>
                <tr>
                    <th onclick="sortTable(0)" style="cursor: pointer;">Day <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(1)" style="cursor: pointer;">Time <i class="fas fa-sort"></i></th>
                    <th>Full Title</th>
                    <th>Type</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($classes as $index => $class): ?>
                <tr>
                    <td><?php echo htmlspecialchars($class['day']); ?></td>
                    <td><?php echo htmlspecialchars($class['time']); ?></td>
                    <td><?php echo htmlspecialchars($class['fullTitle']); ?></td>
                    <td>
                        <span class="badge bg-<?php echo $class['type'] === 'youth' ? 'primary' : ($class['type'] === 'adult' ? 'warning' : 'info'); ?>">
                            <?php echo ucfirst($class['type']); ?>
                        </span>
                    </td>
                    <td><?php echo htmlspecialchars($class['location']); ?></td>
                    <td>
                        <button type="button" class="btn btn-sm btn-primary" onclick="editClass(<?php echo $index; ?>)" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteClass(<?php echo $index; ?>)" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add/Edit Class Modal Form -->
<div id="classFormModal" class="modal" style="display: none;">
    <div class="modal-content">
        <form method="POST" id="classForm">
            <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
            <input type="hidden" name="class_action" id="class_action" value="add_class">
            <input type="hidden" name="class_index" id="class_index" value="">
            
            <div class="modal-header">
                <h3 id="modalTitle">Add New Class</h3>
                <span class="close" onclick="closeClassForm()">&times;</span>
            </div>
            
            <div class="modal-body">
                <!-- Basic Information -->
                <div class="form-section">
                    <h5 class="text-secondary mb-3">Basic Information</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="class_day" class="form-label">Day <span class="text-danger">*</span></label>
                                <select class="form-control" id="class_day" name="class_day" required>
                                    <option value="">Select Day</option>
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                    <option value="Saturday">Saturday</option>
                                    <option value="Sunday">Sunday</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="class_time" class="form-label">Time <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="class_time" name="class_time" 
                                       placeholder="e.g., 6:00 pm" required pattern="^\d{1,2}:\d{2}\s?(am|pm)$">
                                <div class="form-text">Format: HH:MM am/pm</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="class_title" class="form-label">Short Title</label>
                                <input type="text" class="form-control" id="class_title" name="class_title" 
                                       placeholder="e.g., All Belts, Beginner #1, Master Form / Jujitsu">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="class_full_title" class="form-label">Full Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="class_full_title" name="class_full_title" 
                                       placeholder="e.g., Y-Calvary All Belts" required>
                                <div class="form-text">Complete title as displayed in schedule (auto-generates preview)</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Class Details -->
                <div class="form-section">
                    <h5 class="text-secondary mb-3">Class Details</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Type <span class="text-danger">*</span></label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="class_type" id="type_youth" value="youth" required>
                                        <label class="form-check-label" for="type_youth">Youth</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="class_type" id="type_adult" value="adult" required>
                                        <label class="form-check-label" for="type_adult">Adult</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="class_type" id="type_mixed" value="mixed" required>
                                        <label class="form-check-label" for="type_mixed">Mixed</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="class_location" class="form-label">Location <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="class_location" name="class_location" 
                                       placeholder="e.g., Silver Spring MD" required list="location_list">
                                <datalist id="location_list">
                                    <?php foreach ($class_metadata['locations'] ?? [] as $location): ?>
                                    <option value="<?php echo htmlspecialchars($location); ?>">
                                    <?php endforeach; ?>
                                </datalist>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Age & Belt Information -->
                <div class="form-section">
                    <h5 class="text-secondary mb-3">Age & Belt Information</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="class_age_group" class="form-label">Primary Age Group <span class="text-danger">*</span></label>
                                <select class="form-control" id="class_age_group" name="class_age_group" required>
                                    <option value="">Select Age Group</option>
                                    <option value="all">All</option>
                                    <option value="little-ninja">Little Ninja (3-5)</option>
                                    <option value="beginner">Beginner (6-9)</option>
                                    <option value="intermediate">Intermediate (10-12)</option>
                                    <option value="advanced">Advanced (13+)</option>
                                    <option value="adult">Adult</option>
                                </select>
                            </div>
                            
                            <!-- Multiple Age Groups (always visible, optional) -->
                            <div class="mb-3">
                                <label class="form-label">Multiple Age Groups (Optional)</label>
                                <div class="age-groups-checkboxes">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="class_age_groups[]" value="little-ninja" id="age_little_ninja">
                                        <label class="form-check-label" for="age_little_ninja">Little Ninja</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="class_age_groups[]" value="beginner" id="age_beginner">
                                        <label class="form-check-label" for="age_beginner">Beginner</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="class_age_groups[]" value="intermediate" id="age_intermediate">
                                        <label class="form-check-label" for="age_intermediate">Intermediate</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="class_age_groups[]" value="advanced" id="age_advanced">
                                        <label class="form-check-label" for="age_advanced">Advanced</label>
                                    </div>
                                </div>
                                <div class="form-text">Check if class serves multiple age groups</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="class_belt_level" class="form-label">Belt Level <span class="text-danger">*</span></label>
                                <select class="form-control" id="class_belt_level" name="class_belt_level" required>
                                    <option value="">Select Belt Level</option>
                                    <option value="all">All Belts</option>
                                    <option value="white-yellow">White-Yellow</option>
                                    <option value="green-blue">Green-Blue</option>
                                    <option value="brown-red">Brown-Red</option>
                                    <option value="green-plus">Green+ (Master Form)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Additional Options -->
                <div class="form-section">
                    <h5 class="text-secondary mb-3">Additional Options</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="class_short" id="class_short">
                        <label class="form-check-label" for="class_short">
                            Short Class (30 minutes)
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeClassForm()">Cancel</button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Save Class
                </button>
            </div>
        </form>
    </div>
</div>

<?php
$page_content = ob_get_clean();

$additional_styles = '
        .content-section {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            border: 1px solid #e9ecef;
        }
        
        .section-title {
            color: var(--kaizen-primary);
            margin-bottom: 1.5rem;
            font-weight: 600;
        }
        
        .btn-kaizen {
            background: linear-gradient(45deg, var(--kaizen-primary), var(--kaizen-secondary));
            border: none;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-kaizen:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(164, 51, 43, 0.3);
            color: white;
        }
        
        .form-control:focus {
            border-color: var(--kaizen-primary);
            box-shadow: 0 0 0 0.2rem rgba(164, 51, 43, 0.25);
        }
        
        .file-upload-group {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            background: #fff;
        }
        
        .file-upload-group:hover {
            border-color: var(--kaizen-primary);
        }
        
        .current-file {
            background: #e9ecef;
            padding: 0.5rem;
            border-radius: 4px;
            font-size: 0.9em;
            margin-top: 0.5rem;
        }
        
        /* Class Management Styles */
        .table th {
            background-color: var(--kaizen-primary);
            color: white;
            border: none;
        }
        
        .table th:hover {
            background-color: var(--kaizen-secondary);
        }
        
        .badge {
            font-size: 0.85em;
        }
        
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 1000;
        }
        
        .modal-content {
            background: white;
            margin: 2% auto;
            width: 90%;
            max-width: 800px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .modal-header {
            padding: 1.5rem 2rem 1rem;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .modal-body {
            padding: 1.5rem 2rem;
        }
        
        .modal-footer {
            padding: 1rem 2rem 1.5rem;
            border-top: 1px solid #e9ecef;
            text-align: right;
        }
        
        .close {
            font-size: 1.5rem;
            cursor: pointer;
            color: #aaa;
        }
        
        .close:hover {
            color: var(--kaizen-primary);
        }
        
        .form-section {
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #e9ecef;
        }
        
        .form-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        
        .age-groups-checkboxes {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .age-groups-checkboxes .form-check {
            margin-bottom: 0;
        }
';

include 'includes/admin-template.php';
?>
<script>
// Class management JavaScript functionality

// Class data for JavaScript use
const classData = <?php echo json_encode($classes); ?>;

// Sort table functionality
let sortDirection = {};
function sortTable(columnIndex) {
    const table = document.getElementById('classTable');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    // Toggle sort direction
    const column = ['day', 'time', 'title', 'type', 'location'][columnIndex];
    sortDirection[column] = !sortDirection[column];
    const ascending = sortDirection[column];
    
    rows.sort((a, b) => {
        let aVal = a.cells[columnIndex].textContent.trim();
        let bVal = b.cells[columnIndex].textContent.trim();
        
        // Special handling for day sorting - always include time as secondary sort
        if (columnIndex === 0) {
            const dayOrder = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            const aDayIndex = dayOrder.indexOf(aVal);
            const bDayIndex = dayOrder.indexOf(bVal);
            
            // If different days, sort by day
            if (aDayIndex !== bDayIndex) {
                if (ascending) {
                    return aDayIndex - bDayIndex;
                } else {
                    return bDayIndex - aDayIndex;
                }
            }
            
            // Same day - sort by time as secondary sort (always earliest first)
            const aTime = convertTimeToMinutes(a.cells[1].textContent.trim());
            const bTime = convertTimeToMinutes(b.cells[1].textContent.trim());
            return aTime - bTime;
        }
        
        // Special handling for time sorting
        if (columnIndex === 1) {
            aVal = convertTimeToMinutes(aVal);
            bVal = convertTimeToMinutes(bVal);
        }
        
        if (ascending) {
            return aVal > bVal ? 1 : -1;
        } else {
            return aVal < bVal ? 1 : -1;
        }
    });
    
    // Re-append sorted rows
    rows.forEach(row => tbody.appendChild(row));
    
    // Update sort indicators
    document.querySelectorAll('#classTable th i').forEach(icon => {
        icon.className = 'fas fa-sort';
    });
    const currentHeader = document.querySelectorAll('#classTable th')[columnIndex];
    const icon = currentHeader.querySelector('i');
    icon.className = ascending ? 'fas fa-sort-up' : 'fas fa-sort-down';
}

// Convert time string to minutes for sorting
function convertTimeToMinutes(timeStr) {
    const [time, period] = timeStr.split(' ');
    let [hours, minutes] = time.split(':').map(Number);
    
    if (period === 'pm' && hours !== 12) hours += 12;
    if (period === 'am' && hours === 12) hours = 0;
    
    return hours * 60 + minutes;
}

// Filter classes functionality
function filterClasses() {
    const searchTerm = document.getElementById('classSearch').value.toLowerCase();
    const table = document.getElementById('classTable');
    const rows = table.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
}

// Show add class form
function showAddClassForm() {
    document.getElementById('modalTitle').textContent = 'Add New Class';
    document.getElementById('class_action').value = 'add_class';
    document.getElementById('class_index').value = '';
    
    // Clear form
    document.getElementById('classForm').reset();
    
    // Show modal
    document.getElementById('classFormModal').style.display = 'block';
}

// Edit class
function editClass(index) {
    const classObj = classData[index];
    
    document.getElementById('modalTitle').textContent = 'Edit Class';
    document.getElementById('class_action').value = 'edit_class';
    document.getElementById('class_index').value = index;
    
    // Populate form
    document.getElementById('class_day').value = classObj.day;
    document.getElementById('class_time').value = classObj.time;
    document.getElementById('class_title').value = classObj.title || '';
    
    // Set radio button
    document.querySelector(`input[name="class_type"][value="${classObj.type}"]`).checked = true;
    
    document.getElementById('class_location').value = classObj.location;
    document.getElementById('class_age_group').value = classObj.ageGroup;
    document.getElementById('class_belt_level').value = classObj.beltLevel;
    document.getElementById('class_full_title').value = classObj.fullTitle;
    
    // Handle multiple age groups
    document.querySelectorAll('input[name="class_age_groups[]"]').forEach(checkbox => {
        checkbox.checked = classObj.ageGroups && classObj.ageGroups.includes(checkbox.value);
    });
    
    // Handle short class checkbox
    document.getElementById('class_short').checked = classObj.shortClass || false;
    
    // Show modal
    document.getElementById('classFormModal').style.display = 'block';
}

// Delete class with confirmation
function deleteClass(index) {
    const classObj = classData[index];
    const confirmMsg = `Are you sure you want to delete this class?\n\n${classObj.day} ${classObj.time}\n${classObj.fullTitle}\nLocation: ${classObj.location}`;
    
    if (confirm(confirmMsg)) {
        // Create hidden form and submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.innerHTML = `
            <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
            <input type="hidden" name="class_action" value="delete_class">
            <input type="hidden" name="class_index" value="${index}">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}

// Close class form modal
function closeClassForm() {
    document.getElementById('classFormModal').style.display = 'none';
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('classFormModal');
    if (event.target === modal) {
        closeClassForm();
    }
}

// Auto-format time input
document.getElementById('class_time').addEventListener('blur', function() {
    let value = this.value.trim();
    if (value) {
        // Basic time formatting
        value = value.replace(/[^\d:apm\s]/gi, '');
        
        // Add colon if missing (e.g., "630pm" -> "6:30pm")
        if (!/\d+:\d+/.test(value)) {
            const match = value.match(/(\d+)([ap]m?)/i);
            if (match) {
                value = match[1] + ':00 ' + match[2];
            }
        }
        
        // Add space before am/pm if missing
        value = value.replace(/(\d)([ap]m)/i, '$1 $2');
        
        // Ensure lowercase am/pm
        value = value.replace(/AM/g, 'am').replace(/PM/g, 'pm');
        
        this.value = value;
    }
});

// Auto-generate full title preview
function updateFullTitlePreview() {
    const day = document.getElementById('class_day').value;
    const time = document.getElementById('class_time').value;
    const title = document.getElementById('class_title').value;
    const type = document.querySelector('input[name="class_type"]:checked')?.value;
    const location = document.getElementById('class_location').value;
    
    if (day && time && type && location) {
        const typePrefix = type === 'youth' ? 'Y' : (type === 'adult' ? 'A' : 'Y/A');
        const locationShort = location.split(' ')[0]; // First word of location
        const titlePart = title ? ` ${title}` : '';
        
        const preview = `${typePrefix}-${locationShort}${titlePart}`;
        document.getElementById('class_full_title').placeholder = `Suggested: ${preview}`;
    }
}

// Add event listeners for auto-generation
['class_day', 'class_time', 'class_title', 'class_location'].forEach(id => {
    document.getElementById(id).addEventListener('input', updateFullTitlePreview);
});

document.querySelectorAll('input[name="class_type"]').forEach(radio => {
    radio.addEventListener('change', updateFullTitlePreview);
});

// Form validation
document.getElementById('classForm').addEventListener('submit', function(e) {
    const timeInput = document.getElementById('class_time');
    const timePattern = /^\d{1,2}:\d{2}\s?(am|pm)$/i;
    
    if (!timePattern.test(timeInput.value)) {
        e.preventDefault();
        alert('Please enter time in format "HH:MM am/pm" (e.g., "6:00 pm")');
        timeInput.focus();
        return false;
    }
});
</script>
<script>
document.getElementById('page-content').innerHTML = <?php echo json_encode($page_content); ?>;
</script>