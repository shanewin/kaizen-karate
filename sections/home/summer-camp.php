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
