<?php
define('KAIZEN_ADMIN', true);
session_start();
require_once __DIR__ . '/error-handling.php';
require_once 'config.php';

// Require login
require_login();

// File paths
$contact_file = DATA_ROOT . '/contact_submissions.txt';
$nyc_file = DATA_ROOT . '/nyc_contact_submissions.txt';
$subscribers_file = DATA_ROOT . '/subscribers.txt';

/**
 * Read submissions from one pipe delimited file.
 *
 * A record starts with a timestamp. Message bodies can contain newlines, so any
 * following line without a timestamp belongs to the record before it. Counting
 * raw lines instead treated those continuations as separate rows, and the older
 * nine field format was skipped entirely, which hid all but a handful of the
 * history.
 *
 * @return array{records: array, raw: array} parsed records and their raw text
 */
function read_submission_file($path, $source) {
    if (!file_exists($path)) {
        return ['records' => [], 'raw' => []];
    }

    $records = [];
    $raw     = [];

    foreach (file($path, FILE_IGNORE_NEW_LINES) as $line) {
        if (preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\|/', $line)) {
            $raw[] = $line;
        } elseif ($raw) {
            // continuation of the previous record's message
            $raw[count($raw) - 1] .= "\n" . $line;
        }
    }

    foreach ($raw as $i => $entry) {
        $d = explode('|', $entry);
        $base = [
            'source'     => $source,
            'index'      => $i,
            'timestamp'  => $d[0] ?? '',
            'ip'         => $d[1] ?? '',
            'first_name' => $d[2] ?? '',
            'last_name'  => $d[3] ?? '',
            'email'      => $d[4] ?? '',
            'phone'      => $d[5] ?? '',
            'age'        => '',
        ];

        if ($source === 'nyc') {
            // timestamp|ip|first|last|email|phone|role|borough|school|message
            $records[] = $base + [
                'details' => array_filter([
                    'Role'    => $d[6] ?? '',
                    'Borough' => $d[7] ?? '',
                    'School'  => $d[8] ?? '',
                ]),
                'message' => $d[9] ?? '',
            ];
        } elseif (count($d) >= 11) {
            // timestamp|ip|first|last|email|phone|age|experience|program|heard|message
            $records[] = array_merge($base, [
                'age'     => $d[6] ?? '',
                'details' => array_filter([
                    'Program'    => $d[8] ?? '',
                    'Experience' => $d[7] ?? '',
                    'Heard via'  => $d[9] ?? '',
                ]),
                'message' => implode('|', array_slice($d, 10)),
            ]);
        } else {
            // older format, no age or experience:
            // timestamp|ip|first|last|email|phone|program|heard|message
            $records[] = $base + [
                'details' => array_filter([
                    'Program'   => $d[6] ?? '',
                    'Heard via' => $d[7] ?? '',
                ]),
                'message' => implode('|', array_slice($d, 8)),
            ];
        }
    }

    return ['records' => $records, 'raw' => $raw];
}

