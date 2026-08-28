<?php
// Start session with proper settings. The preview wrapper (testing.php) starts
// the session before including this file, so only start one when this is the
// entry point.
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_lifetime' => 86400, // 24 hours
        'cookie_secure' => isset($_SERVER['HTTPS']),
        'cookie_httponly' => true,
        'cookie_samesite' => 'Lax'
    ]);
}

// Regenerate token only if doesn't exist
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Load CMS content
require_once __DIR__ . '/includes/content-loader.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-8JGNGZY633"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-8JGNGZY633');
  </script>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php 
  // Generate meta tags from CMS content
  if (is_cms_enabled()) {
      generate_meta_tags();
  } else {
      // Fallback to original content
      echo '<title>Kaizen Karate | Traditional Martial Arts Training</title>';
      echo '<meta name="description" content="Experience authentic karate training at Kaizen Karate. Traditional martial arts instruction for all ages and skill levels. Build discipline, confidence, and character.">';
  }
  ?>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Dancing+Script:wght@400;600&display=swap" rel="stylesheet">
  <!-- Font Awesome CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="styles/style.css?v=20241117-fix">
  <link rel="stylesheet" href="styles/test-schedule.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="chatbot-php/widget.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="modules/nyc/nyc-style.css?v=FIX_FINAL_LAYOUT_V3">
  <!-- <link rel="stylesheet" href="styles/chatbot.css?v=<?php echo time(); ?>"> -->

  <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png?v=2">
  <link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-96x96.png?v=2">
  <link rel="icon" type="image/svg+xml" href="favicon/favicon.svg?v=2">
  <link rel="icon" type="image/x-icon" href="favicon/favicon.ico?v=2">
  <link rel="manifest" href="favicon/site.webmanifest?v=2">

  <!--
    /**
    * @license
    * MyFonts Webfont Build ID 892684
    *
    * The fonts listed in this notice are subject to the End User License
    * Agreement(s) entered into by the website owner. All other parties are
    * explicitly restricted from using the Licensed Webfonts(s).
    *
    * You may obtain a valid license from one of MyFonts official sites.
    * http://www.fonts.com
    * http://www.myfonts.com
    * http://www.linotype.com
    *
    */
    -->
    <link rel="stylesheet" type="text/css" href="assets/fonts/MyWebfontsKit/MyWebfontsKit.css">
  
  <!-- Mobile Logo Optimization -->
  <link rel="stylesheet" href="styles/home.css?v=<?php echo time(); ?>">
</head>
<body>

<!-- Floating Pills Reverse Navigation -->
<?php include __DIR__ . '/includes/nav.php'; ?>

  <!-- Fixed Sidebar Widget -->
  <div class="fixed-sidebar-widget">
    <div class="sidebar-button">
      <a href="<?php echo display_text('navigation', 'social_media.facebook', 'https://www.facebook.com/people/Kaizen-Karate/100063714665511/'); ?>" target="_blank" class="sidebar-btn" title="Follow us on Facebook">
        <i class="fab fa-facebook-f"></i>
      </a>
    </div>
    <div class="sidebar-button">
      <a href="<?php echo display_text('navigation', 'social_media.tiktok', 'https://www.tiktok.com/@kaizenkaratemd'); ?>" target="_blank" class="sidebar-btn" title="Follow us on TikTok">
        <i class="fab fa-tiktok"></i>
      </a>
    </div>
    <div class="sidebar-button">
      <a href="<?php echo display_text('navigation', 'social_media.instagram', 'https://www.instagram.com/kaizen_karate/'); ?>" target="_blank" class="sidebar-btn" title="Follow us on Instagram">
        <i class="fab fa-instagram"></i>
      </a>
    </div>
    <div class="sidebar-button">
      <a href="<?php echo display_text('navigation', 'social_media.podcast', 'https://coachv6z.podbean.com/'); ?>" target="_blank" class="sidebar-btn" title="Listen to our Podcast">
        <i class="fas fa-podcast"></i>
      </a>
    </div>
  </div>

