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
        // Update Header content
        if (isset($_POST['header_section'])) {
            $content = load_json_data('site-content');
            
            // Update hero section in site content
            $content['hero_section'] = [
                'title' => sanitize_input($_POST['hero_title']),
                'quote' => sanitize_input($_POST['hero_quote']),
                'subtitle' => sanitize_input($_POST['hero_subtitle']),
                'button_text' => sanitize_input($_POST['hero_button_text']),
                'registration_panel' => [
                    'after_school' => [
                        'header_line1' => sanitize_input($_POST['hero_after_school_line1']),
                        'header_line2' => sanitize_input($_POST['hero_after_school_line2']),
                        'button' => sanitize_input($_POST['hero_after_school_button']),
                        'url' => sanitize_input($_POST['hero_after_school_url'])
                    ],
                    'kaizen_dojo' => [
                        'header' => sanitize_input($_POST['hero_kaizen_dojo_header']),
                        'button' => sanitize_input($_POST['hero_kaizen_dojo_button']),
                        'url' => sanitize_input($_POST['hero_kaizen_dojo_url'])
                    ],
                    'summer_camp' => [
                        'header' => sanitize_input($_POST['hero_summer_camp_header']),
                        'display_mode' => sanitize_input($_POST['hero_summer_camp_display_mode']),
                        'text' => sanitize_input($_POST['hero_summer_camp_text']),
                        'link_text' => sanitize_input($_POST['hero_summer_camp_link_text']),
                        'link_url' => sanitize_input($_POST['hero_summer_camp_link_url']),
                        'button' => sanitize_input($_POST['hero_summer_camp_button']),
                        'url' => sanitize_input($_POST['hero_summer_camp_url'])
                    ],
                    'belt_exams' => [
                        'header' => sanitize_input($_POST['hero_belt_exams_header']),
                        'display_mode' => sanitize_input($_POST['hero_belt_exams_display_mode']),
                        'button' => sanitize_input($_POST['hero_belt_exams_button']),
                        'url' => sanitize_input($_POST['hero_belt_exams_url']),
                        'num_buttons' => sanitize_input($_POST['hero_belt_exams_num_buttons']),
                        'exam_buttons' => []
                    ]
                ]
            ];
            
            // Process Belt Exam buttons for multiple mode
            if ($content['hero_section']['registration_panel']['belt_exams']['display_mode'] === 'multiple') {
                $num_buttons = intval($content['hero_section']['registration_panel']['belt_exams']['num_buttons']);
                for ($i = 1; $i <= $num_buttons; $i++) {
                    $content['hero_section']['registration_panel']['belt_exams']['exam_buttons'][] = [
                        'line1' => sanitize_input($_POST["hero_belt_exam_button_{$i}_line1"]),
                        'line2' => sanitize_input($_POST["hero_belt_exam_button_{$i}_line2"]),
                        'line3' => sanitize_input($_POST["hero_belt_exam_button_{$i}_line3"]),
                        'url' => sanitize_input($_POST["hero_belt_exam_button_{$i}_url"])
                    ];
                }
            }
            
            // Update hero video in media content
            $media_content = load_json_data('media');
            
            // Handle hero video upload
            $video_source_path = sanitize_input($_POST['hero_video_source']);
            if (isset($_FILES['hero_video_upload']) && $_FILES['hero_video_upload']['error'] === UPLOAD_ERR_OK) {
                $upload_result = handle_file_upload('hero_video_upload', 'video', '../assets/videos/hero/');
                if ($upload_result['success']) {
                    $video_source_path = $upload_result['path'];
                    $message = success_message('Hero video uploaded successfully!');
                } else {
                    $message = error_message('Hero video upload failed: ' . $upload_result['error']);
                }
            }
            
            // Handle poster image upload
            $poster_path = sanitize_input($_POST['hero_video_poster']);
            if (isset($_FILES['hero_poster_upload']) && $_FILES['hero_poster_upload']['error'] === UPLOAD_ERR_OK) {
                $upload_result = handle_file_upload('hero_poster_upload', 'image', '../assets/images/hero/');
                if ($upload_result['success']) {
                    $poster_path = $upload_result['path'];
                    $message = success_message('Hero poster image uploaded successfully!');
                } else {
                    $message = error_message('Poster image upload failed: ' . $upload_result['error']);
                }
            }
            
            $media_content['hero_video'] = [
                'source' => $video_source_path,
                'poster' => $poster_path,
                'alt' => sanitize_input($_POST['hero_video_alt'])
            ];
            
            if (save_json_data('site-content', $content) && save_json_data('media', $media_content)) {
                $message = success_message('Header updated successfully!');
            } else {
                $message = error_message('Failed to save changes.');
            }
        }
    }
}

