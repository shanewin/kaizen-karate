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
  <style>
    /* 📱 Mobile Logo Enhancement - 480px and below */
    @media (max-width: 480px) {
      .brand-logo-prominent {
        width: 150% !important;
        height: auto !important;
        max-width: 220px !important;
        transform: scale(1.3) !important;
      }
      
      .luxury-brand-container {
        padding: 0.5rem !important;
      }
    }
    
    /* 📱 Ultra Small Mobile Logo - 390px and below */
    @media (max-width: 390px) {
      .brand-logo-prominent {
        width: 100% !important;
        height: auto !important;
        max-width: 100px !important;
        transform: none !important;
        object-fit: contain !important;
        object-position: center !important;
        display: block !important;
      }
      
      .luxury-brand-container {
        padding: 0.2rem !important;
        margin: 0 !important;
        flex-shrink: 0 !important;
        width: auto !important;
      }
    }
    
    /* 📱 Mobile Brand Text Enhancement - 480px and below */
    @media (max-width: 480px) {
      body nav.floating-pills-nav .nav-container .mobile-brand-text .mobile-brand-name,
      body .mobile-brand-text .mobile-brand-name,
      body .nav-container .mobile-brand-text .mobile-brand-name,
      body .floating-pills-nav .nav-container .mobile-brand-text .mobile-brand-name,
      body span.mobile-brand-name,
      .mobile-brand-text .mobile-brand-name,
      .nav-container .mobile-brand-text .mobile-brand-name,
      .floating-pills-nav .nav-container .mobile-brand-text .mobile-brand-name,
      span.mobile-brand-name {
        font-size: 1.6rem !important;
        font-weight: 900 !important;
        letter-spacing: 2px !important;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2) !important;
      }
    }
    
    /* 📱 Ultra Small Mobile Brand Text - 390px and below */
    @media (max-width: 390px) {
      body nav.floating-pills-nav .nav-container .mobile-brand-text .mobile-brand-name,
      body .mobile-brand-text .mobile-brand-name,
      body .nav-container .mobile-brand-text .mobile-brand-name,
      body .floating-pills-nav .nav-container .mobile-brand-text .mobile-brand-name,
      body span.mobile-brand-name,
      .mobile-brand-text .mobile-brand-name,
      .nav-container .mobile-brand-text .mobile-brand-name,
      .floating-pills-nav .nav-container .mobile-brand-text .mobile-brand-name,
      span.mobile-brand-name {
        font-size: 1.5rem !important;
        font-weight: 900 !important;
        letter-spacing: 1.5px !important;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3) !important;
        line-height: 1.1 !important;
        margin: 0 !important;
        padding: 0 !important;
        white-space: nowrap !important;
      }
      
      .mobile-brand-text {
        flex: 1 !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        min-width: 0 !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
      }
      
      /* Ensure equal spacing on both sides */
      .luxury-brand-container {
        flex-shrink: 0 !important;
        width: 100px !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
      }
      
      .mobile-menu-toggle {
        flex-shrink: 0 !important;
        width: 40px !important;
      }
      
      /* Ensure proper header layout with equal spacing */
      .nav-container {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        width: 100% !important;
        max-width: 100% !important;
        padding: 0 1rem !important;
      }
    }
    
    /* 📱 Ultra Small Mobile Hamburger Menu - 390px and below */
    @media (max-width: 390px) {
      .mobile-menu-toggle {
        width: 40px !important;
        height: 40px !important;
        padding: 6px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
      }
      
      .mobile-menu-toggle .hamburger {
        width: 22px !important;
        height: 3px !important;
        background-color: white !important;
        position: relative !important;
      }
      
      .mobile-menu-toggle .hamburger::before,
      .mobile-menu-toggle .hamburger::after {
        width: 22px !important;
        height: 3px !important;
        background-color: white !important;
        position: absolute !important;
        left: 0 !important;
      }
      
      .mobile-menu-toggle .hamburger::before {
        top: -7px !important;
      }
      
      .mobile-menu-toggle .hamburger::after {
        top: 7px !important;
      }
    }
    
    /* 📱 Ultra Small Mobile Header Spacing - 390px and below */
    @media (max-width: 390px) {
      /* Add padding to the navigation container for overall spacing */
      .nav-container {
        padding-left: 0.8rem !important;
        padding-right: 0.8rem !important;
      }
      
      /* Add space between logo and text */
      .luxury-brand-container {
        margin-right: 0.5rem !important;
      }
      
      /* Add space around the text */
      .mobile-brand-text {
        margin: 0 0.5rem !important;
      }
      
      /* Ensure hamburger stays on right with proper spacing */
      .mobile-menu-toggle {
        margin-left: auto !important;
      }
    }
    
    /* 🖥️ Desktop Service Areas - 769px and above */
    @media (min-width: 769px) {
      .served-states-inner {
        display: flex !important;
        align-items: center !important;
        gap: 1rem !important;
      }
      
      .served-states-title {
        font-size: 2.2rem !important;
        font-weight: 900 !important;
        text-transform: uppercase !important;
        letter-spacing: 3px !important;
        margin-bottom: 0 !important;
        flex-shrink: 0 !important;
      }
      
      .served-states-grid {
        flex: 1 !important;
      }
    }
    
    /* 📱 Mobile Accordion Titles - 480px and below */
    @media (max-width: 480px) {
      .about-section-title {
        font-size: 1.7rem !important;
        font-weight: 700 !important;
        line-height: 1.3 !important;
      }
    }
    
    /* 📱 Ultra Small Mobile Accordion Titles - 390px and below */
    @media (max-width: 390px) {
      .about-section-title {
        font-size: 1.5rem !important;
        font-weight: 700 !important;
        line-height: 1.2 !important;
      }
    }
    
    /* 👨‍🏫 Instructor Profile Images - All breakpoints */
    .instructor-profile-image {
      margin-top: 1rem !important;
      margin-bottom: 1rem !important;
      float: left !important;
      margin-right: 1.5rem !important;
      border-radius: 8px !important;
      max-width: 220px !important;
      height: auto !important;
    }
    
    /* 📱 Mobile Instructor Images - 480px and below */
    @media (max-width: 480px) {
      .instructor-profile-image {
        float: none !important;           /* Remove float */
        display: block !important;        /* Block display */
        margin: 1rem auto 1.5rem auto !important;  /* Center with spacing */
        max-width: 280px !important;      /* Even bigger on mobile */
        width: 100% !important;           /* Responsive width */
        max-height: 320px !important;     /* Larger height limit */
        object-fit: cover !important;     /* Maintain aspect ratio */
      }
    }
    
    /* 📱 Ultra Small Mobile Instructor Images - 390px and below */
    @media (max-width: 390px) {
      .instructor-profile-image {
        max-width: 240px !important;      /* Much bigger on tiny screens */
        max-height: 280px !important;     /* Larger height for small screens */
        margin: 0.8rem auto 1.2rem auto !important;
      }
    }
    
    /* 📱 Ultra Small Mobile Service Areas - 390px and below */
    @media (max-width: 390px) {
      /* Service Areas Section Title */
      .served-states-section h2,
      .served-states-section .section-title,
      .service-areas-title {
        font-size: 2.2rem !important;
        font-weight: 900 !important;
        text-transform: uppercase !important;
        letter-spacing: 2px !important;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3) !important;
      }
      
      /* Main Section Headers - Make Bigger (except accordion titles) */
      .summer-camp-title,
      .kaizen-dojo-title,
      h2.text-center.mb-4,
      h2.text-center.mb-5 {
        font-size: 2.5rem !important;
        font-weight: 900 !important;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3) !important;
        line-height: 1.2 !important;
      }
      
      /* Training Card Headers */
      .training-card-header h3,
      .weekend-evening-title {
        font-size: 1.1rem !important;
        font-weight: 700 !important;
      }
      
      /* Card Title Headers (h6 elements) - Make Bigger */
      .card-title,
      h6.card-title,
      h6.card-title.text-danger.fw-bold.text-uppercase.mb-3,
      h6[style*="font-size: 0.9rem"] {
        font-size: 1.3rem !important;
        font-weight: 900 !important;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3) !important;
      }
      
      /* Summer Camp Section Headers */
      .summer-camp-section-title {
        font-size: 1.6rem !important;
        font-weight: 800 !important;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3) !important;
      }
      
      .served-states-grid {
        display: grid !important;
        grid-template-columns: 1fr 1fr !important;
        grid-template-rows: 1fr 1fr !important;
        gap: 1.8rem !important;
        max-width: 320px !important;
        margin: 0 auto !important;
      }
      
      .state-icons-row {
        display: contents !important;
      }
      
      .state-labels-row {
        display: contents !important;
      }
      
      .state-icon-img {
        width: 65px !important;
        height: 65px !important;
        display: block !important;
        margin: 0 auto 0.5rem auto !important;
      }
      
      .state-label {
        display: block !important;
        text-align: center !important;
        font-size: 0.9rem !important;
        font-weight: 600 !important;
        line-height: 1.2 !important;
      }
      
      /* Position each state in 2x2 grid */
      .state-icon-img:nth-child(1) { grid-column: 1; grid-row: 1; }
      .state-label:nth-child(1) { grid-column: 1; grid-row: 1; margin-top: 7rem; }
      
      .state-icon-img:nth-child(2) { grid-column: 2; grid-row: 1; }
      .state-label:nth-child(2) { grid-column: 2; grid-row: 1; margin-top: 7rem; }
      
      .state-icon-img:nth-child(3) { grid-column: 1; grid-row: 2; }
      .state-label:nth-child(3) { grid-column: 1; grid-row: 2; margin-top: 7rem; }
      
      .state-icon-img:nth-child(4) { grid-column: 2; grid-row: 2; }
      .state-label:nth-child(4) { grid-column: 2; grid-row: 2; margin-top: 7rem; }
    }
    
    /* 📱 Mobile Hero Gap Fix - 480px and below */
    @media (max-width: 480px) {
      /* Move hero video up to eliminate gap */
      .hero-section {
        margin-top: -15px !important;
        padding-top: 0 !important;
      }
      
      .hero-overlay-section {
        padding-top: 0 !important;
        margin-top: 0 !important;
      }
      
      .hero-content {
        padding-top: 1rem !important;
      }
      
      /* Ensure video container starts immediately after header */
      .video-container {
        margin-top: 0 !important;
        padding-top: 0 !important;
      }
    }
    
    /* 📱 Ultra Small Mobile Hero Gap Fix - 390px and below */
    @media (max-width: 390px) {
      /* Move hero video up to eliminate gap */
      .hero-section {
        margin-top: -20px !important;
      }
      
      .hero-overlay-section {
        padding-top: 0 !important;
        margin-top: 0 !important;
      }
      
      .hero-content {
        padding-top: 1rem !important;
      }
      
      /* Ensure video container starts immediately after header */
      .video-container {
        margin-top: 0 !important;
        padding-top: 0 !important;
      }
      
      /* Summer Camp Special Offer Section - Mobile Fix */
      .summer-camp-section div[style*="background: linear-gradient(135deg, rgba(220, 53, 69, 0.12)"] {
        padding: 1rem !important;
        margin: 0 0.3rem !important;
        border-radius: 12px !important;
      }
      
      /* Move Summer Camp section up higher */
      .summer-camp-section {
        padding-top: 1rem !important;
        margin-top: -1rem !important;
      }
      
      .summer-camp-section .container {
        padding-top: 0.5rem !important;
      }
      
      /* Fix absolute positioned badges */
      .summer-camp-section div[style*="position: absolute"] {
        position: static !important;
        top: auto !important;
        left: auto !important;
        right: auto !important;
        transform: none !important;
        display: block !important;
        margin: 0 auto 1rem auto !important;
        width: fit-content !important;
        text-align: center !important;
      }
      
      /* Special offer badge - more specific targeting */
      div[style*="position: absolute; top: -12px; left: 50%"],
      div[style*="SPECIAL OFFER - SAVE $150 PER WEEK"],
      .summer-camp-section div[style*="SPECIAL OFFER"] {
        position: absolute !important;
        top: -12px !important;
        left: 50% !important;
        transform: translateX(-50%) !important;
        font-size: 0.75rem !important;
        padding: 4px 25px !important;
        margin: 0 !important;
        border-radius: 15px !important;
        width: 90% !important;
        max-width: 280px !important;
        display: block !important;
        text-align: center !important;
        z-index: 10 !important;
      }
      
      /* Free badge */
      .summer-camp-section div[style*="100% FREE"] {
        font-size: 0.6rem !important;
        padding: 3px 8px !important;
        margin-bottom: 1rem !important;
      }
      
      /* Main content spacing */
      .summer-camp-section div[style*="margin-top: 15px"] {
        margin-top: 0.5rem !important;
      }
      
      /* Deadline section */
      .summer-camp-section div[style*="margin-bottom: 20px"] {
        margin-bottom: 1rem !important;
        padding: 0.8rem !important;
      }
      
      /* Green benefit box */
      .summer-camp-section div[style*="background: linear-gradient(135deg, rgba(40, 167, 69, 0.2)"] {
        padding: 1rem !important;
        margin-bottom: 1rem !important;
      }
      
      /* All headings smaller */
      .summer-camp-section h3 {
        font-size: 1.1rem !important;
        line-height: 1.2 !important;
        margin-bottom: 0.5rem !important;
      }
      
      .summer-camp-section h4 {
        font-size: 1rem !important;
        margin-bottom: 0.3rem !important;
      }
      
      /* All text smaller */
      .summer-camp-section p {
        font-size: 0.9rem !important;
        line-height: 1.3 !important;
        margin-bottom: 0.5rem !important;
      }
      
      /* Icons smaller */
      .summer-camp-section i {
        font-size: 1.5rem !important;
        margin-bottom: 0.5rem !important;
      }
      
      /* Kaizen Kenpo Tab Navigation - Mobile Dropdown */
      .kenpo-tabs-mobile {
        display: block !important;
      }
      
      .kenpo-tabs-desktop {
        display: none !important;
      }
      
      .kenpo-dropdown-container {
        margin-bottom: 1.5rem !important;
      }
      
      .kenpo-dropdown-header {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
        color: white !important;
        border: 2px solid #dc3545 !important;
        border-radius: 8px !important;
        padding: 0.8rem 1rem !important;
        font-weight: 600 !important;
        font-size: 1rem !important;
        text-align: center !important;
        box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3) !important;
        cursor: pointer !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
      }
      
      .kenpo-dropdown-menu {
        background: white !important;
        border: 2px solid #ddd !important;
        border-top: none !important;
        border-radius: 0 0 8px 8px !important;
        margin-top: -2px !important;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
      }
      
      .kenpo-dropdown-button {
        width: 100% !important;
        background: white !important;
        border: none !important;
        border-bottom: 1px solid #eee !important;
        padding: 0.8rem 1rem !important;
        font-weight: 600 !important;
        font-size: 0.9rem !important;
        color: #333 !important;
        text-align: left !important;
        margin-bottom: 0 !important;
        cursor: pointer !important;
      }
      
      .kenpo-dropdown-button:last-child {
        border-bottom: none !important;
        border-radius: 0 0 6px 6px !important;
      }
      
      .kenpo-dropdown-button:hover {
        background: #f8f9fa !important;
        color: #dc3545 !important;
      }
      
      .kenpo-dropdown-button.active {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
        color: white !important;
      }
      
      /* Kaizen Dojo Cards - Mobile Fix */
      .dojo-card {
        padding: 1rem !important;
        margin-bottom: 1rem !important;
        height: auto !important;
        min-height: auto !important;
      }
      
      .dojo-card-title {
        font-size: 1.1rem !important;
        line-height: 1.3 !important;
        margin-bottom: 0.8rem !important;
        word-wrap: break-word !important;
        overflow-wrap: break-word !important;
      }
      
      .dojo-card-text {
        font-size: 0.9rem !important;
        line-height: 1.4 !important;
        margin-bottom: 0 !important;
        word-wrap: break-word !important;
        overflow-wrap: break-word !important;
        hyphens: auto !important;
        text-align: left !important;
      }
      
      .dojo-card-icon {
        margin-bottom: 0.8rem !important;
      }
      
      .dojo-card-icon i {
        font-size: 1.8rem !important;
      }
    }
    
    /* Kaizen Kenpo Tab Navigation - Desktop Tabs Only (above 768px) */
    @media (min-width: 769px) {
      .kenpo-tabs-mobile {
        display: none !important;
      }
      
      .kenpo-tabs-desktop {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        justify-content: flex-start !important;
        align-items: flex-end !important;
      }
      
      .kenpo-tabs-desktop .nav-item {
        flex: 0 0 auto !important;
      }
      
      .kenpo-tabs-desktop .nav-link {
        white-space: nowrap !important;
        font-size: 1.1rem !important;
        padding: 0.8rem 1.5rem !important;
      }
    }
    
    /* Kaizen Kenpo Tab Navigation - Mobile Dropdown (768px and below) */
    @media (max-width: 768px) {
      .kenpo-tabs-mobile {
        display: block !important;
      }
      
      .kenpo-tabs-desktop {
        display: none !important;
      }
      
      .kenpo-dropdown-container {
        margin-bottom: 1.5rem !important;
      }
      
      .kenpo-dropdown-header {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
        color: white !important;
        border: 2px solid #dc3545 !important;
        border-radius: 8px !important;
        padding: 0.8rem 1rem !important;
        font-weight: 600 !important;
        font-size: 1rem !important;
        text-align: center !important;
        box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3) !important;
        cursor: pointer !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
      }
      
      .kenpo-dropdown-menu {
        background: white !important;
        border: 2px solid #ddd !important;
        border-top: none !important;
        border-radius: 0 0 8px 8px !important;
        margin-top: -2px !important;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
      }
      
      .kenpo-dropdown-button {
        width: 100% !important;
        background: white !important;
        border: none !important;
        border-bottom: 1px solid #eee !important;
        padding: 0.8rem 1rem !important;
        font-weight: 600 !important;
        font-size: 0.9rem !important;
        color: #333 !important;
        text-align: left !important;
        margin-bottom: 0 !important;
        cursor: pointer !important;
      }
      
      .kenpo-dropdown-button:last-child {
        border-bottom: none !important;
        border-radius: 0 0 6px 6px !important;
      }
      
      .kenpo-dropdown-button:hover {
        background: #f8f9fa !important;
        color: #dc3545 !important;
      }
      
      .kenpo-dropdown-button.active {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
        color: white !important;
      }
    }
    
    /* Training Card Expandable Content */
    .expandable-content {
      display: none !important;
    }
    
    .expandable-content.show {
      display: block !important;
    }
    
    /* Override existing CSS that hides description text */
    .training-description-full {
      display: block !important;
      visibility: visible !important;
      opacity: 1 !important;
    }
    
    /* Ensure description text is visible when expanded */
    .expandable-content.show .training-description-full {
      display: block !important;
      visibility: visible !important;
      opacity: 1 !important;
    }
    
  </style>
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
   <script>
   document.addEventListener('DOMContentLoaded', function() {
     const mobileRegisterBtn = document.getElementById('mobileHeroRegisterBtn');
     const mobileRegisterPanel = document.getElementById('mobileHeroRegisterPanel');
     
     if (mobileRegisterBtn && mobileRegisterPanel) {
       console.log('Mobile register elements found'); // Debug log
       
       mobileRegisterBtn.addEventListener('click', function(e) {
         e.preventDefault();
         console.log('Mobile register button clicked'); // Debug log
         
         // Check current display state
         const currentDisplay = window.getComputedStyle(mobileRegisterPanel).display;
         console.log('Current display:', currentDisplay); // Debug log
         
         if (currentDisplay === 'none') {
           mobileRegisterPanel.style.display = 'flex';
           console.log('Showing panel'); // Debug log
         } else {
           mobileRegisterPanel.style.display = 'none';
           console.log('Hiding panel'); // Debug log
         }
       });
     } else {
       console.log('Mobile register elements not found'); // Debug log
     }
   });
   </script>


  
  <!-- Training Options Section -->
  <section id="training-options" class="training-options-section">
    <div class="container">
      <!-- Training Cards Grid -->
      <div class="row g-4 training-cards-grid">
        <!-- After School -->
        <div class="col-lg-3 col-md-6 col-sm-6 col-6">
          <div class="training-card h-100">
            <div class="training-card-header">
              <h3><?php echo display_text('programs', 'cards.0.title', 'After School Program'); ?></h3>
            </div>
            <div class="training-card-image">
              <img src="<?php echo display_text('programs', 'cards.0.image', 'assets/images/panels/after-school.jpg'); ?>" alt="<?php echo display_text('programs', 'cards.0.image_alt', 'After school karate program for children at Kaizen Karate'); ?>" class="card-image">
            </div>
            <div class="training-card-content">
              <p class="training-summary"><?php echo display_text('programs', 'cards.0.summary', 'Comprehensive after-school karate program designed for young students.'); ?></p>
              <a class="read-more-link" onclick="toggleDescription(this)">Read More</a>
              <div class="training-description expandable-content">
                <span class="training-description-full"><?php echo display_text('programs', 'cards.0.description', 'Safe, structured environment where children learn traditional karate while developing discipline, respect, and confidence. Perfect for working parents.'); ?></span>
              <div class="training-card-buttons">
                <?php 
                $programs_data = get_content('programs');
                $card0_buttons = $programs_data['cards'][0]['buttons'] ?? [];
                foreach ($card0_buttons as $button): 
                  $btn_class = ($button['style'] === 'primary') ? 'training-btn-primary' : 'training-btn-secondary';
                ?>
                <a href="<?php echo htmlspecialchars($button['url'] ?? '#'); ?>" <?php echo (strpos($button['url'] ?? '', 'http') === 0) ? 'target="_blank"' : ''; ?> class="btn <?php echo $btn_class; ?>"><?php echo htmlspecialchars($button['text'] ?? 'Learn More'); ?> →</a>
                <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Weekend & Evening -->
        <div class="col-lg-3 col-md-6 col-sm-6 col-6">
          <div class="training-card h-100">
            <div class="training-card-header">
              <h3><?php echo display_text('programs', 'cards.1.title', 'Weekend & Evening'); ?></h3>
            </div>
            <div class="training-card-image">
              <img src="<?php echo display_text('programs', 'cards.1.image', 'assets/images/panels/weekends.jpg'); ?>" alt="<?php echo display_text('programs', 'cards.1.image_alt', 'Weekend and evening karate classes for busy schedules'); ?>" class="card-image">
            </div>
            <div class="training-card-content">
              <p class="training-summary"><?php echo display_text('programs', 'cards.1.summary', 'Flexible scheduling for adults and families with busy weekday commitments.'); ?></p>
              <a class="read-more-link" onclick="toggleDescription(this)">Read More</a>
              <div class="training-description expandable-content">
                <span class="training-description-full"><?php echo display_text('programs', 'cards.1.description', 'Traditional karate training designed to fit your lifestyle. Weekend and evening classes accommodate work and school schedules while maintaining authentic instruction.'); ?></span>
              <div class="training-card-buttons">
                <?php 
                $card1_buttons = $programs_data['cards'][1]['buttons'] ?? [];
                foreach ($card1_buttons as $button): 
                  $btn_class = ($button['style'] === 'primary') ? 'training-btn-primary' : 'training-btn-secondary';
                ?>
                <a href="<?php echo htmlspecialchars($button['url'] ?? '#'); ?>" <?php echo (strpos($button['url'] ?? '', 'http') === 0) ? 'target="_blank"' : ''; ?> class="btn <?php echo $btn_class; ?>"><?php echo htmlspecialchars($button['text'] ?? 'Learn More'); ?> →</a>
                <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      
        <!-- Belt Exam -->
        <div class="col-lg-3 col-md-6 col-sm-6 col-6">
          <div class="training-card h-100">
            <div class="training-card-header">
              <h3><?php echo display_text('programs', 'cards.2.title', 'Belt Exams'); ?></h3>
            </div>
            <div class="training-card-image">
              <img src="<?php echo display_text('programs', 'cards.2.image', 'assets/images/panels/belts.png'); ?>" alt="<?php echo display_text('programs', 'cards.2.image_alt', 'Traditional karate belt exam process at Kaizen Karate'); ?>" class="card-image">
            </div>
            <div class="training-card-content">
              <p class="training-summary"><?php echo display_text('programs', 'cards.2.summary', 'Learn about our traditional belt examination and advancement process.'); ?></p>
              <a class="read-more-link" onclick="toggleDescription(this)">Read More</a>
              <div class="training-description expandable-content">
                <span class="training-description-full"><?php echo display_text('programs', 'cards.2.description', 'Belt exams are invitation-only and students must be invited by their instructor to test. Our rigorous testing ensures authentic skill development and progression.'); ?></span>
              <div class="training-card-buttons">
                <?php 
                $card2_buttons = $programs_data['cards'][2]['buttons'] ?? [];
                foreach ($card2_buttons as $button): 
                  $btn_class = ($button['style'] === 'primary') ? 'training-btn-primary' : 'training-btn-secondary';
                  $onclick = ($button['url'] === '#' || empty($button['url'])) ? 'onclick="return scrollToBeltExamRegister(event);"' : '';
                ?>
                <a href="<?php echo htmlspecialchars($button['url'] ?? '#'); ?>" <?php echo (strpos($button['url'] ?? '', 'http') === 0) ? 'target="_blank"' : ''; ?> <?php echo $onclick; ?> class="btn <?php echo $btn_class; ?>"><?php echo htmlspecialchars($button['text'] ?? 'Learn More'); ?> →</a>
                <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Online Store -->
        <div class="col-lg-3 col-md-6 col-sm-6 col-6">
          <div class="training-card h-100">
            <div class="training-card-header">
              <h3><?php echo display_text('programs', 'cards.3.title', 'Online Store'); ?></h3>
            </div>
            <div class="training-card-image">
              <img src="<?php echo display_text('programs', 'cards.3.image', 'assets/images/panels/online-store.jpg'); ?>" alt="<?php echo display_text('programs', 'cards.3.image_alt', 'Kaizen Karate online store for equipment and merchandise'); ?>" class="card-image">
            </div>
            <div class="training-card-content">
              <p class="training-summary"><?php echo display_text('programs', 'cards.3.summary', 'Quality karate equipment, uniforms, and Kaizen Karate merchandise.'); ?></p>
              <a class="read-more-link" onclick="toggleDescription(this)">Read More</a>
              <div class="training-description expandable-content">
                <span class="training-description-full"><?php echo display_text('programs', 'cards.3.description', 'Everything you need for your karate journey - from beginner gear to advanced equipment. Support your training with authentic, high-quality items.'); ?></span>
              <div class="training-card-buttons">
                <?php 
                $card3_buttons = $programs_data['cards'][3]['buttons'] ?? [];
                foreach ($card3_buttons as $button): 
                  $btn_class = ($button['style'] === 'primary') ? 'training-btn-primary' : 'training-btn-secondary';
                ?>
                <a href="<?php echo htmlspecialchars($button['url'] ?? '#'); ?>" <?php echo (strpos($button['url'] ?? '', 'http') === 0) ? 'target="_blank"' : ''; ?> class="btn <?php echo $btn_class; ?>"><?php echo htmlspecialchars($button['text'] ?? 'Learn More'); ?> →</a>
                <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>



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
<section id="about" class="about-dark-section">
  <div class="container-fluid">
    <div class="about-content-wrapper">
      <?php
      $about_data = get_content('about_section');
      $kaizen_section = $about_data['kaizen_section'] ?? [];
      $coach_v_section = $about_data['coach_v_section'] ?? [];
      ?>
      
      <!-- Coach V Image - Floated Left -->
      <img src="<?php echo htmlspecialchars($kaizen_section['coach_v_image'] ?? 'assets/images/about/coach-v-about.png'); ?>" 
           alt="<?php echo htmlspecialchars($kaizen_section['coach_v_image_alt'] ?? 'Coach V - Head Instructor at Kaizen Karate'); ?>" 
           class="coach-v-float-image">
      
      <h1 class="about-main-title mb-4"><?php echo display_text('about_section', 'kaizen_section.title', 'About Kaizen Karate'); ?></h1>
      
      <p class="about-lead">
        <?php echo htmlspecialchars($kaizen_section['lead_paragraph'] ?? 'Kaizen Karate was founded by Coach V in 2003. Kaizen Karate has been offering instruction in non-traditional Tang Soo Do as part of its core curriculum since its founding. Around 2010 Chinese Kenpo was introduced into the Kaizen curriculum.'); ?>
      </p>
      
      <p class="about-text">
        <?php echo htmlspecialchars($kaizen_section['paragraph_2'] ?? "Kaizen Karate's team of highly trained martial artists offer a number of programs for students starting as young as 3.5 years old up to adult. They focus on discipline and encouragement in a fun-loving environment. Their main goal is to help everyone progress, continually improve, and enjoy the process."); ?>
      </p>
      
      <p class="about-text">
        <?php echo htmlspecialchars($kaizen_section['paragraph_3'] ?? 'Kaizen Karate now operates 7 days per week throughout Maryland, Washington D.C., Virginia, and New York.'); ?>
      </p>

      <h2 class="about-section-title mt-5 mb-4"><?php echo display_text('about_section', 'coach_v_section.title', 'Meet Coach V'); ?></h2>
      
      <p class="about-text">
        <?php echo htmlspecialchars($coach_v_section['paragraph_1'] ?? '"Coach V" has 38 years of experience in the martial arts, having spent the majority of his life committed to the trade. He began his journey with karate at five years old and earned his first black belt in non-traditional Tang Soo Do in 1998 through Hill\'s Hitters Karate and Master Instructor Dr. Phillip Hill.'); ?>
      </p>
      
      <p class="about-text">
        <?php echo htmlspecialchars($coach_v_section['paragraph_2'] ?? 'Coach V went on to earn his business degree at the Robert H. Smith School of Business at the University of Maryland in College Park. He then continued his training in Kenpo under 8th degree black belt Sifu Greg Payne who also holds a 5th degree black belt in Shotokan as well as many other black belts in other arts including Goju ryu & Judo.'); ?>
      </p>
      
      <p class="about-text">
        <?php echo htmlspecialchars($coach_v_section['paragraph_3'] ?? 'In 2024, Coach V was promoted to 8th degree black belt in IKCA Chinese Kenpo by 10th degree black belt Senior Grandmaster Chuck Sullivan. Additionally, Coach V holds the rank of Nikyu (2nd degree brown belt) in Budoshin JuJitsu and studied Aikido at the ASU headquarters overseen by Saotome Sensei, Shihan.'); ?>
      </p>
      
      <p class="about-text">
        <?php echo htmlspecialchars($coach_v_section['paragraph_4'] ?? 'In his free time he enjoys spending time with his wife and children as well as running local long distance races which most recently included the Cherry Blossom 10 miler, Rock \'n\' Roll 1/2 Marathon, & Marine Corp Marathon in Washington, DC.'); ?>
      </p>
      
      <!-- Other Instructors Accordion -->
      <div class="about-instructors-section">
        <!-- Master Accordion Header -->
        <?php
        $team_section = $about_data['team_section'] ?? [];
        $instructors = $team_section['instructors'] ?? [];
        
        if (!empty($instructors)):
        ?>
        <div class="master-instructor-accordion">
          <button class="master-instructor-header">
            <h2 class="about-section-title mt-3 mb-4"><?php echo htmlspecialchars($team_section['title'] ?? 'Meet the Team'); ?></h2>
            <span class="master-accordion-icon" style="margin-top: -0.5rem;">▼</span>
          </button>
          
          <!-- Master Accordion Content -->
          <div class="master-instructor-content">
            <div class="instructors-accordion">
              <?php foreach ($instructors as $index => $instructor): 
                $instructor_id = $index + 1;
              ?>
              <div class="instructor-item">
                <button class="instructor-header" data-instructor="<?php echo $instructor_id; ?>">
                  <h3><?php echo htmlspecialchars($instructor['name'] ?? ''); ?> - <?php echo htmlspecialchars($instructor['title'] ?? 'Instructor'); ?></h3>
                  <span class="accordion-icon">+</span>
                </button>
                <div class="instructor-content" id="instructor-<?php echo $instructor_id; ?>">
                  <?php if (!empty($instructor['image'])): ?>
                    <img src="<?php echo htmlspecialchars($instructor['image']); ?>" 
                         alt="<?php echo htmlspecialchars($instructor['image_alt'] ?? $instructor['name'] ?? ''); ?>" 
                         class="instructor-profile-image">
                  <?php endif; ?>
                  
                  <?php 
                  $bio = $instructor['bio'] ?? [];
                  if (is_array($bio)) {
                    foreach ($bio as $paragraph) {
                      if (!empty($paragraph)) {
                        echo '<p class="about-text">' . $paragraph . '</p>';
                      }
                    }
                  }
                  ?>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

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
<section id="summer-camp" class="py-5" style="background-color: #f8f9fa;">
  <div class="container">
    <h2 class="text-center mb-4 summer-camp-title"><?php echo display_text('summer_camp', 'basic_info.title', 'Summer Camp 2025'); ?></h2>
    <p class="text-center mb-2 summer-camp-subtitle"><?php echo display_text('summer_camp', 'basic_info.subtitle', '4 campsites for campers ages 5-12'); ?></p>
    
    <!-- Early Registration Special Offer -->
    <?php if ($special_offer['enabled'] ?? false): ?>
    <div class="text-center mb-5">
      <div style="background: linear-gradient(135deg, rgba(220, 53, 69, 0.12), rgba(220, 53, 69, 0.06)); border: 3px solid rgba(220, 53, 69, 0.4); border-radius: 16px; padding: 2rem; text-align: center; position: relative; box-shadow: 0 8px 25px rgba(220, 53, 69, 0.15);">
        <!-- Special Offer Badge -->
        <div style="position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: linear-gradient(135deg, #dc3545, #c82333); color: white; padding: 8px 20px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);">
          <i class="fas fa-star" style="margin-right: 6px;"></i><?php echo display_text('summer_camp', 'special_offer.badge_text', 'SPECIAL OFFER - SAVE $150 PER WEEK'); ?>
      </div>
        
        <!-- Main Content -->
        <div style="margin-top: 15px;">
          <!-- Deadline -->
          <div style="margin-bottom: 20px;">
            <i class="fas fa-calendar-alt" style="color: #dc3545; font-size: 1.5rem; margin-bottom: 8px;"></i>
            <h4 style="color: #dc3545; font-weight: 700; margin-bottom: 8px; font-size: 1.3rem;"><?php echo display_text('summer_camp', 'special_offer.deadline_label', 'Early Registration Deadline'); ?></h4>
            <p style="color: #dc3545; font-weight: 600; font-size: 1.1rem; margin: 0;"><?php echo display_text('summer_camp', 'special_offer.deadline_date', 'March 31st, 2025'); ?></p>
      </div>
          
          <!-- Free Care Benefit -->
          <div style="margin-bottom: 20px; padding: 20px; background: linear-gradient(135deg, rgba(40, 167, 69, 0.2), rgba(40, 167, 69, 0.1)); border: 3px solid #28a745; border-radius: 16px; position: relative; box-shadow: 0 6px 20px rgba(40, 167, 69, 0.25);">
            <!-- FREE Badge -->
            <div style="position: absolute; top: -15px; right: 20px; background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 6px 16px; border-radius: 15px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 3px 10px rgba(40, 167, 69, 0.4);">
              <i class="fas fa-check-circle" style="margin-right: 4px;"></i><?php echo display_text('summer_camp', 'special_offer.free_badge_text', '100% FREE'); ?>
            </div>
            
            <div style="text-align: center;">
              <i class="fas fa-clock" style="color: #28a745; font-size: 2.5rem; margin-bottom: 15px; text-shadow: 0 2px 4px rgba(40, 167, 69, 0.3);"></i>
              <h3 style="color: #28a745; font-weight: 800; margin-bottom: 12px; font-size: 1.6rem; text-shadow: 0 1px 2px rgba(40, 167, 69, 0.2); text-transform: uppercase;"><?php echo display_text('summer_camp', 'special_offer.free_care_heading', 'FREE BEFORE & AFTER CARE'); ?></h3>
              <p style="color: #28a745; font-weight: 700; font-size: 1.2rem; margin: 0; text-shadow: 0 1px 2px rgba(40, 167, 69, 0.2);"><?php echo display_text('summer_camp', 'special_offer.free_care_description', 'For ALL weeks when you register before March 31st, 2025'); ?></p>
            </div>
          </div>
          
        </div>
      </div>
    </div>
    <?php endif; ?>
    
    <!-- Summer Camp Features & Video -->
    <div class="row align-items-stretch mb-5">
      <!-- Left Column: Feature Icons -->
      <div class="col-lg-5 col-md-6 mb-4 mb-md-0">
        <div class="camp-features-standalone">
          <?php foreach ($features as $feature): ?>
          <div class="feature-item" onclick="<?php echo htmlspecialchars($feature['onclick'] ?? ''); ?>" style="cursor: pointer;">
            <div class="feature-icon-circle">
              <i class="<?php echo htmlspecialchars($feature['icon'] ?? 'fas fa-star'); ?>"></i>
            </div>
            <span class="feature-text"><?php echo htmlspecialchars($feature['text'] ?? ''); ?></span>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      
      <!-- Right Column: Video -->
      <div class="col-lg-7 col-md-6">
        <div class="summer-camp-video-container" onclick="<?php echo htmlspecialchars($video['onclick'] ?? 'openSummerCampVideo()'); ?>">
          <img src="<?php echo htmlspecialchars($video['thumbnail'] ?? 'assets/images/summer-camp/video-thumb.png'); ?>" alt="<?php echo htmlspecialchars($video['thumbnail_alt'] ?? 'Summer Camp Video Preview'); ?>" class="summer-camp-video-thumbnail">
          <div class="video-play-overlay">
            <div class="play-button">
              <i class="fas fa-play"></i>
          </div>
            <div class="video-overlay-text">
              <h4><?php echo htmlspecialchars($video['overlay_title'] ?? 'Watch Our Summer Camp Experience'); ?></h4>
              <p><?php echo htmlspecialchars($video['overlay_description'] ?? 'See what makes Kaizen Summer Camp special'); ?></p>
            </div>
            <div class="video-overlay-logo">
              <img src="assets/images/logo.png" alt="Kaizen Karate" class="overlay-logo">
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
      
      <!-- Camp Locations -->
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="camp-info-highlight">
            <div class="text-center mb-4">
              <h3 class="summer-camp-section-title">Camp Locations</h3>
              <p class="summer-camp-section-subtitle">Choose from 4 convenient locations across the DC metro area</p>
            </div>
            
            <div class="row justify-content-center">
              <div class="col-lg-10 col-xl-9">
                <div class="row justify-content-center">
                  <?php foreach ($camp_locations as $location): ?>
                  <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 px-2">
                    <div class="campsite-card">
                      <div class="campsite-header">
                        <h3 class="campsite-title"><?php echo htmlspecialchars($location['title'] ?? ''); ?></h3>
                        <div class="campsite-divider"></div>
                      </div>
                      <div class="campsite-content">
                        <p class="campsite-venue"><?php echo htmlspecialchars($location['venue'] ?? ''); ?></p>
                        <p class="campsite-address"><?php echo $location['address'] ?? ''; ?></p>
                        <div class="campsite-dates">
                          <span class="campsite-duration"><?php echo htmlspecialchars($location['duration'] ?? ''); ?></span>
                          <span class="campsite-weeks"><?php echo htmlspecialchars($location['weeks'] ?? ''); ?></span>
                        </div>
                        <div class="campsite-buttons">
                          <a href="<?php echo htmlspecialchars($location['new_families_url'] ?? '#'); ?>" class="campsite-btn campsite-btn-primary" target="_blank">Register - New Families</a>
                          <a href="<?php echo htmlspecialchars($location['returning_families_url'] ?? '#'); ?>" class="campsite-btn campsite-btn-secondary" target="_blank">Register - Returning Families</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php endforeach; ?>
                </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Registration Information -->
      <div class="row justify-content-center mt-3">
        <div class="col-lg-8 col-xl-7">
            <div class="text-center mb-4">
              <h3 class="registration-clean-title">Registration Information</h3>
            </div>
            
          <div class="registration-consolidated-card">
            <!-- Essential Camp Details -->
            <div class="clean-camp-details text-center mb-4">
                    <div class="clean-detail-item">
                      <i class="fas fa-child"></i>
                      <span><?php echo htmlspecialchars($registration_info['age_range'] ?? 'Ages 5-12 years old'); ?></span>
                    </div>
                    <div class="clean-detail-item">
                      <i class="fas fa-exclamation-triangle"></i>
                      <span><?php echo htmlspecialchars($registration_info['space_notice'] ?? 'Space is limited'); ?></span>
                </div>
              </div>
              
            <!-- Registration Actions -->
            <div class="text-center">
                  <h4 class="clean-registration-header"><?php echo htmlspecialchars($registration_info['header_text'] ?? 'Ready to Register?'); ?></h4>
                  <p class="clean-registration-subtext"><?php echo htmlspecialchars($registration_info['subtext'] ?? 'Choose your registration option below'); ?></p>
                  
                  <div class="clean-registration-buttons">
                    <a href="<?php echo htmlspecialchars($registration_info['new_families_url'] ?? 'https://kaizenkarate.campmanagement.com/p/request_for_info_m.php?action=enroll'); ?>" target="_blank" class="clean-register-btn new-families">
                      <i class="fas fa-user-plus"></i>
                      <span>Register Here - New Families</span>
                    </a>
                    <a href="<?php echo htmlspecialchars($registration_info['returning_families_url'] ?? 'https://kaizenkarate.campmanagement.com/p/campers/login_m.php'); ?>" target="_blank" class="clean-register-btn returning-families">
                      <i class="fas fa-sign-in-alt"></i>
                      <span>Register Here - Returning Families</span>
                    </a>
              </div>
            </div>
              </div>
    </div>

      <!-- Summer Camp Information Accordion -->
      <div class="row justify-content-center mt-2">
        <div class="col-lg-10">
            <!-- Master Accordion Header -->
            <div class="master-instructor-accordion">
            <!-- Master Accordion Header (Static) -->
            <div class="master-instructor-header-static text-center">
              <h2 class="about-section-title mt-2 mb-3">More Information about Summer Camp 2026</h2>
            </div>
              
              <!-- Master Accordion Content (Always Visible) -->
              <div class="master-instructor-content-visible">
                <div class="instructors-accordion">
                  <?php if (!empty($accordion_sections)): ?>
                    <?php foreach ($accordion_sections as $index => $section): ?>
                    <div class="instructor-item">
                      <button class="instructor-header" data-instructor="camp<?php echo $index + 1; ?>">
                        <h3><?php echo htmlspecialchars($section['title'] ?? ''); ?></h3>
                        <span class="accordion-icon">+</span>
                      </button>
                      <div class="instructor-content" id="instructor-camp<?php echo $index + 1; ?>">
                        <div style="color: var(--text-dark);">
                          <?php echo $section['content'] ?? ''; ?>
                        </div>
                      </div>
                    </div>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>
              </div>
            </div>
        </div>
      </div>
 
    </div>
  </section>


