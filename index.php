<?php
// Start session with proper settings
session_start([
    'cookie_lifetime' => 86400, // 24 hours
    'cookie_secure' => isset($_SERVER['HTTPS']),
    'cookie_httponly' => true,
    'cookie_samesite' => 'Lax'
]);

// Regenerate token only if doesn't exist
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Load CMS content
require_once 'includes/content-loader.php';
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
<?php include 'includes/nav.php'; ?>

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

  <!-- Hero Section -->
  <header class="hero-section">
    <div class="container-fluid h-100">
      <div class="row h-100">
        <!-- Full-Screen Video Background -->
        <div class="video-container">
          <video autoplay muted loop playsinline id="hero-video"<?php 
            $hero_video_poster = get_media('hero_video', 'poster');
            if (!empty($hero_video_poster)): ?> poster="<?php echo htmlspecialchars($hero_video_poster); ?>"<?php endif; ?>>
            <source src="<?php echo display_media('hero_video', 'source', 'assets/videos/hero/kaizen-hero-video.mp4'); ?>" type="video/mp4">
            Your browser does not support the video tag.
          </video>
        </div>
        <!-- Hero Overlay - Full Width Transparent Overlay -->
        <div class="hero-overlay-section">
          <div class="nav-container">
            <div class="hero-content" id="heroContent">
              <div class="hero-title-row">
                <div class="hero-title-col">
                  <h1 class="hero-title"><?php echo display_text('hero_section', 'title', 'KAIZEN<span class="desktop-space"> </span><br class="mobile-break">KARATE'); ?></h1>
                </div>
                <div class="hero-quote-col" style="margin-top:12px;">
                  <p class="hero-quote">"<?php echo display_text('hero_section', 'quote', 'Discipline is not about being told what to do. It is about learning how to choose what matters.'); ?>"</p>
                </div>
              </div>
              <div class="hero-row">
                <div class="hero-col-left">
                  <p class="hero-description">
                    <?php echo display_text('hero_section', 'subtitle', 'Kaizen Karate has offered martial arts instruction since 2003. Founded by Coach V, we specialize in karate instruction for children of all ages in the <span class="hero-locations">Washington DC, Maryland, Northern Virginia, and New York</span> areas. We also offer karate programs for adults with a focus on fitness and self-defense.'); ?> <a href="#about" class="hero-read-more-inline">Read more</a>
                  </p>
                </div>
                <div class="hero-col-right">
                  <button type="button" id="heroRegisterBtn" class="btn training-btn-black hero-registration-btn"><?php echo display_text('hero_section', 'button_text', 'Register Now'); ?></button>
                </div>
              </div>
              <!-- HERO_REGISTER_PANEL_START -->
              <div class="hero-overlay-row">
                <div class="hero-overlay-media">
                  <img src="assets/images/about/hero-over-1.png?v=<?php echo time(); ?>" alt="Kaizen Karate" class="hero-overlay-image" />
                </div>
                <div id="heroRegisterPanel" class="hero-register-panel">
                
                <div class="hero-slide-col">
                  <div class="hero-slide-header"><?php echo display_text('hero_section', 'registration_panel.after_school.header_line1', 'AFTER SCHOOL'); ?><br><?php echo display_text('hero_section', 'registration_panel.after_school.header_line2', 'WEEKEND & EVENING'); ?></div>
                  <a class="hero-slide-btn" href="<?php echo display_text('hero_section', 'registration_panel.after_school.url', 'https://www.gomotionapp.com/team/mdkfu/page/class-registration'); ?>" target="_blank"><?php echo display_text('hero_section', 'registration_panel.after_school.button', 'Register Now!'); ?></a>
                </div>
                
                <div class="hero-slide-vertical-divider"></div>
                
                <div class="hero-slide-col">
                  <div class="hero-slide-header"><?php echo display_text('hero_section', 'registration_panel.kaizen_dojo.header', 'KAIZEN DOJO'); ?></div>
                  <a class="hero-slide-btn" href="<?php echo display_text('hero_section', 'registration_panel.kaizen_dojo.url', 'https://form.jotform.com/251533593606459'); ?>" target="_blank"><?php echo display_text('hero_section', 'registration_panel.kaizen_dojo.button', 'Register Now!'); ?></a>
                  </div>
                
                <div class="hero-slide-vertical-divider"></div>
                
                <div class="hero-slide-col">
                  <div class="hero-slide-header"><?php echo display_text('hero_section', 'registration_panel.summer_camp.header', 'Summer Camp'); ?></div>
                  <?php 
                  $hero_content = get_content('hero_section');
                  $summer_camp_mode = $hero_content['registration_panel']['summer_camp']['display_mode'] ?? 'information';
                  if ($summer_camp_mode === 'button'): ?>
                    <a class="hero-slide-btn" href="<?php echo display_text('hero_section', 'registration_panel.summer_camp.url', '#summer-camp'); ?>" target="_blank"><?php echo display_text('hero_section', 'registration_panel.summer_camp.button', 'Register Now!'); ?></a>
                  <?php else: ?>
                    <div class="hero-slide-text"><?php echo display_text('hero_section', 'registration_panel.summer_camp.text', 'Registration for Summer Camp 2026 has not opened yet.'); ?><br>
                    <a href="<?php echo display_text('hero_section', 'registration_panel.summer_camp.link_url', '#summer-camp'); ?>" class="summer-camp-explore-link"><?php echo display_text('hero_section', 'registration_panel.summer_camp.link_text', 'Explore our 2025 Summer Camp program'); ?></a></div>
                  <?php endif; ?>
                </div>
                
                <div class="hero-slide-vertical-divider"></div>
                
                <div class="hero-slide-col">
                  <div class="hero-slide-header"><?php echo display_text('hero_section', 'registration_panel.belt_exams.header', 'Belt Exams'); ?></div>
                  <?php 
                  $belt_exam_mode = $hero_content['registration_panel']['belt_exams']['display_mode'] ?? 'simple';
                  if ($belt_exam_mode === 'multiple'): 
                    $exam_buttons = $hero_content['registration_panel']['belt_exams']['exam_buttons'] ?? [];
                    if (is_array($exam_buttons) && !empty($exam_buttons)):
                      foreach ($exam_buttons as $button): ?>
                        <a class="hero-slide-btn" href="<?php echo htmlspecialchars($button['url'] ?? '#'); ?>" <?php echo !empty($button['url']) ? 'target="_blank"' : 'onclick="return scrollToBeltExamRegister(event);"'; ?>><?php echo htmlspecialchars($button['line1'] ?? 'Register Now!'); ?></a>
                      <?php endforeach;
                    else: ?>
                      <a class="hero-slide-btn" href="<?php echo display_text('hero_section', 'registration_panel.belt_exams.url', '#'); ?>" onclick="return scrollToBeltExamRegister(event);"><?php echo display_text('hero_section', 'registration_panel.belt_exams.button', 'Register Now!'); ?></a>
                    <?php endif;
                  else: ?>
                    <a class="hero-slide-btn" href="<?php echo display_text('hero_section', 'registration_panel.belt_exams.url', '#'); ?>" onclick="return scrollToBeltExamRegister(event);"><?php echo display_text('hero_section', 'registration_panel.belt_exams.button', 'Register Now!'); ?></a>
                  <?php endif; ?>
                </div>
                
                </div>
                </div> <!-- /.hero-register-panel -->
              </div> <!-- /.hero-overlay-row -->
              <!-- HERO_REGISTER_PANEL_END -->
            </div>
          </div>
        </div>
      </div>
    </header>

  <!-- Video Controls -->
  <div class="video-controls">
    <button class="video-control-btn" id="pausePlayBtn" title="Pause/Play Video" 
            onclick="togglePlayPause();">
      <i class="fas fa-pause" id="pausePlayIcon"></i>
    </button>
    <button class="video-control-btn" id="muteUnmuteBtn" title="Mute/Unmute Video"
            onclick="toggleMute();">
      <i class="fas fa-volume-mute" id="muteUnmuteIcon"></i>
    </button>
    </div>

  <!-- Mobile Hero Content Section - Only visible on 480px and below -->
  <section class="mobile-hero-content-section">
    <div class="container">
             <div class="mobile-hero-content">
         <div class="mobile-hero-title-row">
           <p class="mobile-hero-quote">"<?php echo display_text('hero_section', 'quote', 'Discipline is not about being told what to do. It is about learning how to choose what matters.'); ?>"</p>
         </div>
                 <div class="mobile-hero-row">
           <div class="mobile-hero-description-container">
             <p class="mobile-hero-description">
               <?php echo display_text('hero_section', 'subtitle', 'Kaizen Karate has offered martial arts instruction since 2003. Founded by Coach V, we specialize in karate instruction for children of all ages in the <span class="hero-locations">Washington DC, Maryland, Northern Virginia, and New York</span> areas. We also offer karate programs for adults with a focus on fitness and self-defense.'); ?> <a href="#about" class="hero-read-more-inline">Read more</a>
             </p>
           </div>
         </div>
         
                 <!-- Mobile Register Options - Pure Bootstrap Layout -->
        <div class="container-fluid py-1">
          <div class="row">
            <div class="col-12">
              <h5 class="registration-center-title">REGISTRATION CENTER</h5>
            </div>
          </div>
          <div class="row g-2">
             <div class="col-12">
               <div class="card">
                 <div class="card-body text-center py-3">
                   <h6 class="card-title text-danger fw-bold text-uppercase mb-3" style="font-size: 0.9rem; letter-spacing: 0.5px;">
                     <span class="mobile-header-line-1"><?php echo display_text('hero_section', 'registration_panel.after_school.header_line1', 'AFTER SCHOOL'); ?></span>
                     <span class="mobile-header-line-2"><?php echo display_text('hero_section', 'registration_panel.after_school.header_line2', 'WEEKEND & EVENING'); ?></span>
                   </h6>
                   <a class="btn btn-danger btn-sm px-4" href="<?php echo display_text('hero_section', 'registration_panel.after_school.url', 'https://www.gomotionapp.com/team/mdkfu/page/class-registration'); ?>" target="_blank"><?php echo display_text('hero_section', 'registration_panel.after_school.button', 'Register Now!'); ?></a>
                 </div>
               </div>
             </div>
             
             <div class="col-12">
               <div class="card">
                 <div class="card-body text-center py-3">
                   <h6 class="card-title text-danger fw-bold text-uppercase mb-3" style="font-size: 0.9rem; letter-spacing: 0.5px;">
                     <?php echo display_text('hero_section', 'registration_panel.kaizen_dojo.header', 'KAIZEN DOJO'); ?>
                   </h6>
                   <a class="btn btn-danger btn-sm px-4" href="<?php echo display_text('hero_section', 'registration_panel.kaizen_dojo.url', 'https://form.jotform.com/251533593606459'); ?>" target="_blank"><?php echo display_text('hero_section', 'registration_panel.kaizen_dojo.button', 'Register Now!'); ?></a>
                 </div>
               </div>
             </div>
             
             <div class="col-12">
               <div class="card">
                 <div class="card-body text-center py-3">
                   <h6 class="card-title text-danger fw-bold text-uppercase mb-3" style="font-size: 0.9rem; letter-spacing: 0.5px;">
                     <?php echo display_text('hero_section', 'registration_panel.summer_camp.header', 'Summer Camp'); ?>
                   </h6>
                   <?php 
                   $summer_camp_mode = $hero_content['registration_panel']['summer_camp']['display_mode'] ?? 'information';
                   if ($summer_camp_mode === 'button'): ?>
                     <a class="btn btn-danger btn-sm px-4" href="<?php echo display_text('hero_section', 'registration_panel.summer_camp.url', '#summer-camp'); ?>" target="_blank"><?php echo display_text('hero_section', 'registration_panel.summer_camp.button', 'Register Now!'); ?></a>
                   <?php else: ?>
                     <div class="text-muted" style="font-size: 0.8rem; font-style: italic;">
                       <?php echo display_text('hero_section', 'registration_panel.summer_camp.text', 'Registration for Summer Camp 2026 has not opened yet.'); ?><br>
                       <a href="<?php echo display_text('hero_section', 'registration_panel.summer_camp.link_url', '#summer-camp'); ?>" class="text-decoration-none"><?php echo display_text('hero_section', 'registration_panel.summer_camp.link_text', 'Explore our 2025 Summer Camp program'); ?></a>
                     </div>
                   <?php endif; ?>
                 </div>
               </div>
             </div>
             
             <div class="col-12">
               <div class="card">
                 <div class="card-body text-center py-3">
                   <h6 class="card-title text-danger fw-bold text-uppercase mb-3" style="font-size: 0.9rem; letter-spacing: 0.5px;">
                     <?php echo display_text('hero_section', 'registration_panel.belt_exams.header', 'Belt Exams'); ?>
                   </h6>
                   <?php 
                   $belt_exam_mode = $hero_content['registration_panel']['belt_exams']['display_mode'] ?? 'simple';
                   if ($belt_exam_mode === 'multiple'): 
                     $exam_buttons = $hero_content['registration_panel']['belt_exams']['exam_buttons'] ?? [];
                     if (is_array($exam_buttons) && !empty($exam_buttons)):
                       foreach ($exam_buttons as $button): ?>
                         <a class="btn btn-danger btn-sm px-2 mb-2" href="<?php echo htmlspecialchars($button['url'] ?? '#'); ?>" <?php echo !empty($button['url']) ? 'target="_blank"' : 'onclick="return scrollToBeltExamRegister(event);"'; ?> style="font-size: 0.75rem; line-height: 1.3; padding: 10px 12px; display: block;">
                           <div style="font-weight: 700; margin-bottom: 3px;"><?php echo htmlspecialchars($button['line1'] ?? 'REGISTER NOW'); ?></div>
                           <div style="font-size: 0.7rem; font-weight: 600; margin-bottom: 2px;"><?php echo htmlspecialchars($button['line2'] ?? 'Exam'); ?></div>
                           <div style="font-size: 0.65rem; font-weight: 500;"><?php echo htmlspecialchars($button['line3'] ?? 'Date TBD'); ?></div>
                         </a>
                       <?php endforeach;
                     else: ?>
                       <a class="btn btn-danger btn-sm px-2" href="<?php echo display_text('hero_section', 'registration_panel.belt_exams.url', '#'); ?>" onclick="return scrollToBeltExamRegister(event);" style="font-size: 0.75rem; line-height: 1.3; padding: 10px 12px;">
                         <?php echo display_text('hero_section', 'registration_panel.belt_exams.button', 'Register Now!'); ?>
                       </a>
                     <?php endif;
                   else: ?>
                     <a class="btn btn-danger btn-sm px-2" href="<?php echo display_text('hero_section', 'registration_panel.belt_exams.url', '#'); ?>" onclick="return scrollToBeltExamRegister(event);" style="font-size: 0.75rem; line-height: 1.3; padding: 10px 12px;">
                       <?php echo display_text('hero_section', 'registration_panel.belt_exams.button', 'Register Now!'); ?>
                     </a>
                   <?php endif; ?>
                 </div>
               </div>
             </div>
           </div>
         </div>
       </div>
     </div>
   </section>

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
  <?php include 'modules/nyc/nyc-section.php'; ?>

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

