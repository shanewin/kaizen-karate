<?php
define('KAIZEN_ADMIN', true);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once 'config.php';

require_login();

$message = '';
$validationErrors = [];

/**
 * Shared image upload helper (lightweight).
 */
if (!function_exists('handle_image_upload')) {
    function handle_image_upload($field, $relativeDir, $fileName = '')
    {
        if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
        $fileInfo = pathinfo($_FILES[$field]['name']);
        $extension = strtolower($fileInfo['extension'] ?? '');

        if (!in_array($extension, $allowedExtensions, true)) {
            return null;
        }

        $relativeDir = trim($relativeDir, '/');
        $siteRoot = dirname(__DIR__);
        $uploadDir = $siteRoot . '/' . $relativeDir;

        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true)) {
            return null;
        }

        if ($fileName === '') {
            $baseName = preg_replace('/[^a-z0-9_-]/i', '-', $fileInfo['filename'] ?? pathinfo($field, PATHINFO_FILENAME));
            $fileName = $baseName . '-' . uniqid();
        }

        $targetPath = $uploadDir . '/' . $fileName . '.' . $extension;

        if (!move_uploaded_file($_FILES[$field]['tmp_name'], $targetPath)) {
            return null;
        }

        return $relativeDir . '/' . $fileName . '.' . $extension;
    }
}

/**
 * Simple video upload helper.
 */
if (!function_exists('handle_video_upload')) {
    function handle_video_upload($field, $relativeDir, $fileName = '')
    {
        if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $allowedExtensions = ['mp4', 'webm', 'ogg'];
        $fileInfo = pathinfo($_FILES[$field]['name']);
        $extension = strtolower($fileInfo['extension'] ?? '');

        if (!in_array($extension, $allowedExtensions, true)) {
            return null;
        }

        $relativeDir = trim($relativeDir, '/');
        $siteRoot = dirname(__DIR__);
        $uploadDir = $siteRoot . '/' . $relativeDir;

        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true)) {
            return null;
        }

        if ($fileName === '') {
            $baseName = preg_replace('/[^a-z0-9_-]/i', '-', $fileInfo['filename'] ?? pathinfo($field, PATHINFO_FILENAME));
            $fileName = $baseName . '-' . uniqid();
        }

        $targetPath = $uploadDir . '/' . $fileName . '.' . $extension;

        if (!move_uploaded_file($_FILES[$field]['tmp_name'], $targetPath)) {
            return null;
        }

        return $relativeDir . '/' . $fileName . '.' . $extension;
    }
}

$content = load_json_data('site-content', 'draft');
$existingPopup = $content['homepage_popup'] ?? [];

$defaultPopup = [
    'enabled' => false,
    'display_frequency' => 'once_per_day',
    'show_delay_seconds' => 5,
    'slide_interval_seconds' => 4,
    'auto_close_seconds' => 0,
    'appearance' => [
        'size' => 'large',
        'overlay_opacity' => 0.7,
        'close_position' => 'top_right'
    ],
    'slides' => [
        [
            'type' => 'image',
            'src' => 'assets/2026_kaizen_tournament_cup.jpg',
            'alt' => '2026 Kaizen Tournament Cup'
        ],
        [
            'type' => 'dynamic',
            'title' => 'SUMMER CAMP 2026',
            'content_text' => '',
            'cta' => [
                'enabled' => true,
                'text' => 'Learn More',
                'url' => '#summer-camp',
                'style' => 'primary'
            ]
        ]
    ]
];

// Migration: Convert old single-content format to multi-slide if necessary
if (isset($existingPopup['content']) && !isset($existingPopup['slides'])) {
    $oldContent = $existingPopup['content'];
    $oldCta = $existingPopup['cta'] ?? $defaultPopup['slides'][1]['cta'];
    $oldTitle = $existingPopup['title'] ?? $defaultPopup['slides'][1]['title'];
    
    $existingPopup['slides'] = [
        $defaultPopup['slides'][0], // Default Slide 1
        [
            'type' => 'dynamic',
            'title' => $oldTitle,
            'content_text' => $oldContent['text'] ?? '',
            'cta' => $oldCta
        ]
    ];
    unset($existingPopup['content'], $existingPopup['cta'], $existingPopup['title'], $existingPopup['content_type']);
}

$popupAlert = array_replace_recursive($defaultPopup, $existingPopup);

$frequencyOptions = [
    'every_visit',
    'once_per_session',
    'once_per_day',
    'once_ever'
];

$delayOptions = [
    0 => 'Immediately',
    3 => 'After 3 seconds',
    5 => 'After 5 seconds',
    10 => 'After 10 seconds',
    30 => 'After 30 seconds'
];

