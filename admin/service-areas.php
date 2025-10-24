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
        
        // Update Service Areas section
        if (isset($_POST['service_areas_section'])) {
            $service_areas = [
                'title' => sanitize_input($_POST['service_areas_title']),
                'states' => []
            ];
            
            // Process all states
            $num_states = intval($_POST['num_states'] ?? 0);
            for ($i = 1; $i <= $num_states; $i++) {
                $state_name = sanitize_input($_POST["state_{$i}_name"]);
                $state_image = sanitize_input($_POST["state_{$i}_image"]);
                $state_alt = sanitize_input($_POST["state_{$i}_alt"]);
                
                // Handle image upload
                if (isset($_FILES["state_{$i}_image_upload"]) && $_FILES["state_{$i}_image_upload"]['error'] === UPLOAD_ERR_OK) {
                    $upload_result = handle_file_upload("state_{$i}_image_upload", 'image', '../assets/images/states/');
                    if ($upload_result['success']) {
                        $state_image = $upload_result['path'];
                        $message = success_message("State {$i} image uploaded successfully!");
                    }
                }
                
                // Only add if name is provided
                if (!empty($state_name)) {
                    $service_areas['states'][] = [
                        'name' => $state_name,
                        'image' => $state_image,
                        'alt' => $state_alt
                    ];
                }
            }
            
            $content['service_areas'] = $service_areas;
            
            if (save_json_data('site-content', $content, 'draft')) {
                $message = success_message('Service Areas saved to draft successfully!');
            } else {
                $message = error_message('Failed to save changes.');
            }
        }
    }
}

// Load current content from draft
$content = load_json_data('site-content', 'draft');
$service_areas = $content['service_areas'] ?? [];

// Default service areas data with original content
$default_service_areas = [
    'title' => 'Kaizen Karate Proudly Serves:',
    'states' => [
        [
            'name' => 'Washington<br>DC',
            'image' => 'assets/images/states/dc.png',
            'alt' => 'Washington, DC'
        ],
        [
            'name' => 'Maryland',
            'image' => 'assets/images/states/maryland.png',
            'alt' => 'Maryland'
        ],
        [
            'name' => 'Virginia',
            'image' => 'assets/images/states/virginia.png',
            'alt' => 'Virginia'
        ],
        [
            'name' => 'New York',
            'image' => 'assets/images/states/newyork.png',
            'alt' => 'New York'
        ]
    ]
];

// Merge with defaults if empty
$service_areas = array_merge($default_service_areas, $service_areas);
$states = $service_areas['states'];

// Ensure we have at least 1 state
if (empty($states)) {
    $states = $default_service_areas['states'];
}

$page_title = 'Service Areas';
$page_icon = 'fas fa-map-marked-alt';

// Set page variables for template
ob_start();
?>

