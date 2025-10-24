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
  <title>FAQ | Kaizen Karate</title>
  <meta name="description" content="Find answers to frequently asked questions about Kaizen Karate classes, enrollment, uniforms, safety, and more.">
  
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
                <div class="register-button-container">
                  <a class="mega-menu-item mega-register-btn" href="index.php#belt-exam" onclick="scrollToBeltExamRegister(); return false;">Register Now!</a>
                </div>
              </div>
            </div>
          </div>
        </li>
        <li class="mega-nav-item">
          <a class="mega-nav-link" href="index.php#about"><?php echo display_text('navigation', 'menu_items.0.text', 'About'); ?></a>
        </li>
        <li class="mega-nav-item">
          <a class="mega-nav-link" href="index.php#summer-camp"><?php echo display_text('navigation', 'menu_items.1.text', 'Summer Camp'); ?></a>
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
              <h6>
                <span class="header-line-1">AFTER SCHOOL</span>
                <span class="header-line-2">WEEKEND & EVENING</span>
              </h6>
              <a href="https://www.gomotionapp.com/team/mdkfu/page/class-registration" target="_blank" class="mobile-dropdown-item">Register Now!</a>
            </div>
            
            <hr class="mobile-menu-divider">
            
            <div class="mobile-dropdown-section">
              <h6>KAIZEN DOJO</h6>
              <a href="https://form.jotform.com/251533593606459" target="_blank" class="mobile-dropdown-item">Register Now!</a>
            </div>
            
            <hr class="mobile-menu-divider">
            
            <div class="mobile-dropdown-section">
              <h6>Summer Camp</h6>
              <p class="mobile-dropdown-text">Registration for Summer Camp 2026 has not opened yet.<br>
              <a href="index.php#summer-camp" class="summer-camp-explore-link">Explore our 2025 Summer Camp program</a> to see what we have in store for next year!</p>
            </div>
            
            <hr class="mobile-menu-divider">
            
            <div class="mobile-dropdown-section register-section-with-stripes">
              <h6>Belt Exams</h6>
              <a href="index.php#belt-exam" onclick="scrollToBeltExamRegister(); return false;" class="mobile-dropdown-item">Register Now!</a>
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

