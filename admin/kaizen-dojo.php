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
        $content = load_json_data('site-content', 'draft');
    
    // Hero Section
    $content['kaizen_dojo']['hero']['title'] = $_POST['hero_title'] ?? '';
    $content['kaizen_dojo']['hero']['description'] = $_POST['hero_description'] ?? '';
    $content['kaizen_dojo']['hero']['registration_button_text'] = $_POST['hero_registration_button_text'] ?? '';
    
    // Handle logo upload
    if (isset($_FILES['hero_logo']) && $_FILES['hero_logo']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../assets/images/';
        $file_extension = pathinfo($_FILES['hero_logo']['name'], PATHINFO_EXTENSION);
        $filename = 'kaizen-logo-hero.' . $file_extension;
        $upload_path = $upload_dir . $filename;
        
        if (move_uploaded_file($_FILES['hero_logo']['tmp_name'], $upload_path)) {
            $content['kaizen_dojo']['hero']['logo'] = 'assets/images/' . $filename;
        }
    }
    
    // Van Service Panel
    $content['kaizen_dojo']['van_service']['title'] = $_POST['van_service_title'] ?? '';
    $content['kaizen_dojo']['van_service']['description'] = $_POST['van_service_description'] ?? '';
    
    // Van Service Locations
    $locations = [];
    if (isset($_POST['location_school_name']) && is_array($_POST['location_school_name'])) {
        foreach ($_POST['location_school_name'] as $index => $school_name) {
            if (!empty($school_name)) {
                $locations[] = [
                    'school_name' => $school_name,
                    'address' => $_POST['location_address'][$index] ?? '',
                    'is_new' => ($_POST['location_is_new'][$index] ?? '0') === '1',
                    'badge_text' => $_POST['location_badge_text'][$index] ?? ''
                ];
            }
        }
    }
    $content['kaizen_dojo']['van_service']['locations'] = $locations;
    
    // Service Cards
    $service_cards = [];
    if (isset($_POST['service_card_title']) && is_array($_POST['service_card_title'])) {
        for ($i = 0; $i < count($_POST['service_card_title']); $i++) {
            if (!empty($_POST['service_card_title'][$i])) {
                $service_cards[] = [
                    'icon' => $_POST['service_card_icon'][$i] ?? 'fas fa-star',
                    'title' => $_POST['service_card_title'][$i],
                    'description' => $_POST['service_card_description'][$i] ?? ''
                ];
            }
        }
    }
    $content['kaizen_dojo']['service_cards'] = $service_cards;
    
    // Van Service Accordion Notice
    $content['kaizen_dojo']['accordion']['van_service']['title'] = $_POST['van_service_accordion_title'] ?? '';
    $content['kaizen_dojo']['accordion']['van_service']['notice']['enabled'] = isset($_POST['van_service_notice_enabled']);
    $content['kaizen_dojo']['accordion']['van_service']['notice']['title'] = $_POST['van_service_notice_title'] ?? '';
    $content['kaizen_dojo']['accordion']['van_service']['notice']['message'] = $_POST['van_service_notice_message'] ?? '';
    $content['kaizen_dojo']['accordion']['van_service']['notice']['contact_email'] = $_POST['van_service_notice_contact_email'] ?? '';
    
    // Tuition & Payment Accordion
    $content['kaizen_dojo']['accordion']['tuition_payment']['title'] = $_POST['tuition_title'] ?? '';
    
    // Individual Pricing Fields (structured approach)
    $content['kaizen_dojo']['accordion']['tuition_payment']['pricing']['full_time'] = $_POST['tuition_full_time'] ?? '';
    $content['kaizen_dojo']['accordion']['tuition_payment']['pricing']['part_time_4'] = $_POST['tuition_part_time_4'] ?? '';
    $content['kaizen_dojo']['accordion']['tuition_payment']['pricing']['part_time_3'] = $_POST['tuition_part_time_3'] ?? '';
    $content['kaizen_dojo']['accordion']['tuition_payment']['pricing']['part_time_2'] = $_POST['tuition_part_time_2'] ?? '';
    $content['kaizen_dojo']['accordion']['tuition_payment']['pricing']['part_time_1'] = $_POST['tuition_part_time_1'] ?? '';
    $content['kaizen_dojo']['accordion']['tuition_payment']['pricing']['drop_in'] = $_POST['tuition_drop_in'] ?? '';
    
    // Keep old fields for backward compatibility but deprecate them
    $content['kaizen_dojo']['accordion']['tuition_payment']['monthly_tuition'] = $_POST['tuition_monthly_tuition'] ?? '';
    $content['kaizen_dojo']['accordion']['tuition_payment']['payment_schedule'] = $_POST['tuition_payment_schedule'] ?? '';
    $content['kaizen_dojo']['accordion']['tuition_payment']['payment_methods'] = $_POST['tuition_payment_methods'] ?? '';
    
    // Security & Safety Accordion (TinyMCE content)
    $content['kaizen_dojo']['accordion']['security_safety']['title'] = $_POST['security_title'] ?? '';
    $content['kaizen_dojo']['accordion']['security_safety']['content'] = $_POST['security_content'] ?? '';
    
    // Contact Information Accordion
    $content['kaizen_dojo']['accordion']['contact_info']['title'] = $_POST['contact_title'] ?? '';
    $content['kaizen_dojo']['accordion']['contact_info']['primary_contact_name'] = $_POST['contact_primary_contact_name'] ?? '';
    $content['kaizen_dojo']['accordion']['contact_info']['primary_contact_email'] = $_POST['contact_primary_contact_email'] ?? '';
    $content['kaizen_dojo']['accordion']['contact_info']['primary_contact_phone'] = $_POST['contact_primary_contact_phone'] ?? '';
    $content['kaizen_dojo']['accordion']['contact_info']['secondary_contact_name'] = $_POST['contact_secondary_contact_name'] ?? '';
    $content['kaizen_dojo']['accordion']['contact_info']['secondary_contact_email'] = $_POST['contact_secondary_contact_email'] ?? '';
    $content['kaizen_dojo']['accordion']['contact_info']['office_hours'] = $_POST['contact_office_hours'] ?? '';
    
        // Save the updated content
        if (save_json_data('site-content', $content, 'draft')) {
            $message = success_message('Kaizen Dojo content saved to draft successfully!');
        } else {
            $message = error_message('Failed to save Kaizen Dojo content.');
        }
    }
}

