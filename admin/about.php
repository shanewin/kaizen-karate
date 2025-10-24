<?php
define('KAIZEN_ADMIN', true);
session_start();
require_once 'config.php';

// Require login
require_login();

$message = '';

// Load current about section data
$contentFile = '../data/content/site-content.json';
$content = file_exists($contentFile) ? json_decode(file_get_contents($contentFile), true) : [];

// Default data structure
$defaultAbout = [
    'kaizen_section' => [
        'title' => 'About Kaizen Karate',
        'coach_v_image' => 'assets/images/about/coach-v-about.png',
        'coach_v_image_alt' => 'Coach V - Head Instructor at Kaizen Karate',
        'lead_paragraph' => 'Kaizen Karate was founded by Coach V in 2003. Kaizen Karate has been offering instruction in non-traditional Tang Soo Do as part of its core curriculum since its founding. Around 2010 Chinese Kenpo was introduced into the Kaizen curriculum.',
        'paragraph_2' => "Kaizen Karate's team of highly trained martial artists offer a number of programs for students starting as young as 3.5 years old up to adult. They focus on discipline and encouragement in a fun-loving environment. Their main goal is to help everyone progress, continually improve, and enjoy the process.",
        'paragraph_3' => 'Kaizen Karate now operates 7 days per week throughout Maryland, Washington D.C., Virginia, and New York.'
    ],
    'coach_v_section' => [
        'title' => 'Meet Coach V',
        'paragraph_1' => '"Coach V" has 38 years of experience in the martial arts, having spent the majority of his life committed to the trade. He began his journey with karate at five years old and earned his first black belt in non-traditional Tang Soo Do in 1998 through Hill\'s Hitters Karate and Master Instructor Dr. Phillip Hill.',
        'paragraph_2' => 'Coach V went on to earn his business degree at the Robert H. Smith School of Business at the University of Maryland in College Park. He then continued his training in Kenpo under 8th degree black belt Sifu Greg Payne who also holds a 5th degree black belt in Shotokan as well as many other black belts in other arts including Goju ryu & Judo.',
        'paragraph_3' => 'In 2024, Coach V was promoted to 8th degree black belt in IKCA Chinese Kenpo by 10th degree black belt Senior Grandmaster Chuck Sullivan. Additionally, Coach V holds the rank of Nikyu (2nd degree brown belt) in Budoshin JuJitsu and studied Aikido at the ASU headquarters overseen by Saotome Sensei, Shihan.',
        'paragraph_4' => 'In his free time he enjoys spending time with his wife and children as well as running local long distance races which most recently included the Cherry Blossom 10 miler, Rock \'n\' Roll 1/2 Marathon, & Marine Corp Marathon in Washington, DC.'
    ],
    'team_section' => [
        'title' => 'Meet the Team',
        'instructors' => [
            [
                'name' => 'Coach Chris Marr',
                'title' => 'Instructor',
                'image' => '',
                'image_alt' => '',
                'bio' => [
                    '<strong>Qualifications:</strong> 5th degree black belt with Kaizen Karate, over 20 years of martial arts experience and over 15 years of instructional experience.',
                    'Coach Chris holds black belts in Kenpo Karate and Tien Shan Pai Kung Fu and has trained for years in several different martial arts including: Muay Thai (reaching the rank of instructor), boxing, Brazilian Jiu Jitsu (blue belt), and Kyokushin Karate. He is very interested in the history of martial arts, especially arts from East Asia and Southeast Asia.',
                    "Chris' other hobbies include running, lifting weights, and interval training mostly to stay competitive in the martial arts he still practices. He spends most of his free time with his wife and son."
                ]
            ],
            [
                'name' => 'Coach Zach Knox',
                'title' => 'Instructor',
                'image' => '',
                'image_alt' => '',
                'bio' => [
                    '<strong>Experience:</strong> Training since 1987, Zach Knox holds black belts in Tae Kwon Do and Hap Ki Do.',
                    'Over the years, he has trained in different arts such as Kung Fu, Shorin Ryu and Goju Ryu Karate, Kickboxing, and Escrima. In his time away from teaching and training, his hobbies include acting, directing, producing, football, hiking, screenplay writing, reading, boxing, and rock climbing.'
                ]
            ],
            [
                'name' => 'Coach David Matusow',
                'title' => 'Instructor',
                'image' => '',
                'image_alt' => '',
                'bio' => [
                    '<strong>Background:</strong> Inspired by \'The Karate Kid\', Coach David began his martial arts journey in 1988. He currently holds a 1st degree blackbelt in Tae Kwon Do, a 6th degree blackbelt in non traditional Tang Soo Do, and a 6th degree blackbelt in Chinese Kenpo where he is also an IKCA Certified Instructor.',
                    'Coach David earned his first blackbelt in Tae Kwon Do in 1993 under 9th degree Master Jae Kim, his second blackbelt in Tang Soo Do from Kaizen Karate under Coach V, and his third blackbelt in IKCA Chinese Kenpo under Coach V and 10th degree blackbelt Senior Grandmaster Chuck Sullivan.',
                    'A Software Engineer at NASA and accomplished triathlete, Coach David has competed in numerous races and is a 3-time Ironman triathlon finisher. He has 2 children, both blackbelts in Kaizen Karate, and enjoys competing in duplicate bridge and home coffee brewing.'
                ]
            ],
            [
                'name' => 'Coach Skylar Parr',
                'title' => 'Instructor',
                'image' => '',
                'image_alt' => '',
                'bio' => [
                    '<strong>Journey:</strong> Coach Skylar started martial arts at 11 years old. After bouncing around a few schools at first, she eventually landed in a Tae Kwon Do dojang, where she would get the base of her skills and passion for the arts.',
                    'She began training and teaching with Kaizen Karate in 2011 and earned her black belt in 2017. As an avid martial artist and personal trainer (NASM), she spends most of her time doing things related to fitness and martial arts. However, she also loves studying languages, playing drums, camping, skateboarding, and learning about a wide breadth of subjects.'
                ]
            ],
            [
                'name' => 'Coach Nina Hanisco',
                'title' => 'Instructor',
                'image' => '',
                'image_alt' => '',
                'bio' => [
                    '<strong>Experience:</strong> Coach Nina has trained with Kaizen Karate for over 10 years and has over five years of teaching experience in summer camp and classes. She is a Kaizen Karate Senior Instructor.',
                    'She received her Kaizen Karate black belt in 2021 and her first degree Kaizen black belt in 2023. Currently, she studies Psychology and Sociology at McDaniel College in Westminster, Maryland.'
                ]
            ],
            [
                'name' => 'Coach James Stevens',
                'title' => 'Instructor',
                'image' => '',
                'image_alt' => '',
                'bio' => [
                    '<strong>Unique Journey:</strong> Coach James\' exploration of martial arts began as a Kaizen Karate parent, watching his now-advanced rank son throw punches and kicks as a kindergartner. Starting as a virtual student in spring 2020, he dedicated himself to training with accelerated progress.',
                    'When he began in-person classes in 2021, his progress continued at an accelerated pace, earning him many tournament victories, additional ranking in Chinese Kenpo, and opportunities to share lessons learned throughout his unique journey.',
                    'Professionally, he works as a full-time musician, playing live shows and performing studio vocals (his rock band Rome In A Day toured the world for Armed Forces Entertainment). He enjoys reading, writing, designing tabletop games, running, basketball, lifting weights, and helping guide his daughter in her own martial arts journey.'
                ]
            ]
        ]
    ]
];

