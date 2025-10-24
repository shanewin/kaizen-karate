<?php
define('KAIZEN_ADMIN', true);
session_start();
require_once 'config.php';

// Require login
require_login();

$message = '';

// Handle form submissions
if ($_POST) {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $message = error_message('Security token invalid. Please try again.');
    } else {
        $content = load_json_data('site-content');
        
        // Update Summer Camp section
        if (isset($_POST['summer_camp_section'])) {
            $summer_camp = $content['summer_camp'] ?? [];
            
            // Update Basic Information
            $summer_camp['basic_info'] = [
                'title' => sanitize_input($_POST['basic_title']),
                'subtitle' => sanitize_input($_POST['basic_subtitle']),
                'is_active' => isset($_POST['basic_is_active'])
            ];
            
            // Update Special Offer
            $summer_camp['special_offer'] = [
                'enabled' => isset($_POST['offer_enabled']),
                'badge_text' => sanitize_input($_POST['offer_badge_text']),
                'deadline_label' => sanitize_input($_POST['offer_deadline_label']),
                'deadline_date' => sanitize_input($_POST['offer_deadline_date']),
                'free_badge_text' => sanitize_input($_POST['offer_free_badge_text']),
                'free_care_heading' => sanitize_input($_POST['offer_free_care_heading']),
                'free_care_description' => sanitize_input($_POST['offer_free_care_description'])
            ];
            
            // Handle video uploads
            $video_data = $summer_camp['video'] ?? [];
            
            // Handle summer camp video upload
            $video_source_path = sanitize_input($_POST['video_source']);
            if (isset($_FILES['summer_camp_video_upload']) && $_FILES['summer_camp_video_upload']['error'] === UPLOAD_ERR_OK) {
                $upload_result = handle_file_upload('summer_camp_video_upload', 'video', '../assets/videos/summer-camp/');
                if ($upload_result['success']) {
                    $video_source_path = $upload_result['path'];
                    $message = success_message('Summer camp video uploaded successfully!');
                } else {
                    $message = error_message('Video upload failed: ' . $upload_result['error']);
                }
            }
            
            // Handle video thumbnail upload
            if (isset($_FILES['video_thumbnail']) && $_FILES['video_thumbnail']['error'] === UPLOAD_ERR_OK) {
                $upload_result = handle_file_upload('video_thumbnail', 'image', '../assets/images/summer-camp/');
                if ($upload_result['success']) {
                    $video_data['thumbnail'] = $upload_result['path'];
                    $message = success_message('Video thumbnail uploaded successfully!');
                } else {
                    $message = error_message('Thumbnail upload failed: ' . $upload_result['error']);
                }
            }
            
            // Update Video Settings
            $summer_camp['video'] = [
                'source' => $video_source_path,
                'thumbnail' => $video_data['thumbnail'] ?? $summer_camp['video']['thumbnail'] ?? '',
                'thumbnail_alt' => sanitize_input($_POST['video_thumbnail_alt']),
                'overlay_title' => sanitize_input($_POST['video_overlay_title']),
                'overlay_description' => sanitize_input($_POST['video_overlay_description']),
                'onclick' => sanitize_input($_POST['video_onclick'])
            ];
            
            $content['summer_camp'] = $summer_camp;
            
            if (save_json_data('site-content', $content)) {
                $message = success_message('Summer Camp section updated successfully!');
            } else {
                $message = error_message('Failed to save changes.');
            }
        }
    }
    
    // Handle Features Grid Update
    if (isset($_POST['update_features']) && verify_csrf_token($_POST['csrf_token'])) {
        $content = load_json_data('site-content');
        
        // Process features data
        $features = [];
        if (isset($_POST['feature_icon']) && is_array($_POST['feature_icon'])) {
            for ($i = 0; $i < count($_POST['feature_icon']); $i++) {
                if (!empty($_POST['feature_icon'][$i]) && !empty($_POST['feature_text'][$i])) {
                    $features[] = [
                        'icon' => sanitize_input($_POST['feature_icon'][$i]),
                        'text' => sanitize_input($_POST['feature_text'][$i]),
                        'onclick' => sanitize_input($_POST['feature_onclick'][$i] ?? '')
                    ];
                }
            }
        }
        
        $content['summer_camp']['features'] = $features;
        
        if (save_json_data('site-content', $content)) {
            $message = success_message('Features grid updated successfully!');
        } else {
            $message = error_message('Failed to save features grid.');
        }
    }
    
    // Handle Camp Locations Update
    if (isset($_POST['update_locations']) && verify_csrf_token($_POST['csrf_token'])) {
        $content = load_json_data('site-content');
        
        // Process locations data
        $locations = [];
        if (isset($_POST['location_title']) && is_array($_POST['location_title'])) {
            for ($i = 0; $i < count($_POST['location_title']); $i++) {
                if (!empty($_POST['location_title'][$i])) {
                    $locations[] = [
                        'title' => sanitize_input($_POST['location_title'][$i]),
                        'venue' => sanitize_input($_POST['location_venue'][$i] ?? ''),
                        'address' => sanitize_input($_POST['location_address'][$i] ?? ''),
                        'duration' => sanitize_input($_POST['location_duration'][$i] ?? ''),
                        'weeks' => sanitize_input($_POST['location_weeks'][$i] ?? ''),
                        'new_families_url' => sanitize_input($_POST['location_new_families_url'][$i] ?? ''),
                        'returning_families_url' => sanitize_input($_POST['location_returning_families_url'][$i] ?? '')
                    ];
                }
            }
        }
        
        $content['summer_camp']['camp_locations'] = $locations;
        
        if (save_json_data('site-content', $content)) {
            $message = success_message('Camp locations updated successfully!');
        } else {
            $message = error_message('Failed to save camp locations.');
        }
    }
}

