<?php
define('KAIZEN_ADMIN', true);
session_start();
require_once 'config.php';

// Require login
require_login();

$message = '';

// Handle form submission
if ($_POST) {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $message = error_message('Security token invalid. Please try again.');
    } else {
        $content = load_json_data('site-content');
        
        // Update main menu items
        if (isset($_POST['menu_items'])) {
            $menu_items = [];
            foreach ($_POST['menu_text'] as $index => $text) {
                if (!empty($text)) {
                    $menu_items[] = [
                        'text' => sanitize_input($text),
                        'href' => sanitize_input($_POST['menu_href'][$index])
                    ];
                }
            }
            $content['navigation']['menu_items'] = $menu_items;
        }
        
        // Update Logo content
        if (isset($_POST['logo_section'])) {
            $media_content = load_json_data('media');
            
            // Handle main logo upload
            $main_logo_path = sanitize_input($_POST['logo_main']);
            if (isset($_FILES['logo_main_upload']) && $_FILES['logo_main_upload']['error'] === UPLOAD_ERR_OK) {
                $upload_result = handle_file_upload('logo_main_upload', 'logo');
                if ($upload_result['success']) {
                    $main_logo_path = $upload_result['path'];
                    $message = success_message('Main logo uploaded successfully!');
                } else {
                    $message = error_message('Main logo upload failed: ' . $upload_result['error']);
                }
            }
            
            // Handle mobile logo upload
            $mobile_logo_path = sanitize_input($_POST['logo_mobile']);
            if (isset($_FILES['logo_mobile_upload']) && $_FILES['logo_mobile_upload']['error'] === UPLOAD_ERR_OK) {
                $upload_result = handle_file_upload('logo_mobile_upload', 'logo');
                if ($upload_result['success']) {
                    $mobile_logo_path = $upload_result['path'];
                    $message = success_message('Mobile logo uploaded successfully!');
                } else {
                    $message = error_message('Mobile logo upload failed: ' . $upload_result['error']);
                }
            }
            
            $media_content['logo'] = [
                'main' => $main_logo_path,
                'mobile' => $mobile_logo_path,
                'alt' => sanitize_input($_POST['logo_alt'])
            ];
            save_json_data('media', $media_content);
        }
        
        // Update Register dropdown content
        if (isset($_POST['register_section'])) {
            $content['navigation']['register_dropdown'] = [
                'title' => sanitize_input($_POST['register_title']),
                'after_school' => [
                    'header_line1' => sanitize_input($_POST['after_school_line1']),
                    'header_line2' => sanitize_input($_POST['after_school_line2']),
                    'button' => sanitize_input($_POST['after_school_button']),
                    'url' => sanitize_input($_POST['after_school_url'])
                ],
                'kaizen_dojo' => [
                    'header' => sanitize_input($_POST['kaizen_dojo_header']),
                    'button' => sanitize_input($_POST['kaizen_dojo_button']),
                    'url' => sanitize_input($_POST['kaizen_dojo_url'])
                ],
                'summer_camp' => [
                    'header' => sanitize_input($_POST['summer_camp_header']),
                    'display_mode' => sanitize_input($_POST['summer_camp_display_mode']),
                    'text' => sanitize_input($_POST['summer_camp_text']),
                    'link_text' => sanitize_input($_POST['summer_camp_link_text']),
                    'link_url' => sanitize_input($_POST['summer_camp_link_url']),
                    'button' => sanitize_input($_POST['summer_camp_button']),
                    'url' => sanitize_input($_POST['summer_camp_url'])
                ],
                'belt_exams' => [
                    'header' => sanitize_input($_POST['belt_exams_header']),
                    'display_mode' => sanitize_input($_POST['belt_exams_display_mode']),
                    'button' => sanitize_input($_POST['belt_exams_button']),
                    'url' => sanitize_input($_POST['belt_exams_url']),
                    'num_buttons' => sanitize_input($_POST['belt_exams_num_buttons']),
                    'exam_buttons' => [],
                    'view_process_text' => sanitize_input($_POST['belt_exams_view_process_text']),
                    'view_process_url' => sanitize_input($_POST['belt_exams_view_process_url'])
                ]
            ];
            
            // Process exam buttons for multiple mode
            if ($content['navigation']['register_dropdown']['belt_exams']['display_mode'] === 'multiple') {
                $num_buttons = intval($content['navigation']['register_dropdown']['belt_exams']['num_buttons']);
                for ($i = 1; $i <= $num_buttons; $i++) {
                    $content['navigation']['register_dropdown']['belt_exams']['exam_buttons'][] = [
                        'line1' => sanitize_input($_POST["belt_exam_button_{$i}_line1"]),
                        'line2' => sanitize_input($_POST["belt_exam_button_{$i}_line2"]),
                        'line3' => sanitize_input($_POST["belt_exam_button_{$i}_line3"]),
                        'url' => sanitize_input($_POST["belt_exam_button_{$i}_url"])
                    ];
                }
            }
        }
        
        // Update Social Media Links
        if (isset($_POST['social_media_section'])) {
            $content['navigation']['social_media'] = [
                'facebook' => sanitize_input($_POST['facebook_url']),
                'instagram' => sanitize_input($_POST['instagram_url']),
                'tiktok' => sanitize_input($_POST['tiktok_url']),
                'podcast' => sanitize_input($_POST['podcast_url']),
                'youtube' => sanitize_input($_POST['youtube_url']),
                'twitter' => sanitize_input($_POST['twitter_url'])
            ];
        }
        
        if (save_json_data('site-content', $content)) {
            $message = success_message('Navigation updated successfully!');
        } else {
            $message = error_message('Failed to save changes.');
        }
    }
}

