<?php
// This page has been replaced by about.php
header('Location: about.php');
exit();

$message = '';

// Handle form submissions
if ($_POST) {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $message = error_message('Security token invalid. Please try again.');
    } else {
        $instructors = load_json_data('instructors.json');
        
        if ($_POST['action'] === 'update_main') {
            // Update main instructor
            $instructors['main_instructor']['name'] = sanitize_input($_POST['main_name']);
            $instructors['main_instructor']['title'] = sanitize_input($_POST['main_title']);
            $instructors['main_instructor']['image'] = sanitize_input($_POST['main_image']);
            
            // Handle bio paragraphs
            $bio_paragraphs = explode("\n\n", $_POST['main_bio']);
            $instructors['main_instructor']['bio'] = array_map('trim', array_filter($bio_paragraphs));
            
            if (save_json_data('instructors.json', $instructors)) {
                $message = success_message('Main instructor updated successfully!');
            } else {
                $message = error_message('Failed to save changes.');
            }
        } elseif ($_POST['action'] === 'update_other') {
            // Update other instructor
            $instructor_id = (int)$_POST['instructor_id'];
            
            foreach ($instructors['other_instructors'] as &$instructor) {
                if ($instructor['id'] === $instructor_id) {
                    $instructor['name'] = sanitize_input($_POST['name']);
                    $instructor['title'] = sanitize_input($_POST['title']);
                    $instructor['qualifications'] = sanitize_input($_POST['qualifications']);
                    
                    // Handle bio paragraphs
                    $bio_paragraphs = explode("\n\n", $_POST['bio']);
                    $instructor['bio'] = array_map('trim', array_filter($bio_paragraphs));
                    break;
                }
            }
            
            if (save_json_data('instructors.json', $instructors)) {
                $message = success_message('Instructor updated successfully!');
            } else {
                $message = error_message('Failed to save changes.');
            }
        }
    }
}

// Load current data
$instructors = load_json_data('instructors.json');
if (empty($instructors)) {
    // Initialize default structure if file doesn't exist
    $instructors = [
        'main_instructor' => [
            'name' => 'Coach V',
            'title' => 'Head Instructor & Founder',
            'image' => 'assets/images/about/coach-v-about.png',
            'bio' => ['Add main instructor bio here...']
        ],
        'other_instructors' => []
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Instructors - Kaizen Karate Admin</title>
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
        }
        
        .sidebar {
            background: var(--sidebar-bg);
            min-height: 100vh;
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
            text-align: center;
        }
        
        .instructor-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            overflow: hidden;
        }
        
        .card-header-custom {
            background: linear-gradient(45deg, var(--kaizen-primary), var(--kaizen-secondary));
            color: white;
            padding: 1.5rem;
        }
        
        .btn-kaizen {
            background: linear-gradient(45deg, var(--kaizen-primary), var(--kaizen-secondary));
            border: none;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 600;
        }
        
        .btn-kaizen:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(164, 51, 43, 0.3);
        }
        
        .form-control:focus {
            border-color: var(--kaizen-primary);
            box-shadow: 0 0 0 0.2rem rgba(164, 51, 43, 0.25);
        }
        
        .bio-textarea {
            min-height: 150px;
        }
    </style>
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
                        <i class="fas fa-users me-2 text-primary"></i>
                        Manage Instructors
                    </h1>
                </div>
                
                <?php echo $message; ?>
                
                <!-- Main Instructor -->
                <div class="instructor-card">
                    <div class="card-header-custom">
                        <h3 class="mb-0">
                            <i class="fas fa-star me-2"></i>
                            Main Instructor
                        </h3>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST">
                            <input type="hidden" name="action" value="update_main">
                            <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="main_name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="main_name" name="main_name" 
                                               value="<?php echo htmlspecialchars($instructors['main_instructor']['name']); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="main_title" class="form-label">Title</label>
                                        <input type="text" class="form-control" id="main_title" name="main_title" 
                                               value="<?php echo htmlspecialchars($instructors['main_instructor']['title']); ?>" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="main_image" class="form-label">Image Path</label>
                                <input type="text" class="form-control" id="main_image" name="main_image" 
                                       value="<?php echo htmlspecialchars($instructors['main_instructor']['image']); ?>" required>
                                <div class="form-text">Relative path to instructor image (e.g., assets/images/about/coach-v-about.png)</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="main_bio" class="form-label">Biography</label>
                                <textarea class="form-control bio-textarea" id="main_bio" name="main_bio" required><?php echo htmlspecialchars(implode("\n\n", $instructors['main_instructor']['bio'])); ?></textarea>
                                <div class="form-text">Separate paragraphs with double line breaks (Enter twice)</div>
                            </div>
                            
                            <button type="submit" class="btn btn-kaizen">
                                <i class="fas fa-save me-2"></i>Update Main Instructor
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Other Instructors -->
                <div class="instructor-card">
                    <div class="card-header-custom">
                        <h3 class="mb-0">
                            <i class="fas fa-users me-2"></i>
                            Other Instructors
                        </h3>
                    </div>
                    <div class="card-body p-4">
                        <?php if (!empty($instructors['other_instructors'])): ?>
                            <?php foreach ($instructors['other_instructors'] as $instructor): ?>
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0"><?php echo htmlspecialchars($instructor['name']); ?></h5>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST">
                                            <input type="hidden" name="action" value="update_other">
                                            <input type="hidden" name="instructor_id" value="<?php echo $instructor['id']; ?>">
                                            <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Name</label>
                                                        <input type="text" class="form-control" name="name" 
                                                               value="<?php echo htmlspecialchars($instructor['name']); ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Title</label>
                                                        <input type="text" class="form-control" name="title" 
                                                               value="<?php echo htmlspecialchars($instructor['title']); ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Qualifications</label>
                                                <textarea class="form-control" name="qualifications" rows="2" required><?php echo htmlspecialchars($instructor['qualifications']); ?></textarea>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Biography</label>
                                                <textarea class="form-control bio-textarea" name="bio" required><?php echo htmlspecialchars(implode("\n\n", $instructor['bio'])); ?></textarea>
                                                <div class="form-text">Separate paragraphs with double line breaks</div>
                                            </div>
                                            
                                            <button type="submit" class="btn btn-kaizen">
                                                <i class="fas fa-save me-2"></i>Update Instructor
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-info-circle mb-2" style="font-size: 2rem;"></i>
                                <p>No other instructors found. The system will load them from the main site.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Instructions -->
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            Instructions
                        </h5>
                    </div>
                    <div class="card-body">
                        <ul>
                            <li><strong>Biography formatting:</strong> Use double line breaks (press Enter twice) to separate paragraphs</li>
                            <li><strong>Image paths:</strong> Use relative paths from your website root (e.g., assets/images/about/instructor.jpg)</li>
                            <li><strong>Changes are immediate:</strong> Updates will be reflected on your website instantly</li>
                            <li><strong>Backup:</strong> Your original content is preserved in case you need to restore it</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>