<!-- Calendar Preview Lightboxes -->
<div id="calendarLightbox" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0, 0, 0, 0.95); display: none; align-items: center; justify-content: center; z-index: 9999; opacity: 0; transition: opacity 0.3s ease;" onclick="closeCalendarPreview()">
  <div style="position: relative; max-width: 90vw; max-height: 90vh;">
    <img src="<?php echo display_text('after_school', 'schedule.preview_image', 'assets/images/aftersschool/sep-oct-karate.png'); ?>" 
         alt="<?php echo display_text('after_school', 'schedule.title', 'September - October Schedule'); ?> - Full Size" 
         style="width: 100%; height: auto; border-radius: 10px; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.8);">
    
    <button onclick="closeCalendarPreview()" 
            style="position: absolute; top: -15px; right: -15px; width: 40px; height: 40px; border-radius: 50%; background: #dc3545; border: none; color: white; font-size: 1.2rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease;"
            onmouseover="this.style.transform='scale(1.1)'; this.style.background='#c82333';"
            onmouseout="this.style.transform='scale(1)'; this.style.background='#dc3545';">
      ×
    </button>
  </div>
</div>

<!-- Belt Exam Requirements Lightboxes -->
<div id="matrixLightbox" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0, 0, 0, 0.95); display: none; align-items: center; justify-content: center; z-index: 9999; opacity: 0; transition: opacity 0.3s ease;" onclick="closeMatrixLightbox()">
  <div style="position: relative; max-width: 90vw; max-height: 90vh;">
    <img src="assets/images/belt-exam/requirements-test/kaizen-testing-matrix.png" 
         alt="Kaizen Karate Testing Matrix - Full Size" 
         style="width: 100%; height: auto; border-radius: 10px; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.8);">
    
    <button onclick="closeMatrixLightbox()" 
            style="position: absolute; top: -15px; right: -15px; width: 40px; height: 40px; border-radius: 50%; background: #dc3545; border: none; color: white; font-size: 1.2rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease;"
            onmouseover="this.style.transform='scale(1.1)'; this.style.background='#c82333';"
            onmouseout="this.style.transform='scale(1)'; this.style.background='#dc3545';">
      ×
    </button>
    
    <a href="assets/images/belt-exam/requirements-test/kaizen-testing-matrix.png" download="kaizen-testing-matrix.png"
       style="position: absolute; bottom: -15px; right: -15px; background: #28a745; border: none; color: white; padding: 0.5rem 1rem; border-radius: 6px; font-size: 0.9rem; cursor: pointer; transition: all 0.3s ease; text-decoration: none; display: flex; align-items: center; gap: 0.5rem;"
       onmouseover="this.style.background='#218838';"
       onmouseout="this.style.background='#28a745';">
      <i class="fas fa-download"></i>Download
    </a>
    </div>
