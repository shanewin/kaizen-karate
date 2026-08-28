<?php
define('KAIZEN_ADMIN', true);
session_start();
require_once 'config.php';

// Require login
require_login();

$success = '';
$error = '';

// Handle form submission
if ($_POST && verify_csrf_token($_POST['csrf_token'] ?? '')) {
    try {
        $schedule_data = [
            'monday' => [
                'morning' => sanitize_input($_POST['monday_morning'] ?? ''),
                'afternoon' => sanitize_input($_POST['monday_afternoon'] ?? ''),
                'evening' => sanitize_input($_POST['monday_evening'] ?? '')
            ],
            'tuesday' => [
                'morning' => sanitize_input($_POST['tuesday_morning'] ?? ''),
                'afternoon' => sanitize_input($_POST['tuesday_afternoon'] ?? ''),
                'evening' => sanitize_input($_POST['tuesday_evening'] ?? '')
            ],
            'wednesday' => [
                'morning' => sanitize_input($_POST['wednesday_morning'] ?? ''),
                'afternoon' => sanitize_input($_POST['wednesday_afternoon'] ?? ''),
                'evening' => sanitize_input($_POST['wednesday_evening'] ?? '')
            ],
            'thursday' => [
                'morning' => sanitize_input($_POST['thursday_morning'] ?? ''),
                'afternoon' => sanitize_input($_POST['thursday_afternoon'] ?? ''),
                'evening' => sanitize_input($_POST['thursday_evening'] ?? '')
            ],
            'friday' => [
                'morning' => sanitize_input($_POST['friday_morning'] ?? ''),
                'afternoon' => sanitize_input($_POST['friday_afternoon'] ?? ''),
                'evening' => sanitize_input($_POST['friday_evening'] ?? '')
            ],
            'saturday' => [
                'morning' => sanitize_input($_POST['saturday_morning'] ?? ''),
                'afternoon' => sanitize_input($_POST['saturday_afternoon'] ?? ''),
                'evening' => sanitize_input($_POST['saturday_evening'] ?? '')
            ],
            'sunday' => [
                'morning' => sanitize_input($_POST['sunday_morning'] ?? ''),
                'afternoon' => sanitize_input($_POST['sunday_afternoon'] ?? ''),
                'evening' => sanitize_input($_POST['sunday_evening'] ?? '')
            ]
        ];
        
        // Save schedule data
        save_json_data('schedule', $schedule_data);
        $success = 'Class schedule updated successfully!';
        
    } catch (Exception $e) {
        $error = 'Error updating schedule: ' . $e->getMessage();
    }
}

// Load current schedule data
$schedule = load_json_data('schedule') ?: [];

// Default empty schedule structure
$default_schedule = [
    'monday' => ['morning' => '', 'afternoon' => '', 'evening' => ''],
    'tuesday' => ['morning' => '', 'afternoon' => '', 'evening' => ''],
    'wednesday' => ['morning' => '', 'afternoon' => '', 'evening' => ''],
    'thursday' => ['morning' => '', 'afternoon' => '', 'evening' => ''],
    'friday' => ['morning' => '', 'afternoon' => '', 'evening' => ''],
    'saturday' => ['morning' => '', 'afternoon' => '', 'evening' => ''],
    'sunday' => ['morning' => '', 'afternoon' => '', 'evening' => '']
];

// Merge with defaults to ensure all fields exist
foreach ($default_schedule as $day => $times) {
    if (!isset($schedule[$day])) {
        $schedule[$day] = $times;
    } else {
        foreach ($times as $time => $value) {
            if (!isset($schedule[$day][$time])) {
                $schedule[$day][$time] = '';
            }
        }
    }
}

