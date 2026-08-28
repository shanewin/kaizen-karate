<?php
/**
 * Homepage Popup for Kaizen Karate
 * 
 * Renders a dismissible popup based on CMS settings.
 */

// Only run on homepage (index.php) or preview site (testing.php)
if (basename($_SERVER['PHP_SELF']) !== 'index.php' && basename($_SERVER['PHP_SELF']) !== 'testing.php') {
    return;
}

// Ensure $site_content is available (loaded in index.php via content-loader.php)
global $site_content;

// Get popup settings with defaults from site-content.json
$popupData = $site_content['homepage_popup'] ?? [
    'enabled' => false,
    'title' => 'Homepage Popup',
    'display_frequency' => 'once_per_day',
    'show_delay_seconds' => 5,
    'auto_close_seconds' => 0,
    'content_type' => 'text_only',
    'content' => [
        'text' => '<h2>Special Announcement!</h2><p>Welcome to our new homepage.</p>',
        'carousel' => [],
        'video' => ['type' => 'embed', 'value' => '']
    ],
    'cta' => [
        'enabled' => false,
        'text' => '',
        'url' => '',
        'style' => 'primary'
    ],
    'appearance' => [
        'size' => 'medium',
        'overlay_opacity' => 0.7,
        'close_position' => 'top_right'
    ]
];

// Check if enabled
if (empty($popupData['enabled'])) {
    return;
}

// Extract settings
$enabled = $popupData['enabled'];
$displayFreq = $popupData['display_frequency'] ?? 'once_per_day';
$delaySec = (int)($popupData['show_delay_seconds'] ?? 5);
$autoCloseSec = (int)($popupData['auto_close_seconds'] ?? 0);
$slideInterval = (int)($popupData['slide_interval_seconds'] ?? 4);
$rawSlides = $popupData['slides'] ?? [];
$appearance = $popupData['appearance'] ?? [];

// Filter out disabled slides and re-index for the carousel
$slides = array_values(array_filter($rawSlides, function($slide) {
    return !isset($slide['enabled']) || $slide['enabled'];
}));

if (empty($slides)) {
    return;
}

$modalSize = 'modal-xl'; // Expanded to xl for better navigation space
if ($appearance['size'] === 'small') $modalSize = '';
if ($appearance['size'] === 'medium') $modalSize = 'modal-lg';
if ($appearance['size'] === 'large') $modalSize = 'modal-xl';

$overlayOpacity = $appearance['overlay_opacity'] ?? 0.7;
?>