</div>

<div id="requirementsLightbox" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0, 0, 0, 0.95); display: none; align-items: center; justify-content: center; z-index: 9999; opacity: 0; transition: opacity 0.3s ease;" onclick="closeRequirementsLightbox()">
  <div style="position: relative; max-width: 90vw; max-height: 90vh;">
    <img src="assets/images/belt-exam/requirements-test/kaizen-testing-requirement.png" 
         alt="Kaizen Karate Testing Requirements - Full Size" 
         style="width: 100%; height: auto; border-radius: 10px; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.8);">
    
    <button onclick="closeRequirementsLightbox()" 
            style="position: absolute; top: -15px; right: -15px; width: 40px; height: 40px; border-radius: 50%; background: #dc3545; border: none; color: white; font-size: 1.2rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease;"
            onmouseover="this.style.transform='scale(1.1)'; this.style.background='#c82333';"
            onmouseout="this.style.transform='scale(1)'; this.style.background='#dc3545';">
      ×
    </button>
    
    <a href="assets/images/belt-exam/requirements-test/kaizen-testing-requirement.png" download="kaizen-testing-requirement.png"
       style="position: absolute; bottom: -15px; right: -15px; background: #28a745; border: none; color: white; padding: 0.5rem 1rem; border-radius: 6px; font-size: 0.9rem; cursor: pointer; transition: all 0.3s ease; text-decoration: none; display: flex; align-items: center; gap: 0.5rem;"
       onmouseover="this.style.background='#218838';"
       onmouseout="this.style.background='#28a745';">
      <i class="fas fa-download"></i>Download
    </a>
  </div>