<!-- Kaizen Dojo Section -->
<section id="kaizen-dojo" class="kaizen-dojo-section py-5">
  <div class="container">
    <h2 class="text-center mb-4" style="display:none;">Kaizen Dojo</h2>
    <div class="row align-items-center dojo-hero mb-4">
      <?php
      $hero_data = get_content('kaizen_dojo', 'hero');
      ?>
      <div class="col-md-3 text-center text-md-start mb-3 mb-md-0">
        <img src="<?php echo $hero_data['logo'] ?? 'assets/images/dojo/Kaizen-Dojo-Logo.webp'; ?>" alt="Kaizen Dojo" class="dojo-logo" />
      </div>
      <div class="col-md-9">
        <h1 class="kaizen-dojo-title"><?php echo $hero_data['title'] ?? 'KAIZEN DOJO'; ?></h1>
        <p class="dojo-intro">
          <?php echo $hero_data['description'] ?? '<strong>Kaizen Dojo</strong> is an after school program operated by <strong>Kaizen Karate</strong>. We are located at 9545 Georgia Ave, Silver Spring, MD 20910 (near the beltway exits). Students will take part in daily karate lessons, snack time, homework time, and more! We provide service throughout the entire 2025-2026 school year. Please note, we follow the MCPS calendar. Service will be provided on 1/2 days.'; ?>
        </p>
      </div>
    </div>
    <div class="dojo-van-wrap">
      <img src="assets/images/dojo/dojo-van.png" alt="Kaizen Dojo Van" class="dojo-van" />
    </div>

            <!-- Van Service Panel - Full Width Row -->
            <div class="row g-4 mb-4">
              <div class="col-12">
                <div class="dojo-card">
                  <?php
                  $van_service_data = get_content('kaizen_dojo', 'van_service');
                  $locations = $van_service_data['locations'] ?? [];
                  ?>
                  <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                    <div class="dojo-card-icon" style="margin: 0 15px 0 0;"><i class="fas fa-bus"></i></div>
                    <h3 class="dojo-card-title" style="font-size: 1.8rem; margin: 0;"><?php echo $van_service_data['title'] ?? 'Van Service — Locations'; ?></h3>
                  </div>
                  <?php if (!empty($van_service_data['description'])): ?>
                  <p style="text-align: center; margin-bottom: 25px; color: #555; font-style: italic;">
                    <?php echo htmlspecialchars($van_service_data['description']); ?>
                  </p>
                  <?php endif; ?>
                  <div class="row g-3 mt-2">
                    <?php
                    foreach ($locations as $location):
                      $is_new = $location['is_new'] ?? false;
                      $badge_text = $location['badge_text'] ?? '';
                      $school_name = $location['school_name'] ?? '';
                      
                      if ($is_new):
                        // Use provided badge text or default to "NEW"
                        $display_badge = !empty($badge_text) ? $badge_text : 'NEW';
                    ?>
                    <div class="col-md-4">
                      <div style="background: rgba(255, 193, 7, 0.1); border: 1px solid rgba(255, 193, 7, 0.3); border-radius: 12px; padding: 1.5rem; text-align: center; position: relative;">
                        <i class="fas fa-star" style="position: absolute; top: 10px; right: 10px; color: #ffc107; font-size: 1rem;"></i>
                        <i class="fas fa-map-marker-alt" style="color: #dc3545; font-size: 1.5rem; margin-bottom: 0.8rem; display: block;"></i>
                        <h5 style="margin: 0; font-weight: 600; color: #333; font-size: 1.1rem;"><?php echo htmlspecialchars($school_name); ?></h5>
                        <span style="font-size: 0.8rem; color: #ffc107; font-weight: 600;"><?php echo htmlspecialchars($display_badge); ?></span>
                      </div>
                    </div>
                    <?php else: ?>
                    <div class="col-md-4">
                      <div style="background: rgba(220, 53, 69, 0.1); border: 1px solid rgba(220, 53, 69, 0.2); border-radius: 12px; padding: 1.5rem; text-align: center;">
                        <i class="fas fa-map-marker-alt" style="color: #dc3545; font-size: 1.5rem; margin-bottom: 0.8rem; display: block;"></i>
                        <h5 style="margin: 0; font-weight: 600; color: #333; font-size: 1.1rem;"><?php echo htmlspecialchars($school_name); ?></h5>
                      </div>
                    </div>
                    <?php 
                      endif;
                    endforeach; 
                    ?>
                  </div>
                  
                  <!-- No Van Service Option Alert -->
                  <div style="background: rgba(108, 117, 125, 0.08); border: 1px solid rgba(108, 117, 125, 0.2); border-radius: 12px; padding: 1.5rem; margin-top: 20px; position: relative;">
                    <div style="margin-bottom: 10px;">
                      <h6 style="color: #6c757d; margin: 0 0 10px 0; font-weight: 600; font-size: 1rem; font-style: italic;">No Van Service Option</h6>
                      <p style="margin: 0 0 10px 0; color: #555; line-height: 1.5; font-size: 0.85rem;">
                        If you are not using our van service, students can be dropped off directly at <strong>Calvary Lutheran Church, 9545 Georgia Ave, Silver Spring, MD 20910</strong>, for their classes. Parents are responsible for arranging their child's transportation to and from this location.
                      </p>
                      <div style="background: rgba(255, 193, 7, 0.1); border-left: 4px solid #ffc107; padding: 10px 12px; border-radius: 6px;">
                        <p style="margin: 0; color: #856404; font-weight: 600; font-size: 0.8rem;">
                          <i class="fas fa-info-circle" style="margin-right: 6px; color: #ffc107; font-size: 0.8rem;"></i>
                          A prorated tuition rate will apply for families who choose not to use van service. Please <a href="#contact" style="color: #dc3545; text-decoration: none; font-weight: 700;">contact us</a> for exact pricing based on your start date.
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Other Services Row -->
            <div class="row g-4">
          <?php
          $service_cards = get_content('kaizen_dojo', 'service_cards', []);
          foreach ($service_cards as $card):
            $icon = $card['icon'] ?? 'fas fa-star';
            $title = $card['title'] ?? '';
            $description = $card['description'] ?? '';
          ?>
          <div class="col-md-4">
            <div class="dojo-card">
              <div class="dojo-card-icon"><i class="<?php echo htmlspecialchars($icon); ?>"></i></div>
              <h3 class="dojo-card-title"><?php echo htmlspecialchars($title); ?></h3>
              <p class="dojo-card-text"><?php echo htmlspecialchars($description); ?></p>
            </div>
          </div>
          <?php endforeach; ?>
        </div>

        <div class="dojo-register-button-container">
          <a href="https://form.jotform.com/251533593606459" target="_blank" class="btn dojo-register-btn">
            <?php echo $hero_data['registration_button_text'] ?? 'Register for Kaizen Dojo'; ?>
          </a>
        </div>

            <div class="dojo-accordion mt-4">
          <details class="dojo-accordion-item">
            <?php
            $accordion_data = get_content('kaizen_dojo', 'accordion');
            $van_service_accordion = $accordion_data['van_service'] ?? [];
            ?>
            <summary><?php echo $van_service_accordion['title'] ?? 'Van Service'; ?></summary>
            <div class="dojo-accordion-content">
              <div style="color: #555; line-height: 1.6;">
                <p style="margin-bottom: 2rem; font-size: 1.1rem; text-align: center;">Convenient van service available from multiple school locations directly to Kaizen Dojo:</p>
                
                <!-- Current Locations -->
                <div style="background: rgba(220, 53, 69, 0.08); border: 1px solid rgba(220, 53, 69, 0.2); border-radius: 12px; padding: 2rem; margin-bottom: 2rem;">
                  <h4 style="color: #dc3545; margin-bottom: 1.5rem; font-size: 1.3rem; text-align: center;">
                    <i class="fas fa-bus" style="margin-right: 0.5rem;"></i>Current Van Service Locations
                  </h4>
                  
                  <div style="background: rgba(255, 255, 255, 0.6); border-radius: 8px; padding: 1.5rem; margin-bottom: 1.5rem;">
                    <p style="margin-bottom: 1rem; font-size: 0.95rem; color: #333;">Van service is now available from these locations. We pick up students directly at each site and bring them back to the dojo:</p>
                    <div class="row g-3">
                      <div class="col-md-4">
                        <div style="background: white; border: 1px solid rgba(220, 53, 69, 0.15); border-radius: 8px; padding: 1rem; text-align: center;">
                          <i class="fas fa-school" style="color: #dc3545; margin-bottom: 0.5rem; font-size: 1.2rem;"></i>
                          <p style="margin: 0; font-weight: 600; color: #333;">Sligo Creek ES</p>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div style="background: white; border: 1px solid rgba(220, 53, 69, 0.15); border-radius: 8px; padding: 1rem; text-align: center;">
                          <i class="fas fa-school" style="color: #dc3545; margin-bottom: 0.5rem; font-size: 1.2rem;"></i>
                          <p style="margin: 0; font-weight: 600; color: #333;">East Silver Spring ES</p>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div style="background: white; border: 1px solid rgba(220, 53, 69, 0.15); border-radius: 8px; padding: 1rem; text-align: center;">
                          <i class="fas fa-school" style="color: #dc3545; margin-bottom: 0.5rem; font-size: 1.2rem;"></i>
                          <p style="margin: 0; font-weight: 600; color: #333;">Woodlin ES</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div style="background: rgba(40, 167, 69, 0.1); border: 1px solid rgba(40, 167, 69, 0.3); border-radius: 8px; padding: 1rem;">
                    <p style="margin: 0; font-size: 0.9rem; color: #28a745; font-weight: 600; text-align: center;">
                      <i class="fas fa-info-circle" style="margin-right: 0.5rem;"></i>Parents must pick up directly from Kaizen Dojo
                    </p>
                  </div>
                </div>

                <!-- New Locations Fall 2025 -->
                <div style="background: rgba(255, 193, 7, 0.1); border: 1px solid rgba(255, 193, 7, 0.3); border-radius: 12px; padding: 2rem; margin-bottom: 2rem;">
                  <h4 style="color: #ffc107; margin-bottom: 1.5rem; font-size: 1.3rem; text-align: center;">
                    <i class="fas fa-plus-circle" style="margin-right: 0.5rem;"></i>NEW Fall 2025 Locations
                  </h4>
                  
                  <div style="background: rgba(255, 255, 255, 0.7); border-radius: 8px; padding: 1.5rem; margin-bottom: 1.5rem;">
                    <p style="margin-bottom: 1rem; font-size: 0.95rem; color: #333;">Starting in Fall 2025, we are adding 3 new pick-up locations!</p>
                    <div class="row g-3">
                      <div class="col-md-4">
                        <div style="background: white; border: 1px solid rgba(255, 193, 7, 0.3); border-radius: 8px; padding: 1rem; text-align: center;">
                          <i class="fas fa-star" style="color: #ffc107; margin-bottom: 0.5rem; font-size: 1.2rem;"></i>
                          <p style="margin: 0; font-weight: 600; color: #333;">Oakland Terrace ES</p>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div style="background: white; border: 1px solid rgba(255, 193, 7, 0.3); border-radius: 8px; padding: 1rem; text-align: center;">
                          <i class="fas fa-star" style="color: #ffc107; margin-bottom: 0.5rem; font-size: 1.2rem;"></i>
                          <p style="margin: 0; font-weight: 600; color: #333;">Piney Branch ES</p>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div style="background: white; border: 1px solid rgba(255, 193, 7, 0.3); border-radius: 8px; padding: 1rem; text-align: center;">
                          <i class="fas fa-star" style="color: #ffc107; margin-bottom: 0.5rem; font-size: 1.2rem;"></i>
                          <p style="margin: 0; font-weight: 600; color: #333;">Takoma Park ES</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Notice Section -->
                <?php 
                $notice_data = $van_service_accordion['notice'] ?? [];
                $notice_enabled = $notice_data['enabled'] ?? true;
                if ($notice_enabled): 
                  $notice_title = $notice_data['title'] ?? 'Limited Space Available';
                  $notice_message = $notice_data['message'] ?? 'Space is limited! If you are interested in registering for Kaizen Dojo van service for Fall 2025, please contact us ASAP.';
                  $notice_email = $notice_data['contact_email'] ?? 'coach.v@kaizenkarateusa.com';
                ?>
                <div style="background: rgba(220, 53, 69, 0.1); border: 1px solid rgba(220, 53, 69, 0.3); border-radius: 12px; padding: 2rem;">
                  <h4 style="color: #dc3545; margin-bottom: 1.5rem; font-size: 1.3rem; text-align: center;">
                    <i class="fas fa-exclamation-triangle" style="margin-right: 0.5rem;"></i><?php echo htmlspecialchars($notice_title); ?>
                  </h4>
                  
                  <div style="background: rgba(255, 255, 255, 0.6); border-radius: 8px; padding: 1.5rem;">
                    <p style="margin-bottom: 1rem; font-size: 1rem; color: #333; text-align: center; font-weight: 600;"><?php echo htmlspecialchars($notice_message); ?></p>
                    
                    <div style="background: white; border: 2px solid #dc3545; border-radius: 8px; padding: 1rem; text-align: center;">
                      <p style="margin: 0; font-size: 0.95rem; color: #333;">
                        <i class="fas fa-envelope" style="color: #dc3545; margin-right: 0.5rem;"></i>
                        Questions? Email: <strong style="color: #dc3545;"><?php echo htmlspecialchars($notice_email); ?></strong>
                      </p>
                    </div>
                  </div>
                </div>
                <?php endif; ?>
              </div>
            </div>
          </details>
          <details class="dojo-accordion-item">
            <?php $tuition_data = $accordion_data['tuition_payment'] ?? []; ?>
            <summary><?php echo $tuition_data['title'] ?? 'Tuition and Payment Options'; ?></summary>
            <div class="dojo-accordion-content">
              <div style="color: #555; line-height: 1.6;">
                <p style="margin-bottom: 2rem; font-size: 1.1rem; text-align: center;"><?php echo $tuition_data['additional_notes'] ?? 'Flexible payment options designed to fit your family\'s schedule and budget:'; ?></p>
                
                <!-- Regular Service Options -->
                <div style="background: rgba(220, 53, 69, 0.08); border: 1px solid rgba(220, 53, 69, 0.2); border-radius: 12px; padding: 2rem; margin-bottom: 2rem;">
                  <h4 style="color: #dc3545; margin-bottom: 1.5rem; font-size: 1.3rem; text-align: center;">
                    <i class="fas fa-dollar-sign" style="margin-right: 0.5rem;"></i>Monthly Tuition Options
                  </h4>
                  
                  <?php
                  // Use structured pricing fields directly from admin (NO TEXT PARSING)
                  $pricing = $tuition_data['pricing'] ?? [];
                  $pricing_data = [
                    'full_time' => [
                      'price' => $pricing['full_time'] ?? '$460', 
                      'days' => '5 days per week'
                    ],
                    'part_time_4' => [
                      'price' => $pricing['part_time_4'] ?? '$410', 
                      'days' => '4 days per week'
                    ],
                    'part_time_3' => [
                      'price' => $pricing['part_time_3'] ?? '$310', 
                      'days' => '3 days per week'
                    ],
                    'part_time_2' => [
                      'price' => $pricing['part_time_2'] ?? '$210', 
                      'days' => '2 days per week'
                    ],
                    'part_time_1' => [
                      'price' => $pricing['part_time_1'] ?? '$110', 
                      'days' => '1 day per week'
                    ]
                  ];
                  ?>
                  
                  <div class="row g-3">
                    <!-- Full-time -->
                    <div class="col-lg-6">
                      <div style="background: linear-gradient(135deg, rgba(40, 167, 69, 0.1), rgba(40, 167, 69, 0.05)); border: 2px solid rgba(40, 167, 69, 0.3); border-radius: 12px; padding: 1.5rem; text-align: center; position: relative;">
                        <div style="position: absolute; top: -10px; right: 15px; background: #28a745; color: white; padding: 4px 12px; border-radius: 15px; font-size: 0.8rem; font-weight: 600;">MOST POPULAR</div>
                        <i class="fas fa-star" style="color: #28a745; font-size: 2rem; margin-bottom: 1rem;"></i>
                        <h5 style="color: #28a745; margin-bottom: 0.5rem; font-size: 1.2rem; font-weight: 700;">Full-time Service</h5>
                        <p style="margin-bottom: 1rem; font-size: 0.9rem; color: #666;"><?php echo $pricing_data['full_time']['days']; ?></p>
                        <div style="font-size: 2rem; font-weight: 700; color: #28a745; margin-bottom: 0.5rem;"><?php echo $pricing_data['full_time']['price']; ?></div>
                        <p style="margin: 0; font-size: 0.85rem; color: #666;">per month</p>
                      </div>
                    </div>
                    
                    <!-- Part-time 4 days -->
                    <div class="col-lg-6">
                      <div style="background: rgba(255, 255, 255, 0.8); border: 1px solid rgba(220, 53, 69, 0.15); border-radius: 12px; padding: 1.5rem; text-align: center;">
                        <i class="fas fa-calendar-alt" style="color: #dc3545; font-size: 2rem; margin-bottom: 1rem;"></i>
                        <h5 style="color: #dc3545; margin-bottom: 0.5rem; font-size: 1.2rem; font-weight: 700;">Part-time Service</h5>
                        <p style="margin-bottom: 1rem; font-size: 0.9rem; color: #666;"><?php echo $pricing_data['part_time_4']['days']; ?></p>
                        <div style="font-size: 2rem; font-weight: 700; color: #dc3545; margin-bottom: 0.5rem;"><?php echo $pricing_data['part_time_4']['price']; ?></div>
                        <p style="margin: 0; font-size: 0.85rem; color: #666;">per month</p>
                      </div>
                    </div>
                  </div>
                  
                  <div class="row g-3 mt-2">
                    <!-- Part-time 3 days -->
                    <div class="col-lg-4">
                      <div style="background: rgba(255, 255, 255, 0.8); border: 1px solid rgba(220, 53, 69, 0.15); border-radius: 12px; padding: 1.5rem; text-align: center;">
                        <i class="fas fa-calendar-week" style="color: #6c757d; font-size: 1.5rem; margin-bottom: 1rem;"></i>
                        <h6 style="color: #6c757d; margin-bottom: 0.5rem; font-size: 1rem; font-weight: 600;">3 days per week</h6>
                        <div style="font-size: 1.5rem; font-weight: 700; color: #6c757d; margin-bottom: 0.5rem;"><?php echo $pricing_data['part_time_3']['price']; ?></div>
                        <p style="margin: 0; font-size: 0.8rem; color: #666;">per month</p>
                      </div>
                    </div>
                    
                    <!-- Part-time 2 days -->
                    <div class="col-lg-4">
                      <div style="background: rgba(255, 255, 255, 0.8); border: 1px solid rgba(220, 53, 69, 0.15); border-radius: 12px; padding: 1.5rem; text-align: center;">
                        <i class="fas fa-calendar-day" style="color: #6c757d; font-size: 1.5rem; margin-bottom: 1rem;"></i>
                        <h6 style="color: #6c757d; margin-bottom: 0.5rem; font-size: 1rem; font-weight: 600;">2 days per week</h6>
                        <div style="font-size: 1.5rem; font-weight: 700; color: #6c757d; margin-bottom: 0.5rem;"><?php echo $pricing_data['part_time_2']['price']; ?></div>
                        <p style="margin: 0; font-size: 0.8rem; color: #666;">per month</p>
                      </div>
                    </div>
                    
                    <!-- Part-time 1 day -->
                    <div class="col-lg-4">
                      <div style="background: rgba(255, 255, 255, 0.8); border: 1px solid rgba(220, 53, 69, 0.15); border-radius: 12px; padding: 1.5rem; text-align: center;">
                        <i class="fas fa-calendar" style="color: #6c757d; font-size: 1.5rem; margin-bottom: 1rem;"></i>
                        <h6 style="color: #6c757d; margin-bottom: 0.5rem; font-size: 1rem; font-weight: 600;">1 day per week</h6>
                        <div style="font-size: 1.5rem; font-weight: 700; color: #6c757d; margin-bottom: 0.5rem;"><?php echo $pricing_data['part_time_1']['price']; ?></div>
                        <p style="margin: 0; font-size: 0.8rem; color: #666;">per month</p>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Drop-in Service -->
                <div style="background: rgba(255, 193, 7, 0.1); border: 1px solid rgba(255, 193, 7, 0.3); border-radius: 12px; padding: 2rem;">
                  <h4 style="color: #ffc107; margin-bottom: 1.5rem; font-size: 1.3rem; text-align: center;">
                    <i class="fas fa-clock" style="margin-right: 0.5rem;"></i>Drop-in Service Option
                  </h4>
                  
                  <div style="background: rgba(255, 255, 255, 0.7); border-radius: 8px; padding: 1.5rem;">
                    <?php
                    // Use structured drop-in pricing field directly (NO TEXT PARSING)
                    $drop_in_price = $pricing['drop_in'] ?? '$30';
                    $drop_in_notice = 'We request an email at least 24hrs in advance when possible or call our office directly.';
                    ?>
                    <div class="row align-items-center">
                      <div class="col-md-6 text-center">
                        <div style="background: white; border: 2px solid #ffc107; border-radius: 12px; padding: 1.5rem; margin-bottom: 1rem;">
                          <i class="fas fa-hand-holding-usd" style="color: #ffc107; font-size: 2rem; margin-bottom: 1rem;"></i>
                          <div style="font-size: 2.5rem; font-weight: 700; color: #ffc107; margin-bottom: 0.5rem;"><?php echo $drop_in_price; ?></div>
                          <p style="margin: 0; font-size: 1rem; color: #333; font-weight: 600;">per day</p>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div style="background: rgba(220, 53, 69, 0.1); border: 1px solid rgba(220, 53, 69, 0.3); border-radius: 8px; padding: 1rem;">
                          <h6 style="color: #dc3545; margin-bottom: 0.5rem; font-size: 1rem;">
                            <i class="fas fa-exclamation-circle" style="margin-right: 0.5rem;"></i>Advance Notice Required
                          </h6>
                          <p style="margin: 0; font-size: 0.9rem; color: #333;"><?php echo htmlspecialchars($drop_in_notice); ?></p>
                        </div>
                      </div>
                    </div>
                  </div>
                  </div>
                </div>
              </div>
            </div>
          </details>
          <details class="dojo-accordion-item">
            <?php $security_data = $accordion_data['security_safety'] ?? []; ?>
            <summary><?php echo $security_data['title'] ?? 'Security, Discipline and Safety'; ?></summary>
            <div class="dojo-accordion-content">
              <?php echo $security_data['content'] ?? '<div style="color: #555; line-height: 1.6;"><p>Security and safety information will be managed through the admin panel.</p></div>'; ?>
            </div>
          </details>
          <details class="dojo-accordion-item">
            <?php $contact_data = $accordion_data['contact_info'] ?? []; ?>
            <summary><?php echo $contact_data['title'] ?? 'Contact Information'; ?></summary>
            <div class="dojo-accordion-content">
              <div style="color: #555; line-height: 1.6;">
                <p style="margin-bottom: 2rem; font-size: 1.1rem; text-align: center;">Get in touch with our Kaizen Dojo team for questions, enrollment, or support:</p>
                
                <!-- Primary Contact Methods -->
                <div style="background: rgba(220, 53, 69, 0.08); border: 1px solid rgba(220, 53, 69, 0.2); border-radius: 12px; padding: 2rem; margin-bottom: 2rem;">
                  <h4 style="color: #dc3545; margin-bottom: 1.5rem; font-size: 1.3rem; text-align: center;">
                    <i class="fas fa-headset" style="margin-right: 0.5rem;"></i><?php echo $contact_data['primary_contact_name'] ?? 'Coach V'; ?>
                  </h4>
                  
                  <div class="row g-4">
                    <!-- Email Contact -->
                    <div class="col-md-6">
                      <div style="background: white; border: 2px solid rgba(220, 53, 69, 0.2); border-radius: 12px; padding: 2rem; text-align: center; height: 100%;">
                        <i class="fas fa-envelope" style="color: #dc3545; font-size: 3rem; margin-bottom: 1.5rem;"></i>
                        <h5 style="color: #dc3545; margin-bottom: 1rem; font-size: 1.2rem; font-weight: 700;">Email Us</h5>
                        <div style="background: rgba(220, 53, 69, 0.05); border-radius: 8px; padding: 1rem; margin-bottom: 1rem;">
                          <a href="mailto:<?php echo $contact_data['primary_contact_email'] ?? 'coach.v@kaizenkarateusa.com'; ?>" style="color: #dc3545; text-decoration: none; font-weight: 600; font-size: 1.1rem;">
                            <?php echo $contact_data['primary_contact_email'] ?? 'coach.v@kaizenkarateusa.com'; ?>
                          </a>
                        </div>
                        <p style="margin: 0; font-size: 0.9rem; color: #666; font-style: italic;">Preferred method for questions and enrollment</p>
                      </div>
                    </div>
                    
                    <!-- Phone Contact -->
                    <div class="col-md-6">
                      <div style="background: white; border: 2px solid rgba(40, 167, 69, 0.2); border-radius: 12px; padding: 2rem; text-align: center; height: 100%;">
                        <i class="fas fa-phone" style="color: #28a745; font-size: 3rem; margin-bottom: 1.5rem;"></i>
                        <h5 style="color: #28a745; margin-bottom: 1rem; font-size: 1.2rem; font-weight: 700;">Call Us</h5>
                        <div style="background: rgba(40, 167, 69, 0.05); border-radius: 8px; padding: 1rem; margin-bottom: 1rem;">
                          <a href="tel:<?php echo str_replace(['(', ')', ' ', '-'], '', $contact_data['primary_contact_phone'] ?? '(301) 938-2711'); ?>" style="color: #28a745; text-decoration: none; font-weight: 600; font-size: 1.4rem;">
                            <?php echo $contact_data['primary_contact_phone'] ?? '(301) 938-2711'; ?>
                          </a>
                        </div>
                        <p style="margin: 0; font-size: 0.9rem; color: #666; font-style: italic;">For urgent matters and direct communication</p>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Location Information -->
                <div style="background: rgba(0, 123, 255, 0.08); border: 1px solid rgba(0, 123, 255, 0.2); border-radius: 12px; padding: 2rem; margin-bottom: 2rem;">
                  <h4 style="color: #007bff; margin-bottom: 1.5rem; font-size: 1.3rem; text-align: center;">
                    <i class="fas fa-map-marker-alt" style="margin-right: 0.5rem;"></i>Kaizen Dojo Location
                  </h4>
                  
                  <div style="background: rgba(255, 255, 255, 0.7); border-radius: 8px; padding: 1.5rem;">
                    <div class="row align-items-center">
                      <div class="col-md-8">
                        <div style="background: white; border: 1px solid rgba(0, 123, 255, 0.2); border-radius: 8px; padding: 1.5rem;">
                          <h6 style="color: #007bff; margin-bottom: 1rem; font-size: 1.1rem; font-weight: 600;">
                            <i class="fas fa-building" style="margin-right: 0.5rem;"></i>Address & Hours
                          </h6>
                          <div style="white-space: pre-line; font-size: 1rem; color: #333; line-height: 1.6;">
                            <?php echo $contact_data['office_hours'] ?? "Physical Address:\n9545 Georgia Ave\nSilver Spring, MD 20910\n(Near the beltway exits)"; ?>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4 text-center">
                        <div style="background: rgba(0, 123, 255, 0.1); border: 1px solid rgba(0, 123, 255, 0.3); border-radius: 8px; padding: 1rem;">
                          <i class="fas fa-car" style="color: #007bff; font-size: 2rem; margin-bottom: 0.5rem;"></i>
                          <p style="margin: 0; font-size: 0.9rem; color: #333; font-weight: 600;">Easy Beltway Access</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Secondary Contact (if exists) -->
                <?php if (!empty($contact_data['secondary_contact_name']) || !empty($contact_data['secondary_contact_email'])): ?>
                <div style="background: rgba(108, 117, 125, 0.08); border: 1px solid rgba(108, 117, 125, 0.2); border-radius: 12px; padding: 2rem; margin-bottom: 2rem;">
                  <h4 style="color: #6c757d; margin-bottom: 1.5rem; font-size: 1.3rem; text-align: center;">
                    <i class="fas fa-user-friends" style="margin-right: 0.5rem;"></i>Additional Contact
                  </h4>
                  
                  <div style="background: rgba(255, 255, 255, 0.7); border-radius: 8px; padding: 1.5rem;">
                    <?php if (!empty($contact_data['secondary_contact_name'])): ?>
                    <h5 style="color: #6c757d; margin-bottom: 1rem; text-align: center; font-weight: 600;">
                      <?php echo htmlspecialchars($contact_data['secondary_contact_name']); ?>
                    </h5>
                    <?php endif; ?>
                    
                    <?php if (!empty($contact_data['secondary_contact_email'])): ?>
                    <div style="text-align: center;">
                      <div style="background: rgba(108, 117, 125, 0.1); border-radius: 8px; padding: 1rem; display: inline-block;">
                        <i class="fas fa-envelope" style="color: #6c757d; margin-right: 0.5rem;"></i>
                        <a href="mailto:<?php echo htmlspecialchars($contact_data['secondary_contact_email']); ?>" style="color: #6c757d; text-decoration: none; font-weight: 600;">
                          <?php echo htmlspecialchars($contact_data['secondary_contact_email']); ?>
                        </a>
                      </div>
                    </div>
                    <?php endif; ?>
                  </div>
                </div>
                <?php endif; ?>

              </div>
            </div>
          </details>
        </div>
  </div>