<!-- Service Areas Section -->
<div class="content-section">
    <h3 class="section-title"><i class="fas fa-map-marked-alt me-2"></i>Service Areas Management</h3>
    <div class="alert alert-kaizen border-0 mb-4">
        <i class="fas fa-info-circle me-2"></i>
        <strong>Service Areas:</strong> Manage the states and regions where Kaizen Karate operates. This section appears on the homepage to show your service coverage.
    </div>
    
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="service_areas_section" value="1">
        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
        <input type="hidden" name="num_states" id="num_states" value="<?php echo count($states); ?>">
        
        <!-- Section Title -->
        <div class="mb-4 p-3 border rounded bg-light">
            <h5 class="text-primary mb-3"><i class="fas fa-heading me-2"></i>Section Title</h5>
            <div class="mb-3">
                <label for="service_areas_title" class="form-label"><strong>Title Text</strong></label>
                <input type="text" class="form-control" id="service_areas_title" name="service_areas_title" 
                       value="<?php echo htmlspecialchars($service_areas['title']); ?>"
                       placeholder="e.g., Kaizen Karate Proudly Serves:">
                <div class="form-text">
                    <i class="fas fa-lightbulb text-warning me-1"></i>This title appears above the state icons
                </div>
            </div>
        </div>
        
        <!-- States Management -->
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="text-primary mb-0"><i class="fas fa-globe-americas me-2"></i>States & Regions</h5>
                <div>
                    <button type="button" class="btn btn-success btn-sm" onclick="addState()">
                        <i class="fas fa-plus me-1"></i>Add State
                    </button>
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeLastState()">
                        <i class="fas fa-minus me-1"></i>Remove Last
                    </button>
                </div>
            </div>
            
            <div id="states-container">
                <?php foreach ($states as $index => $state): 
                    $state_num = $index + 1;
                ?>
                <div class="state-item card mb-3" id="state-<?php echo $state_num; ?>">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>State/Region <?php echo $state_num; ?></h6>
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeState(<?php echo $state_num; ?>)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label"><strong>State/Region Name</strong></label>
                                    <input type="text" class="form-control" name="state_<?php echo $state_num; ?>_name" 
                                           value="<?php echo htmlspecialchars($state['name']); ?>"
                                           placeholder="e.g., Maryland or Washington DC">
                                    <div class="form-text">Use &lt;br&gt; for line breaks (e.g., "Washington&lt;br&gt;DC")</div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label"><strong>Upload New Icon</strong></label>
                                    <input type="file" class="form-control" name="state_<?php echo $state_num; ?>_image_upload" 
                                           accept="image/*" onchange="previewStateImage(this, 'state-<?php echo $state_num; ?>-preview')">
                                    <div class="form-text">Upload icon for this state (PNG recommended, 48x48px optimal)</div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label"><strong>Or Enter Image Path</strong></label>
                                    <input type="text" class="form-control" name="state_<?php echo $state_num; ?>_image" 
                                           value="<?php echo htmlspecialchars($state['image']); ?>"
                                           placeholder="e.g., assets/images/states/maryland.png">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label"><strong>Alt Text</strong></label>
                                    <input type="text" class="form-control" name="state_<?php echo $state_num; ?>_alt" 
                                           value="<?php echo htmlspecialchars($state['alt']); ?>"
                                           placeholder="e.g., Maryland">
                                    <div class="form-text">Accessibility description for screen readers</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <p><strong>Current Icon:</strong></p>
                                    <?php if (!empty($state['image'])): ?>
                                        <img id="state-<?php echo $state_num; ?>-preview" 
                                             src="../<?php echo htmlspecialchars($state['image']); ?>" 
                                             alt="Preview" class="img-thumbnail" style="max-width: 80px; max-height: 80px;">
                                    <?php else: ?>
                                        <div id="state-<?php echo $state_num; ?>-preview" class="text-center text-muted">
                                            <i class="fas fa-map-marker-alt fa-3x mb-2"></i>
                                            <p>No image</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <button type="submit" class="btn btn-kaizen">
            <i class="fas fa-save me-2"></i>Update Service Areas
        </button>
    </form>
</div>

