<?php
session_start([
    'cookie_lifetime' => 86400,
    'cookie_secure' => isset($_SERVER['HTTPS']),
    'cookie_httponly' => true,
    'cookie_samesite' => 'Lax'
]);

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require_once __DIR__ . '/../includes/content-loader.php';

// Load published gallery data
$galleries_data = load_content('galleries.json');
$galleries = $galleries_data['galleries'] ?? [];

// Show galleries in their configured order, and only those with photos
usort($galleries, function ($a, $b) {
    return ($a['order'] ?? 0) <=> ($b['order'] ?? 0);
});
$galleries = array_filter($galleries, function ($g) {
    return !empty($g['images']);
});
$galleries = array_values($galleries); // re-index so block ids stay sequential
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-8JGNGZY633"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'G-8JGNGZY633');
  </script>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo display_text('site_info', 'title', 'Kaizen Karate'); ?> | Photo Gallery</title>
  <meta name="description" content="Photo gallery from Kaizen Karate — our dojo, events, belt testing, and more.">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Dancing+Script:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/photoswipe@5.4.4/dist/photoswipe.css">
  <link rel="stylesheet" href="styles/style.css?v=<?php echo time(); ?>">
  <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png?v=2">
  <link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-96x96.png?v=2">
  <link rel="icon" type="image/svg+xml" href="favicon/favicon.svg?v=2">
  <link rel="icon" type="image/x-icon" href="favicon/favicon.ico?v=2">
  <link rel="manifest" href="favicon/site.webmanifest?v=2">
  <link rel="stylesheet" type="text/css" href="assets/fonts/MyWebfontsKit/MyWebfontsKit.css">
  <style>
    .gallery-page { padding-top: 130px; padding-bottom: 60px; }
    @media (max-width: 1199px) { .gallery-page { padding-top: 120px; } }
    @media (max-width: 767px)  { .gallery-page { padding-top: 110px; } }
    .gallery-page .page-title { font-family: 'Playfair Display', serif; color: #a4332b; text-align: center; margin-bottom: 0.5rem; }
    .gallery-page .page-subtitle { text-align: center; color: #6c757d; margin-bottom: 3rem; }
    .gallery-block { margin-bottom: 3.5rem; padding-top: 0; background-color: transparent; }
    .gallery-block h2 { font-family: 'Playfair Display', serif; color: #2c3e50; border-bottom: 3px solid #a4332b; padding-bottom: 0.5rem; margin-top: 0; margin-bottom: 0.25rem; }
    .gallery-block .gallery-desc { color: #6c757d; margin-bottom: 1.25rem; }

    /* Album side-navigation layout */
    .gallery-layout { display: flex; gap: 2.5rem; align-items: flex-start; }
    .gallery-nav { flex: 0 0 230px; position: sticky; top: 120px; align-self: flex-start; max-height: calc(100vh - 150px); overflow-y: auto; }
    .gallery-nav .album-list { display: flex; flex-direction: column; gap: 0.15rem; }
    .gallery-nav .album-link { display: flex; justify-content: space-between; align-items: center; gap: 0.5rem; width: 100%; text-align: left; background: transparent; border: none; border-left: 3px solid transparent; padding: 0.6rem 0.85rem; border-radius: 6px; color: #2c3e50; font-weight: 600; cursor: pointer; transition: background 0.2s ease, color 0.2s ease; }
    .gallery-nav .album-link:hover { background: #f5ebea; color: #a4332b; }
    .gallery-nav .album-link.active { background: #a4332b; color: #fff; border-left-color: #721c24; }
    .gallery-nav .album-link .count { background: rgba(0,0,0,0.08); border-radius: 10px; padding: 0.05rem 0.55rem; font-size: 0.78rem; flex: 0 0 auto; }
    .gallery-nav .album-link.active .count { background: rgba(255,255,255,0.25); }
    .gallery-main { flex: 1 1 auto; min-width: 0; }
    .gallery-block { display: none; }
    .gallery-block.active { display: block; }

    @media (max-width: 991px) {
        .gallery-layout { flex-direction: column; gap: 1.25rem; }
        .gallery-nav { position: static; flex-basis: auto; width: 100%; max-height: none; overflow-x: auto; overflow-y: visible; -webkit-overflow-scrolling: touch; }
        .gallery-nav h3 { display: none; }
        .gallery-nav .album-list { flex-direction: row; flex-wrap: nowrap; gap: 0.5rem; padding-bottom: 0.35rem; padding-right: 1.5rem; }
        .gallery-nav .album-link { width: auto; white-space: nowrap; border-left: none; border: 1px solid #e3e3e3; }
        .gallery-nav .album-link.active { border-color: #a4332b; }

        /* Fade-right scroll hint */
        .gallery-nav-scroll-wrap { position: relative; width: 100%; overflow: hidden; }
        .gallery-nav-scroll-wrap::after {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 48px; height: 100%;
            background: linear-gradient(to right, transparent, #fff 85%);
            pointer-events: none;
            transition: opacity 0.25s;
        }
        .gallery-nav-scroll-wrap.at-end::after { opacity: 0; }
    }
    .photo-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 12px; }
    .photo-grid a { display: block; overflow: hidden; border-radius: 8px; position: relative; aspect-ratio: 4 / 3; }
    .photo-grid img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.35s ease; display: block; }
    .photo-grid a:hover img { transform: scale(1.06); }
    .photo-grid a::after { content: "\f00e"; font-family: "Font Awesome 6 Free"; font-weight: 900; position: absolute; top: 8px; right: 10px; color: #fff; opacity: 0; transition: opacity 0.3s ease; text-shadow: 0 1px 4px rgba(0,0,0,0.6); }
    .photo-grid a:hover::after { opacity: 0.9; }
    .pswp__custom-caption { position: absolute; bottom: 0; left: 0; right: 0; padding: 16px 20px; background: rgba(0,0,0,0.55); color: #fff; text-align: center; font-size: 1rem; }
    .empty-note { text-align: center; color: #6c757d; padding: 3rem 0; }
  </style>
</head>
<body class="gallery-page-body">
<?php include __DIR__ . '/../includes/nav.php'; ?>

<div class="container gallery-page">
    <h1 class="page-title">Photo Gallery</h1>
    <p class="page-subtitle">Moments from the Kaizen Karate community</p>

    <?php if (empty($galleries)): ?>
        <div class="empty-note"><i class="fas fa-camera fa-2x mb-3 d-block"></i>Photos are coming soon. Check back shortly!</div>
    <?php else: ?>
        <div class="gallery-layout">
            <div class="gallery-nav-scroll-wrap">
            <aside class="gallery-nav">
                <div class="album-list">
                    <?php foreach ($galleries as $gi => $g): ?>
                        <button type="button" class="album-link" data-target="album-<?php echo $gi; ?>">
                            <span><?php echo htmlspecialchars($g['title']); ?></span>
                            <span class="count"><?php echo count($g['images']); ?></span>
                        </button>
                    <?php endforeach; ?>
                </div>
            </aside>
            </div>

            <div class="gallery-main">
                <?php foreach ($galleries as $gi => $g): ?>
                    <section class="gallery-block" id="album-<?php echo $gi; ?>">
                        <h2><?php echo htmlspecialchars($g['title']); ?></h2>
                        <?php if (!empty($g['description'])): ?>
                            <p class="gallery-desc"><?php echo htmlspecialchars($g['description']); ?></p>
                        <?php endif; ?>

                        <div class="photo-grid pswp-gallery" id="pswp-gallery-<?php echo $gi; ?>">
                            <?php foreach ($g['images'] as $img): ?>
                                <a href="<?php echo htmlspecialchars($img['full']); ?>"
                                   data-pswp-width="<?php echo (int) ($img['width'] ?? 1600); ?>"
                                   data-pswp-height="<?php echo (int) ($img['height'] ?? 1067); ?>"
                                   data-caption="<?php echo htmlspecialchars($img['caption'] ?? ''); ?>"
                                   target="_blank">
                                    <img src="<?php echo htmlspecialchars($img['thumb'] ?? $img['full']); ?>"
                                         alt="<?php echo htmlspecialchars($img['alt'] ?? $img['caption'] ?? ''); ?>"
                                         loading="lazy">
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/footer-dynamic.php'; ?>

<script>
    // Album side-navigation: show one album at a time
    (function () {
        var links = Array.prototype.slice.call(document.querySelectorAll('.gallery-nav .album-link'));
        var blocks = Array.prototype.slice.call(document.querySelectorAll('.gallery-main .gallery-block'));
        if (!links.length || !blocks.length) return;

        function activate(id, doScroll) {
            blocks.forEach(function (b) { b.classList.toggle('active', b.id === id); });
            links.forEach(function (l) { l.classList.toggle('active', l.dataset.target === id); });
            if (doScroll) {
                var layout = document.querySelector('.gallery-layout');
                var top = layout.getBoundingClientRect().top + window.pageYOffset - 100;
                window.scrollTo({ top: top, behavior: 'smooth' });
            }
        }

        links.forEach(function (l) {
            l.addEventListener('click', function () {
                var id = this.dataset.target;
                activate(id, true);
                if (history.replaceState) history.replaceState(null, '', '#' + id);
            });
        });

        // Open the album named in the URL hash, else the first one
        var hashId = location.hash ? location.hash.slice(1) : '';
        var initial = (hashId && document.getElementById(hashId)) ? hashId : blocks[0].id;
        activate(initial, false);

        // Scroll-fade indicator: hide the right gradient once scrolled to the end
        var nav = document.querySelector('.gallery-nav');
        var wrap = document.querySelector('.gallery-nav-scroll-wrap');
        if (nav && wrap) {
            function checkScroll() {
                wrap.classList.toggle('at-end', nav.scrollLeft + nav.clientWidth >= nav.scrollWidth - 4);
            }
            nav.addEventListener('scroll', checkScroll, { passive: true });
            checkScroll();
        }
    })();
</script>

<script type="module">
    import PhotoSwipeLightbox from 'https://cdn.jsdelivr.net/npm/photoswipe@5.4.4/dist/photoswipe-lightbox.esm.min.js';

    document.querySelectorAll('.pswp-gallery').forEach(function (galleryEl) {
        const lightbox = new PhotoSwipeLightbox({
            gallery: '#' + galleryEl.id,
            children: 'a',
            pswpModule: () => import('https://cdn.jsdelivr.net/npm/photoswipe@5.4.4/dist/photoswipe.esm.min.js')
        });

        lightbox.on('uiRegister', function () {
            // Caption shown at the bottom of the viewer
            lightbox.pswp.ui.registerElement({
                name: 'custom-caption',
                order: 9,
                isButton: false,
                appendTo: 'root',
                onInit: (el, pswp) => {
                    el.className = 'pswp__custom-caption';
                    const update = () => {
                        const slideEl = pswp.currSlide && pswp.currSlide.data.element;
                        const caption = slideEl ? slideEl.getAttribute('data-caption') : '';
                        el.innerHTML = caption || '';
                        el.style.display = caption ? 'block' : 'none';
                    };
                    pswp.on('change', update);
                    update();
                }
            });

            // Play/pause slideshow button
            let timer = null;
            const stopAutoplay = () => {
                if (timer) { clearInterval(timer); timer = null; }
            };
            lightbox.pswp.ui.registerElement({
                name: 'autoplay',
                order: 8,
                isButton: true,
                html: '<i class="fas fa-play" aria-hidden="true"></i>',
                onInit: (el, pswp) => {
                    pswp.on('close', stopAutoplay);
                    pswp.on('destroy', stopAutoplay);
                },
                onClick: (e, el, pswp) => {
                    if (timer) {
                        stopAutoplay();
                        el.innerHTML = '<i class="fas fa-play" aria-hidden="true"></i>';
                    } else {
                        timer = setInterval(() => pswp.next(), 3500);
                        el.innerHTML = '<i class="fas fa-pause" aria-hidden="true"></i>';
                    }
                }
            });
        });

        lightbox.init();
    });
</script>
</body>
</html>