<?php include __DIR__ . '/sections/home/hero.php'; ?>

   <!-- Mobile Hero Section JavaScript -->
  <script src="scripts/home/hero-register.js"></script>


  
  <!-- Training Options Section -->
<?php include __DIR__ . '/sections/home/training-options.php'; ?>



<!-- Served States Section -->
<section class="served-states-section" aria-label="Kaizen Karate Proudly Serves">
  <div class="container">
    <div class="served-states-inner served-states-row">
      <h2 class="served-states-title"><?php echo display_text('service_areas', 'title', 'Kaizen Karate Proudly Serves:'); ?></h2>
      <div class="served-states-grid served-states-inline">
        <?php
        $service_areas = get_content('service_areas');
        $states = $service_areas['states'] ?? [];
        
        // Fallback to default states if no admin data
        if (empty($states)) {
          $states = [
            ['name' => 'Washington<br>DC', 'image' => 'assets/images/states/dc.png', 'alt' => 'Washington, DC'],
            ['name' => 'Maryland', 'image' => 'assets/images/states/maryland.png', 'alt' => 'Maryland'],
            ['name' => 'Virginia', 'image' => 'assets/images/states/virginia.png', 'alt' => 'Virginia'],
            ['name' => 'New York', 'image' => 'assets/images/states/newyork.png', 'alt' => 'New York']
          ];
        }
        
        if (!empty($states)): ?>
        <!-- Icons Row -->
        <div class="state-icons-row">
          <?php foreach ($states as $state): ?>
            <img class="state-icon-img" 
                 src="<?php echo htmlspecialchars($state['image'] ?? ''); ?>?v=<?php echo time(); ?>" 
                 alt="<?php echo htmlspecialchars($state['alt'] ?? $state['name'] ?? ''); ?>" 
                 width="48" height="48">
          <?php endforeach; ?>
        </div>
        <!-- Labels Row -->
        <div class="state-labels-row">
          <?php foreach ($states as $state): ?>
            <span class="state-label"><?php echo $state['name'] ?? ''; ?></span>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>


  <!-- NYC "Wow" Section Module -->
  <?php include __DIR__ . '/modules/nyc/nyc-section.php'; ?>

<!-- About Section -->
<?php include __DIR__ . '/sections/home/about.php'; ?>

<!-- Summer Camp Section -->
<?php 
$summer_camp = get_content('summer_camp');
$features = $summer_camp['features'] ?? [];
$camp_locations = $summer_camp['camp_locations'] ?? [];
$video = $summer_camp['video'] ?? [];
$special_offer = $summer_camp['special_offer'] ?? [];
$registration_info = $summer_camp['registration_info'] ?? [];
$accordion_sections = $summer_camp['accordion_sections'] ?? [];
?>
<?php include __DIR__ . '/sections/home/summer-camp.php'; ?>


<!-- Kaizen Dojo Section -->
<?php include __DIR__ . '/sections/home/kaizen-dojo.php'; ?>

<!-- After School | Weekend & Evening Section -->
<?php include __DIR__ . '/sections/home/weekend-evening.php'; ?>

<?php include __DIR__ . '/sections/home/belt-lightboxes.php'; ?>


<!-- Online Store Section -->
<?php include __DIR__ . '/sections/home/online-store.php'; ?>


<!-- Belt Exam Section -->
<?php include __DIR__ . '/sections/home/belt-exam.php'; ?>

<script>
function toggleAccordion(section) {
  const content = document.getElementById(section + '-content');
  const icon = document.getElementById(section + '-icon');
  
  if (content.style.display === 'none' || content.style.display === '') {
    content.style.display = 'block';
    icon.style.transform = 'rotate(180deg)';
  } else {
    content.style.display = 'none';
    icon.style.transform = 'rotate(0deg)';
  }
}
</script>

