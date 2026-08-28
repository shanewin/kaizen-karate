<?php
// Admin navigation template
$current_page = basename($_SERVER['PHP_SELF']);
$footerGroupPages = ['footer.php', 'policies.php', 'faq.php', 'student-handbook.php'];
$footerGroupActive = in_array($current_page, $footerGroupPages, true);
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
    <a class="nav-link <?php echo ($current_page == 'homepage-popup.php') ? 'active' : ''; ?>" href="homepage-popup.php">
        <i class="fas fa-window-restore me-2"></i>Homepage Pop-Up
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
    <a class="nav-link <?php echo ($current_page == 'nyc.php') ? 'active' : ''; ?>" href="nyc.php">
        <i class="fas fa-city me-2"></i>NYC Section
    </a>
    <a class="nav-link <?php echo ($current_page == 'kaizen-dojo.php') ? 'active' : ''; ?>" href="kaizen-dojo.php">
        <i class="fas fa-home me-2"></i>Kaizen Dojo
    </a>
    <a class="nav-link <?php echo ($current_page == 'weekend-evening.php') ? 'active' : ''; ?>" href="weekend-evening.php">
        <i class="fas fa-calendar-alt me-2"></i>Weekend & Evening Classes
    </a>
    <a class="nav-link <?php echo ($current_page == 'online-store.php') ? 'active' : ''; ?>" href="online-store.php">
        <i class="fas fa-shopping-cart me-2"></i>Online Store
    </a>
    <a class="nav-link <?php echo ($current_page == 'belt-exams.php') ? 'active' : ''; ?>" href="belt-exams.php">
        <i class="fas fa-award me-2"></i>Belt Exams
    </a>
    <a class="nav-link <?php echo ($current_page == 'kaizen-kenpo.php') ? 'active' : ''; ?>" href="kaizen-kenpo.php">
        <i class="fas fa-fist-raised me-2"></i>Kaizen Kenpo
    </a>
    <a class="nav-link <?php echo ($current_page == 'submissions.php') ? 'active' : ''; ?>" href="submissions.php">
        <i class="fas fa-envelope me-2"></i>Contact Kaizen Karate
    </a>



    <div class="mt-2">
        <a class="nav-link <?php echo $footerGroupActive ? 'active' : ''; ?>" href="footer.php">
            <i class="fas fa-shoe-prints me-2"></i>Footer
        </a>
        <div class="nav flex-column ms-4 ps-2 border-start border-secondary border-opacity-25 small">
            <a class="nav-link <?php echo ($current_page == 'policies.php') ? 'active' : ''; ?>" href="policies.php" style="padding-left: 0.75rem;">
                <i class="fas fa-file-contract me-2"></i>Policies
            </a>
            <a class="nav-link <?php echo ($current_page == 'faq.php') ? 'active' : ''; ?>" href="faq.php" style="padding-left: 0.75rem;">
                <i class="fas fa-question-circle me-2"></i>FAQ
            </a>
            <a class="nav-link <?php echo ($current_page == 'student-handbook.php') ? 'active' : ''; ?>" href="student-handbook.php" style="padding-left: 0.75rem;">
                <i class="fas fa-book me-2"></i>Student Handbook
            </a>
        </div>
    </div>

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