</div>

<div id="stripeLightbox" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0, 0, 0, 0.95); display: none; align-items: center; justify-content: center; z-index: 9999; opacity: 0; transition: opacity 0.3s ease;" onclick="closeStripeLightbox()">
  <div style="position: relative; max-width: 90vw; max-height: 90vh;">
    <img src="assets/images/belt-exam/requirements-test/kaizen-testing-stripe-system.png" 
         alt="Kaizen Karate Stripe System - Full Size" 
         style="width: 100%; height: auto; border-radius: 10px; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.8);">
    
    <button onclick="closeStripeLightbox()" 
            style="position: absolute; top: -15px; right: -15px; width: 40px; height: 40px; border-radius: 50%; background: #dc3545; border: none; color: white; font-size: 1.2rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease;"
            onmouseover="this.style.transform='scale(1.1)'; this.style.background='#c82333';"
            onmouseout="this.style.transform='scale(1)'; this.style.background='#dc3545';">
      ×
    </button>
    
    <a href="assets/images/belt-exam/requirements-test/kaizen-testing-stripe-system.png" download="kaizen-testing-stripe-system.png"
       style="position: absolute; bottom: -15px; right: -15px; background: #28a745; border: none; color: white; padding: 0.5rem 1rem; border-radius: 6px; font-size: 0.9rem; cursor: pointer; transition: all 0.3s ease; text-decoration: none; display: flex; align-items: center; gap: 0.5rem;"
       onmouseover="this.style.background='#218838';"
       onmouseout="this.style.background='#28a745';">
      <i class="fas fa-download"></i>Download
    </a>
          </div>
  </div>

<!-- Testing Scripts Lightboxes -->
<?php
// Load scripts accordion data for lightboxes
$scriptsAccordion = null;
$belt_exam_data = get_content('belt_exams') ?: [];
$accordions = $belt_exam_data['accordions'] ?? [];
foreach ($accordions as $acc) {
    if ($acc['id'] === 'scripts') {
        $scriptsAccordion = $acc;
        break;
    }
}
?>
<div id="testingTipsLightbox" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0, 0, 0, 0.95); display: none; align-items: center; justify-content: center; z-index: 9999; opacity: 0; transition: opacity 0.3s ease;" onclick="closeTestingTipsLightbox()">
  <div style="position: relative; max-width: 90vw; max-height: 90vh;">
    <button onclick="closeTestingTipsLightbox()" 
            style="position: absolute; top: -15px; right: -15px; width: 40px; height: 40px; border-radius: 50%; background: #dc3545; border: none; color: white; font-size: 1.2rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease; z-index: 10;"
            onmouseover="this.style.transform='scale(1.1)'; this.style.background='#c82333';"
            onmouseout="this.style.transform='scale(1)'; this.style.background='#dc3545';">
      ×
    </button>
    <div style="background: rgba(255, 255, 255, 0.95); border-radius: 12px; padding: 2rem; color: #333; overflow-y: auto; max-height: 90vh;">
    <?php echo $scriptsAccordion['lightbox_content']['testing_tips'] ?? '<p>Content not configured</p>'; ?>
    </div>
  </div>
</div>

 <div id="videoInstructionsLightbox" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0, 0, 0, 0.95); display: none; align-items: center; justify-content: center; z-index: 9999; opacity: 0; transition: opacity 0.3s ease;" onclick="closeVideoInstructionsLightbox()">
   <div style="position: relative; max-width: 90vw; max-height: 90vh;">
     <button onclick="closeVideoInstructionsLightbox()" 
             style="position: absolute; top: -15px; right: -15px; width: 40px; height: 40px; border-radius: 50%; background: #dc3545; border: none; color: white; font-size: 1.2rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease; z-index: 10;"
             onmouseover="this.style.transform='scale(1.1)'; this.style.background='#c82333';"
             onmouseout="this.style.transform='scale(1)'; this.style.background='#dc3545';">
       ×
     </button>
    <div style="background: rgba(255, 255, 255, 0.95); border-radius: 12px; padding: 2rem; color: #333; overflow-y: auto; max-height: 90vh;">
    <?php echo $scriptsAccordion['lightbox_content']['video_instructions'] ?? '<p>Content not configured</p>'; ?>
    </div>
  </div>
   </div>
 </div>
 </div>

 <div id="greenBeltLightbox" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0, 0, 0, 0.95); display: none; align-items: center; justify-content: center; z-index: 9999; opacity: 0; transition: opacity 0.3s ease;" onclick="closeGreenBeltLightbox()">
   <div style="position: relative; max-width: 90vw; max-height: 90vh;">
     <button onclick="closeGreenBeltLightbox()" 
             style="position: absolute; top: -15px; right: -15px; width: 40px; height: 40px; border-radius: 50%; background: #dc3545; border: none; color: white; font-size: 1.2rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease; z-index: 10;"
             onmouseover="this.style.transform='scale(1.1)'; this.style.background='#c82333';"
             onmouseout="this.style.transform='scale(1)'; this.style.background='#dc3545';">
       ×
     </button>
    <div style="background: rgba(255, 255, 255, 0.95); border-radius: 12px; padding: 2rem; color: #333; overflow-y: auto; max-height: 90vh;">
    <?php echo $scriptsAccordion['lightbox_content']['green_belt'] ?? '<p>Content not configured</p>'; ?>
    </div>
  </div>
     </div>
          </div>
        </div>
      </div>

<div id="purpleBeltLightbox" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0, 0, 0, 0.95); display: none; align-items: center; justify-content: center; z-index: 9999; opacity: 0; transition: opacity 0.3s ease;" onclick="closePurpleBeltLightbox()">
   <div style="position: relative; max-width: 90vw; max-height: 90vh;">
     <button onclick="closePurpleBeltLightbox()" 
            style="position: absolute; top: -15px; right: -15px; width: 40px; height: 40px; border-radius: 50%; background: #dc3545; border: none; color: white; font-size: 1.2rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease; z-index: 10;"
            onmouseover="this.style.transform='scale(1.1)'; this.style.background='#c82333';"
            onmouseout="this.style.transform='scale(1)'; this.style.background='#dc3545';">
       ×
     </button>
    <div style="background: rgba(255, 255, 255, 0.95); border-radius: 12px; padding: 2rem; color: #333; overflow-y: auto; max-height: 90vh;">
    <?php echo $scriptsAccordion['lightbox_content']['purple_belt'] ?? '<p>Content not configured</p>'; ?>
    </div>
  </div>
  </div>