</section>

<!-- After School | Weekend & Evening Section -->
<section id="weekend-evening" class="py-5" style="background: linear-gradient(135deg, #1a1a1a 0%, #2c2c2c 100%); color: white;">
  <div class="container">
    <h2 class="text-center mb-5" style="color: white; font-family: 'Playfair Display', serif; font-size: 3rem; font-weight: 700;"><span style="text-decoration: underline; text-underline-offset: 0.3em; text-decoration-color: #dc3545;"><?php echo display_text('after_school', 'title', 'Weekend & Evening'); ?></span></h2>
    
    <!-- Schedule Integration Section -->
    <div class="schedule-integration mt-5">
      <div id="schedule-container">
        <!-- Integrated filter toolbar -->
        <div class="schedule-filters-toolbar">
          <!-- Calendar Info Header -->
          <div style="text-align: center; margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 2px solid rgba(220, 53, 69, 0.2);">
            <h3 style="color: #dc3545; font-family: 'Playfair Display', serif; font-size: 2.2rem; font-weight: 700; margin-bottom: 2rem; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
              <i class="fas fa-calendar-alt" style="margin-right: 0.75rem; font-size: 1.8rem; opacity: 0.9;"></i>
<?php echo display_text('after_school', 'calendar_section.header', '2025 September / October Class Calendar'); ?>
            </h3>
            
            <!-- Info Badges -->
            <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 1.5rem; align-items: center;">
              <!-- Duration Badge -->
              <div style="background: rgba(255, 255, 255, 0.95); border: 2px solid #dc3545; border-radius: 25px; padding: 0.75rem 1.5rem; display: flex; align-items: center; box-shadow: 0 4px 15px rgba(220, 53, 69, 0.2); backdrop-filter: blur(10px);">
                <i class="fas fa-clock" style="color: #dc3545; font-size: 1.1rem; margin-right: 0.6rem;"></i>
                <span style="color: #333; font-weight: 600; font-size: 0.95rem; letter-spacing: 0.3px;"><?php echo display_text('after_school', 'calendar_section.info_badges.duration', 'One-hour classes unless stated otherwise'); ?></span>
              </div>
              
              <!-- Location Badge -->
              <div style="background: rgba(255, 255, 255, 0.95); border: 2px solid #dc3545; border-radius: 25px; padding: 0.75rem 1.5rem; display: flex; align-items: center; box-shadow: 0 4px 15px rgba(220, 53, 69, 0.2); backdrop-filter: blur(10px);">
                <i class="fas fa-home" style="color: #dc3545; font-size: 1.1rem; margin-right: 0.6rem;"></i>
                <span style="color: #333; font-weight: 600; font-size: 0.95rem; letter-spacing: 0.3px;"><?php echo display_text('after_school', 'calendar_section.info_badges.location_type', 'All Classes Held Indoors/In-Person'); ?></span>
              </div>
            </div>
          </div>
          <div class="filters">
            <div class="filter-group">
              <label>Class Type:</label>
              <div class="custom-dropdown" data-filter="class-type">
                <div class="dropdown-selected">
                  <span class="selected-text">All Types</span>
                  <span class="dropdown-arrow">▼</span>
                </div>
                <div class="dropdown-options">
                  <div class="dropdown-option active" data-value="all">All Types</div>
                  <div class="dropdown-option" data-value="youth">Youth</div>
                  <div class="dropdown-option" data-value="adult">Adult (13 years +)</div>
                  <div class="dropdown-option" data-value="mixed">Mixed (Youth & Adult)</div>
                </div>
              </div>
            </div>
            
            <div class="filter-group">
              <label>Youth Group:</label>
              <div class="custom-dropdown" data-filter="age-group">
                <div class="dropdown-selected">
                  <span class="selected-text">All Youth Groups</span>
                  <span class="dropdown-arrow">▼</span>
                </div>
                <div class="dropdown-options">
                  <div class="dropdown-option active" data-value="all">All Youth Groups</div>
                  <div class="dropdown-option" data-value="little-ninja">Little Ninjas (3.5-4 years)</div>
                  <div class="dropdown-option" data-value="beginner">Beginner (5 Years +, White / Yellow / Orange)</div>
                  <div class="dropdown-option" data-value="intermediate">Intermediate (5 Years +, Green / Purple / Blue)</div>
                  <div class="dropdown-option" data-value="advanced">Advanced (5 Years +, Brown / Red)</div>
                </div>
              </div>
            </div>
            
            <div class="filter-group">
              <label>Belt Level:</label>
              <div class="custom-dropdown" data-filter="belt-level">
                <div class="dropdown-selected">
                  <span class="selected-text">All Belts</span>
                  <span class="dropdown-arrow">▼</span>
                </div>
                <div class="dropdown-options">
                  <div class="dropdown-option active" data-value="all">All Belts</div>
                  <div class="dropdown-option" data-value="white">White</div>
                  <div class="dropdown-option" data-value="yellow">Yellow</div>
                  <div class="dropdown-option" data-value="orange">Orange</div>
                  <div class="dropdown-option" data-value="green">Green</div>
                  <div class="dropdown-option" data-value="purple">Purple</div>
                  <div class="dropdown-option" data-value="blue">Blue</div>
                  <div class="dropdown-option" data-value="brown">Brown</div>
                  <div class="dropdown-option" data-value="red">Red</div>
                  <div class="dropdown-option" data-value="master-form-kenpo">Master Form / Kenpo</div>
                  <div class="dropdown-option" data-value="master-form-jujitsu">Master Form / Jujitsu</div>
                </div>
              </div>
            </div>
            
            <div class="filter-group">
              <label>Location:</label>
              <div class="custom-dropdown" data-filter="location">
                <div class="dropdown-selected">
                  <span class="selected-text">All Locations</span>
                  <span class="dropdown-arrow">▼</span>
                </div>
                <div class="dropdown-options">
                  <div class="dropdown-option active" data-value="all">All Locations</div>
                  <div class="dropdown-option" data-value="Silver Spring MD">📍Silver Spring MD</div>
                  <div class="dropdown-option" data-value="NW DC">📍NW DC</div>
                  <div class="dropdown-option" data-value="Arlington VA">📍Arlington VA</div>
                  <div class="dropdown-option" data-value="Rockville MD">📍Rockville MD</div>
                  <div class="dropdown-option" data-value="Glenn Dale MD">📍Glenn Dale MD</div>
                  <div class="dropdown-option" data-value="Capitol Hill DC">📍Capitol Hill DC</div>
                </div>
              </div>
            </div>
            
            <div class="filter-group">
              <label>Day of Week:</label>
              <div class="custom-dropdown" data-filter="day">
                <div class="dropdown-selected">
                  <span class="selected-text">All Days</span>
                  <span class="dropdown-arrow">▼</span>
                </div>
                <div class="dropdown-options">
                  <div class="dropdown-option active" data-value="all">All Days</div>
                  <div class="dropdown-option" data-value="Monday">Monday</div>
                  <div class="dropdown-option" data-value="Tuesday">Tuesday</div>
                  <div class="dropdown-option" data-value="Wednesday">Wednesday</div>
                  <div class="dropdown-option" data-value="Thursday">Thursday</div>
                  <div class="dropdown-option" data-value="Friday">Friday</div>
                  <div class="dropdown-option" data-value="Saturday">Saturday</div>
                  <div class="dropdown-option" data-value="Sunday">Sunday</div>
                </div>
              </div>
            </div>
            
            <!-- Bottom row container for checkbox and reset button -->
            <div class="bottom-row-container">
              <!-- Dynamic checkbox for excluding mixed classes -->
              <div id="exclude-mixed-container" class="exclude-mixed-checkbox" style="display: none;">
                <label class="checkbox-label">
                  <input type="checkbox" id="exclude-mixed">
                  <span class="checkmark"></span>
                  Exclude Mixed (Youth & Adult) Classes?
                </label>
              </div>
              
              <button id="reset-filters">Reset Filters</button>
            </div>
          </div>
        </div>
        
        <!-- Schedule content will be inserted here by JavaScript -->
        <div id="schedule-content"></div>
      </div>
    </div>

    <!-- Sept-Oct Schedule and Registration Containers -->
    <div class="row justify-content-center g-4 mt-5">
      <!-- Sept - Oct Schedule -->
      <div class="col-lg-6">
        <div style="background: rgba(255, 255, 255, 0.05); border-radius: 15px; padding: 2rem; border: 1px solid rgba(255, 255, 255, 0.1); text-align: center; height: 100%;">
          <h3 style="color: #dc3545; font-size: 1.5rem; margin-bottom: 1.5rem; font-weight: 600;"><?php echo display_text('after_school', 'schedule.title', 'September - October Schedule'); ?></h3>
          
          <!-- Calendar Preview -->
          <div style="position: relative; margin-bottom: 1.5rem;">
            <img src="<?php echo display_text('after_school', 'schedule.preview_image', 'assets/images/aftersschool/sep-oct-karate.png'); ?>" 
                 alt="<?php echo display_text('after_school', 'schedule.title', 'September - October Schedule'); ?>" 
                 style="width: 100%; max-width: 400px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3); cursor: pointer;"
                 onclick="openCalendarPreview()"
                 onmouseover="this.style.transform='scale(1.02)'; this.style.transition='all 0.3s ease';"
                 onmouseout="this.style.transform='scale(1)'; this.style.transition='all 0.3s ease';">
          </div>
          
          <!-- Download Button -->
          <a href="<?php echo display_text('after_school', 'schedule.pdf_file', 'assets/images/aftersschool/2025-Sep-Oct-Karate-Class-Calendar-v2.pdf'); ?>" 
             download
             style="background: rgba(220, 53, 69, 0.2); color: white; padding: 0.8rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 500; display: inline-block; border: 1px solid rgba(220, 53, 69, 0.4); transition: all 0.3s ease;"
             onmouseover="this.style.background='rgba(220, 53, 69, 0.3)'; this.style.borderColor='#dc3545';"
             onmouseout="this.style.background='rgba(220, 53, 69, 0.2)'; this.style.borderColor='rgba(220, 53, 69, 0.4)';">
            <i class="fas fa-download" style="margin-right: 0.5rem;"></i>
            <?php echo display_text('after_school', 'schedule.download_text', 'Download Schedule'); ?>
          </a>
            </div>
          </div>
      
      <!-- Registration Button -->
      <div class="col-lg-6">
        <div style="background: rgba(255, 255, 255, 0.05); border-radius: 15px; padding: 2rem; border: 1px solid rgba(255, 255, 255, 0.1); text-align: center; display: flex; flex-direction: column; justify-content: center; height: 100%;">
          <h3 style="color: white; font-size: 1.8rem; margin-bottom: 2rem; font-weight: 600;"><?php echo display_text('after_school', 'registration.title', 'Ready to Enroll?'); ?></h3>
          
          <a href="<?php echo display_text('after_school', 'registration.button_url', 'https://www.gomotionapp.com/team/mdkfu/page/class-registration'); ?>" 
             target="_blank"
             style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; padding: 1.5rem 2.5rem; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 1.3rem; display: inline-block; transition: all 0.3s ease; box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4); border: none; margin: 0 auto;"
             onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 25px rgba(220, 53, 69, 0.6)';"
             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 6px 20px rgba(220, 53, 69, 0.4)';">
            <i class="fas fa-user-plus" style="margin-right: 0.8rem; font-size: 1.2rem;"></i>
            <?php echo display_text('after_school', 'registration.button_text', 'Register Now'); ?>
          </a>
          
          <p style="color: #e9ecef; margin-top: 1.5rem; font-size: 0.95rem; opacity: 0.8;">
