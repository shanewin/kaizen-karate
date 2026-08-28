<?php
if (!defined('KAIZEN_ADMIN')) {
    define('KAIZEN_ADMIN', true);
}

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once 'config.php';

require_login();

$message = '';

function handle_image_upload($field, $relativeDir, $fileName = '')
{
    $logFile = dirname(__DIR__) . '/data/logs/kaizen-kenpo-upload.log';
    $log = function ($message) use ($logFile) {
        $logDir = dirname($logFile);
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }
        file_put_contents($logFile, '[' . date('c') . "] {$message}\n", FILE_APPEND);
    };

    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
        $log("Upload skipped for {$field}: error code " . ($_FILES[$field]['error'] ?? 'n/a'));
        return null;
    }

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
    $fileInfo = pathinfo($_FILES[$field]['name']);
    $extension = strtolower($fileInfo['extension'] ?? '');

    if (!in_array($extension, $allowedExtensions, true)) {
        $log("Upload rejected for {$field}: unsupported extension '{$extension}'");
        return null;
    }

    $relativeDir = trim($relativeDir, '/');
    $siteRoot = dirname(__DIR__);
    $uploadDir = $siteRoot . '/' . $relativeDir;

    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true)) {
        $log("Failed to create upload directory {$uploadDir}");
        return null;
    }

    if ($fileName === '') {
        $baseName = preg_replace('/[^a-z0-9_-]/i', '-', $fileInfo['filename'] ?? pathinfo($field, PATHINFO_FILENAME));
        $fileName = $baseName . '-' . uniqid();
    }

    $fileName .= '.' . $extension;
    $targetPath = $uploadDir . '/' . $fileName;
    $log("Attempting to move {$field} to {$targetPath} from {$_FILES[$field]['tmp_name']}");

    if (!move_uploaded_file($_FILES[$field]['tmp_name'], $targetPath)) {
        $log("move_uploaded_file failed for {$field}");
        return null;
    }

    $log("Upload success for {$field}: {$relativeDir}/{$fileName}");
    return $relativeDir . '/' . $fileName;
}




$defaultKaizenKenpo = [
    'settings' => [
        'section_title' => 'Kaizen Kenpo',
        'nav_label' => 'Kaizen Kenpo',
        'logo' => [
            'image' => 'assets/images/kenpo/kenpo-logo.png',
            'alt' => 'Kaizen Kenpo Logo'
        ],
        'tabs' => [
            ['id' => 'about', 'label' => 'Kaizen Kenpo Home', 'icon' => 'fas fa-home'],
            ['id' => 'ikca', 'label' => 'What is IKCA Kenpo?', 'icon' => 'fas fa-question-circle'],
            ['id' => 'gallery', 'label' => 'Photo Gallery', 'icon' => 'fas fa-images'],
            ['id' => 'contact', 'label' => 'Contact & Location', 'icon' => 'fas fa-map-marker-alt']
        ]
    ],
    'tabs' => [
        'about' => [
            'hero_image' => ['src' => '', 'alt' => ''],
            'lead_text' => '',
            'class_schedule' => ['label' => 'Class Time', 'value' => ''],
            'highlight' => ['icon' => 'fas fa-star', 'title' => '', 'text' => ''],
            'cta_primary' => ['label' => '', 'url' => ''],
            'cta_secondary' => ['label' => '', 'url' => '']
        ],
        'ikca' => [
            'image' => ['src' => '', 'alt' => '', 'caption' => ''],
            'intro_heading' => '',
            'paragraphs' => ['', '', ''],
            'video_embed' => ''
        ],
        'gallery' => [
            'intro_text' => '',
            'images' => []
        ],
        'contact' => [
            'map' => ['heading' => 'Find Us', 'embed_url' => ''],
            'location' => ['heading' => 'Location', 'lines' => []],
            'contact' => ['heading' => 'Contact Us', 'phone' => '', 'email' => ''],
            'class_time' => ['heading' => 'Class Time', 'value' => '']
        ]
    ]
];

$content = load_json_data('site-content', 'draft');
$kaizenKenpo = $content['kaizen_kenpo'] ?? [];
$kaizenKenpo = array_replace_recursive($defaultKaizenKenpo, $kaizenKenpo);

if (!isset($kaizenKenpo['settings']['tabs']) || !is_array($kaizenKenpo['settings']['tabs'])) {
    $kaizenKenpo['settings']['tabs'] = $defaultKaizenKenpo['settings']['tabs'];
}

$kaizenKenpo['settings']['tabs'] = array_values($kaizenKenpo['settings']['tabs']);

if (!isset($kaizenKenpo['tabs']['ikca']['paragraphs']) || !is_array($kaizenKenpo['tabs']['ikca']['paragraphs'])) {
    $kaizenKenpo['tabs']['ikca']['paragraphs'] = ['', '', ''];
}

for ($i = 0; $i < 3; $i++) {
    if (!isset($kaizenKenpo['tabs']['ikca']['paragraphs'][$i])) {
        $kaizenKenpo['tabs']['ikca']['paragraphs'][$i] = '';
    }
}

$galleryMaxImages = 20;

if (!isset($kaizenKenpo['tabs']['gallery']['images']) || !is_array($kaizenKenpo['tabs']['gallery']['images'])) {
    $kaizenKenpo['tabs']['gallery']['images'] = [];
}

$normalizedGalleryImages = [];
$highestGalleryIndex = -1;
foreach ($kaizenKenpo['tabs']['gallery']['images'] as $image) {
    if (!is_array($image)) {
        continue;
    }

    $src = $image['src'] ?? '';
    $alt = $image['alt'] ?? '';
    $caption = $image['caption'] ?? '';

    if ($src === '' && $alt === '' && $caption === '') {
        continue;
    }

    $slotId = isset($image['id']) ? (int)$image['id'] : null;
    if ($slotId === null || $slotId < 0) {
        $slotId = $highestGalleryIndex + 1;
    }

    if ($slotId > $highestGalleryIndex) {
        $highestGalleryIndex = $slotId;
    }

    $normalizedGalleryImages[] = [
        'id' => $slotId,
        'src' => $src,
        'alt' => $alt,
        'caption' => $caption
    ];
}

usort($normalizedGalleryImages, function ($a, $b) {
    return ($a['id'] ?? 0) <=> ($b['id'] ?? 0);
});