<?php
$kaizen_kenpo = get_content('kaizen_kenpo');
$kenpo_settings = $kaizen_kenpo['settings'] ?? [];
$kenpo_tabs_meta = $kenpo_settings['tabs'] ?? [];
$kenpo_tabs = $kaizen_kenpo['tabs'] ?? [];
$kenpo_logo = $kenpo_settings['logo'] ?? [];
$first_tab_meta = $kenpo_tabs_meta[0] ?? [];
$first_tab_id = $first_tab_meta['id'] ?? 'about';
$first_tab_label = $first_tab_meta['label'] ?? 'Kaizen Kenpo Home';
?>
<!-- Kaizen Kenpo Section -->
<?php include __DIR__ . '/sections/home/kaizen-kenpo.php'; ?>

<?php include __DIR__ . '/sections/home/gallery-lightbox.php'; ?>



<?php
/* ── Gallery Preview Section ── */
$_gs        = get_content('gallery_section') ?? [];
$_gs_album  = $_gs['featured_album'] ?? 'dojo-training';
$_gs_count  = max(1, (int)($_gs['preview_count'] ?? 6));
$_gs_gals   = load_content('galleries.json');
$_gs_images = [];
foreach ($_gs_gals['galleries'] ?? [] as $_g) {
    if ($_g['id'] === $_gs_album) { $_gs_images = array_slice($_g['images'], 0, $_gs_count); break; }
}
?>
<?php include __DIR__ . '/sections/home/photo-gallery-preview.php'; ?>

<!-- Contact Section -->
<?php include __DIR__ . '/sections/home/contact.php'; ?>

<?php
require_once __DIR__ . '/includes/footer-dynamic.php';
render_footer('live');
?>

<?php include __DIR__ . '/sections/home/summer-camp-lightbox.php'; ?>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="scripts/smooth-scroll.js"></script>
  <script src="scripts/video-controls.js"></script>
  
  <!-- Video Controls JavaScript -->
  
  <!-- Floating Pills Navigation JavaScript -->
  <script src="scripts/home/nav-menu.js"></script>

  <script src="scripts/lightbox.js"></script>

  <script src="scripts/wait-list.js"></script>
  <script src="scripts/accordion.js"></script>
  <script src="scripts/test-schedule.js"></script>
<script src="scripts/kenpo-shuffle.js"></script>
  <!-- <script src="scripts/chatbot.js"></script> -->

  
  <script src="scripts/home/phone-format.js"></script>

  <!-- Summer Camp Video Lightbox JavaScript -->
  <script src="scripts/home/summer-camp-video.js"></script>

  <!-- Calendar Preview JavaScript -->
  <script src="scripts/home/calendar-lightbox.js"></script>

  <!-- Training Card Read More Functionality -->
  <script>
    function toggleDescription(link) {
      const description = link.nextElementSibling;
      
      if (description) {
        const isExpanded = description.classList.contains('show');
      
      if (isExpanded) {
          description.classList.remove('show');
        link.textContent = 'Read More';
      } else {
          description.classList.add('show');
        link.textContent = 'Read Less';
        }
      }
    }
  </script>

  <!-- Include Chatbot Widget -->
  <script src="https://cdn.jsdelivr.net/npm/gsap@3/dist/gsap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/gsap@3/dist/ScrollTrigger.min.js"></script>
  <!-- Scroll to Top Button (temporarily disabled)
  <button class="scroll-to-top" id="scrollToTopBtn" aria-label="Scroll to top">
    <i class="fas fa-chevron-up"></i>
  </button>
  -->

  <script>console.log('Test script loaded');</script>
  <script src="scripts/scripts.js?v=<?php echo time(); ?>"></script>
  <script>
      window.kaizenChatConfig = {
          position: 'bottom-right',
          primaryColor: '#c41e3a',
          primaryDark: '#a01729',
          greeting: "Hi! I'm the Kaizen Karate Assistant. Ask me anything about our programs, classes, pricing, or instructors! 🥋",
          businessHours: "Mon-Fri 9am-6pm, Sat 9am-3pm",
          apiEndpoint: './chatbot-php/chat-api.php'
      };
  </script>
  <script src="chatbot-php/widget.js"></script>
  <script src="modules/nyc/nyc-script.js?v=<?php echo time(); ?>"></script>

  <!-- Homepage Popup -->
  <?php include __DIR__ . '/includes/homepage-popup.php'; ?>

</body>
</html>
