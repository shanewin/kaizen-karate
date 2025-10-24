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
        $content = load_json_data('site-content');
        
        // Update Programs section
        if (isset($_POST['programs_section'])) {
            $content['programs'] = [
                'title' => sanitize_input($_POST['programs_title']),
                'subtitle' => sanitize_input($_POST['programs_subtitle']),
                'cards' => []
            ];
            
            // Process all 4 cards
            for ($i = 1; $i <= 4; $i++) {
                $card = [
                    'title' => sanitize_input($_POST["card{$i}_title"]),
                    'summary' => sanitize_input($_POST["card{$i}_summary"]),
                    'description' => sanitize_input($_POST["card{$i}_description"]),
                    'image' => sanitize_input($_POST["card{$i}_image"]),
                    'image_alt' => sanitize_input($_POST["card{$i}_image_alt"]),
                    'buttons' => []
                ];
                
                // Handle image upload
                if (isset($_FILES["card{$i}_image_upload"]) && $_FILES["card{$i}_image_upload"]['error'] === UPLOAD_ERR_OK) {
                    $upload_result = handle_file_upload("card{$i}_image_upload", 'image', '../assets/images/panels/');
                    if ($upload_result['success']) {
                        $card['image'] = $upload_result['path'];
                        $message = success_message("Card {$i} image uploaded successfully!");
                    }
                }
                
                // Process buttons (up to 2 per card)
                for ($j = 1; $j <= 2; $j++) {
                    $button_text = sanitize_input($_POST["card{$i}_button{$j}_text"]);
                    $button_url = sanitize_input($_POST["card{$i}_button{$j}_url"]);
                    $button_style = sanitize_input($_POST["card{$i}_button{$j}_style"]);
                    
                    if (!empty($button_text) && !empty($button_url)) {
                        $card['buttons'][] = [
                            'text' => $button_text,
                            'url' => $button_url,
                            'style' => $button_style
                        ];
                    }
                }
                
                $content['programs']['cards'][] = $card;
            }
            
            if (save_json_data('site-content', $content)) {
                $message = success_message('Programs section updated successfully!');
            } else {
                $message = error_message('Failed to save changes.');
            }
        }
    }
}

// Load current content
$content = load_json_data('site-content');
$programs = $content['programs'] ?? [];
$cards = $programs['cards'] ?? [];

// Default card data with original content
$default_cards = [
    [
        'title' => 'After School Program',
        'summary' => 'Comprehensive martial arts training for students after school hours.',
        'description' => 'Safe, structured environment where children learn traditional karate while developing discipline, respect, and confidence. Perfect for working parents.',
        'image' => 'assets/images/panels/after-school.jpg',
        'image_alt' => 'After school karate program for children at Kaizen Karate',
        'buttons' => [
            ['text' => 'Register Now →', 'url' => 'https://www.gomotionapp.com/team/mdkfu/page/class-registration', 'style' => 'secondary']
        ]
    ],
    [
        'title' => 'Weekend & Evening',
        'summary' => 'Flexible scheduling for adults and families with busy weekday commitments.',
        'description' => 'Traditional karate training designed to fit your lifestyle. Weekend and evening classes accommodate work and school schedules while maintaining authentic instruction.',
        'image' => 'assets/images/panels/weekends.jpg',
        'image_alt' => 'Weekend and evening karate classes for busy schedules',
        'buttons' => [
            ['text' => 'View Schedule →', 'url' => '#after-school', 'style' => 'primary'],
            ['text' => 'Register Now →', 'url' => 'https://www.gomotionapp.com/team/mdkfu/page/class-registration', 'style' => 'secondary']
        ]
    ],
    [
        'title' => 'Belt Exams',
        'summary' => 'Test your skills and advance through traditional karate ranks.',
        'description' => 'Belt exams are invitation-only and students must be invited by their instructor to test. Our rigorous testing ensures authentic skill development and progression.',
        'image' => 'assets/images/panels/belts.png',
        'image_alt' => 'Traditional karate belt exam process at Kaizen Karate',
        'buttons' => [
            ['text' => 'View Process →', 'url' => '#belt-exam', 'style' => 'primary'],
            ['text' => 'Register Now →', 'url' => '#', 'style' => 'secondary']
        ]
    ],
    [
        'title' => 'Online Store',
        'summary' => 'Equipment, uniforms, and training materials for students.',
        'description' => 'Everything you need for your karate journey - from beginner gear to advanced equipment. Support your training with authentic, high-quality items.',
        'image' => 'assets/images/panels/online-store.jpg',
        'image_alt' => 'Kaizen Karate online store for equipment and merchandise',
        'buttons' => [
            ['text' => 'Shop Now →', 'url' => '#online-store', 'style' => 'primary']
        ]
    ]
];

// Ensure we have 4 cards
while (count($cards) < 4) {
    $cards[] = $default_cards[count($cards)];
}

// Ensure each card has proper structure with original content as defaults
for ($i = 0; $i < 4; $i++) {
    $cards[$i] = array_merge($default_cards[$i], $cards[$i]);
}

