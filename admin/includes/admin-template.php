<?php
// Admin page template
if (!defined('KAIZEN_ADMIN')) {
    die('Access denied');
}

$page_title = $page_title ?? 'Admin Panel';
$page_icon = $page_icon ?? 'fas fa-cog';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?> - Kaizen Karate Admin</title>
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
        
        .brand-header {
            background: linear-gradient(45deg, var(--kaizen-primary), var(--kaizen-secondary));
            color: white;
            padding: 1.5rem;
            border-radius: 0 0 15px 15px;
            margin-bottom: 2rem;
            text-align: center;
        }
        
        .content-section {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            border: 1px solid #e9ecef;
        }
        
        .section-title {
            color: var(--kaizen-primary);
            margin-bottom: 1.5rem;
            font-weight: 600;
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
        
        .form-control:focus {
            border-color: var(--kaizen-primary);
            box-shadow: 0 0 0 0.2rem rgba(164, 51, 43, 0.25);
        }
    </style>
    <?php if (isset($additional_styles)): ?>
    <style><?php echo $additional_styles; ?></style>
    <?php endif; ?>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <?php include 'includes/navigation.php'; ?>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>
                        <i class="<?php echo $page_icon; ?> me-2 text-primary"></i>
                        <?php echo htmlspecialchars($page_title); ?>
                    </h1>
                </div>
                
                <?php if (!empty($message)) echo $message; ?>
                
                <!-- Page Content -->
                <div id="page-content">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php if (isset($additional_scripts)): ?>
    <script><?php echo $additional_scripts; ?></script>
    <?php endif; ?>
</body>
</html>