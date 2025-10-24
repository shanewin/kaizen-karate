<?php
define('KAIZEN_ADMIN', true);
session_start();
require_once 'config.php';

// Require login
require_login();

$message = '';

// Handle media updates
if ($_POST) {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $message = error_message('Security token invalid. Please try again.');
    } else {
        $media = load_json_data('media.json');
        $section = $_POST['section'] ?? '';
        
        switch ($section) {
            case 'hero_video':
                $media['hero_video']['source'] = sanitize_input($_POST['video_source']);
                $media['hero_video']['poster'] = sanitize_input($_POST['video_poster']);
                $media['hero_video']['alt'] = sanitize_input($_POST['video_alt']);
                break;
                
            case 'logo':
                $media['logo']['main'] = sanitize_input($_POST['logo_main']);
                $media['logo']['mobile'] = sanitize_input($_POST['logo_mobile']);
                $media['logo']['alt'] = sanitize_input($_POST['logo_alt']);
                break;
                
            case 'program_cards':
                foreach ($media['program_cards'] as $key => &$card) {
                    if (isset($_POST[$key . '_image'])) {
                        $card['image'] = sanitize_input($_POST[$key . '_image']);
                        $card['alt'] = sanitize_input($_POST[$key . '_alt']);
                    }
                }
                break;
                
            case 'kenpo_shuffle':
                $shuffle_images = explode("\n", $_POST['shuffle_images']);
                $media['kenpo']['shuffle_images'] = array_map('trim', array_filter($shuffle_images));
                break;
        }
        
        if (save_json_data('media.json', $media)) {
            $message = success_message('Media updated successfully!');
        } else {
            $message = error_message('Failed to save media changes.');
        }
    }
}

