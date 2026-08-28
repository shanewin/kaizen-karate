<?php
define('KAIZEN_ADMIN', true);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/error-handling.php';

require_once 'config.php';

require_login();

$message = '';
$validationErrors = [];

if (!function_exists('handle_image_upload')) {
    /**
     * Shared image upload helper (lightweight).
     */
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

if (!function_exists('handle_video_upload')) {
    /**
     * Simple video upload helper.
     */
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
$existingPopup = $content['popup_alert'] ?? [];

$defaultPopup = [
    'enabled' => false,
    'title' => 'Welcome!',
    'display_frequency' => 'once_per_day',
    'show_delay_seconds' => 5,
    'auto_close_seconds' => 0,
    'content_type' => 'text_only',
    'content' => [
        'text' => '<h2>Welcome to Kaizen Karate!</h2><p>Check out our programs...</p>',
        'image' => [
            'src' => '',
            'alt' => ''
        ],
        'video' => [
            'type' => 'embed',
            'value' => ''
        ]
    ],
    'cta' => [
        'enabled' => false,
        'text' => '',
        'url' => '',
        'style' => 'primary'
    ],
    'appearance' => [
        'size' => 'medium',
        'overlay_opacity' => 0.7,
        'close_position' => 'top_right'
    ]
];

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

$contentTypeOptions = [
    'text_only',
    'image_only',
    'video_only',
    'text_image',
    'text_video',
    'full_mixed'
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
        $postedFrequency = $_POST['popup_display_frequency'] ?? $popupAlert['display_frequency'];
        if (!in_array($postedFrequency, $frequencyOptions, true)) {
            $postedFrequency = $popupAlert['display_frequency'];
        }

        $postedDelay = (int)($_POST['popup_show_delay'] ?? $popupAlert['show_delay_seconds']);
        if (!array_key_exists($postedDelay, $delayOptions)) {
            $postedDelay = $popupAlert['show_delay_seconds'];
        }

        $postedAutoClose = max(0, (int)($_POST['popup_auto_close'] ?? $popupAlert['auto_close_seconds']));

        $postedContentType = $_POST['popup_content_type'] ?? $popupAlert['content_type'];
        if (!in_array($postedContentType, $contentTypeOptions, true)) {
            $postedContentType = $popupAlert['content_type'];
        }

        $postedSize = $_POST['popup_size'] ?? $popupAlert['appearance']['size'];
        if (!array_key_exists($postedSize, $sizeOptions)) {
            $postedSize = $popupAlert['appearance']['size'];
        }

        $postedOverlayInput = $_POST['popup_overlay_opacity'] ?? (string)$popupAlert['appearance']['overlay_opacity'];
        if (!array_key_exists((string)$postedOverlayInput, $overlayOptions)) {
            $postedOverlayInput = (string)$popupAlert['appearance']['overlay_opacity'];
        }
        $postedOverlay = (float)$postedOverlayInput;

        $postedClosePosition = $_POST['popup_close_position'] ?? $popupAlert['appearance']['close_position'];
        if (!array_key_exists($postedClosePosition, $closePositions)) {
            $postedClosePosition = $popupAlert['appearance']['close_position'];
        }

        $popupAlert['enabled'] = isset($_POST['popup_enabled']);
        $popupAlert['title'] = sanitize_input($_POST['popup_title'] ?? $popupAlert['title']);
        $popupAlert['display_frequency'] = $postedFrequency;
        $popupAlert['show_delay_seconds'] = $postedDelay;
        $popupAlert['auto_close_seconds'] = $postedAutoClose;
        $popupAlert['content_type'] = $postedContentType;

        $contentText = trim($_POST['popup_content_text'] ?? $popupAlert['content']['text']);
        $contentImageSrc = sanitize_input($_POST['popup_image_existing'] ?? $popupAlert['content']['image']['src']);
        $contentImageAlt = sanitize_input($_POST['popup_image_alt'] ?? $popupAlert['content']['image']['alt']);
        $removeImage = isset($_POST['popup_image_remove']);

        $videoMode = $_POST['popup_video_mode'] ?? ($popupAlert['content']['video']['type'] ?? 'embed');
        $videoEmbed = trim($_POST['popup_video_embed'] ?? ($videoMode === 'embed' ? $popupAlert['content']['video']['value'] : ''));
        $videoExisting = sanitize_input($_POST['popup_video_existing'] ?? ($popupAlert['content']['video']['type'] === 'upload' ? $popupAlert['content']['video']['value'] : ''));
        $removeVideo = isset($_POST['popup_video_remove']);

        $ctaEnabled = isset($_POST['popup_cta_enabled']);
        $ctaText = sanitize_input($_POST['popup_cta_text'] ?? $popupAlert['cta']['text']);
        $ctaUrl = trim($_POST['popup_cta_url'] ?? $popupAlert['cta']['url']);
        $ctaStyle = $_POST['popup_cta_style'] ?? $popupAlert['cta']['style'];
        if (!array_key_exists($ctaStyle, $ctaStyleOptions)) {
            $ctaStyle = $popupAlert['cta']['style'];
        }

        $includesText = in_array($postedContentType, ['text_only', 'text_image', 'text_video', 'full_mixed'], true);
        $includesImage = in_array($postedContentType, ['image_only', 'text_image', 'full_mixed'], true);
        $includesVideo = in_array($postedContentType, ['video_only', 'text_video', 'full_mixed'], true);

        if ($includesText) {
            if ($contentText === '') {
                $validationErrors[] = 'Popup text content is required for the selected content type.';
            } else {
                $popupAlert['content']['text'] = $contentText;
            }
        } else {
            $popupAlert['content']['text'] = '';
        }

        if ($includesImage) {
            if ($removeImage) {
                $contentImageSrc = '';
                $contentImageAlt = '';
            }

            $uploadedImage = handle_image_upload('popup_image_upload', 'assets/images/popup', 'popup-alert');
            if ($uploadedImage) {
                $contentImageSrc = $uploadedImage;
            }

            if ($contentImageSrc === '') {
                $validationErrors[] = 'An image is required for the selected content type.';
            }

            if ($contentImageSrc !== '' && $contentImageAlt === '') {
                $validationErrors[] = 'Image alt text is required for accessibility.';
            }

            $popupAlert['content']['image']['src'] = $contentImageSrc;
            $popupAlert['content']['image']['alt'] = $contentImageAlt;
        } else {
            if ($removeImage) {
                $popupAlert['content']['image']['src'] = '';
                $popupAlert['content']['image']['alt'] = '';
            }
        }

        if ($includesVideo) {
            if ($removeVideo) {
                $videoEmbed = '';
                $videoExisting = '';
            }

            $videoMode = in_array($videoMode, ['embed', 'upload'], true) ? $videoMode : 'embed';

            if ($videoMode === 'upload') {
                $uploadedVideo = handle_video_upload('popup_video_upload', 'assets/videos/popup', 'popup-alert');
                if ($uploadedVideo) {
                    $videoExisting = $uploadedVideo;
                }

                if ($videoExisting === '') {
                    $validationErrors[] = 'Please upload a video file or switch to the embed option.';
                } else {
                    $popupAlert['content']['video'] = [
                        'type' => 'upload',
                        'value' => $videoExisting
                    ];
                }
            } else {
                if ($videoEmbed === '') {
                    $validationErrors[] = 'Please paste a YouTube/Vimeo embed code.';
                } else {
                    $popupAlert['content']['video'] = [
                        'type' => 'embed',
                        'value' => $videoEmbed
                    ];
                }
            }
        } else {
            if ($removeVideo) {
                $popupAlert['content']['video'] = [
                    'type' => 'embed',
                    'value' => ''
                ];
            }
        }

        if ($ctaEnabled) {
            if ($ctaText === '') {
                $validationErrors[] = 'CTA button text is required when the button is enabled.';
            }

            if ($ctaUrl === '' || (!filter_var($ctaUrl, FILTER_VALIDATE_URL) && strpos($ctaUrl, '/') !== 0)) {
                $validationErrors[] = 'CTA button URL must be a valid absolute URL or begin with "/".';
            }

            $popupAlert['cta'] = [
                'enabled' => true,
                'text' => $ctaText,
                'url' => $ctaUrl,
                'style' => $ctaStyle
            ];
        } else {
            $popupAlert['cta'] = [
                'enabled' => false,
                'text' => '',
                'url' => '',
                'style' => 'primary'
            ];
        }

        $popupAlert['appearance'] = [
            'size' => $postedSize,
            'overlay_opacity' => $postedOverlay,
            'close_position' => $postedClosePosition
        ];

        if (empty($validationErrors)) {
            $content['popup_alert'] = $popupAlert;

            if (save_json_data('site-content', $content, 'draft')) {
                $message = success_message('Popup alert saved to draft successfully!');
            } else {
                $message = error_message('Failed to save popup alert settings.');
            }
        } else {
            $message = error_message(implode('<br>', $validationErrors));
        }
    }

    $content = load_json_data('site-content', 'draft');
    $popupAlert = array_replace_recursive($defaultPopup, $content['popup_alert'] ?? []);
}

$page_title = 'Popup Alerts';
$page_icon = 'fas fa-bullhorn';

ob_start();
?>
<div class="content-section">
    <div class="alert alert-kaizen border-0 mb-4">
        <i class="fas fa-info-circle me-2"></i>
        <strong>Popup Alerts:</strong> Configure dynamic announcements for the homepage. These settings control how and when the popup appears to visitors.
    </div>

    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">

        <div class="accordion" id="popupAlertAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="popupSettingsHeading">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#popupSettingsCollapse" aria-expanded="true" aria-controls="popupSettingsCollapse">
                        <i class="fas fa-sliders me-2"></i>Popup Settings
                    </button>
                </h2>
                <div id="popupSettingsCollapse" class="accordion-collapse collapse show" aria-labelledby="popupSettingsHeading" data-bs-parent="#popupAlertAccordion">
                    <div class="accordion-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="popup_enabled" name="popup_enabled" <?php echo $popupAlert['enabled'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="popup_enabled"><strong>Enable Popup</strong></label>
                                </div>
                                <div class="form-text mt-2">Toggle to activate/deactivate the popup site-wide.</div>
                            </div>
                            <div class="col-md-9">
                                <label class="form-label" for="popup_title"><strong>Alert Title (Admin only)</strong></label>
                                <input type="text" class="form-control" id="popup_title" name="popup_title" value="<?php echo htmlspecialchars($popupAlert['title']); ?>" placeholder="Internal reference, e.g., Summer Camp Promo">
                                <div class="form-text">This label helps you identify the popup inside the admin panel.</div>
                            </div>
                        </div>

                        <div class="row g-3 mt-1">
                            <div class="col-md-4">
                                <label class="form-label" for="popup_display_frequency"><strong>Display Frequency</strong></label>
                                <select class="form-select" id="popup_display_frequency" name="popup_display_frequency">
                                    <option value="every_visit" <?php echo $popupAlert['display_frequency'] === 'every_visit' ? 'selected' : ''; ?>>Every visit</option>
                                    <option value="once_per_session" <?php echo $popupAlert['display_frequency'] === 'once_per_session' ? 'selected' : ''; ?>>Once per session</option>
                                    <option value="once_per_day" <?php echo $popupAlert['display_frequency'] === 'once_per_day' ? 'selected' : ''; ?>>Once per day</option>
                                    <option value="once_ever" <?php echo $popupAlert['display_frequency'] === 'once_ever' ? 'selected' : ''; ?>>Once ever</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="popup_show_delay"><strong>Show After Delay</strong></label>
                                <select class="form-select" id="popup_show_delay" name="popup_show_delay">
                                    <?php foreach ($delayOptions as $seconds => $label): ?>
                                        <option value="<?php echo $seconds; ?>" <?php echo $popupAlert['show_delay_seconds'] === $seconds ? 'selected' : ''; ?>><?php echo $label; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="popup_auto_close"><strong>Auto-close After (seconds)</strong></label>
                                <input type="number" class="form-control" id="popup_auto_close" name="popup_auto_close" min="0" value="<?php echo (int)$popupAlert['auto_close_seconds']; ?>">
                                <div class="form-text">Set to 0 to require manual dismissal.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="popupContentHeading">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#popupContentCollapse" aria-expanded="false" aria-controls="popupContentCollapse">
                        <i class="fas fa-file-alt me-2"></i>Content
                    </button>
                </h2>
                <div id="popupContentCollapse" class="accordion-collapse collapse" aria-labelledby="popupContentHeading" data-bs-parent="#popupAlertAccordion">
                    <div class="accordion-body">
                        <div class="mb-3">
                            <label class="form-label" for="popup_content_type"><strong>Content Type</strong></label>
                            <select class="form-select" id="popup_content_type" name="popup_content_type">
                                <option value="text_only" <?php echo $popupAlert['content_type'] === 'text_only' ? 'selected' : ''; ?>>Text Only</option>
                                <option value="image_only" <?php echo $popupAlert['content_type'] === 'image_only' ? 'selected' : ''; ?>>Image Only</option>
                                <option value="video_only" <?php echo $popupAlert['content_type'] === 'video_only' ? 'selected' : ''; ?>>Video Only</option>
                                <option value="text_image" <?php echo $popupAlert['content_type'] === 'text_image' ? 'selected' : ''; ?>>Text + Image</option>
                                <option value="text_video" <?php echo $popupAlert['content_type'] === 'text_video' ? 'selected' : ''; ?>>Text + Video</option>
                                <option value="full_mixed" <?php echo $popupAlert['content_type'] === 'full_mixed' ? 'selected' : ''; ?>>Full Mixed</option>
                            </select>
                        </div>

                        <div class="content-text-fields mb-3">
                            <label class="form-label" for="popup_content_text"><strong>Popup Text Content</strong></label>
                            <textarea class="form-control" id="popup_content_text" name="popup_content_text" rows="6"><?php echo htmlspecialchars($popupAlert['content']['text']); ?></textarea>
                            <div class="form-text">Use formatting to highlight key messages. This content displays inside the popup body.</div>
                        </div>

                        <div class="content-image-fields mb-4 border rounded p-3 bg-light">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0"><i class="fas fa-image me-2 text-primary"></i>Image Content</h6>
                                <?php if (!empty($popupAlert['content']['image']['src'])): ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="popup_image_remove" name="popup_image_remove">
                                        <label class="form-check-label text-danger" for="popup_image_remove">Remove current image</label>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <input type="hidden" name="popup_image_existing" value="<?php echo htmlspecialchars($popupAlert['content']['image']['src']); ?>">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="popup_image_upload"><strong>Upload Image</strong></label>
                                    <input type="file" class="form-control" id="popup_image_upload" name="popup_image_upload" accept="image/*">
                                    <div class="form-text">Recommended formats: JPG, PNG, WEBP, SVG. Optimal width: 600px.</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="popup_image_alt"><strong>Image Alt Text</strong></label>
                                    <input type="text" class="form-control" id="popup_image_alt" name="popup_image_alt" value="<?php echo htmlspecialchars($popupAlert['content']['image']['alt']); ?>" placeholder="Describe the image for accessibility">
                                </div>
                            </div>
                            <?php if (!empty($popupAlert['content']['image']['src'])): ?>
                                <div class="mt-3">
                                    <p class="mb-1"><strong>Current Image Preview:</strong></p>
                                    <img src="../<?php echo htmlspecialchars($popupAlert['content']['image']['src']); ?>" alt="<?php echo htmlspecialchars($popupAlert['content']['image']['alt']); ?>" class="img-thumbnail" style="max-width: 240px;">
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="content-video-fields border rounded p-3 bg-light">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0"><i class="fas fa-video me-2 text-primary"></i>Video Content</h6>
                                <?php if (!empty($popupAlert['content']['video']['value'])): ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="popup_video_remove" name="popup_video_remove">
                                        <label class="form-check-label text-danger" for="popup_video_remove">Remove current video</label>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Video Source</strong></label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input popup-video-mode" type="radio" name="popup_video_mode" id="popup_video_mode_embed" value="embed" <?php echo ($popupAlert['content']['video']['type'] ?? 'embed') === 'embed' ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="popup_video_mode_embed">Embed Code</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input popup-video-mode" type="radio" name="popup_video_mode" id="popup_video_mode_upload" value="upload" <?php echo ($popupAlert['content']['video']['type'] ?? 'embed') === 'upload' ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="popup_video_mode_upload">Upload Video</label>
                                </div>
                            </div>

                            <div class="video-embed-fields mb-3">
                                <label class="form-label" for="popup_video_embed"><strong>Embed Code</strong></label>
                                <textarea class="form-control" id="popup_video_embed" name="popup_video_embed" rows="4" placeholder="Paste YouTube or Vimeo embed code here"><?php echo ($popupAlert['content']['video']['type'] ?? 'embed') === 'embed' ? htmlspecialchars($popupAlert['content']['video']['value']) : ''; ?></textarea>
                                <div class="form-text">Example: &lt;iframe src="https://www.youtube.com/embed/..."&gt;&lt;/iframe&gt;</div>
                            </div>

                            <div class="video-upload-fields">
                                <input type="hidden" name="popup_video_existing" value="<?php echo ($popupAlert['content']['video']['type'] ?? '') === 'upload' ? htmlspecialchars($popupAlert['content']['video']['value']) : ''; ?>">
                                <label class="form-label" for="popup_video_upload"><strong>Upload Video File</strong></label>
                                <input type="file" class="form-control" id="popup_video_upload" name="popup_video_upload" accept="video/mp4,video/webm,video/ogg">
                                <div class="form-text">Supported formats: MP4, WebM, OGG. Max size 20MB recommended.</div>
                                <?php if (($popupAlert['content']['video']['type'] ?? '') === 'upload' && !empty($popupAlert['content']['video']['value'])): ?>
                                    <div class="mt-2">
                                        <span class="badge bg-secondary">Current video:</span>
                                        <code><?php echo htmlspecialchars($popupAlert['content']['video']['value']); ?></code>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="form-text mt-3"><i class="fas fa-life-ring me-1"></i>Paste an embed code or upload a video file. Only one source is required.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="popupCtaHeading">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#popupCtaCollapse" aria-expanded="false" aria-controls="popupCtaCollapse">
                        <i class="fas fa-bullseye me-2"></i>Call-to-Action Button
                    </button>
                </h2>
                <div id="popupCtaCollapse" class="accordion-collapse collapse" aria-labelledby="popupCtaHeading" data-bs-parent="#popupAlertAccordion">
                    <div class="accordion-body">
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="popup_cta_enabled" name="popup_cta_enabled" <?php echo $popupAlert['cta']['enabled'] ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="popup_cta_enabled"><strong>Enable CTA Button</strong></label>
                        </div>

                        <div class="cta-fields row g-3">
                            <div class="col-md-4">
                                <label class="form-label" for="popup_cta_text"><strong>Button Text</strong></label>
                                <input type="text" class="form-control" id="popup_cta_text" name="popup_cta_text" value="<?php echo htmlspecialchars($popupAlert['cta']['text']); ?>" placeholder="e.g., Learn More">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label" for="popup_cta_url"><strong>Button URL</strong></label>
                                <input type="text" class="form-control" id="popup_cta_url" name="popup_cta_url" value="<?php echo htmlspecialchars($popupAlert['cta']['url']); ?>" placeholder="https://example.com or /programs.php">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label" for="popup_cta_style"><strong>Button Style</strong></label>
                                <select class="form-select" id="popup_cta_style" name="popup_cta_style">
                                    <?php foreach ($ctaStyleOptions as $value => $label): ?>
                                        <option value="<?php echo $value; ?>" <?php echo $popupAlert['cta']['style'] === $value ? 'selected' : ''; ?>><?php echo $label; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-text mt-2"><i class="fas fa-link me-1"></i>The CTA button is optional. Disable it if you don't need a redirect.</div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="popupAppearanceHeading">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#popupAppearanceCollapse" aria-expanded="false" aria-controls="popupAppearanceCollapse">
                        <i class="fas fa-paint-brush me-2"></i>Popup Appearance
                    </button>
                </h2>
                <div id="popupAppearanceCollapse" class="accordion-collapse collapse" aria-labelledby="popupAppearanceHeading" data-bs-parent="#popupAlertAccordion">
                    <div class="accordion-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label" for="popup_size"><strong>Popup Size</strong></label>
                                <select class="form-select" id="popup_size" name="popup_size">
                                    <?php foreach ($sizeOptions as $value => $label): ?>
                                        <option value="<?php echo $value; ?>" <?php echo $popupAlert['appearance']['size'] === $value ? 'selected' : ''; ?>><?php echo $label; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="popup_overlay_opacity"><strong>Overlay Opacity</strong></label>
                                <select class="form-select" id="popup_overlay_opacity" name="popup_overlay_opacity">
                                    <?php foreach ($overlayOptions as $value => $label): ?>
                                        <option value="<?php echo $value; ?>" <?php echo (string)$popupAlert['appearance']['overlay_opacity'] === (string)$value ? 'selected' : ''; ?>><?php echo $label; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="popup_close_position"><strong>Close Button Position</strong></label>
                                <select class="form-select" id="popup_close_position" name="popup_close_position">
                                    <?php foreach ($closePositions as $value => $label): ?>
                                        <option value="<?php echo $value; ?>" <?php echo $popupAlert['appearance']['close_position'] === $value ? 'selected' : ''; ?>><?php echo $label; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-text mt-2"><i class="fas fa-adjust me-1"></i>These settings control how the popup looks when rendered on the homepage.</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-kaizen">
                <i class="fas fa-save me-2"></i>Save Popup Alert
            </button>
        </div>
    </form>
</div>

<div class="content-section">
    <h3 class="section-title"><i class="fas fa-lightbulb me-2"></i>Tips & Best Practices</h3>
    <ul class="mb-0">
        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Use the popup sparingly for high-impact announcements.</li>
        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Stick to concise messaging—keep copy under 100 words.</li>
        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Always add alt text for images to keep the popup accessible.</li>
        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Test the popup on both desktop and mobile before publishing.</li>
        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>If using video, prefer short clips (under 30 seconds) to minimize load time.</li>
    </ul>
</div>
<?php
$page_content = ob_get_clean();

include 'includes/admin-template.php';
?>
<script src="https://cdn.tiny.cloud/1/<?php echo TINYMCE_API_KEY; ?>/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>

document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('page-content');
    if (container) {
        container.innerHTML = <?php echo json_encode($page_content); ?>;
    }

    const contentTypeSelect = document.getElementById('popup_content_type');
    const textFields = document.querySelector('.content-text-fields');
    const imageFields = document.querySelector('.content-image-fields');
    const videoFields = document.querySelector('.content-video-fields');
    const videoModeRadios = document.querySelectorAll('.popup-video-mode');
    const videoEmbedFields = document.querySelector('.video-embed-fields');
    const videoUploadFields = document.querySelector('.video-upload-fields');
    const ctaToggle = document.getElementById('popup_cta_enabled');
    const ctaFields = document.querySelector('.cta-fields');

    function toggleContentFields() {
        if (!contentTypeSelect) {
            return;
        }
        const value = contentTypeSelect.value;
        const includesText = ['text_only', 'text_image', 'text_video', 'full_mixed'].includes(value);
        const includesImage = ['image_only', 'text_image', 'full_mixed'].includes(value);
        const includesVideo = ['video_only', 'text_video', 'full_mixed'].includes(value);

        if (textFields) textFields.style.display = includesText ? '' : 'none';
        if (imageFields) imageFields.style.display = includesImage ? '' : 'none';
        if (videoFields) videoFields.style.display = includesVideo ? '' : 'none';
    }

    function toggleVideoSourceFields() {
        const selectedMode = Array.from(videoModeRadios).find(radio => radio.checked)?.value || 'embed';
        if (videoEmbedFields) videoEmbedFields.style.display = selectedMode === 'embed' ? '' : 'none';
        if (videoUploadFields) videoUploadFields.style.display = selectedMode === 'upload' ? '' : 'none';
    }

    function toggleCtaFields() {
        if (!ctaFields) {
            return;
        }
        ctaFields.style.display = ctaToggle && ctaToggle.checked ? '' : 'none';
    }

    contentTypeSelect?.addEventListener('change', toggleContentFields);
    videoModeRadios.forEach(radio => radio.addEventListener('change', toggleVideoSourceFields));
    ctaToggle?.addEventListener('change', toggleCtaFields);

    toggleContentFields();
    toggleVideoSourceFields();
    toggleCtaFields();

    tinymce.init({
        selector: '#popup_content_text',
        menubar: false,
        plugins: 'link lists code',
        toolbar: 'undo redo | bold italic underline | bullist numlist | link | code',
        height: 300,
        branding: false
    });
});
</script>
