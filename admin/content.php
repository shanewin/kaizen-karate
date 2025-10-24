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
        $section = $_POST['section'] ?? '';
        
        switch ($section) {
            case 'site_info':
                $content = load_json_data('site-content');
                $content['site_info'] = [
                    'title' => sanitize_input($_POST['title']),
                    'description' => sanitize_input($_POST['description']),
                    'keywords' => sanitize_input($_POST['keywords']),
                    'phone' => sanitize_input($_POST['phone']),
                    'email' => sanitize_input($_POST['email'])
                ];
                if (save_json_data('site-content', $content)) {
                    $message = success_message('Site information updated successfully!');
                }
                break;
                
            case 'hero_section':
                $content = load_json_data('site-content');
                $content['hero_section'] = [
                    'title' => sanitize_input($_POST['hero_title']),
                    'subtitle' => sanitize_input($_POST['hero_subtitle']),
                    'button_primary' => sanitize_input($_POST['button_primary']),
                    'button_secondary' => sanitize_input($_POST['button_secondary'])
                ];
                if (save_json_data('site-content', $content)) {
                    $message = success_message('Hero section updated successfully!');
                }
                break;
                
            case 'programs':
                $content = load_json_data('site-content');
                $content['programs']['title'] = sanitize_input($_POST['programs_title']);
                
                foreach ($content['programs']['cards'] as $index => &$card) {
                    $card['title'] = sanitize_input($_POST['card_title_' . $index]);
                    $card['description'] = sanitize_input($_POST['card_description_' . $index]);
                    $card['button'] = sanitize_input($_POST['card_button_' . $index]);
                }
                
                if (save_json_data('site-content', $content)) {
                    $message = success_message('Programs section updated successfully!');
                }
                break;
                
            case 'summer_camp':
                $content = load_json_data('site-content');
                $content['summer_camp']['title'] = sanitize_input($_POST['camp_title']);
                $content['summer_camp']['subtitle'] = sanitize_input($_POST['camp_subtitle']);
                $content['summer_camp']['section_title'] = sanitize_input($_POST['camp_section_title']);
                $content['summer_camp']['description'] = sanitize_input($_POST['camp_description']);
                $content['summer_camp']['note'] = sanitize_input($_POST['camp_note']);
                
                // Handle features
                $features = explode("\n", $_POST['camp_features']);
                $content['summer_camp']['features'] = array_map('trim', array_filter($features));
                
                if (save_json_data('site-content', $content)) {
                    $message = success_message('Summer camp section updated successfully!');
                }
                break;
                
            case 'contact':
                $content = load_json_data('site-content');
                $content['contact_section']['title'] = sanitize_input($_POST['contact_title']);
                $content['contact_section']['subtitle'] = sanitize_input($_POST['contact_subtitle']);
                $content['contact_section']['waitlist_form']['title'] = sanitize_input($_POST['waitlist_title']);
                $content['contact_section']['waitlist_form']['description'] = sanitize_input($_POST['waitlist_description']);
                $content['contact_section']['waitlist_form']['button'] = sanitize_input($_POST['waitlist_button']);
                
                if (save_json_data('site-content', $content)) {
                    $message = success_message('Contact section updated successfully!');
                }
                break;
        }
    }
}