// Handle delete action. Deleting used to remove a raw line, which for a
// multi-line message removed one fragment and corrupted the rest, so it now
// removes a whole record. Destructive and reachable by URL, so it carries a
// token like every other admin action.
if (isset($_GET['delete_contact']) && is_numeric($_GET['delete_contact'])) {
    if (!verify_csrf_token($_GET['token'] ?? '')) {
        http_response_code(403);
        die('Invalid security token');
    }

    $delete_source = ($_GET['source'] ?? 'main') === 'nyc' ? 'nyc' : 'main';
    $target_file   = $delete_source === 'nyc' ? $nyc_file : $contact_file;
    $parsed        = read_submission_file($target_file, $delete_source);
    $delete_index  = (int) $_GET['delete_contact'];

    if (isset($parsed['raw'][$delete_index])) {
        unset($parsed['raw'][$delete_index]);
        file_put_contents($target_file, implode(PHP_EOL, $parsed['raw']) . PHP_EOL, LOCK_EX);

        $back = strtok($_SERVER['REQUEST_URI'], '?');
        header('Location: ' . $back);
        exit;
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

// Load submissions from both sources: the retired main site form, whose history
// is still worth keeping, and the second location module, which is the live one.
$main_parsed = read_submission_file($contact_file, 'main');
$nyc_parsed  = read_submission_file($nyc_file, 'nyc');

$contact_submissions = array_merge($main_parsed['records'], $nyc_parsed['records']);

// Newest first, across both sources.
usort($contact_submissions, function ($a, $b) {
    return strcmp($b['timestamp'], $a['timestamp']);
});

// Rendering every record produced an 8MB page once the older history became
// visible, so the table shows the most recent slice by default. The totals and
// the CSV export still cover the full set.
$display_limit    = isset($_GET['show']) && $_GET['show'] === 'all' ? null : 200;
$total_submissions = count($contact_submissions);
$visible_submissions = $display_limit === null
    ? $contact_submissions
    : array_slice($contact_submissions, 0, $display_limit);

$submission_counts = [
    'main' => count($main_parsed['records']),
    'nyc'  => count($nyc_parsed['records']),
];

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
        fputcsv($output, ['Date', 'Source', 'IP Address', 'First Name', 'Last Name', 'Email', 'Phone', 'Age', 'Details', 'Message']);
        
        foreach ($contact_submissions as $submission) {
            fputcsv($output, [
                $submission['timestamp'],
                $submission['source'] === 'nyc' ? 'NYC' : 'Main site',
                $submission['ip'],
                $submission['first_name'],
                $submission['last_name'],
                $submission['email'],
                $submission['phone'],
                $submission['age'],
                implode('; ', array_map(
                    function ($k, $v) { return "$k: $v"; },
                    array_keys($submission['details']),
                    $submission['details']
                )),
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
                        <div class="card bg-secondary text-white">
                            <div class="card-body text-center">
                                <i class="fas fa-envelope-open-text mb-2" style="font-size: 2rem;"></i>
                                <h3 class="h5 mb-1">Email Signups</h3>
                                <p class="card-text mb-0">Handled by the Elfsight form. View them in your Elfsight dashboard.</p>
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
                                <?php if ($display_limit !== null && $total_submissions > $display_limit): ?>
                                    <div class="alert alert-light border small">
                                        Showing the most recent <?php echo number_format($display_limit); ?>
                                        of <?php echo number_format($total_submissions); ?> submissions.
                                        <a href="?show=all">Show all</a> or use Export for the full set.
                                    </div>
                                <?php endif; ?>
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
                                        <?php foreach ($visible_submissions as $index => $submission): ?>
                                            <tr class="submission-row">
                                                <td nowrap>
                                                    <small><?php echo htmlspecialchars($submission['timestamp']); ?></small>
                                                    <?php if ($index < 3): ?>
                                                        <span class="badge bg-success ms-1">New</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($submission['first_name'] . ' ' . $submission['last_name']); ?></strong><br>
                                                    <?php if ($submission['age'] !== ''): ?>
                                                        <small class="text-muted">Age: <?php echo htmlspecialchars($submission['age']); ?></small><br>
                                                    <?php endif; ?>
                                                    <span class="badge bg-<?php echo $submission['source'] === 'nyc' ? 'info' : 'secondary'; ?>">
                                                        <?php echo $submission['source'] === 'nyc' ? 'NYC' : 'Main site'; ?>
                                                    </span>
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
                                                    <?php if (empty($submission['details'])): ?>
                                                        <span class="text-muted">&mdash;</span>
                                                    <?php else: foreach ($submission['details'] as $label => $value): ?>
                                                        <strong><?php echo htmlspecialchars($label); ?>:</strong>
                                                        <?php echo htmlspecialchars($value); ?><br>
                                                    <?php endforeach; endif; ?>
                                                </td>
                                                <td>
                                                    <div class="message-preview" title="Click to view full message">
                                                        <?php echo htmlspecialchars(substr($submission['message'], 0, 100)); ?>
                                                        <?php if (strlen($submission['message']) > 100): ?>...<?php endif; ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button class="btn btn-delete" onclick="confirmDelete('contact', <?php echo (int) $submission['index']; ?>, '<?php echo $submission['source']; ?>')">
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
                
                <!-- Email subscribers captured before signups moved to the Elfsight
                     form. Shown only while legacy rows remain in subscribers.txt. -->
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
                            <?php if (!empty($email_subscribers)): ?>
                                <div class="col-md-4 mb-3">
                                    <a href="?export=subscribers" class="btn btn-outline-info w-100">
                                        <i class="fas fa-download me-2"></i>Export Legacy Subscribers
                                    </a>
                                </div>
                            <?php endif; ?>
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
        const CSRF_TOKEN = <?php echo json_encode(generate_csrf_token()); ?>;

        function confirmDelete(type, index, source) {
            if (confirm('Are you sure you want to delete this ' + type + '? This action cannot be undone.')) {
                if (type === 'contact') {
                    window.location.href = '?delete_contact=' + index
                        + '&source=' + encodeURIComponent(source || 'main')
                        + '&token=' + encodeURIComponent(CSRF_TOKEN);
                } else if (type === 'subscriber') {
                    window.location.href = '?delete_subscriber=' + index;
                }
            }
        }
    </script>
</body>
</html>