$csrf_token = generate_csrf_token();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Schedule - Kaizen Karate Admin</title>
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
        
        .schedule-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        
        .day-header {
            background: linear-gradient(45deg, var(--kaizen-primary), var(--kaizen-secondary));
            color: white;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            text-align: center;
            font-weight: bold;
        }
        
        .time-slot {
            margin-bottom: 1rem;
        }
        
        .time-label {
            font-weight: 600;
            color: var(--kaizen-primary);
            margin-bottom: 0.5rem;
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
            <div class="col-md-9 col-lg-10 main-content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>
                        <i class="fas fa-calendar-alt me-2 text-primary"></i>
                        Class Schedule Management
                    </h1>
                    <div class="text-muted">
                        <i class="fas fa-clock me-1"></i>
                        Set class times for each day
                    </div>
                </div>

                <?php if ($success): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i><?php echo $success; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i><?php echo $error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                    
                    <div class="row">
                        <?php 
                        $days = [
                            'monday' => 'Monday',
                            'tuesday' => 'Tuesday', 
                            'wednesday' => 'Wednesday',
                            'thursday' => 'Thursday',
                            'friday' => 'Friday',
                            'saturday' => 'Saturday',
                            'sunday' => 'Sunday'
                        ];
                        
                        foreach ($days as $day_key => $day_name): ?>
                            <div class="col-lg-6 mb-4">
                                <div class="schedule-card">
                                    <div class="day-header">
                                        <i class="fas fa-calendar-day me-2"></i>
                                        <?php echo $day_name; ?>
                                    </div>
                                    
                                    <div class="time-slot">
                                        <div class="time-label">
                                            <i class="fas fa-sun me-2"></i>Morning Classes
                                        </div>
                                        <textarea 
                                            class="form-control" 
                                            name="<?php echo $day_key; ?>_morning" 
                                            rows="2" 
                                            placeholder="e.g., Little Dragons 9:00-9:30 AM, Kids Karate 10:00-11:00 AM"
                                        ><?php echo htmlspecialchars($schedule[$day_key]['morning']); ?></textarea>
                                    </div>
                                    
                                    <div class="time-slot">
                                        <div class="time-label">
                                            <i class="fas fa-cloud-sun me-2"></i>Afternoon Classes
                                        </div>
                                        <textarea 
                                            class="form-control" 
                                            name="<?php echo $day_key; ?>_afternoon" 
                                            rows="2" 
                                            placeholder="e.g., Teen Karate 3:00-4:00 PM, Adult Karate 4:30-5:30 PM"
                                        ><?php echo htmlspecialchars($schedule[$day_key]['afternoon']); ?></textarea>
                                    </div>
                                    
                                    <div class="time-slot">
                                        <div class="time-label">
                                            <i class="fas fa-moon me-2"></i>Evening Classes
                                        </div>
                                        <textarea 
                                            class="form-control" 
                                            name="<?php echo $day_key; ?>_evening" 
                                            rows="2" 
                                            placeholder="e.g., Adult Advanced 6:00-7:00 PM, Sparring Class 7:30-8:30 PM"
                                        ><?php echo htmlspecialchars($schedule[$day_key]['evening']); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-kaizen btn-lg">
                            <i class="fas fa-save me-2"></i>Update Class Schedule
                        </button>
                    </div>
                </form>

                <!-- Usage Instructions -->
                <div class="mt-5">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="fas fa-info-circle me-2 text-primary"></i>
                                How to Use the Schedule Manager
                            </h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2"><i class="fas fa-clock text-primary me-2"></i><strong>Time Formats:</strong> Use clear time formats like "9:00-10:00 AM" or "6:00-7:00 PM"</li>
                                <li class="mb-2"><i class="fas fa-users text-primary me-2"></i><strong>Class Names:</strong> Include age groups like "Little Dragons", "Kids Karate", "Teen Karate", "Adult Karate"</li>
                                <li class="mb-2"><i class="fas fa-list text-primary me-2"></i><strong>Multiple Classes:</strong> Separate multiple classes with commas or new lines</li>
                                <li class="mb-2"><i class="fas fa-times text-primary me-2"></i><strong>No Classes:</strong> Leave fields empty for days/times with no scheduled classes</li>
                                <li><i class="fas fa-sync text-primary me-2"></i><strong>Updates:</strong> Changes appear immediately on your website after saving</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>