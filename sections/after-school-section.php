<?php
$after_school = get_content('after_school');
$calendar_section = $after_school['calendar_section'] ?? [];
$schedule = $after_school['schedule'] ?? [];
$registration = $after_school['registration'] ?? [];
$disclaimer = $after_school['disclaimer'] ?? [];
?>
<section id="weekend-evening" class="py-5" style="background: linear-gradient(135deg, #1a1a1a 0%, #2c2c2c 100%); color: white; margin-top:100px;">
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
                 alt="September - October Karate Schedule" 
                 style="width: 100%; max-width: 400px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3); cursor: pointer;"
                 onclick="openCalendarPreview()"
                 onmouseover="this.style.transform='scale(1.02)'; this.style.transition='all 0.3s ease';"
                 onmouseout="this.style.transform='scale(1)'; this.style.transition='all 0.3s ease';">
          </div>
          
          <!-- Download Button -->
          <a href="<?php echo display_text('after_school', 'schedule.pdf_file', 'assets/images/aftersschool/2025-Sep-Oct-Karate-Class-Calendar-v2.pdf'); ?>" 
            download="Kaizen-Karate-Sept-Oct-2025.pdf"
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
