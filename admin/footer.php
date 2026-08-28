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
     * Simplified image upload helper.
     * Mirrors implementation used by other admin pages.
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

        $targetFile = $uploadDir . '/' . $fileName . '.' . $extension;
        if (!move_uploaded_file($_FILES[$field]['tmp_name'], $targetFile)) {
            return null;
        }

        return $relativeDir . '/' . $fileName . '.' . $extension;
    }
}

$content = load_json_data('site-content', 'draft');

$defaultFooter = [
    'enabled' => true,
    'settings' => [
        'background_color' => '#2c3e50',
        'text_color' => '#ffffff',
        'num_columns' => 3,
    ],
    'columns' => [
        'branding' => [
            'enabled' => true,
            'logo' => [
                'src' => 'assets/images/kaizen-logo-footer.png',
                'alt' => 'Kaizen Karate',
            ],
            'title' => 'Kaizen Karate',
            'description' => 'Traditional martial arts training in Washington DC, Maryland, Northern Virginia, and New York. Building character, discipline, and strength through the art of karate.',
        ],
        'quick_links' => [
            'enabled' => true,
            'title' => 'Quick Links',
            'links' => [
                ['label' => 'Training Options', 'url' => '#training-options'],
                ['label' => 'Summer Camp', 'url' => '#summer-camp'],
                ['label' => 'After School', 'url' => '#weekend-evening'],
                ['label' => 'Weekend Classes', 'url' => '#weekend-evening'],
                ['label' => 'Belt Exams', 'url' => '#belt-exam'],
                ['label' => 'Contact Us', 'url' => '#contact'],
                ['label' => 'Policies', 'url' => 'policies.php'],
                ['label' => 'FAQs', 'url' => 'faq.php'],
                ['label' => 'Student Handbook', 'url' => 'student-handbook.php'],
            ],
        ],
        'contact' => [
            'enabled' => true,
            'heading' => 'Get In Touch',
            'items' => [
                ['type' => 'phone', 'label' => 'DC, MD, VA Programs', 'value' => '301-938-2711', 'icon' => 'fas fa-phone'],
                ['type' => 'phone', 'label' => 'NY Program', 'value' => '646-475-7328', 'icon' => 'fas fa-phone'],
                ['type' => 'email', 'label' => '', 'value' => 'coach.v@kaizenkarateusa.com', 'icon' => 'fas fa-envelope'],
            ],
            'social_heading' => 'Follow Us',
            'social_links' => [
                ['platform' => 'Facebook', 'url' => 'https://www.facebook.com/people/Kaizen-Karate/100063714665511/', 'icon' => 'fab fa-facebook-f'],
                ['platform' => 'TikTok', 'url' => 'https://www.tiktok.com/@kaizenkaratemd', 'icon' => 'fab fa-tiktok'],
                ['platform' => 'Instagram', 'url' => 'https://www.instagram.com/kaizen_karate/', 'icon' => 'fab fa-instagram'],
                ['platform' => 'Podcast', 'url' => 'https://coachv6z.podbean.com/', 'icon' => 'fas fa-podcast'],
            ],
        ],
    ],
    'bottom_bar' => [
        'enabled' => true,
        'copyright' => '© {YEAR} Kaizen Karate. All Rights Reserved.',
    ],
];

$footerData = array_replace_recursive($defaultFooter, $content['footer'] ?? []);
$footerKeyExists = array_key_exists('footer', $content);

// Normalise structure to prevent undefined keys.
$footerData['columns']['branding'] = array_replace_recursive($defaultFooter['columns']['branding'], $footerData['columns']['branding'] ?? []);
$footerData['columns']['quick_links'] = array_replace_recursive($defaultFooter['columns']['quick_links'], $footerData['columns']['quick_links'] ?? []);
$footerData['columns']['contact'] = array_replace_recursive($defaultFooter['columns']['contact'], $footerData['columns']['contact'] ?? []);
$footerData['bottom_bar'] = array_replace_recursive($defaultFooter['bottom_bar'], $footerData['bottom_bar'] ?? []);

if (!isset($footerData['columns']['quick_links']['links']) || !is_array($footerData['columns']['quick_links']['links'])) {
    $footerData['columns']['quick_links']['links'] = $defaultFooter['columns']['quick_links']['links'];
}
$footerData['columns']['quick_links']['links'] = array_values($footerData['columns']['quick_links']['links']);

if (!isset($footerData['columns']['contact']['items']) || !is_array($footerData['columns']['contact']['items'])) {
    $footerData['columns']['contact']['items'] = $defaultFooter['columns']['contact']['items'];
}
$footerData['columns']['contact']['items'] = array_values($footerData['columns']['contact']['items']);

if (!isset($footerData['columns']['contact']['social_links']) || !is_array($footerData['columns']['contact']['social_links'])) {
    $footerData['columns']['contact']['social_links'] = $defaultFooter['columns']['contact']['social_links'];
}
$footerData['columns']['contact']['social_links'] = array_values($footerData['columns']['contact']['social_links']);

$contactIconOptions = [
    'fas fa-phone' => '📞 Phone',
    'fas fa-envelope' => '✉️ Envelope',
    'fas fa-map-marker-alt' => '📍 Location',
    'fas fa-mobile-alt' => '📱 Mobile',
    'fas fa-fax' => '📠 Fax',
];

