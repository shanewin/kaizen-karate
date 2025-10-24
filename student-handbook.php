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
  <title>Student Handbook | Kaizen Karate</title>
  <meta name="description" content="View Kaizen Karate's comprehensive student handbook including guidelines, expectations, and important information for all students and parents.">
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Dancing+Script:wght@400;600&display=swap" rel="stylesheet">
  <!-- Font Awesome CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="styles/style.css?v=<?php echo time(); ?>">

  <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png?v=2">
  <link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-96x96.png?v=2">
  <link rel="icon" type="image/svg+xml" href="favicon/favicon.svg?v=2">
  <link rel="icon" type="image/x-icon" href="favicon/favicon.ico?v=2">
  <link rel="manifest" href="favicon/site.webmanifest?v=2">

  <link rel="stylesheet" type="text/css" href="assets/fonts/MyWebfontsKit/MyWebfontsKit.css">
</head>
<body>

<!-- Floating Pills Reverse Navigation -->
<nav class="floating-pills-nav fixed-top" id="uniqueNavbar">
  <div class="nav-container">
    
    <!-- Karate Logo (Left Side) -->
    <div class="luxury-brand-container">
      <a class="luxury-brand" href="index.php">
        <img src="<?php echo display_media('logo', 'main', 'assets/images/logo.png'); ?>" 
             alt="<?php echo display_media('logo', 'alt', 'Kaizen Karate'); ?>" 
             class="brand-logo-prominent">
      </a>
    </div>
    
    <!-- Navigation Menu (Right Side) -->
    <div class="mega-nav-container" id="megaNavContainer">
      <ul class="mega-navbar-nav">
        <li class="mega-nav-item mega-dropdown register-dropdown">
          <a class="mega-nav-link register-nav-link mega-dropdown-toggle" href="#register" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo display_text('navigation', 'register_dropdown.title', 'Register Now'); ?>
            <i class="fas fa-chevron-down ms-1"></i>
          </a>
          <div class="mega-dropdown-menu">
            <div class="mega-menu-container horizontal-layout">
              <div class="mega-menu-column after-school-column register-section-with-stripes">
                <h6 class="mega-menu-header">
                  <span class="header-line-1"><?php echo display_text('navigation', 'register_dropdown.after_school.header_line1', 'AFTER SCHOOL'); ?></span>
                  <span class="header-line-2">WEEKEND & EVENING</span>
                </h6>
                <div class="register-button-container">
                    <a class="mega-menu-item mega-register-btn" href="https://www.gomotionapp.com/team/mdkfu/page/class-registration" target="_blank">Register Now!</a>
                </div>
              </div>
              
              <div class="mega-menu-vertical-divider"></div>
              
              <div class="mega-menu-column register-section-with-stripes">
                <h6 class="mega-menu-header"><?php echo display_text('navigation', 'register_dropdown.kaizen_dojo.header', 'KAIZEN DOJO'); ?></h6>
                <div class="register-button-container">
                  <a class="mega-menu-item mega-register-btn" href="https://form.jotform.com/251533593606459" target="_blank">Register Now!</a>
                </div>
              </div>
              
              <div class="mega-menu-vertical-divider"></div>
              
              <div class="mega-menu-column">
                <h6 class="mega-menu-header">Summer Camp</h6>
                <div class="mega-menu-text">
                  <p class="mega-menu-summer-text">
                    <?php echo display_text('navigation', 'register_dropdown.summer_camp.text', 'Registration for Summer Camp 2026 has not opened yet.'); ?> 
                    <a href="index.php#summer-camp" class="summer-camp-explore-link">
                      Explore our 2025 Summer Camp program
                    </a> 
                    to see what we have in store for next year!
                  </p>
                </div>
              </div>
              
              <div class="mega-menu-vertical-divider"></div>
              
              <div class="mega-menu-column register-section-with-stripes">
                <h6 class="mega-menu-header"><?php echo display_text('navigation', 'register_dropdown.belt_exams.header', 'Belt Exams'); ?></h6>
                <div class="register-button-container" style="display: flex; flex-direction: column; gap: 12px;">
                  <a class="mega-menu-item mega-register-btn" href="index.php#belt-exam" style="width: 80% !important; min-width: 160px !important; font-size: 0.8rem !important; text-transform: none !important; line-height: 1.3; padding: 14px 12px !important; border-radius: 8px !important; background: linear-gradient(135deg, #a4332b, #d4524a) !important; border: 2px solid rgba(255, 255, 255, 0.3) !important; box-shadow: 0 4px 12px rgba(164, 51, 43, 0.3) !important; display: block !important; text-align: center !important; margin: 4px auto !important;">
                    <div style="font-weight: 800; margin-bottom: 4px; font-size: 0.9rem;">REGISTER!</div>
                    <div style="font-weight: 700; font-size: 1rem; color: #ffffff; text-shadow: 0 1px 2px rgba(0,0,0,0.3);">Youth Exam</div>
                    <div style="font-size: 0.75rem; opacity: 0.95; margin-top: 2px; font-weight: 600;">Saturday, Nov 15th</div>
                  </a>
                  <a class="mega-menu-item" href="index.php#belt-exam" style="color: #a4332b; text-decoration: underline; font-size: 0.9rem; margin-top: 8px; font-weight: 600; transition: all 0.3s ease;" onmouseover="this.style.color='#8b2922'; this.style.textDecoration='none';" onmouseout="this.style.color='#a4332b'; this.style.textDecoration='underline';">View Process >></a>
                </div>
              </div>
            </div>
          </div>
        </li>
        <li class="mega-nav-item">
          <a class="mega-nav-link" href="index.php#about"><?php echo display_text('navigation', 'menu_items.0.text', 'About'); ?></a>
        </li>
        <li class="mega-nav-item">
          <a class="mega-nav-link summer-camp-nav" href="index.php#summer-camp"><?php echo display_text('navigation', 'menu_items.1.text', 'Summer Camp'); ?></a>
        </li>
        <li class="mega-nav-item">
          <a class="mega-nav-link" href="index.php#kaizen-dojo"><?php echo display_text('navigation', 'menu_items.2.text', 'Kaizen Dojo'); ?></a>
        </li>
        <li class="mega-nav-item">
          <a class="mega-nav-link" href="index.php#after-school"><?php echo display_text('navigation', 'menu_items.3.text', 'Weekend & Evening'); ?></a>
        </li>
        <li class="mega-nav-item">
          <a class="mega-nav-link" href="index.php#online-store"><?php echo display_text('navigation', 'menu_items.4.text', 'Online Store'); ?></a>
        </li>
        <li class="mega-nav-item">
          <a class="mega-nav-link" href="index.php#belt-exam"><?php echo display_text('navigation', 'menu_items.5.text', 'Belt Exam'); ?></a>
        </li>
        <li class="mega-nav-item">
          <a class="mega-nav-link" href="index.php#kaizen-kenpo"><?php echo display_text('navigation', 'menu_items.6.text', 'Kaizen Kenpo'); ?></a>
        </li>
        <li class="mega-nav-item">
          <a class="mega-nav-link" href="index.php#contact"><?php echo display_text('navigation', 'menu_items.7.text', 'Contact'); ?></a>
        </li>
      </ul>
    </div>

    <!-- Mobile Brand Text (visible only on mobile) -->
    <div class="mobile-brand-text">
      <span class="mobile-brand-name">KAIZEN KARATE</span>
    </div>
    
    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" id="mobileMenuToggle">
      <span class="toggle-line"></span>
      <span class="toggle-line"></span>
      <span class="toggle-line"></span>
    </button>
    
  </div>
  
  <!-- Mobile Overlay Menu -->
  <div class="mobile-overlay-menu" id="mobileOverlayMenu">
    <div class="mobile-menu-content">
      <div class="mobile-brand">
        <img src="<?php echo display_media('logo', 'main', 'assets/images/logo.png'); ?>" 
             alt="<?php echo display_media('logo', 'alt', 'Kaizen Karate'); ?>" 
             class="mobile-brand-logo">
      </div>
      <div class="mobile-nav-items">
        <div class="mobile-dropdown" data-delay="0">
          <a href="#" class="mobile-nav-item register-mobile-nav mobile-dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo display_text('navigation', 'register_dropdown.title', 'Register Now'); ?>
            <i class="fas fa-chevron-down ms-1"></i>
          </a>
          <div class="mobile-dropdown-menu">
            <div class="mobile-dropdown-section register-section-with-stripes">
              <h6>After School<br>Weekend & Evening</h6>
              <a href="https://www.gomotionapp.com/team/mdkfu/page/class-registration" target="_blank" class="mobile-dropdown-item">Register Now!</a>
            </div>
            <hr class="mobile-menu-divider">
            <div class="mobile-dropdown-section register-section-with-stripes">
              <h6>Kaizen Dojo</h6>
              <a href="https://form.jotform.com/251533593606459" target="_blank" class="mobile-dropdown-item">Register Now!</a>
            </div>
            <hr class="mobile-menu-divider">
            <div class="mobile-dropdown-section register-section-with-stripes">
              <h6>Summer Camp</h6>
              <p class="mobile-dropdown-text">Registration for Summer Camp 2026 has not opened yet.</p>
            </div>
            <hr class="mobile-menu-divider">
            <div class="mobile-dropdown-section register-section-with-stripes">
              <h6>Belt Exams</h6>
              <a href="index.php#belt-exam" class="mobile-dropdown-item" style="background: linear-gradient(135deg, #a4332b, #d4524a) !important; color: white !important; border: 2px solid rgba(255, 255, 255, 0.3) !important; border-radius: 6px !important; padding: 8px 10px !important; margin: 6px auto !important; text-decoration: none !important; display: block !important; text-align: center !important; width: 85% !important; max-width: 200px !important;">
                <span style="display: block; font-weight: 800; font-size: 0.7rem; margin-bottom: 2px;">REGISTER!</span>
                <span style="display: block; font-size: 0.6rem; font-weight: 600;">Youth Exam - Nov 15th</span>
              </a>
              <div style="text-align: center; margin-top: 12px;">
                <a href="index.php#belt-exam" style="color: #a4332b !important; text-decoration: underline !important; font-size: 0.9rem !important; font-weight: 600 !important; transition: all 0.3s ease !important; background: none !important; border: none !important; padding: 0 !important; margin: 0 !important;" onmouseover="this.style.color='#8b2922'; this.style.textDecoration='none';" onmouseout="this.style.color='#a4332b'; this.style.textDecoration='underline';">View Process >></a>
              </div>
            </div>
          </div>
        </div>
        <a href="index.php#about" class="mobile-nav-item" data-delay="50"><?php echo display_text('navigation', 'menu_items.0.text', 'About'); ?></a>
        <a href="index.php#summer-camp" class="mobile-nav-item summer-camp-mobile-nav" data-delay="100"><?php echo display_text('navigation', 'menu_items.1.text', 'Summer Camp'); ?></a>
        <a href="index.php#kaizen-dojo" class="mobile-nav-item" data-delay="125"><?php echo display_text('navigation', 'menu_items.2.text', 'Kaizen Dojo'); ?></a>
        <a href="index.php#after-school" class="mobile-nav-item" data-delay="150"><?php echo display_text('navigation', 'menu_items.3.text', 'Weekend & Evening'); ?></a>
        <a href="index.php#online-store" class="mobile-nav-item" data-delay="175"><?php echo display_text('navigation', 'menu_items.4.text', 'Online Store'); ?></a>
        <a href="index.php#belt-exam" class="mobile-nav-item" data-delay="185"><?php echo display_text('navigation', 'menu_items.5.text', 'Belt Exam'); ?></a>
        <a href="index.php#kaizen-kenpo" class="mobile-nav-item" data-delay="195"><?php echo display_text('navigation', 'menu_items.6.text', 'Kaizen Kenpo'); ?></a>
        <a href="index.php#contact" class="mobile-nav-item" data-delay="205"><?php echo display_text('navigation', 'menu_items.7.text', 'Contact'); ?></a>
      </div>
    </div>
  </div>
  
