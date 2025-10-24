<?php
/**
 * Content Loader for Kaizen Karate CMS
 * 
 * This file loads content from JSON files and provides helper functions
 * to display content throughout the website.
 */

// Define paths
define('CONTENT_DIR', __DIR__ . '/../data/content');

/**
 * Load JSON content file
 */
function load_content($filename) {
    $filepath = CONTENT_DIR . '/' . $filename;
    if (file_exists($filepath)) {
        $content = file_get_contents($filepath);
        return json_decode($content, true);
    }
    return [];
}

// Load all content files
$site_content = load_content('site-content.json');
$instructors_data = load_content('instructors.json');
$media_data = load_content('media.json');

/**
 * Get site information
 */
function get_site_info($key = null) {
    global $site_content;
    $info = $site_content['site_info'] ?? [];
    return $key ? ($info[$key] ?? '') : $info;
}

/**
 * Get media path
 */
function get_media($category, $key = null) {
    global $media_data;
    $media = $media_data[$category] ?? [];
    return $key ? ($media[$key] ?? '') : $media;
}

/**
 * Get content section
 */
function get_content($section, $key = null) {
    global $site_content;
    $content = $site_content[$section] ?? [];
    return $key ? ($content[$key] ?? '') : $content;
}

/**
 * Get instructor data
 */
function get_instructors($type = 'all') {
    global $instructors_data;
    switch ($type) {
        case 'main':
            return $instructors_data['main_instructor'] ?? [];
        case 'others':
            return $instructors_data['other_instructors'] ?? [];
        default:
            return $instructors_data;
    }
}

/**
 * Display text content with fallback
 */
function display_text($section, $key, $fallback = '') {
    global $site_content;
    
    // Handle nested array access like 'programs.cards.0.title'
    $keys = explode('.', $key);
    $content = $site_content[$section] ?? [];
    
    foreach ($keys as $k) {
        if (is_array($content) && isset($content[$k])) {
            $content = $content[$k];
        } else {
            $content = '';
            break;
        }
    }
    
    return !empty($content) ? htmlspecialchars($content) : htmlspecialchars($fallback);
}

/**
 * Display media with fallback
 */
function display_media($category, $key, $fallback = '') {
    $media = get_media($category, $key);
    return !empty($media) ? htmlspecialchars($media) : htmlspecialchars($fallback);
}

/**
 * Display list items (for features, etc.)
 */
function display_list($section, $key, $tag = 'li') {
    $items = get_content($section, $key);
    if (is_array($items)) {
        foreach ($items as $item) {
            echo "<{$tag}>" . htmlspecialchars($item) . "</{$tag}>";
        }
    }
}

/**
 * Check if content management is enabled
 */
function is_cms_enabled() {
    return file_exists(CONTENT_DIR . '/site-content.json');
}

/**
 * Get navigation items
 */
function get_nav_items() {
    $nav = get_content('navigation');
    return $nav['menu_items'] ?? [];
}

/**
 * Get program cards
 */
function get_program_cards() {
    $programs = get_content('programs');
    return $programs['cards'] ?? [];
}

/**
 * Generate meta tags
 */
function generate_meta_tags() {
    $title = get_site_info('title');
    $description = get_site_info('description');
    $keywords = get_site_info('keywords');
    
    if ($title) {
        echo "<title>" . htmlspecialchars($title) . "</title>\n";
    }
    if ($description) {
        echo '<meta name="description" content="' . htmlspecialchars($description) . '">' . "\n";
    }
    if ($keywords) {
        echo '<meta name="keywords" content="' . htmlspecialchars($keywords) . '">' . "\n";
    }
}

/**
 * Generate structured data for SEO
 */
function generate_structured_data() {
    $site_info = get_site_info();
    $contact = get_content('contact_section');
    
    $schema = [
        "@context" => "https://schema.org",
        "@type" => "Organization",
        "name" => "Kaizen Karate",
        "url" => "https://kaizenkaratemd.com",
        "description" => $site_info['description'] ?? '',
        "contactPoint" => [
            "@type" => "ContactPoint",
            "telephone" => $site_info['phone'] ?? '',
            "email" => $site_info['email'] ?? '',
            "contactType" => "customer service"
        ]
    ];
    
    echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES) . '</script>';
}
?>