$socialIconOptions = [
    'fab fa-facebook-f' => '📘 Facebook',
    'fab fa-instagram' => '📷 Instagram',
    'fab fa-tiktok' => '🎵 TikTok',
    'fab fa-twitter' => '🐦 Twitter',
    'fab fa-youtube' => '📺 YouTube',
    'fab fa-linkedin' => '💼 LinkedIn',
    'fab fa-discord' => '💬 Discord',
    'fab fa-pinterest' => '📌 Pinterest',
    'fab fa-github' => '🐙 GitHub',
    'fas fa-podcast' => '🎙️ Podcast',
];

if (!$footerKeyExists && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    $content['footer'] = $footerData;
    save_json_data('site-content', $content);
}

function footer_is_valid_hex_color($value)
{
    return is_string($value) && preg_match('/^#[0-9A-Fa-f]{6}$/', $value);
}

function footer_is_valid_link_url($url)
{
    if (!is_string($url)) {
        return false;
    }

    $url = trim($url);

    if ($url === '') {
        return false;
    }

    $firstChar = $url[0];
    if ($firstChar === '/' || $firstChar === '#') {
        return true;
    }

    if (stripos($url, 'mailto:') === 0 || stripos($url, 'tel:') === 0) {
        return true;
    }

    if (preg_match('/\\.php(?:[?#].*)?$/i', $url)) {
        return true;
    }

    if (preg_match('/^https?:\/\//i', $url)) {
        return (bool)filter_var($url, FILTER_VALIDATE_URL);
    }

    return false;
}

$maxQuickLinks = 15;
$maxContactItems = 10;
$maxSocialLinks = 10;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $message = error_message('Security token invalid. Please try again.');
    } else {
        $postedFooter = $footerData;

        $postedFooter['enabled'] = true;
        $postedFooter['settings']['background_color'] = '#2c3e50';
        $postedFooter['settings']['text_color'] = '#ffffff';
        $postedFooter['settings']['num_columns'] = 3;

        // Branding column
        $postedFooter['columns']['branding']['enabled'] = isset($_POST['branding_enabled']);
        $postedFooter['columns']['branding']['title'] = sanitize_input($_POST['branding_title'] ?? $postedFooter['columns']['branding']['title']);
        $postedFooter['columns']['branding']['description'] = sanitize_input($_POST['branding_description'] ?? $postedFooter['columns']['branding']['description']);
        $postedFooter['columns']['branding']['logo']['alt'] = sanitize_input($_POST['branding_logo_alt'] ?? $postedFooter['columns']['branding']['logo']['alt']);
        $logoPath = sanitize_input($_POST['branding_logo_path'] ?? $postedFooter['columns']['branding']['logo']['src']);
        $uploadedLogo = handle_image_upload('branding_logo_upload', 'assets/images/footer', 'footer-logo');
        if ($uploadedLogo) {
            $logoPath = $uploadedLogo;
        }
        $postedFooter['columns']['branding']['logo']['src'] = $logoPath;

        // Quick links
        $postedFooter['columns']['quick_links']['enabled'] = isset($_POST['quick_links_enabled']);
        $postedFooter['columns']['quick_links']['title'] = sanitize_input($_POST['quick_links_title'] ?? $postedFooter['columns']['quick_links']['title']);
        $quickLinks = [];
        if (isset($_POST['quick_links']) && is_array($_POST['quick_links'])) {
            foreach ($_POST['quick_links'] as $linkData) {
                $label = sanitize_input($linkData['label'] ?? '');
                $url = trim($linkData['url'] ?? '');
                $order = isset($linkData['order']) ? (int)$linkData['order'] : 0;

                if ($label === '' && $url === '') {
                    continue;
                }

                if ($label === '' || $url === '') {
                    $validationErrors[] = 'Quick links require both a label and URL.';
                    continue;
                }

                if (!footer_is_valid_link_url($url)) {
                    $validationErrors[] = 'Quick link "' . htmlspecialchars($label) . '" has an invalid URL.';
                    continue;
                }

                $quickLinks[] = [
                    'label' => $label,
                    'url' => $url,
                    'order' => $order,
                ];
            }
        }

        if (count($quickLinks) > $maxQuickLinks) {
            $validationErrors[] = 'Quick links cannot exceed ' . $maxQuickLinks . ' items.';
        }

        usort($quickLinks, static function ($a, $b) {
            return ($a['order'] ?? 0) <=> ($b['order'] ?? 0);
        });

        $postedFooter['columns']['quick_links']['links'] = array_map(static function ($link) {
            return [
                'label' => $link['label'],
                'url' => $link['url'],
            ];
        }, $quickLinks);

        // Contact column
        $postedFooter['columns']['contact']['enabled'] = isset($_POST['contact_enabled']);
        $postedFooter['columns']['contact']['heading'] = sanitize_input($_POST['contact_heading'] ?? $postedFooter['columns']['contact']['heading']);

        $contactItems = [];
        if (isset($_POST['contact_items']) && is_array($_POST['contact_items'])) {
            foreach ($_POST['contact_items'] as $itemData) {
                $type = strtolower($itemData['type'] ?? 'phone');
                if (!in_array($type, ['phone', 'email', 'address'], true)) {
                    $type = 'phone';
                }
                $label = sanitize_input($itemData['label'] ?? '');
                $value = sanitize_input($itemData['value'] ?? '');
                $icon = sanitize_input($itemData['icon'] ?? '');
                $order = isset($itemData['order']) ? (int)$itemData['order'] : 0;

                if ($value === '') {
                    continue;
                }

                if ($icon === '') {
                    $icon = $type === 'email' ? 'fas fa-envelope' : ($type === 'address' ? 'fas fa-map-marker-alt' : 'fas fa-phone');
                }

                $contactItems[] = [
                    'type' => $type,
                    'label' => $label,
                    'value' => $value,
                    'icon' => $icon,
                    'order' => $order,
                ];
            }
        }

        if (count($contactItems) > $maxContactItems) {
            $validationErrors[] = 'Contact items cannot exceed ' . $maxContactItems . ' entries.';
        }

        usort($contactItems, static function ($a, $b) {
            return ($a['order'] ?? 0) <=> ($b['order'] ?? 0);
        });

        $postedFooter['columns']['contact']['items'] = array_map(static function ($item) {
            return [
                'type' => $item['type'],
                'label' => $item['label'],
                'value' => $item['value'],
                'icon' => $item['icon'],
            ];
        }, $contactItems);

        $postedFooter['columns']['contact']['social_heading'] = sanitize_input($_POST['social_heading'] ?? $postedFooter['columns']['contact']['social_heading']);

        $socialLinks = [];
        if (isset($_POST['social_links']) && is_array($_POST['social_links'])) {
            foreach ($_POST['social_links'] as $linkData) {
                $platform = sanitize_input($linkData['platform'] ?? '');
                $url = trim($linkData['url'] ?? '');
                $icon = sanitize_input($linkData['icon'] ?? '');
                $order = isset($linkData['order']) ? (int)$linkData['order'] : 0;

                if ($platform === '' && $url === '' && $icon === '') {
                    continue;
                }

                if ($platform === '' || $url === '' || $icon === '') {
                    $validationErrors[] = 'Social links require platform, URL, and icon.';
                    continue;
                }

                if (!footer_is_valid_link_url($url)) {
                    $validationErrors[] = 'Social link "' . htmlspecialchars($platform) . '" has an invalid URL.';
                    continue;
                }

                $socialLinks[] = [
                    'platform' => $platform,
                    'url' => $url,
                    'icon' => $icon,
                    'order' => $order,
                ];
            }
        }

        if (count($socialLinks) > $maxSocialLinks) {
            $validationErrors[] = 'Social links cannot exceed ' . $maxSocialLinks . ' entries.';
        }

        usort($socialLinks, static function ($a, $b) {
            return ($a['order'] ?? 0) <=> ($b['order'] ?? 0);
        });

        $postedFooter['columns']['contact']['social_links'] = array_map(static function ($link) {
            return [
                'platform' => $link['platform'],
                'url' => $link['url'],
                'icon' => $link['icon'],
            ];
        }, $socialLinks);

        // Bottom bar
        $postedFooter['bottom_bar']['enabled'] = isset($_POST['bottom_enabled']);
        $postedFooter['bottom_bar']['copyright'] = sanitize_input($_POST['bottom_copyright'] ?? $postedFooter['bottom_bar']['copyright']);

        if (empty($validationErrors)) {
            $content['footer'] = $postedFooter;
            if (save_json_data('site-content', $content)) {
                $message = success_message('Footer saved to draft successfully!');
                $footerData = $postedFooter;
            } else {
                $message = error_message('Failed to save footer changes.');
            }
        } else {
            $errorHtml = '<strong>Please fix the following:</strong><ul class="mb-0">';
            foreach ($validationErrors as $error) {
                $errorHtml .= '<li>' . htmlspecialchars($error) . '</li>';
            }
            $errorHtml .= '</ul>';
            $message = error_message($errorHtml);
            $footerData = $postedFooter;
        }
    }
}