</div>
 </div>

<div id="blueBeltLightbox" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0, 0, 0, 0.95); display: none; align-items: center; justify-content: center; z-index: 9999; opacity: 0; transition: opacity 0.3s ease;" onclick="closeBlueBeltLightbox()">
   <div style="position: relative; max-width: 90vw; max-height: 90vh;">
     <button onclick="closeBlueBeltLightbox()" 
            style="position: absolute; top: -15px; right: -15px; width: 40px; height: 40px; border-radius: 50%; background: #dc3545; border: none; color: white; font-size: 1.2rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease; z-index: 10;"
            onmouseover="this.style.transform='scale(1.1)'; this.style.background='#c82333';"
            onmouseout="this.style.transform='scale(1)'; this.style.background='#dc3545';">
       ×
     </button>
    <div style="background: rgba(255, 255, 255, 0.95); border-radius: 12px; padding: 2rem; color: #333; overflow-y: auto; max-height: 90vh;">
    <?php echo $scriptsAccordion['lightbox_content']['blue_belt'] ?? '<p>Content not configured</p>'; ?>
    </div>
  </div>
  </div>
</div>
 </div>

<div id="brownBeltLightbox" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0, 0, 0, 0.95); display: none; align-items: center; justify-content: center; z-index: 9999; opacity: 0; transition: opacity 0.3s ease;" onclick="closeBrownBeltLightbox()">
   <div style="position: relative; max-width: 90vw; max-height: 90vh;">
     <button onclick="closeBrownBeltLightbox()" 
            style="position: absolute; top: -15px; right: -15px; width: 40px; height: 40px; border-radius: 50%; background: #dc3545; border: none; color: white; font-size: 1.2rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease; z-index: 10;"
            onmouseover="this.style.transform='scale(1.1)'; this.style.background='#c82333';"
            onmouseout="this.style.transform='scale(1)'; this.style.background='#dc3545';">
       ×
     </button>
    <div style="background: rgba(255, 255, 255, 0.95); border-radius: 12px; padding: 2rem; color: #333; overflow-y: auto; max-height: 90vh;">
    <?php echo $scriptsAccordion['lightbox_content']['brown_belt'] ?? '<p>Content not configured</p>'; ?>
    </div>
  </div>
  </div>
</div>
 </div>

