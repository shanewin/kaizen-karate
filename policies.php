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
  <title>Policies | Kaizen Karate</title>
  <meta name="description" content="View Kaizen Karate's comprehensive policies including refund, withdrawal, credit, transfer, and other important program policies.">
  
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

<!-- Policies Content Section -->
<section class="policies-section" style="padding-top: 120px; padding-bottom: 60px; background-color: #f8f9fa;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10 col-xl-8">
        <div class="policies-content" style="background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
          
          <h1 class="text-center mb-5" style="color: var(--accent); font-weight: 700; font-size: 2.5rem;">Policies</h1>
          
          <!-- Refund Policy -->
          <div class="policy-section mb-5">
            <h2 style="color: var(--accent); font-weight: 600; margin-bottom: 20px; border-bottom: 2px solid var(--accent); padding-bottom: 10px;">Refund Policy</h2>
            <p class="mb-3">There are no refunds for any classes once the session has begun (see Withdrawal Policy below). Students who do not attend one or more sessions of a class are not due a "partial" refund. All sales are final after the start of the first class of the session. No exceptions will be made.</p>
          </div>

          <!-- Withdrawal Policy -->
          <div class="policy-section mb-5">
            <h2 style="color: var(--accent); font-weight: 600; margin-bottom: 20px; border-bottom: 2px solid var(--accent); padding-bottom: 10px;">Withdrawal Policy</h2>
            <p class="mb-2">If class is cancelled by Kaizen Karate then student will receive a FULL refund.</p>
            <p class="mb-2">If the student withdraws before the start of the 1st class then they will receive a FULL refund minus a $25 processing fee.</p>
            <p class="mb-2">If a student withdraws after the 1st class then credit will be given (see Credit Policy below).</p>
            <p class="mb-2">If a student withdraws after 2nd class: No refund or credit will be given.</p>
            <p class="mb-0"><strong>Workshops / Seminars / Tournaments / Belt Exams:</strong> No refund or credit will be given at any time.</p>
          </div>

          <!-- Credit Policy -->
          <div class="policy-section mb-5">
            <h2 style="color: var(--accent); font-weight: 600; margin-bottom: 20px; border-bottom: 2px solid var(--accent); padding-bottom: 10px;">Credit Policy</h2>
            <p class="mb-3">Per our no refund policy, credit will be given for any refund request up to 30 days from the original date of sale (not the class start date). Credit applies to any service offered by Kaizen Karate of equal or lesser value. Any additional price difference must be paid prior to the student participating in the class. Credit may not be used to purchase merchandise. Any credit not used within a 6 month period will expire. No exceptions.</p>
            <p class="mb-3">Credit that is issued for ANY reason is valid for a 6 month period only. No Exceptions. After the 60 day period the credit is no longer valid.</p>
            <p class="mb-3">Credit given for any program that operates during the school year (September - May) can <strong>not</strong> be applied to any Summer Camp programs including our all-day camps.</p>
            <p class="mb-3">Credit given for group classes can not be applied to private lessons or small group classes.</p>
            <p class="mb-3">Credit given for Summer Camp can not be applied for school year programs.</p>
            <p class="mb-0" style="font-style: italic; color: #666;">Updated on 9/4/2020</p>
          </div>

          <!-- Transfer Policy -->
          <div class="policy-section mb-5">
            <h2 style="color: var(--accent); font-weight: 600; margin-bottom: 20px; border-bottom: 2px solid var(--accent); padding-bottom: 10px;">Transfer Policy</h2>
            <p class="mb-0">If you have registered for a class and wish to transfer there is a $10.00 processing fee. Students are only able to transfer to a different class if there is space available.</p>
          </div>

          <!-- Late Pick-up Policy -->
          <div class="policy-section mb-5">
            <h2 style="color: var(--accent); font-weight: 600; margin-bottom: 20px; border-bottom: 2px solid var(--accent); padding-bottom: 10px;">Late Pick-up Policy</h2>
            <p class="mb-0">Instructors frequently have other commitments shortly after class ends, we ask that you respect the Instructors' time by arriving on time. There will be a 5 minute grace period after the program has ended. After that parents will be charged an additional fee of $1.00 per minute. The late fee must be paid before the next class. If the late-fee is not paid the student will be removed from the program.</p>
          </div>

          <!-- Make-Up Policy -->
          <div class="policy-section mb-5">
            <h2 style="color: var(--accent); font-weight: 600; margin-bottom: 20px; border-bottom: 2px solid var(--accent); padding-bottom: 10px;">Make-Up Policy</h2>
            
            <h3 style="color: var(--text-dark); font-weight: 600; margin-bottom: 15px;">AFTER SCHOOL PROGRAMS - Fall, Winter, Spring, & Summer</h3>
            <p class="mb-3">Kaizen Karate does <strong>not</strong> offer pro-rating of tuition at any of our programs. However, if a class is missed, it can be made up at one of our evening or weekend locations. The make-up must be completed during the session that the class was missed. Once the given session has been completed, no more make-ups are permitted for that session. No Exceptions.</p>
            <p class="mb-3">To schedule your make-up a class, email our office directly at coach.v@kaizenkaratemd.com with your request. Please note, all make-ups <strong>must</strong> be scheduled in advance.</p>
            <p class="mb-4" style="font-style: italic; color: #666;">Updated on 6/13/18</p>

            <h3 style="color: var(--text-dark); font-weight: 600; margin-bottom: 15px;">AFTER SCHOOL PROGRAMS - Winter <strong>ONLY</strong></h3>
            <p class="mb-3">Kaizen Karate does <strong>not</strong> offer more than 2 make-ups per session during the winter season. IF one or two classes is missed due to weather, those classes will be made up during the session generally by adding classes dates to the end of the session. If three or more classes are missed for any reason, class three and beyond must be made up at one of our weekend or evening locations.</p>
            <p class="mb-0" style="font-style: italic; color: #666;">Updated on 11/16/21</p>
          </div>

          <!-- Snow Policy -->
          <div class="policy-section mb-5">
            <h2 style="color: var(--accent); font-weight: 600; margin-bottom: 20px; border-bottom: 2px solid var(--accent); padding-bottom: 10px;">Snow Policy - After School Programs</h2>
            <p class="mb-0">If 1 class is missed at an after school program due to a snow day then the class will be made up at the end of the session by adding on one extra class. If 2 classes are missed due to snow then Kaizen Fitness will make-up the missed dates by adding 2 extra classes on to the end of the session. No more than 2 missed classes will be made up for snow dates in a given session. If a 3rd class is missed due to snow then this class and any future missed classes (4, 5, etc) in the session must be made up at one of our weekend or evening classes and they will not be made up by adding on additional dates to the session.</p>
          </div>

          <!-- Tuition Payment Policies -->
          <div class="policy-section mb-5">
            <h2 style="color: var(--accent); font-weight: 600; margin-bottom: 20px; border-bottom: 2px solid var(--accent); padding-bottom: 10px;">Tuition Payment Policies</h2>
            <p class="mb-2">No Cash OR Checks Accepted by Kaizen Karate Instructors.</p>
            <p class="mb-0">ALL tuition payments must be made online through our website PRIOR to the start of classes.</p>
          </div>

          <!-- Private Lesson Policy -->
          <div class="policy-section mb-5">
            <h2 style="color: var(--accent); font-weight: 600; margin-bottom: 20px; border-bottom: 2px solid var(--accent); padding-bottom: 10px;">Private Lesson Policy</h2>
            <p class="mb-3">All registration for private lessons must place directly with the Kaizen Karate office.</p>
            <p class="mb-0" style="font-style: italic; color: #666;">Updated on 9/4/2020</p>
          </div>

          <!-- Lockout Policy -->
          <div class="policy-section mb-5">
            <h2 style="color: var(--accent); font-weight: 600; margin-bottom: 20px; border-bottom: 2px solid var(--accent); padding-bottom: 10px;">Lockout Policy</h2>
            <p class="mb-3">The Kaizen Office Team will do everything possible to ensure that all classes run on schedule at all times. On rare occasions, we are unable to access a facility for factors that are out of our control. We ask that all parents and adult students "opt in" for our text message alerts to receive timely updates with the latest news and announcements in the case of a last minute change. Please note, you will only receive a text message if you are enrolled for the class. See our Lockout Policy below for both youth & adult classes.</p>
            <p class="mb-3"><strong>YOUTH Classes:</strong> If we are unable to access the facility for any reason (lock out, etc), a credit will be awarded to the parent's online account to be used for future sessions.</p>
            <p class="mb-3"><strong>ADULT Classes:</strong> If we are unable to access the facility for any reason (lock out, etc), a credit will be issued to your account IF you are enrolled in that class with your name on the roster. If you are enrolled in a different adult class (name not on the roster) and attend the class that is "locked out", no credit and no refund will be given. Instead, students who are not on the roster (but are enrolled in a different adult class) are welcome to make-up the class at any of our other adult class locations.</p>
            <p class="mb-0" style="font-style: italic; color: #666;">Updated on 11/23/2021</p>
          </div>

          <!-- Merchandise Exchange Policy -->
          <div class="policy-section mb-5">
            <h2 style="color: var(--accent); font-weight: 600; margin-bottom: 20px; border-bottom: 2px solid var(--accent); padding-bottom: 10px;">Merchandise Exchange Policy</h2>
            <p class="mb-0">All items include FREE SHIPPING and will be sent directly to your address on file. In the event you need to return or exchange for a different size, customer will be charged for the shipping fee to re-ship each item for the correct size. No exchanges or refunds for special edition t-shirts or t-shirt competition apparel. Once the item is mailed back to PO Box 221, Spencerville, MD 20868 and received then the new item will be shipped out.</p>
          </div>

          <!-- Virtual Classes -->
          <div class="policy-section mb-5">
            <h2 style="color: var(--accent); font-weight: 600; margin-bottom: 20px; border-bottom: 2px solid var(--accent); padding-bottom: 10px;">Virtual Classes</h2>
            <p class="mb-3">No transfers allowed from In-person classes to Virtual classes or vice versa.</p>
            <p class="mb-3">There is no pro-rating at any time for Virtual classes. Full tuition rate is due if you join after the start of the session.</p>
            <p class="mb-3">No refunds or credits will be given after the first class of the week has started.</p>
            <p class="mb-0" style="font-style: italic; color: #666;">Updated on 1/6/2022</p>
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