<?php
define('KAIZEN_ADMIN', true);
session_start();
require_once 'config.php';

// Require login
require_login();

$message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'])) {
        $message = error_message('Security token invalid. Please try again.');
    } else {
        $content = load_json_data('site-content', 'draft');
        $current_store = $content['online_store'] ?? [];
        $changes = [];
        
        // Track changes for Online Store Section
        $new_title = $_POST['store_title'] ?? '';
        if (($current_store['title'] ?? '') !== $new_title) {
            $changes[] = 'Online Store: title updated';
            $content['online_store']['title'] = $new_title;
        }
        
        $new_heading = $_POST['announcement_heading'] ?? '';
        if (($current_store['announcement_heading'] ?? '') !== $new_heading) {
            $changes[] = 'Online Store: announcement heading updated';
            $content['online_store']['announcement_heading'] = $new_heading;
        }
        
        $new_description = $_POST['announcement_description'] ?? '';
        if (($current_store['announcement_description'] ?? '') !== $new_description) {
            $changes[] = 'Online Store: announcement description updated';
            $content['online_store']['announcement_description'] = $new_description;
        }
        
        $new_button_text = $_POST['button_text'] ?? '';
        if (($current_store['button_text'] ?? '') !== $new_button_text) {
            $changes[] = 'Online Store: button text updated';
            $content['online_store']['button_text'] = $new_button_text;
        }
        
        $new_button_url = $_POST['button_url'] ?? '';
        if (($current_store['button_url'] ?? '') !== $new_button_url) {
            $changes[] = 'Online Store: button URL updated';
            $content['online_store']['button_url'] = $new_button_url;
        }
        
        // Handle store image upload
        if (isset($_FILES['store_image']) && $_FILES['store_image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../assets/images/online-store/';
            
            // Create directory if it doesn't exist
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            $file_extension = pathinfo($_FILES['store_image']['name'], PATHINFO_EXTENSION);
            $filename = 'online-store.' . $file_extension;
            $upload_path = $upload_dir . $filename;
            
            if (move_uploaded_file($_FILES['store_image']['tmp_name'], $upload_path)) {
                $changes[] = 'Online Store: image updated';
                $content['online_store']['store_image'] = 'assets/images/online-store/' . $filename;
            }
        }
        
        // Only save if there are actual changes
        if (!empty($changes)) {
            // Prepare change details
            $change_details = [
                'section' => 'Online Store',
                'changes' => $changes,
                'field_count' => count($changes)
            ];
            
            if (save_json_data('site-content', $content, 'draft', $change_details)) {
                $message = success_message('Online Store saved to draft successfully!');
            } else {
                $message = error_message('Error saving content. Please try again.');
            }
        } else {
            $message = success_message('No changes detected.');
        }
    }
}

// Load current content
$content = load_json_data('site-content', 'draft');
$online_store = $content['online_store'] ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Store Management - Kaizen Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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
                    <h1><i class="fas fa-shopping-cart me-2 text-primary"></i>Online Store Management</h1>
                </div>
                <?php echo $message; ?>

                <!-- Online Store Management -->
                <div class="content-section">
                    <div class="alert alert-kaizen border-0 mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Online Store:</strong> Manage the online store section content including title, image, announcement, and button details.
                    </div>
                    
                    <form method="POST" enctype="multipart/form-data" id="onlineStoreForm">
                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                        
                        <!-- Basic Information -->
                        <div class="mb-4 p-3 border rounded bg-light">
                            <h5 class="text-primary mb-3"><i class="fas fa-store me-2"></i>Store Information</h5>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Section Title</label>
                                    <input type="text" class="form-control" name="store_title" 
                                           value="<?php echo htmlspecialchars($online_store['title'] ?? ''); ?>" 
                                           placeholder="Online Store">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Store Image</label>
                                    <input type="file" class="form-control" name="store_image" accept="image/*" 
                                           onchange="previewImage(this, 'store-image-preview')">
                                    <div class="form-text">Upload JPG, PNG, or WebP image (max 2MB)</div>
                                    
                                    <!-- Current Image Preview -->
                                    <div class="mt-3" id="store-image-preview">
                                        <?php if (!empty($online_store['store_image'])): ?>
                                            <div class="border rounded p-2 bg-light">
                                                <small class="text-muted d-block mb-2">Current Image:</small>
                                                <img src="../<?php echo htmlspecialchars($online_store['store_image']); ?>" 
                                                     alt="Current Store Image" 
                                                     class="img-fluid border rounded" 
                                                     style="max-height: 150px; max-width: 100%;">
                                                <div class="mt-1">
                                                    <small class="text-muted"><?php echo htmlspecialchars($online_store['store_image']); ?></small>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <small class="text-muted">No image uploaded</small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Announcement Box -->
                        <div class="mb-4 p-3 border rounded bg-light">
                            <h5 class="text-primary mb-3"><i class="fas fa-bullhorn me-2"></i>Announcement Box</h5>
                            
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label">Announcement Heading</label>
                                    <input type="text" class="form-control" name="announcement_heading" 
                                           value="<?php echo htmlspecialchars($online_store['announcement_heading'] ?? ''); ?>" 
                                           placeholder="The online store is now open!">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Announcement Description</label>
                                    <textarea class="form-control" name="announcement_description" rows="3" 
                                              placeholder="Get your karate uniform, t-shirt, & sparring gear shipped directly to your home."><?php echo htmlspecialchars($online_store['announcement_description'] ?? ''); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Button Settings -->
                        <div class="mb-4 p-3 border rounded bg-light">
                            <h5 class="text-primary mb-3"><i class="fas fa-mouse-pointer me-2"></i>Button Settings</h5>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Button Text</label>
                                    <input type="text" class="form-control" name="button_text" 
                                           value="<?php echo htmlspecialchars($online_store['button_text'] ?? ''); ?>" 
                                           placeholder="Shop Now">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Button URL</label>
                                    <input type="url" class="form-control" name="button_url" 
                                           value="<?php echo htmlspecialchars($online_store['button_url'] ?? ''); ?>" 
                                           placeholder="https://kaizenkarate.store/">
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center mb-4">
                            <button type="submit" class="btn btn-kaizen btn-lg">
                                <i class="fas fa-save me-2"></i>Save Online Store Content
                            </button>
                        </div>
                    </form>
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
            
            const reader = new FileReader();
            reader.onload = function(e) {
                if (preview) {
                    // Update the preview area with new image
                    preview.innerHTML = `
                        <div class="border rounded p-2 bg-light">
                            <small class="text-muted d-block mb-2">New Image Preview:</small>
                            <img src="${e.target.result}" alt="Preview" class="img-fluid border rounded" style="max-height: 150px; max-width: 100%;">
                            <div class="mt-1">
                                <small class="text-success"><i class="fas fa-check me-1"></i>New image selected: ${file.name}</small>
                            </div>
                        </div>
                    `;
                }
            };
            reader.readAsDataURL(file);
        }
    }
    </script>
</body>
</html>