<?php echo display_text('after_school', 'registration.subtext', 'Secure your spot in our programs'); ?>
          </p>
        </div>
      </div>
    </div>

    <!-- Disclaimer Text -->
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <p style="color: #e9ecef; font-size: 0.9rem; text-align: center; line-height: 1.5; opacity: 0.8;">
<?php echo display_text('after_school', 'disclaimer.text', 'Not all classes are listed. If you do not see your program listed then please'); ?> 
          <a href="<?php echo display_text('after_school', 'disclaimer.link_url', '#contact'); ?>" style="color: #dc3545; text-decoration: underline; transition: color 0.2s ease;"
             onmouseover="this.style.color='#ff6b7a';"
             onmouseout="this.style.color='#dc3545';"><?php echo display_text('after_school', 'disclaimer.link_text', 'contact our office'); ?></a> 
          <?php echo display_text('after_school', 'disclaimer.end_text', 'directly for more information.'); ?>
        </p>
      </div>
    </div>
  </div>
  
  <!-- Inject Class Schedule Data for JavaScript -->
  <script>
    // Load class schedule data from JSON and make it globally available
    <?php
    $class_schedule_data = load_content('class-schedule.json');
    if ($class_schedule_data && isset($class_schedule_data['classes'])) {
        echo 'window.classData = ' . json_encode($class_schedule_data['classes']) . ';';
        echo 'window.classScheduleMetadata = ' . json_encode($class_schedule_data['metadata']) . ';';
    } else {
        echo 'window.classData = [];';
        echo 'window.classScheduleMetadata = null;';
        echo 'console.error("Failed to load class schedule data");';
    }
    ?>
  </script>
</section>

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
<section id="online-store" class="py-5" style="background: #ffffff; color: #333; position: relative; overflow: hidden;">
  <!-- Artistic Background Blobs -->
  <!-- Large Impact Blobs -->
  <div style="position: absolute; top: -120px; left: -120px; width: 400px; height: 400px; background: radial-gradient(circle, rgba(220, 53, 69, 0.10) 0%, rgba(220, 53, 69, 0.05) 40%, transparent 100%); border-radius: 50%; z-index: 1;"></div>
  <div style="position: absolute; bottom: -100px; right: -150px; width: 500px; height: 500px; background: radial-gradient(circle, rgba(44, 62, 80, 0.08) 0%, rgba(44, 62, 80, 0.03) 45%, transparent 100%); border-radius: 50%; z-index: 1;"></div>
  <div style="position: absolute; top: 40%; right: -180px; width: 380px; height: 380px; background: radial-gradient(circle, rgba(220, 53, 69, 0.07) 0%, rgba(220, 53, 69, 0.02) 50%, transparent 100%); border-radius: 50%; z-index: 1;"></div>
  <div style="position: absolute; bottom: 20%; left: -80px; width: 320px; height: 320px; background: radial-gradient(circle, rgba(44, 62, 80, 0.06) 0%, rgba(44, 62, 80, 0.02) 60%, transparent 100%); border-radius: 50%; z-index: 1;"></div>
  
  <!-- Medium Impact Blobs -->
  <div style="position: absolute; top: 60%; left: 75%; transform: translate(-50%, -50%); width: 280px; height: 280px; background: radial-gradient(circle, rgba(220, 53, 69, 0.06) 0%, rgba(220, 53, 69, 0.02) 60%, transparent 100%); border-radius: 50%; z-index: 1;"></div>
  <div style="position: absolute; top: 15%; left: 20%; width: 240px; height: 240px; background: radial-gradient(circle, rgba(44, 62, 80, 0.05) 0%, transparent 70%); border-radius: 50%; z-index: 1;"></div>
  <div style="position: absolute; bottom: 30%; right: 10%; width: 300px; height: 300px; background: radial-gradient(circle, rgba(220, 53, 69, 0.05) 0%, transparent 75%); border-radius: 50%; z-index: 1;"></div>
  <div style="position: absolute; top: 70%; left: 10%; width: 250px; height: 250px; background: radial-gradient(circle, rgba(44, 62, 80, 0.04) 0%, transparent 65%); border-radius: 50%; z-index: 1;"></div>
  
  <!-- Additional Artistic Blobs -->
  <div style="position: absolute; top: 20%; right: 8%; width: 200px; height: 200px; background: radial-gradient(circle, rgba(220, 53, 69, 0.06) 0%, rgba(220, 53, 69, 0.02) 60%, transparent 100%); border-radius: 50%; z-index: 1;"></div>
  <div style="position: absolute; top: 80%; left: 50%; width: 180px; height: 180px; background: radial-gradient(circle, rgba(44, 62, 80, 0.04) 0%, transparent 65%); border-radius: 50%; z-index: 1;"></div>
  <div style="position: absolute; top: -30px; left: 45%; width: 260px; height: 260px; background: radial-gradient(circle, rgba(220, 53, 69, 0.04) 0%, transparent 80%); border-radius: 50%; z-index: 1;"></div>
  <div style="position: absolute; bottom: 35%; right: -60px; width: 300px; height: 300px; background: radial-gradient(circle, rgba(44, 62, 80, 0.05) 0%, rgba(44, 62, 80, 0.01) 55%, transparent 100%); border-radius: 50%; z-index: 1;"></div>
  
  <div class="container" style="position: relative; z-index: 2;">
    <h2 class="text-center mb-5" style="color: #2c3e50; font-family: 'Playfair Display', serif; font-size: 3rem; font-weight: 700; text-decoration: underline; text-underline-offset: 0.3em; text-decoration-color: #dc3545;"><?php echo display_text('online_store', 'title', 'Online Store'); ?></h2>
    
    <div class="row align-items-center g-4">
      <!-- Store Image -->
      <div class="col-lg-7">
        <img src="<?php echo display_text('online_store', 'store_image', 'assets/images/online-store/online-store.jpg'); ?>" 
             alt="Kaizen Karate Online Store - Uniforms, T-shirts & Sparring Gear" 
             style="width: 100%; height: auto; object-fit: contain;">
    </div>
    
      <!-- Store Information -->
      <div class="col-lg-5">
        <div style="padding: 1.5rem;">
          
          <div style="background: rgba(220, 53, 69, 0.1); border: 2px solid rgba(220, 53, 69, 0.2); border-radius: 15px; padding: 1.5rem; margin-bottom: 2rem; text-align: center;">
            <h4 style="color: #dc3545; font-size: 1.8rem; margin-bottom: 1rem; font-weight: 700;">
              <i class="fas fa-shopping-cart" style="margin-right: 0.5rem;"></i>
              <?php echo display_text('online_store', 'announcement_heading', 'The online store is now open!'); ?>
            </h4>
            <p style="color: #495057; font-size: 1.1rem; margin: 0; line-height: 1.6;">
            <?php echo display_text('online_store', 'announcement_description', 'Get your karate uniform, t-shirt, & sparring gear shipped directly to your home.'); ?>
            </p>
          </div>
                               
                     <!-- Shop Now Button -->
           <div style="text-align: center; margin-top: 1.5rem;">
            <a href="<?php echo display_text('online_store', 'button_url', 'https://kaizenkarate.store/'); ?>" 
               target="_blank"
               style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; padding: 1.2rem 2.5rem; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 1.3rem; display: inline-block; transition: all 0.3s ease; box-shadow: 0 6px 20px rgba(220, 53, 69, 0.3); border: none;"
               onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 25px rgba(220, 53, 69, 0.5)';"
               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 6px 20px rgba(220, 53, 69, 0.3)';">
              <i class="fas fa-shopping-bag" style="margin-right: 0.8rem; font-size: 1.2rem;"></i>
              <?php echo display_text('online_store', 'button_text', 'Shop Now'); ?>
            </a>

          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- Belt Exam Section -->