<!-- Homepage Popup Modal -->
<div class="modal fade" id="hpPopupModal" tabindex="-1" aria-labelledby="hpPopupLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered <?php echo $modalSize; ?>">
        <div class="modal-content border-0 shadow-lg position-relative" style="overflow: hidden;">
            
            <!-- Close Button -->
            <?php if (($appearance['close_position'] ?? 'top_right') === 'top_right'): ?>
                <button type="button" id="hpPopupCloseBtn" class="btn-close position-absolute" data-bs-dismiss="modal" aria-label="Close" style="top: 15px; right: 15px; z-index: 1100; background-color: rgba(255,255,255,0.8); border-radius: 50%; padding: 0.5rem;"></button>
            <?php endif; ?>

            <div class="modal-body p-0">
                <!-- Main Slide Carousel -->
                <div id="hpPopupSlideCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="<?php echo $slideInterval * 1000; ?>">
                    
                    <!-- Indicators -->
                    <?php if (count($slides) > 1): ?>
                        <div class="carousel-indicators hp-indicators-pill">
                            <?php foreach ($slides as $index => $slide): ?>
                                <button type="button" data-bs-target="#hpPopupSlideCarousel" data-bs-slide-to="<?php echo $index; ?>" class="<?php echo $index === 0 ? 'active' : ''; ?>" aria-current="<?php echo $index === 0 ? 'true' : 'false'; ?>" aria-label="Slide <?php echo $index + 1; ?>"></button>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <div class="carousel-inner">
                        <?php foreach ($slides as $index => $slide): ?>
                            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>" <?php echo $slide['type'] === 'image' ? 'style="background: rgba(0,0,0,0.05);"' : ''; ?>>
                                
                                <?php if ($slide['type'] === 'image'): ?>
                                    <!-- Image Slide with Hybrid Support -->
                                    <?php 
                                        $hasContent = !empty($slide['title']) || !empty($slide['content_text']) || !empty($slide['cta']['enabled']); 
                                        $bgStyle = $hasContent ? '' : 'style="background-image: url(\''.htmlspecialchars($slide['src']).'\'); background-size: cover; background-position: center; filter: blur(20px); opacity: 0.15; position: absolute; top:0; left:0; width:100%; height:100%; z-index: -1;"';
                                    ?>
                                    <div class="row g-0 position-relative" style="min-height: 550px; <?php echo $hasContent ? '' : 'overflow: hidden;'; ?>">
                                        <?php if (!$hasContent): ?>
                                            <div class="image-bg-blur" <?php echo $bgStyle; ?>></div>
                                        <?php endif; ?>

                                        <?php if ($hasContent): ?>
                                            <!-- Stacked Layout (Image Top, Content Bottom) -->
                                            <div class="col-12 d-flex flex-column bg-white">
                                                <div class="text-center p-2 p-md-3" style="background: rgba(0,0,0,0.03)!important;">
                                                    <img src="<?php echo htmlspecialchars($slide['src']); ?>" class="img-fluid mx-auto d-block" style="max-height: 65vh; max-width: 100%; width: auto; height: auto; object-fit: contain; margin: 0 auto; min-height: 400px;">
                                                </div>
                                                <div class="p-3 p-lg-4 pb-4 d-flex flex-column align-items-center text-center">
                                                    <style>
                                                        .slide-content-title {
                                                            font-family: 'Playfair Display', serif;
                                                            font-weight: 700;
                                                            background: linear-gradient(135deg, #a4332b, #dc3545);
                                                            -webkit-background-clip: text;
                                                            -webkit-text-fill-color: transparent;
                                                            background-clip: text;
                                                            margin-bottom: 1.5rem;
                                                            line-height: 1.2;
                                                        }
                                                        @media (min-width: 992px) { .slide-content-title { font-size: 2.2rem; } }
                                                        @media (max-width: 991px) { .slide-content-title { font-size: 1.8rem; } }
                                                    </style>
                                                    <?php if (!empty($slide['title'])): ?>
                                                        <h2 class="slide-content-title"><?php echo htmlspecialchars($slide['title']); ?></h2>
                                                    <?php endif; ?>
                                                    
                                                    <?php if (!empty($slide['content_text'])): ?>
                                                        <div class="popup-text-content mb-4" style="font-size: 0.95rem;">
                                                            <?php echo $slide['content_text']; ?>
                                                        </div>
                                                    <?php endif; ?>

                                                    <?php if (!empty($slide['cta']['enabled']) && !empty($slide['cta']['url'])): ?>
                                                        <?php 
                                                            $isExternal = !str_starts_with($slide['cta']['url'], '#'); 
                                                            $targetAttr = $isExternal ? 'target="_blank" rel="noopener"' : '';
                                                            $btnStyle = $slide['cta']['style'] ?? 'danger';
                                                            if ($btnStyle === 'primary') $btnStyle = 'danger';
                                                            if ($btnStyle === 'outline-primary') $btnStyle = 'outline-danger';
                                                        ?>
                                                        <div class="mt-auto pt-2">
                                                            <a href="<?php echo htmlspecialchars($slide['cta']['url']); ?>" <?php echo $targetAttr; ?> class="popup-cta-btn btn btn-<?php echo htmlspecialchars($btnStyle); ?> rounded-pill px-5 py-3 shadow text-uppercase fw-bold" style="letter-spacing: 1px; font-size: 1rem;">
                                                                <?php echo htmlspecialchars($slide['cta']['text'] ?? 'Learn More'); ?>
                                                            </a>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <!-- Simple Image Layout -->
                                            <div class="col-12 d-flex align-items-center justify-content-center" style="height: 550px; z-index: 1;">
                                                <img src="<?php echo htmlspecialchars($slide['src']); ?>" class="d-block h-100 shadow-lg" style="object-fit: contain; max-width: 100%;">
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                <?php elseif ($slide['type'] === 'dynamic'): ?>
                                    <!-- Dynamic Content Slide -->
                                    <div class="row g-0" style="min-height: 550px;">
                                        <div class="col-12 p-4 p-md-5 pb-5 d-flex flex-column justify-content-center">
                                            
                                            <!-- Responsive Styles for Popup -->
                                            <style>
                                                .popup-header-title {
                                                    display: block !important;
                                                    font-family: 'Playfair Display', serif;
                                                    font-weight: 700;
                                                    letter-spacing: 1.2px;
                                                    background: linear-gradient(135deg, #a4332b, #dc3545);
                                                    -webkit-background-clip: text;
                                                    -webkit-text-fill-color: transparent;
                                                    background-clip: text;
                                                    text-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
                                                    width: 100%;
                                                    text-align: center;
                                                    line-height: 1.2;
                                                    margin-bottom: 20px !important;
                                                }
                                                @media (min-width: 992px) { .popup-header-title { font-size: 2.5rem; } }
                                                @media (max-width: 991px) { .popup-header-title { font-size: 2rem !important; } }
                                                @media (max-width: 576px) {
                                                    .popup-header-title { font-size: 1.6rem !important; margin-bottom: 15px !important; white-space: normal; }
                                                    #hpPopupSlideCarousel .carousel-item .p-md-4 { padding: 1rem !important; }
                                                    .popup-text-content p.text-center { font-size: 0.9rem !important; margin-bottom: 20px !important; }
                                                }
                                            </style>

                                            <?php if (!empty($slide['title'])): ?>
                                                <h1 class="popup-header-title text-center"><?php echo htmlspecialchars($slide['title']); ?></h1>
                                            <?php endif; ?>

                                            <div class="popup-text-content mb-4" style="max-height: 400px; overflow-y: auto; padding-right: 5px;">
                                                <?php echo $slide['content_text'] ?? ''; ?>
                                            </div>

                                            <?php if (!empty($slide['cta']['enabled']) && !empty($slide['cta']['url'])): ?>
                                                <?php 
                                                    $isExternal = !str_starts_with($slide['cta']['url'], '#'); 
                                                    $targetAttr = $isExternal ? 'target="_blank" rel="noopener"' : '';
                                                    $btnStyle = $slide['cta']['style'] ?? 'danger';
                                                    if ($btnStyle === 'primary') $btnStyle = 'danger';
                                                    if ($btnStyle === 'outline-primary') $btnStyle = 'outline-danger';
                                                ?>
                                                <div class="mt-auto text-center">
                                                    <a href="<?php echo htmlspecialchars($slide['cta']['url']); ?>" <?php echo $targetAttr; ?> class="popup-cta-btn btn btn-<?php echo htmlspecialchars($btnStyle); ?> rounded-pill px-5 py-3 shadow-lg text-uppercase fw-bold" style="letter-spacing: 1.5px; font-size: 1rem;">
                                                        <?php echo htmlspecialchars($slide['cta']['text'] ?? 'Learn More'); ?>
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Carousel Controls -->
                    <button class="carousel-control-prev hp-nav-control" type="button" data-bs-target="#hpPopupSlideCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon shadow-sm" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next hp-nav-control" type="button" data-bs-target="#hpPopupSlideCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon shadow-sm" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Persistent Mini-Pop-Up Trigger (Minimized State) -->
<div id="hpPopupMinimizedTrigger" class="hp-popup-trigger" aria-label="View Announcements" style="display: none;">
    <div class="trigger-icon">
        <i class="fas fa-bullhorn"></i>
        <span class="trigger-badge"><?php echo count($slides); ?></span>
    </div>
    <div class="pulse-ring"></div>
</div>

<style>
#hpPopupModal .btn-close:focus {
    box-shadow: none;
}
#hpPopupModal .min-vh-25 {
    min-height: 250px;
}
.object-fit-cover {
    object-fit: cover;
}
#hpPopupModal .modal-content {
    background: #fff;
    border-radius: 12px;
    border: 1px solid rgba(0, 0, 0, 0.1);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2), 0 5px 15px rgba(0, 0, 0, 0.1);
}
#hpPopupModal .popup-text-content h2 {
    font-family: 'Playfair Display', serif;
    font-weight: 700;
    margin-bottom: 1.5rem;
}
/* Handle Backdrop Opacity & Blur */
.modal-backdrop.hp-popup-backdrop {
    opacity: <?php echo $overlayOpacity; ?> !important;
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
}