// Load current content
$content = load_json_data('site-content');
$summer_camp = $content['summer_camp'] ?? [];

// Define summer_camp_data with proper defaults for the forms
$summer_camp_data = $summer_camp;

// Default features from index.php
$default_features = [
    [
        'icon' => 'fas fa-fist-raised',
        'text' => 'Karate Instruction',
        'onclick' => 'scrollToDailyScheduleInfo()'
    ],
    [
        'icon' => 'fas fa-bus',
        'text' => 'Field Trips',
        'onclick' => 'scrollToFieldTripsInfo()'
    ],
    [
        'icon' => 'fas fa-swimming-pool',
        'text' => 'Pool Time',
        'onclick' => 'scrollToSwimmingInfo()'
    ],
    [
        'icon' => 'fas fa-medal',
        'text' => 'Belt Exams',
        'onclick' => 'scrollToFieldTripsInfo()'
    ]
];

// Default camp locations from index.php
$default_camp_locations = [
    [
        'title' => 'Maryland',
        'venue' => 'Calvary Lutheran Church',
        'address' => '9545 Georgia Ave.<br>Silver Spring, MD 20910',
        'duration' => 'June 11 - August 22',
        'weeks' => '10 weeks',
        'new_families_url' => 'https://kaizenkarate.campmanagement.com/p/request_for_info_m.php?action=enroll',
        'returning_families_url' => 'https://kaizenkarate.campmanagement.com/p/campers/login_m.php'
    ],
    [
        'title' => 'Northwest DC',
        'venue' => 'Washington Hebrew Congregation',
        'address' => '3935 Macomb St NW<br>Washington, DC 20016',
        'duration' => 'June 23 - August 15',
        'weeks' => '8 weeks',
        'new_families_url' => 'https://kaizenkarate.campmanagement.com/p/request_for_info_m.php?action=enroll',
        'returning_families_url' => 'https://kaizenkarate.campmanagement.com/p/campers/login_m.php'
    ],
    [
        'title' => 'Capitol Hill DC',
        'venue' => 'Christ Church + Washington Parish',
        'address' => '620 G St. SE<br>Washington, DC 20003',
        'duration' => 'July 21 - August 22',
        'weeks' => '5 weeks',
        'new_families_url' => 'https://kaizenkarate.campmanagement.com/p/request_for_info_m.php?action=enroll',
        'returning_families_url' => 'https://kaizenkarate.campmanagement.com/p/campers/login_m.php'
    ],
    [
        'title' => 'Virginia',
        'venue' => 'Arlington Community Church',
        'address' => '6040 Wilson Blvd.<br>Arlington, VA 22205',
        'duration' => 'July 7 - August 1',
        'weeks' => '4 weeks',
        'new_families_url' => 'https://kaizenkarate.campmanagement.com/p/request_for_info_m.php?action=enroll',
        'returning_families_url' => 'https://kaizenkarate.campmanagement.com/p/campers/login_m.php'
    ]
];

