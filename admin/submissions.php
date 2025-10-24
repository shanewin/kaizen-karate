<?php
define('KAIZEN_ADMIN', true);
session_start();
require_once 'config.php';

// Require login
require_login();

$message = '';

// Load submissions
$waitlist_file = DATA_ROOT . '/waitlist_submissions.txt';
$subscribers_file = DATA_ROOT . '/subscribers.txt';

$waitlist_submissions = [];
$email_subscribers = [];

if (file_exists($waitlist_file)) {
    $lines = file($waitlist_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $data = explode('|', $line);
        if (count($data) >= 5) {
            $waitlist_submissions[] = [
                'timestamp' => $data[0],
                'first_name' => $data[1],
                'last_name' => $data[2], 
                'email' => $data[3],
                'phone' => $data[4],
                'ip' => $data[5] ?? 'N/A'
            ];
        }
    }
    // Reverse to show newest first
    $waitlist_submissions = array_reverse($waitlist_submissions);
}

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
    // Reverse to show newest first
    $email_subscribers = array_reverse($email_subscribers);
}

// Handle export
if (isset($_GET['export'])) {
    $type = $_GET['export'];
    
    if ($type === 'waitlist') {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="waitlist_submissions_' . date('Y-m-d') . '.csv"');
        
        echo "Date,First Name,Last Name,Email,Phone,IP Address\n";
        foreach ($waitlist_submissions as $submission) {
            echo '"' . date('Y-m-d H:i:s', $submission['timestamp']) . '",';
            echo '"' . $submission['first_name'] . '",';
            echo '"' . $submission['last_name'] . '",';
            echo '"' . $submission['email'] . '",';
            echo '"' . $submission['phone'] . '",';
            echo '"' . $submission['ip'] . '"' . "\n";
        }
        exit;
    } elseif ($type === 'subscribers') {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="email_subscribers_' . date('Y-m-d') . '.csv"');
        
        echo "Date,Email,IP Address\n";
        foreach ($email_subscribers as $subscriber) {
            echo '"' . date('Y-m-d H:i:s', $subscriber['timestamp']) . '",';
            echo '"' . $subscriber['email'] . '",';
            echo '"' . $subscriber['ip'] . '"' . "\n";
        }
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
                    <h1><i class="fas fa-envelope me-2 text-primary"></i>Form Submissions</h1>
                </div>
                
                <?php echo $message; ?>
                
                <!-- Stats Overview -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card bg-primary text-white">
                            <div class="card-body text-center">
                                <i class="fas fa-list-ul mb-2" style="font-size: 2rem;"></i>
                                <h3 class="card-title"><?php echo count($waitlist_submissions); ?></h3>
                                <p class="card-text">Wait List Submissions</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-success text-white">
                            <div class="card-body text-center">
                                <i class="fas fa-envelope mb-2" style="font-size: 2rem;"></i>
                                <h3 class="card-title"><?php echo count($email_subscribers); ?></h3>
                                <p class="card-text">Email Subscribers</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Wait List Submissions -->
                <div class="submissions-card">
                    <div class="card-header-custom d-flex justify-content-between align-items-center">
                        <h3 class="mb-0"><i class="fas fa-list-ul me-2"></i>Wait List Submissions</h3>
                        <a href="?export=waitlist" class="btn btn-light btn-sm">
                            <i class="fas fa-download me-2"></i>Export CSV
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <?php if (!empty($waitlist_submissions)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Date</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>IP Address</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($waitlist_submissions as $index => $submission): ?>
                                            <tr class="submission-row">
                                                <td>
                                                    <?php echo date('M j, Y g:i A', $submission['timestamp']); ?>
                                                    <?php if ($index < 5): ?>
                                                        <span class="badge badge-recent text-white ms-1">Recent</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($submission['first_name'] . ' ' . $submission['last_name']); ?></strong>
                                                </td>
                                                <td>
                                                    <a href="mailto:<?php echo htmlspecialchars($submission['email']); ?>">
                                                        <?php echo htmlspecialchars($submission['email']); ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="tel:<?php echo htmlspecialchars($submission['phone']); ?>">
                                                        <?php echo htmlspecialchars($submission['phone']); ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <small class="text-muted"><?php echo htmlspecialchars($submission['ip']); ?></small>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5 text-muted">
                                <i class="fas fa-inbox mb-3" style="font-size: 3rem;"></i>
                                <h5>No wait list submissions yet</h5>
                                <p>Submissions will appear here when visitors join your wait list.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Email Subscribers -->
                <div class="submissions-card">
                    <div class="card-header-custom d-flex justify-content-between align-items-center">
                        <h3 class="mb-0"><i class="fas fa-envelope me-2"></i>Email Subscribers</h3>
                        <a href="?export=subscribers" class="btn btn-light btn-sm">
                            <i class="fas fa-download me-2"></i>Export CSV
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <?php if (!empty($email_subscribers)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Date</th>
                                            <th>Email Address</th>
                                            <th>IP Address</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($email_subscribers as $index => $subscriber): ?>
                                            <tr class="submission-row">
                                                <td>
                                                    <?php echo date('M j, Y g:i A', $subscriber['timestamp']); ?>
                                                    <?php if ($index < 5): ?>
                                                        <span class="badge badge-recent text-white ms-1">Recent</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="mailto:<?php echo htmlspecialchars($subscriber['email']); ?>">
                                                        <?php echo htmlspecialchars($subscriber['email']); ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <small class="text-muted"><?php echo htmlspecialchars($subscriber['ip']); ?></small>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5 text-muted">
                                <i class="fas fa-envelope-open mb-3" style="font-size: 3rem;"></i>
                                <h5>No email subscribers yet</h5>
                                <p>Email subscriptions will appear here when visitors subscribe to updates.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="card">
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
                                <a href="?export=waitlist" class="btn btn-outline-success w-100">
                                    <i class="fas fa-download me-2"></i>Export Wait List
                                </a>
                            </div>
                            <div class="col-md-4 mb-3">
                                <a href="?export=subscribers" class="btn btn-outline-success w-100">
                                    <i class="fas fa-download me-2"></i>Export Subscribers
                                </a>
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