<div id="brownStripeLightbox" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0, 0, 0, 0.95); display: none; align-items: center; justify-content: center; z-index: 9999; transition: opacity 0.3s ease;" onclick="closeBrownStripeLightbox()">
  <div style="position: relative; max-width: 90vw; max-height: 90vh;">
    <button onclick="closeBrownStripeLightbox()" 
            style="position: absolute; top: -15px; right: -15px; width: 40px; height: 40px; border-radius: 50%; background: #dc3545; border: none; color: white; font-size: 1.2rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease; z-index: 10;"
            onmouseover="this.style.transform='scale(1.1)'; this.style.background='#c82333';"
            onmouseout="this.style.transform='scale(1)'; this.style.background='#dc3545';">
      ×
    </button>
    <div style="background: rgba(255, 255, 255, 0.95); border-radius: 12px; padding: 2rem; color: #333; overflow-y: auto; max-height: 90vh;">
    <?php echo $scriptsAccordion['lightbox_content']['brown_stripe'] ?? '<p>Content not configured</p>'; ?>
    </div>
  </div>
      Brown Belt with Black Stripe Script
    </h3>
    
    <div style="line-height: 1.6;">
      <!-- Important Requirements -->
      <div style="background: rgba(220, 53, 69, 0.1); border: 1px solid rgba(220, 53, 69, 0.3); border-radius: 8px; padding: 1.5rem; margin-bottom: 2rem;">
        <h4 style="color: #dc3545; margin-bottom: 1rem; font-size: 1.2rem;">
          <i class="fas fa-exclamation-triangle" style="margin-right: 0.5rem;"></i>Important Requirements
        </h4>
        <p style="margin-bottom: 1rem; font-weight: 600; color: #dc3545;">
          Students testing for green, purple, blue, brown, or red belt MUST register & pay online PRIOR to submitting your video test
        </p>
        <ul style="margin: 0; padding-left: 1.5rem; list-style-type: disc;">
          <li style="margin-bottom: 0.8rem;"><strong>Sparring is required</strong> on all video tests for green belt rank and above (Effective 5/14/21)</li>
          <li style="margin-bottom: 0.8rem;"><strong>Jujitsu is required</strong> on all video tests for brown belt rank and above (Effective 5/14/21)</li>
          <li style="margin: 0;"><strong>All video tests must be submitted as a YouTube link.</strong> No other formats will be accepted (Effective 5/14/21)</li>
        </ul>
      </div>
      
      <!-- Script Instructions -->
      <div style="background: rgba(101, 57, 16, 0.1); border: 1px solid rgba(101, 57, 16, 0.3); border-radius: 8px; padding: 1.5rem; margin-bottom: 2rem;">
        <h4 style="color: #653910; margin-bottom: 1rem; font-size: 1.1rem;">
          <i class="fas fa-microphone" style="margin-right: 0.5rem;"></i>The Brown Belt with Black Stripe Script
        </h4>
        <p style="margin: 0; font-style: italic; color: #666;">
          (To be read aloud by a friend or Parent)
        </p>
      </div>
      
      <!-- Script Content -->
      <div style="background: rgba(255, 255, 255, 0.8); border-radius: 8px; padding: 2rem; border: 1px solid rgba(0, 0, 0, 0.1);">
        <ol style="margin: 0; padding-left: 1.5rem; counter-reset: script-counter;">
          <li style="margin-bottom: 1rem; font-weight: 500;">Stand at attention in Joon Bi.</li>
          <li style="margin-bottom: 1rem; font-weight: 500;">State your name, age, and belt you are testing for. Also, state the name of the class location where you train & the name of your primary karate instructor.</li>
          <li style="margin-bottom: 1rem; font-weight: 500;">Bow</li>
          
          <!-- White Belt Section -->
          <li style="margin-bottom: 1.5rem; font-weight: 600; color: #dc3545; background: rgba(220, 53, 69, 0.05); padding: 0.5rem; border-radius: 4px;">We begin with the White Belt with Stripe section</li>
          <li style="margin-bottom: 0.8rem;">Joon-bi Stance <span style="color: #666; font-style: italic;">(hold for 3 seconds)</span></li>
          <li style="margin-bottom: 0.8rem;">Horse Stance <span style="color: #666; font-style: italic;">(hold for 3 seconds)</span></li>
          <li style="margin-bottom: 0.8rem;">Fighting Stance <span style="color: #666; font-style: italic;">(hold for 3 seconds)</span></li>
          <li style="margin-bottom: 0.8rem;">Cat Stance <span style="color: #666; font-style: italic;">(hold for 3 seconds)</span></li>
          <li style="margin-bottom: 0.8rem;">Up Block <span style="background: #ffc107; color: #000; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Hana! Dul! Set!</span></li>
          <li style="margin-bottom: 0.8rem;">Jab <span style="background: #ffc107; color: #000; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Hana! Dul! Set!</span></li>
          <li style="margin-bottom: 0.8rem;">Cross <span style="background: #ffc107; color: #000; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Hana! Dul! Set!</span></li>
          <li style="margin-bottom: 0.8rem;">Front-leg Snap Kick <span style="background: #ffc107; color: #000; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Hana! Dul! Set!</span></li>
          <li style="margin-bottom: 1.5rem;">Back-leg Snap Kick <span style="background: #ffc107; color: #000; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Hana! Dul! Set!</span></li>
          
          <!-- Orange Belt Section -->
          <li style="margin-bottom: 1.5rem; font-weight: 600; color: #fd7e14; background: rgba(253, 126, 20, 0.1); padding: 0.5rem; border-radius: 4px;">This is the Orange Belt Section</li>
          <li style="margin-bottom: 0.8rem;">Front Stance <span style="color: #666; font-style: italic;">(hold for 3 seconds)</span></li>
          <li style="margin-bottom: 0.8rem;">Lunge Stance <span style="color: #666; font-style: italic;">(hold for 3 seconds)</span></li>
          <li style="margin-bottom: 0.8rem;">Down Block <span style="background: #ffc107; color: #000; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Hana! Dul! Set!</span></li>
          <li style="margin-bottom: 1.5rem;">Front-leg Side Kick <span style="background: #ffc107; color: #000; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Hana! Dul! Set!</span></li>
          
          <!-- Yellow Belt Section -->
          <li style="margin-bottom: 1.5rem; font-weight: 600; color: #ffc107; background: rgba(255, 193, 7, 0.2); padding: 0.5rem; border-radius: 4px;">This is the Yellow Belt Section</li>
          <li style="margin-bottom: 0.8rem;">Ridge Hand <span style="background: #ffc107; color: #000; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Hana! Dul! Set!</span></li>
          <li style="margin-bottom: 0.8rem;">Rap <span style="background: #ffc107; color: #000; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Hana! Dul! Set!</span></li>
          <li style="margin-bottom: 0.8rem;">Hammer Fist <span style="background: #ffc107; color: #000; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Hana! Dul! Set!</span></li>
          <li style="margin-bottom: 1.5rem;">Back-leg Side Kick <span style="background: #ffc107; color: #000; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Hana! Dul! Set!</span></li>
          
          <!-- Green Belt Section -->
          <li style="margin-bottom: 1.5rem; font-weight: 600; color: #28a745; background: rgba(40, 167, 69, 0.1); padding: 0.5rem; border-radius: 4px;">This is the Green Belt Section</li>
          <li style="margin-bottom: 0.8rem;">Inside-Out Block <span style="background: #ffc107; color: #000; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Hana! Dul! Set!</span></li>
          <li style="margin-bottom: 0.8rem;">Lateral Block <span style="background: #ffc107; color: #000; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Hana! Dul! Set!</span></li>
          <li style="margin-bottom: 0.8rem;">Elbow Strike <span style="background: #ffc107; color: #000; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Hana! Dul! Set!</span></li>
          <li style="margin-bottom: 0.8rem;">Forearm Strike <span style="background: #ffc107; color: #000; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Hana! Dul! Set!</span></li>
          <li style="margin-bottom: 0.8rem;">Front-leg Round Kick <span style="background: #ffc107; color: #000; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Hana! Dul! Set!</span></li>
          <li style="margin-bottom: 1.5rem;">Back-leg Round Kick <span style="background: #ffc107; color: #000; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Hana! Dul! Set!</span></li>
          
          <!-- Purple Belt Section -->
          <li style="margin-bottom: 1.5rem; font-weight: 600; color: #800080; background: rgba(128, 0, 128, 0.1); padding: 0.5rem; border-radius: 4px;">This is the Purple Belt Section</li>
          <li style="margin-bottom: 0.8rem;">Take off and Tie Belt in 30 seconds <span style="color: #666; font-style: italic;">(Parent or friend calls time)</span></li>
          <li style="margin-bottom: 0.8rem;">Hook <span style="background: #ffc107; color: #000; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Hana! Dul! Set!</span></li>
          <li style="margin-bottom: 0.8rem;">Upper cut <span style="background: #ffc107; color: #000; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Hana! Dul! Set!</span></li>
          <li style="margin-bottom: 0.8rem;">Spin Rap <span style="background: #ffc107; color: #000; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Hana! Dul! Set!</span></li>
          <li style="margin-bottom: 0.8rem;">Hook Kick <span style="background: #ffc107; color: #000; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Hana! Dul! Set!</span></li>
          <li style="margin-bottom: 0.8rem;">Spin Hook Kick <span style="background: #ffc107; color: #000; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Hana! Dul! Set!</span></li>
          <li style="margin-bottom: 1.5rem;">Back Kick (turn sideways) <span style="background: #ffc107; color: #000; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Hana! Dul! Set!</span></li>
          
          <!-- Blue Belt Section -->
          <li style="margin-bottom: 1.5rem; font-weight: 600; color: #007bff; background: rgba(0, 123, 255, 0.1); padding: 0.5rem; border-radius: 4px;">We finish with the Blue Belt Section</li>
          <li style="margin-bottom: 0.8rem;">Reverse Stance <span style="color: #666; font-style: italic;">(hold for 3 seconds)</span></li>
          <li style="margin-bottom: 0.8rem;">Crescent Kick <span style="background: #ffc107; color: #000; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Hana! Dul! Set!</span></li>
          <li style="margin-bottom: 0.8rem;">Moon Kick <span style="background: #ffc107; color: #000; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Hana! Dul! Set!</span></li>
          <li style="margin-bottom: 0.8rem;">Axe Kick <span style="background: #ffc107; color: #000; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Hana! Dul! Set!</span></li>
          <li style="margin-bottom: 0.8rem;">Double Front Round Kick <span style="background: #ffc107; color: #000; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Hana! Dul! Set!</span></li>
          <li style="margin-bottom: 0.8rem;">All Purpose Block (Left) <span style="background: #ffc107; color: #000; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Hana! Dul! Set!</span></li>
          <li style="margin-bottom: 2rem;">All Purpose block (Right) <span style="background: #ffc107; color: #000; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Hana! Dul! Set!</span></li>
          
          <!-- Pad Striking Section -->
          <li style="margin-bottom: 1rem; font-weight: 600; color: #dc3545; background: rgba(220, 53, 69, 0.1); padding: 1rem; border-radius: 6px; line-height: 1.7;">
            This is the Pad Striking Section - perform all moves on a punching bag, BOB Dummy, Kicking Shield, or approved focus pads. Perform each single and combination 3x on the pads with power. Take 2-3 seconds between each repetition to allow time to reset in your fighting stance. Add a yell to any back hand cross and back leg snap kicks only.
          </li>
          
          <li style="margin-bottom: 0.8rem;">Combination - Jab, Cross</li>
          <li style="margin-bottom: 0.8rem;">Combination - Jab, cross, front hand hook, back hand uppercut</li>
          <li style="margin-bottom: 0.8rem;">Single - Back leg snap kick</li>
          <li style="margin-bottom: 0.8rem;">Single - Back leg side kick</li>
          <li style="margin-bottom: 0.8rem;">Combination - Lateral block, front hand rap, back leg round kick</li>
          <li style="margin-bottom: 0.8rem;">Combination - Inside out block, back hand ridge hand, back hand forearm strike</li>
          <li style="margin-bottom: 0.8rem;">Single - Front leg round kick - left lead leg</li>
          <li style="margin-bottom: 0.8rem;">Single - Front leg round kick - right lead leg</li>
          <li style="margin-bottom: 0.8rem;">Single - Back leg round kick - left lead leg</li>
          <li style="margin-bottom: 0.8rem;">Single - Back leg round kick - right lead leg</li>
          <li style="margin-bottom: 0.8rem;">Combination - Front leg round kick, back hand hammer fist - left lead leg</li>
          <li style="margin-bottom: 0.8rem;">Combination - Front leg round kick, back hand hammer fist - right lead leg</li>
          <li style="margin-bottom: 0.8rem;">Combination - Jab, Rap, Spin-Rap</li>
          <li style="margin-bottom: 0.8rem;">Combination - Front snap kick, jab, cross, back leg round kick</li>
          <li style="margin-bottom: 0.8rem;">Combination - Double front leg round kick - left lead leg</li>
          <li style="margin-bottom: 0.8rem;">Combination - Double front leg round kick - right lead leg</li>
          <li style="margin-bottom: 0.8rem;">Combination - All purpose block, back leg reverse moon kick - left lead leg</li>
          <li style="margin-bottom: 0.8rem;">Combination - All purpose block, back leg reverse moon kick - right lead leg</li>
          <li style="margin-bottom: 2rem;">Combination - Double front round kick, spin kick</li>
          
          <li style="margin-bottom: 2rem; font-weight: 500;">Bow</li>
          
          <!-- Master Form Section -->
          <li style="margin-bottom: 1.5rem; font-weight: 600; color: #6f42c1; background: rgba(111, 66, 193, 0.1); padding: 0.5rem; border-radius: 4px;">Now we move on to Master Form, moves 1-30</li>
          <li style="margin-bottom: 0.8rem;">Joon Bi!</li>
          <li style="margin-bottom: 0.8rem;">Present! <span style="color: #666; font-style: italic;">(Student says, "Judges, my name is...")</span></li>
          <li style="margin-bottom: 0.8rem;">Yes, you may begin.</li>
          <li style="margin-bottom: 0.8rem;">Formal Salute</li>
          <li style="margin-bottom: 0.8rem;">Bow</li>
          <li style="margin-bottom: 0.8rem; font-style: italic; color: #666;">(Student executes moves 1-30 without stopping)</li>
          <li style="margin-bottom: 0.8rem;">Formal Salute</li>
          <li style="margin-bottom: 0.8rem;">Bow</li>
          <li style="margin-bottom: 1.5rem; font-weight: 600; color: #6f42c1; background: rgba(111, 66, 193, 0.05); padding: 0.5rem; border-radius: 4px;">Now we will perform each move individually facing the camera</li>
          <li style="margin-bottom: 0.8rem;">Move 22, Fists of Fury, Inside a Right Punch <span style="background: #17a2b8; color: white; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Begin. Again.</span></li>
          <li style="margin-bottom: 0.8rem;">Move 23, Gathering the Dragon, Outside a Left Punch <span style="background: #17a2b8; color: white; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Begin. Again.</span></li>
          <li style="margin-bottom: 0.8rem;">Move 24, Bolo, Inside a Right Punch <span style="background: #17a2b8; color: white; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Begin. Again.</span></li>
          <li style="margin-bottom: 0.8rem;">Move 25, Up the Circle, Inside a Right Roundhouse Kick <span style="background: #17a2b8; color: white; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Begin. Again.</span></li>
          <li style="margin-bottom: 0.8rem;">Move 26, Rolling Thunder, Sparring - Fake Low Ball Kick Lead <span style="background: #17a2b8; color: white; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Begin. Again.</span></li>
          <li style="margin-bottom: 0.8rem;">Move 27, Twirling Fans, Inside Left/Right Punches <span style="background: #17a2b8; color: white; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Begin. Again.</span></li>
          <li style="margin-bottom: 0.8rem;">Move 28, Stinging Butterfly, Outside a Right Punch <span style="background: #17a2b8; color: white; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Begin. Again.</span></li>
          <li style="margin-bottom: 0.8rem;">Move 29, Escaping Wings, Rear Arms Captured <span style="background: #17a2b8; color: white; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Begin. Again.</span></li>
          <li style="margin-bottom: 1.5rem;">Move 30, Broken Lightning, Outside-in a Left Punch <span style="background: #17a2b8; color: white; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Begin. Again.</span></li>
          <li style="margin-bottom: 0.8rem;">Formal Salute</li>
          <li style="margin-bottom: 2rem;">Bow</li>
          
          <!-- Jujitsu Section -->
          <li style="margin-bottom: 1.5rem; font-weight: 600; color: #653910; background: rgba(101, 57, 16, 0.1); padding: 0.5rem; border-radius: 4px;">Now we move on to Jujitsu, with 3 different escapes for each hold (when applicable)</li>
          <li style="margin-bottom: 0.8rem;">Front Hair Grab <span style="background: #ffc107; color: #000; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Hana! Dul! Set!</span></li>
          <li style="margin-bottom: 0.8rem;">Side Choke (face camera) <span style="background: #ffc107; color: #000; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Hana! Dul! Set!</span></li>
          <li style="margin-bottom: 0.8rem;">Shirt Grab hands up <span style="background: #ffc107; color: #000; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Hana! Dul! Set!</span></li>
          <li style="margin-bottom: 0.8rem;">Belt Grab <span style="background: #ffc107; color: #000; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Hana! Dul! Set!</span></li>
          <li style="margin-bottom: 0.8rem;">Rear Choke <span style="background: #ffc107; color: #000; padding: 0.2rem 0.4rem; border-radius: 3px; font-weight: 600;">Hana! Dul! Set!</span></li>
          <li style="margin-bottom: 0.8rem;">Joon Bi!</li>
          <li style="margin: 0; font-weight: 500;">Bow</li>
        </ol>
      </div>
    </div>
    </div>
  </div>