/* Premium Close Button */
#hpPopupModal .btn-close {
    opacity: 0.8;
    background-color: white;
    border-radius: 50%;
    padding: 0.8rem;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}
#hpPopupModal .btn-close:hover {
    opacity: 1;
    transform: rotate(90deg);
    background-color: #f8f9fa;
    box-shadow: 0 6px 15px rgba(0,0,0,0.15);
}

/* Entrance Animation */
@keyframes hpPopupEntrance {
    from {
        opacity: 0;
        transform: translate(0, 30px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translate(0, 0) scale(1);
    }
}
#hpPopupModal .modal-content {
    animation: hpPopupEntrance 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
}

/* Minimized Trigger Styles */
.hp-popup-trigger {
    position: fixed;
    bottom: 30px;
    left: 30px;
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #a4332b, #dc3545);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(164, 51, 43, 0.4);
    z-index: 9999;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    animation: triggerEntrance 0.5s ease-out forwards;
}

.hp-popup-trigger:hover {
    transform: scale(1.1) rotate(5deg);
    box-shadow: 0 6px 20px rgba(164, 51, 43, 0.6);
}

.hp-popup-trigger .trigger-icon {
    position: relative;
    z-index: 2;
}

.hp-popup-trigger .trigger-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: white;
    color: #dc3545;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    font-size: 12px;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