$kaizenKenpo['tabs']['gallery']['images'] = $normalizedGalleryImages;
$nextGalleryId = $highestGalleryIndex + 1;
if ($nextGalleryId < 0) {
    $nextGalleryId = 0;
}
$kaizenKenpo['tabs']['gallery']['next_id'] = min($nextGalleryId, $galleryMaxImages);

$iconOptions = [
    'fas fa-home' => 'Home',
    'fas fa-question-circle' => 'Question',
    'fas fa-images' => 'Images',
    'fas fa-map-marker-alt' => 'Map Marker',
    'fas fa-star' => 'Star',
    'fas fa-user-plus' => 'User Plus',
    'fas fa-link' => 'Link',
    'fas fa-info-circle' => 'Info Circle',
    'fas fa-hand-point-right' => 'Hand Point Right',
    'fas fa-flag' => 'Flag'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $message = error_message('Security token invalid. Please try again.');
    } else {
        $section = $_POST['section'] ?? '';

        switch ($section) {
            case 'basics':
                $kaizenKenpo['settings']['section_title'] = sanitize_input($_POST['kenpo_section_title'] ?? $kaizenKenpo['settings']['section_title']);
                $kaizenKenpo['settings']['nav_label'] = sanitize_input($_POST['kenpo_nav_label'] ?? $kaizenKenpo['settings']['nav_label']);
                $kaizenKenpo['settings']['logo']['alt'] = sanitize_input($_POST['kenpo_logo_alt'] ?? $kaizenKenpo['settings']['logo']['alt']);

                $uploadedLogo = handle_image_upload('kenpo_logo_image', 'assets/images/kenpo', 'kenpo-logo');
                if ($uploadedLogo) {
                    $kaizenKenpo['settings']['logo']['image'] = $uploadedLogo;
                }

                $content['kaizen_kenpo'] = $kaizenKenpo;
                if (save_json_data('site-content', $content)) {
                    $message = success_message('Section basics saved to draft successfully!');
                } else {
                    $message = error_message('Failed to save section basics.');
                }
                break;

            case 'tab_settings':
                foreach ($kaizenKenpo['settings']['tabs'] as $index => &$tabMeta) {
                    $tabMeta['label'] = sanitize_input($_POST['tab_label_' . $index] ?? $tabMeta['label']);
                    $tabMeta['icon'] = sanitize_input($_POST['tab_icon_' . $index] ?? $tabMeta['icon']);
                }
                unset($tabMeta);

                $content['kaizen_kenpo'] = $kaizenKenpo;
                if (save_json_data('site-content', $content)) {
                    $message = success_message('Tab settings saved to draft successfully!');
                } else {
                    $message = error_message('Failed to save tab settings.');
                }
                break;

            case 'tab_about':
                $about = &$kaizenKenpo['tabs']['about'];
                $about['lead_text'] = sanitize_input($_POST['about_lead_text'] ?? $about['lead_text']);
                $about['class_schedule']['label'] = sanitize_input($_POST['about_schedule_label'] ?? $about['class_schedule']['label']);
                $about['class_schedule']['value'] = sanitize_input($_POST['about_schedule_value'] ?? $about['class_schedule']['value']);
                $about['highlight']['icon'] = sanitize_input($_POST['about_highlight_icon'] ?? $about['highlight']['icon']);
                $about['highlight']['title'] = sanitize_input($_POST['about_highlight_title'] ?? $about['highlight']['title']);
                $about['highlight']['text'] = sanitize_input($_POST['about_highlight_text'] ?? $about['highlight']['text']);
                $about['cta_primary']['label'] = sanitize_input($_POST['about_cta_primary_label'] ?? $about['cta_primary']['label']);
                $about['cta_primary']['url'] = trim($_POST['about_cta_primary_url'] ?? $about['cta_primary']['url']);
                $about['cta_secondary']['label'] = sanitize_input($_POST['about_cta_secondary_label'] ?? $about['cta_secondary']['label']);
                $about['cta_secondary']['url'] = trim($_POST['about_cta_secondary_url'] ?? $about['cta_secondary']['url']);

                $about['hero_image']['alt'] = sanitize_input($_POST['about_hero_alt'] ?? $about['hero_image']['alt']);
                $heroUpload = handle_image_upload('about_hero_image', 'assets/images/kenpo', 'kenpo-hero');
                if ($heroUpload) {
                    $about['hero_image']['src'] = $heroUpload;
                }
                unset($about);

                $content['kaizen_kenpo'] = $kaizenKenpo;
                if (save_json_data('site-content', $content)) {
                    $message = success_message('About tab saved to draft successfully!');
                } else {
                    $message = error_message('Failed to save About tab.');
                }
                break;

            case 'tab_ikca':
                $ikca = &$kaizenKenpo['tabs']['ikca'];
                $ikca['intro_heading'] = sanitize_input($_POST['ikca_intro_heading'] ?? $ikca['intro_heading']);
                $ikca['video_embed'] = trim($_POST['ikca_video_embed'] ?? $ikca['video_embed']);
                $ikca['image']['alt'] = sanitize_input($_POST['ikca_image_alt'] ?? $ikca['image']['alt']);
                $ikca['image']['caption'] = sanitize_input($_POST['ikca_image_caption'] ?? $ikca['image']['caption']);

                $ikcaUpload = handle_image_upload('ikca_image', 'assets/images/kenpo', 'ikca-image');
                if ($ikcaUpload) {
                    $ikca['image']['src'] = $ikcaUpload;
                }

                for ($i = 0; $i < 3; $i++) {
                    $ikca['paragraphs'][$i] = sanitize_input($_POST['ikca_paragraph_' . $i] ?? $ikca['paragraphs'][$i]);
                }
                unset($ikca);

                $content['kaizen_kenpo'] = $kaizenKenpo;
                if (save_json_data('site-content', $content)) {
                    $message = success_message('IKCA tab saved to draft successfully!');
                } else {
                    $message = error_message('Failed to save IKCA tab.');
                }
                break;

            case 'tab_gallery':
                $gallery = &$kaizenKenpo['tabs']['gallery'];
                $gallery['intro_text'] = sanitize_input($_POST['gallery_intro_text'] ?? $gallery['intro_text']);

                $existingImages = $gallery['images'] ?? [];
                $existingById = [];
                $maxExistingId = -1;

                foreach ($existingImages as $existingImage) {
                    if (!is_array($existingImage)) {
                        continue;
                    }

                    $imageId = isset($existingImage['id']) ? (int)$existingImage['id'] : null;
                    if ($imageId === null || $imageId < 0) {
                        continue;
                    }

                    $existingById[$imageId] = [
                        'id' => $imageId,
                        'src' => $existingImage['src'] ?? '',
                        'alt' => $existingImage['alt'] ?? '',
                        'caption' => $existingImage['caption'] ?? ''
                    ];

                    if ($imageId > $maxExistingId) {
                        $maxExistingId = $imageId;
                    }
                }

                $submittedIndexes = [];
                foreach ($_POST as $key => $value) {
                    if (preg_match('/^gallery_(?:src|alt|caption|remove)_(\d+)$/', $key, $matches)) {
                        $submittedIndexes[(int)$matches[1]] = true;
                    }
                }
                foreach ($_FILES as $key => $value) {
                    if (preg_match('/^gallery_image_(\d+)$/', $key, $matches)) {
                        $submittedIndexes[(int)$matches[1]] = true;
                    }
                }

                foreach (array_keys($existingById) as $existingIndex) {
                    $submittedIndexes[(int)$existingIndex] = true;
                }

                $indexes = array_keys($submittedIndexes);
                sort($indexes, SORT_NUMERIC);

                $validationErrors = [];
                foreach ($indexes as $index) {
                    if ($index >= $galleryMaxImages) {
                        continue;
                    }

                    $removeFlag = ($_POST['gallery_remove_' . $index] ?? '0') === '1';
                    if ($removeFlag) {
                        continue;
                    }

                    $postedSrc = trim($_POST['gallery_src_' . $index] ?? '');
                    $existingSrc = $existingById[$index]['src'] ?? '';
                    $hasUpload = isset($_FILES['gallery_image_' . $index]) && $_FILES['gallery_image_' . $index]['error'] === UPLOAD_ERR_OK;

                    if (!$hasUpload && $postedSrc === '' && $existingSrc === '') {
                        continue;
                    }

                    $altInput = trim($_POST['gallery_alt_' . $index] ?? '');
                    $captionInput = trim($_POST['gallery_caption_' . $index] ?? '');

                    if ($altInput === '') {
                        $validationErrors[] = 'Gallery image ' . ($index + 1) . ' requires alt text.';
                    }
                    if ($captionInput === '') {
                        $validationErrors[] = 'Gallery image ' . ($index + 1) . ' requires a caption.';
                    }
                }

                if (!empty($validationErrors)) {
                    $message = error_message(implode('<br>', $validationErrors));
                    break;
                }

                $newImages = [];
                $maxSubmittedId = $maxExistingId;

                foreach ($indexes as $index) {
                    if ($index >= $galleryMaxImages) {
                        continue;
                    }

                    $removeFlag = ($_POST['gallery_remove_' . $index] ?? '0') === '1';
                    $existingImage = $existingById[$index] ?? ['id' => $index, 'src' => '', 'alt' => '', 'caption' => ''];

                    if ($removeFlag) {
                        $existingSrc = $existingImage['src'] ?? '';
                        if ($existingSrc) {
                            $existingPath = dirname(__DIR__) . '/' . $existingSrc;
                            if (file_exists($existingPath)) {
                                @unlink($existingPath);
                            }
                        }
                        continue;
                    }

                    $altValue = sanitize_input($_POST['gallery_alt_' . $index] ?? ($existingImage['alt'] ?? ''));
                    $captionValue = sanitize_input($_POST['gallery_caption_' . $index] ?? ($existingImage['caption'] ?? ''));

                    $upload = handle_image_upload('gallery_image_' . $index, 'assets/images/kenpo/shuffle', 'gallery-' . $index);
                    if ($upload) {
                        $srcValue = $upload;
                    } else {
                        $srcValue = sanitize_input($_POST['gallery_src_' . $index] ?? ($existingImage['src'] ?? ''));
                    }

                    if (!$upload && $srcValue === '' && ($existingImage['src'] ?? '') === '') {
                        continue;
                    }

                    if ($srcValue === '') {
                        continue;
                    }

                    $newImages[] = [
                        'id' => $index,
                        'src' => $srcValue,
                        'alt' => $altValue,
                        'caption' => $captionValue
                    ];

                    if ($index > $maxSubmittedId) {
                        $maxSubmittedId = $index;
                    }
                }

                usort($newImages, function ($a, $b) {
                    return ($a['id'] ?? 0) <=> ($b['id'] ?? 0);
                });

                $gallery['images'] = $newImages;

                $nextIdFromPost = isset($_POST['gallery_next_id']) ? (int)$_POST['gallery_next_id'] : ($gallery['next_id'] ?? 0);
                $calculatedNextId = $maxSubmittedId + 1;
                $gallery['next_id'] = min(max($calculatedNextId, $nextIdFromPost, 0), $galleryMaxImages);

                unset($gallery);

                $content['kaizen_kenpo'] = $kaizenKenpo;
                if (save_json_data('site-content', $content)) {
                    $message = success_message('Gallery tab saved to draft successfully!');
                } else {
                    $message = error_message('Failed to save Gallery tab.');
                }
                break;

            case 'tab_contact':
                $contact = &$kaizenKenpo['tabs']['contact'];
                $contact['map']['heading'] = sanitize_input($_POST['contact_map_heading'] ?? $contact['map']['heading']);
                $contact['map']['embed_url'] = trim($_POST['contact_map_embed'] ?? $contact['map']['embed_url']);

                $contact['location']['heading'] = sanitize_input($_POST['contact_location_heading'] ?? $contact['location']['heading']);
                $locationLines = [];
                for ($i = 0; $i < 5; $i++) {
                    $line = sanitize_input($_POST['contact_location_line_' . $i] ?? '');
                    if ($line !== '') {
                        $locationLines[] = $line;
                    }
                }
                $contact['location']['lines'] = $locationLines;

                $contact['contact']['heading'] = sanitize_input($_POST['contact_heading'] ?? $contact['contact']['heading']);
                $contact['contact']['phone'] = sanitize_input($_POST['contact_phone'] ?? $contact['contact']['phone']);
                $contact['contact']['email'] = sanitize_input($_POST['contact_email'] ?? $contact['contact']['email']);

                $contact['class_time']['heading'] = sanitize_input($_POST['contact_class_heading'] ?? $contact['class_time']['heading']);
                $contact['class_time']['value'] = sanitize_input($_POST['contact_class_value'] ?? $contact['class_time']['value']);
                unset($contact);

                $content['kaizen_kenpo'] = $kaizenKenpo;
                if (save_json_data('site-content', $content)) {
                    $message = success_message('Contact tab saved to draft successfully!');
                } else {
                    $message = error_message('Failed to save Contact tab.');
                }
                break;

            default:
                $message = error_message('Unknown form submission.');
                break;
        }
    }
}

