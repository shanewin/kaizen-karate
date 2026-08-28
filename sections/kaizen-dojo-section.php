<section id="kaizen-dojo" class="kaizen-dojo-section py-5" style="margin-top:100px;">
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
