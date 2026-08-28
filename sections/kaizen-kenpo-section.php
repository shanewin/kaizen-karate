<?php
$kaizen_kenpo = get_content('kaizen_kenpo');
$kenpo_settings = $kaizen_kenpo['settings'] ?? [];
$kenpo_tabs_meta = $kenpo_settings['tabs'] ?? [];
$kenpo_tabs = $kaizen_kenpo['tabs'] ?? [];
$kenpo_logo = $kenpo_settings['logo'] ?? [];
$first_tab_meta = $kenpo_tabs_meta[0] ?? [];
$first_tab_id = $first_tab_meta['id'] ?? 'about';
$first_tab_label = $first_tab_meta['label'] ?? 'Kaizen Kenpo Home';
?>

<style>
  @media (max-width: 991px) {
    .kenpo-tabs-mobile .kenpo-dropdown-header {
      background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
      color: #fff;
      padding: 0.85rem 1.2rem;
      border-radius: 12px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      cursor: pointer;
      font-weight: 600;
      box-shadow: 0 10px 20px rgba(220, 53, 69, 0.25);
    }
    .kenpo-tabs-mobile .kenpo-dropdown-menu {
      margin-top: 0.6rem;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    }
    .kenpo-tabs-mobile .kenpo-dropdown-button {
      width: 100%;
      border: none;
      background: #fff;
      padding: 0.9rem 1.2rem;
      text-align: left;
      font-weight: 600;
      border-bottom: 1px solid #f0f0f0;
      color: #333;
      transition: background 0.2s ease, color 0.2s ease;
    }
    .kenpo-tabs-mobile .kenpo-dropdown-button:last-child {
      border-bottom: none;
    }
    .kenpo-tabs-mobile .kenpo-dropdown-button.active,
    .kenpo-tabs-mobile .kenpo-dropdown-button:hover {
      background: rgba(220, 53, 69, 0.1);
      color: #dc3545;
    }
  }
</style>