<section id="belt-exam" class="py-5" style="background: linear-gradient(135deg, #1a1a1a 0%, #2c2c2c 100%); color: white;">
  <div class="container">
    <h2 class="text-center mb-5" style="color: white; font-family: 'Playfair Display', serif; font-size: 3rem; font-weight: 700; text-decoration: underline; text-underline-offset: 0.3em; text-decoration-color: #dc3545;"><?php echo display_text('belt_exam', 'title', 'Belt Exam'); ?></h2>
    
    <!-- Hero Image -->
    <div class="mb-5">
      <div style="position: relative; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);">
        <img src="assets/images/panels/belt-exams.jpg" 
             alt="Kaizen Karate Belt Exam - Students testing for their next rank" 
             style="width: 100%; height: 650px; object-fit: cover; object-position: center;">
        
        <!-- Image Overlay -->
        <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0, 0, 0, 0.8)); padding: 2rem 1.5rem 1.5rem 1.5rem;">
          <h3 style="color: white; font-size: 1.8rem; font-weight: 600; margin-bottom: 0.5rem;">Traditional Belt Testing</h3>
          <p style="color: #e9ecef; font-size: 1.1rem; margin: 0; opacity: 0.9;">Advancing through the ranks with authentic karate examination</p>
          </div>
            </div>
          </div>
    
    <!-- Requirements Section -->
    <div>
      <div style="background: rgba(220, 53, 69, 0.1); border: 2px solid rgba(220, 53, 69, 0.3); border-radius: 15px; padding: 2.5rem;">
          <h3 style="color: #dc3545; font-size: 2rem; margin-bottom: 2rem; font-weight: 700; text-align: center;">
            <i class="fas fa-exclamation-triangle" style="margin-right: 0.5rem;"></i>
            Important Requirements
          </h3>
          
          <div style="space-y: 1rem;">
            <!-- Pre-registration Required -->
            <div style="background: rgba(255, 255, 255, 0.05); border-radius: 10px; padding: 1.2rem; margin-bottom: 1rem; border-left: 4px solid #dc3545;">
              <p style="color: white; font-weight: 600; margin: 0; font-size: 1.2rem;">
                <i class="fas fa-calendar-check" style="color: #dc3545; margin-right: 0.5rem;"></i>
                Pre-registration required.
              </p>
        </div>
            
            <!-- Invitation Only -->
            <div style="background: rgba(255, 255, 255, 0.05); border-radius: 10px; padding: 1.2rem; margin-bottom: 1rem; border-left: 4px solid #dc3545;">
              <p style="color: white; font-weight: 600; margin: 0; font-size: 1.2rem;">
                <i class="fas fa-user-shield" style="color: #dc3545; margin-right: 0.5rem;"></i>
                Belt exams are <strong style="color: #ff6b7a;">INVITATION ONLY</strong> events.
              </p>
      </div>

            <!-- Registration Deadline -->
            <div style="background: rgba(255, 255, 255, 0.05); border-radius: 10px; padding: 1.2rem; margin-bottom: 1rem; border-left: 4px solid #dc3545;">
              <p style="color: white; font-weight: 600; margin: 0; font-size: 1.2rem;">
                <i class="fas fa-clock" style="color: #dc3545; margin-right: 0.5rem;"></i>
                Online registration closes <strong>1 week prior</strong> to the belt exam.
              </p>
          </div>
            
            <!-- No Verbal Approvals -->
            <div style="background: rgba(255, 255, 255, 0.05); border-radius: 10px; padding: 1.2rem; margin-bottom: 1rem; border-left: 4px solid #dc3545;">
              <p style="color: white; font-weight: 600; margin: 0; font-size: 1.2rem;">
                <i class="fas fa-times-circle" style="color: #dc3545; margin-right: 0.5rem;"></i>
                Verbal approvals by instructors during class time are <strong style="color: #ff6b7a;">no longer accepted.</strong>
              </p>
            </div>
            
            <!-- Written Approval Required -->
            <div style="background: rgba(255, 255, 255, 0.1); border-radius: 10px; padding: 1.5rem; margin-bottom: 1rem; border: 2px solid #dc3545;">
              <p style="color: white; font-weight: 700; margin-bottom: 0.5rem; font-size: 1.2rem;">
                <i class="fas fa-envelope" style="color: #dc3545; margin-right: 0.5rem;"></i>
                ALL students must receive <strong style="color: #ff6b7a;">*written*</strong> approval directly from the Kaizen office team before starting the testing process.
              </p>
              <p style="color: #e9ecef; margin: 0; font-size: 1rem; font-style: italic;">
                Approval to test will be sent to students via email.
              </p>
            </div>
          </div>
        </div>
    </div>
    
    <!-- Belt Exam Accordion Section - 100% ADMIN CONTROLLED -->
    <div class="mt-5">
      <div style="background: rgba(255, 255, 255, 0.05); border-radius: 15px; padding: 0; border: 1px solid rgba(255, 255, 255, 0.1); overflow: hidden;">
        
        <?php
        // Load Belt Exam accordions from admin - SINGLE SOURCE OF TRUTH
        $belt_exam_data = get_content('belt_exams') ?: [];
        $accordions = $belt_exam_data['accordions'] ?? [];
        
        // Sort accordions by order field
        if (!empty($accordions)) {
            usort($accordions, function($a, $b) {
                return ($a['order'] ?? 999) - ($b['order'] ?? 999);
            });
            
            foreach ($accordions as $accordion):
                $accordion_id = $accordion['id'] ?? '';
                $accordion_title = $accordion['title'] ?? 'Untitled';
                $accordion_icon = $accordion['icon'] ?? 'fas fa-info-circle';
                $accordion_description = $accordion['description'] ?? '';
                $content_type = $accordion['content_type'] ?? '';
        ?>
        
        <!-- <?php echo htmlspecialchars($accordion_title); ?> -->
        <div class="accordion-item" style="border: none; background: transparent;">
          <div class="accordion-header" style="background: rgba(255, 255, 255, 0.08); padding: 1.5rem 2rem; cursor: pointer; border-bottom: 1px solid rgba(255, 255, 255, 0.1); transition: all 0.3s ease;" onclick="toggleAccordion('<?php echo $accordion_id; ?>')" onmouseover="this.style.background='rgba(255, 255, 255, 0.12)'" onmouseout="this.style.background='rgba(255, 255, 255, 0.08)'">
            <h4 style="color: white; margin: 0; font-size: 1.4rem; font-weight: 600; display: flex; align-items: center; justify-content: space-between;">
              <span><i class="<?php echo htmlspecialchars($accordion_icon); ?>" style="color: #dc3545; margin-right: 0.8rem;"></i><?php echo htmlspecialchars($accordion_title); ?></span>
              <i class="fas fa-chevron-down" id="<?php echo $accordion_id; ?>-icon" style="color: #dc3545; transition: transform 0.3s ease;"></i>
            </h4>
          </div>
          <div class="accordion-content" id="<?php echo $accordion_id; ?>-content" style="display: none; padding: 2rem; background: rgba(0, 0, 0, 0.2); border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
            <div style="color: #e9ecef; line-height: 1.6;">
              <?php if (!empty($accordion_description)): ?>
                <p style="margin-bottom: 2rem; font-size: 1.1rem; text-align: center;"><?php echo htmlspecialchars($accordion_description); ?></p>
              <?php endif; ?>
              
              <?php
              // Render content based on type - ALL FROM ADMIN DATA
              switch ($content_type) {
                  
                case 'dates':
                  // Upcoming Testing Dates from Admin
                  $date_cards = $accordion['date_cards'] ?? [];
                  
                  // Sort cards by order
                  if (!empty($date_cards)) {
                      usort($date_cards, function($a, $b) {
                          return ($a['order'] ?? 0) - ($b['order'] ?? 0);
                      });
                  }
                  
                  if (!empty($date_cards)):
              ?>
                      <div class="row g-4">
                        <?php foreach ($date_cards as $date_card): ?>
                        <div class="col-lg-4 col-md-6">
                          <div style="background: rgba(220, 53, 69, 0.1); border: 1px solid rgba(220, 53, 69, 0.3); border-radius: 12px; padding: 1.5rem; height: 100%;">
                          <h5 style="color: #dc3545; margin-bottom: 1rem; font-size: 1.3rem; text-align: center; display: flex; align-items: center; justify-content: center; flex-wrap: wrap; gap: 0.5rem;">
                            <span>
                              <i class="fas fa-calendar-day" style="margin-right: 0.5rem;"></i><?php echo htmlspecialchars($date_card['month_year'] ?? 'Testing Date'); ?>
                            </span>
                            <?php if (!empty($date_card['invitation_only'])): ?>
                            <span style="background: #dc3545; color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 2px 4px rgba(220, 53, 69, 0.3);">
                              <i class="fas fa-lock" style="margin-right: 0.3rem; font-size: 0.7rem;"></i>Invitation Only
                            </span>
                            <?php endif; ?>
                          </h5>
                            <div style="background: rgba(255, 255, 255, 0.05); border-radius: 8px; padding: 1rem; margin-bottom: 1rem;">
                              <p style="margin: 0; font-size: 0.95rem; line-height: 1.4;">
                                <strong style="color: white;"><?php echo htmlspecialchars($date_card['location_name'] ?? 'Location TBA'); ?></strong><br>
                                <?php 
                                $address = '';
                                if (!empty($date_card['street_address'])) {
                                    $address = $date_card['street_address'];
                                    if (!empty($date_card['city_state_zip'])) {
                                        $address .= "\n" . $date_card['city_state_zip'];
                                    }
                                }
                                echo nl2br(htmlspecialchars($address)); 
                                ?><span style="display: block; margin-top: 0.75rem; color: #ffdf6b; font-weight: 700; letter-spacing: 0.01em;"><?php echo htmlspecialchars($date_card['datetime_string'] ?? 'Date & Time TBA'); ?></span>
                              </p>
                              <?php if (!empty($date_card['link_text']) && ($date_card['show_link'] ?? true)): ?>
                              <div style="text-align: center; margin-top: 1rem;">
                                <a href="#" onclick="return scrollToBeltExamRegister(event);" style="color: #ffd166; text-decoration: underline; font-weight: 700; font-size: 0.95rem; letter-spacing: 0.02em; transition: all 0.3s ease;" onmouseover="this.style.color='#ffffff'; this.style.textDecoration='none';" onmouseout="this.style.color='#ffd166'; this.style.textDecoration='underline';"><?php echo htmlspecialchars($date_card['link_text']); ?></a>
                              </div>
                              <?php endif; ?>
                            </div>
                            <?php 
                            // Display notes from admin fields
                            $notes = [];
                            if (!empty($date_card['youth_note'])) $notes[] = $date_card['youth_note'];
                            if (!empty($date_card['adult_note'])) $notes[] = $date_card['adult_note'];
                            if (!empty($date_card['makeup_month'])) {
                                // Check if makeup_month already contains the full text
                                if (strpos($date_card['makeup_month'], '*All make-up tests will take place in') === 0) {
                                    $notes[] = $date_card['makeup_month'];
                                } else {
                                    $notes[] = '*All make-up tests will take place in ' . $date_card['makeup_month'];
                                }
                            }
                            
                            if (!empty($notes)): ?>
                            <div style="font-size: 0.85rem; line-height: 1.3;">
                              <?php foreach ($notes as $note): ?>
                              <p style="margin-bottom: 0.5rem;"><em><?php echo htmlspecialchars($note); ?></em></p>
                              <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($date_card['video_note'])): ?>
                            <p style="margin: 0; font-size: 0.8rem; background: rgba(255, 255, 255, 0.1); padding: 0.5rem; border-radius: 4px;">
                              <strong><?php echo htmlspecialchars($date_card['video_note']); ?></strong>
                            </p>
                            <?php endif; ?>
                          </div>
                        </div>
                        <?php endforeach; ?>
                      </div>
              <?php
                      else:
                          echo '<p style="text-align: center; color: #ccc;">No testing dates configured yet.</p>';
                      endif;
                      break;
                      
                  case 'registration':
              ?>
              <!-- In-Person Testing Information -->
              <?php if (!empty($accordion['group_testing_section'])): ?>
              <div style="background: rgba(220, 53, 69, 0.1); border: 1px solid rgba(220, 53, 69, 0.3); border-radius: 12px; padding: 2rem; margin-bottom: 2rem;">
                <h4 style="color: #dc3545; margin-bottom: 1.5rem; font-size: 1.4rem; text-align: center;">
                  <i class="<?php echo htmlspecialchars($accordion['group_testing_section']['icon'] ?? 'fas fa-users'); ?>" style="margin-right: 0.5rem;"></i><?php echo htmlspecialchars($accordion['group_testing_section']['title'] ?? 'In-Person Group Testing'); ?>
                </h4>
                
                <div style="background: rgba(255, 255, 255, 0.05); border-radius: 8px; padding: 1.5rem; margin-bottom: 1.5rem;">
                  <p style="margin-bottom: 1rem; font-size: 0.95rem;"><?php echo htmlspecialchars($accordion['group_testing_section']['description'] ?? ''); ?></p>
                </div>
              </div>
              <?php endif; ?>
                
                <!-- Registration Cards Grid -->
                <div style="background: rgba(255, 255, 255, 0.05); border-radius: 8px; padding: 1.5rem; margin-bottom: 1.5rem;">
                  <div style="text-align: center; margin-bottom: 2rem;">
                    <h4 style="color: white; margin: 0 0 0.5rem 0; font-size: 2.5rem; font-weight: 700;"><?php echo htmlspecialchars($accordion['register_section']['heading'] ?? 'Register'); ?></h4>
                    <p style="color: #b3b3b3; margin: 0; font-size: 1rem; font-style: italic;"><?php echo htmlspecialchars($accordion['register_section']['subtitle'] ?? 'Click on your preferred testing date below'); ?></p>
                  </div>
                  
                  <!-- Location Information -->
                  <div style="background: rgba(220, 53, 69, 0.1); border: 1px solid rgba(220, 53, 69, 0.3); border-radius: 8px; padding: 1.5rem; margin-bottom: 2rem; text-align: center;">
                    <h5 style="color: #dc3545; margin-bottom: 1rem;"><i class="<?php echo htmlspecialchars($accordion['location_section']['icon'] ?? 'fas fa-map-marker-alt'); ?>" style="margin-right: 0.5rem;"></i><?php echo htmlspecialchars($accordion['location_section']['heading'] ?? 'Testing Location'); ?></h5>
                    <p style="color: white; margin: 0; font-size: 1.1rem; font-weight: 600;"><?php echo htmlspecialchars($accordion['shared_location']['name'] ?? ''); ?></p>
                    <p style="color: #b3b3b3; margin: 0.5rem 0 0 0;"><?php echo htmlspecialchars($accordion['shared_location']['address'] ?? ''); ?></p>
                  </div>
                  
                  <!-- Dynamic Registration Cards -->
                  <?php
                  $registration_cards = $accordion['registration_cards'] ?? [];
                  if (!empty($registration_cards)):
                      // Sort cards by order
                      usort($registration_cards, function($a, $b) {
                          return ($a['order'] ?? 0) - ($b['order'] ?? 0);
                      });
                      
                      // Display cards in rows of 2
                      $card_chunks = array_chunk($registration_cards, 2);
                      foreach ($card_chunks as $card_row):
                  ?>
                  <div class="row g-3 mb-4 justify-content-center">
                    <?php foreach ($card_row as $card): ?>
                    <div class="col-lg-6 col-md-6">
                      <a href="<?php echo htmlspecialchars($card['registration_link'] ?? '#'); ?>" target="_blank" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(220, 53, 69, 0.3); border-radius: 12px; padding: 1.8rem; text-align: center; cursor: pointer; transition: all 0.3s ease; height: 100%; display: block; text-decoration: none; color: inherit; position: relative;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(220, 53, 69, 0.3)'; this.style.borderColor='#dc3545';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'; this.style.borderColor='rgba(220, 53, 69, 0.3)';">
                        <h5 style="color: #dc3545; margin: 0 0 1rem 0; font-size: 1.3rem; font-weight: 700;"><?php echo htmlspecialchars($card['title'] ?? ''); ?></h5>
                        
                        <!-- Belt Color Visualization -->
                        <div style="display: flex; gap: 6px; justify-content: center; margin-bottom: 1rem; flex-wrap: wrap;">
                          <?php
                          $belt_colors = $card['belt_colors'] ?? [];
                          $belt_size = count($belt_colors) > 3 ? '26px' : '32px';
                          $belt_height = count($belt_colors) > 3 ? '18px' : '22px';
                          $icon_size = count($belt_colors) > 3 ? '0.5rem' : '0.7rem';
                          
                          foreach ($belt_colors as $belt_color):
                              // Belt color styling
                              $belt_style = '';
                              $icon_html = '';
                              
                              switch ($belt_color) {
                                  case 'white_orange':
                                      $belt_style = 'background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 50%, #e9ecef 100%); border: 2px solid #333; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08), 0 1px 3px rgba(0, 0, 0, 0.1), inset 0 1px 0 rgba(255, 255, 255, 0.8);';
                                      $icon_html = '<div style="position: absolute; bottom: 2px; width: 80%; height: 3px; background: #FF8C00; border-radius: 1px;"></div>';
                                      break;
                                  case 'white_black':
                                      $belt_style = 'background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 50%, #e9ecef 100%); border: 2px solid #333; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08), 0 1px 3px rgba(0, 0, 0, 0.1), inset 0 1px 0 rgba(255, 255, 255, 0.8);';
                                      $icon_html = '<div style="position: absolute; bottom: 2px; width: 80%; height: 3px; background: #000; border-radius: 1px;"></div>';
                                      break;
                                  case 'orange':
                                      $belt_style = 'background: linear-gradient(145deg, #FF8C00 0%, #FFA500 50%, #FF7F00 100%); border: 2px solid #333; box-shadow: 0 2px 8px rgba(255, 140, 0, 0.4), 0 1px 3px rgba(0, 0, 0, 0.15), inset 0 1px 0 rgba(255, 255, 255, 0.3);';
                                      $icon_html = '<i class="fas fa-graduation-cap" style="font-size: ' . $icon_size . '; color: white;"></i>';
                                      break;
                                  case 'yellow':
                                      $belt_style = 'background: linear-gradient(145deg, #FFD700 0%, #FFEB3B 50%, #FFC107 100%); border: 2px solid #333; box-shadow: 0 2px 8px rgba(255, 215, 0, 0.4), 0 1px 3px rgba(0, 0, 0, 0.15), inset 0 1px 0 rgba(255, 255, 255, 0.3);';
                                      $icon_html = '<i class="fas fa-graduation-cap" style="font-size: ' . $icon_size . '; color: #8B5000;"></i>';
                                      break;
                                  case 'green':
                                      $belt_style = 'background: linear-gradient(145deg, #4CAF50 0%, #66BB6A 50%, #43A047 100%); border: 2px solid #333; box-shadow: 0 2px 8px rgba(76, 175, 80, 0.4), 0 1px 3px rgba(0, 0, 0, 0.2), inset 0 1px 0 rgba(255, 255, 255, 0.2);';
                                      $icon_html = '<i class="fas fa-graduation-cap" style="font-size: ' . $icon_size . '; color: white;"></i>';
                                      break;
                                  case 'purple':
                                      $belt_style = 'background: linear-gradient(145deg, #9C27B0 0%, #BA68C8 50%, #7B1FA2 100%); border: 2px solid #333; box-shadow: 0 2px 8px rgba(156, 39, 176, 0.4), 0 1px 3px rgba(0, 0, 0, 0.2), inset 0 1px 0 rgba(255, 255, 255, 0.2);';
                                      $icon_html = '<i class="fas fa-graduation-cap" style="font-size: ' . $icon_size . '; color: white;"></i>';
                                      break;
                                  case 'blue':
                                      $belt_style = 'background: linear-gradient(145deg, #2196F3 0%, #42A5F5 50%, #1976D2 100%); border: 2px solid #333; box-shadow: 0 2px 8px rgba(33, 150, 243, 0.4), 0 1px 3px rgba(0, 0, 0, 0.2), inset 0 1px 0 rgba(255, 255, 255, 0.2);';
                                      $icon_html = '<i class="fas fa-graduation-cap" style="font-size: ' . $icon_size . '; color: white;"></i>';
                                      break;
                                  case 'brown':
                                      $belt_style = 'background: linear-gradient(145deg, #8D6E63 0%, #A1887F 50%, #6D4C41 100%); border: 2px solid #333; box-shadow: 0 2px 8px rgba(141, 110, 99, 0.4), 0 1px 3px rgba(0, 0, 0, 0.2), inset 0 1px 0 rgba(255, 255, 255, 0.15);';
                                      $icon_html = '<i class="fas fa-graduation-cap" style="font-size: ' . $icon_size . '; color: white;"></i>';
                                      break;
                                  case 'red':
                                      $belt_style = 'background: linear-gradient(145deg, #F44336 0%, #EF5350 50%, #D32F2F 100%); border: 2px solid #333; box-shadow: 0 2px 8px rgba(244, 67, 54, 0.4), 0 1px 3px rgba(0, 0, 0, 0.2), inset 0 1px 0 rgba(255, 255, 255, 0.2);';
                                      $icon_html = '<i class="fas fa-graduation-cap" style="font-size: ' . $icon_size . '; color: white;"></i>';
                                      break;
                              }
                          ?>
                          <div style="width: <?php echo $belt_size; ?>; height: <?php echo $belt_height; ?>; <?php echo $belt_style; ?> border-radius: 3px; display: flex; align-items: center; justify-content: center; position: relative;">
                            <?php echo $icon_html; ?>
                          </div>
                          <?php endforeach; ?>
                        </div>
                        
                        <h6 style="color: white; margin-bottom: 0.5rem; font-size: 1.1rem; font-weight: 600;"><?php echo htmlspecialchars($card['exam_type'] ?? 'Youth Belt Exam'); ?></h6>
                          <p style="font-size: 0.9rem; color: #b3b3b3; margin: 0 0 0.5rem 0; line-height: 1.4;"><?php echo htmlspecialchars($card['belt_levels'] ?? ''); ?></p>

                          <?php if (!empty($card['invitation_only'])): ?>
                          <div style="margin-bottom: 1rem; text-align: center;">
                            <span style="background: #dc3545; color: white; padding: 0.4rem 1rem; border-radius: 20px; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 2px 4px rgba(220, 53, 69, 0.3); display: inline-block;">
                              <i class="fas fa-lock" style="margin-right: 0.3rem; font-size: 0.75rem;"></i>Invitation Only
                            </span>
                          </div>
                          <?php endif; ?>

                          <div style="margin-top: 1.2rem; padding: 1rem; background: rgba(220, 53, 69, 0.15); border: 1px solid rgba(220, 53, 69, 0.3); border-radius: 8px;">
                            <p style="color: #ffffff; margin: 0; font-size: 1rem; font-weight: 700;"><i class="fas fa-external-link-alt" style="margin-right: 0.5rem;"></i><?php echo htmlspecialchars($card['button_text'] ?? 'Register Now'); ?></p>
                          </div>
                      </a>
                    </div>
                    <?php endforeach; ?>
                  </div>
                  <?php endforeach; ?>
                  <?php endif; ?>
                </div>
              
              <!-- Pre-Registration Requirements -->
              <?php if (!empty($accordion['pre_registration_requirements'])): ?>
              <div style="background: rgba(220, 53, 69, 0.1); border: 1px solid rgba(220, 53, 69, 0.3); padding: 1.5rem; border-radius: 8px; margin-bottom: 1.5rem;">
                <h5 style="color: #dc3545; margin-bottom: 1rem;"><i class="<?php echo htmlspecialchars($accordion['pre_registration_requirements']['icon'] ?? 'fas fa-exclamation-triangle'); ?>" style="margin-right: 0.5rem;"></i><?php echo htmlspecialchars($accordion['pre_registration_requirements']['title'] ?? 'Before You Register'); ?></h5>
                <ul style="margin: 0; padding-left: 1.5rem;">
                  <?php foreach ($accordion['pre_registration_requirements']['requirements'] ?? [] as $requirement): ?>
                  <li style="margin-bottom: 0.8rem;"><?php echo htmlspecialchars($requirement); ?></li>
                  <?php endforeach; ?>
              </ul>
            </div>
              <?php endif; ?>
              <?php
                      break;
                      
                  case 'process':
                    // Get process sections data from accordion
                    $process_sections = $accordion['process_sections'] ?? [];
                    $summary = $accordion['summary'] ?? [];
                    
                    // Sort sections by order
                    if (!empty($process_sections)) {
                        usort($process_sections, function($a, $b) {
                            return ($a['order'] ?? 0) - ($b['order'] ?? 0);
                        });
                    }
              ?>
                <!-- OLD TESTING.PHP CODE - START -->
                <!-- Commented out for dynamic rendering
                (old incomplete process rendering removed)
                -->
                <!-- OLD TESTING.PHP CODE - END -->
                
                <!-- DYNAMIC RENDERING - START -->
                <div style="color: #e9ecef; line-height: 1.6;">
                    <?php 
                    // Description is already rendered by the general accordion system above
                    // No need to render it again here
                    ?>
                    
                    <?php if (!empty($process_sections)): ?>
                        <?php foreach ($process_sections as $section): ?>
                        <div style="background: rgba(220, 53, 69, 0.1); border: 1px solid rgba(220, 53, 69, 0.3); border-radius: 12px; padding: 2rem; margin-bottom: 2rem;">
                            <h4 style="color: #dc3545; margin-bottom: 1.5rem; font-size: 1.4rem; text-align: center;">
                                <i class="<?php echo htmlspecialchars($section['icon'] ?? 'fas fa-medal'); ?>" style="margin-right: 0.5rem;"></i><?php echo htmlspecialchars($section['title'] ?? ''); ?>
                            </h4>
                            
                            <?php 
                            $steps = $section['steps'] ?? [];
                            $total_steps = count($steps);
                            foreach ($steps as $index => $step): 
                                // Last step gets different background
                                $step_bg = ($index === $total_steps - 1) ? 'rgba(220, 53, 69, 0.2)' : 'rgba(255, 255, 255, 0.05)';
                                $margin_bottom = ($index === $total_steps - 1) ? '' : 'margin-bottom: 1.5rem;';
                            ?>
                            <div style="background: <?php echo $step_bg; ?>; border-radius: 8px; padding: 1.5rem; <?php echo $margin_bottom; ?>">
                                <h6 style="color: white; margin-bottom: 1rem; font-size: 1.1rem;">
                                    <i class="<?php echo htmlspecialchars($step['icon'] ?? 'fas fa-info-circle'); ?>" style="margin-right: 0.5rem; color: #dc3545;"></i><?php echo htmlspecialchars($step['title'] ?? ''); ?>
                                </h6>
                                <div style="font-size: 0.95rem;">
                                    <?php echo nl2br(htmlspecialchars($step['description'] ?? '')); ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    
                    <?php if (!empty($summary)): ?>
                    <!-- Summary -->
                    <div style="background: rgba(255, 255, 255, 0.1); border: 2px solid rgba(220, 53, 69, 0.5); border-radius: 12px; padding: 2rem; text-align: center;">
                        <h5 style="color: #dc3545; margin-bottom: 1rem; font-size: 1.3rem;">
                            <i class="<?php echo htmlspecialchars($summary['icon'] ?? 'fas fa-info-circle'); ?>" style="margin-right: 0.5rem;"></i><?php echo htmlspecialchars($summary['title'] ?? 'In Summary'); ?>
                        </h5>
                        <p style="margin: 0; font-size: 1rem; font-weight: 500; line-height: 1.5;">
                            <?php echo nl2br(htmlspecialchars($summary['text'] ?? '')); ?>
                        </p>
                    </div>
                    <?php endif; ?>
                </div>
                <!-- DYNAMIC RENDERING - END -->
                    <?php
                      break;
                      
                  case 'requirements':
                      // Get data from accordion
                      $important_notice = $accordion['important_notice'] ?? [];
                      $requirement_images = $accordion['requirement_images'] ?? [];
                      
                      // Sort images by order
                      if (!empty($requirement_images)) {
                          usort($requirement_images, function($a, $b) {
                              return ($a['order'] ?? 0) - ($b['order'] ?? 0);
                          });
                      }
              ?>
                      <div style="color: #e9ecef; line-height: 1.6;">
                        <?php if (!empty($important_notice)): ?>
                        <!-- Important Notice -->
                        <div style="background: rgba(220, 53, 69, 0.1); border: 1px solid rgba(220, 53, 69, 0.3); border-radius: 12px; padding: 2rem; margin-bottom: 2rem; text-align: center;">
                          <h4 style="color: #dc3545; margin-bottom: 1.5rem; font-size: 1.4rem;">
                            <i class="<?php echo htmlspecialchars($important_notice['icon'] ?? 'fas fa-exclamation-circle'); ?>" style="margin-right: 0.5rem;"></i><?php echo htmlspecialchars($important_notice['title'] ?? 'Important Testing Requirements'); ?>
                          </h4>
                          <div style="font-size: 1rem; line-height: 1.6;">
                            <?php if (!empty($important_notice['main_text'])): ?>
                            <div style="margin-bottom: 1.5rem;">
                              <?php echo nl2br(htmlspecialchars($important_notice['main_text'])); ?>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($important_notice['special_notes'])): ?>
                            <div style="background: rgba(255, 255, 255, 0.1); border-radius: 8px; padding: 1.5rem; margin-bottom: 1rem;">
                              <div style="font-size: 0.95rem;">
                                <?php 
                                $notes = explode("\n", $important_notice['special_notes']);
                                foreach ($notes as $note):
                                  if (trim($note)):
                                ?>
                                <p style="margin-bottom: 0.8rem;"><?php echo htmlspecialchars($note); ?></p>
                                <?php 
                                  endif;
                                endforeach; 
                                ?>
                              </div>
                            </div>
                            <?php endif; ?>
                          </div>
                        </div>
                        <?php endif; ?>
                        
                      <?php if (!empty($requirement_images)): ?>
                      <div style="margin-bottom: 2rem;">
                        <h5 style="color: #dc3545; margin-bottom: 1.5rem; text-align: center; font-size: 1.3rem;">
                          <i class="fas fa-images" style="margin-right: 0.5rem;"></i>Detailed Testing Requirements
                        </h5>
                        <p style="text-align: center; margin-bottom: 2rem; font-style: italic; color: #b3b3b3;">Click any image below to view full size</p>
                        
                        <div class="row g-4">
                          <?php foreach ($requirement_images as $req_image): ?>
                          <div class="col-lg-4 col-md-6">
                            <div style="background: rgba(255, 255, 255, 0.05); border-radius: 12px; padding: 1.5rem; text-align: center; transition: all 0.3s ease; border: 1px solid rgba(220, 53, 69, 0.2);" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(220, 53, 69, 0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                              <h6 style="color: #dc3545; margin-bottom: 1rem; font-size: 1.1rem;">
                                <i class="<?php echo htmlspecialchars($req_image['icon'] ?? 'fas fa-image'); ?>" style="margin-right: 0.5rem;"></i><?php echo htmlspecialchars($req_image['title'] ?? 'Requirement'); ?>
                              </h6>
                              <img src="<?php echo htmlspecialchars($req_image['image'] ?? ''); ?>" alt="<?php echo htmlspecialchars($req_image['title'] ?? 'Requirement Image'); ?>" style="width: 100%; height: 150px; object-fit: cover; border-radius: 8px; margin-bottom: 1rem; border: 2px solid rgba(220, 53, 69, 0.3); cursor: pointer;" onclick="<?php echo htmlspecialchars($req_image['lightbox_function'] ?? 'void(0)'); ?>()">
                              <p style="font-size: 0.9rem; margin-bottom: 1rem; color: #e9ecef;"><?php echo htmlspecialchars($req_image['description'] ?? ''); ?></p>
                              <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                <button onclick="<?php echo htmlspecialchars($req_image['lightbox_function'] ?? 'void(0)'); ?>()" style="background: rgba(220, 53, 69, 0.8); color: white; border: none; padding: 0.5rem 1rem; border-radius: 6px; font-size: 0.85rem; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#dc3545'" onmouseout="this.style.background='rgba(220, 53, 69, 0.8)'">
                                  <i class="fas fa-eye" style="margin-right: 0.5rem;"></i>View
                                </button>
                                <a href="<?php echo htmlspecialchars($req_image['download_url'] ?? ''); ?>" download="<?php echo htmlspecialchars($req_image['download_filename'] ?? ''); ?>" style="background: rgba(40, 167, 69, 0.8); color: white; border: none; padding: 0.5rem 1rem; border-radius: 6px; font-size: 0.85rem; cursor: pointer; transition: all 0.2s ease; text-decoration: none; display: inline-flex; align-items: center;" onmouseover="this.style.background='#28a745'" onmouseout="this.style.background='rgba(40, 167, 69, 0.8)'">
                                  <i class="fas fa-download" style="margin-right: 0.5rem;"></i>Download
                                </a>
                              </div>
                            </div>
                          </div>
                          <?php endforeach; ?>
                        </div>
                      </div>
              <?php
                      else:
                          echo '<p style="text-align: center; color: #ccc;">No requirement images configured yet.</p>';
                      endif;
                      break;
                      
                  case 'clothing':
                      // Get data from accordion
                      $section_title = $accordion['section_title'] ?? 'Belt-Specific Clothing Requirements';
                      $clothing_cards = $accordion['clothing_cards'] ?? [];
                      $shop_section = $accordion['shop_section'] ?? [];
                      
                      // Sort cards by order
                      if (!empty($clothing_cards)) {
                          usort($clothing_cards, function($a, $b) {
                              return ($a['order'] ?? 0) - ($b['order'] ?? 0);
                          });
                      }
                      
                      if (!empty($clothing_cards)):
              ?>
                      <div style="background: rgba(220, 53, 69, 0.1); border: 1px solid rgba(220, 53, 69, 0.3); border-radius: 12px; padding: 2rem; margin-bottom: 2rem;">
                        <h4 style="color: #dc3545; margin-bottom: 1.5rem; font-size: 1.4rem; text-align: center;">
                          <i class="fas fa-tshirt" style="margin-right: 0.5rem;"></i><?php echo htmlspecialchars($section_title); ?>
                        </h4>
                        
                        <div class="row g-4">
                          <?php foreach ($clothing_cards as $clothing_card): ?>
                          <div class="col-lg-6 col-md-12">
                            <div style="background: rgba(255, 255, 255, 0.05); border-radius: 8px; padding: 1.5rem;">
                              <h6 style="color: #dc3545; margin-bottom: 1rem; font-size: 1.1rem; display: flex; align-items: center;">
                                <div style="width: 20px; height: 20px; background: <?php echo htmlspecialchars($clothing_card['belt_color'] ?? 'white'); ?>; border: 2px solid #333; border-radius: 2px; margin-right: 0.75rem; position: relative;">
                                  <?php if (!empty($clothing_card['stripe_color'])): ?>
                                  <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 12px; height: 2px; background: <?php echo htmlspecialchars($clothing_card['stripe_color']); ?>;"></div>
                                  <?php endif; ?>
                                </div>
                                <?php echo htmlspecialchars($clothing_card['title'] ?? 'Belt Level'); ?>
                              </h6>
                              <p style="margin: 0; font-size: 0.95rem; line-height: 1.4;">
                                <?php echo htmlspecialchars($clothing_card['requirement_text'] ?? ''); ?>
                              </p>
                            </div>
                          </div>
                          <?php endforeach; ?>
                        </div>
                      </div>
              <?php
                      else:
                          echo '<p style="text-align: center; color: #ccc;">No clothing requirements configured yet.</p>';
                      endif;
                      
                      // Shop Section
                      if (!empty($shop_section)):
              ?>
                      <!-- Shop Now Section -->
                      <div style="text-align: center; background: rgba(255, 255, 255, 0.05); border-radius: 12px; padding: 2.5rem; border: 1px solid rgba(220, 53, 69, 0.2); margin-top: 2rem;">
                        <h5 style="color: #dc3545; margin-bottom: 1rem; font-size: 1.3rem;">
                          <i class="fas fa-shopping-cart" style="margin-right: 0.5rem;"></i><?php echo htmlspecialchars($shop_section['title'] ?? 'Need Gear or Uniforms?'); ?>
                        </h5>
                        <p style="margin-bottom: 2rem; font-size: 1rem; color: #e9ecef; line-height: 1.5;">
                          <?php echo nl2br(htmlspecialchars($shop_section['description'] ?? '')); ?>
                        </p>
                        
                        <a href="<?php echo htmlspecialchars($shop_section['shop_url'] ?? '#'); ?>" 
                           target="_blank" 
                           rel="noopener noreferrer" 
                           style="display: inline-flex; align-items: center; gap: 0.75rem; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; padding: 1rem 2rem; border-radius: 8px; font-size: 1.1rem; font-weight: 600; text-decoration: none; border: 2px solid #dc3545; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);" 
                           onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 25px rgba(220, 53, 69, 0.4)'; this.style.background='linear-gradient(135deg, #c82333 0%, #a71e2a 100%)';" 
                           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(220, 53, 69, 0.3)'; this.style.background='linear-gradient(135deg, #dc3545 0%, #c82333 100%)';">
                          <i class="fas fa-external-link-alt" style="font-size: 1rem;"></i>
                          <?php echo htmlspecialchars($shop_section['shop_button_text'] ?? 'Shop Now'); ?>
                        </a>
                      </div>
              <?php
                      endif;
                      break;
                      
                  case 'scripts':
                      // Testing Scripts from Admin
                      $script_cards = $accordion['script_cards'] ?? [];
                      $important_note = $accordion['important_note'] ?? [];
                      if (!empty($script_cards)):
              ?>
                      <!-- Testing Scripts Grid -->
                      <div class="row g-4 mb-4">
                        <?php foreach ($script_cards as $script_card): 
                          $isFirstTwo = in_array($script_card['id'], ['testing_tips', 'video_instructions']);
                          $hasBeltColor = isset($script_card['belt_color']);
                          $beltColor = $script_card['belt_color'] ?? '#dc3545';
                          $isStripe = $script_card['has_stripe'] ?? false;
                        ?>
                        <div class="col-lg-4 col-md-6">
                          <div onclick="<?php echo htmlspecialchars($script_card['lightbox_function'] ?? 'void(0)'); ?>()" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(220, 53, 69, 0.3); border-radius: 12px; padding: 1.5rem; text-align: center; cursor: pointer; transition: 0.3s; height: 100%; transform: translateY(0px); box-shadow: none;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(220, 53, 69, 0.3)'; this.style.borderColor='#dc3545';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'; this.style.borderColor='rgba(220, 53, 69, 0.3)';">
                            <?php if ($isFirstTwo): ?>
                              <i class="<?php echo htmlspecialchars($script_card['icon'] ?? 'fas fa-scroll'); ?>" style="font-size: 2rem; color: #dc3545; margin-bottom: 1rem;"></i>
                            <?php else: ?>
                              <div style="width: 30px; height: 20px; background: <?php echo $beltColor; ?>; border: 2px solid #333; border-radius: 3px; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center;<?php echo $isStripe ? ' position: relative;' : ''; ?>">
                                <i class="fas fa-scroll" style="font-size: 0.8rem; color: white;"></i>
                                <?php if ($isStripe): ?>
                                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 20px; height: 2px; background: #333;"></div>
                                <?php endif; ?>
                              </div>
                            <?php endif; ?>
                            <h6 style="color: white; margin-bottom: 0.5rem; font-size: 1.1rem; font-weight: 600;">
                              <?php echo htmlspecialchars($script_card['title'] ?? 'Script'); ?>
                            </h6>
                            <p style="font-size: 0.9rem; color: #b3b3b3; margin: 0; line-height: 1.4;">
                              <?php echo htmlspecialchars($script_card['description'] ?? ''); ?>
                            </p>
                          </div>
                        </div>
                        <?php endforeach; ?>
                      </div>
                      
                      <?php if (!empty($important_note)): ?>
                      <!-- Important Note -->
                      <div style="background: rgba(220, 53, 69, 0.1); border: 1px solid rgba(220, 53, 69, 0.3); padding: 1.5rem; border-radius: 12px; text-align: center;">
                        <h5 style="color: #dc3545; margin-bottom: 1rem; font-size: 1.2rem;">
                          <i class="<?php echo htmlspecialchars($important_note['icon'] ?? 'fas fa-info-circle'); ?>" style="margin-right: 0.5rem;"></i><?php echo htmlspecialchars($important_note['title'] ?? 'Important Note'); ?>
                        </h5>
                        <div style="margin: 0; font-size: 0.95rem; line-height: 1.5;">
                          <?php echo $important_note['content'] ?? ''; ?>
                        </div>
                      </div>
                      <?php endif; ?>
              <?php
                      else:
                          echo '<p style="text-align: center; color: #ccc;">No testing scripts configured yet.</p>';
                      endif;
                      break;
                      
                  default:
                      // Generic content fallback
                      echo '<p style="text-align: center; color: #ccc;">Content type not recognized. Please configure this accordion in the admin panel.</p>';
                      break;
              }
              ?>
            </div>
          </div>
        </div>
        
        <?php endforeach; ?>
        <?php } else { ?>
        <!-- No accordions configured -->
        <div style="padding: 3rem; text-align: center; color: #ccc;">
          <i class="fas fa-exclamation-triangle" style="font-size: 3rem; margin-bottom: 1rem; color: #dc3545;"></i>
          <h4>No Belt Exam Information Available</h4>
          <p>Please configure Belt Exam accordions in the admin panel.</p>
        </div>
        <?php } ?>
        
      </div>
    </div>
  </div>
</section>

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
<section id="kaizen-kenpo" style="background: white; color: #333; position: relative; overflow: hidden; padding: 0; margin: 0;">
  
  <!-- Red Header Section -->
  <div style="background: linear-gradient(135deg, #dc3545 0%, #c82333 50%, #a41e2a 100%); width: 100%; padding: 2.5rem 0; margin: 0;">
    <div class="container" style="position: relative; z-index: 2;">
      <div class="text-center" style="position: relative;">
          <!-- Main Logo -->
        <div style="text-align: center;">
          <img src="<?php echo htmlspecialchars($kenpo_logo['image'] ?? 'assets/images/kenpo/kenpo-logo.png'); ?>" alt="<?php echo htmlspecialchars($kenpo_logo['alt'] ?? 'Kaizen Kenpo Logo'); ?>" style="height: 300px; width: auto;">
        </div>
        <h2 style="color: white; font-family: 'Playfair Display', serif; font-size: 3rem; font-weight: 700; text-decoration: underline; text-underline-offset: 0.3em; text-decoration-color: rgba(255, 255, 255, 0.8); margin: 1rem 0 0 0; position: relative; z-index: 2; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
          <?php echo htmlspecialchars($kenpo_settings['section_title'] ?? 'Kaizen Kenpo'); ?>
        </h2>
      </div>
    </div>
  </div>
  
  <!-- White Content Section -->
  <div class="container" style="position: relative; z-index: 2; padding: 50px 0 50px 0;">
    
    <!-- Kenpo Content with Tabs -->
    <div class="row justify-content-center" style="margin: 0;">
      <div class="col-12" style="padding: 0;">
        <div class="kenpo-tabs-container" style="margin: 0; padding: 0; min-height: 600px; width: 100%;">
          
          <!-- Desktop Tab Navigation -->
          <ul class="nav nav-tabs kenpo-tabs-desktop" id="kenpoTabs" role="tablist" style="border-bottom: 2px solid rgba(220, 53, 69, 0.2); margin: 0; padding-top: 0;">
            <?php foreach ($kenpo_tabs_meta as $index => $tab_meta): 
              $tab_id = $tab_meta['id'] ?? ('tab-' . $index);
              $tab_label = $tab_meta['label'] ?? ('Tab ' . ($index + 1));
              $tab_icon = $tab_meta['icon'] ?? '';
              $is_active = $index === 0 ? 'active' : '';
              $button_id = htmlspecialchars($tab_id . '-tab');
              $target_id = htmlspecialchars('#' . $tab_id . '-content');
              $aria_controls = htmlspecialchars($tab_id . '-content');
              $hover_styles = "onmouseover=\"this.style.borderColor='#dc3545'; this.style.color='#dc3545';\" onmouseout=\"this.style.borderColor='#ddd'; this.style.color='#333333';\"";
            ?>
            <li class="nav-item" role="presentation">
              <button class="nav-link <?php echo $is_active; ?>"
                      id="<?php echo $button_id; ?>"
                      data-bs-toggle="tab"
                      data-bs-target="<?php echo $target_id; ?>"
                      type="button"
                      role="tab"
                      aria-controls="<?php echo $aria_controls; ?>"
                      aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                      style="<?php echo $index === 0
                        ? 'color: white !important; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important; border: 2px solid #dc3545 !important; border-radius: 8px 8px 0 0 !important; font-weight: 600; font-size: 1.1rem; padding: 0.8rem 1.5rem; margin-right: 0.5rem; transition: all 0.3s ease !important; box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3) !important;'
                        : 'color: #333333 !important; background: white !important; border: 2px solid #ddd !important; border-radius: 8px 8px 0 0 !important; font-weight: 600; font-size: 1.1rem; padding: 0.8rem 1.5rem; margin-right: 0.5rem; transition: all 0.3s ease !important; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;'; ?>"
                      <?php echo $index === 0 ? '' : $hover_styles; ?>>
                <?php if (!empty($tab_icon)): ?>
                  <i class="<?php echo htmlspecialchars($tab_icon); ?>" style="margin-right: 8px;"></i>
                <?php endif; ?>
                <?php echo htmlspecialchars($tab_label); ?>
              </button>
            </li>
            <?php endforeach; ?>
          </ul>
          
          <!-- Mobile Dropdown Navigation -->
          <div class="kenpo-tabs-mobile kenpo-dropdown-container">
            <div class="kenpo-dropdown-header" onclick="toggleKenpoDropdown()">
              <span id="kenpo-dropdown-text"><?php echo htmlspecialchars($first_tab_label); ?></span>
              <i class="fas fa-chevron-down" id="kenpo-dropdown-arrow" style="margin-left: 8px; transition: transform 0.3s ease;"></i>
            </div>
            <div class="kenpo-dropdown-menu" id="kenpo-dropdown-menu" style="display: none;">
              <?php foreach ($kenpo_tabs_meta as $index => $tab_meta):
                $tab_id = $tab_meta['id'] ?? ('tab-' . $index);
                $tab_label = $tab_meta['label'] ?? ('Tab ' . ($index + 1));
                $tab_icon = $tab_meta['icon'] ?? '';
                $button_classes = 'kenpo-dropdown-button' . ($index === 0 ? ' active' : '');
              ?>
              <button class="<?php echo $button_classes; ?>"
                      onclick="switchKenpoTab('<?php echo htmlspecialchars($tab_id . '-tab'); ?>', this, '<?php echo htmlspecialchars($tab_label); ?>')">
                <?php if (!empty($tab_icon)): ?>
                  <i class="<?php echo htmlspecialchars($tab_icon); ?>" style="margin-right: 8px;"></i>
                <?php endif; ?>
                <?php echo htmlspecialchars($tab_label); ?>
              </button>
              <?php endforeach; ?>
            </div>
          </div>
          
          <script>
            // Enhanced tab styling functionality
            document.addEventListener('DOMContentLoaded', function() {
              const kenpoTabs = document.querySelectorAll('#kenpoTabs .nav-link');
              
              kenpoTabs.forEach(tab => {
                tab.addEventListener('shown.bs.tab', function(e) {
                  // Reset all tabs to inactive state
                  kenpoTabs.forEach(t => {
                    t.style.color = '#333333';
                    t.style.background = 'white';
                    t.style.borderColor = '#ddd';
                    t.style.boxShadow = '0 2px 4px rgba(0, 0, 0, 0.1)';
                  });
                  
                  // Style the active tab
                  e.target.style.color = 'white';
                  e.target.style.background = 'linear-gradient(135deg, #dc3545 0%, #c82333 100%)';
                  e.target.style.borderColor = '#dc3545';
                  e.target.style.boxShadow = '0 2px 8px rgba(220, 53, 69, 0.3)';
                });
              });
            });
            
            // Mobile dropdown toggle function
            function toggleKenpoDropdown() {
              const menu = document.getElementById('kenpo-dropdown-menu');
              const arrow = document.getElementById('kenpo-dropdown-arrow');
              
              if (menu.style.display === 'none' || menu.style.display === '') {
                menu.style.display = 'block';
                arrow.style.transform = 'rotate(180deg)';
              } else {
                menu.style.display = 'none';
                arrow.style.transform = 'rotate(0deg)';
              }
            }
            
            // Mobile dropdown tab switching function
            function switchKenpoTab(tabId, buttonElement, tabText) {
              // Update mobile dropdown button states
              document.querySelectorAll('.kenpo-dropdown-button').forEach(btn => {
                btn.classList.remove('active');
              });
              buttonElement.classList.add('active');
              
              // Update dropdown header text
              document.getElementById('kenpo-dropdown-text').textContent = tabText;
              
              // Close dropdown menu
              const menu = document.getElementById('kenpo-dropdown-menu');
              const arrow = document.getElementById('kenpo-dropdown-arrow');
              menu.style.display = 'none';
              arrow.style.transform = 'rotate(0deg)';
              
              // Trigger the corresponding desktop tab
              const desktopTab = document.getElementById(tabId);
              if (desktopTab) {
                desktopTab.click();
              }
            }
          </script>
          
          <!-- Tab Content -->
          <div class="tab-content" id="kenpoTabContent" style="min-height: 500px;">
            <?php
            $kenpo_tab_lookup = [];
            foreach ($kenpo_tabs_meta as $meta) {
                $meta_id = $meta['id'] ?? '';
                if ($meta_id !== '') {
                    $kenpo_tab_lookup[$meta_id] = $meta;
                }
            }
            
            $about_dom_id = $kenpo_tab_lookup['about']['id'] ?? ($kenpo_tabs_meta[0]['id'] ?? 'about');
            $ikca_dom_id = $kenpo_tab_lookup['ikca']['id'] ?? 'ikca';
            $gallery_dom_id = $kenpo_tab_lookup['gallery']['id'] ?? 'gallery';
            $contact_dom_id = $kenpo_tab_lookup['contact']['id'] ?? 'contact';
            
            $about_tab = $kenpo_tabs['about'] ?? [];
            $about_hero = $about_tab['hero_image'] ?? [];
            $about_schedule = $about_tab['class_schedule'] ?? [];
            $about_highlight = $about_tab['highlight'] ?? [];
            $about_primary = $about_tab['cta_primary'] ?? [];
            $about_secondary = $about_tab['cta_secondary'] ?? [];
            
            $ikca_tab = $kenpo_tabs['ikca'] ?? [];
            $ikca_image = $ikca_tab['image'] ?? [];
            $ikca_paragraphs = $ikca_tab['paragraphs'] ?? [];
            
            $gallery_tab = $kenpo_tabs['gallery'] ?? [];
            $gallery_intro = $gallery_tab['intro_text'] ?? '';
            $gallery_images = $gallery_tab['images'] ?? [];
            
            $contact_tab = $kenpo_tabs['contact'] ?? [];
            $contact_map = $contact_tab['map'] ?? [];
            $contact_location = $contact_tab['location'] ?? [];
            $contact_info = $contact_tab['contact'] ?? [];
            $contact_class_time = $contact_tab['class_time'] ?? [];
            ?>
            <!-- About Tab -->
            <div class="tab-pane fade<?php echo $about_dom_id === $first_tab_id ? ' show active' : ''; ?>" id="<?php echo htmlspecialchars($about_dom_id); ?>-content" role="tabpanel" aria-labelledby="<?php echo htmlspecialchars($about_dom_id); ?>-tab">
              <div class="row align-items-center g-4">
                <!-- Kenpo Training Photo -->
                <div class="col-lg-6">
                  <div style="text-align: center;">
                    <img src="<?php echo htmlspecialchars($about_hero['src'] ?? 'assets/images/kenpo/shuffle/IMG_0126.webp'); ?>" 
                         alt="<?php echo htmlspecialchars($about_hero['alt'] ?? 'Kaizen Kenpo Training Session'); ?>" 
                         style="width: 100%; max-width: 700px; height: auto;">
                  </div>
                </div>
                
                <!-- About Information -->
                <div class="col-lg-6">
                  <div style="padding: 1rem;">
                    <p style="color: #495057; font-size: 1.2rem; line-height: 1.8; margin-bottom: 1.5rem; text-align: center;">
                      <?php echo htmlspecialchars($about_tab['lead_text'] ?? ''); ?>
                    </p>
                    
                    <!-- Class Schedule -->
                    <div style="background: rgba(44, 62, 80, 0.05); border: 1px solid rgba(44, 62, 80, 0.1); padding: 1rem; border-radius: 6px; text-align: center; margin: 1.5rem 0;">
                      <p style="color: #2c3e50; font-weight: 600; margin-bottom: 0.5rem; font-size: 0.95rem;">
                        <?php echo htmlspecialchars($about_schedule['label'] ?? 'Class Time'); ?>
                      </p>
                      <p style="color: #495057; font-size: 1rem; font-weight: 500; margin: 0;">
                        <?php echo htmlspecialchars($about_schedule['value'] ?? 'Sundays: 1:00pm - 2:00pm'); ?>
                      </p>
                    </div>
                    
                    <!-- Program Information -->
                    <div style="padding: 1.5rem 0; margin-bottom: 2rem; border-left: 4px solid #dc3545; padding-left: 1.5rem;">
                      <h5 style="color: #dc3545; margin-bottom: 1rem;">
                        <i class="<?php echo htmlspecialchars($about_highlight['icon'] ?? 'fas fa-star'); ?>" style="margin-right: 0.5rem;"></i>
                        <?php echo htmlspecialchars($about_highlight['title'] ?? 'Invitation-Only Program'); ?>
                      </h5>
                      <p style="color: #495057; margin: 0; font-size: 1rem; line-height: 1.6;">
                        <?php echo htmlspecialchars($about_highlight['text'] ?? 'Kaizen Kenpo is a division of Kaizen Karate LLC, offering advanced martial arts training for dedicated practitioners.'); ?>
                      </p>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div style="text-align: center; display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                      <a href="<?php echo htmlspecialchars($about_primary['url'] ?? 'https://www.gomotionapp.com/team/mdkfu/page/class-registration'); ?>" 
                         target="_blank"
                         style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; padding: 1.2rem 2rem; border-radius: 25px; text-decoration: none; font-weight: 600; font-size: 1.1rem; display: inline-block; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);"
                         onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(220, 53, 69, 0.4)';"
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(220, 53, 69, 0.3)';">
                        <i class="fas fa-user-plus" style="margin-right: 0.6rem;"></i>
                        <?php echo htmlspecialchars($about_primary['label'] ?? 'Register Now'); ?>
                      </a>
                      
                      <a href="<?php echo htmlspecialchars($about_secondary['url'] ?? 'https://www.kaizenkenpo.net/'); ?>" 
                         target="_blank"
                         style="background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%); color: white; padding: 1.2rem 2rem; border-radius: 25px; text-decoration: none; font-weight: 600; font-size: 1.1rem; display: inline-block; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(44, 62, 80, 0.3);"
                         onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(44, 62, 80, 0.4)';"
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(44, 62, 80, 0.3)';">
                        <i class="fas fa-external-link-alt" style="margin-right: 0.6rem;"></i>
                        <?php echo htmlspecialchars($about_secondary['label'] ?? 'Visit Website'); ?>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- IKCA Kenpo Tab Content -->
            <div class="tab-pane fade<?php echo $ikca_dom_id === $first_tab_id ? ' show active' : ''; ?>" id="<?php echo htmlspecialchars($ikca_dom_id); ?>-content" role="tabpanel" aria-labelledby="<?php echo htmlspecialchars($ikca_dom_id); ?>-tab">
              <div class="row align-items-center g-4">
                <!-- IKCA Logo -->
                <div class="col-lg-6">
                  <div style="text-align: center;">
                    <img src="<?php echo htmlspecialchars($ikca_image['src'] ?? 'assets/images/kenpo/karate-connection.webp'); ?>" 
                         alt="<?php echo htmlspecialchars($ikca_image['alt'] ?? 'IKCA Karate Connection Logo'); ?>" 
                         style="width: 100%; max-width: 400px; height: auto;">
                    <?php if (!empty($ikca_image['caption'])): ?>
                      <p style="color: #666; font-size: 0.9rem; font-style: italic; margin-top: 1rem; text-align: center;">
                        <?php echo htmlspecialchars($ikca_image['caption']); ?>
                      </p>
                    <?php endif; ?>
                  </div>
                </div>
                
                <!-- IKCA Information -->
                <div class="col-lg-6">
                  <div style="padding: 1rem;">
                    <?php if (!empty($ikca_tab['intro_heading'])): ?>
                      <p style="color: #495057; font-size: 1.3rem; line-height: 1.8; margin-bottom: 1.5rem; font-weight: 600;">
                        <?php echo htmlspecialchars($ikca_tab['intro_heading']); ?>
                      </p>
                    <?php endif; ?>
                    
                    <?php foreach ($ikca_paragraphs as $index => $paragraph): ?>
                      <p style="color: #495057; font-size: 1.1rem; line-height: 1.8; margin-bottom: <?php echo $index === array_key_last($ikca_paragraphs) ? '0' : '1.5rem'; ?>;">
                        <?php echo htmlspecialchars($paragraph); ?>
                      </p>
                    <?php endforeach; ?>
                    
                    <?php if (!empty($ikca_tab['video_embed'])): ?>
                      <div style="margin-top: 1.5rem;">
                        <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                          <iframe src="<?php echo htmlspecialchars($ikca_tab['video_embed']); ?>"
                                  title="IKCA Kenpo Video"
                                  style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;"
                                  allowfullscreen
                                  loading="lazy"></iframe>
                        </div>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Photo Gallery Tab -->
            <div class="tab-pane fade<?php echo $gallery_dom_id === $first_tab_id ? ' show active' : ''; ?>" id="<?php echo htmlspecialchars($gallery_dom_id); ?>-content" role="tabpanel" aria-labelledby="<?php echo htmlspecialchars($gallery_dom_id); ?>-tab">
              <div style="display: flex; align-items: flex-start; gap: 2rem;">
                <!-- Gallery Images -->
                <div style="flex: 1;">
                  <div style="text-align: center;">
                    <div class="kenpo-image-shuffle">
                      <div class="shuffle-container">
                        <?php
                          $gallery_items = array_values(array_filter($gallery_images, function ($image) {
                              return !empty($image['src']);
                          }));
                        ?>
                        <?php if (!empty($gallery_items)): ?>
                        <?php foreach ($gallery_items as $index => $image): 
                          $slide_class = $index === 0 ? 'shuffle-slide active' : 'shuffle-slide';
                          $caption_text = $image['caption'] ?? '';
                        ?>
                        <div class="<?php echo $slide_class; ?>" data-caption="<?php echo htmlspecialchars($caption_text); ?>">
                          <img src="<?php echo htmlspecialchars($image['src'] ?? ''); ?>" 
                               alt="<?php echo htmlspecialchars($image['alt'] ?? 'Kaizen Kenpo Training'); ?>"
                               style="width: 100%; max-width: 500px; height: auto;">
                        </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <div class="shuffle-slide active" data-caption="">
                          <img src="assets/images/kenpo/shuffle/IMG_5336.webp"
                               alt="Kaizen Kenpo Training"
                               style="width: 100%; max-width: 500px; height: auto;">
                        </div>
                        <?php endif; ?>
                      </div>
                    
                      <!-- Photo Caption -->
                      <div style="margin-top: 1rem; text-align: center;">
                        <p id="current-caption" style="font-family: 'Playfair Display', serif; font-size: 1.3rem; color: #495057; margin: 0; line-height: 1.4; font-weight: 400;">
                          <?php echo htmlspecialchars($gallery_items[0]['caption'] ?? ''); ?>
                        </p>
                      </div>
                    
                      <!-- Thumbnail Navigation with Arrows -->
                      <div style="display: flex; align-items: center; justify-content: center; gap: 15px; margin-top: 20px;">
                        <!-- Left Arrow -->
                        <button class="shuffle-prev" onclick="changeSlide(-1)" style="background: rgba(0, 0, 0, 0.5); color: white; border: none; width: 35px; height: 35px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease;">
                          <i class="fas fa-chevron-left"></i>
                        </button>
                        
                        <!-- Thumbnails -->
                        <div class="shuffle-thumbnails" style="display: flex; gap: 12px;">
                          <?php foreach ($gallery_items as $index => $image): 
                            $thumb_class = $index === 0 ? 'thumbnail-nav active' : 'thumbnail-nav';
                            $border_style = $index === 0
                              ? 'border: 2px solid rgba(220, 53, 69, 0.8); opacity: 1;'
                              : 'border: 2px solid rgba(255, 255, 255, 0.5); opacity: 0.7;';
                          ?>
                          <img src="<?php echo htmlspecialchars($image['src'] ?? ''); ?>" 
                               onclick="currentSlide(<?php echo $index + 1; ?>)" 
                               class="<?php echo $thumb_class; ?>"
                               style="width: 50px; height: 40px; object-fit: cover; border-radius: 4px; cursor: pointer; transition: all 0.3s ease; <?php echo $border_style; ?>"
                               alt="<?php echo htmlspecialchars($image['alt'] ?? 'Gallery Thumbnail'); ?>">
                          <?php endforeach; ?>
                        </div>
                        
                        <!-- Right Arrow -->
                        <button class="shuffle-next" onclick="changeSlide(1)" style="background: rgba(0, 0, 0, 0.5); color: white; border: none; width: 35px; height: 35px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease;">
                          <i class="fas fa-chevron-right"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Contact & Location Tab Content -->
            <div class="tab-pane fade<?php echo $contact_dom_id === $first_tab_id ? ' show active' : ''; ?>" id="<?php echo htmlspecialchars($contact_dom_id); ?>-content" role="tabpanel" aria-labelledby="<?php echo htmlspecialchars($contact_dom_id); ?>-tab">
              <div class="row align-items-start g-4">
                <!-- Google Maps -->
                <div class="col-lg-6">
                  <div style="padding: 1rem;">
                    <h4 style="color: #dc3545; font-weight: 600; margin-bottom: 1.5rem; font-size: 1.4rem;">
                      <i class="fas fa-map-marker-alt" style="margin-right: 0.5rem;"></i><?php echo htmlspecialchars($contact_map['heading'] ?? 'Find Us'); ?>
                    </h4>
                    
                    <div style="border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                      <iframe 
                        src="<?php echo htmlspecialchars($contact_map['embed_url'] ?? ''); ?>"
                        width="100%" 
                        height="400" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                      </iframe>
                    </div>
                  </div>
                </div>
                
                <!-- Contact & Location Information -->
                <div class="col-lg-6">
                  <div style="padding: 1rem;">
                    <h4 style="color: #dc3545; font-weight: 600; margin-bottom: 1.5rem; font-size: 1.4rem;">
                      <i class="fas fa-map-pin" style="margin-right: 0.5rem;"></i><?php echo htmlspecialchars($contact_location['heading'] ?? 'Location'); ?>
                    </h4>
                    
                    <div style="background: rgba(248, 248, 248, 0.8); border: 1px solid rgba(220, 53, 69, 0.2); padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem;">
                      <p style="color: #495057; font-size: 1rem; line-height: 1.6; margin: 0;">
                        <?php
                        $location_lines = $contact_location['lines'] ?? [];
                        echo implode('<br>', array_map('htmlspecialchars', $location_lines));
                        ?>
                      </p>
                    </div>
                    
                    <h4 style="color: #dc3545; font-weight: 600; margin-bottom: 1.5rem; font-size: 1.4rem;">
                      <i class="fas fa-envelope" style="margin-right: 0.5rem;"></i><?php echo htmlspecialchars($contact_info['heading'] ?? 'Contact Us'); ?>
                    </h4>
                    
                    <div style="background: rgba(248, 248, 248, 0.8); border: 1px solid rgba(220, 53, 69, 0.2); padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem;">
                      <p style="color: #495057; font-size: 1rem; line-height: 1.6; margin: 0;">
                        <strong>Phone:</strong> <?php echo htmlspecialchars($contact_info['phone'] ?? ''); ?><br>
                        <strong>Email:</strong> <?php echo htmlspecialchars($contact_info['email'] ?? ''); ?>
                      </p>
                    </div>
                    
                    <h4 style="color: #dc3545; font-weight: 600; margin-bottom: 1.5rem; font-size: 1.4rem;">
                      <i class="fas fa-clock" style="margin-right: 0.5rem;"></i><?php echo htmlspecialchars($contact_class_time['heading'] ?? 'Class Time'); ?>
                    </h4>
                    
                    <div style="background: rgba(220, 53, 69, 0.1); border: 2px solid rgba(220, 53, 69, 0.3); padding: 1.5rem; border-radius: 8px; text-align: center;">
                      <p style="color: #dc3545; font-size: 1.2rem; font-weight: 600; margin: 0;">
                        <?php echo htmlspecialchars($contact_class_time['value'] ?? 'Sundays: 1:00pm - 2:00pm'); ?>
                      </p>
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
</section>

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
<section id="photo-gallery-preview" style="background: #f8f9fa; padding: 0; margin: 0;">
  <style>
    .gs-thumb-link img { transition: transform 0.35s ease; }
    .gs-thumb-link:hover img { transform: scale(1.06); }
    .gs-cta-btn { transition: all 0.2s ease; }
    .gs-cta-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(164,51,43,0.4) !important; }
    #photo-gallery-preview .gs-header { padding: 2.5rem 0; }
    #photo-gallery-preview .gs-body  { padding: 3rem 15px; }
    @media (max-width: 767px) {
      #photo-gallery-preview .gs-header h2 { font-size: 2.2rem !important; }
      #photo-gallery-preview .gs-header p  { font-size: 1rem !important; }
      #photo-gallery-preview .gs-body      { padding: 2rem 15px; }
    }
    @media (max-width: 400px) {
      #photo-gallery-preview .gs-header h2 { font-size: 1.8rem !important; }
    }
  </style>

  <div class="gs-header" style="background: linear-gradient(135deg, #a4332b 0%, #721c24 100%);">
    <div class="container text-center">
      <h2 style="color:white; font-family:'Playfair Display',serif; font-size:3rem; font-weight:700; text-decoration:underline; text-underline-offset:0.3em; text-decoration-color:rgba(255,255,255,0.7); margin:0;">
        <?php echo display_text('gallery_section', 'title', 'Photo Gallery'); ?>
      </h2>
      <p style="color:rgba(255,255,255,0.9); font-size:1.15rem; margin:0.75rem 0 0;">
        <?php echo display_text('gallery_section', 'subtitle', 'Moments from the Kaizen Karate community'); ?>
      </p>
    </div>
  </div>

  <div class="container gs-body">
    <?php $intro = htmlspecialchars($_gs['intro_text'] ?? ''); if ($intro): ?>
      <p style="text-align:center; color:#555; font-size:1.1rem; max-width:700px; margin:0 auto 2.5rem; line-height:1.7;">
        <?php echo $intro; ?>
      </p>
    <?php endif; ?>

    <?php if (!empty($_gs_images)): ?>
      <div class="row g-2 justify-content-center" style="max-width:920px; margin:0 auto 2.5rem;">
        <?php foreach ($_gs_images as $_img): ?>
          <div class="col-6 col-md-4">
            <a href="gallery.php" class="gs-thumb-link d-block overflow-hidden rounded" style="aspect-ratio:4/3;">
              <img src="<?php echo htmlspecialchars($_img['thumb'] ?? $_img['full']); ?>"
                   alt="<?php echo htmlspecialchars($_img['alt'] ?? $_img['caption'] ?? 'Kaizen Karate'); ?>"
                   loading="lazy"
                   style="width:100%; height:100%; object-fit:cover; display:block;">
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <div class="text-center">
      <a href="gallery.php" class="gs-cta-btn" style="display:inline-block; background:linear-gradient(135deg,#a4332b,#721c24); color:white; font-weight:700; font-size:1rem; padding:0.85rem 2.25rem; border-radius:8px; text-decoration:none; letter-spacing:0.05em; box-shadow:0 4px 15px rgba(164,51,43,0.3); transition:all 0.2s ease;">
        <?php echo display_text('gallery_section', 'button_text', 'View All Photos'); ?> &rarr;
      </a>
    </div>
  </div>