// Initialize about_section if it doesn't exist
if (!isset($content['about_section'])) {
    $content['about_section'] = $defaultAbout;
}

// Ensure all sections exist
$aboutData = $content['about_section'];
if (!isset($aboutData['kaizen_section'])) {
    $aboutData['kaizen_section'] = $defaultAbout['kaizen_section'];
}
if (!isset($aboutData['coach_v_section'])) {
    $aboutData['coach_v_section'] = $defaultAbout['coach_v_section'];
}
if (!isset($aboutData['team_section'])) {
    $aboutData['team_section'] = $defaultAbout['team_section'];
}

// Handle delete image requests
if (isset($_POST['delete_instructor_image']) && isset($_POST['instructor_index']) && verify_csrf_token($_POST['csrf_token'] ?? '')) {
    $instructorIndex = (int)$_POST['instructor_index'];
    
    if (isset($aboutData['team_section']['instructors'][$instructorIndex])) {
        $instructor = $aboutData['team_section']['instructors'][$instructorIndex];
        
        if (!empty($instructor['image'])) {
            // Delete the image file
            $imagePath = '../' . $instructor['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            
            // Clear image data from instructor
            $aboutData['team_section']['instructors'][$instructorIndex]['image'] = '';
            $aboutData['team_section']['instructors'][$instructorIndex]['image_alt'] = '';
            
            // Save updated data
            $content['about_section'] = $aboutData;
            if (file_put_contents($contentFile, json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES))) {
                $message = success_message('Instructor image deleted successfully!');
            } else {
                $message = error_message('Failed to save changes after deleting image.');
            }
        }
    }
}

