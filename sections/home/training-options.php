  <section id="training-options" class="training-options-section">
    <div class="container">
      <!-- Training Cards Grid -->
      <div class="row g-4 training-cards-grid">
        <!-- After School -->
        <div class="col-lg-3 col-md-6 col-sm-6 col-6">
          <div class="training-card h-100">
            <div class="training-card-header">
              <h3><?php echo display_text('programs', 'cards.0.title', 'After School Program'); ?></h3>
            </div>
            <div class="training-card-image">
              <img src="<?php echo display_text('programs', 'cards.0.image', 'assets/images/panels/after-school.jpg'); ?>" alt="<?php echo display_text('programs', 'cards.0.image_alt', 'After school karate program for children at Kaizen Karate'); ?>" class="card-image">
            </div>
            <div class="training-card-content">
              <p class="training-summary"><?php echo display_text('programs', 'cards.0.summary', 'Comprehensive after-school karate program designed for young students.'); ?></p>
              <a class="read-more-link" onclick="toggleDescription(this)">Read More</a>
              <div class="training-description expandable-content">
                <span class="training-description-full"><?php echo display_text('programs', 'cards.0.description', 'Safe, structured environment where children learn traditional karate while developing discipline, respect, and confidence. Perfect for working parents.'); ?></span>
              <div class="training-card-buttons">
                <?php 
                $programs_data = get_content('programs');
                $card0_buttons = $programs_data['cards'][0]['buttons'] ?? [];
                foreach ($card0_buttons as $button): 
                  $btn_class = ($button['style'] === 'primary') ? 'training-btn-primary' : 'training-btn-secondary';
                ?>
                <a href="<?php echo htmlspecialchars($button['url'] ?? '#'); ?>" <?php echo (strpos($button['url'] ?? '', 'http') === 0) ? 'target="_blank"' : ''; ?> class="btn <?php echo $btn_class; ?>"><?php echo htmlspecialchars($button['text'] ?? 'Learn More'); ?> →</a>
                <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Weekend & Evening -->
        <div class="col-lg-3 col-md-6 col-sm-6 col-6">
          <div class="training-card h-100">
            <div class="training-card-header">
              <h3><?php echo display_text('programs', 'cards.1.title', 'Weekend & Evening'); ?></h3>
            </div>
            <div class="training-card-image">
              <img src="<?php echo display_text('programs', 'cards.1.image', 'assets/images/panels/weekends.jpg'); ?>" alt="<?php echo display_text('programs', 'cards.1.image_alt', 'Weekend and evening karate classes for busy schedules'); ?>" class="card-image">
            </div>
            <div class="training-card-content">
              <p class="training-summary"><?php echo display_text('programs', 'cards.1.summary', 'Flexible scheduling for adults and families with busy weekday commitments.'); ?></p>
              <a class="read-more-link" onclick="toggleDescription(this)">Read More</a>
              <div class="training-description expandable-content">
                <span class="training-description-full"><?php echo display_text('programs', 'cards.1.description', 'Traditional karate training designed to fit your lifestyle. Weekend and evening classes accommodate work and school schedules while maintaining authentic instruction.'); ?></span>
              <div class="training-card-buttons">
                <?php 
                $card1_buttons = $programs_data['cards'][1]['buttons'] ?? [];
                foreach ($card1_buttons as $button): 
                  $btn_class = ($button['style'] === 'primary') ? 'training-btn-primary' : 'training-btn-secondary';
                ?>
                <a href="<?php echo htmlspecialchars($button['url'] ?? '#'); ?>" <?php echo (strpos($button['url'] ?? '', 'http') === 0) ? 'target="_blank"' : ''; ?> class="btn <?php echo $btn_class; ?>"><?php echo htmlspecialchars($button['text'] ?? 'Learn More'); ?> →</a>
                <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      
        <!-- Belt Exam -->
        <div class="col-lg-3 col-md-6 col-sm-6 col-6">
          <div class="training-card h-100">
            <div class="training-card-header">
              <h3><?php echo display_text('programs', 'cards.2.title', 'Belt Exams'); ?></h3>
            </div>
            <div class="training-card-image">
              <img src="<?php echo display_text('programs', 'cards.2.image', 'assets/images/panels/belts.png'); ?>" alt="<?php echo display_text('programs', 'cards.2.image_alt', 'Traditional karate belt exam process at Kaizen Karate'); ?>" class="card-image">
            </div>
            <div class="training-card-content">
              <p class="training-summary"><?php echo display_text('programs', 'cards.2.summary', 'Learn about our traditional belt examination and advancement process.'); ?></p>
              <a class="read-more-link" onclick="toggleDescription(this)">Read More</a>
              <div class="training-description expandable-content">
                <span class="training-description-full"><?php echo display_text('programs', 'cards.2.description', 'Belt exams are invitation-only and students must be invited by their instructor to test. Our rigorous testing ensures authentic skill development and progression.'); ?></span>
              <div class="training-card-buttons">
                <?php 
                $card2_buttons = $programs_data['cards'][2]['buttons'] ?? [];
                foreach ($card2_buttons as $button): 
                  $btn_class = ($button['style'] === 'primary') ? 'training-btn-primary' : 'training-btn-secondary';
                  $onclick = ($button['url'] === '#' || empty($button['url'])) ? 'onclick="return scrollToBeltExamRegister(event);"' : '';
                ?>
                <a href="<?php echo htmlspecialchars($button['url'] ?? '#'); ?>" <?php echo (strpos($button['url'] ?? '', 'http') === 0) ? 'target="_blank"' : ''; ?> <?php echo $onclick; ?> class="btn <?php echo $btn_class; ?>"><?php echo htmlspecialchars($button['text'] ?? 'Learn More'); ?> →</a>
                <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Online Store -->
        <div class="col-lg-3 col-md-6 col-sm-6 col-6">
          <div class="training-card h-100">
            <div class="training-card-header">
              <h3><?php echo display_text('programs', 'cards.3.title', 'Online Store'); ?></h3>
            </div>
            <div class="training-card-image">
              <img src="<?php echo display_text('programs', 'cards.3.image', 'assets/images/panels/online-store.jpg'); ?>" alt="<?php echo display_text('programs', 'cards.3.image_alt', 'Kaizen Karate online store for equipment and merchandise'); ?>" class="card-image">
            </div>
            <div class="training-card-content">
              <p class="training-summary"><?php echo display_text('programs', 'cards.3.summary', 'Quality karate equipment, uniforms, and Kaizen Karate merchandise.'); ?></p>
              <a class="read-more-link" onclick="toggleDescription(this)">Read More</a>
              <div class="training-description expandable-content">
                <span class="training-description-full"><?php echo display_text('programs', 'cards.3.description', 'Everything you need for your karate journey - from beginner gear to advanced equipment. Support your training with authentic, high-quality items.'); ?></span>
              <div class="training-card-buttons">
                <?php 
                $card3_buttons = $programs_data['cards'][3]['buttons'] ?? [];
                foreach ($card3_buttons as $button): 
                  $btn_class = ($button['style'] === 'primary') ? 'training-btn-primary' : 'training-btn-secondary';
                ?>
                <a href="<?php echo htmlspecialchars($button['url'] ?? '#'); ?>" <?php echo (strpos($button['url'] ?? '', 'http') === 0) ? 'target="_blank"' : ''; ?> class="btn <?php echo $btn_class; ?>"><?php echo htmlspecialchars($button['text'] ?? 'Learn More'); ?> →</a>
                <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
