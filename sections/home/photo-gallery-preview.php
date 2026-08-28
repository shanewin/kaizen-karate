<section id="photo-gallery-preview" style="background: #f8f9fa; padding: 0; margin: 0;">
  <style>
    .gs-thumb-link img { transition: transform 0.35s ease; }
    .gs-thumb-link:hover img { transform: scale(1.06); }
    .gs-cta-btn { transition: all 0.2s ease; }
    .gs-cta-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(164,51,43,0.4) !important; }
    #photo-gallery-preview .gs-header { padding: 2.5rem 0; }
    #photo-gallery-preview .gs-body  { padding: 3rem 15px; }
    @media (max-width: 767px) {
      #photo-gallery-preview .gs-header h2 { font-size: 2.2rem !important; }
      #photo-gallery-preview .gs-header p  { font-size: 1rem !important; }
      #photo-gallery-preview .gs-body      { padding: 2rem 15px; }
    }
    @media (max-width: 400px) {
      #photo-gallery-preview .gs-header h2 { font-size: 1.8rem !important; }
    }
  </style>

  <div class="gs-header" style="background: linear-gradient(135deg, #a4332b 0%, #721c24 100%);">
    <div class="container text-center">
      <h2 style="color:white; font-family:'Playfair Display',serif; font-size:3rem; font-weight:700; text-decoration:underline; text-underline-offset:0.3em; text-decoration-color:rgba(255,255,255,0.7); margin:0;">
        <?php echo display_text('gallery_section', 'title', 'Photo Gallery'); ?>
      </h2>
      <p style="color:rgba(255,255,255,0.9); font-size:1.15rem; margin:0.75rem 0 0;">
        <?php echo display_text('gallery_section', 'subtitle', 'Moments from the Kaizen Karate community'); ?>
      </p>
    </div>
  </div>

  <div class="container gs-body">
    <?php $intro = htmlspecialchars($_gs['intro_text'] ?? ''); if ($intro): ?>
      <p style="text-align:center; color:#555; font-size:1.1rem; max-width:700px; margin:0 auto 2.5rem; line-height:1.7;">
        <?php echo $intro; ?>
      </p>
    <?php endif; ?>

    <?php if (!empty($_gs_images)): ?>
      <div class="row g-2 justify-content-center" style="max-width:920px; margin:0 auto 2.5rem;">
        <?php foreach ($_gs_images as $_img): ?>
          <div class="col-6 col-md-4">
            <a href="gallery.php" class="gs-thumb-link d-block overflow-hidden rounded" style="aspect-ratio:4/3;">
              <img src="<?php echo htmlspecialchars($_img['thumb'] ?? $_img['full']); ?>"
                   alt="<?php echo htmlspecialchars($_img['alt'] ?? $_img['caption'] ?? 'Kaizen Karate'); ?>"
                   loading="lazy"
                   style="width:100%; height:100%; object-fit:cover; display:block;">
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <div class="text-center">
      <a href="gallery.php" class="gs-cta-btn" style="display:inline-block; background:linear-gradient(135deg,#a4332b,#721c24); color:white; font-weight:700; font-size:1rem; padding:0.85rem 2.25rem; border-radius:8px; text-decoration:none; letter-spacing:0.05em; box-shadow:0 4px 15px rgba(164,51,43,0.3); transition:all 0.2s ease;">
        <?php echo display_text('gallery_section', 'button_text', 'View All Photos'); ?> &rarr;
      </a>
    </div>
  </div>
</section>