</section>

<!-- Contact Section -->
<section id="contact" class="contact-section" style="background: linear-gradient(135deg, #1a1a1a 0%, #2c2c2c 100%); color: white;">
  <div class="container">
    <h2 class="text-center mb-5" style="color: white; font-family: 'Playfair Display', serif; font-size: 3rem; font-weight: 700; text-decoration: underline; text-underline-offset: 0.3em; text-decoration-color: #dc3545;">Contact Kaizen Karate</h2>
    <p class="text-center mb-5" style="color: #e9ecef; font-size: 1.2rem; line-height: 1.6; font-weight: 400;">
      Ready to begin your martial arts journey? Have Questions? Contact us to learn more about our programs.
    </p>
    <!-- Elfsight Contact Form | Contact Kaizen Karate -->
    <script src="https://elfsightcdn.com/platform.js" async></script>
    <div class="elfsight-app-80a0582f-129a-4b92-98e8-31c4ecf061ba" data-elfsight-app-lazy></div>
  </div>
</section>

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
  <script>
    // Video control functions
    window.togglePlayPause = function() {
        const video = document.getElementById('hero-video');
        const pausePlayIcon = document.getElementById('pausePlayIcon');
        
        if (!video) return;
        
        if (video.paused) {
            video.play().then(() => {
                if (pausePlayIcon) {
                    pausePlayIcon.className = 'fas fa-pause';
                }
            }).catch(e => {
                console.error('Error playing video:', e);
            });
        } else {
            video.pause();
            if (pausePlayIcon) {
                pausePlayIcon.className = 'fas fa-play';
            }
        }
    };
    
    window.toggleMute = function() {
        const video = document.getElementById('hero-video');
        const muteUnmuteIcon = document.getElementById('muteUnmuteIcon');
        
        if (!video) return;
        
        if (video.muted) {
            video.muted = false;
            if (muteUnmuteIcon) {
                muteUnmuteIcon.className = 'fas fa-volume-up';
            }
        } else {
            video.muted = true;
            if (muteUnmuteIcon) {
                muteUnmuteIcon.className = 'fas fa-volume-mute';
            }
        }
    };
  </script>
  
  <!-- Floating Pills Navigation JavaScript -->
  <script>
    // Floating pills navigation functionality
    document.addEventListener('DOMContentLoaded', function() {
      const navbar = document.getElementById('uniqueNavbar');
      const mobileToggle = document.getElementById('mobileMenuToggle');
      const mobileOverlay = document.getElementById('mobileOverlayMenu');
      const mobileNavItems = document.querySelectorAll('.mobile-nav-item');
      
      function handleScroll() {
        const currentScrollY = window.scrollY;
        
        // Navbar scroll effect
        if (currentScrollY > 50) {
          navbar.classList.add('scrolled');
        } else {
          navbar.classList.remove('scrolled');
        }
        
        // Hero overlay now stays visible - no scrolling effects
      }
      
      // Throttled scroll listener
      let ticking = false;
      window.addEventListener('scroll', function() {
        if (!ticking) {
          requestAnimationFrame(function() {
            handleScroll();
            ticking = false;
          });
          ticking = true;
        }
      });
      
      // Mobile menu toggle
      mobileToggle.addEventListener('click', function() {
        this.classList.toggle('active');
        mobileOverlay.classList.toggle('active');
      });
      
      // Close mobile menu when clicking nav items (except dropdown toggles)
      mobileNavItems.forEach(item => {
        item.addEventListener('click', function(e) {
          // Don't close menu if this is a dropdown toggle
          if (!item.classList.contains('mobile-dropdown-toggle')) {
          mobileToggle.classList.remove('active');
          mobileOverlay.classList.remove('active');
          }
        });
      });
      
      // Close mobile menu when clicking outside
      document.addEventListener('click', function(e) {
        if (mobileOverlay.classList.contains('active') && 
            !mobileOverlay.contains(e.target) && 
            !mobileToggle.contains(e.target)) {
          mobileToggle.classList.remove('active');
          mobileOverlay.classList.remove('active');
        }
      });
      
      // Mobile dropdown functionality
      const mobileDropdownToggle = document.querySelector('.mobile-dropdown-toggle');
      const mobileDropdown = document.querySelector('.mobile-dropdown');
      
      if (mobileDropdownToggle && mobileDropdown) {
        mobileDropdownToggle.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();
          mobileDropdown.classList.toggle('show');
        });
        
        // Close mobile dropdown when clicking outside
        document.addEventListener('click', function(e) {
          if (mobileDropdown.classList.contains('show') && 
              !mobileDropdown.contains(e.target)) {
            mobileDropdown.classList.remove('show');
          }
        });
      }

    });
  </script>

  <script src="scripts/lightbox.js"></script>
  <script src="scripts/amenities.js"></script>

  <script src="scripts/wait-list.js"></script>
  <script src="scripts/accordion.js"></script>
  <script src="scripts/test-schedule.js"></script>