// Load current content
$content = load_json_data('site-content');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Content Management - Kaizen Karate Admin</title>
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
        .content-card { background: white; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); margin-bottom: 2rem; overflow: hidden; }
        .card-header-custom { background: linear-gradient(45deg, var(--kaizen-primary), var(--kaizen-secondary)); color: white; padding: 1.5rem; }
        .btn-kaizen { background: linear-gradient(45deg, var(--kaizen-primary), var(--kaizen-secondary)); border: none; color: white; padding: 0.75rem 2rem; border-radius: 8px; font-weight: 600; }
        .btn-kaizen:hover { color: white; transform: translateY(-2px); box-shadow: 0 8px 25px rgba(164, 51, 43, 0.3); }
        .form-control:focus { border-color: var(--kaizen-primary); box-shadow: 0 0 0 0.2rem rgba(164, 51, 43, 0.25); }
        .content-section { border: 1px solid #e9ecef; border-radius: 10px; padding: 1.5rem; margin-bottom: 2rem; }
        .section-title { color: var(--kaizen-primary); border-bottom: 2px solid var(--kaizen-primary); padding-bottom: 0.5rem; margin-bottom: 1rem; }
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
                    <h1><i class="fas fa-edit me-2 text-primary"></i>Content Management</h1>
                </div>
                
                <?php echo $message; ?>
                
                <!-- Site Information -->
                <div class="content-section">
                    <h3 class="section-title"><i class="fas fa-globe me-2"></i>Site Information</h3>
                    <form method="POST">
                        <input type="hidden" name="section" value="site_info">
                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Site Title</label>
                                    <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($content['site_info']['title'] ?? ''); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="keywords" class="form-label">Keywords</label>
                                    <input type="text" class="form-control" id="keywords" name="keywords" value="<?php echo htmlspecialchars($content['site_info']['keywords'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Site Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required><?php echo htmlspecialchars($content['site_info']['description'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($content['site_info']['phone'] ?? ''); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($content['site_info']['email'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-kaizen"><i class="fas fa-save me-2"></i>Update Site Info</button>
                    </form>
                </div>
                
                <!-- Hero Section -->
                <div class="content-section">
                    <h3 class="section-title"><i class="fas fa-star me-2"></i>Hero Section</h3>
                    <form method="POST">
                        <input type="hidden" name="section" value="hero_section">
                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                        
                        <div class="mb-3">
                            <label for="hero_title" class="form-label">Main Title</label>
                            <input type="text" class="form-control" id="hero_title" name="hero_title" value="<?php echo htmlspecialchars($content['hero_section']['title'] ?? ''); ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="hero_subtitle" class="form-label">Subtitle</label>
                            <textarea class="form-control" id="hero_subtitle" name="hero_subtitle" rows="2" required><?php echo htmlspecialchars($content['hero_section']['subtitle'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="button_primary" class="form-label">Primary Button Text</label>
                                    <input type="text" class="form-control" id="button_primary" name="button_primary" value="<?php echo htmlspecialchars($content['hero_section']['button_primary'] ?? ''); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="button_secondary" class="form-label">Secondary Button Text</label>
                                    <input type="text" class="form-control" id="button_secondary" name="button_secondary" value="<?php echo htmlspecialchars($content['hero_section']['button_secondary'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-kaizen"><i class="fas fa-save me-2"></i>Update Hero Section</button>
                    </form>
                </div>
                
                <!-- Programs Section -->
                <div class="content-section">
                    <h3 class="section-title"><i class="fas fa-th-large me-2"></i>Programs Section</h3>
                    <form method="POST">
                        <input type="hidden" name="section" value="programs">
                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                        
                        <div class="mb-4">
                            <label for="programs_title" class="form-label">Section Title</label>
                            <input type="text" class="form-control" id="programs_title" name="programs_title" value="<?php echo htmlspecialchars($content['programs']['title'] ?? ''); ?>">
                        </div>
                        
                        <div class="row">
                            <?php if (isset($content['programs']['cards'])): ?>
                                <?php foreach ($content['programs']['cards'] as $index => $card): ?>
                                    <div class="col-md-6 mb-4">
                                        <div class="card">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0">Program Card <?php echo $index + 1; ?></h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Title</label>
                                                    <input type="text" class="form-control" name="card_title_<?php echo $index; ?>" value="<?php echo htmlspecialchars($card['title']); ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Description</label>
                                                    <textarea class="form-control" name="card_description_<?php echo $index; ?>" rows="2"><?php echo htmlspecialchars($card['description']); ?></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Button Text</label>
                                                    <input type="text" class="form-control" name="card_button_<?php echo $index; ?>" value="<?php echo htmlspecialchars($card['button']); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        
                        <button type="submit" class="btn btn-kaizen"><i class="fas fa-save me-2"></i>Update Programs</button>
                    </form>
                </div>
                
                <!-- Summer Camp Section -->
                <div class="content-section">
                    <h3 class="section-title"><i class="fas fa-sun me-2"></i>Summer Camp</h3>
                    <form method="POST">
                        <input type="hidden" name="section" value="summer_camp">
                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="camp_title" class="form-label">Main Title</label>
                                    <input type="text" class="form-control" id="camp_title" name="camp_title" value="<?php echo htmlspecialchars($content['summer_camp']['title'] ?? ''); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="camp_section_title" class="form-label">Section Title</label>
                                    <input type="text" class="form-control" id="camp_section_title" name="camp_section_title" value="<?php echo htmlspecialchars($content['summer_camp']['section_title'] ?? ''); ?>">
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
                            <input type="text" class="form-control" id="camp_note" name="camp_note" value="<?php echo htmlspecialchars($content['summer_camp']['note'] ?? ''); ?>">
                        </div>
                        
                        <button type="submit" class="btn btn-kaizen"><i class="fas fa-save me-2"></i>Update Summer Camp</button>
                    </form>
                </div>
                
                <!-- Contact Section -->
                <div class="content-section">
                    <h3 class="section-title"><i class="fas fa-envelope me-2"></i>Contact Section</h3>
                    <form method="POST">
                        <input type="hidden" name="section" value="contact">
                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="contact_title" class="form-label">Section Title</label>
                                    <input type="text" class="form-control" id="contact_title" name="contact_title" value="<?php echo htmlspecialchars($content['contact_section']['title'] ?? ''); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="waitlist_title" class="form-label">Wait List Form Title</label>
                                    <input type="text" class="form-control" id="waitlist_title" name="waitlist_title" value="<?php echo htmlspecialchars($content['contact_section']['waitlist_form']['title'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="contact_subtitle" class="form-label">Section Subtitle</label>
                            <textarea class="form-control" id="contact_subtitle" name="contact_subtitle" rows="2"><?php echo htmlspecialchars($content['contact_section']['subtitle'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="waitlist_description" class="form-label">Wait List Form Description</label>
                            <textarea class="form-control" id="waitlist_description" name="waitlist_description" rows="2"><?php echo htmlspecialchars($content['contact_section']['waitlist_form']['description'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="waitlist_button" class="form-label">Wait List Button Text</label>
                            <input type="text" class="form-control" id="waitlist_button" name="waitlist_button" value="<?php echo htmlspecialchars($content['contact_section']['waitlist_form']['button'] ?? ''); ?>">
                        </div>
                        
                        <button type="submit" class="btn btn-kaizen"><i class="fas fa-save me-2"></i>Update Contact Section</button>
                    </form>
                </div>
                
                <!-- Quick Actions -->
                <div class="content-section">
                    <h3 class="section-title"><i class="fas fa-bolt me-2"></i>Quick Actions</h3>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <a href="media.php" class="btn btn-outline-primary w-100">
                                <i class="fas fa-images me-2"></i>Manage Images & Videos
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="instructors.php" class="btn btn-outline-primary w-100">
                                <i class="fas fa-users me-2"></i>Edit Instructors
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>