// Load current media data
$media = load_json_data('media.json');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Media Management - Kaizen Karate Admin</title>
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
        .media-preview { max-width: 200px; max-height: 150px; object-fit: cover; border-radius: 8px; border: 2px solid #e9ecef; }
        .media-section { border: 1px solid #e9ecef; border-radius: 10px; padding: 1.5rem; margin-bottom: 2rem; }
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
                    <h1><i class="fas fa-images me-2 text-primary"></i>Media Management</h1>
                </div>
                
                <?php echo $message; ?>
                
                <!-- Hero Video -->
                <div class="media-section">
                    <h3 class="section-title"><i class="fas fa-video me-2"></i>Hero Video</h3>
                    <form method="POST">
                        <input type="hidden" name="section" value="hero_video">
                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="video_source" class="form-label">Video Source</label>
                                    <input type="text" class="form-control" id="video_source" name="video_source" 
                                           value="<?php echo htmlspecialchars($media['hero_video']['source'] ?? ''); ?>" 
                                           placeholder="assets/videos/hero/kaizen-hero-video.mp4">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="video_poster" class="form-label">Video Poster Image (Optional)</label>
                                    <input type="text" class="form-control" id="video_poster" name="video_poster" 
                                           value="<?php echo htmlspecialchars($media['hero_video']['poster'] ?? ''); ?>" 
                                           placeholder="assets/images/hero-poster.jpg">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="video_alt" class="form-label">Alt Text</label>
                                    <input type="text" class="form-control" id="video_alt" name="video_alt" 
                                           value="<?php echo htmlspecialchars($media['hero_video']['alt'] ?? ''); ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <?php if (!empty($media['hero_video']['source'])): ?>
                                    <div class="text-center">
                                        <p><strong>Current Video:</strong></p>
                                        <video class="media-preview" controls muted>
                                            <source src="../<?php echo htmlspecialchars($media['hero_video']['source']); ?>" type="video/mp4">
                                        </video>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-kaizen"><i class="fas fa-save me-2"></i>Update Hero Video</button>
                    </form>
                </div>
                
                <!-- Logo -->
                <div class="media-section">
                    <h3 class="section-title"><i class="fas fa-image me-2"></i>Logo</h3>
                    <form method="POST">
                        <input type="hidden" name="section" value="logo">
                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="logo_main" class="form-label">Main Logo</label>
                                    <input type="text" class="form-control" id="logo_main" name="logo_main" 
                                           value="<?php echo htmlspecialchars($media['logo']['main'] ?? ''); ?>" 
                                           placeholder="assets/images/logo.png">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="logo_mobile" class="form-label">Mobile Logo (Optional)</label>
                                    <input type="text" class="form-control" id="logo_mobile" name="logo_mobile" 
                                           value="<?php echo htmlspecialchars($media['logo']['mobile'] ?? ''); ?>" 
                                           placeholder="assets/images/logo-mobile.png">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="logo_alt" class="form-label">Alt Text</label>
                                    <input type="text" class="form-control" id="logo_alt" name="logo_alt" 
                                           value="<?php echo htmlspecialchars($media['logo']['alt'] ?? ''); ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <?php if (!empty($media['logo']['main'])): ?>
                                    <div class="text-center">
                                        <p><strong>Current Logo:</strong></p>
                                        <img src="../<?php echo htmlspecialchars($media['logo']['main']); ?>" 
                                             alt="Logo" class="media-preview">
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-kaizen"><i class="fas fa-save me-2"></i>Update Logo</button>
                    </form>
                </div>
                
                <!-- Program Cards -->
                <div class="media-section">
                    <h3 class="section-title"><i class="fas fa-th-large me-2"></i>Program Card Images</h3>
                    <form method="POST">
                        <input type="hidden" name="section" value="program_cards">
                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                        
                        <?php if (isset($media['program_cards'])): ?>
                            <div class="row">
                                <?php foreach ($media['program_cards'] as $key => $card): ?>
                                    <div class="col-md-6 mb-4">
                                        <div class="card">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0"><?php echo ucwords(str_replace('_', ' ', $key)); ?></h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="mb-3">
                                                            <label class="form-label">Image Path</label>
                                                            <input type="text" class="form-control" 
                                                                   name="<?php echo $key; ?>_image" 
                                                                   value="<?php echo htmlspecialchars($card['image']); ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Alt Text</label>
                                                            <input type="text" class="form-control" 
                                                                   name="<?php echo $key; ?>_alt" 
                                                                   value="<?php echo htmlspecialchars($card['alt']); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="text-center">
                                                            <img src="../<?php echo htmlspecialchars($card['image']); ?>" 
                                                                 alt="<?php echo htmlspecialchars($card['alt']); ?>" 
                                                                 class="media-preview">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        
                        <button type="submit" class="btn btn-kaizen"><i class="fas fa-save me-2"></i>Update Program Cards</button>
                    </form>
                </div>
                
                <!-- Kenpo Shuffle Images -->
                <div class="media-section">
                    <h3 class="section-title"><i class="fas fa-sync-alt me-2"></i>Kenpo Shuffle Images</h3>
                    <form method="POST">
                        <input type="hidden" name="section" value="kenpo_shuffle">
                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="shuffle_images" class="form-label">Shuffle Images (one per line)</label>
                                    <textarea class="form-control" id="shuffle_images" name="shuffle_images" rows="5" 
                                              placeholder="assets/images/kenpo/shuffle/image1.webp&#10;assets/images/kenpo/shuffle/image2.webp"><?php echo htmlspecialchars(implode("\n", $media['kenpo']['shuffle_images'] ?? [])); ?></textarea>
                                    <div class="form-text">Enter one image path per line. These images will rotate automatically.</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <?php if (!empty($media['kenpo']['shuffle_images'])): ?>
                                    <div class="text-center">
                                        <p><strong>Current Images:</strong></p>
                                        <?php foreach (array_slice($media['kenpo']['shuffle_images'], 0, 2) as $image): ?>
                                            <img src="../<?php echo htmlspecialchars($image); ?>" 
                                                 alt="Kenpo Image" class="media-preview mb-2 d-block mx-auto" style="max-width: 100px; max-height: 80px;">
                                        <?php endforeach; ?>
                                        <?php if (count($media['kenpo']['shuffle_images']) > 2): ?>
                                            <small class="text-muted">+ <?php echo count($media['kenpo']['shuffle_images']) - 2; ?> more</small>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-kaizen"><i class="fas fa-save me-2"></i>Update Shuffle Images</button>
                    </form>
                </div>
                
                <!-- Instructions -->
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Media Management Instructions</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>File Paths</h6>
                                <ul>
                                    <li>Use relative paths from your website root</li>
                                    <li>Example: <code>assets/images/logo.png</code></li>
                                    <li>Supported formats: JPG, PNG, WEBP, MP4</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6>Best Practices</h6>
                                <ul>
                                    <li>Always add descriptive alt text for accessibility</li>
                                    <li>Keep image file sizes optimized for web</li>
                                    <li>Test changes by viewing your website</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>