<script src="scripts/kenpo-shuffle.js"></script>
  <!-- <script src="scripts/chatbot.js"></script> -->

  
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const phoneInputs = document.querySelectorAll(".phone-input");

        phoneInputs.forEach((input) => {
          input.addEventListener("input", function () {
            let x = input.value.replace(/\D/g, '').substring(0, 10); // Only digits
            let formatted = '';

            if (x.length > 0) formatted += '(' + x.substring(0, 3);
            if (x.length >= 4) formatted += ') ' + x.substring(3, 6);
            if (x.length >= 7) formatted += '-' + x.substring(6, 10);

            input.value = formatted;
          });
        });
        
        const emailInputs = document.querySelectorAll(".email-input");

          emailInputs.forEach((input) => {
            input.addEventListener("input", function () {
              // Remove spaces and convert to lowercase
              input.value = input.value.replace(/\s/g, "").toLowerCase();

              // Optionally: Add simple visual feedback
              if (!input.value.includes("@") || !input.value.includes(".")) {
                input.classList.add("is-invalid");
              } else {
                input.classList.remove("is-invalid");
              }
            });
          });
    });
  </script>

  <!-- Summer Camp Video Lightbox JavaScript -->
  <script>
    // Summer camp video lightbox functions
    window.openSummerCampVideo = function() {
      const lightbox = document.getElementById('summerCampVideoLightbox');
      const video = document.getElementById('summerCampVideo');
      
      if (lightbox && video) {
        lightbox.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        // Small delay to ensure smooth animation
        setTimeout(() => {
          lightbox.classList.add('active');
        }, 10);
        
        // Reset video and ensure volume settings
        video.currentTime = 0;
        video.volume = 0.8;
        video.muted = false;
        
        // Simple approach: just play the video and let browser controls handle volume
        video.play().catch(e => {
          // If autoplay fails, that's ok - user can click play button
          console.log('Autoplay blocked, user needs to click play:', e);
        });
        
        // Ensure volume is set correctly when video loads
        video.addEventListener('loadeddata', function() {
          video.volume = 0.8;
          video.muted = false;
        });
        
        // Ensure volume when user starts playback
        video.addEventListener('play', function() {
          video.volume = 0.8;
          video.muted = false;
          // Alert instead of console.log to bypass CSP
          // alert('Video playing - Volume: ' + video.volume + ', Muted: ' + video.muted);
        });
        
        // Check if video has audio after 2 seconds of playing
        video.addEventListener('timeupdate', function() {
          if (video.currentTime > 2) {
            // Remove this listener after first check
            video.removeEventListener('timeupdate', arguments.callee);
            // Simple audio check - if webkitAudioDecodedByteCount exists and is 0, no audio
            if (typeof video.webkitAudioDecodedByteCount !== 'undefined') {
              if (video.webkitAudioDecodedByteCount === 0) {
                alert('WARNING: Video file appears to have no audio track!');
              }
            }
          }
        });
      }
    };
    
    window.closeSummerCampVideo = function() {
      const lightbox = document.getElementById('summerCampVideoLightbox');
      const video = document.getElementById('summerCampVideo');
      
      if (lightbox && video) {
        lightbox.classList.remove('active');
        video.pause();
        document.body.style.overflow = '';
        
        // Hide lightbox after animation completes
        setTimeout(() => {
          lightbox.style.display = 'none';
        }, 300);
      }
    };
    
    // Close lightbox when clicking outside video
    document.addEventListener('DOMContentLoaded', function() {
      const lightbox = document.getElementById('summerCampVideoLightbox');
      
      if (lightbox) {
        lightbox.addEventListener('click', function(e) {
          if (e.target === this) {
            closeSummerCampVideo();
          }
        });
      }
      
      // Close with Escape key
      document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
          closeSummerCampVideo();
        }
      });
    });
  </script>

  <!-- Calendar Preview JavaScript -->
  <script>
    // Calendar preview lightbox functions
    window.openCalendarPreview = function() {
      const lightbox = document.getElementById('calendarLightbox');
      
      if (lightbox) {
        lightbox.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        // Small delay to ensure smooth animation
        setTimeout(() => {
          lightbox.style.opacity = '1';
        }, 10);
      }
    };
    
    window.closeCalendarPreview = function() {
      const lightbox = document.getElementById('calendarLightbox');
      
      if (lightbox) {
        lightbox.style.opacity = '0';
        document.body.style.overflow = '';
        
        // Hide lightbox after animation completes
        setTimeout(() => {
          lightbox.style.display = 'none';
        }, 300);
      }
    };
    
    // Close lightbox with Escape key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        closeCalendarPreview();
        closeWeekendCalendarPreview();
        closeMatrixLightbox();
        closeRequirementsLightbox();
        closeStripeLightbox();
        closeTestingTipsLightbox();
        closeVideoInstructionsLightbox();
        closeGreenBeltLightbox();
        closePurpleBeltLightbox();
        closeBlueBeltLightbox();
        closeBrownBeltLightbox();
        closeBrownStripeLightbox();
        closeRedBeltLightbox();
        closeRedStripeLightbox();
      }
    });
    
    // Weekend calendar preview lightbox functions
    window.openWeekendCalendarPreview = function() {
      const lightbox = document.getElementById('weekendCalendarLightbox');
      
      if (lightbox) {
        lightbox.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        // Small delay to ensure smooth animation
        setTimeout(() => {
          lightbox.style.opacity = '1';
        }, 10);
      }
    };
    
    window.closeWeekendCalendarPreview = function() {
      const lightbox = document.getElementById('weekendCalendarLightbox');
      
      if (lightbox) {
        lightbox.style.opacity = '0';
        document.body.style.overflow = '';
        
        // Hide lightbox after animation completes
        setTimeout(() => {
          lightbox.style.display = 'none';
        }, 300);
      }
    };
    
    // Belt Exam Requirements Lightbox Functions
    window.openMatrixLightbox = function() {
      const lightbox = document.getElementById('matrixLightbox');
      
      if (lightbox) {
        lightbox.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        // Small delay to ensure smooth animation
        setTimeout(() => {
          lightbox.style.opacity = '1';
        }, 10);
      }
    };
    
    window.closeMatrixLightbox = function() {
      const lightbox = document.getElementById('matrixLightbox');
      
      if (lightbox) {
        lightbox.style.opacity = '0';
        document.body.style.overflow = '';
        
        // Hide lightbox after animation completes
        setTimeout(() => {
          lightbox.style.display = 'none';
        }, 300);
      }
    };
    
    window.openRequirementsLightbox = function() {
      const lightbox = document.getElementById('requirementsLightbox');
      
      if (lightbox) {
        lightbox.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        // Small delay to ensure smooth animation
        setTimeout(() => {
          lightbox.style.opacity = '1';
        }, 10);
      }
    };
    
    window.closeRequirementsLightbox = function() {
      const lightbox = document.getElementById('requirementsLightbox');
      
      if (lightbox) {
        lightbox.style.opacity = '0';
        document.body.style.overflow = '';
        
        // Hide lightbox after animation completes
        setTimeout(() => {
          lightbox.style.display = 'none';
        }, 300);
      }
    };
    
    window.openStripeLightbox = function() {
      const lightbox = document.getElementById('stripeLightbox');
      
      if (lightbox) {
        lightbox.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        // Small delay to ensure smooth animation
        setTimeout(() => {
          lightbox.style.opacity = '1';
        }, 10);
      }
    };
    
    window.closeStripeLightbox = function() {
      const lightbox = document.getElementById('stripeLightbox');
      
      if (lightbox) {
        lightbox.style.opacity = '0';
        document.body.style.overflow = '';
        
        // Hide lightbox after animation completes
        setTimeout(() => {
          lightbox.style.display = 'none';
        }, 300);
      }
    };
    
    // Testing Scripts Lightbox Functions
    window.openTestingTipsLightbox = function() {
      const lightbox = document.getElementById('testingTipsLightbox');
      
      if (lightbox) {
        lightbox.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        setTimeout(() => {
          lightbox.style.opacity = '1';
        }, 10);
      }
    };
    
    window.closeTestingTipsLightbox = function() {
      const lightbox = document.getElementById('testingTipsLightbox');
      
      if (lightbox) {
        lightbox.style.opacity = '0';
        document.body.style.overflow = '';
        
        setTimeout(() => {
          lightbox.style.display = 'none';
        }, 300);
      }
    };
    
    window.openVideoInstructionsLightbox = function() {
      const lightbox = document.getElementById('videoInstructionsLightbox');
      
      if (lightbox) {
        lightbox.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        setTimeout(() => {
          lightbox.style.opacity = '1';
        }, 10);
      }
    };
    
    window.closeVideoInstructionsLightbox = function() {
      const lightbox = document.getElementById('videoInstructionsLightbox');
      
      if (lightbox) {
        lightbox.style.opacity = '0';
        document.body.style.overflow = '';
        
        setTimeout(() => {
          lightbox.style.display = 'none';
        }, 300);
      }
    };
    
    window.openGreenBeltLightbox = function() {
      const lightbox = document.getElementById('greenBeltLightbox');
      
      if (lightbox) {
        lightbox.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        setTimeout(() => {
          lightbox.style.opacity = '1';
        }, 10);
      }
    };
    
    window.closeGreenBeltLightbox = function() {
      const lightbox = document.getElementById('greenBeltLightbox');
      
      if (lightbox) {
        lightbox.style.opacity = '0';
        document.body.style.overflow = '';
        
        setTimeout(() => {
          lightbox.style.display = 'none';
        }, 300);
      }
    };
    
    window.openPurpleBeltLightbox = function() {
      const lightbox = document.getElementById('purpleBeltLightbox');
      
      if (lightbox) {
        lightbox.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        setTimeout(() => {
          lightbox.style.opacity = '1';
        }, 10);
      }
    };
    
    window.closePurpleBeltLightbox = function() {
      const lightbox = document.getElementById('purpleBeltLightbox');
      
      if (lightbox) {
        lightbox.style.opacity = '0';
        document.body.style.overflow = '';
        
        setTimeout(() => {
          lightbox.style.display = 'none';
        }, 300);
      }
    };
    
    window.openBlueBeltLightbox = function() {
      const lightbox = document.getElementById('blueBeltLightbox');
      
      if (lightbox) {
        lightbox.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        setTimeout(() => {
          lightbox.style.opacity = '1';
        }, 10);
      }
    };
    
    window.closeBlueBeltLightbox = function() {
      const lightbox = document.getElementById('blueBeltLightbox');
      
      if (lightbox) {
        lightbox.style.opacity = '0';
        document.body.style.overflow = '';
        
        setTimeout(() => {
          lightbox.style.display = 'none';
        }, 300);
      }
    };
    
    window.openBrownBeltLightbox = function() {
      const lightbox = document.getElementById('brownBeltLightbox');
      
      if (lightbox) {
        lightbox.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        setTimeout(() => {
          lightbox.style.opacity = '1';
        }, 10);
      }
    };
    
    window.closeBrownBeltLightbox = function() {
      const lightbox = document.getElementById('brownBeltLightbox');
      
      if (lightbox) {
        lightbox.style.opacity = '0';
        document.body.style.overflow = '';
        
        setTimeout(() => {
          lightbox.style.display = 'none';
        }, 300);
      }
    };
    
    window.openBrownStripeLightbox = function() {
      const lightbox = document.getElementById('brownStripeLightbox');
      if (lightbox) {
        lightbox.style.opacity = '0';
        lightbox.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        setTimeout(() => {
          lightbox.style.opacity = '1';
        }, 10);
      }
    };
    
    window.closeBrownStripeLightbox = function() {
      const lightbox = document.getElementById('brownStripeLightbox');
      
      if (lightbox) {
        lightbox.style.opacity = '0';
        document.body.style.overflow = '';
        
        setTimeout(() => {
          lightbox.style.display = 'none';
        }, 300);
      }
    };
    
    window.openRedBeltLightbox = function() {
      const lightbox = document.getElementById('redBeltLightbox');
      if (lightbox) {
        lightbox.style.opacity = '0';
        lightbox.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        setTimeout(() => {
          lightbox.style.opacity = '1';
        }, 10);
      }
    };
    
    window.closeRedBeltLightbox = function() {
      const lightbox = document.getElementById('redBeltLightbox');
      
      if (lightbox) {
        lightbox.style.opacity = '0';
        document.body.style.overflow = '';
        
        setTimeout(() => {
          lightbox.style.display = 'none';
        }, 300);
      }
    };
    
    window.openRedStripeLightbox = function() {
      const lightbox = document.getElementById('redStripeLightbox');
      
      if (lightbox) {
        lightbox.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        setTimeout(() => {
          lightbox.style.opacity = '1';
        }, 10);
      }
    };
    
    window.closeRedStripeLightbox = function() {
      const lightbox = document.getElementById('redStripeLightbox');
      
      if (lightbox) {
        lightbox.style.opacity = '0';
        document.body.style.overflow = '';
        
        setTimeout(() => {
          lightbox.style.display = 'none';
        }, 300);
      }
    };
  </script>

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