$quickLinksNextIndex = count($footerData['columns']['quick_links']['links']);
$contactItemsNextIndex = count($footerData['columns']['contact']['items']);
$socialLinksNextIndex = count($footerData['columns']['contact']['social_links']);

$additional_styles = <<<CSS
.accordion-button { font-weight: 600; color: var(--kaizen-primary); }
.accordion-button:focus { box-shadow: none; }
.repeater-card { border: 1px solid #dee2e6; border-radius: 10px; padding: 1rem; background: #fdfdfd; }
.repeater-card:not(:last-child) { margin-bottom: 1rem; }
.repeater-controls .btn { min-width: 40px; }
.help-text { font-size: 0.875rem; color: #6c757d; }
.template-holder { display: none; }
.logo-preview { max-width: 200px; height: auto; }
.icon-select { font-family: inherit; }
CSS;


ob_start();
?>
<div class="content-section">
    <h3 class="section-title"><i class="fas fa-puzzle-piece me-2"></i>Footer Content & Layout</h3>

    <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generate_csrf_token()); ?>">

                            <div class="accordion" id="footerAccordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingBranding">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBranding" aria-expanded="false" aria-controls="collapseBranding">
                                            <i class="fas fa-id-card me-2"></i>Column 1 - Branding
                                        </button>
                                    </h2>
                                    <div id="collapseBranding" class="accordion-collapse collapse" aria-labelledby="headingBranding" data-bs-parent="#footerAccordion">
                                        <div class="accordion-body">
                                            <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" type="checkbox" id="branding_enabled" name="branding_enabled" <?php echo $footerData['columns']['branding']['enabled'] ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="branding_enabled">Show Branding Column</label>
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label"><strong>Logo Image</strong></label>
                                                    <input type="file" class="form-control" name="branding_logo_upload" accept="image/*">
                                                    <div class="help-text">Upload a PNG/SVG preferred. New upload replaces the existing logo.</div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label"><strong>Current Logo Path</strong></label>
                                                    <input type="text" class="form-control" name="branding_logo_path" value="<?php echo htmlspecialchars($footerData['columns']['branding']['logo']['src']); ?>" placeholder="assets/images/kaizen-logo-footer.png">
                                                    <div class="help-text">Update manually if needed. Upload overrides this path.</div>
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <label class="form-label"><strong>Logo Preview</strong></label>
                                                <div class="border rounded p-3 bg-light">
                                                    <?php if (!empty($footerData['columns']['branding']['logo']['src'])): ?>
                                                        <img src="../<?php echo htmlspecialchars($footerData['columns']['branding']['logo']['src']); ?>" alt="Footer Logo" class="logo-preview">
                                                    <?php else: ?>
                                                        <span class="text-muted">No logo selected.</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="row g-3 mt-3">
                                                <div class="col-md-6">
                                                    <label class="form-label"><strong>Logo Alt Text</strong></label>
                                                    <input type="text" class="form-control" name="branding_logo_alt" value="<?php echo htmlspecialchars($footerData['columns']['branding']['logo']['alt']); ?>" placeholder="Kaizen Karate">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label"><strong>Brand Title</strong></label>
                                                    <input type="text" class="form-control" name="branding_title" value="<?php echo htmlspecialchars($footerData['columns']['branding']['title']); ?>" placeholder="Kaizen Karate">
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <label class="form-label"><strong>Brand Description</strong></label>
                                                <textarea class="form-control" name="branding_description" rows="4" placeholder="Short introduction text shown under the logo."><?php echo htmlspecialchars($footerData['columns']['branding']['description']); ?></textarea>
                                                <div class="help-text">Plain text only. Keep it concise and informative.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingQuickLinks">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseQuickLinks" aria-expanded="false" aria-controls="collapseQuickLinks">
                                            <i class="fas fa-link me-2"></i>Column 2 - Quick Links
                                        </button>
                                    </h2>
                                    <div id="collapseQuickLinks" class="accordion-collapse collapse" aria-labelledby="headingQuickLinks" data-bs-parent="#footerAccordion">
                                        <div class="accordion-body">
                                            <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" type="checkbox" id="quick_links_enabled" name="quick_links_enabled" <?php echo $footerData['columns']['quick_links']['enabled'] ? 'checked' : ''; ?>>

                                                <label class="form-check-label" for="quick_links_enabled">Show Quick Links Column</label>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Column Title</strong></label>
                                                <input type="text" class="form-control" name="quick_links_title" value="<?php echo htmlspecialchars($footerData['columns']['quick_links']['title']); ?>" placeholder="Quick Links">
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="mb-0 text-primary"><i class="fas fa-list me-2"></i>Links</h5>
                                                <div>
                                                    <small class="text-muted me-3">Up to <?php echo $maxQuickLinks; ?> links.</small>
                                                    <button type="button" class="btn btn-success btn-sm" id="add-quick-link">
                                                        <i class="fas fa-plus me-1"></i>Add Link
                                                    </button>
                                                </div>
                                            </div>
                                            <div id="quick-links-container">
                                                <?php if (!empty($footerData['columns']['quick_links']['links'])): ?>
                                                    <?php foreach ($footerData['columns']['quick_links']['links'] as $index => $link): ?>
                                                        <div class="repeater-card quick-link-row" data-index="<?php echo $index; ?>">
                                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                                <h6 class="mb-0 text-secondary">Link <span class="quick-link-position"><?php echo $index + 1; ?></span></h6>
                                                                <div class="btn-group repeater-controls" role="group">
                                                                    <button type="button" class="btn btn-outline-secondary btn-sm quick-link-up" title="Move Up">
                                                                        <i class="fas fa-arrow-up"></i>
                                                                    </button>
                                                                    <button type="button" class="btn btn-outline-secondary btn-sm quick-link-down" title="Move Down">
                                                                        <i class="fas fa-arrow-down"></i>
                                                                    </button>
                                                                    <button type="button" class="btn btn-outline-danger btn-sm quick-link-remove" title="Remove">
                                                                        <i class="fas fa-times"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="row g-3">
                                                                <div class="col-md-6">
                                                                    <label class="form-label">Link Label <span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="quick_links[<?php echo $index; ?>][label]" value="<?php echo htmlspecialchars($link['label'] ?? ''); ?>" placeholder="e.g., Training Options">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label">URL <span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="quick_links[<?php echo $index; ?>][url]" value="<?php echo htmlspecialchars($link['url'] ?? ''); ?>" placeholder="#anchor or https://">
                                                                    <div class="help-text">Relative anchors or full URLs are allowed.</div>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" class="quick-link-order" name="quick_links[<?php echo $index; ?>][order]" value="<?php echo $index; ?>">
                                                        </div>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <div class="alert alert-light border d-flex align-items-center">
                                                        <i class="fas fa-info-circle me-2 text-primary"></i>
                                                        <div>No quick links yet. Click "Add Link" to create one.</div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <input type="hidden" id="quick-links-next-index" value="<?php echo $quickLinksNextIndex; ?>">
                                            <input type="hidden" id="quick-links-max" value="<?php echo $maxQuickLinks; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingContact">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseContact" aria-expanded="false" aria-controls="collapseContact">
                                            <i class="fas fa-address-book me-2"></i>Column 3 - Contact & Social
                                        </button>
                                    </h2>
                                    <div id="collapseContact" class="accordion-collapse collapse" aria-labelledby="headingContact" data-bs-parent="#footerAccordion">
                                        <div class="accordion-body">
                                            <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" type="checkbox" id="contact_enabled" name="contact_enabled" <?php echo $footerData['columns']['contact']['enabled'] ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="contact_enabled">Show Contact Column</label>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Contact Heading</strong></label>
                                                <input type="text" class="form-control" name="contact_heading" value="<?php echo htmlspecialchars($footerData['columns']['contact']['heading']); ?>" placeholder="Get In Touch">
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="mb-0 text-primary"><i class="fas fa-phone-alt me-2"></i>Contact Items</h5>
                                                <div>
                                                    <small class="text-muted me-3">Up to <?php echo $maxContactItems; ?> items.</small>
                                                    <button type="button" class="btn btn-success btn-sm" id="add-contact-item">
                                                        <i class="fas fa-plus me-1"></i>Add Contact Item
                                                    </button>
                                                </div>
                                            </div>
                                            <div id="contact-items-container">
                                                <?php if (!empty($footerData['columns']['contact']['items'])): ?>
                                                    <?php foreach ($footerData['columns']['contact']['items'] as $index => $item): ?>
                                                        <div class="repeater-card contact-item-row" data-index="<?php echo $index; ?>">
                                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                                <h6 class="mb-0 text-secondary">Contact Item <span class="contact-item-position"><?php echo $index + 1; ?></span></h6>
                                                                <div class="btn-group repeater-controls" role="group">
                                                                    <button type="button" class="btn btn-outline-secondary btn-sm contact-item-up" title="Move Up">
                                                                        <i class="fas fa-arrow-up"></i>
                                                                    </button>
                                                                    <button type="button" class="btn btn-outline-secondary btn-sm contact-item-down" title="Move Down">
                                                                        <i class="fas fa-arrow-down"></i>
                                                                    </button>
                                                                    <button type="button" class="btn btn-outline-danger btn-sm contact-item-remove" title="Remove">
                                                                        <i class="fas fa-times"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="row g-3">
                                                                <div class="col-md-3">
                                                                    <label class="form-label">Type</label>
                                                                    <select class="form-select" name="contact_items[<?php echo $index; ?>][type]">
                                                                        <?php
                                                                        $types = [
                                                                            'phone' => 'Phone',
                                                                            'email' => 'Email',
                                                                            'address' => 'Address'
                                                                        ];
                                                                        foreach ($types as $value => $label): ?>
                                                                            <option value="<?php echo $value; ?>" <?php echo (($item['type'] ?? '') === $value) ? 'selected' : ''; ?>>
                                                                                <?php echo $label; ?>
                                                                            </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label">Label</label>
                                                                    <input type="text" class="form-control" name="contact_items[<?php echo $index; ?>][label]" value="<?php echo htmlspecialchars($item['label'] ?? ''); ?>" placeholder="e.g., DC, MD, VA Programs">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label">Value <span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="contact_items[<?php echo $index; ?>][value]" value="<?php echo htmlspecialchars($item['value'] ?? ''); ?>" placeholder="Phone/email/address">
                                                                </div>
                    <div class="col-md-3">
                        <label class="form-label">Icon Class</label>
                        <select class="form-select icon-select" name="contact_items[<?php echo $index; ?>][icon]">
                            <?php foreach ($contactIconOptions as $iconValue => $label): ?>
                                <option value="<?php echo $iconValue; ?>" <?php echo (($item['icon'] ?? '') === $iconValue) ? 'selected' : ''; ?>>
                                    <?php echo $label; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="help-text">Choose the icon that best matches this contact item.</div>
                    </div>
                </div>
                <input type="hidden" class="contact-item-order" name="contact_items[<?php echo $index; ?>][order]" value="<?php echo $index; ?>">
            </div>
        <?php endforeach; ?>
                                                <?php else: ?>
                                                    <div class="alert alert-light border d-flex align-items-center">
                                                        <i class="fas fa-info-circle me-2 text-primary"></i>
                                                        <div>No contact items yet. Click "Add Contact Item" to create one.</div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <input type="hidden" id="contact-items-next-index" value="<?php echo $contactItemsNextIndex; ?>">
                                            <input type="hidden" id="contact-items-max" value="<?php echo $maxContactItems; ?>">

                                            <hr class="my-4">

                                            <div class="mb-3">
                                                <label class="form-label"><strong>Social Heading</strong></label>
                                                <input type="text" class="form-control" name="social_heading" value="<?php echo htmlspecialchars($footerData['columns']['contact']['social_heading']); ?>" placeholder="Follow Us">
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="mb-0 text-primary"><i class="fas fa-share-alt me-2"></i>Social Media Links</h5>
                                                <div>
                                                    <small class="text-muted me-3">Up to <?php echo $maxSocialLinks; ?> links.</small>
                                                    <button type="button" class="btn btn-success btn-sm" id="add-social-link">
                                                        <i class="fas fa-plus me-1"></i>Add Social Link
                                                    </button>
                                                </div>
                                            </div>
                                            <div id="social-links-container">
                                                <?php if (!empty($footerData['columns']['contact']['social_links'])): ?>
                                                    <?php foreach ($footerData['columns']['contact']['social_links'] as $index => $link): ?>
                                                        <div class="repeater-card social-link-row" data-index="<?php echo $index; ?>">
                                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                                <h6 class="mb-0 text-secondary">Social Link <span class="social-link-position"><?php echo $index + 1; ?></span></h6>
                                                                <div class="btn-group repeater-controls" role="group">
                                                                    <button type="button" class="btn btn-outline-secondary btn-sm social-link-up" title="Move Up">
                                                                        <i class="fas fa-arrow-up"></i>
                                                                    </button>
                                                                    <button type="button" class="btn btn-outline-secondary btn-sm social-link-down" title="Move Down">
                                                                        <i class="fas fa-arrow-down"></i>
                                                                    </button>
                                                                    <button type="button" class="btn btn-outline-danger btn-sm social-link-remove" title="Remove">
                                                                        <i class="fas fa-times"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="row g-3">
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Platform <span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="social_links[<?php echo $index; ?>][platform]" value="<?php echo htmlspecialchars($link['platform'] ?? ''); ?>" placeholder="e.g., Facebook">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">URL <span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="social_links[<?php echo $index; ?>][url]" value="<?php echo htmlspecialchars($link['url'] ?? ''); ?>" placeholder="https://">
                                                                </div>
                    <div class="col-md-4">
                        <label class="form-label">Icon Class <span class="text-danger">*</span></label>
                        <select class="form-select icon-select" name="social_links[<?php echo $index; ?>][icon]">
                            <?php foreach ($socialIconOptions as $iconValue => $label): ?>
                                <option value="<?php echo $iconValue; ?>" <?php echo (($link['icon'] ?? '') === $iconValue) ? 'selected' : ''; ?>>
                                    <?php echo $label; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="help-text">Font Awesome icon is selected for you—pick the right platform.</div>
                    </div>
                </div>
                <input type="hidden" class="social-link-order" name="social_links[<?php echo $index; ?>][order]" value="<?php echo $index; ?>">
            </div>
        <?php endforeach; ?>
                                                <?php else: ?>
                                                    <div class="alert alert-light border d-flex align-items-center">
                                                        <i class="fas fa-info-circle me-2 text-primary"></i>
                                                        <div>No social links yet. Click "Add Social Link" to create one.</div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <input type="hidden" id="social-links-next-index" value="<?php echo $socialLinksNextIndex; ?>">
                                            <input type="hidden" id="social-links-max" value="<?php echo $maxSocialLinks; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingBottom">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBottom" aria-expanded="false" aria-controls="collapseBottom">
                                            <i class="fas fa-ruler-horizontal me-2"></i>Bottom Bar
                                        </button>
                                    </h2>
                                    <div id="collapseBottom" class="accordion-collapse collapse" aria-labelledby="headingBottom" data-bs-parent="#footerAccordion">
                                        <div class="accordion-body">
                                            <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" type="checkbox" id="bottom_enabled" name="bottom_enabled" <?php echo $footerData['bottom_bar']['enabled'] ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="bottom_enabled">Show Bottom Bar</label>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Copyright Text</strong></label>
                                                <input type="text" class="form-control" name="bottom_copyright" value="<?php echo htmlspecialchars($footerData['bottom_bar']['copyright']); ?>" placeholder="© {YEAR} Kaizen Karate. All Rights Reserved.">
                                                <div class="help-text">Use {YEAR} to auto-display the current year.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div class="text-muted">
                                    <i class="fas fa-save me-2"></i>Saves update <code>site-content-draft.json</code>.
                                </div>
                                <button type="submit" class="btn btn-kaizen">
                                    <i class="fas fa-save me-2"></i>Save Footer to Draft
                                </button>
                            </div>
                        </form>

</div>

<div class="template-holder d-none" id="quick-link-template">
        <div class="repeater-card quick-link-row" data-index="__INDEX__">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0 text-secondary">Link <span class="quick-link-position">__POSITION__</span></h6>
                <div class="btn-group repeater-controls" role="group">
                    <button type="button" class="btn btn-outline-secondary btn-sm quick-link-up" title="Move Up">
                        <i class="fas fa-arrow-up"></i>
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-sm quick-link-down" title="Move Down">
                        <i class="fas fa-arrow-down"></i>
                    </button>
                    <button type="button" class="btn btn-outline-danger btn-sm quick-link-remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Link Label <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="quick_links[__INDEX__][label]" placeholder="e.g., Training Options">
                </div>
                <div class="col-md-6">
                    <label class="form-label">URL <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="quick_links[__INDEX__][url]" placeholder="#anchor or https://">
                    <div class="help-text">Relative anchors or full URLs are allowed.</div>
                </div>
            </div>
            <input type="hidden" class="quick-link-order" name="quick_links[__INDEX__][order]" value="__ORDER__">
        </div>
    </div>

    <div class="template-holder d-none" id="contact-item-template">
        <div class="repeater-card contact-item-row" data-index="__INDEX__">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0 text-secondary">Contact Item <span class="contact-item-position">__POSITION__</span></h6>
                <div class="btn-group repeater-controls" role="group">
                    <button type="button" class="btn btn-outline-secondary btn-sm contact-item-up" title="Move Up">
                        <i class="fas fa-arrow-up"></i>
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-sm contact-item-down" title="Move Down">
                        <i class="fas fa-arrow-down"></i>
                    </button>
                    <button type="button" class="btn btn-outline-danger btn-sm contact-item-remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Type</label>
                    <select class="form-select" name="contact_items[__INDEX__][type]">
                        <option value="phone">Phone</option>
                        <option value="email">Email</option>
                        <option value="address">Address</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Label</label>
                    <input type="text" class="form-control" name="contact_items[__INDEX__][label]" placeholder="e.g., NY Program">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Value <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="contact_items[__INDEX__][value]" placeholder="Phone/email/address">
                </div>
    <div class="col-md-3">
        <label class="form-label">Icon Class</label>
        <select class="form-select icon-select" name="contact_items[__INDEX__][icon]">
            <?php foreach ($contactIconOptions as $iconValue => $label): ?>
                <option value="<?php echo $iconValue; ?>"><?php echo $label; ?></option>
            <?php endforeach; ?>
        </select>
        <div class="help-text">Choose the icon that best matches this contact item.</div>
    </div>
</div>
            <input type="hidden" class="contact-item-order" name="contact_items[__INDEX__][order]" value="__ORDER__">
        </div>
    </div>

    <div class="template-holder d-none" id="social-link-template">
        <div class="repeater-card social-link-row" data-index="__INDEX__">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0 text-secondary">Social Link <span class="social-link-position">__POSITION__</span></h6>
                <div class="btn-group repeater-controls" role="group">
                    <button type="button" class="btn btn-outline-secondary btn-sm social-link-up" title="Move Up">
                        <i class="fas fa-arrow-up"></i>
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-sm social-link-down" title="Move Down">
                        <i class="fas fa-arrow-down"></i>
                    </button>
                    <button type="button" class="btn btn-outline-danger btn-sm social-link-remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Platform <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="social_links[__INDEX__][platform]" placeholder="e.g., Facebook">
                </div>
                <div class="col-md-4">
                    <label class="form-label">URL <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="social_links[__INDEX__][url]" placeholder="https://">
                </div>
    <div class="col-md-4">
        <label class="form-label">Icon Class <span class="text-danger">*</span></label>
        <select class="form-select icon-select" name="social_links[__INDEX__][icon]">
            <?php foreach ($socialIconOptions as $iconValue => $label): ?>
                <option value="<?php echo $iconValue; ?>"><?php echo $label; ?></option>
            <?php endforeach; ?>
        </select>
        <div class="help-text">Font Awesome icon is selected for you—pick the right platform.</div>
    </div>
</div>
            <input type="hidden" class="social-link-order" name="social_links[__INDEX__][order]" value="__ORDER__">
        </div>
    </div>
<?php
$page_content = ob_get_clean();

$page_title = 'Footer';
$page_icon = 'fas fa-shoe-prints';

include 'includes/admin-template.php';
?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const pageContentTarget = document.getElementById('page-content');
    if (!pageContentTarget) {
        return;
    }

    pageContentTarget.innerHTML = <?php echo json_encode($page_content); ?>;

    const quickLinksContainer = document.getElementById('quick-links-container');
    const contactItemsContainer = document.getElementById('contact-items-container');
    const socialLinksContainer = document.getElementById('social-links-container');

    if (!quickLinksContainer || !contactItemsContainer || !socialLinksContainer) {
        return;
    }

    const quickLinksTemplate = document.getElementById('quick-link-template').innerHTML.trim();
    const quickLinksNextIndexInput = document.getElementById('quick-links-next-index');
    const quickLinksMax = parseInt(document.getElementById('quick-links-max').value, 10);
    let quickLinksCounter = parseInt(quickLinksNextIndexInput.value, 10) || 0;
    const addQuickLinkButton = document.getElementById('add-quick-link');

    const contactItemTemplate = document.getElementById('contact-item-template').innerHTML.trim();
    const contactItemsNextIndexInput = document.getElementById('contact-items-next-index');
    const contactItemsMax = parseInt(document.getElementById('contact-items-max').value, 10);
    let contactItemsCounter = parseInt(contactItemsNextIndexInput.value, 10) || 0;
    const addContactItemButton = document.getElementById('add-contact-item');

    const socialLinksTemplate = document.getElementById('social-link-template').innerHTML.trim();
    const socialLinksNextIndexInput = document.getElementById('social-links-next-index');
    const socialLinksMax = parseInt(document.getElementById('social-links-max').value, 10);
    let socialLinksCounter = parseInt(socialLinksNextIndexInput.value, 10) || 0;
    const addSocialLinkButton = document.getElementById('add-social-link');

    function reindexRows(container, rowSelector, positionSelector, orderSelector, upSelector, downSelector, addButton, maxItems) {
        const rows = container.querySelectorAll(':scope > ' + rowSelector);
        rows.forEach(function (row, index) {
            const position = row.querySelector(positionSelector);
            if (position) {
                position.textContent = index + 1;
            }
            const orderInput = row.querySelector(orderSelector);
            if (orderInput) {
                orderInput.value = index;
            }

            const upBtn = row.querySelector(upSelector);
            const downBtn = row.querySelector(downSelector);
            if (upBtn) {
                upBtn.disabled = index === 0;
            }
            if (downBtn) {
                downBtn.disabled = index === rows.length - 1;
            }
        });
        if (addButton) {
            addButton.disabled = rows.length >= maxItems;
        }
    }

    function attachRowHandlers(row, container, upSelector, downSelector, removeSelector, rowSelector, positionSelector, orderSelector, addButton, maxItems) {
        const upBtn = row.querySelector(upSelector);
        const downBtn = row.querySelector(downSelector);
        const removeBtn = row.querySelector(removeSelector);

        if (upBtn) {
            upBtn.addEventListener('click', function () {
                const previous = row.previousElementSibling;
                if (previous) {
                    container.insertBefore(row, previous);
                    reindexRows(container, rowSelector, positionSelector, orderSelector, upSelector, downSelector, addButton, maxItems);
                }
            });
        }

        if (downBtn) {
            downBtn.addEventListener('click', function () {
                const next = row.nextElementSibling ? row.nextElementSibling.nextElementSibling : null;
                container.insertBefore(row, next);
                reindexRows(container, rowSelector, positionSelector, orderSelector, upSelector, downSelector, addButton, maxItems);
            });
        }

        if (removeBtn) {
            removeBtn.addEventListener('click', function () {
                row.remove();
                reindexRows(container, rowSelector, positionSelector, orderSelector, upSelector, downSelector, addButton, maxItems);
            });
        }
    }

    document.querySelectorAll('#quick-links-container .quick-link-row').forEach(function (row) {
        attachRowHandlers(row, quickLinksContainer, '.quick-link-up', '.quick-link-down', '.quick-link-remove', '.quick-link-row', '.quick-link-position', '.quick-link-order', addQuickLinkButton, quickLinksMax);
    });
    document.querySelectorAll('#contact-items-container .contact-item-row').forEach(function (row) {
        attachRowHandlers(row, contactItemsContainer, '.contact-item-up', '.contact-item-down', '.contact-item-remove', '.contact-item-row', '.contact-item-position', '.contact-item-order', addContactItemButton, contactItemsMax);
    });
    document.querySelectorAll('#social-links-container .social-link-row').forEach(function (row) {
        attachRowHandlers(row, socialLinksContainer, '.social-link-up', '.social-link-down', '.social-link-remove', '.social-link-row', '.social-link-position', '.social-link-order', addSocialLinkButton, socialLinksMax);
    });

    reindexRows(quickLinksContainer, '.quick-link-row', '.quick-link-position', '.quick-link-order', '.quick-link-up', '.quick-link-down', addQuickLinkButton, quickLinksMax);
    reindexRows(contactItemsContainer, '.contact-item-row', '.contact-item-position', '.contact-item-order', '.contact-item-up', '.contact-item-down', addContactItemButton, contactItemsMax);
    reindexRows(socialLinksContainer, '.social-link-row', '.social-link-position', '.social-link-order', '.social-link-up', '.social-link-down', addSocialLinkButton, socialLinksMax);

    if (addQuickLinkButton) {
        addQuickLinkButton.addEventListener('click', function () {
            const currentCount = quickLinksContainer.querySelectorAll(':scope > .quick-link-row').length;
            if (currentCount >= quickLinksMax) {
                return;
            }

            const index = quickLinksCounter++;
            quickLinksNextIndexInput.value = quickLinksCounter;

            const templateHtml = quickLinksTemplate
                .replace(/__INDEX__/g, index)
                .replace('__POSITION__', currentCount + 1)
                .replace('__ORDER__', currentCount);

            const wrapper = document.createElement('div');
            wrapper.innerHTML = templateHtml;
            const newRow = wrapper.firstElementChild;
            quickLinksContainer.appendChild(newRow);
            attachRowHandlers(newRow, quickLinksContainer, '.quick-link-up', '.quick-link-down', '.quick-link-remove', '.quick-link-row', '.quick-link-position', '.quick-link-order', addQuickLinkButton, quickLinksMax);
            reindexRows(quickLinksContainer, '.quick-link-row', '.quick-link-position', '.quick-link-order', '.quick-link-up', '.quick-link-down', addQuickLinkButton, quickLinksMax);
        });
    }

    if (addContactItemButton) {
        addContactItemButton.addEventListener('click', function () {
            const currentCount = contactItemsContainer.querySelectorAll(':scope > .contact-item-row').length;
            if (currentCount >= contactItemsMax) {
                return;
            }

            const index = contactItemsCounter++;
            contactItemsNextIndexInput.value = contactItemsCounter;

            const templateHtml = contactItemTemplate
                .replace(/__INDEX__/g, index)
                .replace('__POSITION__', currentCount + 1)
                .replace('__ORDER__', currentCount);

            const wrapper = document.createElement('div');
            wrapper.innerHTML = templateHtml;
            const newRow = wrapper.firstElementChild;
            contactItemsContainer.appendChild(newRow);
            attachRowHandlers(newRow, contactItemsContainer, '.contact-item-up', '.contact-item-down', '.contact-item-remove', '.contact-item-row', '.contact-item-position', '.contact-item-order', addContactItemButton, contactItemsMax);
            reindexRows(contactItemsContainer, '.contact-item-row', '.contact-item-position', '.contact-item-order', '.contact-item-up', '.contact-item-down', addContactItemButton, contactItemsMax);
        });
    }

    if (addSocialLinkButton) {
        addSocialLinkButton.addEventListener('click', function () {
            const currentCount = socialLinksContainer.querySelectorAll(':scope > .social-link-row').length;
            if (currentCount >= socialLinksMax) {
                return;
            }

            const index = socialLinksCounter++;
            socialLinksNextIndexInput.value = socialLinksCounter;

            const templateHtml = socialLinksTemplate
                .replace(/__INDEX__/g, index)
                .replace('__POSITION__', currentCount + 1)
                .replace('__ORDER__', currentCount);

            const wrapper = document.createElement('div');
            wrapper.innerHTML = templateHtml;
            const newRow = wrapper.firstElementChild;
            socialLinksContainer.appendChild(newRow);
            attachRowHandlers(newRow, socialLinksContainer, '.social-link-up', '.social-link-down', '.social-link-remove', '.social-link-row', '.social-link-position', '.social-link-order', addSocialLinkButton, socialLinksMax);
            reindexRows(socialLinksContainer, '.social-link-row', '.social-link-position', '.social-link-order', '.social-link-up', '.social-link-down', addSocialLinkButton, socialLinksMax);
        });
    }
});
</script>