$content = load_json_data('site-content', 'draft');
$kaizenKenpo = array_replace_recursive($defaultKaizenKenpo, $content['kaizen_kenpo'] ?? []);
$kaizenKenpo['settings']['tabs'] = array_values($kaizenKenpo['settings']['tabs']);

while (count($kaizenKenpo['tabs']['gallery']['images']) < 5) {
    $kaizenKenpo['tabs']['gallery']['images'][] = ['src' => '', 'alt' => '', 'caption' => ''];
}

for ($i = 0; $i < 3; $i++) {
    if (!isset($kaizenKenpo['tabs']['ikca']['paragraphs'][$i])) {
        $kaizenKenpo['tabs']['ikca']['paragraphs'][$i] = '';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kaizen Kenpo - Kaizen Karate Admin</title>
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
        .form-control:focus, .form-select:focus { border-color: var(--kaizen-primary); box-shadow: 0 0 0 0.2rem rgba(164, 51, 43, 0.25); }
        .instructions-box { background: #f0f7ff; border-left: 4px solid #0066cc; padding: 1rem; margin-bottom: 1.5rem; border-radius: 5px; }
        .instructions-box h6 { color: #0066cc; margin-bottom: 0.75rem; font-weight: 600; }
        .current-image-preview { max-width: 260px; height: auto; border: 1px solid #dee2e6; border-radius: 5px; margin-top: 0.5rem; }
        .image-group { border: 1px dashed #dee2e6; border-radius: 8px; padding: 1rem; margin-bottom: 1rem; background: #fdfdfd; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 sidebar">
                <?php include 'includes/navigation.php'; ?>
            </div>

            <div class="col-md-9 col-lg-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1><i class="fas fa-fist-raised me-2 text-primary"></i>Kaizen Kenpo Management</h1>
                </div>

                <?php echo $message; ?>

                <div class="accordion" id="kenpoAdminAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="basicsHeading">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#basicsCollapse" aria-expanded="true" aria-controls="basicsCollapse">
                                <i class="fas fa-gear me-2"></i>Section Basics
                            </button>
                        </h2>
                        <div id="basicsCollapse" class="accordion-collapse collapse show" aria-labelledby="basicsHeading" data-bs-parent="#kenpoAdminAccordion">
                            <div class="accordion-body">
                                <div class="content-section">
                                    <div class="instructions-box">
                                        <h6><i class="fas fa-info-circle"></i> Instructions</h6>
                                        <ul class="mb-0">
                                            <li>Update the primary heading and navigation label for the Kaizen Kenpo section.</li>
                                            <li>Upload a new logo if needed; the file will be stored in <code>assets/images/kenpo</code>.</li>
                                            <li>Alt text should clearly describe the logo for accessibility.</li>
                                        </ul>
                                    </div>

                                    <form method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                                        <input type="hidden" name="section" value="basics">

                                        <div class="mb-3">
                                            <label class="form-label" for="kenpo_section_title">Section Title</label>
                                            <input type="text" class="form-control" id="kenpo_section_title" name="kenpo_section_title" value="<?php echo htmlspecialchars($kaizenKenpo['settings']['section_title'] ?? ''); ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="kenpo_nav_label">Navigation Label</label>
                                            <input type="text" class="form-control" id="kenpo_nav_label" name="kenpo_nav_label" value="<?php echo htmlspecialchars($kaizenKenpo['settings']['nav_label'] ?? ''); ?>" required>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label" for="kenpo_logo_image">Section Logo</label>
                                                <input type="file" class="form-control" id="kenpo_logo_image" name="kenpo_logo_image" accept="image/*">
                                                <div class="form-text">Recommended transparent PNG/WebP under 1MB.</div>
                                                <?php if (!empty($kaizenKenpo['settings']['logo']['image'])): ?>
                                                    <img src="../<?php echo htmlspecialchars($kaizenKenpo['settings']['logo']['image']); ?>" alt="" class="current-image-preview">
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="kenpo_logo_alt">Logo Alt Text</label>
                                                <input type="text" class="form-control" id="kenpo_logo_alt" name="kenpo_logo_alt" value="<?php echo htmlspecialchars($kaizenKenpo['settings']['logo']['alt'] ?? ''); ?>">
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end mt-4">
                                            <button type="submit" class="btn btn-kaizen">
                                                <i class="fas fa-save me-2"></i>Save Section Basics
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="tabsHeading">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tabsCollapse" aria-expanded="false" aria-controls="tabsCollapse">
                                <i class="fas fa-tablet-screen-button me-2"></i>Tab Settings
                            </button>
                        </h2>
                        <div id="tabsCollapse" class="accordion-collapse collapse" aria-labelledby="tabsHeading" data-bs-parent="#kenpoAdminAccordion">
                            <div class="accordion-body">
                                <div class="content-section">
                                    <div class="instructions-box">
                                        <h6><i class="fas fa-info-circle"></i> Instructions</h6>
                                        <ul class="mb-0">
                                            <li>Set the label and icon for each tab; IDs remain fixed for frontend logic.</li>
                                            <li>Select icons from the dropdown to keep styling consistent.</li>
                                        </ul>
                                    </div>

                                    <form method="POST">
                                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                                        <input type="hidden" name="section" value="tab_settings">

                                        <?php foreach ($kaizenKenpo['settings']['tabs'] as $index => $tabMeta): ?>
                                            <div class="content-section mb-3" style="border-color: #eef1f4; background: #fbfcff;">
                                                <h5 class="mb-3">
                                                    <i class="fas fa-tag me-2 text-secondary"></i>
                                                    <?php echo htmlspecialchars(strtoupper($tabMeta['id'] ?? 'Tab')); ?> Tab
                                                </h5>
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label" for="tab_label_<?php echo $index; ?>">Tab Label</label>
                                                        <input type="text" class="form-control" id="tab_label_<?php echo $index; ?>" name="tab_label_<?php echo $index; ?>" value="<?php echo htmlspecialchars($tabMeta['label'] ?? ''); ?>" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label" for="tab_icon_<?php echo $index; ?>">Tab Icon</label>
                                                        <select class="form-select" id="tab_icon_<?php echo $index; ?>" name="tab_icon_<?php echo $index; ?>">
                                                            <?php foreach ($iconOptions as $iconValue => $iconLabel): ?>
                                                                <option value="<?php echo htmlspecialchars($iconValue); ?>" <?php echo ($tabMeta['icon'] ?? '') === $iconValue ? 'selected' : ''; ?>>
                                                                    <?php echo $iconLabel; ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>

                                        <div class="d-flex justify-content-end mt-4">
                                            <button type="submit" class="btn btn-kaizen">
                                                <i class="fas fa-save me-2"></i>Save Tab Settings
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="aboutHeading">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#aboutCollapse" aria-expanded="false" aria-controls="aboutCollapse">
                                <i class="fas fa-user-ninja me-2"></i>About Tab Content
                            </button>
                        </h2>
                        <div id="aboutCollapse" class="accordion-collapse collapse" aria-labelledby="aboutHeading" data-bs-parent="#kenpoAdminAccordion">
                            <div class="accordion-body">
                                <div class="content-section">
                                    <form method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                                        <input type="hidden" name="section" value="tab_about">

                                        <div class="row g-3 mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label" for="about_hero_image">Hero Image</label>
                                                <input type="file" class="form-control" id="about_hero_image" name="about_hero_image" accept="image/*">
                                                <div class="form-text">Displayed on the left side of the About tab.</div>
                                                <?php if (!empty($kaizenKenpo['tabs']['about']['hero_image']['src'])): ?>
                                                    <img src="../<?php echo htmlspecialchars($kaizenKenpo['tabs']['about']['hero_image']['src']); ?>" alt="" class="current-image-preview">
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="about_hero_alt">Hero Image Alt Text</label>
                                                <input type="text" class="form-control" id="about_hero_alt" name="about_hero_alt" value="<?php echo htmlspecialchars($kaizenKenpo['tabs']['about']['hero_image']['alt'] ?? ''); ?>">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="about_lead_text">Lead Paragraph</label>
                                            <textarea class="form-control" id="about_lead_text" name="about_lead_text" rows="3"><?php echo htmlspecialchars($kaizenKenpo['tabs']['about']['lead_text'] ?? ''); ?></textarea>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label" for="about_schedule_label">Class Schedule Label</label>
                                                <input type="text" class="form-control" id="about_schedule_label" name="about_schedule_label" value="<?php echo htmlspecialchars($kaizenKenpo['tabs']['about']['class_schedule']['label'] ?? ''); ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="about_schedule_value">Class Schedule Value</label>
                                                <input type="text" class="form-control" id="about_schedule_value" name="about_schedule_value" value="<?php echo htmlspecialchars($kaizenKenpo['tabs']['about']['class_schedule']['value'] ?? ''); ?>">
                                            </div>
                                        </div>

                                        <div class="row g-3 mt-1">
                                            <div class="col-md-4">
                                                <label class="form-label" for="about_highlight_icon">Highlight Icon</label>
                                                <select class="form-select" id="about_highlight_icon" name="about_highlight_icon">
                                                    <?php foreach ($iconOptions as $iconValue => $iconLabel): ?>
                                                        <option value="<?php echo htmlspecialchars($iconValue); ?>" <?php echo ($kaizenKenpo['tabs']['about']['highlight']['icon'] ?? '') === $iconValue ? 'selected' : ''; ?>>
                                                            <?php echo $iconLabel; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="about_highlight_title">Highlight Title</label>
                                                <input type="text" class="form-control" id="about_highlight_title" name="about_highlight_title" value="<?php echo htmlspecialchars($kaizenKenpo['tabs']['about']['highlight']['title'] ?? ''); ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="about_highlight_text">Highlight Text</label>
                                                <textarea class="form-control" id="about_highlight_text" name="about_highlight_text" rows="2"><?php echo htmlspecialchars($kaizenKenpo['tabs']['about']['highlight']['text'] ?? ''); ?></textarea>
                                            </div>
                                        </div>

                                        <div class="row g-3 mt-1">
                                            <div class="col-md-6">
                                                <label class="form-label" for="about_cta_primary_label">Primary CTA Label</label>
                                                <input type="text" class="form-control" id="about_cta_primary_label" name="about_cta_primary_label" value="<?php echo htmlspecialchars($kaizenKenpo['tabs']['about']['cta_primary']['label'] ?? ''); ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="about_cta_primary_url">Primary CTA URL</label>
                                                <input type="text" class="form-control" id="about_cta_primary_url" name="about_cta_primary_url" value="<?php echo htmlspecialchars($kaizenKenpo['tabs']['about']['cta_primary']['url'] ?? ''); ?>">
                                            </div>
                                        </div>

                                        <div class="row g-3 mt-1">
                                            <div class="col-md-6">
                                                <label class="form-label" for="about_cta_secondary_label">Secondary CTA Label</label>
                                                <input type="text" class="form-control" id="about_cta_secondary_label" name="about_cta_secondary_label" value="<?php echo htmlspecialchars($kaizenKenpo['tabs']['about']['cta_secondary']['label'] ?? ''); ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="about_cta_secondary_url">Secondary CTA URL</label>
                                                <input type="text" class="form-control" id="about_cta_secondary_url" name="about_cta_secondary_url" value="<?php echo htmlspecialchars($kaizenKenpo['tabs']['about']['cta_secondary']['url'] ?? ''); ?>">
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end mt-4">
                                            <button type="submit" class="btn btn-kaizen">
                                                <i class="fas fa-save me-2"></i>Save About Tab
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="ikcaHeading">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#ikcaCollapse" aria-expanded="false" aria-controls="ikcaCollapse">
                                <i class="fas fa-dragon me-2"></i>IKCA Tab Content
                            </button>
                        </h2>
                        <div id="ikcaCollapse" class="accordion-collapse collapse" aria-labelledby="ikcaHeading" data-bs-parent="#kenpoAdminAccordion">
                            <div class="accordion-body">
                                <div class="content-section">
                                    <form method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                                        <input type="hidden" name="section" value="tab_ikca">
                                        
                                        <div class="row g-3 mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label" for="ikca_image">IKCA Image</label>
                                                <input type="file" class="form-control" id="ikca_image" name="ikca_image" accept="image/*">
                                                <div class="form-text">Displayed alongside the IKCA overview content.</div>
                                                <?php if (!empty($kaizenKenpo['tabs']['ikca']['image']['src'])): ?>
                                                    <img src="../<?php echo htmlspecialchars($kaizenKenpo['tabs']['ikca']['image']['src']); ?>" alt="" class="current-image-preview">
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label" for="ikca_image_alt">Image Alt Text</label>
                                                <input type="text" class="form-control" id="ikca_image_alt" name="ikca_image_alt" value="<?php echo htmlspecialchars($kaizenKenpo['tabs']['ikca']['image']['alt'] ?? ''); ?>">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label" for="ikca_image_caption">Image Caption</label>
                                                <input type="text" class="form-control" id="ikca_image_caption" name="ikca_image_caption" value="<?php echo htmlspecialchars($kaizenKenpo['tabs']['ikca']['image']['caption'] ?? ''); ?>">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="ikca_intro_heading">Intro Heading</label>
                                            <input type="text" class="form-control" id="ikca_intro_heading" name="ikca_intro_heading" value="<?php echo htmlspecialchars($kaizenKenpo['tabs']['ikca']['intro_heading'] ?? ''); ?>">
                                        </div>

                                        <?php for ($i = 0; $i < 3; $i++): ?>
                                            <div class="mb-3">
                                                <label class="form-label" for="ikca_paragraph_<?php echo $i; ?>">Paragraph <?php echo $i + 1; ?></label>
                                                <textarea class="form-control" id="ikca_paragraph_<?php echo $i; ?>" name="ikca_paragraph_<?php echo $i; ?>" rows="3"><?php echo htmlspecialchars($kaizenKenpo['tabs']['ikca']['paragraphs'][$i] ?? ''); ?></textarea>
                                            </div>
                                        <?php endfor; ?>

                                        <div class="mb-3">
                                            <label class="form-label" for="ikca_video_embed">Video Embed URL</label>
                                            <input type="text" class="form-control" id="ikca_video_embed" name="ikca_video_embed" value="<?php echo htmlspecialchars($kaizenKenpo['tabs']['ikca']['video_embed'] ?? ''); ?>" placeholder="https://www.youtube.com/embed/...">
                                        </div>

                                        <div class="d-flex justify-content-end mt-4">
                                            <button type="submit" class="btn btn-kaizen">
                                                <i class="fas fa-save me-2"></i>Save IKCA Tab
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="galleryHeading">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#galleryCollapse" aria-expanded="false" aria-controls="galleryCollapse">
                                <i class="fas fa-images me-2"></i>Gallery Tab Content
                            </button>
                        </h2>
                        <div id="galleryCollapse" class="accordion-collapse collapse" aria-labelledby="galleryHeading" data-bs-parent="#kenpoAdminAccordion">
                            <div class="accordion-body">
                                <div class="content-section">
                                    <form method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                                        <input type="hidden" name="section" value="tab_gallery">

                                        <div class="mb-3">
                                            <label class="form-label" for="gallery_intro_text">Intro Text</label>
                                            <textarea class="form-control" id="gallery_intro_text" name="gallery_intro_text" rows="2"><?php echo htmlspecialchars($kaizenKenpo['tabs']['gallery']['intro_text'] ?? ''); ?></textarea>
                                        </div>

                                        <?php
                                            $galleryImages = $kaizenKenpo['tabs']['gallery']['images'] ?? [];
                                            $galleryActiveImages = array_values(array_filter($galleryImages, function ($img) {
                                                return !empty($img['src'] ?? '');
                                            }));
                                            $galleryActiveCount = count($galleryActiveImages);
                                            $storedNextId = (int)($kaizenKenpo['tabs']['gallery']['next_id'] ?? 0);
                                            $renderableGalleryImages = [];
                                            $maxSlotId = -1;

                                            foreach ($galleryActiveImages as $displayIndex => $image) {
                                                $slotId = isset($image['id']) ? (int)$image['id'] : $displayIndex;
                                                if ($slotId > $maxSlotId) {
                                                    $maxSlotId = $slotId;
                                                }

                                                $renderableGalleryImages[] = [
                                                    'slot_id' => $slotId,
                                                    'display_number' => $displayIndex + 1,
                                                    'src' => $image['src'] ?? '',
                                                    'alt' => $image['alt'] ?? '',
                                                    'caption' => $image['caption'] ?? ''
                                                ];
                                            }

                                            $calculatedNextIndex = $maxSlotId + 1;
                                            if ($calculatedNextIndex < 0) {
                                                $calculatedNextIndex = 0;
                                            }
                                            $calculatedNextIndex = min(max($storedNextId, $calculatedNextIndex), $galleryMaxImages);
                                        ?>

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="text-muted">
                                                <i class="fas fa-images me-1"></i>
                                                <span id="gallery-active-count"><?php echo (int)$galleryActiveCount; ?></span>
                                                / <?php echo (int)$galleryMaxImages; ?> images
                                            </div>
                                        </div>

                                        <div id="galleryImagesContainer"
                                             data-next-index="<?php echo (int)$calculatedNextIndex; ?>"
                                             data-max-images="<?php echo (int)$galleryMaxImages; ?>">
                                            <?php foreach ($renderableGalleryImages as $image): ?>
                                                <div class="image-group" data-gallery-index="<?php echo (int)$image['slot_id']; ?>">
                                                    <h6 class="mb-3 text-secondary">
                                                        <i class="fas fa-image me-2"></i>Gallery Image <?php echo (int)$image['display_number']; ?>
                                                    </h6>
                                                    <div class="row g-3 align-items-end">
                                                        <div class="col-md-4">
                                                            <label class="form-label" for="gallery_image_<?php echo (int)$image['slot_id']; ?>">Replace Image</label>
                                                            <input type="file" class="form-control" id="gallery_image_<?php echo (int)$image['slot_id']; ?>" name="gallery_image_<?php echo (int)$image['slot_id']; ?>" accept="image/*">
                                                            <input type="hidden" name="gallery_src_<?php echo (int)$image['slot_id']; ?>" value="<?php echo htmlspecialchars($image['src']); ?>">
                                                            <input type="hidden" class="gallery-remove-flag" data-gallery-index="<?php echo (int)$image['slot_id']; ?>" name="gallery_remove_<?php echo (int)$image['slot_id']; ?>" value="0">
                                                            <img src="../<?php echo htmlspecialchars($image['src']); ?>" alt="" class="current-image-preview">
                                                            <button type="button"
                                                                    class="btn btn-sm btn-outline-danger w-100 mt-2 gallery-delete-btn"
                                                                    data-gallery-index="<?php echo (int)$image['slot_id']; ?>">
                                                                <i class="fas fa-trash-alt me-1"></i>Delete Image
                                                            </button>
                                                            <div class="text-danger small mt-2 gallery-delete-message d-none">
                                                                Image will be removed when you save.
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label" for="gallery_alt_<?php echo (int)$image['slot_id']; ?>">Alt Text</label>
                                                            <input type="text" class="form-control gallery-alt-input" id="gallery_alt_<?php echo (int)$image['slot_id']; ?>" name="gallery_alt_<?php echo (int)$image['slot_id']; ?>" value="<?php echo htmlspecialchars($image['alt']); ?>">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label" for="gallery_caption_<?php echo (int)$image['slot_id']; ?>">Caption</label>
                                                            <input type="text" class="form-control gallery-caption-input" id="gallery_caption_<?php echo (int)$image['slot_id']; ?>" name="gallery_caption_<?php echo (int)$image['slot_id']; ?>" value="<?php echo htmlspecialchars($image['caption']); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>

                                        <input type="hidden" id="galleryNextId" name="gallery_next_id" value="<?php echo (int)$calculatedNextIndex; ?>">

                                        <div class="d-flex align-items-center gap-3 mt-4">
                                            <button type="button" class="btn btn-success" id="addGalleryImageBtn">
                                                <i class="fas fa-plus me-2"></i>Add Gallery Image
                                            </button>
                                            <div class="alert alert-success mb-0 py-2 px-3 d-none" id="galleryAddMessage">
                                                <i class="fas fa-check-circle me-2"></i>Gallery slot added! Don't forget to save.
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end mt-4">
                                            <button type="submit" class="btn btn-kaizen">
                                                <i class="fas fa-save me-2"></i>Save Gallery Tab
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="contactHeading">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#contactCollapse" aria-expanded="false" aria-controls="contactCollapse">
                                <i class="fas fa-map-location-dot me-2"></i>Contact Tab Content
                            </button>
                        </h2>
                        <div id="contactCollapse" class="accordion-collapse collapse" aria-labelledby="contactHeading" data-bs-parent="#kenpoAdminAccordion">
                            <div class="accordion-body">
                                <div class="content-section">
                                    <form method="POST">
                                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                                        <input type="hidden" name="section" value="tab_contact">

                                        <div class="row g-3 mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label" for="contact_map_heading">Map Heading</label>
                                                <input type="text" class="form-control" id="contact_map_heading" name="contact_map_heading" value="<?php echo htmlspecialchars($kaizenKenpo['tabs']['contact']['map']['heading'] ?? ''); ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="contact_map_embed">Map Embed URL</label>
                                                <input type="text" class="form-control" id="contact_map_embed" name="contact_map_embed" value="<?php echo htmlspecialchars($kaizenKenpo['tabs']['contact']['map']['embed_url'] ?? ''); ?>">
                                            </div>
                                        </div>

                                        <div class="row g-3 mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label" for="contact_location_heading">Location Heading</label>
                                                <input type="text" class="form-control" id="contact_location_heading" name="contact_location_heading" value="<?php echo htmlspecialchars($kaizenKenpo['tabs']['contact']['location']['heading'] ?? ''); ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="contact_heading">Contact Heading</label>
                                                <input type="text" class="form-control" id="contact_heading" name="contact_heading" value="<?php echo htmlspecialchars($kaizenKenpo['tabs']['contact']['contact']['heading'] ?? ''); ?>">
                                            </div>
                                        </div>

                                        <div class="row g-3 mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label" for="contact_phone">Phone</label>
                                                <input type="text" class="form-control" id="contact_phone" name="contact_phone" value="<?php echo htmlspecialchars($kaizenKenpo['tabs']['contact']['contact']['phone'] ?? ''); ?>">
                                            </div>
                                            <div class="col-md-8">
                                                <label class="form-label" for="contact_email">Email</label>
                                                <input type="email" class="form-control" id="contact_email" name="contact_email" value="<?php echo htmlspecialchars($kaizenKenpo['tabs']['contact']['contact']['email'] ?? ''); ?>">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Location Lines</label>
                                            <?php
                                                $locationLines = $kaizenKenpo['tabs']['contact']['location']['lines'] ?? [];
                                                for ($i = 0; $i < 3; $i++):
                                                    $value = $locationLines[$i] ?? '';
                                            ?>
                                                <input type="text" class="form-control mb-2" name="contact_location_line_<?php echo $i; ?>" value="<?php echo htmlspecialchars($value); ?>">
                                            <?php endfor; ?>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label" for="contact_class_heading">Class Time Heading</label>
                                                <input type="text" class="form-control" id="contact_class_heading" name="contact_class_heading" value="<?php echo htmlspecialchars($kaizenKenpo['tabs']['contact']['class_time']['heading'] ?? ''); ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="contact_class_value">Class Time Value</label>
                                                <input type="text" class="form-control" id="contact_class_value" name="contact_class_value" value="<?php echo htmlspecialchars($kaizenKenpo['tabs']['contact']['class_time']['value'] ?? ''); ?>">
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end mt-4">
                                            <button type="submit" class="btn btn-kaizen">
                                                <i class="fas fa-save me-2"></i>Save Contact Tab
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const galleryContainer = document.getElementById('galleryImagesContainer');
            if (!galleryContainer) {
                return;
            }

            const addButton = document.getElementById('addGalleryImageBtn');
            const addMessage = document.getElementById('galleryAddMessage');
            const activeCountDisplay = document.getElementById('gallery-active-count');
            const galleryNextInput = document.getElementById('galleryNextId');
            const galleryForm = galleryContainer.closest('form');
            const maxImages = parseInt(galleryContainer.dataset.maxImages || '20', 10);
            let nextIndex = parseInt(galleryContainer.dataset.nextIndex || '0', 10);
            if (galleryNextInput) {
                const hiddenNext = parseInt(galleryNextInput.value || '0', 10);
                if (!Number.isNaN(hiddenNext) && hiddenNext > nextIndex) {
                    nextIndex = hiddenNext;
                }
            }
            nextIndex = Math.min(nextIndex, maxImages);

            let galleryDirty = false;

            function markGalleryDirty() {
                galleryDirty = true;
            }

            function updateActiveCount() {
                let active = 0;
                galleryContainer.querySelectorAll('.image-group').forEach(function (group) {
                    const removeField = group.querySelector('.gallery-remove-flag');
                    if (removeField && removeField.value === '1') {
                        return;
                    }
                    const hiddenSrc = group.querySelector('input[name^="gallery_src_"]');
                    const preview = group.querySelector('.current-image-preview');
                    if (hiddenSrc && hiddenSrc.value.trim() !== '') {
                        active++;
                    } else if (preview) {
                        active++;
                    }
                });
                if (activeCountDisplay) {
                    activeCountDisplay.textContent = active;
                }
                return active;
            }

            function updateAddButtonState() {
                if (!addButton) {
                    return;
                }
                const disable = nextIndex >= maxImages;
                addButton.disabled = disable;
                if (disable) {
                    addButton.classList.add('disabled');
                    addButton.title = 'Maximum number of gallery images reached.';
                } else {
                    addButton.classList.remove('disabled');
                    addButton.removeAttribute('title');
                }
            }

            function showAddMessage() {
                if (!addMessage) {
                    return;
                }
                addMessage.classList.remove('d-none');
                addMessage.classList.add('show');
                setTimeout(function () {
                    addMessage.classList.add('d-none');
                    addMessage.classList.remove('show');
                }, 3000);
            }

            function attachDeleteHandler(button) {
                if (!button || button.dataset.deleteInitialized === '1') {
                    return;
                }

                button.dataset.deleteInitialized = '1';
                button.addEventListener('click', function () {
                    if (button.disabled) {
                        return;
                    }

                    if (!window.confirm('Delete this gallery image? The change is final after you save.')) {
                        return;
                    }

                    const index = button.getAttribute('data-gallery-index');
                    const group = button.closest('.image-group');
                    if (!group || !index) {
                        return;
                    }

                    const removeField = group.querySelector('input[name="gallery_remove_' + index + '"]');
                    if (removeField) {
                        removeField.value = '1';
                    }

                    const fileInput = group.querySelector('#gallery_image_' + index);
                    if (fileInput) {
                        fileInput.value = '';
                    }

                    const hiddenSrc = group.querySelector('input[name="gallery_src_' + index + '"]');
                    if (hiddenSrc) {
                        hiddenSrc.value = '';
                    }

                    const altInput = group.querySelector('#gallery_alt_' + index);
                    if (altInput) {
                        altInput.value = '';
                        altInput.readOnly = true;
                        altInput.classList.add('bg-light');
                        altInput.placeholder = 'Marked for deletion';
                    }

                    const captionInput = group.querySelector('#gallery_caption_' + index);
                    if (captionInput) {
                        captionInput.value = '';
                        captionInput.readOnly = true;
                        captionInput.classList.add('bg-light');
                        captionInput.placeholder = 'Marked for deletion';
                    }

                    const preview = group.querySelector('.current-image-preview');
                    if (preview) {
                        preview.remove();
                    }

                    const deleteMessage = group.querySelector('.gallery-delete-message');
                    if (deleteMessage) {
                        deleteMessage.classList.remove('d-none');
                    }

                    button.classList.remove('btn-outline-danger');
                    button.classList.add('btn-danger');
                    button.innerHTML = '<i class="fas fa-trash-alt me-1"></i>Marked for Deletion';
                    button.disabled = true;

                    markGalleryDirty();
                    updateActiveCount();
                    updateAddButtonState();
                });
            }

            function createGalleryGroup(index) {
                const wrapper = document.createElement('div');
                wrapper.className = 'image-group';
                wrapper.setAttribute('data-gallery-index', index);
                wrapper.innerHTML = `
                    <h6 class="mb-3 text-secondary">
                        <i class="fas fa-image me-2"></i>Gallery Image ${index + 1}
                    </h6>
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label" for="gallery_image_${index}">Replace Image</label>
                            <input type="file" class="form-control" id="gallery_image_${index}" name="gallery_image_${index}" accept="image/*">
                            <input type="hidden" name="gallery_src_${index}" value="">
                            <input type="hidden" class="gallery-remove-flag" data-gallery-index="${index}" name="gallery_remove_${index}" value="0">
                            <button type="button"
                                    class="btn btn-sm btn-outline-danger w-100 mt-2 gallery-delete-btn"
                                    data-gallery-index="${index}">
                                <i class="fas fa-trash-alt me-1"></i>Delete Image
                            </button>
                            <div class="text-danger small mt-2 gallery-delete-message d-none">
                                Image will be removed when you save.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="gallery_alt_${index}">Alt Text</label>
                            <input type="text" class="form-control gallery-alt-input" id="gallery_alt_${index}" name="gallery_alt_${index}" value="">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="gallery_caption_${index}">Caption</label>
                            <input type="text" class="form-control gallery-caption-input" id="gallery_caption_${index}" name="gallery_caption_${index}" value="">
                        </div>
                    </div>
                `;
                return wrapper;
            }

            if (addButton) {
                addButton.addEventListener('click', function () {
                    if (nextIndex >= maxImages) {
                        return;
                    }

                    const currentIndex = nextIndex;
                    const newGroup = createGalleryGroup(currentIndex);
                    galleryContainer.appendChild(newGroup);

                    const newDeleteButton = newGroup.querySelector('.gallery-delete-btn');
                    attachDeleteHandler(newDeleteButton);

                    nextIndex = Math.min(nextIndex + 1, maxImages);
                    galleryContainer.dataset.nextIndex = String(nextIndex);
                    if (galleryNextInput) {
                        galleryNextInput.value = String(nextIndex);
                    }

                    markGalleryDirty();
                    showAddMessage();
                    updateActiveCount();
                    updateAddButtonState();

                    window.requestAnimationFrame(function () {
                        newGroup.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    });
                });
            }

            galleryContainer.querySelectorAll('.gallery-delete-btn').forEach(attachDeleteHandler);

            function handleGalleryInputEvent(event) {
                if (event.target.matches('.gallery-alt-input, .gallery-caption-input, input[type="file"]')) {
                    markGalleryDirty();
                }
            }

            galleryContainer.addEventListener('change', handleGalleryInputEvent);
            galleryContainer.addEventListener('input', handleGalleryInputEvent);

            if (galleryForm) {
                galleryForm.addEventListener('submit', function () {
                    galleryDirty = false;
                });
            }

            window.addEventListener('beforeunload', function (event) {
                if (!galleryDirty) {
                    return;
                }
                event.preventDefault();
                event.returnValue = '';
            });

            updateActiveCount();
            updateAddButtonState();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
