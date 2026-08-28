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
        $content = load_json_data('site-content', 'draft');
        $nyc_section = $content['nyc_section'] ?? [];

        // Update NYC section
        if (isset($_POST['update_nyc_section'])) {
            // Update Header
            $nyc_section['header'] = [
                'title' => $_POST['header_title'], // Allow HTML for span
                'subtitle' => sanitize_input($_POST['header_subtitle'])
            ];

            // Update Badge
            $nyc_section['badge'] = [
                'icon' => sanitize_input($_POST['badge_icon']),
                'text' => sanitize_input($_POST['badge_text'])
            ];

            // Update Video
            $nyc_section['video'] = [
                'source' => sanitize_input($_POST['video_source'])
            ];

            // Update Contact
            $nyc_section['contact'] = [
                'address' => $_POST['contact_address'], // Allow <br>
                'phone' => sanitize_input($_POST['contact_phone']),
                'email' => sanitize_input($_POST['contact_email'])
            ];

            // Update CTA
            $nyc_section['cta'] = [
                'text' => sanitize_input($_POST['cta_text']),
                'url' => sanitize_input($_POST['cta_url'])
            ];

            // Update Features Grid
            $features = [];
            if (isset($_POST['feature_icon']) && is_array($_POST['feature_icon'])) {
                for ($i = 0; $i < count($_POST['feature_icon']); $i++) {
                    if (!empty($_POST['feature_icon'][$i]) && !empty($_POST['feature_text'][$i])) {
                        $features[] = [
                            'icon' => sanitize_input($_POST['feature_icon'][$i]),
                            'text' => sanitize_input($_POST['feature_text'][$i])
                        ];
                    }
                }
            }
            $nyc_section['features'] = $features;

            $content['nyc_section'] = $nyc_section;

            if (save_json_data('site-content', $content)) {
                $message = success_message('NYC section updated successfully!');
            } else {
                $message = error_message('Failed to save changes.');
            }
        }
    }
}

// Load current content
$content = load_json_data('site-content', 'draft');
$nyc_section = $content['nyc_section'] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NYC Section Management - Kaizen Karate Admin</title>
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
                    <h1><i class="fas fa-city me-2 text-primary"></i>NYC Section Management</h1>
                </div>
                
                <?php echo $message; ?>

                <div class="content-section">
                    <form method="POST">
                        <input type="hidden" name="update_nyc_section" value="1">
                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                        
                        <!-- Header & Badge -->
                        <h4 class="section-title"><i class="fas fa-heading me-2"></i>Header & Badge</h4>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label"><strong>Section Title</strong></label>
                                    <input type="text" class="form-control" name="header_title" 
                                           value="<?php echo htmlspecialchars($nyc_section['header']['title'] ?? ''); ?>">
                                    <div class="form-text">Supports HTML (e.g., &lt;span class="nyc-red"&gt;NYC&lt;/span&gt;)</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><strong>Subtitle</strong></label>
                                    <input type="text" class="form-control" name="header_subtitle" 
                                           value="<?php echo htmlspecialchars($nyc_section['header']['subtitle'] ?? ''); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label"><strong>Badge Icon</strong></label>
                                    <input type="text" class="form-control" name="badge_icon" 
                                           value="<?php echo htmlspecialchars($nyc_section['badge']['icon'] ?? ''); ?>">
                                    <div class="form-text">FontAwesome class (e.g., fas fa-check-circle)</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><strong>Badge Text</strong></label>
                                    <input type="text" class="form-control" name="badge_text" 
                                           value="<?php echo htmlspecialchars($nyc_section['badge']['text'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>

                        <!-- Video Source -->
                        <h4 class="section-title"><i class="fas fa-video me-2"></i>Video Source</h4>
                        <div class="mb-4">
                            <div class="mb-3">
                                <label class="form-label"><strong>Background Video Path</strong></label>
                                <input type="text" class="form-control" name="video_source" 
                                       value="<?php echo htmlspecialchars($nyc_section['video']['source'] ?? ''); ?>">
                            </div>
                        </div>

                        <!-- Features Grid -->
                        <h4 class="section-title"><i class="fas fa-list me-2"></i>Features Grid</h4>
                        <div id="features-container" class="mb-4">
                            <?php foreach ($nyc_section['features'] ?? [] as $index => $feature): ?>
                            <div class="feature-item border rounded p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-5">
                                        <label class="form-label">Icon Class</label>
                                        <input type="text" class="form-control" name="feature_icon[]" 
                                               value="<?php echo htmlspecialchars($feature['icon']); ?>">
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label">Feature Text</label>
                                        <input type="text" class="form-control" name="feature_text[]" 
                                               value="<?php echo htmlspecialchars($feature['text']); ?>">
                                    </div>
                                    <div class="col-md-2 text-center mt-3">
                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="this.closest('.feature-item').remove()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm mb-4" onclick="addFeature()">
                            <i class="fas fa-plus me-1"></i>Add Feature
                        </button>

                        <!-- Contact & CTA -->
                        <h4 class="section-title"><i class="fas fa-address-book me-2"></i>Contact & CTA</h4>
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label"><strong>Address</strong></label>
                                    <textarea class="form-control" name="contact_address" rows="3"><?php echo htmlspecialchars($nyc_section['contact']['address'] ?? ''); ?></textarea>
                                    <div class="form-text">Supports &lt;br&gt;</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label"><strong>Phone</strong></label>
                                    <input type="text" class="form-control" name="contact_phone" 
                                           value="<?php echo htmlspecialchars($nyc_section['contact']['phone'] ?? ''); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><strong>Email</strong></label>
                                    <input type="email" class="form-control" name="contact_email" 
                                           value="<?php echo htmlspecialchars($nyc_section['contact']['email'] ?? ''); ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label"><strong>CTA Button Text</strong></label>
                                    <input type="text" class="form-control" name="cta_text" 
                                           value="<?php echo htmlspecialchars($nyc_section['cta']['text'] ?? ''); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><strong>CTA URL</strong></label>
                                    <input type="text" class="form-control" name="cta_url" 
                                           value="<?php echo htmlspecialchars($nyc_section['cta']['url'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-kaizen">
                            <i class="fas fa-save me-2"></i>Save NYC Section Settings
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addFeature() {
            const container = document.getElementById('features-container');
            const div = document.createElement('div');
            div.className = 'feature-item border rounded p-3 mb-3';
            div.innerHTML = `
                <div class="row align-items-center">
                    <div class="col-md-5">
                        <label class="form-label">Icon Class</label>
                        <input type="text" class="form-control" name="feature_icon[]" placeholder="fas fa-star">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Feature Text</label>
                        <input type="text" class="form-control" name="feature_text[]" placeholder="New Feature">
                    </div>
                    <div class="col-md-2 text-center mt-3">
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="this.closest('.feature-item').remove()">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(div);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bundle.min.js"></script>
</body>
</html>
