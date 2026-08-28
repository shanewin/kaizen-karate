<?php 
$nyc_data = get_content('nyc_section');
$features = $nyc_data['features'] ?? [];
$header = $nyc_data['header'] ?? [];
$badge = $nyc_data['badge'] ?? [];
$video = $nyc_data['video'] ?? [];
$contact = $nyc_data['contact'] ?? [];
$cta = $nyc_data['cta'] ?? [];
?>
<section id="NYC" class="nyc-inline">
    <div class="nyc-video-container">
        <video autoplay muted loop playsinline class="nyc-bg-video lazy-video">
            <source data-src="<?php echo htmlspecialchars($video['source'] ?? 'assets/videos/nyc/manhattan_two_bridges.mp4'); ?>" type="video/mp4">
        </video>
        <div class="nyc-overlay"></div>
    </div>

    <div class="nyc-content-container">
        <div class="nyc-badge">
            <i class="<?php echo htmlspecialchars($badge['icon'] ?? 'fas fa-check-circle'); ?>"></i> <?php echo htmlspecialchars($badge['text'] ?? 'NYC PUBLIC SCHOOLS VENDOR'); ?>
        </div>
        
        <div class="nyc-scroll-wrapper nyc-hero-flex-container">
            <h2 class="nyc-title"><?php echo $header['title'] ?? 'Kaizen Karate <span class="nyc-red">NYC</span>'; ?></h2>
            <p class="nyc-subtitle"><?php echo htmlspecialchars($header['subtitle'] ?? 'Bringing our tradition of excellence to the 5 Boroughs.'); ?></p>
            
            <div class="nyc-features-grid">
                <?php foreach ($features as $feature): ?>
                <div class="nyc-feature-item">
                    <i class="<?php echo htmlspecialchars($feature['icon'] ?? 'fas fa-star'); ?> nyc-feature-icon"></i>
                    <span><?php echo htmlspecialchars($feature['text'] ?? ''); ?></span>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="nyc-info-grid">
                <div class="nyc-info-item">
                    <div class="nyc-info-row">
                        <i class="fas fa-map-marker-alt nyc-icon"></i>
                        <div class="nyc-info-text">
                            <span class="nyc-placeholder nyc-address-text"><?php echo $contact['address'] ?? '745 5th Avenue, Suite 500<br>New York, NY 100151'; ?></span>
                        </div>
                    </div>

                    <div class="nyc-info-row">
                        <i class="fas fa-phone-alt nyc-icon"></i>
                        <div class="nyc-info-text">
                            <span class="nyc-placeholder"><?php echo htmlspecialchars($contact['phone'] ?? '(646) 475-7328'); ?></span>
                        </div>
                    </div>

                    <div class="nyc-info-row">
                        <i class="fas fa-envelope nyc-icon"></i>
                        <div class="nyc-info-text">
                            <span class="nyc-placeholder"><?php echo htmlspecialchars($contact['email'] ?? 'coach.v@kaizenkarateusa.com'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="nyc-cta-container">
                <a href="<?php echo htmlspecialchars($cta['url'] ?? 'nyc.php'); ?>" class="nyc-btn-primary"><?php echo htmlspecialchars($cta['text'] ?? 'Learn More'); ?></a>
            </div>

            <script src="modules/nyc/nyc-script.js?v=<?php echo time(); ?>"></script>
        </div>
    </div>
</section>