$summer_camp_data['features'] = $summer_camp_data['features'] ?? $default_features;
$summer_camp_data['camp_locations'] = $summer_camp_data['camp_locations'] ?? $default_camp_locations;

// Default values for Step 1 sections
$default_data = [
    'basic_info' => [
        'title' => 'Summer Camp 2025',
        'subtitle' => '4 campsites for campers ages 5-12',
        'is_active' => true
    ],
    'special_offer' => [
        'enabled' => true,
        'badge_text' => 'SPECIAL OFFER - SAVE $150 PER WEEK',
        'deadline_label' => 'Early Registration Deadline',
        'deadline_date' => 'March 31st, 2025',
        'free_badge_text' => '100% FREE',
        'free_care_heading' => 'FREE BEFORE & AFTER CARE',
        'free_care_description' => 'For ALL weeks when you register before March 31st, 2025'
    ],
    'video' => [
        'source' => '',
        'thumbnail' => 'assets/images/summer-camp/video-thumb.png',
        'thumbnail_alt' => 'Summer Camp Video Preview',
        'overlay_title' => 'Watch Our Summer Camp Experience',
        'overlay_description' => 'See what makes Kaizen Summer Camp special',
        'onclick' => 'openSummerCampVideo()'
    ]
];

// Merge with defaults
$summer_camp = array_merge($default_data, $summer_camp);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summer Camp Management - Kaizen Karate Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --kaizen-primary: #a4332b;
            --kaizen-secondary: #721c24;
            --sidebar-bg: #2c3e50;
            --sidebar-hover: #34495e;
        }
        
        body { background-color: #f8f9fa; }
        .sidebar { background: var(--sidebar-bg); min-height: 100vh; }
        .sidebar .nav-link { color: #ecf0f1; padding: 1rem 1.5rem; margin: 0.25rem 0; border-radius: 8px; transition: all 0.3s ease; }
        .sidebar .nav-link:hover { background: var(--sidebar-hover); color: white; transform: translateX(5px); }
        .sidebar .nav-link.active { background: var(--kaizen-primary); color: white; }
        .brand-header { background: linear-gradient(45deg, var(--kaizen-primary), var(--kaizen-secondary)); color: white; padding: 1.5rem; text-align: center; }
        .content-section { border: 1px solid #e9ecef; border-radius: 10px; padding: 1.5rem; margin-bottom: 2rem; background: white; }
        .section-title { color: var(--kaizen-primary); border-bottom: 2px solid var(--kaizen-primary); padding-bottom: 0.5rem; margin-bottom: 1rem; }
        .btn-kaizen { background: linear-gradient(45deg, var(--kaizen-primary), var(--kaizen-secondary)); border: none; color: white; padding: 0.75rem 2rem; border-radius: 8px; font-weight: 600; }
        .btn-kaizen:hover { color: white; transform: translateY(-2px); box-shadow: 0 8px 25px rgba(164, 51, 43, 0.3); }
        .form-control:focus { border-color: var(--kaizen-primary); box-shadow: 0 0 0 0.2rem rgba(164, 51, 43, 0.25); }
        .alert-kaizen { background: linear-gradient(45deg, rgba(164, 51, 43, 0.1), rgba(164, 51, 43, 0.05)); border: 1px solid rgba(164, 51, 43, 0.2); color: var(--kaizen-primary); }
        .video-preview { min-height: 200px; display: flex; align-items: center; justify-content: center; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <?php include 'includes/navigation.php'; ?>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1><i class="fas fa-sun me-2 text-primary"></i>Summer Camp Management</h1>
                </div>
                
                <?php echo $message; ?>

<!-- Summer Camp Management -->
<div class="content-section">
    <h3 class="section-title"><i class="fas fa-sun me-2"></i>Summer Camp Management - Step 1</h3>
    <div class="alert alert-kaizen border-0 mb-4">
        <i class="fas fa-info-circle me-2"></i>
        <strong>Summer Camp:</strong> Manage the summer camp section content. This is Step 1 of 3 - covering basic information, special offers, and video settings.
    </div>
    
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="summer_camp_section" value="1">
        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
        
        <!-- Section 1: Basic Information -->
        <div class="mb-4 p-3 border rounded bg-light">
            <h5 class="text-primary mb-3"><i class="fas fa-info-circle me-2"></i>Basic Information</h5>
            
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="basic_title" class="form-label"><strong>Section Title</strong></label>
                        <input type="text" class="form-control" id="basic_title" name="basic_title" 
                               value="<?php echo htmlspecialchars($summer_camp['basic_info']['title']); ?>"
                               placeholder="e.g., Summer Camp 2025">
                        <div class="form-text">
                            <i class="fas fa-lightbulb text-warning me-1"></i>Main title for the summer camp section
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="basic_subtitle" class="form-label"><strong>Subtitle</strong></label>
                        <input type="text" class="form-control" id="basic_subtitle" name="basic_subtitle" 
                               value="<?php echo htmlspecialchars($summer_camp['basic_info']['subtitle']); ?>"
                               placeholder="e.g., 4 campsites for campers ages 5-12">
                        <div class="form-text">
                            <i class="fas fa-lightbulb text-warning me-1"></i>Subtitle describing the camp basics
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label"><strong>Section Status</strong></label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="basic_is_active" name="basic_is_active" 
                                   <?php echo ($summer_camp['basic_info']['is_active'] ?? true) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="basic_is_active">
                                Section Active
                            </label>
                        </div>
                        <div class="form-text">Enable/disable the entire summer camp section</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Section 2: Special Offer Configuration -->
        <div class="mb-4 p-3 border rounded bg-light">
            <h5 class="text-primary mb-3"><i class="fas fa-tags me-2"></i>Special Offer Configuration</h5>
            
            <div class="mb-3">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="offer_enabled" name="offer_enabled" 
                           <?php echo ($summer_camp['special_offer']['enabled'] ?? true) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="offer_enabled">
                        <strong>Enable Special Offer Section</strong>
                    </label>
                </div>
                <div class="form-text">Show/hide the special offer promotion box</div>
            </div>
            
            <div id="offer-fields">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="offer_badge_text" class="form-label"><strong>Offer Badge Text</strong></label>
                            <input type="text" class="form-control" id="offer_badge_text" name="offer_badge_text" 
                                   value="<?php echo htmlspecialchars($summer_camp['special_offer']['badge_text']); ?>"
                                   placeholder="e.g., SPECIAL OFFER - SAVE $150 PER WEEK">
                        </div>
                        
                        <div class="mb-3">
                            <label for="offer_deadline_label" class="form-label"><strong>Deadline Label</strong></label>
                            <input type="text" class="form-control" id="offer_deadline_label" name="offer_deadline_label" 
                                   value="<?php echo htmlspecialchars($summer_camp['special_offer']['deadline_label']); ?>"
                                   placeholder="e.g., Early Registration Deadline">
                        </div>
                        
                        <div class="mb-3">
                            <label for="offer_deadline_date" class="form-label"><strong>Deadline Date</strong></label>
                            <input type="text" class="form-control" id="offer_deadline_date" name="offer_deadline_date" 
                                   value="<?php echo htmlspecialchars($summer_camp['special_offer']['deadline_date']); ?>"
                                   placeholder="e.g., March 31st, 2025">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="offer_free_badge_text" class="form-label"><strong>Free Badge Text</strong></label>
                            <input type="text" class="form-control" id="offer_free_badge_text" name="offer_free_badge_text" 
                                   value="<?php echo htmlspecialchars($summer_camp['special_offer']['free_badge_text']); ?>"
                                   placeholder="e.g., 100% FREE">
                        </div>
                        
                        <div class="mb-3">
                            <label for="offer_free_care_heading" class="form-label"><strong>Free Care Heading</strong></label>
                            <input type="text" class="form-control" id="offer_free_care_heading" name="offer_free_care_heading" 
                                   value="<?php echo htmlspecialchars($summer_camp['special_offer']['free_care_heading']); ?>"
                                   placeholder="e.g., FREE BEFORE & AFTER CARE">
                        </div>
                        
                        <div class="mb-3">
                            <label for="offer_free_care_description" class="form-label"><strong>Free Care Description</strong></label>
                            <textarea class="form-control" id="offer_free_care_description" name="offer_free_care_description" rows="2"
                                      placeholder="e.g., For ALL weeks when you register before March 31st, 2025"><?php echo htmlspecialchars($summer_camp['special_offer']['free_care_description']); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Section 3: Video Settings -->
        <div class="mb-4 p-3 border rounded bg-light">
            <h5 class="text-primary mb-3"><i class="fas fa-play-circle me-2"></i>Summer Camp Video</h5>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><strong>Upload New Video</strong></label>
                        <input type="file" class="form-control" name="summer_camp_video_upload" 
                               accept="video/*" onchange="previewVideo(this, 'summer-camp-video-preview')">
                        <div class="form-text">Upload MP4, WebM, or OGG (max 2MB for testing, larger files via FTP)</div>
                    </div>
                    <div class="mb-3">
                        <label for="video_source" class="form-label"><strong>Or Enter Video Path Manually</strong></label>
                        <input type="text" class="form-control" id="video_source" name="video_source" 
                               value="<?php echo htmlspecialchars($summer_camp['video']['source'] ?? 'assets/videos/summer-camp/summer-camp-video.mp4'); ?>"
                               placeholder="e.g., assets/videos/summer-camp/summer-camp-video.mp4">
                        <div class="form-text">Advanced: Direct path to video file</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><strong>Upload Video Thumbnail</strong></label>
                        <input type="file" class="form-control" name="video_thumbnail" 
                               accept="image/*" onchange="previewImage(this, 'summer-camp-thumbnail-preview')">
                        <div class="form-text">Upload thumbnail image (JPG, PNG, WebP - max 2MB)</div>
                    </div>
                    <div class="mb-3">
                        <label for="video_thumbnail_alt" class="form-label"><strong>Thumbnail Alt Text</strong></label>
                        <input type="text" class="form-control" id="video_thumbnail_alt" name="video_thumbnail_alt" 
                               value="<?php echo htmlspecialchars($summer_camp['video']['thumbnail_alt']); ?>"
                               placeholder="e.g., Summer Camp Video Preview">
                        <div class="form-text">Accessibility description for the video thumbnail</div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="video_overlay_title" class="form-label"><strong>Video Overlay Title</strong></label>
                        <input type="text" class="form-control" id="video_overlay_title" name="video_overlay_title" 
                               value="<?php echo htmlspecialchars($summer_camp['video']['overlay_title']); ?>"
                               placeholder="e.g., Watch Our Summer Camp Experience">
                    </div>
                    
                    <div class="mb-3">
                        <label for="video_overlay_description" class="form-label"><strong>Video Overlay Description</strong></label>
                        <input type="text" class="form-control" id="video_overlay_description" name="video_overlay_description" 
                               value="<?php echo htmlspecialchars($summer_camp['video']['overlay_description']); ?>"
                               placeholder="e.g., See what makes Kaizen Summer Camp special">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="video_onclick" class="form-label"><strong>Click Action (JavaScript)</strong></label>
                        <input type="text" class="form-control" id="video_onclick" name="video_onclick" 
                               value="<?php echo htmlspecialchars($summer_camp['video']['onclick']); ?>"
                               placeholder="e.g., openSummerCampVideo()">
                        <div class="form-text">JavaScript function to call when video is clicked</div>
                    </div>
                    
                    <!-- Current Thumbnail Preview -->
                    <?php if (!empty($summer_camp['video']['thumbnail'])): ?>
                    <div class="mb-3">
                        <label class="form-label"><strong>Current Thumbnail</strong></label>
                        <div>
                            <img id="summer-camp-thumbnail-preview" src="../<?php echo htmlspecialchars($summer_camp['video']['thumbnail']); ?>" 
                                 alt="Summer Camp Thumbnail Preview" class="img-fluid border rounded" 
                                 style="max-height: 150px; max-width: 100%;">
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Video Preview -->
        <div class="mb-4">
            <h5 class="text-primary mb-3"><i class="fas fa-eye me-2"></i>Current Video Preview</h5>
            <div class="video-preview bg-light p-3 rounded border">
                <?php if (!empty($summer_camp['video']['source'])): ?>
                    <video width="400" height="225" controls poster="<?php echo htmlspecialchars($summer_camp['video']['thumbnail']); ?>"
                           style="max-width: 100%;">
                        <source src="../<?php echo htmlspecialchars($summer_camp['video']['source']); ?>" type="video/mp4">
                        <div style="color: #dc3545;">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Video not supported or not found: <?php echo htmlspecialchars($summer_camp['video']['source']); ?>
                        </div>
                    </video>
                <?php else: ?>
                    <div class="text-muted text-center" style="min-height: 200px; display: flex; align-items: center; justify-content: center;">
                        <div>
                            <i class="fas fa-video me-2" style="font-size: 2rem;"></i>
                            <p class="mb-0">No video configured</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <button type="submit" class="btn btn-kaizen">
            <i class="fas fa-save me-2"></i>Save Summer Camp Settings (Step 1)
        </button>
    </form>
</div>

<!-- Features Grid Management -->
<div class="content-section">
    <h3 class="section-title"><i class="fas fa-th-large me-2"></i>Features Grid Management</h3>
    <div class="alert alert-kaizen border-0 mb-4">
        <i class="fas fa-info-circle me-2"></i>
        <strong>Features Grid:</strong> Manage the clickable feature icons shown next to the video. These features help users understand what your Summer Camp offers.
    </div>
    
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
        <input type="hidden" name="update_features" value="1">
        
        <div id="features-container">
            <?php foreach ($summer_camp_data['features'] as $index => $feature): ?>
            <div class="feature-item border rounded p-3 mb-3">
                <div class="row align-items-center">
                    <div class="col-md-1 text-center">
                        <i class="fas fa-grip-vertical text-muted" style="cursor: move;"></i>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Icon Class</label>
                        <input type="text" class="form-control" name="feature_icon[]" 
                               value="<?php echo htmlspecialchars($feature['icon']); ?>"
                               placeholder="e.g., fas fa-fist-raised">
                        <div class="form-text">FontAwesome icon class</div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Feature Text</label>
                        <input type="text" class="form-control" name="feature_text[]" 
                               value="<?php echo htmlspecialchars($feature['text']); ?>"
                               placeholder="e.g., Karate Instruction">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Click Action</label>
                        <input type="text" class="form-control" name="feature_onclick[]" 
                               value="<?php echo htmlspecialchars($feature['onclick']); ?>"
                               placeholder="e.g., scrollToDailyScheduleInfo()">
                        <div class="form-text">JavaScript function or action</div>
                    </div>
                    <div class="col-md-1 text-center">
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeFeature(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="mt-3 mb-4">
            <button type="button" class="btn btn-outline-primary" onclick="addFeature()">
                <i class="fas fa-plus me-2"></i>Add Feature
            </button>
        </div>
        
        <button type="submit" class="btn btn-kaizen">
            <i class="fas fa-save me-2"></i>Update Features Grid
        </button>
    </form>
</div>

<!-- Camp Locations Management -->
<div class="content-section">
    <h3 class="section-title"><i class="fas fa-map-marker-alt me-2"></i>Camp Locations Management</h3>
    <div class="alert alert-kaizen border-0 mb-4">
        <i class="fas fa-info-circle me-2"></i>
        <strong>Camp Locations:</strong> Manage all summer camp location cards. Each location includes venue information, dates, and registration links.
    </div>
    
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
        <input type="hidden" name="update_locations" value="1">
        
        <div id="locations-container">
            <?php foreach ($summer_camp_data['camp_locations'] as $index => $location): ?>
            <div class="location-item border rounded p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0"><i class="fas fa-map-pin me-2 text-primary"></i>Location <?php echo $index + 1; ?></h5>
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeLocation(this)">
                        <i class="fas fa-trash me-1"></i>Remove Location
                    </button>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><strong>Location Title</strong></label>
                            <input type="text" class="form-control" name="location_title[]" 
                                   value="<?php echo htmlspecialchars($location['title']); ?>"
                                   placeholder="e.g., Northwest DC">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><strong>Venue Name</strong></label>
                            <input type="text" class="form-control" name="location_venue[]" 
                                   value="<?php echo htmlspecialchars($location['venue']); ?>"
                                   placeholder="e.g., Washington Hebrew Congregation">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><strong>Address</strong></label>
                            <textarea class="form-control" name="location_address[]" rows="2"
                                      placeholder="Street Address<br>City, State ZIP"><?php echo htmlspecialchars($location['address']); ?></textarea>
                            <div class="form-text">Use &lt;br&gt; for line breaks</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label"><strong>Duration</strong></label>
                            <input type="text" class="form-control" name="location_duration[]" 
                                   value="<?php echo htmlspecialchars($location['duration']); ?>"
                                   placeholder="e.g., June 23 - August 15">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label"><strong>Number of Weeks</strong></label>
                            <input type="text" class="form-control" name="location_weeks[]" 
                                   value="<?php echo htmlspecialchars($location['weeks']); ?>"
                                   placeholder="e.g., 8 weeks">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><strong>New Families Registration URL</strong></label>
                            <input type="url" class="form-control" name="location_new_families_url[]" 
                                   value="<?php echo htmlspecialchars($location['new_families_url']); ?>"
                                   placeholder="https://...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><strong>Returning Families Registration URL</strong></label>
                            <input type="url" class="form-control" name="location_returning_families_url[]" 
                                   value="<?php echo htmlspecialchars($location['returning_families_url']); ?>"
                                   placeholder="https://...">
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="mt-3 mb-4">
            <button type="button" class="btn btn-outline-primary" onclick="addLocation()">
                <i class="fas fa-plus me-2"></i>Add Location
            </button>
        </div>
        
        <button type="submit" class="btn btn-kaizen">
            <i class="fas fa-save me-2"></i>Update Camp Locations
        </button>
    </form>
</div>

<!-- Next Steps Information -->
<div class="content-section">
    <h3 class="section-title"><i class="fas fa-info-circle me-2"></i>Implementation Progress</h3>
    <div class="row">
        <div class="col-md-4">
            <div class="card border-success">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="fas fa-check-circle me-2"></i>Step 1: Basic Settings</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li><i class="fas fa-check text-success me-2"></i>Basic Information</li>
                        <li><i class="fas fa-check text-success me-2"></i>Special Offer Configuration</li>
                        <li><i class="fas fa-check text-success me-2"></i>Video Settings</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-warning">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0"><i class="fas fa-clock me-2"></i>Step 2: Dynamic Elements</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li><i class="fas fa-hourglass-half text-warning me-2"></i>Features Grid Management</li>
                        <li><i class="fas fa-hourglass-half text-warning me-2"></i>Camp Locations</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-secondary">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0"><i class="fas fa-hourglass-start me-2"></i>Step 3: Complex Content</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li><i class="fas fa-hourglass-start text-secondary me-2"></i>Registration Information</li>
                        <li><i class="fas fa-hourglass-start text-secondary me-2"></i>Accordion Content Management</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle offer fields based on enabled checkbox
    const offerEnabled = document.getElementById('offer_enabled');
    const offerFields = document.getElementById('offer-fields');
    
    function toggleOfferFields() {
        if (offerEnabled.checked) {
            offerFields.style.display = 'block';
        } else {
            offerFields.style.display = 'none';
        }
    }
    
    offerEnabled.addEventListener('change', toggleOfferFields);
    toggleOfferFields(); // Initialize on page load
});

function previewImage(input, previewId) {
    const file = input.files[0];
    const preview = document.getElementById(previewId);
    
    if (file) {
        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/svg+xml', 'image/webp'];
        if (!allowedTypes.includes(file.type)) {
            alert('Please select a valid image file (JPG, PNG, SVG, or WebP)');
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            if (preview) {
                if (preview.querySelector('img')) {
                    preview.querySelector('img').src = e.target.result;
                } else {
                    // Create new image element
                    preview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="img-fluid border rounded" style="max-height: 150px; max-width: 100%;">`;
                }
            }
        };
        reader.readAsDataURL(file);
    }
}

function previewVideo(input, previewId) {
    const file = input.files[0];
    const preview = document.getElementById(previewId);
    
    if (file) {
        // Validate file type
        const allowedTypes = ['video/mp4', 'video/webm', 'video/ogg'];
        if (!allowedTypes.includes(file.type)) {
            alert('Please select a valid video file (MP4, WebM, or OGG)');
            input.value = '';
            return;
        }
        
        // Validate file size (2MB limit for demo - larger files should use FTP)
        if (file.size > 2 * 1024 * 1024) {
            alert('File size too large for web upload. For videos larger than 2MB, please use FTP to upload to assets/videos/summer-camp/ directory.');
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            if (preview) {
                preview.innerHTML = `
                    <video width="400" height="225" controls style="max-width: 100%;">
                        <source src="${e.target.result}" type="${file.type}">
                        Your browser does not support the video tag.
                    </video>
                `;
            }
        };
        reader.readAsDataURL(file);
    }
}

// Features Management Functions
function addFeature() {
    const container = document.getElementById('features-container');
    const newItem = document.createElement('div');
    newItem.className = 'feature-item border rounded p-3 mb-3';
    newItem.innerHTML = `
        <div class="row align-items-center">
            <div class="col-md-1 text-center">
                <i class="fas fa-grip-vertical text-muted" style="cursor: move;"></i>
            </div>
            <div class="col-md-3">
                <label class="form-label">Icon Class</label>
                <input type="text" class="form-control" name="feature_icon[]" 
                       placeholder="e.g., fas fa-fist-raised">
                <div class="form-text">FontAwesome icon class</div>
            </div>
            <div class="col-md-3">
                <label class="form-label">Feature Text</label>
                <input type="text" class="form-control" name="feature_text[]" 
                       placeholder="e.g., Karate Instruction">
            </div>
            <div class="col-md-4">
                <label class="form-label">Click Action</label>
                <input type="text" class="form-control" name="feature_onclick[]" 
                       placeholder="e.g., scrollToDailyScheduleInfo()">
                <div class="form-text">JavaScript function or action</div>
            </div>
            <div class="col-md-1 text-center">
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeFeature(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `;
    container.appendChild(newItem);
}

function removeFeature(button) {
    button.closest('.feature-item').remove();
}

// Camp Locations Management Functions
function addLocation() {
    const container = document.getElementById('locations-container');
    const locationCount = container.children.length + 1;
    const newItem = document.createElement('div');
    newItem.className = 'location-item border rounded p-4 mb-4';
    newItem.innerHTML = `
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0"><i class="fas fa-map-pin me-2 text-primary"></i>Location ${locationCount}</h5>
            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeLocation(this)">
                <i class="fas fa-trash me-1"></i>Remove Location
            </button>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label"><strong>Location Title</strong></label>
                    <input type="text" class="form-control" name="location_title[]" 
                           placeholder="e.g., Northwest DC">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label"><strong>Venue Name</strong></label>
                    <input type="text" class="form-control" name="location_venue[]" 
                           placeholder="e.g., Washington Hebrew Congregation">
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label"><strong>Address</strong></label>
                    <textarea class="form-control" name="location_address[]" rows="2"
                              placeholder="Street Address<br>City, State ZIP"></textarea>
                    <div class="form-text">Use &lt;br&gt; for line breaks</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label"><strong>Duration</strong></label>
                    <input type="text" class="form-control" name="location_duration[]" 
                           placeholder="e.g., June 23 - August 15">
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label"><strong>Number of Weeks</strong></label>
                    <input type="text" class="form-control" name="location_weeks[]" 
                           placeholder="e.g., 8 weeks">
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label"><strong>New Families Registration URL</strong></label>
                    <input type="url" class="form-control" name="location_new_families_url[]" 
                           placeholder="https://...">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label"><strong>Returning Families Registration URL</strong></label>
                    <input type="url" class="form-control" name="location_returning_families_url[]" 
                           placeholder="https://...">
                </div>
            </div>
        </div>
    `;
    container.appendChild(newItem);
}

function removeLocation(button) {
    button.closest('.location-item').remove();
    // Update location numbers
    const container = document.getElementById('locations-container');
    const locationItems = container.querySelectorAll('.location-item');
    locationItems.forEach((item, index) => {
        const header = item.querySelector('h5');
        header.innerHTML = `<i class="fas fa-map-pin me-2 text-primary"></i>Location ${index + 1}`;
    });
}
</script>

            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>