</nav>

  <!-- Fixed Sidebar Widget -->
  <div class="fixed-sidebar-widget">
    <div class="sidebar-button">
      <a href="https://www.facebook.com/people/Kaizen-Karate/100063714665511/" target="_blank" class="sidebar-btn" title="Follow us on Facebook">
        <i class="fab fa-facebook-f"></i>
      </a>
    </div>
    <div class="sidebar-button">
      <a href="https://www.tiktok.com/@kaizenkaratemd" target="_blank" class="sidebar-btn" title="Follow us on TikTok">
        <i class="fab fa-tiktok"></i>
      </a>
    </div>
    <div class="sidebar-button">
      <a href="https://www.instagram.com/kaizen_karate/" target="_blank" class="sidebar-btn" title="Follow us on Instagram">
        <i class="fab fa-instagram"></i>
      </a>
    </div>
    <div class="sidebar-button">
      <a href="https://coachv6z.podbean.com/" target="_blank" class="sidebar-btn" title="Listen to our Podcast">
        <i class="fas fa-podcast"></i>
      </a>
    </div>
  </div>

<!-- Student Handbook Content Section -->
<section class="policies-section py-5" style="margin-top: 100px;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        
        <!-- Page Header -->
        <div class="text-center mb-5">
          <h1 style="color: var(--accent); font-weight: 700; margin-bottom: 20px;">Student Handbook</h1>
          <p class="lead" style="color: var(--text-dark); font-size: 1.1rem;">
            Important information and guidelines for all Kaizen Karate students and parents.
          </p>
        </div>

        <!-- Mission Statement -->
        <div class="policy-section mb-5">
          <h2 style="color: var(--accent); font-weight: 600; margin-bottom: 20px; border-bottom: 2px solid var(--accent); padding-bottom: 10px;">Mission Statement</h2>
          <p class="mb-0" style="font-style: italic; color: var(--text-dark);">Our mission is to teach the highest quality of martial arts in the spirit of continuous improvement</p>
        </div>

        <!-- FAQs Section -->
        <div class="policy-section mb-5">
          <h2 style="color: var(--accent); font-weight: 600; margin-bottom: 30px; border-bottom: 2px solid var(--accent); padding-bottom: 10px;">FAQs</h2>
          
          <div class="mb-4">
            <h4 style="color: var(--text-dark); font-weight: 600; margin-bottom: 12px;">How old do I have to be to begin taking classes?</h4>
            <p class="mb-0">We start taking students as young as 3.5yrs old and as old as 65yrs old. Little Ninja classes are designed for ages 3.5yrs - 4yrs old. Beginner level youth classes cater to ages 5yrs - 8yrs old. Beginner level youth students who are ages 8yrs - 11yrs old should attend an "ALL Belts" class to start.</p>
          </div>

          <hr style="border-top: 1px solid rgba(220, 53, 69, 0.2); margin: 2rem 0;">

          <div class="mb-4">
            <h4 style="color: var(--text-dark); font-weight: 600; margin-bottom: 12px;">What should my child wear to class?</h4>
            <p class="mb-0">Before ordering a uniform students should wear long comfortable pants and t-shirt to class each week (dark colors such as black are preferred without any logos). Students will have time to change before the start of class. <a href="https://kaizenkarate.store/" target="_blank">Click here</a> to see the clothing requirements by belt.</p>
          </div>

          <hr style="border-top: 1px solid rgba(220, 53, 69, 0.2); margin: 2rem 0;">

          <div class="mb-4">
            <h4 style="color: var(--text-dark); font-weight: 600; margin-bottom: 12px;">Do I need to order a uniform?</h4>
            <p class="mb-0">When a student first starts karate classes a uniform is optional. Once a student determines that they are interested in continuing classes past their initial session then a black uniform can be ordered through the <a href="https://kaizenkarate.store/" target="_blank">Kaizen Karate website</a> at our discounted group rate. <a href="https://kaizenkarate.store/" target="_blank">Click here</a> to see the clothing requirements by belt.</p>
          </div>

          <hr style="border-top: 1px solid rgba(220, 53, 69, 0.2); margin: 2rem 0;">

          <div class="mb-4">
            <h4 style="color: var(--text-dark); font-weight: 600; margin-bottom: 12px;">Will there be sparring or fighting in class?</h4>
            <p class="mb-0">Before a student is allowed to participate in partner drills they must first learn basic kicks, punches and blocks. Movement drills will follow the technique training.</p>
          </div>

          <hr style="border-top: 1px solid rgba(220, 53, 69, 0.2); margin: 2rem 0;">

          <div class="mb-4">
            <h4 style="color: var(--text-dark); font-weight: 600; margin-bottom: 12px;">When should I purchase sparring equipment for my son/daughter?</h4>
            <p class="mb-0">Students can invest in sparring equipment after completing a full 8-week session of karate and not before. Students must have all sparring equipment by yellow belt rank. Details of what to purchase can be found <a href="https://kaizenkarate.store/" target="_blank">here</a>.</p>
          </div>

          <hr style="border-top: 1px solid rgba(220, 53, 69, 0.2); margin: 2rem 0;">

          <div class="mb-4">
            <h4 style="color: var(--text-dark); font-weight: 600; margin-bottom: 12px;">How safe is the class?</h4>
            <p class="mb-0">We are very sensitive to the safety of every student in our karate program. At no time will a student be in danger in any Kaizen Karate class. The instructor will cover all safety procedures in detail before the start of each drill.</p>
          </div>

          <hr style="border-top: 1px solid rgba(220, 53, 69, 0.2); margin: 2rem 0;">

          <div class="mb-4">
            <h4 style="color: var(--text-dark); font-weight: 600; margin-bottom: 12px;">Will students earn colored belts?</h4>
            <p class="mb-0">Yes, students will be allowed to test for colored belts upon invitation by their instructor. The instructor will announce the <a href="index.php#belt-exam">dates of belt exams</a> in class and parents will receive email notification as well.</p>
          </div>

          <hr style="border-top: 1px solid rgba(220, 53, 69, 0.2); margin: 2rem 0;">

          <div class="mb-4">
            <h4 style="color: var(--text-dark); font-weight: 600; margin-bottom: 12px;">When does the next session start?</h4>
            <p class="mb-0">Weekend classes run in 2-month cycles. Other programs vary depending on the location. For details email us at <a href="mailto:coach.v@kaizenkaratemd.com">coach.v@kaizenkaratemd.com</a> or visit our list of classes <a href="index.php#after-school">here</a>.</p>
          </div>

          <hr style="border-top: 1px solid rgba(220, 53, 69, 0.2); margin: 2rem 0;">

          <div class="mb-4">
            <h4 style="color: var(--text-dark); font-weight: 600; margin-bottom: 12px;">How do I enroll my son/daughter for classes?</h4>
            <p class="mb-0">To register, visit us online by <a href="https://www.gomotionapp.com/team/mdkfu/page/class-registration" target="_blank">clicking here</a>. Students must be enrolled in class *prior* to participating. We ask that all students are registered online as we do not accept cash or check.</p>
          </div>

          <hr style="border-top: 1px solid rgba(220, 53, 69, 0.2); margin: 2rem 0;">

          <div class="mb-4">
            <h4 style="color: var(--text-dark); font-weight: 600; margin-bottom: 12px;">How do I tie my belt?</h4>
            <div class="text-center my-4">
              <div class="ratio ratio-16x9" style="max-width: 560px; margin: 0 auto;">
                <iframe src="https://www.youtube.com/embed/t7l6g2bbhTg" title="How to Tie a Karate Belt" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen style="border-radius: 8px;"></iframe>
              </div>
            </div>
          </div>
        </div>

        <!-- Getting Started -->
        <div class="policy-section mb-5">
          <h2 style="color: var(--accent); font-weight: 600; margin-bottom: 20px; border-bottom: 2px solid var(--accent); padding-bottom: 10px;">Getting Started</h2>
          
          <h4 style="color: var(--text-dark); font-weight: 600; margin-bottom: 15px;">Tuition</h4>
          <p class="mb-3">Payment must be received *prior* to starting classes.</p>
          <p class="mb-3">To pay tuition for weeknight or weekend classes please <a href="https://www.gomotionapp.com/team/mdkfu/page/class-registration" target="_blank">click here</a>.</p>
          <p class="mb-4">To pay tuition for one of our programs that you do not see listed on the website please email us at <a href="mailto:coach.v@kaizenkaratemd.com">coach.v@kaizenkaratemd.com</a>.</p>

          <h4 style="color: var(--text-dark); font-weight: 600; margin-bottom: 15px;">Session Dates - Weekend & Evening Classes</h4>
          <ul class="mb-3" style="color: var(--text-dark);">
            <li>Session 1: Jan 1 - Feb 28</li>
            <li>Session 2: Mar 1 - Apr 30</li>
            <li>Session 3: May 1 - Jun 30</li>
            <li>Session 4: Jul 1 - Aug 31</li>
            <li>Session 5: Sep 1 - Oct 31</li>
            <li>Session 6: Nov 1 - Dec 31</li>
          </ul>
          <p class="mb-3">All weekend and evening classes following the scheduled listed above for session dates. Students must register for classes prior to the start of a new session.</p>

          <h4 style="color: var(--text-dark); font-weight: 600; margin-bottom: 15px; margin-top: 25px;">Refund Policy</h4>
          <p class="mb-3"><a href="policies.php">CLICK HERE</a> to view our refund policy</p>

          <h4 style="color: var(--text-dark); font-weight: 600; margin-bottom: 15px;">Make-up Policy</h4>
          <p class="mb-0"><a href="policies.php">CLICK HERE</a> to view our make-up policy</p>
        </div>

        <!-- General Rules -->
        <div class="policy-section mb-5">
          <h2 style="color: var(--accent); font-weight: 600; margin-bottom: 20px; border-bottom: 2px solid var(--accent); padding-bottom: 10px;">General Rules</h2>
          
          <p class="mb-3"><strong>Food & drink policy</strong> – water bottles are permitted and encouraged at all class locations. No food or drink is allowed in class.</p>
          
          <p class="mb-3"><strong>Jewelry & watches</strong> - At no time should a student wear any jewelry or watches to class. We have found that jewelry can easily be damaged and also cause injury to another student.</p>
          
          <p class="mb-3"><strong>Parent pick-up</strong> – Instructors will always wait until the last child is picked up from class. Please make sure to arrive on time to pick up your child. A written note is required if a person other than the child's parent arrives for pick up. If any special needs exist please inform the instructor in writing.</p>
          
          <p class="mb-0"><strong>Video Taping</strong> - *NO* Video taping is allowed during regular class time.</p>
        </div>

        <!-- Inclement Weather Policy -->
        <div class="policy-section mb-5">
          <h2 style="color: var(--accent); font-weight: 600; margin-bottom: 20px; border-bottom: 2px solid var(--accent); padding-bottom: 10px;">Inclement Weather Policy</h2>
          
          <p class="mb-3">The Inclement Weather Policy applies to all Kaizen Karate classes including after school programs, weeknight classes, and weekend classes.</p>
          
          <h4 style="color: var(--text-dark); font-weight: 600; margin-bottom: 15px;">For updated closing information:</h4>
          <ol class="mb-3" style="color: var(--text-dark);">
            <li><a href="https://www.kaizenfitnessusa.com" target="_blank">www.kaizenfitnessusa.com</a> - updates can be found on homepage</li>
            <li>Phone – call our office at <strong>301-938-2711</strong>. Voice mail will be updated at all times with closings and other important scheduling information.</li>
          </ol>
          
          <p class="mb-4">If no cancellations are announced, it should be assumed that the karate classes are being held.</p>

          <h4 style="color: var(--text-dark); font-weight: 600; margin-bottom: 15px;">Timing of Announcements</h4>
          <p class="mb-2">When possible, notification of class closing or class cancellations will be made by the following times:</p>
          <ul class="mb-0" style="color: var(--text-dark);">
            <li>Morning cancellation or closing - announcement out by 6 a.m.</li>
            <li>Afternoon cancellation or closing - announcement out by 10 a.m.</li>
            <li>Evening cancellation or closing - announcement out 2 p.m.</li>
          </ul>
        </div>

        <!-- Equipment -->
        <div class="policy-section mb-5" id="equipment">
          <h2 style="color: var(--accent); font-weight: 600; margin-bottom: 20px; border-bottom: 2px solid var(--accent); padding-bottom: 10px;">Equipment</h2>
          
          <h4 style="color: var(--text-dark); font-weight: 600; margin-bottom: 15px;">REQUIREMENTS</h4>
          <ul class="mb-4" style="color: var(--text-dark);">
            <li><strong>White Belts</strong> - no uniform required (wear comfortable clothing to class)</li>
            <li><strong>Orange Belts</strong> - need a black Kaizen Karate t-shirt prior to testing for this belt</li>
            <li><strong>Yellow Belts</strong> - must have a black Kaizen Karate uniform prior to testing for this belt (NO white colored uniforms are permitted)</li>
            <li><strong>Green Belts</strong> - must have a full set of sparring gear 3-4 months prior to testing for this belt</li>
          </ul>

          <p class="mb-3">Please allow 2-3 business days for uniforms and sparring gear to arrive. All equipment will be delivered directly to your shipping address.</p>
          <p class="mb-4"><a href="https://kaizenkarate.store/" target="_blank" class="btn btn-danger">Click To Order Equipment</a></p>

          <p class="mb-3"><strong>Mouth guards & cups (boys only)</strong> – boys and girls must wear a mouth guard at all times when participating in sparring drills. A protective cup must be worn by boys at all times when participating in sparring drills. Extra mouth guards and cups are *not* available during class time and can be purchased through our website.</p>

          <p class="mb-3"><strong>Uniforms</strong> - all students must wear a black karate uniform to class each week with the Kaizen Karate logo on the back. These uniforms are only available through the Kaizen Karate website.</p>

          <p class="mb-3">We ask that *no* outside uniforms with logos from other schools are worn during class time in any Kaizen Karate class.</p>

          <p class="mb-3"><strong>Guards</strong> – only students who have completed one session of karate should invest in sparring equipment. Sparring sets can be purchased on our website and include head, hand, mouth, foot and protective cup (boys). <a href="https://kaizenkarate.store/" target="_blank">Click here to order</a>.</p>

          <p class="mb-3"><strong>Gi top policy</strong> – students should wear full uniform top & bottom to tournaments and belt exams. All students under black belt rank must wear a black uniform.</p>

          <p class="mb-3"><strong>T-shirts</strong> – students are allowed to wear Kaizen Karate school t-shirt to class in lieu of uniform top especially during summer months when the weather is hot.</p>

          <p class="mb-3"><strong>Patches</strong> – all patches should be worn on the left leg near the bottom of your karate uniform.</p>

          <p class="mb-3"><strong>Karate bag</strong> - we suggest that all students invest in a dedicated bag to carry all karate gear.</p>

          <p class="mb-3"><strong>Tagging</strong> - students must have their name written on all sparring equipment. If a student has black or blue guards then the use of a silver marker is encouraged to make sure names are visible.</p>

          <p class="mb-0"><strong>Lost and found</strong> – at the end of every class the instructor will place all missing clothing and sparring gear in the lost and found or front office of the school / facility.</p>
        </div>

        <!-- Sparring Rules & Tournaments -->
        <div class="policy-section mb-5">
          <h2 style="color: var(--accent); font-weight: 600; margin-bottom: 20px; border-bottom: 2px solid var(--accent); padding-bottom: 10px;">Sparring Rules & Tournaments</h2>
          
          <p class="mb-3"><strong>Contact</strong> – no touch is allowed to the face at any time during sparring drills. Light touch is allowed to the body and head guard.</p>

          <p class="mb-3"><strong>Scoring</strong> – students are allowed to strike to the stomach, chest, side of the body, side of the head guard and forehead of the head guard. Students are not allowed to strike below the belt, to the back, neck or top of the head at any time.</p>

          <p class="mb-0"><strong>Intramural vs. Open Invitational</strong> - All students 5-16 years old are encouraged to participate in our Annual Intramural tournament(s). Students will compete with other Kaizen Karate students of similar belt rank and age. Once a student reaches brown belt level they are allowed to compete in open invitational tournaments where we visit other karate schools. Adult students are allowed to compete in open invitational tournaments.</p>
        </div>

        <!-- Belt Exams -->
        <div class="policy-section mb-5">
          <h2 style="color: var(--accent); font-weight: 600; margin-bottom: 20px; border-bottom: 2px solid var(--accent); padding-bottom: 10px;">Belt Exams</h2>
          
          <p class="mb-3"><strong>Guidelines vs. Standards</strong> – the Belt Promotion guidelines serve as "minimums" that a student must complete in order to achieve the next rank. The instructor will make a student wait to test for the next rank if it is in the student's best interest for long-term development.</p>

          <p class="mb-3"><strong>Pre-testing</strong> - to ensure that a student is ready to take a belt exam the instructor of the class will have at least two pre-testing sessions during regular class time. The instructor is checking to see if the student has demonstrated a strong understanding of the material.</p>

          <p class="mb-2">Students are invited to take the belt exam based on 3 main criteria:</p>
          <ol style="color: var(--text-dark);">
            <li><strong>Attendance</strong> – must have 80% attendance record or better</li>
            <li><strong>Attitude</strong> – must demonstrate good sportsmanship towards peers and instructors</li>
            <li><strong>Karate</strong>
              <ul style="margin-top: 8px;">
                <li>techniques</li>
                <li>sparring</li>
                <li>master form</li>
                <li>JuJitsu (if applicable for belt level)</li>
              </ul>
            </li>
          </ol>
        </div>

        <!-- 2 Times to Use Karate -->
        <div class="policy-section mb-5">
          <h2 style="color: var(--accent); font-weight: 600; margin-bottom: 20px; border-bottom: 2px solid var(--accent); padding-bottom: 10px;">2 Times to Use Karate</h2>
          
          <p class="mb-3"><strong>Situation 1</strong> - if your life is in danger – students are taught to only use karate in a self-defense situation when there is no other option.</p>

          <p class="mb-3"><strong>Situation 2</strong> - when you are in karate class – students are allowed to practice karate during karate class under the supervision of their karate instructor. Students are also allowed to practice at home with the permission of their parent(s) or guardian.</p>

          <p class="mb-0" style="font-style: italic; color: #666;">*We strongly encourage parents to have a talk with their children about the appropriate times to use karate. We have found that reinforcement of karate teachings at home increase retention levels dramatically.</p>
        </div>

        <!-- General Terminology -->
        <div class="policy-section mb-5">
          <h2 style="color: var(--accent); font-weight: 600; margin-bottom: 20px; border-bottom: 2px solid var(--accent); padding-bottom: 10px;">General Terminology</h2>
          
          <ol style="color: var(--text-dark);">
            <li><strong>Attention</strong> – charyut</li>
            <li><strong>Bow</strong> – kyung nae</li>
            <li><strong>Ready</strong> – jun-bi</li>
          </ol>

          <p class="mb-0" style="margin-top: 20px;"><strong>The importance of jun-bi (pronounced "chun-bee")</strong> - jun-bi stance is a ready stance that all students learn to master from their very first karate lesson. In our system of karate we teach students to focus and show respect. Jun-bi is the primary way we instill these critical lessons and we encourage parents to teach the importance of focus, discipline and respect at home.</p>
        </div>

        <!-- Back to Home Button -->
        <div class="text-center mt-5">
          <a href="index.php" class="btn btn-danger btn-lg px-5 py-3" style="border-radius: 8px; font-weight: 600;">
            <i class="fas fa-arrow-left me-2"></i>Back to Home
          </a>
        </div>

      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="footer">
  <div class="container">
    <!-- Main Footer Content -->
    <div class="footer-main">
      <div class="row g-4">
        <!-- Column 1: Logo & Description -->
        <div class="col-lg-4 col-md-4 col-sm-12">
          <div class="footer-brand">
            <img src="assets/images/kaizen-logo-footer.png" alt="Kaizen Karate" class="footer-logo">
            <h5 class="footer-title">Kaizen Karate</h5>
            <p class="footer-description">
              Traditional martial arts training in Washington DC, Maryland, Northern Virginia, and New York. 
              Building character, discipline, and strength through the art of karate.
            </p>
          </div>
        </div>

        <!-- Column 2: Quick Links -->
        <div class="col-lg-4 col-md-4 col-sm-12">
          <h6 class="footer-heading">Quick Links</h6>
          <ul class="footer-links">
            <li><a href="index.php#training-options">Training Options</a></li>
            <li><a href="index.php#summer-camp">Summer Camp</a></li>
            <li><a href="index.php#after-school">After School</a></li>
            <li><a href="index.php#after-school">Weekend Classes</a></li>
            <li><a href="index.php#belt-exam">Belt Exams</a></li>
            <li><a href="index.php#contact">Contact Us</a></li>
            <li><a href="policies.php">Policies</a></li>
            <li><a href="faq.php">FAQs</a></li>
            <li><a href="student-handbook.php">Student Handbook</a></li>
        </ul>
      </div>

        <!-- Column 3: Contact & Social -->
        <div class="col-lg-4 col-md-4 col-sm-12">
          <h6 class="footer-heading">Get In Touch</h6>
        <div class="footer-contact">
            <div class="contact-item">
              <i class="fas fa-phone"></i>
              <div style="display: flex; flex-direction: column; gap: 4px;">
                <span style="font-weight: 600;">301-938-2711</span>
                <span style="font-size: 0.85em; opacity: 0.9;">(DC, MD, VA Programs)</span>
              </div>
            </div>
            <div class="contact-item">
              <i class="fas fa-phone"></i>
              <div style="display: flex; flex-direction: column; gap: 4px;">
                <span>646-475-7328</span>
                <span style="font-size: 0.85em; opacity: 0.9;">(NY Program)</span>
              </div>
            </div>
            <div class="contact-item">
              <i class="fas fa-envelope"></i>
              <a href="mailto:coach.v@kaizenkarateusa.com" style="color: inherit; text-decoration: none;">coach.v@kaizenkarateusa.com</a>
      </div>
    </div>

          <!-- Social Media Icons -->
          <div class="footer-social">
            <h6 class="social-heading">Follow Us</h6>
            <div class="social-icons">
              <a href="https://www.facebook.com/people/Kaizen-Karate/100063714665511/" target="_blank" class="social-icon" aria-label="Facebook">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="https://www.tiktok.com/@kaizenkaratemd" target="_blank" class="social-icon" aria-label="TikTok">
                <i class="fab fa-tiktok"></i>
              </a>
              <a href="https://www.instagram.com/kaizen_karate/" target="_blank" class="social-icon" aria-label="Instagram">
                <i class="fab fa-instagram"></i>
              </a>
              <a href="https://coachv6z.podbean.com/" target="_blank" class="social-icon" aria-label="Podcast">
                <i class="fas fa-podcast"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
      <div class="row align-items-center">
        <div class="col-md-12 text-center">
          <p>&copy; 2025 Kaizen Karate. All Rights Reserved.</p>
        </div>
      </div>
    </div>
  </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="scripts/floating-nav.js?v=<?php echo time(); ?>"></script>

<!-- Scroll to Top Button -->
<button class="scroll-to-top" id="scrollToTopBtn" aria-label="Scroll to top">
  <i class="fas fa-chevron-up"></i>
</button>

<script>console.log('Test script loaded');</script>
<script src="scripts/scripts.js?v=<?php echo time(); ?>"></script>

</body>
</html>