<!-- Usage Instructions -->
<div class="content-section">
    <h3 class="section-title"><i class="fas fa-info-circle me-2"></i>Service Areas Instructions</h3>
    <div class="row">
        <div class="col-md-6">
            <h6><i class="fas fa-map-marked-alt me-2 text-primary"></i>Managing States</h6>
            <ul class="list-unstyled mb-4">
                <li class="mb-2"><i class="fas fa-plus text-muted me-2"></i>Use "Add State" to add new service areas</li>
                <li class="mb-2"><i class="fas fa-minus text-muted me-2"></i>Use "Remove Last" to remove the last state</li>
                <li class="mb-2"><i class="fas fa-trash text-muted me-2"></i>Use trash icon to remove specific states</li>
                <li class="mb-2"><i class="fas fa-sort text-muted me-2"></i>States display in the order you arrange them</li>
                <li class="mb-2"><i class="fas fa-code text-muted me-2"></i>Use &lt;br&gt; for multi-line state names</li>
            </ul>
            
            <h6><i class="fas fa-image me-2 text-primary"></i>Icon Guidelines</h6>
            <ul class="list-unstyled mb-0">
                <li class="mb-2"><i class="fas fa-check text-muted me-2"></i>Optimal size: 48x48 pixels</li>
                <li class="mb-2"><i class="fas fa-check text-muted me-2"></i>Format: PNG with transparency preferred</li>
                <li class="mb-2"><i class="fas fa-check text-muted me-2"></i>Simple, recognizable state/region symbols</li>
                <li class="mb-2"><i class="fas fa-check text-muted me-2"></i>Keep consistent visual style across all icons</li>
            </ul>
        </div>
        <div class="col-md-6">
            <h6><i class="fas fa-mobile-alt me-2 text-primary"></i>Display & Layout</h6>
            <ul class="list-unstyled mb-4">
                <li class="mb-2"><i class="fas fa-desktop text-muted me-2"></i>Icons display in a horizontal row on desktop</li>
                <li class="mb-2"><i class="fas fa-mobile text-muted me-2"></i>Automatically wraps on smaller screens</li>
                <li class="mb-2"><i class="fas fa-eye text-muted me-2"></i>State names appear below icons</li>
                <li class="mb-2"><i class="fas fa-expand-arrows-alt text-muted me-2"></i>Layout adapts to any number of states</li>
            </ul>
            
            <h6><i class="fas fa-lightbulb me-2 text-primary"></i>Best Practices</h6>
            <ul class="list-unstyled mb-0">
                <li class="mb-2"><i class="fas fa-rocket text-muted me-2"></i>Keep state names short and clear</li>
                <li class="mb-2"><i class="fas fa-balance-scale text-muted me-2"></i>Use consistent naming style</li>
                <li class="mb-2"><i class="fas fa-universal-access text-muted me-2"></i>Always include descriptive alt text</li>
                <li class="mb-2"><i class="fas fa-sync text-muted me-2"></i>Test changes on mobile devices</li>
                <li class="mb-2"><i class="fas fa-clock text-muted me-2"></i>Changes appear immediately after saving</li>
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

let stateCounter = <?php echo count($states); ?>;

// Add new state
function addState() {
    stateCounter++;
    const container = document.getElementById('states-container');
    
    const newStateHtml = `
        <div class="state-item card mb-3" id="state-${stateCounter}">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>State/Region ${stateCounter}</h6>
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeState(${stateCounter})">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label"><strong>State/Region Name</strong></label>
                            <input type="text" class="form-control" name="state_${stateCounter}_name" 
                                   value="" placeholder="e.g., Maryland or Washington DC">
                            <div class="form-text">Use &lt;br&gt; for line breaks (e.g., "Washington&lt;br&gt;DC")</div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label"><strong>Upload New Icon</strong></label>
                            <input type="file" class="form-control" name="state_${stateCounter}_image_upload" 
                                   accept="image/*" onchange="previewStateImage(this, 'state-${stateCounter}-preview')">
                            <div class="form-text">Upload icon for this state (PNG recommended, 48x48px optimal)</div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label"><strong>Or Enter Image Path</strong></label>
                            <input type="text" class="form-control" name="state_${stateCounter}_image" 
                                   value="" placeholder="e.g., assets/images/states/maryland.png">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label"><strong>Alt Text</strong></label>
                            <input type="text" class="form-control" name="state_${stateCounter}_alt" 
                                   value="" placeholder="e.g., Maryland">
                            <div class="form-text">Accessibility description for screen readers</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <p><strong>Current Icon:</strong></p>
                            <div id="state-${stateCounter}-preview" class="text-center text-muted">
                                <i class="fas fa-map-marker-alt fa-3x mb-2"></i>
                                <p>No image</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', newStateHtml);
    updateNumStates();
}

// Remove specific state
function removeState(stateNum) {
    const stateElement = document.getElementById(`state-${stateNum}`);
    if (stateElement) {
        stateElement.remove();
        updateNumStates();
    }
}

// Remove last state
function removeLastState() {
    const container = document.getElementById('states-container');
    const states = container.querySelectorAll('.state-item');
    if (states.length > 1) {
        states[states.length - 1].remove();
        updateNumStates();
    } else {
        alert('You must have at least one state/region.');
    }
}

// Update hidden num_states field
function updateNumStates() {
    const container = document.getElementById('states-container');
    const states = container.querySelectorAll('.state-item');
    document.getElementById('num_states').value = states.length;
}

// Image preview functionality
function previewStateImage(input, previewId) {
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
                <img src="${e.target.result}" alt="Preview" class="img-thumbnail" style="max-width: 80px; max-height: 80px;">
            `;
        };
        reader.readAsDataURL(file);
    }
}
</script>