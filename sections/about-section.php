<section id="about" class="about-dark-section" style="margin-top:100px;">
  <div class="container-fluid">
    <div class="about-content-wrapper">
      <?php
      $about_data = get_content('about_section');
      $kaizen_section = $about_data['kaizen_section'] ?? [];
      $coach_v_section = $about_data['coach_v_section'] ?? [];
      ?>
      
      <!-- Coach V Image - Floated Left -->
      <img src="<?php echo htmlspecialchars($kaizen_section['coach_v_image'] ?? 'assets/images/about/coach-v-about.png'); ?>" 
           alt="<?php echo htmlspecialchars($kaizen_section['coach_v_image_alt'] ?? 'Coach V - Head Instructor at Kaizen Karate'); ?>" 
           class="coach-v-float-image">
      
      <h1 class="about-main-title mb-4"><?php echo display_text('about_section', 'kaizen_section.title', 'About Kaizen Karate'); ?></h1>
      
      <p class="about-lead">
        <?php echo htmlspecialchars($kaizen_section['lead_paragraph'] ?? 'Kaizen Karate was founded by Coach V in 2003. Kaizen Karate has been offering instruction in non-traditional Tang Soo Do as part of its core curriculum since its founding. Around 2010 Chinese Kenpo was introduced into the Kaizen curriculum.'); ?>
      </p>
      
      <p class="about-text">
        <?php echo htmlspecialchars($kaizen_section['paragraph_2'] ?? "Kaizen Karate's team of highly trained martial artists offer a number of programs for students starting as young as 3.5 years old up to adult. They focus on discipline and encouragement in a fun-loving environment. Their main goal is to help everyone progress, continually improve, and enjoy the process."); ?>
      </p>
      
      <p class="about-text">
        <?php echo htmlspecialchars($kaizen_section['paragraph_3'] ?? 'Kaizen Karate now operates 7 days per week throughout Maryland, Washington D.C., Virginia, and New York.'); ?>
      </p>

      <h2 class="about-section-title mt-5 mb-4"><?php echo display_text('about_section', 'coach_v_section.title', 'Meet Coach V'); ?></h2>
      
      <p class="about-text">
        <?php echo htmlspecialchars($coach_v_section['paragraph_1'] ?? '"Coach V" has 38 years of experience in the martial arts, having spent the majority of his life committed to the trade. He began his journey with karate at five years old and earned his first black belt in non-traditional Tang Soo Do in 1998 through Hill\'s Hitters Karate and Master Instructor Dr. Phillip Hill.'); ?>
      </p>
      
      <p class="about-text">
        <?php echo htmlspecialchars($coach_v_section['paragraph_2'] ?? 'Coach V went on to earn his business degree at the Robert H. Smith School of Business at the University of Maryland in College Park. He then continued his training in Kenpo under 8th degree black belt Sifu Greg Payne who also holds a 5th degree black belt in Shotokan as well as many other black belts in other arts including Goju ryu & Judo.'); ?>
      </p>
      
      <p class="about-text">
        <?php echo htmlspecialchars($coach_v_section['paragraph_3'] ?? 'In 2024, Coach V was promoted to 8th degree black belt in IKCA Chinese Kenpo by 10th degree black belt Senior Grandmaster Chuck Sullivan. Additionally, Coach V holds the rank of Nikyu (2nd degree brown belt) in Budoshin JuJitsu and studied Aikido at the ASU headquarters overseen by Saotome Sensei, Shihan.'); ?>
      </p>
      
      <p class="about-text">
        <?php echo htmlspecialchars($coach_v_section['paragraph_4'] ?? 'In his free time he enjoys spending time with his wife and children as well as running local long distance races which most recently included the Cherry Blossom 10 miler, Rock \'n\' Roll 1/2 Marathon, & Marine Corp Marathon in Washington, DC.'); ?>
      </p>
      
      <!-- Other Instructors Accordion -->
      <div class="about-instructors-section">
        <!-- Master Accordion Header -->
        <?php
        $team_section = $about_data['team_section'] ?? [];
        $instructors = $team_section['instructors'] ?? [];
        
        if (!empty($instructors)):
        ?>
        <div class="master-instructor-accordion">
          <button class="master-instructor-header">
            <h2 class="about-section-title mt-3 mb-4"><?php echo htmlspecialchars($team_section['title'] ?? 'Meet the Team'); ?></h2>
            <span class="master-accordion-icon" style="margin-top: -0.5rem;">▼</span>
          </button>
          
          <!-- Master Accordion Content -->
          <div class="master-instructor-content">
            <div class="instructors-accordion">
              <?php foreach ($instructors as $index => $instructor): 
                $instructor_id = $index + 1;
              ?>
              <div class="instructor-item">
                <button class="instructor-header" data-instructor="<?php echo $instructor_id; ?>">
                  <h3><?php echo htmlspecialchars($instructor['name'] ?? ''); ?> - <?php echo htmlspecialchars($instructor['title'] ?? 'Instructor'); ?></h3>
                  <span class="accordion-icon">+</span>
                </button>
                <div class="instructor-content" id="instructor-<?php echo $instructor_id; ?>">
                  <?php if (!empty($instructor['image'])): ?>
                    <img src="<?php echo htmlspecialchars($instructor['image']); ?>" 
                         alt="<?php echo htmlspecialchars($instructor['image_alt'] ?? $instructor['name'] ?? ''); ?>" 
                         class="instructor-profile-image">
                  <?php endif; ?>
                  
                  <?php 
                  $bio = $instructor['bio'] ?? [];
                  if (is_array($bio)) {
                    foreach ($bio as $paragraph) {
                      if (!empty($paragraph)) {
                        echo '<p class="about-text">' . $paragraph . '</p>';
                      }
                    }
                  }
                  ?>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
