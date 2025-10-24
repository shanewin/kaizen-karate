<?php
define('KAIZEN_ADMIN', true);
session_start();
require_once 'config.php';

// Require login
require_login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kaizen Karate Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --kaizen-primary: #a4332b;
            --kaizen-secondary: #721c24;
            --sidebar-bg: #2c3e50;
            --sidebar-hover: #34495e;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .sidebar {
            background: var(--sidebar-bg);
            min-height: 100vh;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        
        .sidebar .nav-link {
            color: #ecf0f1;
            padding: 1rem 1.5rem;
            margin: 0.25rem 0;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .sidebar .nav-link:hover {
            background: var(--sidebar-hover);
            color: white;
            transform: translateX(5px);
        }
        
        .sidebar .nav-link.active {
            background: var(--kaizen-primary);
            color: white;
        }
        
        .main-content {
            padding: 2rem;
        }
        
        .stats-card {
            background: linear-gradient(135deg, var(--kaizen-primary), var(--kaizen-secondary));
            color: white;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 8px 25px rgba(164, 51, 43, 0.2);
            transition: transform 0.3s ease;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
        }
        
        .stats-number {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        
        .quick-action-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }
        
        .quick-action-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .action-icon {
            font-size: 3rem;
            color: var(--kaizen-primary);
            margin-bottom: 1rem;
        }
        
        .btn-kaizen {
            background: linear-gradient(45deg, var(--kaizen-primary), var(--kaizen-secondary));
            border: none;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-kaizen:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(164, 51, 43, 0.3);
            color: white;
        }
        
        .brand-header {
            background: linear-gradient(45deg, var(--kaizen-primary), var(--kaizen-secondary));
            color: white;
            padding: 1.5rem;
            border-radius: 0 0 15px 15px;
            margin-bottom: 2rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <div class="brand-header">
                    <i class="fas fa-fist-raised mb-2" style="font-size: 2rem;"></i>
                    <h4 class="mb-0">Kaizen Karate</h4>
                    <small>Admin Panel</small>
                </div>
                
                <nav class="nav flex-column">
                    <a class="nav-link active" href="dashboard.php">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                    <a class="nav-link" href="navigation.php">
                        <i class="fas fa-bars me-2"></i>Navigation
                    </a>
                    <a class="nav-link" href="header.php">
                        <i class="fas fa-video me-2"></i>Header
                    </a>
                    <a class="nav-link" href="programs.php">
                        <i class="fas fa-th-large me-2"></i>Programs
                    </a>
                    <a class="nav-link" href="service-areas.php">
                        <i class="fas fa-map-marker-alt me-2"></i>Service Areas
                    </a>
                    <a class="nav-link" href="about.php">
                        <i class="fas fa-users me-2"></i>About
                    </a>
                    <a class="nav-link" href="summer-camp.php">
                        <i class="fas fa-sun me-2"></i>Summer Camp
                    </a>
                    <a class="nav-link" href="kaizen-dojo.php">
                        <i class="fas fa-home me-2"></i>Kaizen Dojo
                    </a>
                    <a class="nav-link" href="weekend-evening.php">
                        <i class="fas fa-calendar-alt me-2"></i>Weekend & Evening Classes
                    </a>
                    <a class="nav-link" href="online-store.php">
                        <i class="fas fa-shopping-cart me-2"></i>Kaizen Karate Online Store
                    </a>
                    <a class="nav-link" href="belt-exams.php">
                        <i class="fas fa-award me-2"></i>Belt Exams
                    </a>
                    <a class="nav-link" href="kaizen-kenpo.php">
                        <i class="fas fa-fist-raised me-2"></i>Kaizen Kenpo
                    </a>
                    <a class="nav-link" href="contact.php">
                        <i class="fas fa-envelope me-2"></i>Contact Kaizen Karate
                    </a>
                    <a class="nav-link" href="footer.php">
                        <i class="fas fa-copyright me-2"></i>Footer
                    </a>
                    <hr class="my-3" style="border-color: #34495e;">
                    <a class="nav-link" href="submissions.php">
                        <i class="fas fa-inbox me-2"></i>Submissions
                    </a>
                    <a class="nav-link" href="../index.php" target="_blank">
                        <i class="fas fa-external-link-alt me-2"></i>View Site
                    </a>
                    <a class="nav-link" href="logout.php">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                </nav>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>
                        <i class="fas fa-tachometer-alt me-2 text-primary"></i>
                        Dashboard
                    </h1>
                    <div class="text-muted">
                        <i class="fas fa-user me-1"></i>
                        Welcome, Admin
                    </div>
                </div>
                
                <!-- Welcome Section -->
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center py-5">
                                <i class="fas fa-fist-raised text-primary mb-4" style="font-size: 4rem;"></i>
                                <h2 class="mb-3">Welcome to Kaizen Karate Admin Panel</h2>
                                <p class="lead text-muted mb-4">
                                    Manage your martial arts website content with ease. Use the navigation menu on the left 
                                    to edit different sections of your website.
                                </p>
                                <div class="row text-center">
                                    <div class="col-md-4">
                                        <i class="fas fa-edit text-primary mb-2" style="font-size: 2rem;"></i>
                                        <h5>Edit Content</h5>
                                        <p class="text-muted">Update text, images, and videos across all sections</p>
                                    </div>
                                    <div class="col-md-4">
                                        <i class="fas fa-users text-primary mb-2" style="font-size: 2rem;"></i>
                                        <h5>Manage Programs</h5>
                                        <p class="text-muted">Update class schedules, instructor info, and program details</p>
                                    </div>
                                    <div class="col-md-4">
                                        <i class="fas fa-eye text-primary mb-2" style="font-size: 2rem;"></i>
                                        <h5>Live Updates</h5>
                                        <p class="text-muted">Changes appear immediately on your live website</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Start Guide -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">
                                    <i class="fas fa-rocket me-2 text-primary"></i>
                                    Quick Start Guide
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6><i class="fas fa-bars text-primary me-2"></i>Navigation & Header</h6>
                                        <ul class="list-unstyled mb-4">
                                            <li class="mb-2">• Update website logo and navigation menu</li>
                                            <li class="mb-2">• Edit hero video and main title</li>
                                            <li class="mb-2">• Manage registration dropdown options</li>
                                        </ul>
                                        
                                        <h6><i class="fas fa-th-large text-primary me-2"></i>Content Sections</h6>
                                        <ul class="list-unstyled mb-4">
                                            <li class="mb-2">• Programs: After School, Summer Camp, Kaizen Dojo</li>
                                            <li class="mb-2">• Service Areas: Update locations served</li>
                                            <li class="mb-2">• Instructors: Add/edit instructor profiles</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <h6><i class="fas fa-cog text-primary me-2"></i>Specialized Sections</h6>
                                        <ul class="list-unstyled mb-4">
                                            <li class="mb-2">• Belt Exams: Manage exam schedules and registration</li>
                                            <li class="mb-2">• Kaizen Kenpo: Update martial arts philosophy content</li>
                                            <li class="mb-2">• Contact & Footer: Update contact information</li>
                                        </ul>
                                        
                                        <h6><i class="fas fa-inbox text-primary me-2"></i>Form Submissions</h6>
                                        <ul class="list-unstyled mb-4">
                                            <li class="mb-2">• View waitlist and email signups</li>
                                            <li class="mb-2">• Monitor student registration activity</li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <div class="text-center mt-4">
                                    <a href="../index.php" target="_blank" class="btn btn-kaizen me-3">
                                        <i class="fas fa-external-link-alt me-2"></i>View Live Website
                                    </a>
                                    <a href="navigation.php" class="btn btn-outline-primary">
                                        <i class="fas fa-play me-2"></i>Start Editing
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>