<!-- Kaizen Kenpo Section -->
<section id="kaizen-kenpo" style="margin-top: 80px; background: white; color: #333; position: relative; overflow: hidden; padding: 0; margin: 0;">
  
  <!-- Red Header Section -->
  <div style="background: linear-gradient(135deg, #dc3545 0%, #c82333 50%, #a41e2a 100%); width: 100%; padding: 2.5rem 0; margin: 0;">
    <div class="container" style="position: relative; z-index: 2;">
      <div class="text-center" style="position: relative;">
          <!-- Main Logo -->
        <div style="text-align: center;">
          <img src="<?php echo htmlspecialchars($kenpo_logo['image'] ?? 'assets/images/kenpo/kenpo-logo.png'); ?>" alt="<?php echo htmlspecialchars($kenpo_logo['alt'] ?? 'Kaizen Kenpo Logo'); ?>" style="height: 300px; width: auto;">
        </div>
        <h2 style="color: white; font-family: 'Playfair Display', serif; font-size: 3rem; font-weight: 700; text-decoration: underline; text-underline-offset: 0.3em; text-decoration-color: rgba(255, 255, 255, 0.8); margin: 1rem 0 0 0; position: relative; z-index: 2; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
          <?php echo htmlspecialchars($kenpo_settings['section_title'] ?? 'Kaizen Kenpo'); ?>
        </h2>
      </div>
    </div>
  </div>
  
  <!-- White Content Section -->
  <div class="container" style="position: relative; z-index: 2; padding: 50px 0 50px 0;">
    
    <!-- Kenpo Content with Tabs -->
    <div class="row justify-content-center" style="margin: 0;">
      <div class="col-12" style="padding: 0;">
        <div class="kenpo-tabs-container" style="margin: 0; padding: 0; min-height: 600px; width: 100%;">
          
          <!-- Desktop Tab Navigation -->
          <ul class="nav nav-tabs kenpo-tabs-desktop d-none d-lg-flex" id="kenpoTabs" role="tablist" style="border-bottom: 2px solid rgba(220, 53, 69, 0.2); margin: 0; padding-top: 0;">
            <?php foreach ($kenpo_tabs_meta as $index => $tab_meta): 
              $tab_id = $tab_meta['id'] ?? ('tab-' . $index);
              $tab_label = $tab_meta['label'] ?? ('Tab ' . ($index + 1));
              $tab_icon = $tab_meta['icon'] ?? '';
              $is_active = $index === 0 ? 'active' : '';
              $button_id = htmlspecialchars($tab_id . '-tab');
              $target_id = htmlspecialchars('#' . $tab_id . '-content');
              $aria_controls = htmlspecialchars($tab_id . '-content');
              $hover_styles = "onmouseover=\"this.style.borderColor='#dc3545'; this.style.color='#dc3545';\" onmouseout=\"this.style.borderColor='#ddd'; this.style.color='#333333';\"";
            ?>
            <li class="nav-item" role="presentation">
              <button class="nav-link <?php echo $is_active; ?>"
                      id="<?php echo $button_id; ?>"
                      data-bs-toggle="tab"
                      data-bs-target="<?php echo $target_id; ?>"
                      type="button"
                      role="tab"
                      aria-controls="<?php echo $aria_controls; ?>"
                      aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                      style="<?php echo $index === 0
                        ? 'color: white !important; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important; border: 2px solid #dc3545 !important; border-radius: 8px 8px 0 0 !important; font-weight: 600; font-size: 1.1rem; padding: 0.8rem 1.5rem; margin-right: 0.5rem; transition: all 0.3s ease !important; box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3) !important;'
                        : 'color: #333333 !important; background: white !important; border: 2px solid #ddd !important; border-radius: 8px 8px 0 0 !important; font-weight: 600; font-size: 1.1rem; padding: 0.8rem 1.5rem; margin-right: 0.5rem; transition: all 0.3s ease !important; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;'; ?>"
                      <?php echo $index === 0 ? '' : $hover_styles; ?>>
                <?php if (!empty($tab_icon)): ?>
                  <i class="<?php echo htmlspecialchars($tab_icon); ?>" style="margin-right: 8px;"></i>
                <?php endif; ?>
                <?php echo htmlspecialchars($tab_label); ?>
              </button>
            </li>
            <?php endforeach; ?>
          </ul>
          
          <!-- Mobile Dropdown Navigation -->
          <div class="kenpo-tabs-mobile kenpo-dropdown-container d-lg-none">
            <div class="kenpo-dropdown-header" onclick="toggleKenpoDropdown()">
              <span id="kenpo-dropdown-text"><?php echo htmlspecialchars($first_tab_label); ?></span>
              <i class="fas fa-chevron-down" id="kenpo-dropdown-arrow" style="margin-left: 8px; transition: transform 0.3s ease;"></i>
            </div>
            <div class="kenpo-dropdown-menu" id="kenpo-dropdown-menu" style="display: none;">
              <?php foreach ($kenpo_tabs_meta as $index => $tab_meta):
                $tab_id = $tab_meta['id'] ?? ('tab-' . $index);
                $tab_label = $tab_meta['label'] ?? ('Tab ' . ($index + 1));
                $tab_icon = $tab_meta['icon'] ?? '';
                $button_classes = 'kenpo-dropdown-button' . ($index === 0 ? ' active' : '');
              ?>
              <button class="<?php echo $button_classes; ?>"
                      onclick="switchKenpoTab('<?php echo htmlspecialchars($tab_id . '-tab'); ?>', this, '<?php echo htmlspecialchars($tab_label); ?>')">
                <?php if (!empty($tab_icon)): ?>
                  <i class="<?php echo htmlspecialchars($tab_icon); ?>" style="margin-right: 8px;"></i>
                <?php endif; ?>
                <?php echo htmlspecialchars($tab_label); ?>
              </button>
              <?php endforeach; ?>
            </div>
          </div>
          
          <script>
            // Enhanced tab styling functionality
            document.addEventListener('DOMContentLoaded', function() {
              const kenpoTabs = document.querySelectorAll('#kenpoTabs .nav-link');
              
              kenpoTabs.forEach(tab => {
                tab.addEventListener('shown.bs.tab', function(e) {
                  // Reset all tabs to inactive state
                  kenpoTabs.forEach(t => {
                    t.style.color = '#333333';
                    t.style.background = 'white';
                    t.style.borderColor = '#ddd';
                    t.style.boxShadow = '0 2px 4px rgba(0, 0, 0, 0.1)';
                  });
                  
                  // Style the active tab
                  e.target.style.color = 'white';
                  e.target.style.background = 'linear-gradient(135deg, #dc3545 0%, #c82333 100%)';
                  e.target.style.borderColor = '#dc3545';
                  e.target.style.boxShadow = '0 2px 8px rgba(220, 53, 69, 0.3)';
                });
              });
            });
            
            // Mobile dropdown toggle function
            function toggleKenpoDropdown() {
              const menu = document.getElementById('kenpo-dropdown-menu');
              const arrow = document.getElementById('kenpo-dropdown-arrow');
              
              if (menu.style.display === 'none' || menu.style.display === '') {
                menu.style.display = 'block';
                arrow.style.transform = 'rotate(180deg)';
              } else {
                menu.style.display = 'none';
                arrow.style.transform = 'rotate(0deg)';
              }
            }
            
            // Mobile dropdown tab switching function
            function switchKenpoTab(tabId, buttonElement, tabText) {
              // Update mobile dropdown button states
              document.querySelectorAll('.kenpo-dropdown-button').forEach(btn => {
                btn.classList.remove('active');
              });
              buttonElement.classList.add('active');
              
              // Update dropdown header text
              document.getElementById('kenpo-dropdown-text').textContent = tabText;
              
              // Close dropdown menu
              const menu = document.getElementById('kenpo-dropdown-menu');
              const arrow = document.getElementById('kenpo-dropdown-arrow');
              menu.style.display = 'none';
              arrow.style.transform = 'rotate(0deg)';
              
              // Trigger the corresponding desktop tab
              const desktopTab = document.getElementById(tabId);
              if (desktopTab) {
                desktopTab.click();
              }
            }
          </script>
          
          <!-- Tab Content -->
          <div class="tab-content" id="kenpoTabContent" style="min-height: 500px;">
            <?php
            $kenpo_tab_lookup = [];
            foreach ($kenpo_tabs_meta as $meta) {
                $meta_id = $meta['id'] ?? '';
                if ($meta_id !== '') {
                    $kenpo_tab_lookup[$meta_id] = $meta;
                }
            }
            
            $about_dom_id = $kenpo_tab_lookup['about']['id'] ?? ($kenpo_tabs_meta[0]['id'] ?? 'about');
            $ikca_dom_id = $kenpo_tab_lookup['ikca']['id'] ?? 'ikca';
            $gallery_dom_id = $kenpo_tab_lookup['gallery']['id'] ?? 'gallery';
            $contact_dom_id = $kenpo_tab_lookup['contact']['id'] ?? 'contact';
            
            $about_tab = $kenpo_tabs['about'] ?? [];
            $about_hero = $about_tab['hero_image'] ?? [];
            $about_schedule = $about_tab['class_schedule'] ?? [];
            $about_highlight = $about_tab['highlight'] ?? [];
            $about_primary = $about_tab['cta_primary'] ?? [];
            $about_secondary = $about_tab['cta_secondary'] ?? [];
            
            $ikca_tab = $kenpo_tabs['ikca'] ?? [];
            $ikca_image = $ikca_tab['image'] ?? [];
            $ikca_paragraphs = $ikca_tab['paragraphs'] ?? [];
            
            $gallery_tab = $kenpo_tabs['gallery'] ?? [];
            $gallery_intro = $gallery_tab['intro_text'] ?? '';
            $gallery_images = $gallery_tab['images'] ?? [];
            
            $contact_tab = $kenpo_tabs['contact'] ?? [];
            $contact_map = $contact_tab['map'] ?? [];
            $contact_location = $contact_tab['location'] ?? [];
            $contact_info = $contact_tab['contact'] ?? [];
            $contact_class_time = $contact_tab['class_time'] ?? [];
            ?>
            <!-- About Tab -->
            <div class="tab-pane fade<?php echo $about_dom_id === $first_tab_id ? ' show active' : ''; ?>" id="<?php echo htmlspecialchars($about_dom_id); ?>-content" role="tabpanel" aria-labelledby="<?php echo htmlspecialchars($about_dom_id); ?>-tab">
              <div class="row align-items-center g-4">
                <!-- Kenpo Training Photo -->
                <div class="col-lg-6">
                  <div style="text-align: center;">
                    <img src="<?php echo htmlspecialchars($about_hero['src'] ?? 'assets/images/kenpo/shuffle/IMG_0126.webp'); ?>" 
                         alt="<?php echo htmlspecialchars($about_hero['alt'] ?? 'Kaizen Kenpo Training Session'); ?>" 
                         style="width: 100%; max-width: 700px; height: auto;">
                  </div>
                </div>
                
                <!-- About Information -->
                <div class="col-lg-6">
                  <div style="padding: 1rem;">
                    <p style="color: #495057; font-size: 1.2rem; line-height: 1.8; margin-bottom: 1.5rem; text-align: center;">
                      <?php echo htmlspecialchars($about_tab['lead_text'] ?? ''); ?>
                    </p>
                    
                    <!-- Class Schedule -->
                    <div style="background: rgba(44, 62, 80, 0.05); border: 1px solid rgba(44, 62, 80, 0.1); padding: 1rem; border-radius: 6px; text-align: center; margin: 1.5rem 0;">
                      <p style="color: #2c3e50; font-weight: 600; margin-bottom: 0.5rem; font-size: 0.95rem;">
                        <?php echo htmlspecialchars($about_schedule['label'] ?? 'Class Time'); ?>
                      </p>
                      <p style="color: #495057; font-size: 1rem; font-weight: 500; margin: 0;">
                        <?php echo htmlspecialchars($about_schedule['value'] ?? 'Sundays: 1:00pm - 2:00pm'); ?>
                      </p>
                    </div>
                    
                    <!-- Program Information -->
                    <div style="padding: 1.5rem 0; margin-bottom: 2rem; border-left: 4px solid #dc3545; padding-left: 1.5rem;">
                      <h5 style="color: #dc3545; margin-bottom: 1rem;">
                        <i class="<?php echo htmlspecialchars($about_highlight['icon'] ?? 'fas fa-star'); ?>" style="margin-right: 0.5rem;"></i>
                        <?php echo htmlspecialchars($about_highlight['title'] ?? 'Invitation-Only Program'); ?>
                      </h5>
                      <p style="color: #495057; margin: 0; font-size: 1rem; line-height: 1.6;">
                        <?php echo htmlspecialchars($about_highlight['text'] ?? 'Kaizen Kenpo is a division of Kaizen Karate LLC, offering advanced martial arts training for dedicated practitioners.'); ?>
                      </p>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div style="text-align: center; display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                      <a href="<?php echo htmlspecialchars($about_primary['url'] ?? 'https://www.gomotionapp.com/team/mdkfu/page/class-registration'); ?>" 
                         target="_blank"
                         style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; padding: 1.2rem 2rem; border-radius: 25px; text-decoration: none; font-weight: 600; font-size: 1.1rem; display: inline-block; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);"
                         onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(220, 53, 69, 0.4)';"
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(220, 53, 69, 0.3)';">
                        <i class="fas fa-user-plus" style="margin-right: 0.6rem;"></i>
                        <?php echo htmlspecialchars($about_primary['label'] ?? 'Register Now'); ?>
                      </a>
                      
                      <a href="<?php echo htmlspecialchars($about_secondary['url'] ?? 'https://www.kaizenkenpo.net/'); ?>" 
                         target="_blank"
                         style="background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%); color: white; padding: 1.2rem 2rem; border-radius: 25px; text-decoration: none; font-weight: 600; font-size: 1.1rem; display: inline-block; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(44, 62, 80, 0.3);"
                         onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(44, 62, 80, 0.4)';"
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(44, 62, 80, 0.3)';">
                        <i class="fas fa-external-link-alt" style="margin-right: 0.6rem;"></i>
                        <?php echo htmlspecialchars($about_secondary['label'] ?? 'Visit Website'); ?>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- IKCA Kenpo Tab Content -->
            <div class="tab-pane fade<?php echo $ikca_dom_id === $first_tab_id ? ' show active' : ''; ?>" id="<?php echo htmlspecialchars($ikca_dom_id); ?>-content" role="tabpanel" aria-labelledby="<?php echo htmlspecialchars($ikca_dom_id); ?>-tab">
              <div class="row align-items-center g-4">
                <!-- IKCA Logo -->
                <div class="col-lg-6">
                  <div style="text-align: center;">
                    <img src="<?php echo htmlspecialchars($ikca_image['src'] ?? 'assets/images/kenpo/karate-connection.webp'); ?>" 
                         alt="<?php echo htmlspecialchars($ikca_image['alt'] ?? 'IKCA Karate Connection Logo'); ?>" 
                         style="width: 100%; max-width: 400px; height: auto;">
                    <?php if (!empty($ikca_image['caption'])): ?>
                      <p style="color: #666; font-size: 0.9rem; font-style: italic; margin-top: 1rem; text-align: center;">
                        <?php echo htmlspecialchars($ikca_image['caption']); ?>
                      </p>
                    <?php endif; ?>
                  </div>
                </div>
                
                <!-- IKCA Information -->
                <div class="col-lg-6">
                  <div style="padding: 1rem;">
                    <?php if (!empty($ikca_tab['intro_heading'])): ?>
                      <p style="color: #495057; font-size: 1.3rem; line-height: 1.8; margin-bottom: 1.5rem; font-weight: 600;">
                        <?php echo htmlspecialchars($ikca_tab['intro_heading']); ?>
                      </p>
                    <?php endif; ?>
                    
                    <?php foreach ($ikca_paragraphs as $index => $paragraph): ?>
                      <p style="color: #495057; font-size: 1.1rem; line-height: 1.8; margin-bottom: <?php echo $index === array_key_last($ikca_paragraphs) ? '0' : '1.5rem'; ?>;">
                        <?php echo htmlspecialchars($paragraph); ?>
                      </p>
                    <?php endforeach; ?>
                    
                    <?php if (!empty($ikca_tab['video_embed'])): ?>
                      <div style="margin-top: 1.5rem;">
                        <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                          <iframe src="<?php echo htmlspecialchars($ikca_tab['video_embed']); ?>"
                                  title="IKCA Kenpo Video"
                                  style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;"
                                  allowfullscreen
                                  loading="lazy"></iframe>
                        </div>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Photo Gallery Tab -->
            <div class="tab-pane fade<?php echo $gallery_dom_id === $first_tab_id ? ' show active' : ''; ?>" id="<?php echo htmlspecialchars($gallery_dom_id); ?>-content" role="tabpanel" aria-labelledby="<?php echo htmlspecialchars($gallery_dom_id); ?>-tab">
              <div style="display: flex; align-items: flex-start; gap: 2rem;">
                <!-- Gallery Images -->
                <div style="flex: 1;">
                  <div style="text-align: center;">
                    <div class="kenpo-image-shuffle">
                      <div class="shuffle-container">
                        <?php
                          $gallery_items = array_values(array_filter($gallery_images, function ($image) {
                              return !empty($image['src']);
                          }));
                        ?>
                        <?php if (!empty($gallery_items)): ?>
                        <?php foreach ($gallery_items as $index => $image): 
                          $slide_class = $index === 0 ? 'shuffle-slide active' : 'shuffle-slide';
                          $caption_text = $image['caption'] ?? '';
                        ?>
                        <div class="<?php echo $slide_class; ?>" data-caption="<?php echo htmlspecialchars($caption_text); ?>">
                          <img src="<?php echo htmlspecialchars($image['src'] ?? ''); ?>" 
                               alt="<?php echo htmlspecialchars($image['alt'] ?? 'Kaizen Kenpo Training'); ?>"
                               style="width: 100%; max-width: 500px; height: auto;">
                        </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <div class="shuffle-slide active" data-caption="">
                          <img src="assets/images/kenpo/shuffle/IMG_5336.webp"
                               alt="Kaizen Kenpo Training"
                               style="width: 100%; max-width: 500px; height: auto;">
                        </div>
                        <?php endif; ?>
                      </div>
                    
                      <!-- Photo Caption -->
                      <div style="margin-top: 1rem; text-align: center;">
                        <p id="current-caption" style="font-family: 'Playfair Display', serif; font-size: 1.3rem; color: #495057; margin: 0; line-height: 1.4; font-weight: 400;">
                          <?php echo htmlspecialchars($gallery_items[0]['caption'] ?? ''); ?>
                        </p>
                      </div>
                    
                      <!-- Thumbnail Navigation with Arrows -->
                      <div style="display: flex; align-items: center; justify-content: center; gap: 15px; margin-top: 20px;">
                        <!-- Left Arrow -->
                        <button class="shuffle-prev" onclick="changeSlide(-1)" style="background: rgba(0, 0, 0, 0.5); color: white; border: none; width: 35px; height: 35px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease;">
                          <i class="fas fa-chevron-left"></i>
                        </button>
                        
                        <!-- Thumbnails -->
                        <div class="shuffle-thumbnails" style="display: flex; gap: 12px;">
                          <?php foreach ($gallery_items as $index => $image): 
                            $thumb_class = $index === 0 ? 'thumbnail-nav active' : 'thumbnail-nav';
                            $border_style = $index === 0
                              ? 'border: 2px solid rgba(220, 53, 69, 0.8); opacity: 1;'
                              : 'border: 2px solid rgba(255, 255, 255, 0.5); opacity: 0.7;';
                          ?>
                          <img src="<?php echo htmlspecialchars($image['src'] ?? ''); ?>" 
                               onclick="currentSlide(<?php echo $index + 1; ?>)" 
                               class="<?php echo $thumb_class; ?>"
                               style="width: 50px; height: 40px; object-fit: cover; border-radius: 4px; cursor: pointer; transition: all 0.3s ease; <?php echo $border_style; ?>"
                               alt="<?php echo htmlspecialchars($image['alt'] ?? 'Gallery Thumbnail'); ?>">
                          <?php endforeach; ?>
                        </div>
                        
                        <!-- Right Arrow -->
                        <button class="shuffle-next" onclick="changeSlide(1)" style="background: rgba(0, 0, 0, 0.5); color: white; border: none; width: 35px; height: 35px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease;">
                          <i class="fas fa-chevron-right"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Contact & Location Tab Content -->
            <div class="tab-pane fade<?php echo $contact_dom_id === $first_tab_id ? ' show active' : ''; ?>" id="<?php echo htmlspecialchars($contact_dom_id); ?>-content" role="tabpanel" aria-labelledby="<?php echo htmlspecialchars($contact_dom_id); ?>-tab">
              <div class="row align-items-start g-4">
                <!-- Google Maps -->
                <div class="col-lg-6">
                  <div style="padding: 1rem;">
                    <h4 style="color: #dc3545; font-weight: 600; margin-bottom: 1.5rem; font-size: 1.4rem;">
                      <i class="fas fa-map-marker-alt" style="margin-right: 0.5rem;"></i><?php echo htmlspecialchars($contact_map['heading'] ?? 'Find Us'); ?>
                    </h4>
                    
                    <div style="border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                      <iframe 
                        src="<?php echo htmlspecialchars($contact_map['embed_url'] ?? ''); ?>"
                        width="100%" 
                        height="400" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                      </iframe>
                    </div>
                  </div>
                </div>
                
                <!-- Contact & Location Information -->
                <div class="col-lg-6">
                  <div style="padding: 1rem;">
                    <h4 style="color: #dc3545; font-weight: 600; margin-bottom: 1.5rem; font-size: 1.4rem;">
                      <i class="fas fa-map-pin" style="margin-right: 0.5rem;"></i><?php echo htmlspecialchars($contact_location['heading'] ?? 'Location'); ?>
                    </h4>
                    
                    <div style="background: rgba(248, 248, 248, 0.8); border: 1px solid rgba(220, 53, 69, 0.2); padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem;">
                      <p style="color: #495057; font-size: 1rem; line-height: 1.6; margin: 0;">
                        <?php
                        $location_lines = $contact_location['lines'] ?? [];
                        echo implode('<br>', array_map('htmlspecialchars', $location_lines));
                        ?>
                      </p>
                    </div>
                    
                    <h4 style="color: #dc3545; font-weight: 600; margin-bottom: 1.5rem; font-size: 1.4rem;">
                      <i class="fas fa-envelope" style="margin-right: 0.5rem;"></i><?php echo htmlspecialchars($contact_info['heading'] ?? 'Contact Us'); ?>
                    </h4>
                    
                    <div style="background: rgba(248, 248, 248, 0.8); border: 1px solid rgba(220, 53, 69, 0.2); padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem;">
                      <p style="color: #495057; font-size: 1rem; line-height: 1.6; margin: 0;">
                        <strong>Phone:</strong> <?php echo htmlspecialchars($contact_info['phone'] ?? ''); ?><br>
                        <strong>Email:</strong> <?php echo htmlspecialchars($contact_info['email'] ?? ''); ?>
                      </p>
                    </div>
                    
                    <h4 style="color: #dc3545; font-weight: 600; margin-bottom: 1.5rem; font-size: 1.4rem;">
                      <i class="fas fa-clock" style="margin-right: 0.5rem;"></i><?php echo htmlspecialchars($contact_class_time['heading'] ?? 'Class Time'); ?>
                    </h4>
                    
                    <div style="background: rgba(220, 53, 69, 0.1); border: 2px solid rgba(220, 53, 69, 0.3); padding: 1.5rem; border-radius: 8px; text-align: center;">
                      <p style="color: #dc3545; font-size: 1.2rem; font-weight: 600; margin: 0;">
                        <?php echo htmlspecialchars($contact_class_time['value'] ?? 'Sundays: 1:00pm - 2:00pm'); ?>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>
</section>
<script>
    // Video control functions
    window.togglePlayPause = function() {
        const video = document.getElementById('hero-video');
        const pausePlayIcon = document.getElementById('pausePlayIcon');
        
        if (!video) return;
        
        if (video.paused) {
            video.play().then(() => {
                if (pausePlayIcon) {
                    pausePlayIcon.className = 'fas fa-pause';
                }
            }).catch(e => {
                console.error('Error playing video:', e);
            });
        } else {
            video.pause();
            if (pausePlayIcon) {
                pausePlayIcon.className = 'fas fa-play';
            }
        }
    };
    
    window.toggleMute = function() {
        const video = document.getElementById('hero-video');
        const muteUnmuteIcon = document.getElementById('muteUnmuteIcon');
        
        if (!video) return;
        
        if (video.muted) {
            video.muted = false;
            if (muteUnmuteIcon) {
                muteUnmuteIcon.className = 'fas fa-volume-up';
            }
        } else {
            video.muted = true;
            if (muteUnmuteIcon) {
                muteUnmuteIcon.className = 'fas fa-volume-mute';
            }
        }
    };
  </script>