// Load current content
$content = load_json_data('site-content');
$hero_section = $content['hero_section'] ?? [];

// Load media content for hero video
$media_content = load_json_data('media');
$hero_video = $media_content['hero_video'] ?? [];

$csrf_token = generate_csrf_token();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header Management - Kaizen Karate Admin</title>
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
        .form-select:focus { border-color: var(--kaizen-primary); box-shadow: 0 0 0 0.2rem rgba(164, 51, 43, 0.25); }
        .upload-area { border: 2px dashed #dee2e6; border-radius: 8px; padding: 2rem; text-align: center; background: #f8f9fa; transition: all 0.3s ease; }
        .upload-area:hover { border-color: var(--kaizen-primary); background: #fff; }
        .upload-area.drag-over { border-color: var(--kaizen-primary); background: rgba(164, 51, 43, 0.1); }
        .preview-container { max-width: 300px; border: 2px solid #e9ecef; border-radius: 8px; overflow: hidden; }
        .video-preview { background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; }
        .alert-kaizen { background-color: rgba(164, 51, 43, 0.1); border-color: var(--kaizen-primary); color: var(--kaizen-secondary); }
        
        .section-title {
            color: var(--kaizen-primary);
            margin-bottom: 1.5rem;
            font-weight: 600;
        }
        
        .video-preview {
            min-height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
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
                    <h1><i class="fas fa-video me-2 text-primary"></i>Header & Hero Management</h1>
                </div>
                
                <?php echo $message; ?>
                
                <!-- Header Section -->
                <div class="content-section">
                    <h3 class="section-title"><i class="fas fa-video me-2"></i>Header & Hero Section</h3>
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="header_section" value="1">
                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                        
                        <!-- Hero Video Settings -->
                        <div class="mb-4 p-3 border rounded bg-light">
                            <h5 class="text-primary mb-3"><i class="fas fa-play-circle me-2"></i>Background Video</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Upload New Video</strong></label>
                                        <input type="file" class="form-control" name="hero_video_upload" 
                                               accept="video/*" onchange="previewVideo(this, 'hero-video-preview')">
                                        <div class="form-text">Upload MP4, WebM, or OGG (max 2MB for testing, larger files via FTP)</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="hero_video_source" class="form-label"><strong>Or Enter Path Manually</strong></label>
                                        <input type="text" class="form-control" id="hero_video_source" name="hero_video_source" 
                                               value="<?php echo htmlspecialchars($hero_video['source'] ?? 'assets/videos/hero/kaizen-hero-video.mp4'); ?>"
                                               placeholder="e.g., assets/videos/hero/kaizen-hero-video.mp4">
                                        <div class="form-text">Advanced: Direct path to video file</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Upload Poster Image</strong></label>
                                        <input type="file" class="form-control" name="hero_poster_upload" 
                                               accept="image/*" onchange="previewImage(this, 'hero-poster-preview')">
                                        <div class="form-text">Upload poster image (JPG, PNG, WebP - max 2MB)</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="hero_video_poster" class="form-label"><strong>Or Enter Poster Path Manually</strong></label>
                                        <input type="text" class="form-control" id="hero_video_poster" name="hero_video_poster" 
                                               value="<?php echo htmlspecialchars($hero_video['poster'] ?? ''); ?>"
                                               placeholder="e.g., assets/images/hero-poster.jpg">
                                        <div class="form-text">Advanced: Direct path to poster image (optional)</div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="hero_video_alt" class="form-label"><strong>Video Alt Text</strong></label>
                                <input type="text" class="form-control" id="hero_video_alt" name="hero_video_alt" 
                                       value="<?php echo htmlspecialchars($hero_video['alt'] ?? 'Kaizen Karate Hero Video'); ?>"
                                       placeholder="e.g., Kaizen Karate Hero Video">
                                <div class="form-text">Alternative text for accessibility</div>
                            </div>
                            
                            <!-- Poster Preview -->
                            <?php if (!empty($hero_video['poster'])): ?>
                            <div class="mb-3">
                                <label class="form-label"><strong>Current Poster Image</strong></label>
                                <div>
                                    <img id="hero-poster-preview" src="../<?php echo htmlspecialchars($hero_video['poster']); ?>" 
                                         alt="Hero Poster Preview" class="img-fluid border rounded" 
                                         style="max-height: 150px; max-width: 100%;">
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Video Preview -->
                        <div class="mb-4">
                            <h5 class="text-primary mb-3"><i class="fas fa-eye me-2"></i>Current Video Preview</h5>
                            <div class="video-preview bg-light p-3 rounded border">
                                <?php if (!empty($hero_video['source'])): ?>
                                    <video width="400" height="225" controls poster="<?php echo htmlspecialchars($hero_video['poster']); ?>"
                                           style="max-width: 100%;">
                                        <source src="../<?php echo htmlspecialchars($hero_video['source']); ?>" type="video/mp4">
                                        <div style="color: #dc3545;">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            Video not supported or not found: <?php echo htmlspecialchars($hero_video['source']); ?>
                                        </div>
                                    </video>
                                <?php else: ?>
                                    <div class="text-muted">
                                        <i class="fas fa-video me-2"></i>
                                        No video configured
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Hero Content Settings -->
                        <div class="mb-4">
                            <h5 class="text-primary mb-3"><i class="fas fa-text-height me-2"></i>Hero Content</h5>
                            <div class="mb-3">
                                <label for="hero_title" class="form-label"><strong>Main Title</strong></label>
                                <input type="text" class="form-control" id="hero_title" name="hero_title" 
                                       value="<?php echo htmlspecialchars($hero_section['title'] ?? 'KAIZEN KARATE'); ?>"
                                       placeholder="e.g., KAIZEN KARATE">
                                <div class="form-text">Main headline displayed over the video</div>
                            </div>
                            <div class="mb-3">
                                <label for="hero_quote" class="form-label"><strong>Quote</strong></label>
                                <textarea class="form-control" id="hero_quote" name="hero_quote" rows="2"
                                          placeholder="e.g., Discipline is not about being told what to do. It is about learning how to choose what matters."><?php echo htmlspecialchars($hero_section['quote'] ?? 'Discipline is not about being told what to do. It is about learning how to choose what matters.'); ?></textarea>
                                <div class="form-text">Inspirational quote displayed prominently</div>
                            </div>
                            <div class="mb-3">
                                <label for="hero_subtitle" class="form-label"><strong>Subtitle</strong></label>
                                <textarea class="form-control" id="hero_subtitle" name="hero_subtitle" rows="4"
                                          placeholder="e.g., Kaizen Karate has offered martial arts instruction since 2003..."><?php echo htmlspecialchars($hero_section['subtitle'] ?? 'Kaizen Karate has offered martial arts instruction since 2003. Founded by Coach V, we specialize in karate instruction for children of all ages in the Washington DC, Maryland, Northern Virginia, and New York areas. We also offer karate programs for adults with a focus on fitness and self-defense.'); ?></textarea>
                                <div class="form-text">Detailed description about your karate school</div>
                            </div>
                            <div class="mb-3">
                                <label for="hero_button_text" class="form-label"><strong>Hero Button Text</strong></label>
                                <input type="text" class="form-control" id="hero_button_text" name="hero_button_text" 
                                       value="<?php echo htmlspecialchars($hero_section['button_text'] ?? 'Register Now'); ?>"
                                       placeholder="e.g., Register Now">
                                <div class="form-text"><i class="fas fa-lightbulb text-warning me-1"></i>This text appears on the hero button that opens the registration panel</div>
                            </div>
                        </div>
                        
                        <!-- Hero Registration Panel Settings -->
                        <div class="mb-4">
                            <h5 class="text-primary mb-3"><i class="fas fa-clipboard-list me-2"></i>Hero Registration Panel</h5>
                            <div class="alert alert-kaizen border-0">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Hero Registration Panel:</strong> This controls the registration panel that slides down when users click the hero "Register Now" button. This is completely separate from the navigation register dropdown and can be customized independently.
                            </div>
                            
                            <!-- After School Column -->
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-school me-2"></i>After School Column</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Header Line 1</label>
                                                <input type="text" class="form-control" name="hero_after_school_line1" 
                                                       value="<?php echo htmlspecialchars($hero_section['registration_panel']['after_school']['header_line1'] ?? 'AFTER SCHOOL'); ?>"
                                                       placeholder="e.g., AFTER SCHOOL">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Header Line 2</label>
                                                <input type="text" class="form-control" name="hero_after_school_line2" 
                                                       value="<?php echo htmlspecialchars($hero_section['registration_panel']['after_school']['header_line2'] ?? 'WEEKEND & EVENING'); ?>"
                                                       placeholder="e.g., WEEKEND & EVENING">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Button Text</label>
                                                <input type="text" class="form-control" name="hero_after_school_button" 
                                                       value="<?php echo htmlspecialchars($hero_section['registration_panel']['after_school']['button'] ?? 'Register Now!'); ?>"
                                                       placeholder="e.g., Register Now!">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Registration URL</label>
                                                <input type="url" class="form-control" name="hero_after_school_url" 
                                                       value="<?php echo htmlspecialchars($hero_section['registration_panel']['after_school']['url'] ?? 'https://www.gomotionapp.com/team/mdkfu/page/class-registration'); ?>"
                                                       placeholder="https://www.gomotionapp.com/team/mdkfu/page/class-registration">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Kaizen Dojo Column -->
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-home me-2"></i>Kaizen Dojo Column</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Header</label>
                                                <input type="text" class="form-control" name="hero_kaizen_dojo_header" 
                                                       value="<?php echo htmlspecialchars($hero_section['registration_panel']['kaizen_dojo']['header'] ?? 'KAIZEN DOJO'); ?>"
                                                       placeholder="e.g., KAIZEN DOJO">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Button Text</label>
                                                <input type="text" class="form-control" name="hero_kaizen_dojo_button" 
                                                       value="<?php echo htmlspecialchars($hero_section['registration_panel']['kaizen_dojo']['button'] ?? 'Register Now!'); ?>"
                                                       placeholder="e.g., Register Now!">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Registration URL</label>
                                                <input type="url" class="form-control" name="hero_kaizen_dojo_url" 
                                                       value="<?php echo htmlspecialchars($hero_section['registration_panel']['kaizen_dojo']['url'] ?? 'https://form.jotform.com/251533593606459'); ?>"
                                                       placeholder="https://form.jotform.com/251533593606459">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Summer Camp Column -->
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-sun me-2"></i>Summer Camp Column</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Header</label>
                                        <input type="text" class="form-control" name="hero_summer_camp_header" 
                                               value="<?php echo htmlspecialchars($hero_section['registration_panel']['summer_camp']['header'] ?? 'Summer Camp'); ?>"
                                               placeholder="e.g., Summer Camp">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Display Mode</label>
                                        <select class="form-select" name="hero_summer_camp_display_mode" id="heroSummerCampDisplayMode">
                                            <option value="information" <?php echo (($hero_section['registration_panel']['summer_camp']['display_mode'] ?? 'information') === 'information') ? 'selected' : ''; ?>>Information Text with Link</option>
                                            <option value="button" <?php echo (($hero_section['registration_panel']['summer_camp']['display_mode'] ?? 'information') === 'button') ? 'selected' : ''; ?>>Registration Button</option>
                                        </select>
                                        <div class="form-text"><i class="fas fa-toggle-on text-info me-1"></i>Information mode shows text with a link, Button mode shows a direct registration button</div>
                                    </div>
                                    
                                    <!-- Information Mode Fields -->
                                    <div class="hero-summer-camp-info-fields">
                                        <div class="mb-3">
                                            <label class="form-label">Information Text</label>
                                            <textarea class="form-control" name="hero_summer_camp_text" rows="2"
                                                      placeholder="e.g., Registration for Summer Camp 2026 has not opened yet."><?php echo htmlspecialchars($hero_section['registration_panel']['summer_camp']['text'] ?? 'Registration for Summer Camp 2026 has not opened yet.'); ?></textarea>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Link Text</label>
                                                    <input type="text" class="form-control" name="hero_summer_camp_link_text" 
                                                           value="<?php echo htmlspecialchars($hero_section['registration_panel']['summer_camp']['link_text'] ?? 'Explore our 2025 Summer Camp program!'); ?>"
                                                           placeholder="e.g., Explore our 2025 Summer Camp program!">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Link URL</label>
                                                    <input type="text" class="form-control" name="hero_summer_camp_link_url" 
                                                           value="<?php echo htmlspecialchars($hero_section['registration_panel']['summer_camp']['link_url'] ?? '#summer-camp'); ?>"
                                                           placeholder="e.g., #summer-camp">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Button Mode Fields -->
                                    <div class="hero-summer-camp-button-fields">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Button Text</label>
                                                    <input type="text" class="form-control" name="hero_summer_camp_button" 
                                                           value="<?php echo htmlspecialchars($hero_section['registration_panel']['summer_camp']['button'] ?? 'Register Now!'); ?>"
                                                           placeholder="e.g., Register Now!">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Registration URL</label>
                                                    <input type="text" class="form-control" name="hero_summer_camp_url" 
                                                           value="<?php echo htmlspecialchars($hero_section['registration_panel']['summer_camp']['url'] ?? '#summer-camp'); ?>"
                                                           placeholder="e.g., https://example.com/register or #summer-camp">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Belt Exams Column -->
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-medal me-2"></i>Belt Exams Column</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Header</label>
                                        <input type="text" class="form-control" name="hero_belt_exams_header" 
                                               value="<?php echo htmlspecialchars($hero_section['registration_panel']['belt_exams']['header'] ?? 'Belt Exams'); ?>"
                                               placeholder="e.g., Belt Exams">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Display Mode</label>
                                        <select class="form-select" name="hero_belt_exams_display_mode" id="heroBeltExamsDisplayMode">
                                            <option value="simple" <?php echo (($hero_section['registration_panel']['belt_exams']['display_mode'] ?? 'simple') === 'simple') ? 'selected' : ''; ?>>Simple Button</option>
                                            <option value="multiple" <?php echo (($hero_section['registration_panel']['belt_exams']['display_mode'] ?? 'simple') === 'multiple') ? 'selected' : ''; ?>>Multiple Exam Buttons</option>
                                        </select>
                                        <div class="form-text"><i class="fas fa-toggle-on text-info me-1"></i>Simple shows one button, Multiple allows specific exam buttons with dates and details</div>
                                    </div>
                                    
                                    <!-- Simple Mode Fields -->
                                    <div class="hero-belt-exams-simple-fields">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Button Text</label>
                                                    <input type="text" class="form-control" name="hero_belt_exams_button" 
                                                           value="<?php echo htmlspecialchars($hero_section['registration_panel']['belt_exams']['button'] ?? 'Register Now!'); ?>"
                                                           placeholder="e.g., Register Now!">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Registration URL</label>
                                                    <input type="text" class="form-control" name="hero_belt_exams_url" 
                                                           value="<?php echo htmlspecialchars($hero_section['registration_panel']['belt_exams']['url'] ?? ''); ?>"
                                                           placeholder="e.g., https://example.com/register or leave empty for scroll to belt exam section">
                                                    <div class="form-text"><i class="fas fa-link text-success me-1"></i>Leave empty or use # to automatically scroll to the belt exam section on your page</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Multiple Mode Fields -->
                                    <div class="hero-belt-exams-multiple-fields">
                                        <div class="mb-3">
                                            <label class="form-label">Number of Exam Buttons</label>
                                            <select class="form-select" name="hero_belt_exams_num_buttons" id="heroBeltExamsNumButtons">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <option value="<?php echo $i; ?>" <?php echo (($hero_section['registration_panel']['belt_exams']['num_buttons'] ?? '1') == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                        
                                        <div id="heroBeltExamButtonsContainer">
                                            <?php 
                                            $exam_buttons = $hero_section['registration_panel']['belt_exams']['exam_buttons'] ?? [];
                                            $num_buttons = intval($hero_section['registration_panel']['belt_exams']['num_buttons'] ?? 1);
                                            for ($i = 1; $i <= $num_buttons; $i++): 
                                                $button = $exam_buttons[$i-1] ?? [];
                                            ?>
                                            <div class="hero-exam-button-group mb-3 p-3 border rounded">
                                                <h6>Exam Button <?php echo $i; ?></h6>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="mb-2">
                                                            <label class="form-label">Line 1</label>
                                                            <input type="text" class="form-control" name="hero_belt_exam_button_<?php echo $i; ?>_line1" 
                                                                   value="<?php echo htmlspecialchars($button['line1'] ?? 'REGISTER!'); ?>"
                                                                   placeholder="e.g., REGISTER!">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-2">
                                                            <label class="form-label">Line 2</label>
                                                            <input type="text" class="form-control" name="hero_belt_exam_button_<?php echo $i; ?>_line2" 
                                                                   value="<?php echo htmlspecialchars($button['line2'] ?? 'Youth Exam'); ?>"
                                                                   placeholder="e.g., Youth Exam">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-2">
                                                            <label class="form-label">Line 3</label>
                                                            <input type="text" class="form-control" name="hero_belt_exam_button_<?php echo $i; ?>_line3" 
                                                                   value="<?php echo htmlspecialchars($button['line3'] ?? 'Saturday, Nov 15th'); ?>"
                                                                   placeholder="e.g., Saturday, Nov 15th">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-2">
                                                            <label class="form-label">URL</label>
                                                            <input type="text" class="form-control" name="hero_belt_exam_button_<?php echo $i; ?>_url" 
                                                                   value="<?php echo htmlspecialchars($button['url'] ?? ''); ?>"
                                                                   placeholder="Leave empty for scroll">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-kaizen">
                            <i class="fas fa-save me-2"></i>Update Header
                        </button>
                    </form>
                </div>
                
                <!-- Usage Instructions -->
                <div class="content-section">
                    <h3 class="section-title"><i class="fas fa-info-circle me-2"></i>Header Management Instructions</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="fas fa-video me-2 text-primary"></i>Video Settings</h6>
                            <ul class="list-unstyled mb-4">
                                <li class="mb-2"><i class="fas fa-upload text-muted me-2"></i>Use Upload for small test videos (under 2MB)</li>
                                <li class="mb-2"><i class="fas fa-folder text-muted me-2"></i>Use FTP for production videos over 2MB</li>
                                <li class="mb-2"><i class="fas fa-image text-muted me-2"></i>Always include poster images for faster loading</li>
                                <li class="mb-2"><i class="fas fa-mobile text-muted me-2"></i>Test video playback on mobile devices</li>
                            </ul>
                            
                            <h6><i class="fas fa-text-height me-2 text-primary"></i>Content Guidelines</h6>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2"><i class="fas fa-check text-muted me-2"></i>Keep titles concise and impactful</li>
                                <li class="mb-2"><i class="fas fa-check text-muted me-2"></i>Use quotes that inspire and motivate</li>
                                <li class="mb-2"><i class="fas fa-check text-muted me-2"></i>Ensure mobile readability</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-clipboard-list me-2 text-primary"></i>Hero Registration Panel</h6>
                            <ul class="list-unstyled mb-4">
                                <li class="mb-2"><i class="fas fa-info-circle text-muted me-2"></i>This panel is separate from navigation register dropdown</li>
                                <li class="mb-2"><i class="fas fa-edit text-muted me-2"></i>Each column can be customized independently</li>
                                <li class="mb-2"><i class="fas fa-toggle-on text-muted me-2"></i>Summer Camp and Belt Exams have display modes</li>
                                <li class="mb-2"><i class="fas fa-external-link-alt text-muted me-2"></i>External URLs automatically open in new windows</li>
                            </ul>
                            
                            <h6><i class="fas fa-sync me-2 text-primary"></i>Best Practices</h6>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2"><i class="fas fa-eye text-muted me-2"></i>Preview changes on your public site</li>
                                <li class="mb-2"><i class="fas fa-clock text-muted me-2"></i>Changes appear immediately after saving</li>
                                <li class="mb-2"><i class="fas fa-shield-alt text-muted me-2"></i>Always test forms before going live</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
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
                    if (preview) {
                        if (preview.tagName === 'IMG') {
                            preview.src = e.target.result;
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
                    alert('File size too large for web upload. For videos larger than 2MB, please use FTP to upload to assets/videos/hero/ directory.');
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
        
        // Hero Registration Panel Display Mode Toggles
        function toggleHeroSummerCampFields() {
            const mode = document.getElementById('heroSummerCampDisplayMode').value;
            const infoFields = document.querySelector('.hero-summer-camp-info-fields');
            const buttonFields = document.querySelector('.hero-summer-camp-button-fields');
            
            if (mode === 'information') {
                infoFields.style.display = 'block';
                buttonFields.style.display = 'none';
            } else {
                infoFields.style.display = 'none';
                buttonFields.style.display = 'block';
            }
        }
        
        function toggleHeroBeltExamsFields() {
            const mode = document.getElementById('heroBeltExamsDisplayMode').value;
            const simpleFields = document.querySelector('.hero-belt-exams-simple-fields');
            const multipleFields = document.querySelector('.hero-belt-exams-multiple-fields');
            
            if (mode === 'simple') {
                simpleFields.style.display = 'block';
                multipleFields.style.display = 'none';
            } else {
                simpleFields.style.display = 'none';
                multipleFields.style.display = 'block';
            }
        }
        
        function updateHeroBeltExamButtons() {
            const numButtons = parseInt(document.getElementById('heroBeltExamsNumButtons').value);
            const container = document.getElementById('heroBeltExamButtonsContainer');
            
            // Clear existing buttons
            container.innerHTML = '';
            
            // Add new buttons
            for (let i = 1; i <= numButtons; i++) {
                const buttonGroup = document.createElement('div');
                buttonGroup.className = 'hero-exam-button-group mb-3 p-3 border rounded';
                buttonGroup.innerHTML = `
                    <h6>Exam Button ${i}</h6>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-2">
                                <label class="form-label">Line 1</label>
                                <input type="text" class="form-control" name="hero_belt_exam_button_${i}_line1" 
                                       value="REGISTER!" placeholder="e.g., REGISTER!">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-2">
                                <label class="form-label">Line 2</label>
                                <input type="text" class="form-control" name="hero_belt_exam_button_${i}_line2" 
                                       value="Youth Exam" placeholder="e.g., Youth Exam">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-2">
                                <label class="form-label">Line 3</label>
                                <input type="text" class="form-control" name="hero_belt_exam_button_${i}_line3" 
                                       value="Saturday, Nov 15th" placeholder="e.g., Saturday, Nov 15th">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-2">
                                <label class="form-label">URL</label>
                                <input type="text" class="form-control" name="hero_belt_exam_button_${i}_url" 
                                       value="" placeholder="Leave empty for scroll">
                            </div>
                        </div>
                    </div>
                `;
                container.appendChild(buttonGroup);
            }
        }
        
        // Initialize display modes and event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Set up Summer Camp display mode toggle
            const summerCampMode = document.getElementById('heroSummerCampDisplayMode');
            if (summerCampMode) {
                summerCampMode.addEventListener('change', toggleHeroSummerCampFields);
                toggleHeroSummerCampFields(); // Set initial state
            }
            
            // Set up Belt Exams display mode toggle
            const beltExamsMode = document.getElementById('heroBeltExamsDisplayMode');
            if (beltExamsMode) {
                beltExamsMode.addEventListener('change', toggleHeroBeltExamsFields);
                toggleHeroBeltExamsFields(); // Set initial state
            }
            
            // Set up Belt Exams number of buttons
            const numButtons = document.getElementById('heroBeltExamsNumButtons');
            if (numButtons) {
                numButtons.addEventListener('change', updateHeroBeltExamButtons);
            }
        });
    </script>
</body>
</html>