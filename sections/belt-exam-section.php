<!-- Belt Exam Section -->
<?php $isStandaloneBeltPage = defined('BELT_EXAM_STANDALONE') && BELT_EXAM_STANDALONE; ?>
<section id="belt-exam" class="py-5" style="margin-top: 100px; background: linear-gradient(135deg, #1a1a1a 0%, #2c2c2c 100%); color: white;">
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
                                <a href="#" style="color: #ffd166; text-decoration: underline; font-weight: 700; font-size: 0.95rem; letter-spacing: 0.02em; transition: all 0.3s ease;" onmouseover="this.style.color='#ffffff'; this.style.textDecoration='none';" onmouseout="this.style.color='#ffd166'; this.style.textDecoration='underline';"><?php echo htmlspecialchars($date_card['link_text']); ?></a>
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
                            <p style="color: #dc3545; margin: 0; font-size: 1rem; font-weight: 700;"><i class="fas fa-external-link-alt" style="margin-right: 0.5rem;"></i><?php echo htmlspecialchars($card['button_text'] ?? 'Register Now'); ?></p>
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
                              <img src="<?php echo htmlspecialchars($req_image['image'] ?? ''); ?>" alt="<?php echo htmlspecialchars($req_image['title'] ?? 'Requirement Image'); ?>" style="width: 100%; height: 150px; object-fit: cover; border-radius: 8px; margin-bottom: 1rem; border: 2px solid rgba(220, 53, 69, 0.3);">
                              <p style="font-size: 0.9rem; margin-bottom: 1rem; color: #e9ecef;"><?php echo htmlspecialchars($req_image['description'] ?? ''); ?></p>
                              <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                <a href="<?php echo htmlspecialchars($req_image['image'] ?? '#'); ?>" target="_blank" rel="noopener" style="background: rgba(220, 53, 69, 0.8); color: white; border: none; padding: 0.5rem 1rem; border-radius: 6px; font-size: 0.85rem; cursor: pointer; transition: all 0.2s ease; text-decoration: none; display: inline-flex; align-items: center;" onmouseover="this.style.background='#dc3545'" onmouseout="this.style.background='rgba(220, 53, 69, 0.8)'">
                                  <i class="fas fa-eye" style="margin-right: 0.5rem;"></i>View
                                </a>
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
                      $script_cards = $accordion['script_cards'] ?? [];
                      $important_note = $accordion['important_note'] ?? [];
                      if (!empty($script_cards)):
                      ?>
                      <!-- Testing Scripts Grid -->
                      <div class="row g-4 mb-4">
                        <?php foreach ($script_cards as $script_card):
                          $scriptId = $script_card['id'] ?? '';
                          $isFirstTwo = in_array($scriptId, ['testing_tips', 'video_instructions'], true);
                          $beltColor = $script_card['belt_color'] ?? '#dc3545';
                          $isStripe = $script_card['has_stripe'] ?? false;
                          $lightboxFunction = $script_card['lightbox_function'] ?? '';
                          $card_link = match($scriptId) {
                              'testing_tips' => 'testing-tips.php',
                              'video_instructions' => 'video-instructions.php',
                              'green_belt' => 'green-belt.php',
                              'purple_belt' => 'purple-belt.php',
                              'blue_belt' => 'blue-belt.php',
                              'brown_belt' => 'brown-belt.php',
                              'brown_stripe' => 'brown-stripe.php',
                              'brown_stripe_belt' => 'brown-stripe.php',
                              'red_belt' => 'red-belt.php',
                              'red_stripe' => 'red-stripe.php',
                              'red_stripe_belt' => 'red-stripe.php',
                              default => '#'
                          };
                          $hasValidLink = $card_link !== '#';
                          $shouldUseLightbox = !$isStandaloneBeltPage && !empty($lightboxFunction);
                          $safeLightboxFunction = htmlspecialchars($lightboxFunction, ENT_QUOTES, 'UTF-8');
                        ?>
                        <div class="col-lg-4 col-md-6">
                          <a 
                            class="belt-testing-script-card" 
                            href="<?php echo $hasValidLink ? htmlspecialchars($card_link) : '#'; ?>" 
                            style="text-decoration: none; color: inherit;"
                            <?php if ($shouldUseLightbox): ?>
                              data-open-mode="lightbox"
                              data-lightbox-function="<?php echo $safeLightboxFunction; ?>"
                            <?php else: ?>
                              data-open-mode="link"
                            <?php endif; ?>
                            <?php if (!$shouldUseLightbox && !$hasValidLink): ?>
                              aria-disabled="true"
                            <?php endif; ?>
                          >
                          <div style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(220, 53, 69, 0.3); border-radius: 12px; padding: 1.5rem; text-align: center; transition: 0.3s; height: 100%; transform: translateY(0px); box-shadow: none; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(220, 53, 69, 0.3)'; this.style.borderColor='#dc3545';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'; this.style.borderColor='rgba(220, 53, 69, 0.3)';">
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
                          </a>
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
  if (!content || !icon) return;
  const isHidden = content.style.display === '' || content.style.display === 'none';
  content.style.display = isHidden ? 'block' : 'none';
  icon.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
}
</script>
<?php if (!$isStandaloneBeltPage): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const scriptCards = document.querySelectorAll('.belt-testing-script-card[data-open-mode="lightbox"]');
  scriptCards.forEach(function(card) {
    card.addEventListener('click', function(event) {
      const fnName = this.dataset.lightboxFunction;
      if (!fnName) {
        return;
      }
      const handler = window[fnName];
      if (typeof handler === 'function') {
        event.preventDefault();
        handler();
      }
    });
  });
});
</script>
<?php endif; ?>