$page_title = 'Programs (4 Cards)';
$page_icon = 'fas fa-th-large';

// Set page variables for template
ob_start();
?>

<!-- Programs Section -->
<div class="content-section">
    <h3 class="section-title"><i class="fas fa-th-large me-2"></i>Programs Section</h3>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="programs_section" value="1">
        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
        
        <!-- Section Header -->
        <div class="mb-4">
            <h5 class="text-primary mb-3"><i class="fas fa-heading me-2"></i>Section Header</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="programs_title" class="form-label"><strong>Main Title</strong></label>
                        <input type="text" class="form-control" id="programs_title" name="programs_title" 
                               value="<?php echo htmlspecialchars($programs['title'] ?? 'Our Programs'); ?>"
                               placeholder="e.g., Our Programs">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="programs_subtitle" class="form-label"><strong>Subtitle</strong></label>
                        <input type="text" class="form-control" id="programs_subtitle" name="programs_subtitle" 
                               value="<?php echo htmlspecialchars($programs['subtitle'] ?? 'Choose Your Path'); ?>"
                               placeholder="e.g., Choose Your Path">
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Program Cards -->
        <?php 
        $card_names = ['After School Program', 'Weekend & Evening', 'Belt Exams', 'Online Store'];
        for ($i = 0; $i < 4; $i++): 
            $card = $cards[$i];
            $card_num = $i + 1;
            $card_name = $card_names[$i];
        ?>
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0 text-primary">
                    <i class="fas fa-card-blank me-2"></i><?php echo $card_name; ?> (Card <?php echo $card_num; ?>)
                </h5>
            </div>
            <div class="card-body">
                <!-- Basic Info -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><strong>Card Title</strong></label>
                            <input type="text" class="form-control" name="card<?php echo $card_num; ?>_title" 
                                   value="<?php echo htmlspecialchars($card['title']); ?>"
                                   placeholder="e.g., <?php echo $card_name; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><strong>Summary Text</strong></label>
                            <input type="text" class="form-control" name="card<?php echo $card_num; ?>_summary" 
                                   value="<?php echo htmlspecialchars($card['summary']); ?>"
                                   placeholder="Short description shown initially">
                            <div class="form-text">Brief text shown before "Read More"</div>
                        </div>
                    </div>
                </div>
                
                <!-- Full Description -->
                <div class="mb-3">
                    <label class="form-label"><strong>Full Description</strong></label>
                    <textarea class="form-control" name="card<?php echo $card_num; ?>_description" rows="3"
                              placeholder="Detailed description shown after clicking 'Read More'"><?php echo htmlspecialchars($card['description']); ?></textarea>
                    <div class="form-text">Expanded text shown when "Read More" is clicked</div>
                </div>
                
                <!-- Image Settings -->
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label"><strong>Upload New Image</strong></label>
                            <input type="file" class="form-control" name="card<?php echo $card_num; ?>_image_upload" 
                                   accept="image/*" onchange="previewImage(this, 'card<?php echo $card_num; ?>-preview')">
                            <div class="form-text">Upload JPG, PNG, or WebP image for this card</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Or Enter Image Path</strong></label>
                            <input type="text" class="form-control" name="card<?php echo $card_num; ?>_image" 
                                   value="<?php echo htmlspecialchars($card['image']); ?>"
                                   placeholder="e.g., assets/images/panels/<?php echo strtolower(str_replace(' ', '-', $card_name)); ?>.jpg">
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Image Alt Text</strong></label>
                            <input type="text" class="form-control" name="card<?php echo $card_num; ?>_image_alt" 
                                   value="<?php echo htmlspecialchars($card['image_alt']); ?>"
                                   placeholder="Describe the image for accessibility">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <?php if (!empty($card['image'])): ?>
                            <div class="text-center">
                                <p><strong>Current Image:</strong></p>
                                <img id="card<?php echo $card_num; ?>-preview" src="../<?php echo htmlspecialchars($card['image']); ?>" 
                                     alt="Preview" class="img-thumbnail" style="max-width: 150px;">
                            </div>
                        <?php else: ?>
                            <div id="card<?php echo $card_num; ?>-preview" class="text-center text-muted">
                                <i class="fas fa-image fa-3x mb-2"></i>
                                <p>No image</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Buttons (up to 2) -->
                <h6 class="text-primary mt-4 mb-3"><i class="fas fa-mouse-pointer me-2"></i>Action Buttons</h6>
                <?php for ($j = 1; $j <= 2; $j++): 
                    $button = $card['buttons'][$j-1] ?? [];
                ?>
                <div class="row mb-3 p-2 border rounded">
                    <div class="col-md-4">
                        <label class="form-label"><strong>Button <?php echo $j; ?> Text</strong></label>
                        <input type="text" class="form-control" name="card<?php echo $card_num; ?>_button<?php echo $j; ?>_text" 
                               value="<?php echo htmlspecialchars($button['text'] ?? ''); ?>"
                               placeholder="e.g., Register Now">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><strong>Button <?php echo $j; ?> URL</strong></label>
                        <input type="text" class="form-control" name="card<?php echo $card_num; ?>_button<?php echo $j; ?>_url" 
                               value="<?php echo htmlspecialchars($button['url'] ?? ''); ?>"
                               placeholder="e.g., #section or https://...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><strong>Button <?php echo $j; ?> Style</strong></label>
                        <select class="form-select" name="card<?php echo $card_num; ?>_button<?php echo $j; ?>_style">
                            <option value="primary" <?php echo (($button['style'] ?? '') === 'primary') ? 'selected' : ''; ?>>Primary (Red)</option>
                            <option value="secondary" <?php echo (($button['style'] ?? '') === 'secondary') ? 'selected' : ''; ?>>Secondary (Dark)</option>
                        </select>
                    </div>
                </div>
                <?php endfor; ?>
                <div class="form-text mt-2">
                    <i class="fas fa-lightbulb text-warning me-1"></i>
                    Leave button text empty to hide that button. Primary buttons are red, secondary buttons are dark.
                </div>
            </div>
        </div>
        <?php endfor; ?>
        
        <button type="submit" class="btn btn-kaizen">
            <i class="fas fa-save me-2"></i>Update Programs Section
        </button>
    </form>