// Load current content
$content = load_json_data('site-content');
$nav = $content['navigation'] ?? [];
$menu_items = $nav['menu_items'] ?? [];
$register_dropdown = $nav['register_dropdown'] ?? [];

// Load media content for logo
$media_content = load_json_data('media');
$logo = $media_content['logo'] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation & Logo Management - Kaizen Karate Admin</title>
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
        .menu-item { background: #f8f9fa; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; }
        .dropdown-section { background: #fff8f0; padding: 1.25rem; border-radius: 8px; margin-bottom: 1rem; border: 1px solid #ffd6b3; }
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
                    <h1><i class="fas fa-bars me-2 text-primary"></i>Navigation & Logo Management</h1>
                </div>
                
                <?php echo $message; ?>
                
                <!-- Logo Section -->
                <div class="content-section">
                    <h3 class="section-title"><i class="fas fa-image me-2"></i>Website Logo</h3>
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="logo_section" value="1">
                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                        
                        <!-- Main Logo -->
                        <div class="mb-4 p-3 border rounded bg-light">
                            <h5 class="text-primary mb-3"><i class="fas fa-image me-2"></i>Main Logo</h5>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Upload New Logo</strong></label>
                                        <input type="file" class="form-control" name="logo_main_upload" 
                                               accept="image/*" onchange="previewImage(this, 'main-logo-preview')">
                                        <div class="form-text">Upload JPG, PNG, SVG, or WebP (max 2MB)</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="logo_main" class="form-label"><strong>Or Enter Path Manually</strong></label>
                                        <input type="text" class="form-control" id="logo_main" name="logo_main" 
                                               value="<?php echo htmlspecialchars($logo['main'] ?? 'assets/images/logo.png'); ?>"
                                               placeholder="e.g., assets/images/logo.png">
                                        <div class="form-text">Advanced: Direct path to logo file</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label"><strong>Current Logo</strong></label>
                                    <div class="logo-preview-container">
                                        <?php if (!empty($logo['main'])): ?>
                                        <img id="main-logo-preview" src="../<?php echo htmlspecialchars($logo['main']); ?>" 
                                             alt="Main Logo Preview" class="img-fluid border rounded" 
                                             style="max-height: 120px; max-width: 100%;">
                                        <?php else: ?>
                                        <div id="main-logo-preview" class="border rounded p-3 text-center text-muted" 
                                             style="height: 120px; display: flex; align-items: center; justify-content: center;">
                                            No logo uploaded
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Mobile Logo -->
                        <div class="mb-4 p-3 border rounded bg-light">
                            <h5 class="text-primary mb-3"><i class="fas fa-mobile-alt me-2"></i>Mobile Logo</h5>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Upload New Mobile Logo</strong></label>
                                        <input type="file" class="form-control" name="logo_mobile_upload" 
                                               accept="image/*" onchange="previewImage(this, 'mobile-logo-preview')">
                                        <div class="form-text">Upload JPG, PNG, SVG, or WebP (max 2MB)</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="logo_mobile" class="form-label"><strong>Or Enter Path Manually</strong></label>
                                        <input type="text" class="form-control" id="logo_mobile" name="logo_mobile" 
                                               value="<?php echo htmlspecialchars($logo['mobile'] ?? 'assets/images/logo.png'); ?>"
                                               placeholder="e.g., assets/images/logo.png">
                                        <div class="form-text">Advanced: Direct path to mobile logo file</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label"><strong>Current Mobile Logo</strong></label>
                                    <div class="logo-preview-container">
                                        <?php if (!empty($logo['mobile'])): ?>
                                        <img id="mobile-logo-preview" src="../<?php echo htmlspecialchars($logo['mobile']); ?>" 
                                             alt="Mobile Logo Preview" class="img-fluid border rounded" 
                                             style="max-height: 120px; max-width: 100%;">
                                        <?php else: ?>
                                        <div id="mobile-logo-preview" class="border rounded p-3 text-center text-muted" 
                                             style="height: 120px; display: flex; align-items: center; justify-content: center;">
                                            No mobile logo uploaded
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="logo_alt" class="form-label"><strong>Logo Alt Text</strong></label>
                            <input type="text" class="form-control" id="logo_alt" name="logo_alt" 
                                   value="<?php echo htmlspecialchars($logo['alt'] ?? 'Kaizen Karate'); ?>"
                                   placeholder="e.g., Kaizen Karate Logo">
                            <div class="form-text">Alternative text for accessibility and SEO</div>
                        </div>
                        
                        <!-- Logo Preview -->
                        <div class="mb-4">
                            <h5 class="text-primary mb-3"><i class="fas fa-eye me-2"></i>Current Logo Preview</h5>
                            <div class="logo-preview bg-light p-3 rounded border">
                                <?php if (!empty($logo['main'])): ?>
                                    <img src="../<?php echo htmlspecialchars($logo['main']); ?>" 
                                         alt="<?php echo htmlspecialchars($logo['alt']); ?>" 
                                         style="max-height: 100px; max-width: 300px;"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                    <div style="display:none; color: #dc3545;">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        Logo image not found: <?php echo htmlspecialchars($logo['main']); ?>
                                    </div>
                                <?php else: ?>
                                    <div class="text-muted">
                                        <i class="fas fa-image me-2"></i>
                                        No logo configured
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-kaizen">
                            <i class="fas fa-save me-2"></i>Update Logo
                        </button>
                    </form>
                </div>
                
                <!-- Register Dropdown Section -->
                <div class="content-section">
                    <h3 class="section-title"><i class="fas fa-caret-down me-2"></i>Register Dropdown Menu</h3>
                    <form method="POST">
                        <input type="hidden" name="register_section" value="1">
                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                        
                        <div class="mb-4">
                            <label for="register_title" class="form-label"><strong>Dropdown Title</strong></label>
                            <input type="text" class="form-control" id="register_title" name="register_title" 
                                   value="<?php echo htmlspecialchars($register_dropdown['title'] ?? 'Register Now'); ?>">
                        </div>
                        
                        <!-- After School Section -->
                        <div class="dropdown-section">
                            <h5 class="text-primary mb-3"><i class="fas fa-school me-2"></i>After School / Weekend & Evening</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Header Line 1</label>
                                        <input type="text" class="form-control" name="after_school_line1" 
                                               value="<?php echo htmlspecialchars($register_dropdown['after_school']['header_line1'] ?? ''); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Header Line 2</label>
                                        <input type="text" class="form-control" name="after_school_line2" 
                                               value="<?php echo htmlspecialchars($register_dropdown['after_school']['header_line2'] ?? ''); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Button Text</label>
                                        <input type="text" class="form-control" name="after_school_button" 
                                               value="<?php echo htmlspecialchars($register_dropdown['after_school']['button'] ?? ''); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Registration URL</label>
                                        <input type="url" class="form-control" name="after_school_url" 
                                               value="<?php echo htmlspecialchars($register_dropdown['after_school']['url'] ?? ''); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Kaizen Dojo Section -->
                        <div class="dropdown-section">
                            <h5 class="text-primary mb-3"><i class="fas fa-car me-2"></i>Kaizen Dojo</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Header</label>
                                        <input type="text" class="form-control" name="kaizen_dojo_header" 
                                               value="<?php echo htmlspecialchars($register_dropdown['kaizen_dojo']['header'] ?? ''); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Button Text</label>
                                        <input type="text" class="form-control" name="kaizen_dojo_button" 
                                               value="<?php echo htmlspecialchars($register_dropdown['kaizen_dojo']['button'] ?? ''); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Registration URL</label>
                                        <input type="url" class="form-control" name="kaizen_dojo_url" 
                                               value="<?php echo htmlspecialchars($register_dropdown['kaizen_dojo']['url'] ?? ''); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Summer Camp Section -->
                        <div class="dropdown-section">
                            <h5 class="text-primary mb-3"><i class="fas fa-sun me-2"></i>Summer Camp</h5>
                            <div class="mb-3">
                                <label class="form-label">Header</label>
                                <input type="text" class="form-control" name="summer_camp_header" 
                                       value="<?php echo htmlspecialchars($register_dropdown['summer_camp']['header'] ?? ''); ?>">
                            </div>
                            
                            <div class="mb-4">
                                <label for="summer_camp_display_mode" class="form-label"><strong>Display Style</strong></label>
                                <select class="form-select" name="summer_camp_display_mode" id="summer_camp_display_mode" onchange="toggleSummerCampFields()">
                                    <option value="information" <?php echo ($register_dropdown['summer_camp']['display_mode'] ?? 'information') === 'information' ? 'selected' : ''; ?>>Information (Text + Optional Link)</option>
                                    <option value="button" <?php echo ($register_dropdown['summer_camp']['display_mode'] ?? '') === 'button' ? 'selected' : ''; ?>>Registration Button</option>
                                </select>
                                <div class="form-text">Choose how to display the Summer Camp section</div>
                            </div>

                            <!-- Information Mode Fields -->
                            <div id="information_fields" style="<?php echo ($register_dropdown['summer_camp']['display_mode'] ?? 'information') === 'button' ? 'display: none;' : ''; ?>">
                                <div class="mb-3">
                                    <label class="form-label">Description Text</label>
                                    <textarea class="form-control" name="summer_camp_text" rows="3"><?php echo htmlspecialchars($register_dropdown['summer_camp']['text'] ?? ''); ?></textarea>
                                    <div class="form-text">Plain text description (no HTML links)</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Link Text</label>
                                            <input type="text" class="form-control" name="summer_camp_link_text" 
                                                   value="<?php echo htmlspecialchars($register_dropdown['summer_camp']['link_text'] ?? ''); ?>"
                                                   placeholder="e.g., Explore our 2025 Summer Camp program">
                                            <div class="form-text">Text to display for the link (optional)</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Link URL</label>
                                            <input type="text" class="form-control" name="summer_camp_link_url" 
                                                   value="<?php echo htmlspecialchars($register_dropdown['summer_camp']['link_url'] ?? ''); ?>"
                                                   placeholder="e.g., #summer-camp or full URL">
                                            <div class="form-text">URL for the link (optional)</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Button Mode Fields -->
                            <div id="button_fields" style="<?php echo ($register_dropdown['summer_camp']['display_mode'] ?? 'information') === 'information' ? 'display: none;' : ''; ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Button Text</label>
                                            <input type="text" class="form-control" name="summer_camp_button" 
                                                   value="<?php echo htmlspecialchars($register_dropdown['summer_camp']['button'] ?? 'Register Now!'); ?>"
                                                   placeholder="e.g., Register Now!">
                                            <div class="form-text">Text displayed on the registration button</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Registration URL</label>
                                            <input type="text" class="form-control" name="summer_camp_url" 
                                                   value="<?php echo htmlspecialchars($register_dropdown['summer_camp']['url'] ?? ''); ?>"
                                                   placeholder="https://register.example.com or #summer-camp">
                                            <div class="form-text">Full URL, anchor link (#section), or relative path (/register)</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Belt Exams Section -->
                        <div class="dropdown-section">
                            <h5 class="text-primary mb-3"><i class="fas fa-award me-2"></i>Belt Exams</h5>
                            <div class="mb-3">
                                <label class="form-label">Header</label>
                                <input type="text" class="form-control" name="belt_exams_header" 
                                       value="<?php echo htmlspecialchars($register_dropdown['belt_exams']['header'] ?? ''); ?>">
                            </div>
                            
                            <div class="mb-4">
                                <label for="belt_exams_display_mode" class="form-label"><strong>Display Mode</strong></label>
                                <select class="form-select" name="belt_exams_display_mode" id="belt_exams_display_mode" onchange="toggleBeltExamsFields()">
                                    <option value="simple" <?php echo ($register_dropdown['belt_exams']['display_mode'] ?? 'simple') === 'simple' ? 'selected' : ''; ?>>Simple Button</option>
                                    <option value="multiple" <?php echo ($register_dropdown['belt_exams']['display_mode'] ?? '') === 'multiple' ? 'selected' : ''; ?>>Multiple Exam Buttons</option>
                                </select>
                                <div class="form-text">Choose how to display the Belt Exams section</div>
                            </div>

                            <!-- Simple Mode Fields -->
                            <div id="simple_belt_fields" style="<?php echo ($register_dropdown['belt_exams']['display_mode'] ?? 'simple') === 'multiple' ? 'display: none;' : ''; ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Button Text</label>
                                            <input type="text" class="form-control" name="belt_exams_button" 
                                                   value="<?php echo htmlspecialchars($register_dropdown['belt_exams']['button'] ?? 'Register Now!'); ?>"
                                                   placeholder="e.g., Register Now!">
                                            <div class="form-text">Text displayed on the registration button</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Registration URL</label>
                                            <input type="text" class="form-control" name="belt_exams_url" 
                                                   value="<?php echo htmlspecialchars($register_dropdown['belt_exams']['url'] ?? ''); ?>"
                                                   placeholder="Leave blank for scroll behavior">
                                            <div class="form-text"><strong>WARNING:</strong> Leave URL blank to use the special scroll-to-belt-exam-register functionality. Adding a custom URL will override this behavior.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Multiple Mode Fields -->
                            <div id="multiple_belt_fields" style="<?php echo ($register_dropdown['belt_exams']['display_mode'] ?? 'simple') === 'simple' ? 'display: none;' : ''; ?>">
                                <div class="mb-4">
                                    <label for="belt_exams_num_buttons" class="form-label">Number of Exam Buttons</label>
                                    <select class="form-select" name="belt_exams_num_buttons" id="belt_exams_num_buttons" onchange="updateBeltExamButtons()">
                                        <option value="1" <?php echo ($register_dropdown['belt_exams']['num_buttons'] ?? '1') === '1' ? 'selected' : ''; ?>>1</option>
                                        <option value="2" <?php echo ($register_dropdown['belt_exams']['num_buttons'] ?? '') === '2' ? 'selected' : ''; ?>>2</option>
                                        <option value="3" <?php echo ($register_dropdown['belt_exams']['num_buttons'] ?? '') === '3' ? 'selected' : ''; ?>>3</option>
                                    </select>
                                </div>
                                
                                <div id="exam_buttons_container">
                                    <?php 
                                    $num_buttons = intval($register_dropdown['belt_exams']['num_buttons'] ?? 1);
                                    $exam_buttons = $register_dropdown['belt_exams']['exam_buttons'] ?? [];
                                    for ($i = 1; $i <= 3; $i++): 
                                        $button_data = $exam_buttons[$i-1] ?? [];
                                        $display_style = ($i <= $num_buttons) ? '' : 'display: none;';
                                    ?>
                                    <div class="exam-button-group border rounded p-3 mb-3" id="exam_button_<?php echo $i; ?>" style="<?php echo $display_style; ?>">
                                        <h6 class="text-secondary mb-3">Exam Button <?php echo $i; ?></h6>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label">Line 1 Text</label>
                                                    <input type="text" class="form-control" name="belt_exam_button_<?php echo $i; ?>_line1" 
                                                           value="<?php echo htmlspecialchars($button_data['line1'] ?? 'REGISTER!'); ?>"
                                                           placeholder="REGISTER!">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label">Line 2 Text</label>
                                                    <input type="text" class="form-control" name="belt_exam_button_<?php echo $i; ?>_line2" 
                                                           value="<?php echo htmlspecialchars($button_data['line2'] ?? 'Youth Exam'); ?>"
                                                           placeholder="Youth Exam">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label">Line 3 Text</label>
                                                    <input type="text" class="form-control" name="belt_exam_button_<?php echo $i; ?>_line3" 
                                                           value="<?php echo htmlspecialchars($button_data['line3'] ?? 'Saturday, Nov 15th'); ?>"
                                                           placeholder="Saturday, Nov 15th">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label">Custom URL</label>
                                                    <input type="text" class="form-control" name="belt_exam_button_<?php echo $i; ?>_url" 
                                                           value="<?php echo htmlspecialchars($button_data['url'] ?? ''); ?>"
                                                           placeholder="Leave blank for scroll">
                                                    <div class="form-text"><strong>WARNING:</strong> Leave blank to use scroll-to-register functionality. Adding a URL will override the special scroll behavior.</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endfor; ?>
                                </div>
                            </div>

                            <!-- View Process Link (Always Shown) -->
                            <div class="mb-4 p-3 bg-light rounded">
                                <h6 class="text-primary mb-3">View Process Link (Always Displayed)</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Link Text</label>
                                            <input type="text" class="form-control" name="belt_exams_view_process_text" 
                                                   value="<?php echo htmlspecialchars($register_dropdown['belt_exams']['view_process_text'] ?? 'View Process >>'); ?>"
                                                   placeholder="View Process >>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Link URL</label>
                                            <input type="text" class="form-control" name="belt_exams_view_process_url" 
                                                   value="<?php echo htmlspecialchars($register_dropdown['belt_exams']['view_process_url'] ?? '#belt-exam'); ?>"
                                                   placeholder="#belt-exam">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-kaizen">
                            <i class="fas fa-save me-2"></i>Update Register Dropdown
                        </button>
                    </form>
                </div>
                
                <!-- Social Media Links Section -->
                <div class="content-section">
                    <h3 class="section-title"><i class="fas fa-share-alt me-2"></i>Social Media Links</h3>
                    <form method="POST">
                        <input type="hidden" name="social_media_section" value="1">
                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="facebook_url" class="form-label">
                                        <i class="fab fa-facebook text-primary me-1"></i>
                                        <strong>Facebook URL</strong>
                                    </label>
                                    <input type="url" class="form-control" id="facebook_url" name="facebook_url" 
                                           value="<?php echo htmlspecialchars($content['navigation']['social_media']['facebook'] ?? 'https://www.facebook.com/people/Kaizen-Karate/100063714665511/'); ?>"
                                           placeholder="https://www.facebook.com/...">
                                    <div class="form-text">Your Facebook page URL</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="instagram_url" class="form-label">
                                        <i class="fab fa-instagram text-danger me-1"></i>
                                        <strong>Instagram URL</strong>
                                    </label>
                                    <input type="url" class="form-control" id="instagram_url" name="instagram_url" 
                                           value="<?php echo htmlspecialchars($content['navigation']['social_media']['instagram'] ?? 'https://www.instagram.com/kaizenkaratemd/'); ?>"
                                           placeholder="https://www.instagram.com/...">
                                    <div class="form-text">Your Instagram profile URL</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tiktok_url" class="form-label">
                                        <i class="fab fa-tiktok text-dark me-1"></i>
                                        <strong>TikTok URL</strong>
                                    </label>
                                    <input type="url" class="form-control" id="tiktok_url" name="tiktok_url" 
                                           value="<?php echo htmlspecialchars($content['navigation']['social_media']['tiktok'] ?? 'https://www.tiktok.com/@kaizenkaratemd'); ?>"
                                           placeholder="https://www.tiktok.com/@...">
                                    <div class="form-text">Your TikTok profile URL</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="podcast_url" class="form-label">
                                        <i class="fas fa-podcast text-success me-1"></i>
                                        <strong>Podcast URL</strong>
                                    </label>
                                    <input type="url" class="form-control" id="podcast_url" name="podcast_url" 
                                           value="<?php echo htmlspecialchars($content['navigation']['social_media']['podcast'] ?? 'https://coachv6z.podbean.com/'); ?>"
                                           placeholder="https://... (optional)">
                                    <div class="form-text">Your Podcast URL (optional)</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="youtube_url" class="form-label">
                                        <i class="fab fa-youtube text-danger me-1"></i>
                                        <strong>YouTube URL</strong>
                                    </label>
                                    <input type="url" class="form-control" id="youtube_url" name="youtube_url" 
                                           value="<?php echo htmlspecialchars($content['navigation']['social_media']['youtube'] ?? ''); ?>"
                                           placeholder="https://www.youtube.com/... (optional)">
                                    <div class="form-text">Your YouTube channel URL (optional)</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="twitter_url" class="form-label">
                                        <i class="fab fa-twitter text-info me-1"></i>
                                        <strong>Twitter/X URL</strong>
                                    </label>
                                    <input type="url" class="form-control" id="twitter_url" name="twitter_url" 
                                           value="<?php echo htmlspecialchars($content['navigation']['social_media']['twitter'] ?? ''); ?>"
                                           placeholder="https://twitter.com/... (optional)">
                                    <div class="form-text">Your Twitter/X profile URL (optional)</div>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-kaizen">
                            <i class="fas fa-save me-2"></i>Update Social Media Links
                        </button>
                    </form>
                </div>
                
                <!-- Main Navigation Menu -->
                <div class="content-section">
                    <h3 class="section-title"><i class="fas fa-list me-2"></i>Main Navigation Menu</h3>
                    <form method="POST">
                        <input type="hidden" name="menu_items" value="1">
                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                        
                        <div id="menu-items-container">
                            <?php 
                            // Default menu items if none exist
                            if (empty($menu_items)) {
                                $menu_items = [
                                    ['text' => 'About', 'href' => '#about'],
                                    ['text' => 'Summer Camp', 'href' => '#summer-camp'],
                                    ['text' => 'Kaizen Dojo', 'href' => '#kaizen-dojo'],
                                    ['text' => 'Weekend & Evening', 'href' => '#after-school'],
                                    ['text' => 'Online Store', 'href' => '#online-store'],
                                    ['text' => 'Belt Exam', 'href' => '#belt-exam'],
                                    ['text' => 'Kaizen Kenpo', 'href' => '#kaizen-kenpo'],
                                    ['text' => 'Contact', 'href' => '#contact']
                                ];
                            }
                            
                            foreach ($menu_items as $index => $item): 
                            ?>
                            <div class="menu-item">
                                <div class="row align-items-center">
                                    <div class="col-md-1 text-center">
                                        <i class="fas fa-grip-vertical text-muted" style="cursor: move;"></i>
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label">Menu Text</label>
                                        <input type="text" class="form-control" name="menu_text[]" 
                                               value="<?php echo htmlspecialchars($item['text']); ?>" 
                                               placeholder="Menu item text">
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label">Link (href)</label>
                                        <input type="text" class="form-control" name="menu_href[]" 
                                               value="<?php echo htmlspecialchars($item['href']); ?>" 
                                               placeholder="#section-id or URL">
                                    </div>
                                    <div class="col-md-1 text-center">
                                        <button type="button" class="btn btn-sm btn-danger" onclick="removeMenuItem(this)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="mt-3">
                            <button type="button" class="btn btn-outline-primary" onclick="addMenuItem()">
                                <i class="fas fa-plus me-2"></i>Add Menu Item
                            </button>
                        </div>
                        
                        <hr class="my-4">
                        
                        <button type="submit" class="btn btn-kaizen">
                            <i class="fas fa-save me-2"></i>Update Main Menu
                        </button>
                    </form>
                </div>
                
                <!-- Instructions -->
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Navigation Instructions</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Register Dropdown</h6>
                                <ul>
                                    <li>This appears as the main "Register Now" button</li>
                                    <li>Contains registration links for all programs</li>
                                    <li>Summer Camp and Belt Exams have flexible display modes</li>
                                    <li>After School and Kaizen Dojo have direct registration buttons</li>
                                </ul>
                                
                                <h6 class="mt-4">Main Menu Items</h6>
                                <ul>
                                    <li><strong>Dynamic Display:</strong> All menu items appear on both desktop and mobile navigation</li>
                                    <li><strong>Add Items:</strong> Click "+ Add Menu Item" to add unlimited navigation links</li>
                                    <li><strong>Remove Items:</strong> Click the trash icon to remove any menu item</li>
                                    <li><strong>External Links:</strong> URLs starting with http:// or https:// automatically open in new windows</li>
                                    <li><strong>Order:</strong> Menu items display in the order shown (drag to reorder coming soon)</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6>Available Internal Links</h6>
                                <p class="text-muted mb-2"><strong>Page Sections (Anchors):</strong></p>
                                <ul class="list-unstyled">
                                    <li><code>#about</code> - About section</li>
                                    <li><code>#summer-camp</code> - Summer Camp information</li>
                                    <li><code>#kaizen-dojo</code> - Kaizen Dojo program</li>
                                    <li><code>#after-school</code> - After School/Weekend & Evening programs</li>
                                    <li><code>#online-store</code> - Online Store section</li>
                                    <li><code>#belt-exam</code> - Belt Examination information</li>
                                    <li><code>#kaizen-kenpo</code> - Kaizen Kenpo section</li>
                                    <li><code>#contact</code> - Contact form section</li>
                                    <li><code>#training-options</code> - Training options overview</li>
                                </ul>
                                
                                <p class="text-muted mb-2"><strong>Additional Pages:</strong></p>
                                <ul class="list-unstyled">
                                    <li><code>faq.php</code> - Frequently Asked Questions</li>
                                    <li><code>policies.php</code> - Policies page</li>
                                    <li><code>student-handbook.php</code> - Student Handbook</li>
                                </ul>
                                
                                <h6 class="mt-4">External Links</h6>
                                <ul>
                                    <li>Use full URLs for external websites (e.g., <code>https://example.com</code>)</li>
                                    <li>External links automatically open in new browser windows</li>
                                    <li>Include https:// or http:// for external links</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="alert alert-success mt-3" role="alert">
                            <i class="fas fa-lightbulb me-2"></i>
                            <strong>Tip:</strong> Menu items are immediately visible on the public website after saving. Both desktop and mobile navigation automatically display all items you add.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function addMenuItem() {
            const container = document.getElementById('menu-items-container');
            const newItem = document.createElement('div');
            newItem.className = 'menu-item';
            newItem.innerHTML = `
                <div class="row align-items-center">
                    <div class="col-md-1 text-center">
                        <i class="fas fa-grip-vertical text-muted" style="cursor: move;"></i>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Menu Text</label>
                        <input type="text" class="form-control" name="menu_text[]" placeholder="Menu item text">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Link (href)</label>
                        <input type="text" class="form-control" name="menu_href[]" placeholder="#section-id or URL">
                    </div>
                    <div class="col-md-1 text-center">
                        <button type="button" class="btn btn-sm btn-danger" onclick="removeMenuItem(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(newItem);
        }
        
        function removeMenuItem(button) {
            button.closest('.menu-item').remove();
        }
        
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
                
                // Validate file size (2MB limit)
                if (file.size > 2 * 1024 * 1024) {
                    alert('File size too large. Please select an image under 2MB.');
                    input.value = '';
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (preview.tagName === 'IMG') {
                        preview.src = e.target.result;
                    } else {
                        // Replace placeholder div with image
                        preview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="img-fluid border rounded" style="max-height: 120px; max-width: 100%;">`;
                    }
                };
                reader.readAsDataURL(file);
            }
        }
        
        function toggleSummerCampFields() {
            const displayMode = document.getElementById('summer_camp_display_mode').value;
            const informationFields = document.getElementById('information_fields');
            const buttonFields = document.getElementById('button_fields');
            
            if (displayMode === 'button') {
                informationFields.style.display = 'none';
                buttonFields.style.display = 'block';
            } else {
                informationFields.style.display = 'block';
                buttonFields.style.display = 'none';
            }
        }
        
        function toggleBeltExamsFields() {
            const displayMode = document.getElementById('belt_exams_display_mode').value;
            const simpleFields = document.getElementById('simple_belt_fields');
            const multipleFields = document.getElementById('multiple_belt_fields');
            
            if (displayMode === 'multiple') {
                simpleFields.style.display = 'none';
                multipleFields.style.display = 'block';
            } else {
                simpleFields.style.display = 'block';
                multipleFields.style.display = 'none';
            }
        }
        
        function updateBeltExamButtons() {
            const numButtons = parseInt(document.getElementById('belt_exams_num_buttons').value);
            
            for (let i = 1; i <= 3; i++) {
                const buttonGroup = document.getElementById('exam_button_' + i);
                if (i <= numButtons) {
                    buttonGroup.style.display = 'block';
                } else {
                    buttonGroup.style.display = 'none';
                }
            }
        }
    </script>
</body>
</html>