<!-- FAQ Content Section -->
<section class="faq-section" style="padding-top: 120px; padding-bottom: 60px; background-color: #f8f9fa;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10 col-xl-8">
        <div class="faq-content" style="background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
          
          <h1 class="text-center mb-5" style="color: var(--accent); font-weight: 700; font-size: 2.5rem;">Frequently Asked Questions</h1>
          
          <!-- FAQ Item 1 -->
          <div class="faq-item mb-4">
            <h3 style="color: var(--accent); font-weight: 600; margin-bottom: 15px; font-size: 1.3rem;">How old do I have to be to begin taking classes?</h3>
            <p class="mb-0">Our Little Ninja program is available for students ages 3.5 - 4 years old. Our beginner youth classes start at age 5. We also offer adult classes for all ages.</p>
          </div>
          <hr style="border: none; border-top: 1px solid #e9ecef; margin: 2rem 0; opacity: 0.6;">

          <!-- FAQ Item 2 -->
          <div class="faq-item mb-4">
            <h3 style="color: var(--accent); font-weight: 600; margin-bottom: 15px; font-size: 1.3rem;">What should my child wear to their 1st class?</h3>
            <p class="mb-0">Before ordering a uniform students should wear long comfortable pants and t-shirt to class each week. Students will have time to change before the start of class. Parents can purchase t-shirts, uniforms, and other gear through our <a href="https://kaizenkarate.store/" target="_blank" style="color: var(--accent); text-decoration: underline;">online store</a>.</p>
          </div>
          <hr style="border: none; border-top: 1px solid #e9ecef; margin: 2rem 0; opacity: 0.6;">

          <!-- FAQ Item 3 -->
          <div class="faq-item mb-4">
            <h3 style="color: var(--accent); font-weight: 600; margin-bottom: 15px; font-size: 1.3rem;">Do I need to order a uniform?</h3>
            <p class="mb-0">When a student first starts karate classes a uniform is optional. Once a student determines that they are interested in continuing classes past their initial session then a black uniform can be ordered through the Kaizen Karate <a href="https://kaizenkarate.store/" target="_blank" style="color: var(--accent); text-decoration: underline;">online store</a> at our discounted group rate.</p>
          </div>
          <hr style="border: none; border-top: 1px solid #e9ecef; margin: 2rem 0; opacity: 0.6;">

          <!-- FAQ Item 4 -->
          <div class="faq-item mb-4">
            <h3 style="color: var(--accent); font-weight: 600; margin-bottom: 15px; font-size: 1.3rem;">Will there be sparring or fighting in class?</h3>
            <p class="mb-0">Before a student is allowed to participate in partner drills they must first learn basic kicks, punches and blocks. Students will first learn proper technique, followed by movement drills, and finally partner based training.</p>
          </div>
          <hr style="border: none; border-top: 1px solid #e9ecef; margin: 2rem 0; opacity: 0.6;">

          <!-- FAQ Item 5 -->
          <div class="faq-item mb-4">
            <h3 style="color: var(--accent); font-weight: 600; margin-bottom: 15px; font-size: 1.3rem;">When should I purchase sparring equipment for my son/daughter?</h3>
            <p class="mb-0">Students can invest in sparring equipment after completing a full 8-week session of karate and not before. Students must have all sparring equipment no later than yellow belt rank.</p>
          </div>
          <hr style="border: none; border-top: 1px solid #e9ecef; margin: 2rem 0; opacity: 0.6;">

          <!-- FAQ Item 6 -->
          <div class="faq-item mb-4">
            <h3 style="color: var(--accent); font-weight: 600; margin-bottom: 15px; font-size: 1.3rem;">How safe is the class?</h3>
            <p class="mb-0">Safety is our #1 priority. We are very sensitive to the safety of every student in our karate program. The instructor will cover all safety procedures in detail before the start of each drill.</p>
          </div>
          <hr style="border: none; border-top: 1px solid #e9ecef; margin: 2rem 0; opacity: 0.6;">

          <!-- FAQ Item 7 -->
          <div class="faq-item mb-4">
            <h3 style="color: var(--accent); font-weight: 600; margin-bottom: 15px; font-size: 1.3rem;">Will students earn colored belts?</h3>
            <p class="mb-0">Yes, students will be allowed to test for colored belts upon invitation by their instructor. Please remember that belt exams are <strong>*invitation*</strong> only events. For more details, visit the belt exam page for testing requirements.</p>
          </div>
          <hr style="border: none; border-top: 1px solid #e9ecef; margin: 2rem 0; opacity: 0.6;">

          <!-- FAQ Item 8 -->
          <div class="faq-item mb-4">
            <h3 style="color: var(--accent); font-weight: 600; margin-bottom: 15px; font-size: 1.3rem;">When does the next session start?</h3>
            <p class="mb-0">Weekend & evening classes run in 2-month cycles. Other programs vary depending on the location. For details email us by <a href="index.php#contact" style="color: var(--accent); text-decoration: underline;">clicking here</a>.</p>
          </div>
          <hr style="border: none; border-top: 1px solid #e9ecef; margin: 2rem 0; opacity: 0.6;">

          <!-- FAQ Item 9 -->
          <div class="faq-item mb-4">
            <h3 style="color: var(--accent); font-weight: 600; margin-bottom: 15px; font-size: 1.3rem;">How do I enroll my son/daughter for classes?</h3>
            <p class="mb-0">To register, visit us online by <a href="https://www.gomotionapp.com/team/mdkfu/page/class-registration" target="_blank" style="color: var(--accent); text-decoration: underline;">clicking here</a>. Students must be enrolled in class prior to participating. We ask that all students are registered online as we do not accept cash or check.</p>
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

    <!-- Bottom Footer -->
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

<script src="scripts/scripts.js?v=<?php echo time(); ?>"></script>

</body>
</html>