// Load current content from draft
$content = load_json_data('site-content', 'draft');
$kaizen_dojo = $content['kaizen_dojo'] ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kaizen Dojo Management - Kaizen Karate Admin</title>
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
        .location-card, .service-card-admin {
            background: white;
            border-radius: 6px;
            padding: 1rem;
            margin-bottom: 1rem;
            border: 1px solid #dee2e6;
        }
        .conditional-field {
            margin-top: 0.5rem;
            padding: 0.75rem;
            background: #e3f2fd;
            border-radius: 4px;
            border-left: 3px solid #2196f3;
        }
        .icon-selector {
            position: relative;
            display: inline-block;
        }
        .icon-preview {
            font-size: 1.5rem;
            color: var(--kaizen-primary);
            margin-right: 0.5rem;
        }
        .transition-icon { transition: transform 0.3s ease; }
    </style>
    
    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/fq0i7hnb9d2b3crowpl5mnry1dqw0zfcdycrxo7s3qohwuj6/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
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
                    <h1><i class="fas fa-home me-2 text-primary"></i>Kaizen Dojo Management</h1>
                </div>
                <?php echo $message; ?>

                <!-- Kaizen Dojo Management -->
                <div class="content-section">
                    <div class="alert alert-kaizen border-0 mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Kaizen Dojo:</strong> Manage the after-school program content including hero section, van service, service cards, and accordion sections.
                    </div>
                    
                    <form method="POST" enctype="multipart/form-data" id="kaizenDojoForm">
                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                        
                        <!-- Hero Section -->
                        <div class="mb-4 p-3 border rounded bg-light">
                            <h5 class="text-primary mb-3"><i class="fas fa-home me-2"></i>Hero Section</h5>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Logo Upload</label>
                        <input type="file" class="form-control" name="hero_logo" accept="image/*">
                        <?php if (!empty($kaizen_dojo['hero']['logo'])): ?>
                            <small class="text-muted">Current: <?php echo $kaizen_dojo['hero']['logo']; ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" name="hero_title" 
                               value="<?php echo htmlspecialchars($kaizen_dojo['hero']['title'] ?? ''); ?>">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <label class="form-label">Main Description</label>
                        <textarea class="form-control" name="hero_description" rows="3"><?php echo htmlspecialchars($kaizen_dojo['hero']['description'] ?? ''); ?></textarea>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label class="form-label">Registration Button Text</label>
                        <input type="text" class="form-control" name="hero_registration_button_text" 
                               value="<?php echo htmlspecialchars($kaizen_dojo['hero']['registration_button_text'] ?? ''); ?>">
                    </div>
                </div>
            </div>
            
            <!-- Save Button - Hero Section -->
            <div class="text-center mb-4">
                <button type="submit" class="btn btn-kaizen">
                    <i class="fas fa-save me-2"></i>Save Hero Section
                </button>
            </div>

                        <!-- Van Service Panel -->
                        <div class="mb-4 p-3 border rounded bg-light">
                            <h5 class="text-primary mb-3"><i class="fas fa-bus me-2"></i>Van Service Panel</h5>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Section Title</label>
                        <input type="text" class="form-control" name="van_service_title" 
                               value="<?php echo htmlspecialchars($kaizen_dojo['van_service']['title'] ?? ''); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="van_service_description" rows="2"><?php echo htmlspecialchars($kaizen_dojo['van_service']['description'] ?? ''); ?></textarea>
                    </div>
                </div>

                <h4 class="mt-4 mb-3">School Locations</h4>
                <div id="locations-container">
                    <?php
                    $locations = $kaizen_dojo['van_service']['locations'] ?? [];
                    foreach ($locations as $index => $location):
                    ?>
                        <div class="location-card" data-index="<?php echo $index; ?>">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">School Name</label>
                                    <input type="text" class="form-control" name="location_school_name[<?php echo $index; ?>]" 
                                           value="<?php echo htmlspecialchars($location['school_name'] ?? ''); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control" name="location_address[<?php echo $index; ?>]" 
                                           value="<?php echo htmlspecialchars($location['address'] ?? ''); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Mark as New</label>
                                    <input type="hidden" name="location_is_new[<?php echo $index; ?>]" value="0">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input mark-new-checkbox" name="location_is_new[<?php echo $index; ?>]" 
                                               value="1" <?php echo ($location['is_new'] ?? false) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">Show "New" Badge</label>
                                    </div>
                                    <div class="conditional-field" style="<?php echo ($location['is_new'] ?? false) ? '' : 'display: none;'; ?>">
                                        <label class="form-label">Badge Text</label>
                                        <input type="text" class="form-control" name="location_badge_text[<?php echo $index; ?>]" 
                                               value="<?php echo htmlspecialchars($location['badge_text'] ?? ''); ?>" 
                                               placeholder="e.g., NEW Fall 2025">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12 text-end">
                                    <button type="button" class="btn btn-sm btn-outline-danger remove-location">
                                        <i class="fas fa-trash me-1"></i>Remove Location
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="btn btn-success" id="add-location">
                    <i class="fas fa-plus me-1"></i>Add Location
                </button>
                
                <!-- Save Button - Van Service -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-kaizen">
                        <i class="fas fa-save me-2"></i>Save Van Service
                    </button>
                </div>
            </div>

                        <!-- Service Cards -->
                        <div class="mb-4 p-3 border rounded bg-light">
                            <h5 class="text-primary mb-3"><i class="fas fa-th-large me-2"></i>Service Cards</h5>
                <div id="service-cards-container">
                    <?php
                    $service_cards = $kaizen_dojo['service_cards'] ?? [];
                    foreach ($service_cards as $index => $card):
                    ?>
                        <div class="service-card-admin">
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="form-label">Icon</label>
                                    <div class="icon-selector">
                                        <span class="icon-preview"><i class="<?php echo $card['icon'] ?? 'fas fa-star'; ?>"></i></span>
                                        <input type="text" class="form-control icon-input" name="service_card_icon[]" 
                                               value="<?php echo htmlspecialchars($card['icon'] ?? ''); ?>" 
                                               placeholder="fas fa-star">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control" name="service_card_title[]" 
                                           value="<?php echo htmlspecialchars($card['title'] ?? ''); ?>">
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" name="service_card_description[]" rows="2"><?php echo htmlspecialchars($card['description'] ?? ''); ?></textarea>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="button" class="btn btn-outline-danger remove-service-card">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="btn btn-success" id="add-service-card">
                    <i class="fas fa-plus me-1"></i>Add Service Card
                </button>
                
                <!-- Save Button - Service Cards -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-kaizen">
                        <i class="fas fa-save me-2"></i>Save Service Cards
                    </button>
                </div>
            </div>

                        <!-- Van Service Accordion -->
                        <div class="mb-4 p-3 border rounded bg-light">
                            <h5 class="text-primary mb-3"><i class="fas fa-list me-2"></i>Van Service Accordion</h5>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Accordion Title</label>
                        <input type="text" class="form-control" name="van_service_accordion_title" 
                               value="<?php echo htmlspecialchars($kaizen_dojo['accordion']['van_service']['title'] ?? ''); ?>">
                    </div>
                </div>
                
                <h4 class="mt-4 mb-3">Limited Space Notice</h4>
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" name="van_service_notice_enabled" id="notice-enabled" 
                           value="1" <?php echo ($kaizen_dojo['accordion']['van_service']['notice']['enabled'] ?? false) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="notice-enabled">Enable Notice Box</label>
                </div>
                
                <div id="notice-fields" style="<?php echo ($kaizen_dojo['accordion']['van_service']['notice']['enabled'] ?? false) ? '' : 'display: none;'; ?>">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Notice Title</label>
                            <input type="text" class="form-control" name="van_service_notice_title" 
                                   value="<?php echo htmlspecialchars($kaizen_dojo['accordion']['van_service']['notice']['title'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Contact Email</label>
                            <input type="email" class="form-control" name="van_service_notice_contact_email" 
                                   value="<?php echo htmlspecialchars($kaizen_dojo['accordion']['van_service']['notice']['contact_email'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <label class="form-label">Notice Message</label>
                            <textarea class="form-control" name="van_service_notice_message" rows="3"><?php echo htmlspecialchars($kaizen_dojo['accordion']['van_service']['notice']['message'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

                        <!-- Tuition & Payment Accordion -->
                        <div class="mb-4 p-3 border rounded bg-light">
                            <h5 class="text-primary mb-3"><i class="fas fa-dollar-sign me-2"></i>Tuition & Payment Accordion</h5>
                <div class="row">
                    <div class="col-md-12">
                        <label class="form-label">Section Title</label>
                        <input type="text" class="form-control" name="tuition_title" 
                               value="<?php echo htmlspecialchars($kaizen_dojo['accordion']['tuition_payment']['title'] ?? ''); ?>">
                    </div>
                </div>
                
                <h4 class="mt-4 mb-3">Individual Pricing Tiers</h4>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <label class="form-label">Full-time (5 days/week)</label>
                        <input type="text" class="form-control" name="tuition_full_time" 
                               value="<?php echo htmlspecialchars($kaizen_dojo['accordion']['tuition_payment']['pricing']['full_time'] ?? ''); ?>" 
                               placeholder="$460">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Part-time (4 days/week)</label>
                        <input type="text" class="form-control" name="tuition_part_time_4" 
                               value="<?php echo htmlspecialchars($kaizen_dojo['accordion']['tuition_payment']['pricing']['part_time_4'] ?? ''); ?>" 
                               placeholder="$410">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Part-time (3 days/week)</label>
                        <input type="text" class="form-control" name="tuition_part_time_3" 
                               value="<?php echo htmlspecialchars($kaizen_dojo['accordion']['tuition_payment']['pricing']['part_time_3'] ?? ''); ?>" 
                               placeholder="$310">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <label class="form-label">Part-time (2 days/week)</label>
                        <input type="text" class="form-control" name="tuition_part_time_2" 
                               value="<?php echo htmlspecialchars($kaizen_dojo['accordion']['tuition_payment']['pricing']['part_time_2'] ?? ''); ?>" 
                               placeholder="$210">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Part-time (1 day/week)</label>
                        <input type="text" class="form-control" name="tuition_part_time_1" 
                               value="<?php echo htmlspecialchars($kaizen_dojo['accordion']['tuition_payment']['pricing']['part_time_1'] ?? ''); ?>" 
                               placeholder="$110">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Drop-in Daily Rate</label>
                        <input type="text" class="form-control" name="tuition_drop_in" 
                               value="<?php echo htmlspecialchars($kaizen_dojo['accordion']['tuition_payment']['pricing']['drop_in'] ?? ''); ?>" 
                               placeholder="$30">
                    </div>
                </div>
            </div>

                        <!-- Security & Safety Accordion -->
                        <div class="mb-4 p-3 border rounded bg-light">
                            <h5 class="text-primary mb-3"><i class="fas fa-shield-alt me-2"></i>Security & Safety Accordion</h5>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Section Title</label>
                        <input type="text" class="form-control" name="security_title" 
                               value="<?php echo htmlspecialchars($kaizen_dojo['accordion']['security_safety']['title'] ?? ''); ?>">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <label class="form-label">Content (Rich Text Editor)</label>
                        <textarea class="form-control tinymce-editor" name="security_content" rows="10"><?php echo htmlspecialchars($kaizen_dojo['accordion']['security_safety']['content'] ?? ''); ?></textarea>
                    </div>
                </div>
            </div>

                        <!-- Contact Information Accordion -->
                        <div class="mb-4 p-3 border rounded bg-light">
                            <h5 class="text-primary mb-3"><i class="fas fa-address-book me-2"></i>Contact Information Accordion</h5>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Section Title</label>
                        <input type="text" class="form-control" name="contact_title" 
                               value="<?php echo htmlspecialchars($kaizen_dojo['accordion']['contact_info']['title'] ?? ''); ?>">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <label class="form-label">Primary Contact Name</label>
                        <input type="text" class="form-control" name="contact_primary_contact_name" 
                               value="<?php echo htmlspecialchars($kaizen_dojo['accordion']['contact_info']['primary_contact_name'] ?? ''); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Primary Contact Email</label>
                        <input type="email" class="form-control" name="contact_primary_contact_email" 
                               value="<?php echo htmlspecialchars($kaizen_dojo['accordion']['contact_info']['primary_contact_email'] ?? ''); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Primary Contact Phone</label>
                        <input type="tel" class="form-control" name="contact_primary_contact_phone" 
                               value="<?php echo htmlspecialchars($kaizen_dojo['accordion']['contact_info']['primary_contact_phone'] ?? ''); ?>">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label class="form-label">Secondary Contact Name</label>
                        <input type="text" class="form-control" name="contact_secondary_contact_name" 
                               value="<?php echo htmlspecialchars($kaizen_dojo['accordion']['contact_info']['secondary_contact_name'] ?? ''); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Secondary Contact Email</label>
                        <input type="email" class="form-control" name="contact_secondary_contact_email" 
                               value="<?php echo htmlspecialchars($kaizen_dojo['accordion']['contact_info']['secondary_contact_email'] ?? ''); ?>">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <label class="form-label">Office Hours</label>
                        <textarea class="form-control" name="contact_office_hours" rows="3"><?php echo htmlspecialchars($kaizen_dojo['accordion']['contact_info']['office_hours'] ?? ''); ?></textarea>
                    </div>
                </div>
            </div>
            
            <!-- Save Button - Accordion Sections -->
            <div class="text-center mb-4">
                <button type="submit" class="btn btn-kaizen">
                    <i class="fas fa-save me-2"></i>Save Accordion Sections
                </button>
            </div>

                        <!-- Submit Button -->
                        <div class="text-center mb-4">
                            <button type="submit" class="btn btn-kaizen btn-lg">
                                <i class="fas fa-save me-2"></i>Save Kaizen Dojo Content
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize TinyMCE
        tinymce.init({
            selector: '.tinymce-editor',
            plugins: 'lists link image table code',
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist | link image | table | code',
            height: 300,
            menubar: false,
            branding: false,
            content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; }'
        });

        // Handle notice enable/disable
        document.getElementById('notice-enabled').addEventListener('change', function() {
            const noticeFields = document.getElementById('notice-fields');
            noticeFields.style.display = this.checked ? 'block' : 'none';
        });

        // Handle "Mark as New" checkboxes
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('mark-new-checkbox')) {
                const conditionalField = e.target.closest('.col-md-4').querySelector('.conditional-field');
                conditionalField.style.display = e.target.checked ? 'block' : 'none';
            }
        });

        // Handle icon preview updates
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('icon-input')) {
                const iconPreview = e.target.parentElement.querySelector('.icon-preview i');
                iconPreview.className = e.target.value || 'fas fa-star';
            }
        });

        // Add Location functionality
        document.getElementById('add-location').addEventListener('click', function() {
            const container = document.getElementById('locations-container');
            const existingCards = container.querySelectorAll('.location-card');
            // Find the highest index
            let maxIndex = -1;
            existingCards.forEach(card => {
                const index = parseInt(card.getAttribute('data-index') || '0');
                if (index > maxIndex) maxIndex = index;
            });
            const newIndex = maxIndex + 1;
            
            const locationCard = document.createElement('div');
            locationCard.className = 'location-card';
            locationCard.setAttribute('data-index', newIndex);
            locationCard.innerHTML = `
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">School Name</label>
                        <input type="text" class="form-control" name="location_school_name[${newIndex}]">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" name="location_address[${newIndex}]">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Mark as New</label>
                        <input type="hidden" name="location_is_new[${newIndex}]" value="0">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input mark-new-checkbox" name="location_is_new[${newIndex}]" value="1">
                            <label class="form-check-label">Show "New" Badge</label>
                        </div>
                        <div class="conditional-field" style="display: none;">
                            <label class="form-label">Badge Text</label>
                            <input type="text" class="form-control" name="location_badge_text[${newIndex}]" placeholder="e.g., NEW Fall 2025">
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12 text-end">
                        <button type="button" class="btn btn-sm btn-outline-danger remove-location">
                            <i class="fas fa-trash me-1"></i>Remove Location
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(locationCard);
        });

        // Remove Location functionality
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-location')) {
                e.target.closest('.location-card').remove();
            }
        });

        // Add Service Card functionality
        document.getElementById('add-service-card').addEventListener('click', function() {
            const container = document.getElementById('service-cards-container');
            const serviceCard = document.createElement('div');
            serviceCard.className = 'service-card-admin';
            serviceCard.innerHTML = `
                <div class="row">
                    <div class="col-md-2">
                        <label class="form-label">Icon</label>
                        <div class="icon-selector">
                            <span class="icon-preview"><i class="fas fa-star"></i></span>
                            <input type="text" class="form-control icon-input" name="service_card_icon[]" value="fas fa-star" placeholder="fas fa-star">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" name="service_card_title[]">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="service_card_description[]" rows="2"></textarea>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-outline-danger remove-service-card">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(serviceCard);
        });

        // Remove Service Card functionality
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-service-card')) {
                e.target.closest('.service-card-admin').remove();
            }
        });
    </script>
</body>
</html>