$sizeOptions = [
    'small' => 'Small (400px)',
    'medium' => 'Medium (600px)',
    'large' => 'Large (800px)',
    'xlarge' => 'Extra Large (1000px)'
];

$overlayOptions = [
    '0.5' => 'Light (50%)',
    '0.7' => 'Medium (70%)',
    '0.9' => 'Dark (90%)'
];

$closePositions = [
    'top_right' => 'Top Right',
    'top_left' => 'Top Left'
];

$ctaStyleOptions = [
    'primary' => 'Primary (Red)',
    'secondary' => 'Secondary (Dark)',
    'success' => 'Success (Green)',
    'info' => 'Info (Blue)'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $message = error_message('Security token invalid. Please try again.');
    } else {
        // Global Settings
        $popupAlert['enabled'] = isset($_POST['popup_enabled']);
        $popupAlert['display_frequency'] = in_array($_POST['popup_display_frequency'] ?? '', $frequencyOptions) ? $_POST['popup_display_frequency'] : $popupAlert['display_frequency'];
        $popupAlert['show_delay_seconds'] = (int)($_POST['popup_show_delay'] ?? $popupAlert['show_delay_seconds']);
        $popupAlert['slide_interval_seconds'] = (int)($_POST['popup_slide_interval'] ?? $popupAlert['slide_interval_seconds']);
        $popupAlert['auto_close_seconds'] = max(0, (int)($_POST['popup_auto_close'] ?? $popupAlert['auto_close_seconds']));
        
        $popupAlert['appearance']['size'] = array_key_exists($_POST['popup_size'] ?? '', $sizeOptions) ? $_POST['popup_size'] : $popupAlert['appearance']['size'];
        $popupAlert['appearance']['overlay_opacity'] = (float)($_POST['popup_overlay_opacity'] ?? $popupAlert['appearance']['overlay_opacity']);
        $popupAlert['appearance']['close_position'] = array_key_exists($_POST['popup_close_position'] ?? '', $closePositions) ? $_POST['popup_close_position'] : $popupAlert['appearance']['close_position'];

        // Process dynamically submitted slides
        $newSlides = [];
        if (isset($_POST['slides']) && is_array($_POST['slides'])) {
            foreach ($_POST['slides'] as $slideId => $slideData) {
                $slideType = $slideData['type'] ?? 'dynamic';
                $sortOrder = (int)($slideData['sort_order'] ?? count($newSlides) + 1);
                
                if ($slideType === 'image') {
                    $slideExisting = $slideData['existing_src'] ?? '';
                    $slideAlt = sanitize_input($slideData['alt'] ?? '');
                    
                    // Handle file upload if present for this specific slide
                    $uploadFieldName = 'slide_upload_' . $slideId;
                    if (isset($_FILES[$uploadFieldName]) && $_FILES[$uploadFieldName]['error'] === UPLOAD_ERR_OK) {
                        $uploaded = handle_image_upload($uploadFieldName, 'assets/images/popup', 'slide-' . $slideId);
                        if ($uploaded) {
                            $slideExisting = $uploaded;
                        }
                    }
                    
                        $newSlides[] = [
                            'type' => 'image',
                            'enabled' => isset($slideData['enabled']),
                            'src' => $slideExisting,
                            'alt' => $slideAlt,
                            'title' => sanitize_input($slideData['title'] ?? ''),
                            'content_text' => trim($slideData['content_text'] ?? ''),
                            'cta' => [
                                'enabled' => isset($slideData['cta_enabled']),
                                'text' => sanitize_input($slideData['cta_text'] ?? 'Learn More'),
                                'url' => trim($slideData['cta_url'] ?? ''),
                                'style' => $slideData['cta_style'] ?? 'danger'
                            ],
                            'sort_order' => $sortOrder
                        ];
                } elseif ($slideType === 'dynamic') {
                    $newSlides[] = [
                        'type' => 'dynamic',
                        'enabled' => isset($slideData['enabled']),
                        'title' => sanitize_input($slideData['title'] ?? ''),
                        'content_text' => trim($slideData['content_text'] ?? ''),
                        'cta' => [
                            'enabled' => isset($slideData['cta_enabled']),
                            'text' => sanitize_input($slideData['cta_text'] ?? 'Learn More'),
                            'url' => trim($slideData['cta_url'] ?? ''),
                            'style' => $slideData['cta_style'] ?? 'primary'
                        ],
                        'sort_order' => $sortOrder
                    ];
                }
            }
        }
        
        // Final fallback if no slides were submitted (e.g. they were all deleted, or error)
        if (empty($newSlides)) {
            $newSlides = $popupAlert['slides']; 
        } else {
            // Reorder based on sort_order
            usort($newSlides, function($a, $b) {
                return $a['sort_order'] <=> $b['sort_order'];
            });
        }

        $popupAlert['slides'] = $newSlides;

        $content['homepage_popup'] = $popupAlert;
        if (save_json_data('site-content', $content, 'draft')) {
            $message = success_message('Homepage popup settings saved successfully!');
        } else {
            $message = error_message('Failed to save settings.');
        }
    }

    $content = load_json_data('site-content', 'draft');
    $popupAlert = array_replace_recursive($defaultPopup, $content['homepage_popup'] ?? []);
}

