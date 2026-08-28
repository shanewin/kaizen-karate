<?php
$afterSchoolUrl = kaizen_link(get_content_value(
    'navigation',
    'register_dropdown.after_school.url',
    'https://www.gomotionapp.com/team/mdkfu/page/class-registration'
));
$kaizenDojoUrl = kaizen_link(get_content_value(
    'navigation',
    'register_dropdown.kaizen_dojo.url',
    'https://form.jotform.com/251533593606459'
));
$summerCampButtonUrl = kaizen_link(get_content_value(
    'navigation',
    'register_dropdown.summer_camp.url',
    '#summer-camp'
));
$summerCampInfoUrl = kaizen_link(get_content_value(
    'navigation',
    'register_dropdown.summer_camp.link_url',
    '#summer-camp'
));
$beltExamsPrimaryUrl = kaizen_link(get_content_value(
    'navigation',
    'register_dropdown.belt_exams.url',
    '#belt-exam'
));
$beltExamProcessUrl = kaizen_link(get_content_value(
    'navigation',
    'register_dropdown.belt_exams.view_process_url',
    '#belt-exam'
));
?>

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
                  <span class="header-line-2"><?php echo display_text('navigation', 'register_dropdown.after_school.header_line2', 'WEEKEND & EVENING'); ?></span>
                </h6>
                <!-- Dynamic URL for the button -->
                <?php $afterSchoolUrl = kaizen_link(get_content_value('navigation', 'register_dropdown.after_school.url', 'index.php#weekend-evening')); ?>
                <div class="mega-menu-content">
                  <div class="hover-btn-container w-100">
                    <a class="mega-menu-item mega-register-btn" href="<?php echo htmlspecialchars($afterSchoolUrl); ?>" target="_blank"><?php echo display_text('navigation', 'register_dropdown.after_school.button', 'Register Now!'); ?></a>
                  </div>
                </div>
              </div>
              
              <div class="mega-menu-vertical-divider"></div>
              
              <div class="mega-menu-column register-section-with-stripes">
                <h6 class="mega-menu-header"><?php echo display_text('navigation', 'register_dropdown.kaizen_dojo.header', 'KAIZEN DOJO'); ?></h6>
                <div class="register-button-container">
                  <a class="mega-menu-item mega-register-btn" href="<?php echo htmlspecialchars($kaizenDojoUrl); ?>" target="_blank"><?php echo display_text('navigation', 'register_dropdown.kaizen_dojo.button', 'Register Now!'); ?></a>
                </div>
              </div>
              
              <div class="mega-menu-vertical-divider"></div>
              
              <div class="mega-menu-column">
                <h6 class="mega-menu-header"><?php echo display_text('navigation', 'register_dropdown.summer_camp.header', 'Summer Camp'); ?></h6>
                <?php 
                $summer_camp_mode = display_text('navigation', 'register_dropdown.summer_camp.display_mode', 'information');
                if ($summer_camp_mode === 'button'): ?>
                  <!-- Button Mode: Registration Button -->
                  <div class="register-button-container">
                    <a class="mega-menu-item mega-register-btn" href="<?php echo htmlspecialchars($summerCampButtonUrl); ?>" target="_blank"><?php echo display_text('navigation', 'register_dropdown.summer_camp.button', 'Register Now!'); ?></a>
                  </div>
                <?php else: ?>
                  <!-- Information Mode: Text + Optional Link -->
                  <div class="mega-menu-text">
                    <p class="mega-menu-summer-text">
                      <?php echo display_text('navigation', 'register_dropdown.summer_camp.text', 'Registration for Summer Camp 2026 has not opened yet.'); ?> 
                      <a href="<?php echo htmlspecialchars($summerCampInfoUrl); ?>" class="summer-camp-explore-link">
                        <?php echo display_text('navigation', 'register_dropdown.summer_camp.link_text', 'Explore our 2025 Summer Camp program'); ?>
                      </a>
                    </p>
                  </div>
                <?php endif; ?>
              </div>
              
              <div class="mega-menu-vertical-divider"></div>
              
              <div class="mega-menu-column register-section-with-stripes">
                <h6 class="mega-menu-header"><?php echo display_text('navigation', 'register_dropdown.belt_exams.header', 'Belt Exams'); ?></h6>
                <div class="register-button-container" style="display: flex; flex-direction: column; gap: 12px;">
                  <?php 
                  $belt_exams_mode = display_text('navigation', 'register_dropdown.belt_exams.display_mode', 'simple');
                  if ($belt_exams_mode === 'simple'): ?>
                    <!-- Simple Mode: Single Button -->
                    <a class="mega-menu-item mega-register-btn" href="<?php echo htmlspecialchars($beltExamsPrimaryUrl); ?>" onclick="return scrollToBeltExamRegister(event);" style="width: 80% !important; min-width: 160px !important; font-size: 0.9rem !important; text-transform: none !important; line-height: 1.3; padding: 14px 12px !important; border-radius: 8px !important; background: linear-gradient(135deg, #a4332b, #d4524a) !important; border: 2px solid rgba(255, 255, 255, 0.3) !important; box-shadow: 0 4px 12px rgba(164, 51, 43, 0.3) !important; display: block !important; text-align: center !important; margin: 4px auto !important;">
                      <?php echo display_text('navigation', 'register_dropdown.belt_exams.button', 'Register for Belt Exam'); ?>
                    </a>
                  <?php else: ?>
                    <!-- Multiple Mode: Multiple Exam Buttons -->
                    <?php 
                    $num_buttons = intval(display_text('navigation', 'register_dropdown.belt_exams.num_buttons', '1'));
                    for ($i = 0; $i < $num_buttons; $i++): ?>
                      <?php $examButtonUrl = kaizen_link(get_content_value('navigation', "register_dropdown.belt_exams.exam_buttons.{$i}.url", '#belt-exam')); ?>
                      <a class="mega-menu-item mega-register-btn" href="<?php echo htmlspecialchars($examButtonUrl); ?>" onclick="return scrollToBeltExamRegister(event);" style="width: 80% !important; min-width: 160px !important; font-size: 0.8rem !important; text-transform: none !important; line-height: 1.3; padding: 14px 12px !important; border-radius: 8px !important; background: linear-gradient(135deg, #a4332b, #d4524a) !important; border: 2px solid rgba(255, 255, 255, 0.3) !important; box-shadow: 0 4px 12px rgba(164, 51, 43, 0.3) !important; display: block !important; text-align: center !important; margin: 4px auto !important;">
                        <div style="font-weight: 800; margin-bottom: 4px; font-size: 0.9rem;"><?php echo display_text('navigation', "register_dropdown.belt_exams.exam_buttons.{$i}.line1", 'REGISTER!'); ?></div>
                        <div style="font-weight: 700; font-size: 1rem; color: #ffffff; text-shadow: 0 1px 2px rgba(0,0,0,0.3);"><?php echo display_text('navigation', "register_dropdown.belt_exams.exam_buttons.{$i}.line2", 'Youth Exam'); ?></div>
                        <div style="font-size: 0.75rem; opacity: 0.95; margin-top: 2px; font-weight: 600;"><?php echo display_text('navigation', "register_dropdown.belt_exams.exam_buttons.{$i}.line3", 'Saturday, Nov 15th'); ?></div>
                      </a>
                    <?php endfor; ?>
                  <?php endif; ?>
                  <a class="mega-menu-item" href="<?php echo htmlspecialchars($beltExamProcessUrl); ?>" style="color: #a4332b; text-decoration: underline; font-size: 0.9rem; margin-top: 8px; font-weight: 600; transition: all 0.3s ease;" onmouseover="this.style.color='#8b2922'; this.style.textDecoration='none';" onmouseout="this.style.color='#a4332b'; this.style.textDecoration='underline';"><?php echo display_text('navigation', 'register_dropdown.belt_exams.view_process_text', 'View Process >>'); ?></a>
                </div>
              </div>
            </div>
          </div>
        </li>

        <li class="mega-nav-item">
          <a class="mega-nav-link nyc-nav-link" href="index.php#NYC">NYC</a>
        </li>