</div>

<div id="redBeltLightbox" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0, 0, 0, 0.95); display: none; align-items: center; justify-content: center; z-index: 9999; transition: opacity 0.3s ease;" onclick="closeRedBeltLightbox()">
   <div style="position: relative; max-width: 90vw; max-height: 90vh;">
     <button onclick="closeRedBeltLightbox()" 
            style="position: absolute; top: -15px; right: -15px; width: 40px; height: 40px; border-radius: 50%; background: #dc3545; border: none; color: white; font-size: 1.2rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease; z-index: 10;"
            onmouseover="this.style.transform='scale(1.1)'; this.style.background='#c82333';"
            onmouseout="this.style.transform='scale(1)'; this.style.background='#dc3545';">
       ×
     </button>
    <div style="background: rgba(255, 255, 255, 0.95); border-radius: 12px; padding: 2rem; color: #333; overflow-y: auto; max-height: 90vh;">
    <?php echo $scriptsAccordion['lightbox_content']['red_belt'] ?? '<p>Content not configured</p>'; ?>
    </div>
  </div>
  </div>
</div>
 </div>

<div id="redStripeLightbox" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0, 0, 0, 0.95); display: none; align-items: center; justify-content: center; z-index: 9999; opacity: 0; transition: opacity 0.3s ease;" onclick="closeRedStripeLightbox()">
  <div style="position: relative; max-width: 90vw; max-height: 90vh; background: rgba(255, 255, 255, 0.95); border-radius: 12px; padding: 2rem; color: #333; overflow-y: auto;">
    <button onclick="closeRedStripeLightbox()" 
            style="position: absolute; top: -15px; right: -15px; width: 40px; height: 40px; border-radius: 50%; background: #dc3545; border: none; color: white; font-size: 1.2rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease;"
            onmouseover="this.style.transform='scale(1.1)'; this.style.background='#c82333';"
            onmouseout="this.style.transform='scale(1)'; this.style.background='#dc3545';">
      ×
    </button>
    <div style="background: rgba(255, 255, 255, 0.95); border-radius: 12px; padding: 2rem; color: #333; overflow-y: auto; max-height: 90vh;">
    <?php echo $scriptsAccordion['lightbox_content']['red_stripe'] ?? '<p>Content not configured</p>'; ?>
    </div>
  </div>
      Red Belt with Black Stripe Script
    </h3>
    
    <p style="text-align: center; color: #666; font-style: italic;">Content will be provided soon...</p>
  </div>