$page_title = 'Homepage Popup';
$page_icon = 'fas fa-window-restore';

ob_start();
?>
<div class="content-section">
    <div class="alert alert-kaizen border-0 mb-4">
        <i class="fas fa-info-circle me-2"></i>
        <strong>Homepage Popup:</strong> Manage the two alternating sections of your homepage popup.
    </div>

    <form method="POST" enctype="multipart/form-data" id="popup_form">
        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">

        <!-- Global Settings -->
        <div class="mb-4 p-3 border rounded bg-light">
            <h5 class="text-primary mb-3"><i class="fas fa-sliders-h me-2"></i>Global Settings</h5>
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="form-check form-switch pt-2">
                        <input class="form-check-input" type="checkbox" id="popup_enabled" name="popup_enabled" <?php echo $popupAlert['enabled'] ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="popup_enabled"><strong>Enable Popup</strong></label>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label"><strong>Display Frequency</strong></label>
                    <select class="form-select" name="popup_display_frequency">
                        <option value="every_visit" <?php echo $popupAlert['display_frequency'] === 'every_visit' ? 'selected' : ''; ?>>Every visit</option>
                        <option value="once_per_session" <?php echo $popupAlert['display_frequency'] === 'once_per_session' ? 'selected' : ''; ?>>Once per session</option>
                        <option value="once_per_day" <?php echo $popupAlert['display_frequency'] === 'once_per_day' ? 'selected' : ''; ?>>Once per day</option>
                        <option value="once_ever" <?php echo $popupAlert['display_frequency'] === 'once_ever' ? 'selected' : ''; ?>>Once ever</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label"><strong>Delay (Seconds)</strong></label>
                    <select class="form-select" name="popup_show_delay">
                        <?php foreach ($delayOptions as $seconds => $label): ?>
                            <option value="<?php echo $seconds; ?>" <?php echo $popupAlert['show_delay_seconds'] === $seconds ? 'selected' : ''; ?>><?php echo $label; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label"><strong>Slide Interval (Seconds)</strong></label>
                    <input type="number" class="form-control" name="popup_slide_interval" min="1" max="60" value="<?php echo (int)($popupAlert['slide_interval_seconds'] ?? 4); ?>">
                    <div class="form-text">Time between slides</div>
                </div>
                <div class="col-md-3">
                    <label class="form-label"><strong>Auto-close (Seconds)</strong></label>
                    <input type="number" class="form-control" name="popup_auto_close" min="0" value="<?php echo (int)$popupAlert['auto_close_seconds']; ?>">
                    <div class="form-text">0 = Manual close only</div>
                </div>
            </div>
        </div>

        <!-- Appearance Settings -->
        <div class="mb-4 p-3 border rounded bg-light">
            <h5 class="text-primary mb-3"><i class="fas fa-paint-brush me-2"></i>Appearance Settings</h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label"><strong>Modal Size</strong></label>
                    <select class="form-select" name="popup_size">
                        <?php foreach ($sizeOptions as $value => $label): ?>
                            <option value="<?php echo $value; ?>" <?php echo $popupAlert['appearance']['size'] === $value ? 'selected' : ''; ?>><?php echo $label; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label"><strong>Overlay Opacity</strong></label>
                    <select class="form-select" name="popup_overlay_opacity">
                        <?php foreach ($overlayOptions as $value => $label): ?>
                            <option value="<?php echo $value; ?>" <?php echo (string)$popupAlert['appearance']['overlay_opacity'] === (string)$value ? 'selected' : ''; ?>><?php echo $label; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label"><strong>Close Button</strong></label>
                    <select class="form-select" name="popup_close_position">
                        <?php foreach ($closePositions as $value => $label): ?>
                            <option value="<?php echo $value; ?>" <?php echo $popupAlert['appearance']['close_position'] === $value ? 'selected' : ''; ?>><?php echo $label; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <!-- Dynamic Slides Container -->
        <div id="slides_container">
            <?php foreach ($popupAlert['slides'] as $index => $slide): 
                $slideId = uniqid(); 
                $isImageSlide = $slide['type'] === 'image';
            ?>
            <div class="card mb-4 slide-card" data-slide-id="<?php echo $slideId; ?>" id="slide_card_<?php echo $slideId; ?>">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">
                        <?php if ($isImageSlide): ?>
                            <i class="fas fa-image me-2"></i>Slide: Announcement Image & Content
                        <?php else: ?>
                            <i class="fas fa-edit me-2"></i>Slide: Special Offer Content
                        <?php endif; ?>
                    </h6>
                    <div class="d-flex align-items-center">
                        <div class="form-check form-switch me-3 mb-0">
                            <input class="form-check-input" type="checkbox" id="slide_enabled_<?php echo $slideId; ?>" name="slides[<?php echo $slideId; ?>][enabled]" <?php echo (!isset($slide['enabled']) || $slide['enabled']) ? 'checked' : ''; ?>>
                            <label class="form-check-label pt-1" for="slide_enabled_<?php echo $slideId; ?>" style="font-size: 0.85rem; font-weight: 600;">Enabled</label>
                        </div>
                        <span class="badge bg-secondary me-2">Sort: <span class="slide-sort-display"><?php echo $slide['sort_order']; ?></span></span>
                        <button type="button" class="btn btn-sm btn-outline-danger remove-slide-btn" onclick="removeSlide('<?php echo $slideId; ?>')">
                            <i class="fas fa-trash"></i> Remove
                        </button>
                    </div>
                </div>
                <div class="card-body <?php echo $isImageSlide ? 'bg-light bg-opacity-50' : ''; ?>">
                    <input type="hidden" name="slides[<?php echo $slideId; ?>][type]" value="<?php echo htmlspecialchars($slide['type']); ?>">
                    
                    <?php if ($isImageSlide): ?>
                    <!-- Image Slide Content -->
                    <div class="row g-4">
                        <!-- Image Column -->
                        <div class="col-md-5 border-end">
                            <label class="form-label"><strong>Current Image</strong></label>
                            <div class="border rounded p-3 bg-white text-center mb-3">
                                <?php if (!empty($slide['src'])): ?>
                                    <img src="../<?php echo htmlspecialchars($slide['src']); ?>" class="img-fluid rounded shadow-sm" style="max-height: 250px; object-fit: contain;">
                                <?php else: ?>
                                    <div class="text-muted p-4"><i class="fas fa-image fa-3x mb-2"></i><br>No image uploaded</div>
                                <?php endif; ?>
                                <input type="hidden" name="slides[<?php echo $slideId; ?>][existing_src]" value="<?php echo htmlspecialchars($slide['src'] ?? ''); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Update Image</strong></label>
                                <input type="file" class="form-control" name="slide_upload_<?php echo $slideId; ?>" accept="image/*">
                                <div class="form-text small">Recommended: Vertical flyer (ratio approx 4:5 or 2:3).</div>
                            </div>
                            <div class="mb-0">
                                <label class="form-label small"><strong>Alt Text</strong></label>
                                <input type="text" class="form-control form-control-sm" name="slides[<?php echo $slideId; ?>][alt]" value="<?php echo htmlspecialchars($slide['alt'] ?? ''); ?>" placeholder="e.g., 2026 Kaizen Tournament Cup">
                            </div>
                        </div>
                        <!-- Content Column -->
                        <div class="col-md-7">
                            <div class="row g-3 mb-3">
                                <div class="col-md-8">
                                    <label class="form-label"><strong>Slide Title (Optional)</strong></label>
                                    <input type="text" class="form-control" name="slides[<?php echo $slideId; ?>][title]" value="<?php echo htmlspecialchars($slide['title'] ?? ''); ?>" placeholder="e.g. Register today!">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label"><strong>Sort Order</strong></label>
                                    <input type="number" class="form-control sort-order-input" name="slides[<?php echo $slideId; ?>][sort_order]" value="<?php echo (int)($slide['sort_order'] ?? $index + 1); ?>" min="1">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Message Text</strong></label>
                                <textarea class="tinymce-editor" name="slides[<?php echo $slideId; ?>][content_text]"><?php echo htmlspecialchars($slide['content_text'] ?? ''); ?></textarea>
                            </div>
                            <div class="border rounded p-3 bg-white shadow-sm">
                                <h6 class="mb-3 fw-bold text-dark"><i class="fas fa-external-link-alt me-2 text-primary"></i>Button (CTA)</h6>
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input cta-toggle" type="checkbox" id="cta_enabled_<?php echo $slideId; ?>" name="slides[<?php echo $slideId; ?>][cta_enabled]" <?php echo !empty($slide['cta']['enabled']) ? 'checked' : ''; ?> data-target="cta_fields_<?php echo $slideId; ?>">
                                    <label class="form-check-label h6 mb-0" for="cta_enabled_<?php echo $slideId; ?>">Enabled</label>
                                </div>
                                <div id="cta_fields_<?php echo $slideId; ?>" style="<?php echo empty($slide['cta']['enabled']) ? 'display: none;' : ''; ?>">
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <label class="form-label small"><strong>Button Text</strong></label>
                                            <input type="text" class="form-control form-control-sm" name="slides[<?php echo $slideId; ?>][cta_text]" value="<?php echo htmlspecialchars($slide['cta']['text'] ?? 'Learn More'); ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small"><strong>Style</strong></label>
                                            <select class="form-select form-select-sm" name="slides[<?php echo $slideId; ?>][cta_style]">
                                                <?php foreach ($ctaStyleOptions as $val => $lbl): ?>
                                                    <option value="<?php echo $val; ?>" <?php echo ($slide['cta']['style'] ?? 'danger') === $val ? 'selected' : ''; ?>><?php echo $lbl; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label small"><strong>Link URL</strong></label>
                                            <input type="text" class="form-control form-control-sm" name="slides[<?php echo $slideId; ?>][cta_url]" value="<?php echo htmlspecialchars($slide['cta']['url'] ?? ''); ?>" placeholder="https://...">
                                            
                                            <div class="mt-2 p-2 bg-light border rounded small">
                                                <strong><i class="fas fa-info-circle text-primary me-1"></i>Internal Links:</strong><br>
                                                Use section IDs to scroll smoothly to homepage sections (e.g., <code>#summer-camp</code>).<br>
                                                <a href="#availableLinks_<?php echo $slideId; ?>" data-bs-toggle="collapse" class="text-decoration-none"><i class="fas fa-list me-1"></i>View available links</a>
                                                <div class="collapse mt-2" id="availableLinks_<?php echo $slideId; ?>">
                                                    <ul class="list-unstyled mb-0 text-muted">
                                                        <li><code>#about</code> - About Us</li>
                                                        <li><code>#summer-camp</code> - Summer Camp</li>
                                                        <li><code>#kaizen-dojo</code> - Kaizen Dojo</li>
                                                        <li><code>#weekend-evening</code> - After School</li>
                                                        <li><code>#online-store</code> - Store</li>
                                                        <li><code>#belt-exam</code> - Belt Exams</li>
                                                        <li><code>#kaizen-kenpo</code> - Kaizen Kenpo</li>
                                                        <li><code>#training-options</code> - Training Options</li>
                                                        <li><code>#contact</code> - Contact Us</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php else: ?>
                    <!-- Dynamic Slide Content -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label class="form-label"><strong>Section Title</strong></label>
                            <input type="text" class="form-control" name="slides[<?php echo $slideId; ?>][title]" value="<?php echo htmlspecialchars($slide['title'] ?? ''); ?>" placeholder="e.g., SUMMER CAMP 2026">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><strong>Sort Order</strong></label>
                            <input type="number" class="form-control sort-order-input" name="slides[<?php echo $slideId; ?>][sort_order]" value="<?php echo (int)($slide['sort_order'] ?? $index + 1); ?>" min="1">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Message Content</strong></label>
                        <textarea class="form-control tinymce-editor" name="slides[<?php echo $slideId; ?>][content_text]"><?php echo htmlspecialchars($slide['content_text'] ?? ''); ?></textarea>
                    </div>
                    <div class="border rounded p-3 bg-light">
                        <h6 class="mb-3"><i class="fas fa-bullseye me-2"></i>Call-to-Action Component</h6>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input cta-toggle" type="checkbox" id="cta_enabled_<?php echo $slideId; ?>" name="slides[<?php echo $slideId; ?>][cta_enabled]" <?php echo (!empty($slide['cta']['enabled'])) ? 'checked' : ''; ?> data-target="cta_fields_<?php echo $slideId; ?>">
                            <label class="form-check-label" for="cta_enabled_<?php echo $slideId; ?>">Show CTA Button</label>
                        </div>
                        <div id="cta_fields_<?php echo $slideId; ?>" style="<?php echo empty($slide['cta']['enabled']) ? 'display: none;' : ''; ?>">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label"><strong>Button Text</strong></label>
                                    <input type="text" class="form-control" name="slides[<?php echo $slideId; ?>][cta_text]" value="<?php echo htmlspecialchars($slide['cta']['text'] ?? 'Learn More'); ?>">
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label"><strong>Link URL</strong></label>
                                    <input type="text" class="form-control" name="slides[<?php echo $slideId; ?>][cta_url]" value="<?php echo htmlspecialchars($slide['cta']['url'] ?? ''); ?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label"><strong>Style</strong></label>
                                    <select class="form-select" name="slides[<?php echo $slideId; ?>][cta_style]">
                                        <?php foreach ($ctaStyleOptions as $value => $label): ?>
                                            <option value="<?php echo $value; ?>" <?php echo ($slide['cta']['style'] ?? 'primary') === $value ? 'selected' : ''; ?>><?php echo $label; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mt-3 p-2 bg-white border rounded small">
                                <strong><i class="fas fa-info-circle text-primary me-1"></i>Internal Links:</strong><br>
                                Use section IDs in the Link URL field to scroll smoothly to homepage sections (e.g., <code>#summer-camp</code>).<br>
                                <a href="#availableLinksDyn_<?php echo $slideId; ?>" data-bs-toggle="collapse" class="text-decoration-none"><i class="fas fa-list me-1"></i>View available links</a>
                                <div class="collapse mt-2" id="availableLinksDyn_<?php echo $slideId; ?>">
                                    <ul class="list-unstyled mb-0 text-muted">
                                        <li><code>#about</code> - About Us</li>
                                        <li><code>#summer-camp</code> - Summer Camp</li>
                                        <li><code>#kaizen-dojo</code> - Kaizen Dojo</li>
                                        <li><code>#weekend-evening</code> - After School</li>
                                        <li><code>#online-store</code> - Store</li>
                                        <li><code>#belt-exam</code> - Belt Exams</li>
                                        <li><code>#kaizen-kenpo</code> - Kaizen Kenpo</li>
                                        <li><code>#training-options</code> - Training Options</li>
                                        <li><code>#contact</code> - Contact Us</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Add Slide Actions -->
        <div class="card mb-4 border-primary border-2 border-dashed bg-transparent shadow-none" id="add_slide_actions">
            <div class="card-body text-center py-4">
                <h6 class="text-primary mb-3"><i class="fas fa-plus-circle me-2"></i>Add New Slide</h6>
                <div class="d-flex justify-content-center gap-3">
                    <button type="button" class="btn btn-outline-primary" onclick="addSlide('image')">
                        <i class="fas fa-image me-2"></i>Add Image Content Slide
                    </button>
                    <button type="button" class="btn btn-outline-success" onclick="addSlide('dynamic')">
                        <i class="fas fa-edit me-2"></i>Add Special Offer Slide
                    </button>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-kaizen btn-lg px-5 shadow-sm">
                <i class="fas fa-save me-2"></i>Save Multi-Slide Popup
            </button>
        </div>
    </form>
</div>

<?php
$page_content = ob_get_clean();

include 'includes/admin-template.php';
?>
<!-- Hidden Templates for JavaScript -->
<template id="tmpl-slide-image">
    <div class="card mb-4 slide-card" data-slide-id="{{ID}}" id="slide_card_{{ID}}">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h6 class="mb-0"><i class="fas fa-image me-2"></i>Slide: Announcement Image & Content</h6>
            <div class="d-flex align-items-center">
                <div class="form-check form-switch me-3 mb-0">
                    <input class="form-check-input" type="checkbox" id="slide_enabled_{{ID}}" name="slides[{{ID}}][enabled]" checked>
                    <label class="form-check-label pt-1" for="slide_enabled_{{ID}}" style="font-size: 0.85rem; font-weight: 600;">Enabled</label>
                </div>
                <span class="badge bg-secondary me-2">Sort: <span class="slide-sort-display">{{SORT}}</span></span>
                <button type="button" class="btn btn-sm btn-outline-danger remove-slide-btn" onclick="removeSlide('{{ID}}')">
                    <i class="fas fa-trash"></i> Remove
                </button>
            </div>
        </div>
        <div class="card-body bg-light bg-opacity-50">
            <input type="hidden" name="slides[{{ID}}][type]" value="image">
            <div class="row g-4">
                <div class="col-md-5 border-end">
                    <label class="form-label"><strong>Image Upload</strong></label>
                    <div class="mb-3">
                        <input type="file" class="form-control" name="slide_upload_{{ID}}" accept="image/*" required>
                        <div class="form-text small">Recommended: Vertical flyer (ratio approx 4:5 or 2:3).</div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small"><strong>Alt Text</strong></label>
                        <input type="text" class="form-control form-control-sm" name="slides[{{ID}}][alt]" placeholder="e.g., 2026 Kaizen Tournament Cup">
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label class="form-label"><strong>Slide Title (Optional)</strong></label>
                            <input type="text" class="form-control" name="slides[{{ID}}][title]" placeholder="e.g. Register today!">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><strong>Sort Order</strong></label>
                            <input type="number" class="form-control sort-order-input" name="slides[{{ID}}][sort_order]" value="{{SORT}}" min="1">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Message Text</strong></label>
                        <textarea class="tinymce-editor" name="slides[{{ID}}][content_text]" id="tinymce_{{ID}}"></textarea>
                    </div>
                    <div class="border rounded p-3 bg-white shadow-sm">
                        <h6 class="mb-3 fw-bold text-dark"><i class="fas fa-external-link-alt me-2 text-primary"></i>Button (CTA)</h6>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input cta-toggle" type="checkbox" id="cta_enabled_{{ID}}" name="slides[{{ID}}][cta_enabled]" data-target="cta_fields_{{ID}}">
                            <label class="form-check-label h6 mb-0" for="cta_enabled_{{ID}}">Enabled</label>
                        </div>
                        <div id="cta_fields_{{ID}}" style="display: none;">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label class="form-label small"><strong>Button Text</strong></label>
                                    <input type="text" class="form-control form-control-sm" name="slides[{{ID}}][cta_text]" value="Learn More">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small"><strong>Style</strong></label>
                                    <select class="form-select form-select-sm" name="slides[{{ID}}][cta_style]">
                                        <?php foreach ($ctaStyleOptions as $val => $lbl): ?>
                                            <option value="<?php echo $val; ?>"><?php echo $lbl; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label small"><strong>Link URL</strong></label>
                                    <input type="text" class="form-control form-control-sm" name="slides[{{ID}}][cta_url]" placeholder="https://...">
                                    
                                    <div class="mt-2 p-2 bg-light border rounded small">
                                        <strong><i class="fas fa-info-circle text-primary me-1"></i>Internal Links:</strong><br>
                                        Use section IDs to scroll smoothly to homepage sections (e.g., <code>#summer-camp</code>).<br>
                                        <a href="#availableLinks_{{ID}}" data-bs-toggle="collapse" class="text-decoration-none"><i class="fas fa-list me-1"></i>View available links</a>
                                        <div class="collapse mt-2" id="availableLinks_{{ID}}">
                                            <ul class="list-unstyled mb-0 text-muted">
                                                <li><code>#about</code> - About Us</li>
                                                <li><code>#summer-camp</code> - Summer Camp</li>
                                                <li><code>#kaizen-dojo</code> - Kaizen Dojo</li>
                                                <li><code>#weekend-evening</code> - After School</li>
                                                <li><code>#online-store</code> - Store</li>
                                                <li><code>#belt-exam</code> - Belt Exams</li>
                                                <li><code>#kaizen-kenpo</code> - Kaizen Kenpo</li>
                                                <li><code>#training-options</code> - Training Options</li>
                                                <li><code>#contact</code> - Contact Us</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<template id="tmpl-slide-dynamic">
    <div class="card mb-4 slide-card" data-slide-id="{{ID}}" id="slide_card_{{ID}}">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h6 class="mb-0"><i class="fas fa-edit me-2"></i>Slide: Special Offer Content</h6>
            <div class="d-flex align-items-center">
                <div class="form-check form-switch me-3 mb-0">
                    <input class="form-check-input" type="checkbox" id="slide_enabled_{{ID}}" name="slides[{{ID}}][enabled]" checked>
                    <label class="form-check-label pt-1" for="slide_enabled_{{ID}}" style="font-size: 0.85rem; font-weight: 600;">Enabled</label>
                </div>
                <span class="badge bg-secondary me-2">Sort: <span class="slide-sort-display">{{SORT}}</span></span>
                <button type="button" class="btn btn-sm btn-outline-danger remove-slide-btn" onclick="removeSlide('{{ID}}')">
                    <i class="fas fa-trash"></i> Remove
                </button>
            </div>
        </div>
        <div class="card-body">
            <input type="hidden" name="slides[{{ID}}][type]" value="dynamic">
            <div class="row g-3 mb-3">
                <div class="col-md-8">
                    <label class="form-label"><strong>Section Title</strong></label>
                    <input type="text" class="form-control" name="slides[{{ID}}][title]" placeholder="e.g., SUMMER CAMP 2026">
                </div>
                <div class="col-md-4">
                    <label class="form-label"><strong>Sort Order</strong></label>
                    <input type="number" class="form-control sort-order-input" name="slides[{{ID}}][sort_order]" value="{{SORT}}" min="1">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label"><strong>Message Content</strong></label>
                <textarea class="form-control tinymce-editor" name="slides[{{ID}}][content_text]" id="tinymce_{{ID}}"></textarea>
            </div>
            <div class="border rounded p-3 bg-light">
                <h6 class="mb-3"><i class="fas fa-bullseye me-2"></i>Call-to-Action Component</h6>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input cta-toggle" type="checkbox" id="cta_enabled_{{ID}}" name="slides[{{ID}}][cta_enabled]" data-target="cta_fields_{{ID}}">
                    <label class="form-check-label" for="cta_enabled_{{ID}}">Show CTA Button</label>
                </div>
                <div id="cta_fields_{{ID}}" style="display: none;">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label"><strong>Button Text</strong></label>
                            <input type="text" class="form-control" name="slides[{{ID}}][cta_text]" value="Learn More">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label"><strong>Link URL</strong></label>
                            <input type="text" class="form-control" name="slides[{{ID}}][cta_url]">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label"><strong>Style</strong></label>
                            <select class="form-select" name="slides[{{ID}}][cta_style]">
                                <?php foreach ($ctaStyleOptions as $val => $lbl): ?>
                                    <option value="<?php echo $val; ?>"><?php echo $lbl; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mt-3 p-2 bg-white border rounded small">
                        <strong><i class="fas fa-info-circle text-primary me-1"></i>Internal Links:</strong><br>
                        Use section IDs in the Link URL field to scroll smoothly to homepage sections (e.g., <code>#summer-camp</code>).<br>
                        <a href="#availableLinksDyn_{{ID}}" data-bs-toggle="collapse" class="text-decoration-none"><i class="fas fa-list me-1"></i>View available links</a>
                        <div class="collapse mt-2" id="availableLinksDyn_{{ID}}">
                            <ul class="list-unstyled mb-0 text-muted">
                                <li><code>#about</code> - About Us</li>
                                <li><code>#summer-camp</code> - Summer Camp</li>
                                <li><code>#kaizen-dojo</code> - Kaizen Dojo</li>
                                <li><code>#weekend-evening</code> - After School</li>
                                <li><code>#online-store</code> - Store</li>
                                <li><code>#belt-exam</code> - Belt Exams</li>
                                <li><code>#kaizen-kenpo</code> - Kaizen Kenpo</li>
                                <li><code>#training-options</code> - Training Options</li>
                                <li><code>#contact</code> - Contact Us</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script src="https://cdn.tiny.cloud/1/<?php echo TINYMCE_API_KEY; ?>/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
function initTinyMCE(selector) {
    tinymce.init({
        selector: selector,
        menubar: false,
        plugins: 'link lists code',
        toolbar: 'undo redo | bold italic underline | bullist numlist | link | code',
        height: 250,
        branding: false,
        setup: function(editor) {
            editor.on('change', function() {
                tinymce.triggerSave();
            });
        }
    });
}

function rebindCtaToggles() {
    document.querySelectorAll('.cta-toggle').forEach(function(toggle) {
        // Remove old listener to avoid duplicates if called multiple times
        let newToggle = toggle.cloneNode(true);
        toggle.parentNode.replaceChild(newToggle, toggle);
        
        newToggle.addEventListener('change', function() {
            const targetId = this.getAttribute('data-target');
            const targetEl = document.getElementById(targetId);
            if (targetEl) {
                targetEl.style.display = this.checked ? '' : 'none';
            }
        });
    });
}

function addSlide(type) {
    const container = document.getElementById('slides_container');
    const existingSlides = container.querySelectorAll('.slide-card').length;
    const newSortOrder = existingSlides + 1;
    const newId = 'new_' + Math.random().toString(36).substr(2, 9);
    
    const tmplId = type === 'image' ? 'tmpl-slide-image' : 'tmpl-slide-dynamic';
    const tmpl = document.getElementById(tmplId).innerHTML;
    
    let html = tmpl.replace(/{{ID}}/g, newId).replace(/{{SORT}}/g, newSortOrder);
    
    // Convert to DOM node to append gracefully
    const wrapper = document.createElement('div');
    wrapper.innerHTML = html.trim();
    const slideNode = wrapper.firstChild;
    
    container.appendChild(slideNode);
    
    // Initialize things on new node
    initTinyMCE('#tinymce_' + newId);
    rebindCtaToggles();
    rebindSortOrderInputs();
}

function removeSlide(id) {
    if (confirm('Are you sure you want to remove this slide? It will not be saved.')) {
        const slideCard = document.getElementById('slide_card_' + id);
        if (slideCard) {
            slideCard.remove();
            recalculateSortOrders();
        }
    }
}

function recalculateSortOrders() {
    const container = document.getElementById('slides_container');
    const inputs = container.querySelectorAll('.sort-order-input');
    const displays = container.querySelectorAll('.slide-sort-display');
    
    inputs.forEach((input, index) => {
        const order = index + 1;
        input.value = order;
        if (displays[index]) {
            displays[index].textContent = order;
        }
    });
}

function rebindSortOrderInputs() {
    document.querySelectorAll('.sort-order-input').forEach(input => {
        input.addEventListener('input', function() {
            // Traverse up to find the corresponding display and update it
            const card = this.closest('.slide-card');
            if (card) {
                const display = card.querySelector('.slide-sort-display');
                if (display) {
                    display.textContent = this.value || '?';
                }
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('page-content');
    if (container) {
        container.innerHTML = <?php echo json_encode($page_content); ?>;
    }

    initTinyMCE('.tinymce-editor');
    rebindCtaToggles();
    rebindSortOrderInputs();
});
</script>
