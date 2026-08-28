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
    <button class="video-control-btn" id="pausePlayBtn" title="Pause/Play Video">
      <i class="fas fa-pause" id="pausePlayIcon"></i>
    </button>
    <button class="video-control-btn" id="muteUnmuteBtn" title="Mute/Unmute Video">
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
