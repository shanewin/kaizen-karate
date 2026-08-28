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

require_once 'includes/content-loader.php';
if (!defined('BELT_EXAM_STANDALONE')) {
    define('BELT_EXAM_STANDALONE', true);
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
  <title><?php echo display_text('site_info', 'title', 'Kaizen Karate | Traditional Martial Arts Training'); ?> | Belt Exams</title>
  <meta name="description" content="Review Kaizen Karate belt exam requirements, testing dates, scripts, and registration links.">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Dancing+Script:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="styles/style.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="styles/test-schedule.css?v=<?php echo time(); ?>">
  <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png?v=2">
  <link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-96x96.png?v=2">
  <link rel="icon" type="image/svg+xml" href="favicon/favicon.svg?v=2">
  <link rel="icon" type="image/x-icon" href="favicon/favicon.ico?v=2">
  <link rel="manifest" href="favicon/site.webmanifest?v=2">
  <link rel="stylesheet" type="text/css" href="assets/fonts/MyWebfontsKit/MyWebfontsKit.css">
</head>
<body>
<?php include 'includes/nav.php'; ?>

<?php include 'sections/belt-exam-section.php'; ?>

<?php
require_once 'includes/footer-dynamic.php';
render_footer('live');
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="scripts/nav.js"></script>
<script>
function scrollToBeltExamRegister(event) {
  const beltExamSection = document.getElementById('belt-exam');
  if (!beltExamSection) {
    return true;
  }

  if (event && typeof event.preventDefault === 'function') {
    event.preventDefault();
  }

  beltExamSection.scrollIntoView({ 
    behavior: 'smooth',
    block: 'start'
  });
  
  setTimeout(function() {
    const registerContent = document.getElementById('register-content');
    const registerIcon = document.getElementById('register-icon');
    
    if (typeof toggleAccordion === 'function') {
      if (registerContent && (registerContent.style.display === 'none' || registerContent.style.display === '')) {
        toggleAccordion('register');
      }
    }
    
    const targetElement = document.getElementById('register-btn') || registerContent;
    if (targetElement) {
      setTimeout(function() {
        targetElement.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }, 200);
    }
  }, 600);

  return false;
}
</script>
</body>
</html>
