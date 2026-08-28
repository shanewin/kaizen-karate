<?php
define('KAIZEN_ADMIN', true);
session_start();
require_once 'config.php';

// Require login
require_login();

$message = '';
$active_tab = $_GET['tab'] ?? 'about';

// Handle form submissions
if ($_POST) {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $message = error_message('Security token invalid. Please try again.');
    } else {
        $content = load_json_data('site-content', 'draft');
        $section = $_POST['section'] ?? '';
        
        switch ($section) {
            case 'about':
                $content['about_section']['title'] = sanitize_input($_POST['about_title']);
                $content['about_section']['subtitle'] = sanitize_input($_POST['about_subtitle']);
                $content['about_section']['main_title'] = sanitize_input($_POST['about_main_title']);
                break;
                
            case 'summer_camp':
                $content['summer_camp']['title'] = sanitize_input($_POST['camp_title']);
                $content['summer_camp']['subtitle'] = sanitize_input($_POST['camp_subtitle']);
                $content['summer_camp']['section_title'] = sanitize_input($_POST['camp_section_title']);
                $content['summer_camp']['description'] = sanitize_input($_POST['camp_description']);
                $content['summer_camp']['note'] = sanitize_input($_POST['camp_note']);
                
                // Handle features
                $features = explode("\n", $_POST['camp_features']);
                $content['summer_camp']['features'] = array_map('trim', array_filter($features));
                
                // Handle camp weeks
                if (isset($_POST['week_dates'])) {
                    $weeks = [];
                    foreach ($_POST['week_dates'] as $index => $dates) {
                        if (!empty($dates)) {
                            $weeks[] = [
                                'dates' => sanitize_input($dates),
                                'theme' => sanitize_input($_POST['week_theme'][$index]),
                                'description' => sanitize_input($_POST['week_description'][$index])
                            ];
                        }
                    }
                    $content['summer_camp']['camp_weeks']['weeks'] = $weeks;
                    $content['summer_camp']['camp_weeks']['title'] = sanitize_input($_POST['weeks_title']);
                    $content['summer_camp']['camp_weeks']['note'] = sanitize_input($_POST['weeks_note']);
                }
                break;
                
            case 'kaizen_dojo':
                $content['kaizen_dojo']['title'] = sanitize_input($_POST['dojo_title']);
                $content['kaizen_dojo']['subtitle'] = sanitize_input($_POST['dojo_subtitle']);
                $content['kaizen_dojo']['button'] = sanitize_input($_POST['dojo_button']);
                $content['kaizen_dojo']['button_url'] = sanitize_input($_POST['dojo_button_url']);
                
                // Handle features
                for ($i = 0; $i < 3; $i++) {
                    if (isset($_POST['dojo_feature_title_' . $i])) {
                        $content['kaizen_dojo']['features'][$i]['title'] = sanitize_input($_POST['dojo_feature_title_' . $i]);
                        $content['kaizen_dojo']['features'][$i]['description'] = sanitize_input($_POST['dojo_feature_description_' . $i]);
                        $content['kaizen_dojo']['features'][$i]['icon'] = sanitize_input($_POST['dojo_feature_icon_' . $i]);
                    }
                }
                break;
                
            case 'weekend_evening':
                $content['after_school']['title'] = sanitize_input($_POST['weekend_title']);
                $content['after_school']['subtitle'] = sanitize_input($_POST['weekend_subtitle']);
                $content['after_school']['description'] = sanitize_input($_POST['weekend_description']);
                $content['after_school']['button'] = sanitize_input($_POST['weekend_button']);
                $content['after_school']['button_url'] = sanitize_input($_POST['weekend_button_url']);
                break;
                
            case 'online_store':
                $content['online_store']['title'] = sanitize_input($_POST['store_title']);
                $content['online_store']['subtitle'] = sanitize_input($_POST['store_subtitle']);
                $content['online_store']['button'] = sanitize_input($_POST['store_button']);
                
                $features = explode("\n", $_POST['store_features']);
                $content['online_store']['features'] = array_map('trim', array_filter($features));
                break;
                
            case 'belt_exam':
                $content['belt_exam']['title'] = sanitize_input($_POST['belt_title']);
                $content['belt_exam']['subtitle'] = sanitize_input($_POST['belt_subtitle']);
                
                // Requirements section
                $content['belt_exam']['requirements']['title'] = sanitize_input($_POST['requirements_title']);
                $content['belt_exam']['requirements']['matrix']['title'] = sanitize_input($_POST['matrix_title']);
                $content['belt_exam']['requirements']['matrix']['description'] = sanitize_input($_POST['matrix_description']);
                $content['belt_exam']['requirements']['requirements']['title'] = sanitize_input($_POST['req_title']);
                $content['belt_exam']['requirements']['requirements']['description'] = sanitize_input($_POST['req_description']);
                $content['belt_exam']['requirements']['stripe_system']['title'] = sanitize_input($_POST['stripe_title']);
                $content['belt_exam']['requirements']['stripe_system']['description'] = sanitize_input($_POST['stripe_description']);
                
                // Registration section
                $content['belt_exam']['registration']['title'] = sanitize_input($_POST['reg_title']);
                $content['belt_exam']['registration']['description'] = sanitize_input($_POST['reg_description']);
                $content['belt_exam']['registration']['button'] = sanitize_input($_POST['reg_button']);
                
                // Video test info
                $content['belt_exam']['video_test_info']['title'] = sanitize_input($_POST['video_title']);
                $content['belt_exam']['video_test_info']['covid_note'] = sanitize_input($_POST['covid_note']);
                $content['belt_exam']['video_test_info']['recording_tips'] = sanitize_input($_POST['recording_tips']);
                
                // Important notes
                $notes = explode("\n", $_POST['important_notes']);
                $content['belt_exam']['video_test_info']['important_notes'] = array_map('trim', array_filter($notes));
                break;
                
            case 'kaizen_kenpo':
                $content['kenpo_section']['title'] = sanitize_input($_POST['kenpo_title']);
                $content['kenpo_section']['subtitle'] = sanitize_input($_POST['kenpo_subtitle']);
                $content['kenpo_section']['description'] = sanitize_input($_POST['kenpo_description']);
                $content['kenpo_section']['shuffle_button'] = sanitize_input($_POST['kenpo_shuffle_button']);
                
                // Features
                for ($i = 0; $i < 3; $i++) {
                    if (isset($_POST['kenpo_feature_title_' . $i])) {
                        $content['kenpo_section']['features'][$i]['title'] = sanitize_input($_POST['kenpo_feature_title_' . $i]);
                        $content['kenpo_section']['features'][$i]['icon'] = sanitize_input($_POST['kenpo_feature_icon_' . $i]);
                    }
                }
                break;
        }
        
        if (save_json_data('site-content', $content)) {
            $message = success_message('Section updated successfully!');
        } else {
            $message = error_message('Failed to save changes.');
        }
    }
}

