<?php
/**
 * Shared template for standalone belt exam script pages.
 * Require this file from a per-page wrapper after defining $script_slug.
 */

if (empty($script_slug)) {
    http_response_code(404);
    echo 'Script not specified.';
    exit;
}

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

$belt_exam_data = get_content('belt_exams') ?: [];
$scriptsAccordion = null;

foreach ($belt_exam_data['accordions'] ?? [] as $accordion) {
    if (($accordion['id'] ?? '') === 'scripts') {
        $scriptsAccordion = $accordion;
        break;
    }
}

$script_cards = $scriptsAccordion['script_cards'] ?? [];
$lightbox_content = $scriptsAccordion['lightbox_content'][$script_slug] ?? '';

$active_card = null;
foreach ($script_cards as $card) {
    if (($card['id'] ?? '') === $script_slug) {
        $active_card = $card;
        break;
    }
}

$page_title = $active_card['title'] ?? 'Belt Exam Resource';
$page_description = $active_card['description'] ?? 'Detailed belt exam instructions and talking points.';
$page_color = $active_card['belt_color'] ?? '#dc3545';
$has_stripe = !empty($active_card['has_stripe']);

if (empty($lightbox_content)) {
    $lightbox_content = '<p style="margin:0;">This resource is not available yet. Please check back soon.</p>';
}
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
  <title><?php echo htmlspecialchars($page_title); ?> | Kaizen Karate</title>
  <meta name="description" content="<?php echo htmlspecialchars($page_description); ?>">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Dancing+Script:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="styles/style.css?v=<?php echo time(); ?>">
  <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png?v=2">
  <link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-96x96.png?v=2">
  <link rel="icon" type="image/svg+xml" href="favicon/favicon.svg?v=2">
  <link rel="icon" type="image/x-icon" href="favicon/favicon.ico?v=2">
  <link rel="manifest" href="favicon/site.webmanifest?v=2">
  <link rel="stylesheet" type="text/css" href="assets/fonts/MyWebfontsKit/MyWebfontsKit.css">
  <style>
    .script-hero {
      background: linear-gradient(135deg, rgba(0,0,0,0.85), rgba(0,0,0,0.9));
      color: #fff;
      padding: 120px 0 80px 0;
      margin-top: 100px;
    }
    .script-content-card {
      background: rgba(255,255,255,0.97);
      border-radius: 18px;
      box-shadow: 0 25px 60px rgba(0,0,0,0.15);
      padding: 40px;
      margin-top: -80px;
      position: relative;
      z-index: 2;
    }
    .script-content-card h3,
    .script-content-card h4,
    .script-content-card h5,
    .script-content-card h6 {
      color: #dc3545;
    }
    .script-meta-pill {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      padding: 10px 18px;
      border-radius: 999px;
      font-weight: 600;
      color: #fff;
    }
  </style>
</head>
<body>

<?php include __DIR__ . '/../includes/nav.php'; ?>

<header class="script-hero">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-8">
        <p class="script-meta-pill" style="background: <?php echo htmlspecialchars($page_color); ?>;">
          <i class="fas fa-scroll"></i>
          <?php echo htmlspecialchars($page_title); ?>
          <?php if ($has_stripe): ?>
            <span style="width: 20px; height: 2px; background: #fff; display: inline-block;"></span>
          <?php endif; ?>
        </p>
        <h1 style="font-family: 'Playfair Display', serif; font-size: 3rem; font-weight: 700; margin-top: 1rem;">
          <?php echo htmlspecialchars($page_title); ?>
        </h1>
        <p style="font-size: 1.1rem; opacity: 0.9;">
          <?php echo htmlspecialchars($page_description); ?>
        </p>
      </div>
      <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
        <a href="belt-exam.php" class="btn btn-outline-light btn-lg">← Back to Belt Exam</a>
      </div>
    </div>
  </div>
</header>

<main class="py-5">
  <div class="container">
    <div class="script-content-card">
      <div class="script-body">
        <?php echo $lightbox_content; ?>
      </div>
    </div>
  </div>
</main>

<?php
require_once __DIR__ . '/../includes/footer-dynamic.php';
render_footer('live');
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="scripts/nav.js"></script>
</body>
</html>