<?php 
        // Dynamically render all menu items
        $menu_items = get_content('navigation', 'menu_items') ?? [];
        foreach ($menu_items as $index => $item): 
            $itemHref = kaizen_link($item['href'] ?? '');
            ?>
        <li class="mega-nav-item">
          <a class="mega-nav-link" href="<?php echo htmlspecialchars($itemHref); ?>"><?php echo htmlspecialchars($item['text'] ?? ''); ?></a>
        </li>
        <?php endforeach; ?>
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
                <span class="header-line-1"><?php echo display_text('navigation', 'register_dropdown.after_school.header_line1', 'AFTER SCHOOL'); ?></span>
                <span class="header-line-2"><?php echo display_text('navigation', 'register_dropdown.after_school.header_line2', 'WEEKEND & EVENING'); ?></span>
              </h6>
              <a href="<?php echo htmlspecialchars($afterSchoolUrl); ?>" target="_blank" class="mobile-dropdown-item"><?php echo display_text('navigation', 'register_dropdown.after_school.button', 'Register Now!'); ?></a>
            </div>
            
            <hr class="mobile-menu-divider">
            
            <div class="mobile-dropdown-section">
              <h6><?php echo display_text('navigation', 'register_dropdown.kaizen_dojo.header', 'KAIZEN DOJO'); ?></h6>
              <a href="<?php echo htmlspecialchars($kaizenDojoUrl); ?>" target="_blank" class="mobile-dropdown-item"><?php echo display_text('navigation', 'register_dropdown.kaizen_dojo.button', 'Register Now!'); ?></a>
            </div>
            
            <hr class="mobile-menu-divider">
            
            <div class="mobile-dropdown-section">
              <h6><?php echo display_text('navigation', 'register_dropdown.summer_camp.header', 'Summer Camp'); ?></h6>
              <?php 
              $summer_camp_mode = display_text('navigation', 'register_dropdown.summer_camp.display_mode', 'information');
              if ($summer_camp_mode === 'button'): ?>
                <!-- Button Mode: Registration Button -->
                <a href="<?php echo htmlspecialchars($summerCampButtonUrl); ?>" target="_blank" class="mobile-dropdown-item"><?php echo display_text('navigation', 'register_dropdown.summer_camp.button', 'Register Now!'); ?></a>
              <?php else: ?>
                <!-- Information Mode: Text + Optional Link -->
                <p class="mobile-dropdown-text"><?php echo display_text('navigation', 'register_dropdown.summer_camp.text', 'Registration for Summer Camp 2026 has not opened yet.'); ?><br>
                <a href="<?php echo htmlspecialchars($summerCampInfoUrl); ?>" class="summer-camp-explore-link"><?php echo display_text('navigation', 'register_dropdown.summer_camp.link_text', 'Explore our 2025 Summer Camp program'); ?></a></p>
              <?php endif; ?>
            </div>
            
            <hr class="mobile-menu-divider">
            
            <div class="mobile-dropdown-section register-section-with-stripes" style="text-align: center;">
              <h6><?php echo display_text('navigation', 'register_dropdown.belt_exams.header', 'Belt Exams'); ?></h6>
              <?php 
              $belt_exams_mode = display_text('navigation', 'register_dropdown.belt_exams.display_mode', 'simple');
              if ($belt_exams_mode === 'simple'): ?>
                <!-- Simple Mode: Single Button -->
                <a href="<?php echo htmlspecialchars($beltExamsPrimaryUrl); ?>" onclick="return scrollToBeltExamRegister(event);" class="mobile-dropdown-item" style="background: linear-gradient(135deg, #a4332b, #d4524a) !important; color: white !important; border: 2px solid rgba(255, 255, 255, 0.3) !important; border-radius: 6px !important; padding: 12px 10px !important; margin: 6px auto !important; text-decoration: none !important; display: block !important; text-align: center !important; width: 85% !important; max-width: 200px !important; font-size: 0.8rem !important; font-weight: 700 !important;">
                  <?php echo display_text('navigation', 'register_dropdown.belt_exams.button', 'Register for Belt Exam'); ?>
                </a>
              <?php else: ?>
                <!-- Multiple Mode: Multiple Exam Buttons -->
                <?php 
                $num_buttons = intval(display_text('navigation', 'register_dropdown.belt_exams.num_buttons', '1'));
                for ($i = 0; $i < $num_buttons; $i++): ?>
                  <?php $mobileExamButtonUrl = kaizen_link(get_content_value('navigation', "register_dropdown.belt_exams.exam_buttons.{$i}.url", '#belt-exam')); ?>
                  <a href="<?php echo htmlspecialchars($mobileExamButtonUrl); ?>" onclick="return scrollToBeltExamRegister(event);" class="mobile-dropdown-item" style="background: linear-gradient(135deg, #a4332b, #d4524a) !important; color: white !important; border: 2px solid rgba(255, 255, 255, 0.3) !important; border-radius: 6px !important; padding: 8px 10px !important; margin: 6px auto !important; text-decoration: none !important; display: block !important; text-align: center !important; width: 85% !important; max-width: 200px !important;">
                    <span style="display: block; font-weight: 800; font-size: 0.7rem; margin-bottom: 2px;"><?php echo display_text('navigation', "register_dropdown.belt_exams.exam_buttons.{$i}.line1", 'REGISTER!'); ?></span>
                    <span style="display: block; font-size: 0.6rem; font-weight: 600;"><?php echo display_text('navigation', "register_dropdown.belt_exams.exam_buttons.{$i}.line2", 'Youth Exam'); ?> - <?php echo display_text('navigation', "register_dropdown.belt_exams.exam_buttons.{$i}.line3", 'Nov 15th'); ?></span>
                  </a>
                <?php endfor; ?>
              <?php endif; ?>
              <div style="text-align: center; margin-top: 12px;">
                <a href="<?php echo htmlspecialchars($beltExamProcessUrl); ?>" style="color: #a4332b !important; text-decoration: underline !important; font-size: 0.9rem !important; font-weight: 600 !important; transition: all 0.3s ease !important; background: none !important; border: none !important; padding: 0 !important; margin: 0 !important;" onmouseover="this.style.color='#8b2922'; this.style.textDecoration='none';" onmouseout="this.style.color='#a4332b'; this.style.textDecoration='underline';"><?php echo display_text('navigation', 'register_dropdown.belt_exams.view_process_text', 'View Process >>'); ?></a>
              </div>
            </div>
          </div>
        </div>
        
        <a href="index.php#NYC" class="mobile-nav-item nyc-mobile-nav">NYC</a>
<?php 
        // Dynamically render all mobile menu items
        $menu_items = get_content('navigation', 'menu_items') ?? [];
        $base_delay = 50; // Starting delay
        $delay_increment = 25; // Delay between items
        foreach ($menu_items as $index => $item): 
            $delay = $base_delay + ($index * $delay_increment);
            $special_class = ($item['text'] === 'Summer Camp') ? ' summer-camp-mobile-nav' : '';
        ?>
        <a href="<?php echo htmlspecialchars($item['href'] ?? '#'); ?>" class="mobile-nav-item<?php echo $special_class; ?>" data-delay="<?php echo $delay; ?>"><?php echo htmlspecialchars($item['text'] ?? ''); ?></a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
  
</nav>
