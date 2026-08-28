<?php
// Script to update all lightboxes in testing.php to use dynamic content from JSON

$file = 'testing.php';
$content = file_get_contents($file);

// Define all lightbox mappings
$lightboxes = [
    'testingTipsLightbox' => 'testing_tips',
    'videoInstructionsLightbox' => 'video_instructions',
    'greenBeltLightbox' => 'green_belt',
    'purpleBeltLightbox' => 'purple_belt',
    'blueBeltLightbox' => 'blue_belt',
    'brownBeltLightbox' => 'brown_belt',
    'brownStripeLightbox' => 'brown_stripe',
    'redBeltLightbox' => 'red_belt',
    'redStripeLightbox' => 'red_stripe'
];

foreach ($lightboxes as $lightboxId => $jsonKey) {
    echo "Processing $lightboxId ($jsonKey)...\n";
    
    // Find the lightbox div and replace its inner content
    $pattern = '/(<div id="' . $lightboxId . '"[^>]*>.*?<\/button>)(.*?)(<\/div>\s*<\/div>)/s';
    
    $replacement = '$1
    <div style="background: rgba(255, 255, 255, 0.95); border-radius: 12px; padding: 2rem; color: #333; overflow-y: auto; max-height: 90vh;">
    <?php echo $scriptsAccordion[\'lightbox_content\'][\'' . $jsonKey . '\'] ?? \'<p>Content not configured</p>\'; ?>
    </div>
  </div>';
    
    $newContent = preg_replace($pattern, $replacement, $content, 1, $count);
    
    if ($count > 0) {
        $content = $newContent;
        echo "  ✓ Updated $lightboxId\n";
    } else {
        echo "  ✗ Could not find/update $lightboxId\n";
    }
}

// Add PHP code at the beginning of the lightboxes section to load the scripts accordion data
// Find the comment "<!-- Testing Scripts Lightboxes -->"
$phpLoader = '<!-- Testing Scripts Lightboxes -->
<?php
// Load scripts accordion data for lightboxes
$scriptsAccordion = null;
foreach ($belt_exams_data[\'accordions\'] as $acc) {
    if ($acc[\'id\'] === \'scripts\') {
        $scriptsAccordion = $acc;
        break;
    }
}
?>';

$content = str_replace('<!-- Testing Scripts Lightboxes -->', $phpLoader, $content);

// Save the updated content
file_put_contents($file, $content);
echo "\n✓ Saved updated testing.php with dynamic lightbox content\n";
?>