// Handle form submission
if ($_POST && !isset($_POST['delete_instructor_image'])) {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $message = error_message('Security token invalid. Please try again.');
    } else {
    
    // Update Kaizen Section
    $aboutData['kaizen_section'] = [
        'title' => $_POST['kaizen_title'] ?? $defaultAbout['kaizen_section']['title'],
        'coach_v_image' => $aboutData['kaizen_section']['coach_v_image'] ?? $defaultAbout['kaizen_section']['coach_v_image'],
        'coach_v_image_alt' => $_POST['coach_v_image_alt'] ?? $defaultAbout['kaizen_section']['coach_v_image_alt'],
        'lead_paragraph' => $_POST['kaizen_lead'] ?? $defaultAbout['kaizen_section']['lead_paragraph'],
        'paragraph_2' => $_POST['kaizen_para2'] ?? $defaultAbout['kaizen_section']['paragraph_2'],
        'paragraph_3' => $_POST['kaizen_para3'] ?? $defaultAbout['kaizen_section']['paragraph_3']
    ];
    
    // Handle Coach V image upload
    if (isset($_FILES['coach_v_image']) && $_FILES['coach_v_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../assets/images/about/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $fileInfo = pathinfo($_FILES['coach_v_image']['name']);
        $extension = strtolower($fileInfo['extension']);
        
        if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            $fileName = 'coach-v-about.' . $extension;
            $uploadPath = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['coach_v_image']['tmp_name'], $uploadPath)) {
                $aboutData['kaizen_section']['coach_v_image'] = 'assets/images/about/' . $fileName;
            }
        }
    }
    
    // Update Coach V Section
    $aboutData['coach_v_section'] = [
        'title' => $_POST['coach_v_title'] ?? $defaultAbout['coach_v_section']['title'],
        'paragraph_1' => $_POST['coach_v_para1'] ?? $defaultAbout['coach_v_section']['paragraph_1'],
        'paragraph_2' => $_POST['coach_v_para2'] ?? $defaultAbout['coach_v_section']['paragraph_2'],
        'paragraph_3' => $_POST['coach_v_para3'] ?? $defaultAbout['coach_v_section']['paragraph_3'],
        'paragraph_4' => $_POST['coach_v_para4'] ?? $defaultAbout['coach_v_section']['paragraph_4']
    ];
    
    // Update Team Section
    $aboutData['team_section']['title'] = $_POST['team_title'] ?? $defaultAbout['team_section']['title'];
    
    // Process instructors
    $instructors = [];
    if (isset($_POST['instructor_name']) && is_array($_POST['instructor_name'])) {
        foreach ($_POST['instructor_name'] as $index => $name) {
            if (!empty($name)) {
                $bio = [];
                // Process bio paragraphs
                if (isset($_POST['instructor_bio'][$index])) {
                    $bioText = $_POST['instructor_bio'][$index];
                    // Split by double newline for paragraphs (handle both \n\n and \r\n\r\n)
                    $paragraphs = preg_split('/\r?\n\r?\n+/', trim($bioText));
                    foreach ($paragraphs as $para) {
                        $para = trim($para);
                        if (!empty($para)) {
                            $bio[] = $para;
                        }
                    }
                }
                
                // Handle instructor image upload
                $currentInstructor = $aboutData['team_section']['instructors'][$index] ?? null;
                $instructorImage = $currentInstructor['image'] ?? '';
                $instructorImageAlt = $_POST['instructor_image_alt'][$index] ?? '';
                
                if (isset($_FILES['instructor_image']['tmp_name'][$index]) && $_FILES['instructor_image']['error'][$index] === UPLOAD_ERR_OK) {
                    $uploadDir = '../assets/images/instructors/';
                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    
                    $fileInfo = pathinfo($_FILES['instructor_image']['name'][$index]);
                    $extension = strtolower($fileInfo['extension']);
                    
                    if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']) && $_FILES['instructor_image']['size'][$index] <= 2097152) { // 2MB limit
                        $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '', strtolower(str_replace(' ', '_', $name)));
                        $fileName = $safeName . '.' . $extension;
                        $uploadPath = $uploadDir . $fileName;
                        
                        if (move_uploaded_file($_FILES['instructor_image']['tmp_name'][$index], $uploadPath)) {
                            $instructorImage = 'assets/images/instructors/' . $fileName;
                        }
                    }
                }
                
                $instructors[] = [
                    'name' => $name,
                    'title' => $_POST['instructor_title'][$index] ?? 'Instructor',
                    'image' => $instructorImage,
                    'image_alt' => $instructorImageAlt,
                    'bio' => $bio
                ];
            }
        }
    }
    
    if (!empty($instructors)) {
        $aboutData['team_section']['instructors'] = $instructors;
    }
    
    // Save data
    $content['about_section'] = $aboutData;
    
    if (file_put_contents($contentFile, json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES))) {
        $message = success_message('About section updated successfully!');
    } else {
        $message = error_message('Failed to save changes. Please check file permissions.');
    }
    } // Close else block for CSRF validation
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Section Management - Kaizen Karate Admin</title>
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
        .content-section { border: 1px solid #e9ecef; border-radius: 10px; padding: 1.5rem; margin-bottom: 2rem; background: white; }
        .section-title { color: var(--kaizen-primary); border-bottom: 2px solid var(--kaizen-primary); padding-bottom: 0.5rem; margin-bottom: 1rem; }
        .btn-kaizen { background: linear-gradient(45deg, var(--kaizen-primary), var(--kaizen-secondary)); border: none; color: white; padding: 0.75rem 2rem; border-radius: 8px; font-weight: 600; }
        .btn-kaizen:hover { color: white; transform: translateY(-2px); box-shadow: 0 8px 25px rgba(164, 51, 43, 0.3); }
        .form-control:focus { border-color: var(--kaizen-primary); box-shadow: 0 0 0 0.2rem rgba(164, 51, 43, 0.25); }
        
        .instructor-card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            background: #f8f9fa;
            position: relative;
        }
        
        .instructor-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #dee2e6;
        }
        
        .instructor-number {
            background: var(--kaizen-primary);
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.9rem;
        }
        
        .bio-textarea {
            min-height: 150px;
            font-family: monospace;
        }
        
        .current-image-preview {
            max-width: 200px;
            height: auto;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            margin-top: 0.5rem;
        }
        
        #add-instructor-btn {
            background: #28a745;
            border-color: #28a745;
            color: white;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
        }
        
        #add-instructor-btn:hover {
            background: #218838;
            border-color: #218838;
        }
        
        .instructions-box {
            background: #f0f7ff;
            border-left: 4px solid #0066cc;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 5px;
        }
        
        .instructions-box h6 {
            color: #0066cc;
            margin-bottom: 0.75rem;
            font-weight: 600;
        }
        
        .instructor-image-preview {
            max-width: 120px;
            height: auto;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            object-fit: cover;
            display: block;
        }
        
        .current-image-container {
            text-align: center;
        }
        
        .delete-image-btn {
            background: #dc3545;
            border-color: #dc3545;
            font-size: 0.8rem;
            padding: 0.4rem 0.8rem;
        }
        
        .delete-image-btn:hover {
            background: #c82333;
            border-color: #bd2130;
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
                    <h1><i class="fas fa-users me-2 text-primary"></i>About Section Management</h1>
                </div>
                
                <?php echo $message; ?>
                
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                    
                    <!-- About Kaizen Karate Section -->
                    <div class="content-section">
                        <h3 class="section-title"><i class="fas fa-info-circle me-2"></i>About Kaizen Karate Section</h3>
                        
                        <div class="instructions-box">
                            <h6><i class="fas fa-info-circle"></i> Instructions</h6>
                            <ul>
                                <li>This section appears at the top of the About page with Coach V's image floating on the left</li>
                                <li>The lead paragraph introduces the founding story</li>
                                <li>Paragraphs 2 and 3 provide additional context about the organization</li>
                                <li>Image should be portrait-oriented for best display</li>
                            </ul>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="kaizen_title" class="form-label">Section Title</label>
                                    <input type="text" class="form-control" id="kaizen_title" name="kaizen_title"
                                           value="<?php echo htmlspecialchars($aboutData['kaizen_section']['title'] ?? ''); ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="coach_v_image" class="form-label">Coach V Image</label>
                                    <input type="file" class="form-control" id="coach_v_image" name="coach_v_image" accept="image/*">
                                    <div class="form-text">Max 2MB, JPG/PNG/WebP</div>
                                    <?php if (!empty($aboutData['kaizen_section']['coach_v_image'])): ?>
                                        <img src="../<?php echo htmlspecialchars($aboutData['kaizen_section']['coach_v_image']); ?>" 
                                             alt="Current image" class="current-image-preview">
                                    <?php endif; ?>
                                </div>
                                <div class="mb-3">
                                    <label for="coach_v_image_alt" class="form-label">Image Alt Text</label>
                                    <input type="text" class="form-control" id="coach_v_image_alt" name="coach_v_image_alt"
                                           value="<?php echo htmlspecialchars($aboutData['kaizen_section']['coach_v_image_alt'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="kaizen_lead" class="form-label">Lead Paragraph (Founding Story)</label>
                            <textarea class="form-control" id="kaizen_lead" name="kaizen_lead" rows="3"><?php echo htmlspecialchars($aboutData['kaizen_section']['lead_paragraph'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="kaizen_para2" class="form-label">Paragraph 2 (Team & Programs)</label>
                            <textarea class="form-control" id="kaizen_para2" name="kaizen_para2" rows="3"><?php echo htmlspecialchars($aboutData['kaizen_section']['paragraph_2'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="kaizen_para3" class="form-label">Paragraph 3 (Operations)</label>
                            <textarea class="form-control" id="kaizen_para3" name="kaizen_para3" rows="2"><?php echo htmlspecialchars($aboutData['kaizen_section']['paragraph_3'] ?? ''); ?></textarea>
                        </div>
                    </div>
                    
                    <!-- Meet Coach V Section -->
                    <div class="content-section">
                        <h3 class="section-title"><i class="fas fa-user me-2"></i>Meet Coach V Section</h3>
                        
                        <div class="instructions-box">
                            <h6><i class="fas fa-info-circle"></i> Instructions</h6>
                            <ul>
                                <li>This section provides detailed information about Coach V's background</li>
                                <li>Four paragraphs cover his journey, education, credentials, and personal interests</li>
                            </ul>
                        </div>
                        
                        <div class="mb-3">
                            <label for="coach_v_title" class="form-label">Section Title</label>
                            <input type="text" class="form-control" id="coach_v_title" name="coach_v_title"
                                   value="<?php echo htmlspecialchars($aboutData['coach_v_section']['title'] ?? ''); ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="coach_v_para1" class="form-label">Paragraph 1 (Experience & Early Journey)</label>
                            <textarea class="form-control" id="coach_v_para1" name="coach_v_para1" rows="3"><?php echo htmlspecialchars($aboutData['coach_v_section']['paragraph_1'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="coach_v_para2" class="form-label">Paragraph 2 (Education & Training)</label>
                            <textarea class="form-control" id="coach_v_para2" name="coach_v_para2" rows="3"><?php echo htmlspecialchars($aboutData['coach_v_section']['paragraph_2'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="coach_v_para3" class="form-label">Paragraph 3 (Recent Achievements)</label>
                            <textarea class="form-control" id="coach_v_para3" name="coach_v_para3" rows="3"><?php echo htmlspecialchars($aboutData['coach_v_section']['paragraph_3'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="coach_v_para4" class="form-label">Paragraph 4 (Personal Interests)</label>
                            <textarea class="form-control" id="coach_v_para4" name="coach_v_para4" rows="3"><?php echo htmlspecialchars($aboutData['coach_v_section']['paragraph_4'] ?? ''); ?></textarea>
                        </div>
                    </div>
                    
                    <!-- Meet the Team Section -->
                    <div class="content-section">
                        <h3 class="section-title"><i class="fas fa-users me-2"></i>Meet the Team Section</h3>
                        
                        <div class="instructions-box">
                            <h6><i class="fas fa-info-circle"></i> Instructions</h6>
                            <ul>
                                <li>Add team members using the "Add Instructor" button</li>
                                <li>Each instructor appears in an accordion on the public site</li>
                                <li>For bio text: Separate paragraphs with double line breaks (press Enter twice)</li>
                                <li>HTML formatting like &lt;strong&gt; is supported for emphasis</li>
                            </ul>
                        </div>
                        
                        <div class="mb-3">
                            <label for="team_title" class="form-label">Section Title</label>
                            <input type="text" class="form-control" id="team_title" name="team_title"
                                   value="<?php echo htmlspecialchars($aboutData['team_section']['title'] ?? ''); ?>">
                        </div>
                        
                        <div id="instructors-container">
                            <h5 class="mb-3">Team Instructors</h5>
                            <?php
                            $instructors = $aboutData['team_section']['instructors'] ?? [];
                            foreach ($instructors as $index => $instructor):
                            ?>
                            <div class="instructor-card" data-index="<?php echo $index; ?>">
                                <div class="instructor-header">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="instructor-number"><?php echo $index + 1; ?></div>
                                        <h6 class="mb-0">Instructor <?php echo $index + 1; ?></h6>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-danger remove-instructor">
                                        <i class="fas fa-trash"></i> Remove
                                    </button>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" name="instructor_name[]"
                                               value="<?php echo htmlspecialchars($instructor['name']); ?>" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control" name="instructor_title[]"
                                               value="<?php echo htmlspecialchars($instructor['title']); ?>" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Profile Image (Optional)</label>
                                        <input type="file" class="form-control" name="instructor_image[]" accept="image/*">
                                        <div class="form-text">Max 2MB, JPG/PNG/WebP</div>
                                        <?php if (!empty($instructor['image'])): ?>
                                            <div class="current-image-container mt-2">
                                                <img src="../<?php echo htmlspecialchars($instructor['image']); ?>" 
                                                     alt="Current image" class="instructor-image-preview">
                                                <div class="mt-2">
                                                    <button type="button" class="btn btn-sm btn-danger delete-image-btn" 
                                                            data-instructor-index="<?php echo $index; ?>"
                                                            data-instructor-name="<?php echo htmlspecialchars($instructor['name']); ?>">
                                                        <i class="fas fa-trash"></i> Delete Image
                                                    </button>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Image Alt Text (if image uploaded)</label>
                                        <input type="text" class="form-control" name="instructor_image_alt[]"
                                               value="<?php echo htmlspecialchars($instructor['image_alt'] ?? ''); ?>"
                                               placeholder="e.g., Coach Smith - Karate Instructor">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Biography (separate paragraphs with double line breaks)</label>
                                    <textarea class="form-control bio-textarea" name="instructor_bio[]" rows="6"><?php 
                                        // Handle malformed bio data by converting single-string entries to proper paragraph format
                                        $bioText = '';
                                        foreach ($instructor['bio'] as $bioItem) {
                                            if (strpos($bioItem, "\r\n\r\n") !== false || strpos($bioItem, "\n\n") !== false) {
                                                // Convert \r\n\r\n to \n\n for consistent display
                                                $bioText .= str_replace("\r\n", "\n", $bioItem);
                                            } else {
                                                $bioText .= $bioItem . "\n\n";
                                            }
                                        }
                                        echo htmlspecialchars(rtrim($bioText, "\n"));
                                    ?></textarea>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <button type="button" id="add-instructor-btn" class="btn">
                            <i class="fas fa-plus"></i> Add Instructor
                        </button>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="submit" class="btn btn-kaizen">
                            <i class="fas fa-save"></i> Save All Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('instructors-container');
        const addBtn = document.getElementById('add-instructor-btn');
        
        // Handle delete image buttons
        document.addEventListener('click', function(e) {
            if (e.target.closest('.delete-image-btn')) {
                const btn = e.target.closest('.delete-image-btn');
                const instructorIndex = btn.dataset.instructorIndex;
                const instructorName = btn.dataset.instructorName;
                
                if (confirm(`Are you sure you want to delete the image for ${instructorName}? This action cannot be undone.`)) {
                    // Create and submit delete form
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.style.display = 'none';
                    
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = 'csrf_token';
                    csrfInput.value = '<?php echo generate_csrf_token(); ?>';
                    
                    const deleteInput = document.createElement('input');
                    deleteInput.type = 'hidden';
                    deleteInput.name = 'delete_instructor_image';
                    deleteInput.value = '1';
                    
                    const indexInput = document.createElement('input');
                    indexInput.type = 'hidden';
                    indexInput.name = 'instructor_index';
                    indexInput.value = instructorIndex;
                    
                    form.appendChild(csrfInput);
                    form.appendChild(deleteInput);
                    form.appendChild(indexInput);
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            }
        });
        
        // Add new instructor
        addBtn.addEventListener('click', function() {
            const instructors = container.querySelectorAll('.instructor-card');
            const newIndex = instructors.length;
            
            const newCard = document.createElement('div');
            newCard.className = 'instructor-card';
            newCard.dataset.index = newIndex;
            
            newCard.innerHTML = `
                <div class="instructor-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="instructor-number">${newIndex + 1}</div>
                        <h6 class="mb-0">Instructor ${newIndex + 1}</h6>
                    </div>
                    <button type="button" class="btn btn-sm btn-danger remove-instructor">
                        <i class="fas fa-trash"></i> Remove
                    </button>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="instructor_name[]" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" name="instructor_title[]" value="Instructor" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Profile Image (Optional)</label>
                        <input type="file" class="form-control" name="instructor_image[]" accept="image/*">
                        <div class="form-text">Max 2MB, JPG/PNG/WebP</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Image Alt Text (if image uploaded)</label>
                        <input type="text" class="form-control" name="instructor_image_alt[]" placeholder="e.g., Coach Smith - Karate Instructor">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Biography (separate paragraphs with double line breaks)</label>
                    <textarea class="form-control bio-textarea" name="instructor_bio[]" rows="6"></textarea>
                </div>
            `;
            
            container.appendChild(newCard);
            updateInstructorNumbers();
        });
        
        // Remove instructor
        container.addEventListener('click', function(e) {
            if (e.target.closest('.remove-instructor')) {
                if (confirm('Are you sure you want to remove this instructor?')) {
                    const card = e.target.closest('.instructor-card');
                    card.remove();
                    updateInstructorNumbers();
                }
            }
        });
        
        // Update instructor numbers
        function updateInstructorNumbers() {
            const cards = container.querySelectorAll('.instructor-card');
            cards.forEach((card, index) => {
                card.dataset.index = index;
                card.querySelector('.instructor-number').textContent = index + 1;
                card.querySelector('h6').textContent = `Instructor ${index + 1}`;
            });
        }
    });
    </script>
</body>
</html>