</div>

<!-- Usage Instructions -->
<div class="content-section">
    <h3 class="section-title"><i class="fas fa-info-circle me-2"></i>Programs Section Instructions</h3>
    <div class="row">
        <div class="col-md-6">
            <h6><i class="fas fa-th-large me-2 text-primary"></i>Program Cards Structure</h6>
            <ul class="list-unstyled mb-4">
                <li class="mb-2"><i class="fas fa-check text-muted me-2"></i>Four program cards displayed in responsive grid</li>
                <li class="mb-2"><i class="fas fa-check text-muted me-2"></i>Each card has title, summary, and expandable description</li>
                <li class="mb-2"><i class="fas fa-check text-muted me-2"></i>Summary text shown initially, full description after "Read More"</li>
                <li class="mb-2"><i class="fas fa-check text-muted me-2"></i>Each card can have 1-2 action buttons</li>
                <li class="mb-2"><i class="fas fa-check text-muted me-2"></i>Custom images with upload or manual path entry</li>
            </ul>
            
            <h6><i class="fas fa-mouse-pointer me-2 text-primary"></i>Button Configuration</h6>
            <ul class="list-unstyled mb-0">
                <li class="mb-2"><i class="fas fa-palette text-muted me-2"></i>Primary buttons are red (main actions)</li>
                <li class="mb-2"><i class="fas fa-palette text-muted me-2"></i>Secondary buttons are dark (supporting actions)</li>
                <li class="mb-2"><i class="fas fa-link text-muted me-2"></i>URLs can be internal (#section) or external (https://...)</li>
                <li class="mb-2"><i class="fas fa-eye-slash text-muted me-2"></i>Leave button text empty to hide that button</li>
            </ul>
        </div>
        <div class="col-md-6">
            <h6><i class="fas fa-image me-2 text-primary"></i>Image Guidelines</h6>
            <ul class="list-unstyled mb-4">
                <li class="mb-2"><i class="fas fa-upload text-muted me-2"></i>Upload images directly or enter file paths</li>
                <li class="mb-2"><i class="fas fa-crop text-muted me-2"></i>Images automatically resize to fit card layout</li>
                <li class="mb-2"><i class="fas fa-universal-access text-muted me-2"></i>Always include descriptive alt text for accessibility</li>
                <li class="mb-2"><i class="fas fa-file-image text-muted me-2"></i>Supported formats: JPG, PNG, WebP</li>
            </ul>
            
            <h6><i class="fas fa-mobile text-primary me-2"></i>Content Best Practices</h6>
            <ul class="list-unstyled mb-0">
                <li class="mb-2"><i class="fas fa-text-width text-muted me-2"></i>Keep titles concise and descriptive</li>
                <li class="mb-2"><i class="fas fa-align-left text-muted me-2"></i>Summary: 1-2 sentences, easy to scan</li>
                <li class="mb-2"><i class="fas fa-expand-alt text-muted me-2"></i>Full description: 2-3 sentences with details</li>
                <li class="mb-2"><i class="fas fa-rocket text-muted me-2"></i>Use action-oriented button text</li>
                <li class="mb-2"><i class="fas fa-mobile-alt text-muted me-2"></i>Test on mobile devices for readability</li>
            </ul>
        </div>
    </div>
</div>

<?php
$page_content = ob_get_clean();

// Include the admin template
include 'includes/admin-template.php';
?>
<script>
document.getElementById('page-content').innerHTML = <?php echo json_encode($page_content); ?>;

// Image preview functionality
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
        
        // Validate file size (2MB limit)
        if (file.size > 2 * 1024 * 1024) {
            alert('File size must be less than 2MB');
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `
                <p><strong>New Image Preview:</strong></p>
                <img src="${e.target.result}" alt="Preview" class="img-thumbnail" style="max-width: 150px;">
            `;
        };
        reader.readAsDataURL(file);
    }
}
</script>