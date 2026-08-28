<?php
define('KAIZEN_ADMIN', true);
session_start();
require_once 'config.php';

// Require login
require_login();

// File paths
$contact_file = DATA_ROOT . '/contact_submissions.txt';
$subscribers_file = DATA_ROOT . '/subscribers.txt';

// Handle delete action
if (isset($_GET['delete_contact']) && is_numeric($_GET['delete_contact'])) {
    $delete_index = (int)$_GET['delete_contact'];
    
    if (file_exists($contact_file)) {
        $lines = file($contact_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        // Reverse the array to match the display order (newest first)
        $lines = array_reverse($lines);
        
        // Remove the specified line
        if (isset($lines[$delete_index])) {
            unset($lines[$delete_index]);
            
            // Reverse back to original order and save
            $lines = array_reverse($lines);
            file_put_contents($contact_file, implode(PHP_EOL, $lines) . PHP_EOL);
            
            // Redirect to avoid resubmission on refresh
            header('Location: ' . str_replace('&delete_contact=' . $delete_index, '', $_SERVER['REQUEST_URI']));
            exit;
        }
    }
}

// Handle delete subscriber action
if (isset($_GET['delete_subscriber']) && is_numeric($_GET['delete_subscriber'])) {
    $delete_index = (int)$_GET['delete_subscriber'];
    
    if (file_exists($subscribers_file)) {
        $lines = file($subscribers_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        // Reverse the array to match the display order (newest first)
        $lines = array_reverse($lines);
        
        // Remove the specified line
        if (isset($lines[$delete_index])) {
            unset($lines[$delete_index]);
            
            // Reverse back to original order and save
            $lines = array_reverse($lines);
            file_put_contents($subscribers_file, implode(PHP_EOL, $lines) . PHP_EOL);
            
            // Redirect to avoid resubmission on refresh
            header('Location: ' . str_replace('&delete_subscriber=' . $delete_index, '', $_SERVER['REQUEST_URI']));
            exit;
        }
    }
}

// Initialize arrays
$contact_submissions = [];
$email_subscribers = [];

// Load contact form submissions
if (file_exists($contact_file)) {
    $lines = file($contact_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $data = explode('|', $line);
        if (count($data) >= 11) {
            $contact_submissions[] = [
                'timestamp' => $data[0],
                'ip' => $data[1] ?? 'N/A',
                'first_name' => $data[2] ?? '',
                'last_name' => $data[3] ?? '',
                'email' => $data[4] ?? '',
                'phone' => $data[5] ?? '',
                'age' => $data[6] ?? '',
                'experience' => $data[7] ?? '',
                'program' => $data[8] ?? '',
                'hear_about' => $data[9] ?? '',
                'message' => $data[10] ?? ''
            ];
        }
    }
    // Show newest first
    $contact_submissions = array_reverse($contact_submissions);
}

// Load email subscribers
if (file_exists($subscribers_file)) {
    $lines = file($subscribers_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $data = explode('|', $line);
        if (count($data) >= 2) {
            $email_subscribers[] = [
                'timestamp' => $data[0],
                'email' => $data[1],
                'ip' => $data[2] ?? 'N/A'
            ];
        }
    }
    $email_subscribers = array_reverse($email_subscribers);
}

// Handle export
if (isset($_GET['export'])) {
    $type = $_GET['export'];
    
    if ($type === 'contact') {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="contact_submissions_' . date('Y-m-d') . '.csv"');
        
        $output = fopen('php://output', 'w');
        fputcsv($output, ['Date', 'IP Address', 'First Name', 'Last Name', 'Email', 'Phone', 'Age', 'Experience', 'Program', 'How Heard', 'Message']);
        
        foreach ($contact_submissions as $submission) {
            fputcsv($output, [
                $submission['timestamp'],
                $submission['ip'],
                $submission['first_name'],
                $submission['last_name'],
                $submission['email'],
                $submission['phone'],
                $submission['age'],
                $submission['experience'],
                $submission['program'],
                $submission['hear_about'],
                $submission['message']
            ]);
        }
        fclose($output);
        exit;
        
    } elseif ($type === 'subscribers') {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="email_subscribers_' . date('Y-m-d') . '.csv"');
        
        $output = fopen('php://output', 'w');
        fputcsv($output, ['Date', 'Email', 'IP Address']);
        
        foreach ($email_subscribers as $subscriber) {
            fputcsv($output, [
                $subscriber['timestamp'],
                $subscriber['email'],
                $subscriber['ip']
            ]);
        }
        fclose($output);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Submissions - Kaizen Karate Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --kaizen-primary: #a4332b;
            --kaizen-secondary: #721c24;
            --sidebar-bg: #2c3e50;
            --sidebar-hover: #34495e;
        }
        
        body { background-color: #f8f9fa; }
        .sidebar { background: var(--sidebar-bg); min-height: 100vh; }
        .sidebar .nav-link { color: #ecf0f1; padding: 1rem 1.5rem; margin: 0.25rem 0; border-radius: 8px; transition: all 0.3s ease; }
        .sidebar .nav-link:hover { background: var(--sidebar-hover); color: white; transform: translateX(5px); }
        .sidebar .nav-link.active { background: var(--kaizen-primary); color: white; }
        .brand-header { background: linear-gradient(45deg, var(--kaizen-primary), var(--kaizen-secondary)); color: white; padding: 1.5rem; text-align: center; }
        .submissions-card { background: white; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); margin-bottom: 2rem; overflow: hidden; }
        .card-header-custom { background: linear-gradient(45deg, var(--kaizen-primary), var(--kaizen-secondary)); color: white; padding: 1.5rem; }
        .btn-kaizen { background: linear-gradient(45deg, var(--kaizen-primary), var(--kaizen-secondary)); border: none; color: white; padding: 0.5rem 1.5rem; border-radius: 8px; font-weight: 600; }
        .btn-kaizen:hover { color: white; transform: translateY(-2px); box-shadow: 0 8px 25px rgba(164, 51, 43, 0.3); }
        .table-responsive { max-height: 500px; overflow-y: auto; }
        .submission-row:hover { background-color: #f8f9fa; }
        .badge-recent { background: linear-gradient(45deg, #28a745, #20c997); }
        .message-preview { 
            max-width: 250px; 
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            cursor: pointer;
        }
        .message-preview:hover { 
            white-space: normal;
            overflow: visible;
            position: absolute;
            background: white;
            border: 1px solid #ddd;
            padding: 10px;
            z-index: 1000;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .debug-info { font-size: 0.8rem; }
        .total-submissions { font-size: 2.5rem; font-weight: bold; }
        .btn-delete { 
            background: linear-gradient(45deg, #dc3545, #c82333); 
            border: none; 
            color: white; 
            padding: 0.25rem 0.75rem; 
            border-radius: 4px; 
            font-size: 0.875rem;
        }
        .btn-delete:hover { 
            background: linear-gradient(45deg, #c82333, #bd2130); 
            color: white;
            transform: scale(1.05);
        }
        .actions-column { width: 100px; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <?php if (file_exists('includes/navigation.php')): ?>
                    <?php include 'includes/navigation.php'; ?>
                <?php else: ?>
                    <div class="brand-header">
                        <h4><i class="fas fa-fist-raised me-2"></i>Kaizen Admin</h4>
                    </div>
                    <nav class="nav flex-column mt-3">
                        <a href="view_submissions.php" class="nav-link active">
                            <i class="fas fa-envelope me-2"></i>Form Submissions
                        </a>
                        <a href="index.php" class="nav-link">
                            <i class="fas fa-home me-2"></i>Back to Site
                        </a>
                    </nav>
                <?php endif; ?>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1><i class="fas fa-envelope me-2 text-primary"></i>Form Submissions</h1>
                    <div class="btn-group">
                        <button onclick="window.location.reload()" class="btn btn-outline-primary">
                            <i class="fas fa-sync-alt me-2"></i>Refresh
                        </button>
                        <a href="?export=contact" class="btn btn-success">
                            <i class="fas fa-download me-2"></i>Export CSV
                        </a>
                    </div>
                </div>
                
                <!-- Stats Overview -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card bg-primary text-white">
                            <div class="card-body text-center">
                                <i class="fas fa-envelope mb-2" style="font-size: 2rem;"></i>
                                <h3 class="total-submissions"><?php echo number_format(count($contact_submissions)); ?></h3>
                                <p class="card-text">Contact Form Submissions</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-success text-white">
                            <div class="card-body text-center">
                                <i class="fas fa-users mb-2" style="font-size: 2rem;"></i>
                                <h3 class="total-submissions"><?php echo number_format(count($email_subscribers)); ?></h3>
                                <p class="card-text">Email Subscribers</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Form Submissions -->
                <div class="submissions-card">
                    <div class="card-header-custom d-flex justify-content-between align-items-center">
                        <h3 class="mb-0"><i class="fas fa-envelope me-2"></i>Contact Form Submissions</h3>
                        <div class="btn-group">
                            <a href="?export=contact" class="btn btn-light btn-sm">
                                <i class="fas fa-download me-2"></i>Export CSV
                            </a>
                            <?php if (!file_exists($contact_file)): ?>
                                <button class="btn btn-warning btn-sm" onclick="createSampleData()">
                                    <i class="fas fa-plus me-2"></i>Test Data
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <?php if (!empty($contact_submissions)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Date</th>
                                            <th>Name</th>
                                            <th>Contact Info</th>
                                            <th>Details</th>
                                            <th>Message</th>
                                            <th class="actions-column">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($contact_submissions as $index => $submission): ?>
                                            <tr class="submission-row">
                                                <td nowrap>
                                                    <small><?php echo htmlspecialchars($submission['timestamp']); ?></small>
                                                    <?php if ($index < 3): ?>
                                                        <span class="badge bg-success ms-1">New</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($submission['first_name'] . ' ' . $submission['last_name']); ?></strong><br>
                                                    <small class="text-muted">Age: <?php echo htmlspecialchars($submission['age']); ?></small>
                                                </td>
                                                <td>
                                                    <a href="mailto:<?php echo htmlspecialchars($submission['email']); ?>">
                                                        <?php echo htmlspecialchars($submission['email']); ?>
                                                    </a><br>
                                                    <a href="tel:<?php echo htmlspecialchars($submission['phone']); ?>">
                                                        <?php echo htmlspecialchars($submission['phone']); ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <strong>Program:</strong> <?php echo htmlspecialchars($submission['program']); ?><br>
                                                    <strong>Experience:</strong> <?php echo htmlspecialchars($submission['experience']); ?><br>
                                                    <strong>Heard via:</strong> <?php echo htmlspecialchars($submission['hear_about']); ?>
                                                </td>
                                                <td>
                                                    <div class="message-preview" title="Click to view full message">
                                                        <?php echo htmlspecialchars(substr($submission['message'], 0, 100)); ?>
                                                        <?php if (strlen($submission['message']) > 100): ?>...<?php endif; ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button class="btn btn-delete" onclick="confirmDelete('contact', <?php echo $index; ?>)">
                                                        <i class="fas fa-trash me-1"></i>Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5 text-muted">
                                <i class="fas fa-inbox mb-3" style="font-size: 3rem;"></i>
                                <h5>No contact form submissions yet</h5>
                                <p>Submit a test form on your website first, then refresh this page.</p>
                                <div class="mt-3">
                                    <a href="index.php#contact" class="btn btn-primary me-2">
                                        <i class="fas fa-external-link-alt me-2"></i>Go to Contact Form
                                    </a>
                                    <button class="btn btn-outline-secondary" onclick="createSampleData()">
                                        <i class="fas fa-plus me-2"></i>Create Test Data
                                    </button>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Email Subscribers -->
                <?php if (!empty($email_subscribers)): ?>
                <div class="submissions-card mt-4">
                    <div class="card-header-custom d-flex justify-content-between align-items-center">
                        <h3 class="mb-0"><i class="fas fa-users me-2"></i>Email Subscribers</h3>
                        <a href="?export=subscribers" class="btn btn-light btn-sm">
                            <i class="fas fa-download me-2"></i>Export CSV
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Email Address</th>
                                        <th>IP Address</th>
                                        <th class="actions-column">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($email_subscribers as $index => $subscriber): ?>
                                        <tr class="submission-row">
                                            <td><?php echo htmlspecialchars($subscriber['timestamp']); ?></td>
                                            <td>
                                                <a href="mailto:<?php echo htmlspecialchars($subscriber['email']); ?>">
                                                    <?php echo htmlspecialchars($subscriber['email']); ?>
                                                </a>
                                            </td>
                                            <td>
                                                <small class="text-muted"><?php echo htmlspecialchars($subscriber['ip']); ?></small>
                                            </td>
                                            <td>
                                                <button class="btn btn-delete" onclick="confirmDelete('subscriber', <?php echo $index; ?>)">
                                                    <i class="fas fa-trash me-1"></i>Delete
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Quick Actions -->
                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-bolt me-2 text-primary"></i>Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <button onclick="window.location.reload()" class="btn btn-outline-primary w-100">
                                    <i class="fas fa-sync-alt me-2"></i>Refresh Data
                                </button>
                            </div>
                            <div class="col-md-4 mb-3">
                                <a href="?export=contact" class="btn btn-outline-success w-100">
                                    <i class="fas fa-download me-2"></i>Export Contact Data
                                </a>
                            </div>
                            <div class="col-md-4 mb-3">
                                <?php if (!empty($email_subscribers)): ?>
                                    <a href="?export=subscribers" class="btn btn-outline-info w-100">
                                        <i class="fas fa-download me-2"></i>Export Subscribers
                                    </a>
                                <?php else: ?>
                                    <button class="btn btn-outline-secondary w-100" disabled>
                                        <i class="fas fa-download me-2"></i>No Subscribers
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Expand message on click
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('message-preview')) {
                const message = e.target.textContent;
                if (message.length > 100) {
                    alert('Full Message:\n\n' + message);
                }
            }
        });
        
        // Function to create sample data for testing
        function createSampleData() {
            if (confirm('Create sample contact form data? This will help test the admin panel.')) {
                fetch('create_sample_data.php')
                    .then(response => response.text())
                    .then(data => {
                        alert('Sample data created! Refreshing page...');
                        setTimeout(() => window.location.reload(), 1000);
                    })
                    .catch(error => {
                        alert('Error creating sample data: ' + error);
                    });
            }
        }
        
        // Function to confirm and execute delete
        function confirmDelete(type, index) {
            if (confirm('Are you sure you want to delete this ' + type + '? This action cannot be undone.')) {
                if (type === 'contact') {
                    window.location.href = '?delete_contact=' + index;
                } else if (type === 'subscriber') {
                    window.location.href = '?delete_subscriber=' + index;
                }
            }
        }
    </script>
</body>
</html>