</div>
 </div>
 
<div id="weekendCalendarLightbox" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0, 0, 0, 0.95); display: none; align-items: center; justify-content: center; z-index: 9999; opacity: 0; transition: opacity 0.3s ease;" onclick="closeWeekendCalendarPreview()">
  <div style="position: relative; max-width: 90vw; max-height: 90vh;">
    <img src="assets/images/weekend-evening/weekend-evening-may-june.png" 
         alt="Weekend & Evening Karate Schedule - Full Size" 
         style="width: 100%; height: auto; border-radius: 10px; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.8);">
    
    <button onclick="closeWeekendCalendarPreview()" 
            style="position: absolute; top: -15px; right: -15px; width: 40px; height: 40px; border-radius: 50%; background: #dc3545; border: none; color: white; font-size: 1.2rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease;"
            onmouseover="this.style.transform='scale(1.1)'; this.style.background='#c82333';"
            onmouseout="this.style.transform='scale(1)'; this.style.background='#dc3545';">
      ×
    </button>
  </div>
</div>


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

<!-- Lightbox -->
<div id="lightbox" class="lightbox">
  <div class="lightbox-content">
    <div class="media-container">
      <video controls autoplay muted loop class="lightbox-media" id="lightbox-video">
        <source src="" type="video/mp4">
        Your browser does not support the video tag.
      </video>
      <img src="" alt="" class="lightbox-media" id="lightbox-image" style="display: none;">
    </div>

    <div class="lightbox-caption" id="lightbox-caption"></div>
    <span class="close-btn">&times;</span>

    <!-- Navigation arrows -->
    <div class="lightbox-nav-wrapper">
      <button class="lightbox-nav prev">&#10094;</button>
      <button class="lightbox-nav next">&#10095;</button>
    </div>
  </div>
</div>



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
require_once 'includes/footer-dynamic.php';
render_footer('live');
?>

<!-- Summer Camp Video Lightbox -->
<div id="summerCampVideoLightbox" class="summer-camp-lightbox">
  <div class="summer-camp-lightbox-content">
    <button class="summer-camp-close-btn" onclick="closeSummerCampVideo()">
      <i class="fas fa-times"></i>
    </button>
    <div class="summer-camp-video-wrapper">
      <video id="summerCampVideo" class="summer-camp-lightbox-video" controls preload="metadata" volume="0.8">
        <source src="assets/videos/summer-camp/kaizen-summer-camp.mp4" type="video/mp4">
        Your browser does not support the video tag.
      </video>
    </div>
  </div>
</div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="scripts/floating-nav.js"></script>
  <script src="scripts/video-controls.js"></script>
  
  <!-- Video Controls JavaScript -->
  <script src="scripts/home/hero-video.js"></script>
  
  <!-- Floating Pills Navigation JavaScript -->
  <script src="scripts/home/floating-nav.js"></script>

  <script src="scripts/lightbox.js"></script>
  <script src="scripts/amenities.js"></script>

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
  <?php // include 'includes/chatbot.html'; ?>
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
          apiEndpoint: './chatbot-php/test_chatbot_simple.php'
      };
  </script>
  <script src="chatbot-php/widget.js"></script>
  <script src="modules/nyc/nyc-script.js?v=<?php echo time(); ?>"></script>

  <!-- Homepage Popup -->
  <?php include 'includes/homepage-popup.php'; ?>

</body>
</html>
