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