.hp-popup-trigger .pulse-ring {
    position: absolute;
    width: 100%;
    height: 100%;
    border: 3px solid #dc3545;
    border-radius: 50%;
    animation: triggerPulse 2s infinite;
    opacity: 0;
}

@keyframes triggerEntrance {
    from {
        opacity: 0;
        transform: scale(0.5) translateY(20px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

@keyframes triggerPulse {
    0% { transform: scale(1); opacity: 0.5; }
    100% { transform: scale(1.6); opacity: 0; }
}

/* Enhanced Carousel Navigation */
#hpPopupModal .hp-nav-control {
    width: 60px;
    height: 60px;
    top: 50%;
    transform: translateY(-50%);
    opacity: 0.8;
    z-index: 1053;
    background: rgba(0,0,0,0.4);
    border-radius: 50%;
    margin: 0 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}
#hpPopupModal .hp-nav-control:hover {
    opacity: 1;
    background: rgba(0,0,0,0.6);
}
# hpPopupModal .carousel-control-prev {
    left: 0;
    right: auto;
}
#hpPopupModal .carousel-control-next {
    right: 0;
    left: auto;
}
@media (min-width: 992px) {
    #hpPopupModal .hp-nav-control {
        width: 70px;
        height: 70px;
        background: rgba(0,0,0,0.25);
    }
}
@media (max-width: 991px) {
    #hpPopupModal .hp-nav-control {
        width: 45px;
        height: 45px;
        background: rgba(0,0,0,0.5);
    }
    #hpPopupModal .carousel-control-prev { left: 5px; }
    #hpPopupModal .carousel-control-next { right: 5px; }
}
#hpPopupModal .hp-nav-control span {
    width: 25px;
    height: 25px;
}

/* Make space at the bottom for indicators so they don't cover the image */
#hpPopupSlideCarousel {
    padding-bottom: 45px;
}