// Load current content
$content = load_json_data('site-content', 'draft');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Sections - Kaizen Karate Admin</title>
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
        .btn-kaizen { background: linear-gradient(45deg, var(--kaizen-primary), var(--kaizen-secondary)); border: none; color: white; padding: 0.75rem 2rem; border-radius: 8px; font-weight: 600; }
        .btn-kaizen:hover { color: white; transform: translateY(-2px); box-shadow: 0 8px 25px rgba(164, 51, 43, 0.3); }
        .form-control:focus, .form-select:focus { border-color: var(--kaizen-primary); box-shadow: 0 0 0 0.2rem rgba(164, 51, 43, 0.25); }
        .nav-tabs .nav-link { color: var(--kaizen-primary); font-weight: 600; border: 2px solid transparent; }
        .nav-tabs .nav-link:hover { border-color: #e9ecef; }
        .nav-tabs .nav-link.active { color: white; background: var(--kaizen-primary); border-color: var(--kaizen-primary); }
        .tab-content { background: white; padding: 2rem; border-radius: 0 8px 8px 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .feature-item { background: #f8f9fa; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; }
        .week-item { background: #fff8f0; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; border: 1px solid #ffd6b3; }
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
                    <h1><i class="fas fa-th-large me-2 text-primary"></i>Page Sections</h1>
                </div>
                
                <?php echo $message; ?>
                
                <!-- Section Tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link <?php echo $active_tab === 'about' ? 'active' : ''; ?>" href="?tab=about">
                            <i class="fas fa-info-circle me-1"></i>About
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $active_tab === 'summer_camp' ? 'active' : ''; ?>" href="?tab=summer_camp">
                            <i class="fas fa-sun me-1"></i>Summer Camp
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $active_tab === 'kaizen_dojo' ? 'active' : ''; ?>" href="?tab=kaizen_dojo">
                            <i class="fas fa-car me-1"></i>Kaizen Dojo
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $active_tab === 'weekend_evening' ? 'active' : ''; ?>" href="?tab=weekend_evening">
                            <i class="fas fa-clock me-1"></i>Weekend & Evening
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $active_tab === 'online_store' ? 'active' : ''; ?>" href="?tab=online_store">
                            <i class="fas fa-shopping-cart me-1"></i>Online Store
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $active_tab === 'belt_exam' ? 'active' : ''; ?>" href="?tab=belt_exam">
                            <i class="fas fa-award me-1"></i>Belt Exam
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $active_tab === 'kaizen_kenpo' ? 'active' : ''; ?>" href="?tab=kaizen_kenpo">
                            <i class="fas fa-fist-raised me-1"></i>Kaizen Kenpo
                        </a>
                    </li>
                </ul>
                
                <!-- Tab Content -->
                <div class="tab-content">
                    <?php if ($active_tab === 'about'): ?>
                    <!-- About Section -->
                    <form method="POST">
                        <input type="hidden" name="section" value="about">
                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                        
                        <h3 class="mb-4">About Section</h3>
                        
                        <div class="mb-3">
                            <label for="about_title" class="form-label">Section Title</label>
                            <input type="text" class="form-control" id="about_title" name="about_title" 
                                   value="<?php echo htmlspecialchars($content['about_section']['title'] ?? ''); ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="about_subtitle" class="form-label">Subtitle</label>
                            <textarea class="form-control" id="about_subtitle" name="about_subtitle" rows="2"><?php echo htmlspecialchars($content['about_section']['subtitle'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="about_main_title" class="form-label">Main Title (Above Coach V)</label>
                            <input type="text" class="form-control" id="about_main_title" name="about_main_title" 
                                   value="<?php echo htmlspecialchars($content['about_section']['main_title'] ?? ''); ?>">
                        </div>
                        
                        <button type="submit" class="btn btn-kaizen">
                            <i class="fas fa-save me-2"></i>Update About Section
                        </button>
                    </form>
                    
                    <?php elseif ($active_tab === 'summer_camp'): ?>
                    <!-- Summer Camp Section -->
                    <form method="POST">
                        <input type="hidden" name="section" value="summer_camp">
                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                        
                        <h3 class="mb-4">Summer Camp Section</h3>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="camp_title" class="form-label">Main Title</label>
                                    <input type="text" class="form-control" id="camp_title" name="camp_title" 
                                           value="<?php echo htmlspecialchars($content['summer_camp']['title'] ?? ''); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="camp_section_title" class="form-label">Section Title</label>
                                    <input type="text" class="form-control" id="camp_section_title" name="camp_section_title" 
                                           value="<?php echo htmlspecialchars($content['summer_camp']['section_title'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="camp_subtitle" class="form-label">Subtitle</label>
                            <textarea class="form-control" id="camp_subtitle" name="camp_subtitle" rows="2"><?php echo htmlspecialchars($content['summer_camp']['subtitle'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="camp_description" class="form-label">Description</label>
                            <textarea class="form-control" id="camp_description" name="camp_description" rows="3"><?php echo htmlspecialchars($content['summer_camp']['description'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="camp_features" class="form-label">Features (one per line)</label>
                            <textarea class="form-control" id="camp_features" name="camp_features" rows="5"><?php echo htmlspecialchars(implode("\n", $content['summer_camp']['features'] ?? [])); ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="camp_note" class="form-label">Note</label>
                            <input type="text" class="form-control" id="camp_note" name="camp_note" 
                                   value="<?php echo htmlspecialchars($content['summer_camp']['note'] ?? ''); ?>">
                        </div>
                        
                        <h4 class="mt-4 mb-3">Camp Weeks</h4>
                        
                        <div class="mb-3">
                            <label for="weeks_title" class="form-label">Weeks Title</label>
                            <input type="text" class="form-control" id="weeks_title" name="weeks_title" 
                                   value="<?php echo htmlspecialchars($content['summer_camp']['camp_weeks']['title'] ?? ''); ?>">
                        </div>
                        
                        <div id="weeks-container">
                            <?php 
                            $weeks = $content['summer_camp']['camp_weeks']['weeks'] ?? [];
                            foreach ($weeks as $index => $week): 
                            ?>
                            <div class="week-item">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label">Dates</label>
                                        <input type="text" class="form-control" name="week_dates[]" 
                                               value="<?php echo htmlspecialchars($week['dates']); ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Theme</label>
                                        <input type="text" class="form-control" name="week_theme[]" 
                                               value="<?php echo htmlspecialchars($week['theme']); ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Description</label>
                                        <input type="text" class="form-control" name="week_description[]" 
                                               value="<?php echo htmlspecialchars($week['description']); ?>">
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="weeks_note" class="form-label">Weeks Note</label>
                            <textarea class="form-control" id="weeks_note" name="weeks_note" rows="2"><?php echo htmlspecialchars($content['summer_camp']['camp_weeks']['note'] ?? ''); ?></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-kaizen">
                            <i class="fas fa-save me-2"></i>Update Summer Camp
                        </button>
                    </form>
                    
                    <?php elseif ($active_tab === 'kaizen_dojo'): ?>
                    <!-- Kaizen Dojo Section -->
                    <form method="POST">
                        <input type="hidden" name="section" value="kaizen_dojo">
                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                        
                        <h3 class="mb-4">Kaizen Dojo Section</h3>
                        
                        <div class="mb-3">
                            <label for="dojo_title" class="form-label">Section Title</label>
                            <input type="text" class="form-control" id="dojo_title" name="dojo_title" 
                                   value="<?php echo htmlspecialchars($content['kaizen_dojo']['title'] ?? ''); ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="dojo_subtitle" class="form-label">Subtitle</label>
                            <textarea class="form-control" id="dojo_subtitle" name="dojo_subtitle" rows="2"><?php echo htmlspecialchars($content['kaizen_dojo']['subtitle'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="dojo_button" class="form-label">Button Text</label>
                                    <input type="text" class="form-control" id="dojo_button" name="dojo_button" 
                                           value="<?php echo htmlspecialchars($content['kaizen_dojo']['button'] ?? ''); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="dojo_button_url" class="form-label">Button URL</label>
                                    <input type="url" class="form-control" id="dojo_button_url" name="dojo_button_url" 
                                           value="<?php echo htmlspecialchars($content['kaizen_dojo']['button_url'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>
                        
                        <h4 class="mt-4 mb-3">Features</h4>
                        <?php 
                        $features = $content['kaizen_dojo']['features'] ?? [];
                        for ($i = 0; $i < 3; $i++): 
                            $feature = $features[$i] ?? ['icon' => '', 'title' => '', 'description' => ''];
                        ?>
                        <div class="feature-item">
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="form-label">Icon Class</label>
                                    <input type="text" class="form-control" name="dojo_feature_icon_<?php echo $i; ?>" 
                                           value="<?php echo htmlspecialchars($feature['icon']); ?>" 
                                           placeholder="fas fa-car">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control" name="dojo_feature_title_<?php echo $i; ?>" 
                                           value="<?php echo htmlspecialchars($feature['title']); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Description</label>
                                    <input type="text" class="form-control" name="dojo_feature_description_<?php echo $i; ?>" 
                                           value="<?php echo htmlspecialchars($feature['description']); ?>">
                                </div>
                            </div>
                        </div>
                        <?php endfor; ?>
                        
                        <button type="submit" class="btn btn-kaizen">
                            <i class="fas fa-save me-2"></i>Update Kaizen Dojo
                        </button>
                    </form>
                    
                    <?php elseif ($active_tab === 'weekend_evening'): ?>
                    <!-- Weekend & Evening Section -->
                    <form method="POST">
                        <input type="hidden" name="section" value="weekend_evening">
                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                        
                        <h3 class="mb-4">Weekend & Evening Classes Section</h3>
                        
                        <div class="mb-3">
                            <label for="weekend_title" class="form-label">Section Title</label>
                            <input type="text" class="form-control" id="weekend_title" name="weekend_title" 
                                   value="<?php echo htmlspecialchars($content['after_school']['title'] ?? ''); ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="weekend_subtitle" class="form-label">Subtitle</label>
                            <input type="text" class="form-control" id="weekend_subtitle" name="weekend_subtitle" 
                                   value="<?php echo htmlspecialchars($content['after_school']['subtitle'] ?? ''); ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="weekend_description" class="form-label">Description</label>
                            <textarea class="form-control" id="weekend_description" name="weekend_description" rows="3"><?php echo htmlspecialchars($content['after_school']['description'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="weekend_button" class="form-label">Button Text</label>
                                    <input type="text" class="form-control" id="weekend_button" name="weekend_button" 
                                           value="<?php echo htmlspecialchars($content['after_school']['button'] ?? ''); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="weekend_button_url" class="form-label">Button URL</label>
                                    <input type="url" class="form-control" id="weekend_button_url" name="weekend_button_url" 
                                           value="<?php echo htmlspecialchars($content['after_school']['button_url'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-kaizen">
                            <i class="fas fa-save me-2"></i>Update Weekend & Evening
                        </button>
                    </form>
                    
                    <?php elseif ($active_tab === 'online_store'): ?>
                    <!-- Online Store Section -->
                    <form method="POST">
                        <input type="hidden" name="section" value="online_store">
                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                        
                        <h3 class="mb-4">Online Store Section</h3>
                        
                        <div class="mb-3">
                            <label for="store_title" class="form-label">Section Title</label>
                            <input type="text" class="form-control" id="store_title" name="store_title" 
                                   value="<?php echo htmlspecialchars($content['online_store']['title'] ?? ''); ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="store_subtitle" class="form-label">Subtitle</label>
                            <textarea class="form-control" id="store_subtitle" name="store_subtitle" rows="2"><?php echo htmlspecialchars($content['online_store']['subtitle'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="store_features" class="form-label">Store Items (one per line)</label>
                            <textarea class="form-control" id="store_features" name="store_features" rows="5"><?php echo htmlspecialchars(implode("\n", $content['online_store']['features'] ?? [])); ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="store_button" class="form-label">Button Text</label>
                            <input type="text" class="form-control" id="store_button" name="store_button" 
                                   value="<?php echo htmlspecialchars($content['online_store']['button'] ?? ''); ?>">
                        </div>
                        
                        <button type="submit" class="btn btn-kaizen">
                            <i class="fas fa-save me-2"></i>Update Online Store
                        </button>
                    </form>
                    
                    <?php elseif ($active_tab === 'belt_exam'): ?>
                    <!-- Belt Exam Section -->
                    <form method="POST">
                        <input type="hidden" name="section" value="belt_exam">
                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                        
                        <h3 class="mb-4">Belt Examination Section</h3>
                        
                        <div class="mb-3">
                            <label for="belt_title" class="form-label">Section Title</label>
                            <input type="text" class="form-control" id="belt_title" name="belt_title" 
                                   value="<?php echo htmlspecialchars($content['belt_exam']['title'] ?? ''); ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="belt_subtitle" class="form-label">Subtitle</label>
                            <textarea class="form-control" id="belt_subtitle" name="belt_subtitle" rows="2"><?php echo htmlspecialchars($content['belt_exam']['subtitle'] ?? ''); ?></textarea>
                        </div>
                        
                        <h4 class="mt-4 mb-3">Requirements Section</h4>
                        
                        <div class="mb-3">
                            <label for="requirements_title" class="form-label">Requirements Title</label>
                            <input type="text" class="form-control" id="requirements_title" name="requirements_title" 
                                   value="<?php echo htmlspecialchars($content['belt_exam']['requirements']['title'] ?? ''); ?>">
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="matrix_title" class="form-label">Testing Matrix Title</label>
                                    <input type="text" class="form-control" id="matrix_title" name="matrix_title" 
                                           value="<?php echo htmlspecialchars($content['belt_exam']['requirements']['matrix']['title'] ?? ''); ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="matrix_description" class="form-label">Matrix Description</label>
                                    <input type="text" class="form-control" id="matrix_description" name="matrix_description" 
                                           value="<?php echo htmlspecialchars($content['belt_exam']['requirements']['matrix']['description'] ?? ''); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="req_title" class="form-label">Requirements Title</label>
                                    <input type="text" class="form-control" id="req_title" name="req_title" 
                                           value="<?php echo htmlspecialchars($content['belt_exam']['requirements']['requirements']['title'] ?? ''); ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="req_description" class="form-label">Requirements Description</label>
                                    <input type="text" class="form-control" id="req_description" name="req_description" 
                                           value="<?php echo htmlspecialchars($content['belt_exam']['requirements']['requirements']['description'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="stripe_title" class="form-label">Stripe System Title</label>
                                    <input type="text" class="form-control" id="stripe_title" name="stripe_title" 
                                           value="<?php echo htmlspecialchars($content['belt_exam']['requirements']['stripe_system']['title'] ?? ''); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="stripe_description" class="form-label">Stripe Description</label>
                                    <input type="text" class="form-control" id="stripe_description" name="stripe_description" 
                                           value="<?php echo htmlspecialchars($content['belt_exam']['requirements']['stripe_system']['description'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>
                        
                        <h4 class="mt-4 mb-3">Registration Section</h4>
                        
                        <div class="mb-3">
                            <label for="reg_title" class="form-label">Registration Title</label>
                            <input type="text" class="form-control" id="reg_title" name="reg_title" 
                                   value="<?php echo htmlspecialchars($content['belt_exam']['registration']['title'] ?? ''); ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="reg_description" class="form-label">Registration Description</label>
                            <textarea class="form-control" id="reg_description" name="reg_description" rows="2"><?php echo htmlspecialchars($content['belt_exam']['registration']['description'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="reg_button" class="form-label">Registration Button Text</label>
                            <input type="text" class="form-control" id="reg_button" name="reg_button" 
                                   value="<?php echo htmlspecialchars($content['belt_exam']['registration']['button'] ?? ''); ?>">
                        </div>
                        
                        <h4 class="mt-4 mb-3">Video Testing Information</h4>
                        
                        <div class="mb-3">
                            <label for="video_title" class="form-label">Video Testing Title</label>
                            <input type="text" class="form-control" id="video_title" name="video_title" 
                                   value="<?php echo htmlspecialchars($content['belt_exam']['video_test_info']['title'] ?? ''); ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="important_notes" class="form-label">Important Notes (one per line)</label>
                            <textarea class="form-control" id="important_notes" name="important_notes" rows="3"><?php echo htmlspecialchars(implode("\n", $content['belt_exam']['video_test_info']['important_notes'] ?? [])); ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="covid_note" class="form-label">COVID Note</label>
                            <textarea class="form-control" id="covid_note" name="covid_note" rows="2"><?php echo htmlspecialchars($content['belt_exam']['video_test_info']['covid_note'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="recording_tips" class="form-label">Recording Tips</label>
                            <textarea class="form-control" id="recording_tips" name="recording_tips" rows="3"><?php echo htmlspecialchars($content['belt_exam']['video_test_info']['recording_tips'] ?? ''); ?></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-kaizen">
                            <i class="fas fa-save me-2"></i>Update Belt Exam
                        </button>
                    </form>
                    
                    <?php elseif ($active_tab === 'kaizen_kenpo'): ?>
                    <!-- Kaizen Kenpo Section -->
                    <form method="POST">
                        <input type="hidden" name="section" value="kaizen_kenpo">
                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                        
                        <h3 class="mb-4">Kaizen Kenpo Section</h3>
                        
                        <div class="mb-3">
                            <label for="kenpo_title" class="form-label">Section Title</label>
                            <input type="text" class="form-control" id="kenpo_title" name="kenpo_title" 
                                   value="<?php echo htmlspecialchars($content['kenpo_section']['title'] ?? ''); ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="kenpo_subtitle" class="form-label">Subtitle</label>
                            <textarea class="form-control" id="kenpo_subtitle" name="kenpo_subtitle" rows="2"><?php echo htmlspecialchars($content['kenpo_section']['subtitle'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="kenpo_description" class="form-label">Description</label>
                            <textarea class="form-control" id="kenpo_description" name="kenpo_description" rows="3"><?php echo htmlspecialchars($content['kenpo_section']['description'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="kenpo_shuffle_button" class="form-label">Shuffle Button Text</label>
                            <input type="text" class="form-control" id="kenpo_shuffle_button" name="kenpo_shuffle_button" 
                                   value="<?php echo htmlspecialchars($content['kenpo_section']['shuffle_button'] ?? ''); ?>">
                        </div>
                        
                        <h4 class="mt-4 mb-3">Features</h4>
                        <?php 
                        $features = $content['kenpo_section']['features'] ?? [];
                        for ($i = 0; $i < 3; $i++): 
                            $feature = $features[$i] ?? ['icon' => '', 'title' => ''];
                        ?>
                        <div class="feature-item">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">Icon Class</label>
                                    <input type="text" class="form-control" name="kenpo_feature_icon_<?php echo $i; ?>" 
                                           value="<?php echo htmlspecialchars($feature['icon']); ?>" 
                                           placeholder="fas fa-fist-raised">
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label">Feature Title</label>
                                    <input type="text" class="form-control" name="kenpo_feature_title_<?php echo $i; ?>" 
                                           value="<?php echo htmlspecialchars($feature['title']); ?>">
                                </div>
                            </div>
                        </div>
                        <?php endfor; ?>
                        
                        <button type="submit" class="btn btn-kaizen">
                            <i class="fas fa-save me-2"></i>Update Kaizen Kenpo
                        </button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>