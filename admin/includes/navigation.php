<?php
// Admin navigation template
$current_page = basename($_SERVER['PHP_SELF']);
?>
<div class="brand-header">
    <i class="fas fa-fist-raised mb-2" style="font-size: 2rem;"></i>
    <h4 class="mb-0">Kaizen Karate</h4>
    <small>Admin Panel</small>
</div>

<nav class="nav flex-column">
    <a class="nav-link <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>" href="dashboard.php">
        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
    </a>
    <a class="nav-link <?php echo ($current_page == 'navigation.php') ? 'active' : ''; ?>" href="navigation.php">
        <i class="fas fa-bars me-2"></i>Navigation
    </a>
    <a class="nav-link <?php echo ($current_page == 'header.php') ? 'active' : ''; ?>" href="header.php">
        <i class="fas fa-video me-2"></i>Header
    </a>
    <a class="nav-link <?php echo ($current_page == 'programs.php') ? 'active' : ''; ?>" href="programs.php">
        <i class="fas fa-th-large me-2"></i>Programs
    </a>
    <a class="nav-link <?php echo ($current_page == 'service-areas.php') ? 'active' : ''; ?>" href="service-areas.php">
        <i class="fas fa-map-marker-alt me-2"></i>Service Areas
    </a>
    <a class="nav-link <?php echo ($current_page == 'about.php') ? 'active' : ''; ?>" href="about.php">
        <i class="fas fa-users me-2"></i>About
    </a>
    <a class="nav-link <?php echo ($current_page == 'summer-camp.php') ? 'active' : ''; ?>" href="summer-camp.php">
        <i class="fas fa-sun me-2"></i>Summer Camp
    </a>
    <a class="nav-link <?php echo ($current_page == 'kaizen-dojo.php') ? 'active' : ''; ?>" href="kaizen-dojo.php">
        <i class="fas fa-home me-2"></i>Kaizen Dojo
    </a>
    <a class="nav-link <?php echo ($current_page == 'weekend-evening.php') ? 'active' : ''; ?>" href="weekend-evening.php">
        <i class="fas fa-calendar-alt me-2"></i>Weekend & Evening Classes
    </a>
    <a class="nav-link <?php echo ($current_page == 'online-store.php') ? 'active' : ''; ?>" href="online-store.php">
        <i class="fas fa-shopping-cart me-2"></i>Kaizen Karate Online Store
    </a>
    <a class="nav-link <?php echo ($current_page == 'belt-exams.php') ? 'active' : ''; ?>" href="belt-exams.php">
        <i class="fas fa-award me-2"></i>Belt Exams
    </a>
    <a class="nav-link <?php echo ($current_page == 'kaizen-kenpo.php') ? 'active' : ''; ?>" href="kaizen-kenpo.php">
        <i class="fas fa-fist-raised me-2"></i>Kaizen Kenpo
    </a>
    <a class="nav-link <?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>" href="contact.php">
        <i class="fas fa-envelope me-2"></i>Contact Kaizen Karate
    </a>
    <a class="nav-link <?php echo ($current_page == 'footer.php') ? 'active' : ''; ?>" href="footer.php">
        <i class="fas fa-copyright me-2"></i>Footer
    </a>
    <hr class="my-3" style="border-color: #34495e;">
    <a class="nav-link <?php echo ($current_page == 'submissions.php') ? 'active' : ''; ?>" href="submissions.php">
        <i class="fas fa-inbox me-2"></i>Submissions
    </a>
    <a class="nav-link" href="../index.php" target="_blank">
        <i class="fas fa-external-link-alt me-2"></i>View Site
    </a>
    <a class="nav-link" href="logout.php">
        <i class="fas fa-sign-out-alt me-2"></i>Logout
    </a>
</nav>