/* Obvious Navigation Dots */
#hpPopupModal .hp-indicators-pill {
    bottom: 10px;
    background: rgba(0,0,0,0.15);
    padding: 8px 15px;
    border-radius: 30px;
    width: fit-content;
    margin: 0 auto;
    z-index: 1052;
}
#hpPopupModal .hp-indicators-pill button {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid rgba(255,255,255,0.4);
    background-color: white;
    box-sizing: content-box;
    margin: 0 6px;
    opacity: 0.5;
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
#hpPopupModal .hp-indicators-pill button.active {
    opacity: 1;
    transform: scale(1.2);
    border-color: #dc3545;
    background-color: #dc3545;
}

/* Mobile Adjustments for Trigger */
@media (max-width: 768px) {
    .hp-popup-trigger {
        bottom: 20px;
        left: 20px;
        width: 50px;
        height: 50px;
        font-size: 20px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle specific CTA click behavior for anchors
    document.querySelectorAll('.popup-cta-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href && href.startsWith('#')) {
                e.preventDefault();
                
                // Close modal
                minimizePopup();
                
                // Scroll to target
                const targetEl = document.querySelector(href);
                if (targetEl) {
                    // Small delay to allow modal to close cleanly
                    setTimeout(() => {
                        targetEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }, 300);
                }
            } else if (href && !href.startsWith('#')) {
                // Reinforce external links opening in new tab
                this.setAttribute('target', '_blank');
                this.setAttribute('rel', 'noopener');
            }
        });
    });

    // Manual Close Button Fallback
    const closeBtn = document.getElementById('hpPopupCloseBtn');
    const triggerBtn = document.getElementById('hpPopupMinimizedTrigger');

    function minimizePopup() {
        const modalEl = document.getElementById('hpPopupModal');
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) {
            modalInstance.hide();
        }
        
        // Show the minimized trigger
        if (triggerBtn) {
            triggerBtn.style.display = 'flex';
        }
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', minimizePopup);
    }

    if (triggerBtn) {
        triggerBtn.addEventListener('click', function() {
            const modalEl = document.getElementById('hpPopupModal');
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            
            // Hide trigger
            this.style.display = 'none';
            
            // Show modal
            if (modalInstance) {
                modalInstance.show();
            } else {
                const newModal = new bootstrap.Modal(modalEl);
                newModal.show();
            }
        });
    }

    const P_NAME = 'kaizen_hp_popup';
    const settings = {
        enabled: <?php echo $enabled ? 'true' : 'false'; ?>,
        frequency: '<?php echo $displayFreq; ?>',
        delay: <?php echo $delaySec; ?> * 1000,
        autoClose: <?php echo $autoCloseSec; ?> * 1000
    };

    if (!settings.enabled) return;

    function shouldShow() {
        const lastShown = localStorage.getItem(P_NAME + '_last_shown');
        const now = Date.now();

        if (!lastShown) return true;

        if (settings.frequency === 'every_visit') return true;
        
        if (settings.frequency === 'once_per_session') {
            return !sessionStorage.getItem(P_NAME + '_shown');
        }

        if (settings.frequency === 'once_per_day') {
            const oneDay = 24 * 60 * 60 * 1000;
            return (now - parseInt(lastShown)) > oneDay;
        }

        if (settings.frequency === 'once_ever') {
            return false; // If lastShown exists, we don't show ever again
        }

        return true;
    }

    if (shouldShow()) {
        setTimeout(() => {
            const modalEl = document.getElementById('hpPopupModal');
            const modal = new bootstrap.Modal(modalEl, {
                backdrop: 'static'
            });

            // Adjust backdrop opacity after showing
            modalEl.addEventListener('show.bs.modal', function() {
                setTimeout(() => {
                    const backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) {
                        backdrop.classList.add('hp-popup-backdrop');
                    }
                }, 0);
            });

            modal.show();

            // Track state
            localStorage.setItem(P_NAME + '_last_shown', Date.now());
            sessionStorage.setItem(P_NAME + '_shown', 'true');

            // Auto-close if set
            if (settings.autoClose > 0) {
                setTimeout(() => {
                    modal.hide();
                }, settings.autoClose);
            }
        }, settings.delay);
    }
});
</script>
