<?php
define('KAIZEN_ADMIN', true);
session_start();
require_once 'config.php';

// Require login
require_login();

$message = '';

// Load current belt exams data from draft
$content = load_json_data('site-content', 'draft');

// Default belt exams structure
$defaultBeltExams = [
    'hero' => [
        'title' => 'Belt Exam',
        'subtitle' => 'Traditional Belt Testing',
        'description' => 'Advancing through the ranks with authentic karate examination',
        'background_image' => 'assets/images/panels/belt-exams.jpg',
        'background_alt' => 'Kaizen Karate Belt Exam - Students testing for their next rank'
    ],
    'requirements' => [
        [
            'id' => 1,
            'icon' => 'fas fa-calendar-check',
            'title' => 'Pre-registration required.',
            'highlight' => '',
            'order' => 1
        ],
        [
            'id' => 2,
            'icon' => 'fas fa-user-shield',
            'title' => 'Belt exams are INVITATION ONLY events.',
            'highlight' => 'INVITATION ONLY',
            'order' => 2
        ],
        [
            'id' => 3,
            'icon' => 'fas fa-clock',
            'title' => 'Online registration closes 1 week prior to the belt exam.',
            'highlight' => '1 week prior',
            'order' => 3
        ],
        [
            'id' => 4,
            'icon' => 'fas fa-times-circle',
            'title' => 'Verbal approvals by instructors during class time are no longer accepted.',
            'highlight' => 'no longer accepted',
            'order' => 4
        ],
        [
            'id' => 5,
            'icon' => 'fas fa-envelope',
            'title' => 'ALL students must receive *written* approval directly from the Kaizen office team before starting the testing process.',
            'highlight' => '*written*',
            'order' => 5
        ]
    ],
    'accordions' => [
        [
            'id' => 'process',
            'title' => 'Testing Process',
            'icon' => 'fas fa-list-check',
            'order' => 1,
            'description' => 'Our belt testing process varies by belt level to ensure every student is properly prepared:',
            'content_type' => 'process',
            'process_sections' => [
                [
                    'id' => 'lower_belts',
                    'title' => 'Testing for White w/Black Stripe, Orange, or Yellow Belt',
                    'icon' => 'fas fa-medal',
                    'order' => 1,
                    'steps' => [
                        [
                            'title' => 'Pre-Testing Process',
                            'icon' => 'fas fa-user-check',
                            'description' => 'Instructor pre-tests during class time when they feel the student is ready to move up in rank. If the student is ready, the instructor will notify the Kaizen office team. Then, the Kaizen office team will email parents written approval for their child to test.'
                        ],
                        [
                            'title' => 'Live Testing',
                            'icon' => 'fas fa-users',
                            'description' => 'Please note: This test will be LIVE and in-person on the testing date in a group setting. If the student does not pass the in-class pre-test, they must wait until the instructor feels they are ready.'
                        ],
                        [
                            'title' => 'Registration & Testing Day',
                            'icon' => 'fas fa-clipboard-check',
                            'description' => 'Once you have received written approval to test, then the student must register for the test by clicking the link below. Show up for your belt exam on the scheduled date.'
                        ]
                    ]
                ],
                [
                    'id' => 'higher_belts',
                    'title' => 'Testing for Green Belt or Higher',
                    'icon' => 'fas fa-trophy',
                    'order' => 2,
                    'steps' => [
                        [
                            'title' => 'Pre-Testing Process',
                            'icon' => 'fas fa-user-check',
                            'description' => 'Instructor pre-tests during class time when they feel the student is ready to move up in rank. If the student is ready, the instructor sends written notification to the KK office team. Then, the KK office team will email the student directly with approval to test.'
                        ],
                        [
                            'title' => 'Video Testing Requirements',
                            'icon' => 'fas fa-video',
                            'description' => 'Once approved, students must register for the test by clicking the link below (include video links at the time of registration). Important: Sending your video as an attachment via email will NOT be accepted. Video feedback and testing results will only be sent back to the student after they have registered online using the link below.'
                        ],
                        [
                            'title' => 'Important Notes',
                            'icon' => 'fas fa-exclamation-triangle',
                            'description' => '*Please note: The video test for green belts and higher is now the actual test and is pass / fail. *After passing the video test, there is an in-person requirement for students testing for green belt and higher.'
                        ]
                    ]
                ]
            ]
        ],
        [
            'id' => 'requirements',
            'title' => 'Requirements to Test',
            'icon' => 'fas fa-clipboard-list',
            'order' => 2,
            'description' => 'View detailed testing requirements and matrices for each belt level:',
            'content_type' => 'requirements',
            'important_notice' => [
                'title' => 'Important Testing Requirements',
                'description' => 'The requirements listed below are minimums. Please keep in mind that the instructor of the class may require more than what is posted.',
                'additional_notes' => [
                    '*Students who train at Summer Camp only can test up to green belt rank.',
                    '*In order to test for purple belt and higher, student MUST attend weekend and / or evening classes year-round.'
                ]
            ],
            'requirement_images' => [
                [
                    'id' => 'testing_matrix',
                    'title' => 'Testing Matrix',
                    'icon' => 'fas fa-th',
                    'description' => 'Complete testing matrix with belt progression requirements',
                    'image' => 'assets/images/belt-exam/requirements-test/kaizen-testing-matrix.png',
                    'download_url' => 'assets/images/belt-exam/requirements-test/kaizen-testing-matrix.png',
                    'download_filename' => 'kaizen-testing-matrix.png',
                    'lightbox_function' => 'openMatrixLightbox',
                    'order' => 1
                ],
                [
                    'id' => 'testing_requirements',
                    'title' => 'Testing Requirements',
                    'icon' => 'fas fa-clipboard-list',
                    'description' => 'Detailed requirements for each belt level',
                    'image' => 'assets/images/belt-exam/requirements-test/kaizen-testing-requirement.png',
                    'download_url' => 'assets/images/belt-exam/requirements-test/kaizen-testing-requirement.png',
                    'download_filename' => 'kaizen-testing-requirement.png',
                    'lightbox_function' => 'openRequirementsLightbox',
                    'order' => 2
                ],
                [
                    'id' => 'stripe_system',
                    'title' => 'Stripe System',
                    'icon' => 'fas fa-star',
                    'description' => 'Belt stripe system and progression tracking',
                    'image' => 'assets/images/belt-exam/requirements-test/kaizen-testing-stripe-system.png',
                    'download_url' => 'assets/images/belt-exam/requirements-test/kaizen-testing-stripe-system.png',
                    'download_filename' => 'kaizen-testing-stripe-system.png',
                    'lightbox_function' => 'openStripeLightbox',
                    'order' => 3
                ]
            ]
        ],
        [
            'id' => 'clothing',
            'title' => 'Belt Exam Clothing Requirements',
            'icon' => 'fas fa-tshirt',
            'order' => 3,
            'description' => 'Proper uniform requirements for belt examinations by belt level:',
            'content_type' => 'clothing',
            'clothing_cards' => [
                [
                    'id' => 'white_belt',
                    'title' => 'White Belt with Black Stripe',
                    'belt_color' => 'white',
                    'stripe_color' => 'black',
                    'requirements' => [
                        'White karate gi (uniform)',
                        'Proper belt with black stripe',
                        'Clean and pressed uniform',
                        'Appropriate undergarments'
                    ],
                    'additional_notes' => 'Uniform must be clean and in good condition for testing.',
                    'order' => 1
                ],
                [
                    'id' => 'orange_belt',
                    'title' => 'Orange Belt',
                    'belt_color' => 'orange',
                    'stripe_color' => '',
                    'requirements' => [
                        'White karate gi (uniform)',
                        'Orange belt',
                        'Clean and pressed uniform',
                        'Appropriate undergarments'
                    ],
                    'additional_notes' => 'Orange belt should be properly tied and positioned.',
                    'order' => 2
                ],
                [
                    'id' => 'yellow_belt',
                    'title' => 'Yellow Belt',
                    'belt_color' => 'yellow',
                    'stripe_color' => '',
                    'requirements' => [
                        'White karate gi (uniform)',
                        'Yellow belt',
                        'Clean and pressed uniform',
                        'Appropriate undergarments'
                    ],
                    'additional_notes' => 'Ensure belt is the correct shade of yellow.',
                    'order' => 3
                ],
                [
                    'id' => 'green_belt',
                    'title' => 'Green Belt',
                    'belt_color' => 'green',
                    'stripe_color' => '',
                    'requirements' => [
                        'White karate gi (uniform)',
                        'Green belt',
                        'Clean and pressed uniform',
                        'Appropriate undergarments'
                    ],
                    'additional_notes' => 'Green belt represents intermediate level - maintain professional appearance.',
                    'order' => 4
                ]
            ],
            'shop_section' => [
                'title' => 'Shop for Karate Uniforms',
                'description' => 'Need to purchase a karate uniform or belt? Visit our recommended suppliers:',
                'shop_url' => 'https://www.karatesupply.com',
                'shop_button_text' => 'Shop Now'
            ]
        ],
        [
            'id' => 'scripts',
            'title' => 'Testing Scripts',
            'icon' => 'fas fa-scroll',
            'order' => 4,
            'description' => 'Access testing scripts, instructions, and helpful tips for belt examinations:',
            'content_type' => 'scripts',
            'script_cards' => [
                [
                    'id' => 'testing_tips',
                    'title' => 'Testing Tips',
                    'icon' => 'fas fa-lightbulb',
                    'description' => 'Essential filming and submission guidelines',
                    'lightbox_function' => 'openTestingTipsLightbox',
                    'belt_color' => '',
                    'order' => 1
                ],
                [
                    'id' => 'video_instructions',
                    'title' => 'Video Testing Instructions',
                    'icon' => 'fas fa-video',
                    'description' => 'Complete video testing process',
                    'lightbox_function' => 'openVideoInstructionsLightbox',
                    'belt_color' => '',
                    'order' => 2
                ],
                [
                    'id' => 'green_belt',
                    'title' => 'Green Belt Script',
                    'icon' => 'fas fa-scroll',
                    'description' => 'Green belt testing requirements',
                    'lightbox_function' => 'openGreenBeltLightbox',
                    'belt_color' => 'green',
                    'order' => 3
                ],
                [
                    'id' => 'purple_belt',
                    'title' => 'Purple Belt Script',
                    'icon' => 'fas fa-scroll',
                    'description' => 'Purple belt testing requirements',
                    'lightbox_function' => 'openPurpleBeltLightbox',
                    'belt_color' => 'purple',
                    'order' => 4
                ],
                [
                    'id' => 'blue_belt',
                    'title' => 'Blue Belt Script',
                    'icon' => 'fas fa-scroll',
                    'description' => 'Blue belt testing requirements',
                    'lightbox_function' => 'openBlueBeltLightbox',
                    'belt_color' => 'blue',
                    'order' => 5
                ],
                [
                    'id' => 'brown_belt',
                    'title' => 'Brown Belt Script',
                    'icon' => 'fas fa-scroll',
                    'description' => 'Brown belt testing requirements',
                    'lightbox_function' => 'openBrownBeltLightbox',
                    'belt_color' => 'brown',
                    'order' => 6
                ],
                [
                    'id' => 'brown_stripe',
                    'title' => 'Brown Belt w/ Black Stripe',
                    'icon' => 'fas fa-scroll',
                    'description' => 'Brown stripe testing requirements',
                    'lightbox_function' => 'openBrownStripeLightbox',
                    'belt_color' => 'brown',
                    'stripe_color' => 'black',
                    'order' => 7
                ],
                [
                    'id' => 'red_belt',
                    'title' => 'Red Belt Script',
                    'icon' => 'fas fa-scroll',
                    'description' => 'Red belt testing requirements',
                    'lightbox_function' => 'openRedBeltLightbox',
                    'belt_color' => 'red',
                    'order' => 8
                ],
                [
                    'id' => 'red_stripe',
                    'title' => 'Red Belt w/ Black Stripe',
                    'icon' => 'fas fa-scroll',
                    'description' => 'Red stripe testing requirements',
                    'lightbox_function' => 'openRedStripeLightbox',
                    'belt_color' => 'red',
                    'stripe_color' => 'black',
                    'order' => 9
                ]
            ],
            'important_note' => [
                'title' => 'Important Note',
                'icon' => 'fas fa-info-circle',
                'description' => 'Click any card above to view detailed information. Testing scripts are provided as study guides.',
                'additional_text' => 'Actual testing may vary based on instructor discretion and individual student needs.'
            ]
        ],
        [
            'id' => 'dates',
            'title' => 'Upcoming Testing Dates',
            'icon' => 'fas fa-calendar-alt',
            'order' => 5,
            'description' => 'Schedule and register for upcoming belt examinations:',
            'content_type' => 'dates',
            'date_cards' => [
                [
                    'id' => 'date_1',
                    'month_year' => 'November 2025',
                    'icon' => 'fas fa-calendar-day',
                    'location_name' => 'East Silver Spring ES - GYM',
                    'street_address' => '631 Silver Spring Ave',
                    'city_state_zip' => 'Silver Spring, MD 20910',
                    'datetime_string' => 'Saturday, November 15th - 11:00 AM Start Time',
                    'link_text' => 'For more details and registration, click here',
                    'makeup_month' => 'January 2026',
                    'youth_note' => '*Youth testing takes place on Saturdays',
                    'adult_note' => '*Adult testing takes place on Monday nights',
                    'video_note' => 'Video tests due 1 month prior to testing date (green belt and above). NO EXCEPTIONS.',
                    'order' => 1
                ],
                [
                    'id' => 'date_2',
                    'month_year' => 'January 2026',
                    'icon' => 'fas fa-calendar-day',
                    'location_name' => 'East Silver Spring ES - GYM',
                    'street_address' => '631 Silver Spring Ave',
                    'city_state_zip' => 'Silver Spring, MD 20910',
                    'datetime_string' => 'TIME & DATE - TBA',
                    'link_text' => 'For more details and registration, click here',
                    'makeup_month' => 'March 2026',
                    'youth_note' => '*Youth testing takes place on Saturdays',
                    'adult_note' => '*Adult testing takes place on Monday nights',
                    'video_note' => 'Video tests due 1 month prior to testing date (green belt and above). NO EXCEPTIONS.',
                    'order' => 2
                ],
                [
                    'id' => 'date_3',
                    'month_year' => 'March 2026',
                    'icon' => 'fas fa-calendar-day',
                    'location_name' => 'East Silver Spring ES - GYM',
                    'street_address' => '631 Silver Spring Ave',
                    'city_state_zip' => 'Silver Spring, MD 20910',
                    'datetime_string' => 'TIME & DATE - TBA',
                    'link_text' => 'For more details and registration, click here',
                    'makeup_month' => 'May 2026',
                    'youth_note' => '*Youth testing takes place on Saturdays',
                    'adult_note' => '*Adult testing takes place on Monday nights',
                    'video_note' => 'Video tests due 1 month prior to testing date (green belt and above). NO EXCEPTIONS.',
                    'order' => 3
                ],
                [
                    'id' => 'date_4',
                    'month_year' => 'March 2026',
                    'icon' => 'fas fa-calendar-day',
                    'location_name' => 'East Silver Spring ES - GYM',
                    'street_address' => '631 Silver Spring Ave',
                    'city_state_zip' => 'Silver Spring, MD 20910',
                    'datetime_string' => 'TIME & DATE - TBA',
                    'link_text' => 'For more details and registration, click here',
                    'makeup_month' => 'May 2026',
                    'youth_note' => '*Youth testing takes place on Saturdays',
                    'adult_note' => '*Adult testing takes place on Monday nights',
                    'video_note' => 'Video tests due 1 month prior to testing date (green belt and above). NO EXCEPTIONS.',
                    'order' => 4
                ],
                [
                    'id' => 'date_5',
                    'month_year' => 'May 2026',
                    'icon' => 'fas fa-calendar-day',
                    'location_name' => 'East Silver Spring ES - GYM',
                    'street_address' => '631 Silver Spring Ave',
                    'city_state_zip' => 'Silver Spring, MD 20910',
                    'datetime_string' => 'TIME & DATE - TBA',
                    'link_text' => 'For more details and registration, click here',
                    'makeup_month' => 'September 2025',
                    'youth_note' => '*Youth testing takes place on Saturdays',
                    'adult_note' => '*Adult testing takes place on Monday nights',
                    'video_note' => 'Video tests due 1 month prior to testing date (green belt and above). NO EXCEPTIONS.',
                    'order' => 5
                ],
                [
                    'id' => 'date_6',
                    'month_year' => 'September 2026',
                    'icon' => 'fas fa-calendar-day',
                    'location_name' => 'East Silver Spring ES - GYM',
                    'street_address' => '631 Silver Spring Ave',
                    'city_state_zip' => 'Silver Spring, MD 20910',
                    'datetime_string' => 'TIME & DATE - TBA',
                    'link_text' => 'For more details and registration, click here',
                    'makeup_month' => 'November 2026',
                    'youth_note' => '*Youth testing takes place on Saturdays',
                    'adult_note' => '*Adult testing takes place on Monday nights',
                    'video_note' => 'Video tests due 1 month prior to testing date (green belt and above). NO EXCEPTIONS.',
                    'order' => 6
                ]
            ]
        ],
        [
            'id' => 'registration',
            'title' => 'Register for Belt Exam',
            'icon' => 'fas fa-user-plus',
            'order' => 6,
            'description' => 'Register for upcoming belt examinations by time slot and belt level:',
            'content_type' => 'registration',
            'registration_cards' => [
                [
                    'id' => 'registration_1',
                    'title' => '11:00 AM - White Belts',
                    'time_slot' => '11:00',
                    'belt_levels' => 'White belts with black stripe only',
                    'location' => 'Main Dojo',
                    'description' => 'Testing session for white belt students with black stripe. Pre-approval required.',
                    'status' => 'open',
                    'icon' => 'fas fa-clock',
                    'registration_link' => 'https://example.com/register/11am-white',
                    'notes' => 'Instructor pre-approval required',
                    'order' => 1
                ],
                [
                    'id' => 'registration_2',
                    'title' => '12:00 PM - Orange & Yellow Belts',
                    'time_slot' => '12:00',
                    'belt_levels' => 'Orange and Yellow belt students',
                    'location' => 'Main Dojo',
                    'description' => 'Testing session for orange and yellow belt students. Written approval required.',
                    'status' => 'open',
                    'icon' => 'fas fa-users',
                    'registration_link' => 'https://example.com/register/12pm-orange-yellow',
                    'notes' => 'Written approval from office required',
                    'order' => 2
                ],
                [
                    'id' => 'registration_3',
                    'title' => '1:00 PM - Green Belt & Higher',
                    'time_slot' => '13:00',
                    'belt_levels' => 'Green, Purple, Blue, Brown, and Red belt students',
                    'location' => 'Main Dojo',
                    'description' => 'Testing session for advanced belt students. Video submission and in-person requirements.',
                    'status' => 'open',
                    'icon' => 'fas fa-star',
                    'registration_link' => 'https://example.com/register/1pm-advanced',
                    'notes' => 'Video submission required prior to testing',
                    'order' => 3
                ]
            ]
        ]
    ],
    'lightboxes' => [
        [
            'id' => 'testing_tips',
            'title' => 'Testing Tips',
            'trigger_function' => 'openTestingTipsLightbox',
            'content_type' => 'info',
            'content' => [
                'title' => 'Essential Testing Tips',
                'description' => 'Important filming and submission guidelines for your belt examination.',
                'image' => '',
                'text_content' => 'Content will be provided soon...'
            ]
        ],
        [
            'id' => 'video_instructions',
            'title' => 'Video Testing Instructions',
            'trigger_function' => 'openVideoInstructionsLightbox',
            'content_type' => 'info',
            'content' => [
                'title' => 'Video Testing Instructions',
                'description' => 'Complete video testing process guidelines.',
                'image' => '',
                'text_content' => 'Detailed video testing instructions will be provided...'
            ]
        ],
        [
            'id' => 'green_belt_script',
            'title' => 'Green Belt Script',
            'trigger_function' => 'openGreenBeltLightbox',
            'content_type' => 'script',
            'content' => [
                'title' => 'Green Belt Testing Script',
                'description' => 'Complete testing requirements for green belt examination.',
                'image' => '',
                'text_content' => 'Green belt testing script content...'
            ]
        ],
        [
            'id' => 'purple_belt_script',
            'title' => 'Purple Belt Script',
            'trigger_function' => 'openPurpleBeltLightbox',
            'content_type' => 'script',
            'content' => [
                'title' => 'Purple Belt Testing Script',
                'description' => 'Complete testing requirements for purple belt examination.',
                'image' => '',
                'text_content' => 'Purple belt testing script content...'
            ]
        ],
        [
            'id' => 'blue_belt_script',
            'title' => 'Blue Belt Script',
            'trigger_function' => 'openBlueBeltLightbox',
            'content_type' => 'script',
            'content' => [
                'title' => 'Blue Belt Testing Script',
                'description' => 'Complete testing requirements for blue belt examination.',
                'image' => '',
                'text_content' => 'Blue belt testing script content...'
            ]
        ],
        [
            'id' => 'brown_belt_script',
            'title' => 'Brown Belt Script',
            'trigger_function' => 'openBrownBeltLightbox',
            'content_type' => 'script',
            'content' => [
                'title' => 'Brown Belt Testing Script',
                'description' => 'Complete testing requirements for brown belt examination.',
                'image' => '',
                'text_content' => 'Brown belt testing script content...'
            ]
        ],
        [
            'id' => 'brown_stripe_script',
            'title' => 'Brown Belt w/ Black Stripe Script',
            'trigger_function' => 'openBrownStripeLightbox',
            'content_type' => 'script',
            'content' => [
                'title' => 'Brown Belt w/ Black Stripe Testing Script',
                'description' => 'Complete testing requirements for brown belt with black stripe examination.',
                'image' => '',
                'text_content' => 'Brown belt with black stripe testing script content...'
            ]
        ],
        [
            'id' => 'red_belt_script',
            'title' => 'Red Belt Script',
            'trigger_function' => 'openRedBeltLightbox',
            'content_type' => 'script',
            'content' => [
                'title' => 'Red Belt Testing Script',
                'description' => 'Complete testing requirements for red belt examination.',
                'image' => '',
                'text_content' => 'Red belt testing script content...'
            ]
        ],
        [
            'id' => 'red_stripe_script',
            'title' => 'Red Belt w/ Black Stripe Script',
            'trigger_function' => 'openRedStripeLightbox',
            'content_type' => 'script',
            'content' => [
                'title' => 'Red Belt w/ Black Stripe Testing Script',
                'description' => 'Complete testing requirements for red belt with black stripe examination.',
                'image' => '',
                'text_content' => 'Red belt with black stripe testing script content...'
            ]
        ]
    ]
];

// Initialize belt_exams if it doesn't exist
if (!isset($content['belt_exams'])) {
    $content['belt_exams'] = $defaultBeltExams;
}

// Ensure all sections exist
$beltExamsData = $content['belt_exams'];
if (!isset($beltExamsData['hero'])) {
    $beltExamsData['hero'] = $defaultBeltExams['hero'];
}
if (!isset($beltExamsData['requirements'])) {
    $beltExamsData['requirements'] = $defaultBeltExams['requirements'];
}
if (!isset($beltExamsData['accordions'])) {
    $beltExamsData['accordions'] = [];
}
if (!isset($beltExamsData['lightboxes'])) {
    $beltExamsData['lightboxes'] = [];
}

// Handle delete requirement
if (isset($_POST['delete_requirement']) && isset($_POST['requirement_id']) && verify_csrf_token($_POST['csrf_token'] ?? '')) {
    $requirementId = (int)$_POST['requirement_id'];
    
    // Remove requirement with matching ID
    $beltExamsData['requirements'] = array_filter($beltExamsData['requirements'], function($req) use ($requirementId) {
        return $req['id'] !== $requirementId;
    });
    
    // Re-index array
    $beltExamsData['requirements'] = array_values($beltExamsData['requirements']);
    
    // Save data
    $content['belt_exams'] = $beltExamsData;
    if (save_json_data('site-content', $content, 'draft')) {
        $message = success_message('Requirement deleted from draft successfully!');
    } else {
        $message = error_message('Failed to delete requirement.');
    }
}

// Handle form submission
if ($_POST && verify_csrf_token($_POST['csrf_token'] ?? '')) {
    
    // Update Hero Section
    if (isset($_POST['action']) && $_POST['action'] === 'hero') {
        $beltExamsData['hero'] = [
            'title' => $_POST['hero_title'] ?? $defaultBeltExams['hero']['title'],
            'subtitle' => $_POST['hero_subtitle'] ?? $defaultBeltExams['hero']['subtitle'],
            'description' => $_POST['hero_description'] ?? $defaultBeltExams['hero']['description'],
            'background_image' => $beltExamsData['hero']['background_image'] ?? $defaultBeltExams['hero']['background_image'],
            'background_alt' => $_POST['hero_background_alt'] ?? $defaultBeltExams['hero']['background_alt']
        ];
        
        // Handle background image upload
        if (isset($_FILES['hero_background_image']) && $_FILES['hero_background_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../assets/images/belt-exam/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $fileInfo = pathinfo($_FILES['hero_background_image']['name']);
            $extension = strtolower($fileInfo['extension']);
            
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                $fileName = 'hero-background.' . $extension;
                $uploadPath = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['hero_background_image']['tmp_name'], $uploadPath)) {
                    $beltExamsData['hero']['background_image'] = 'assets/images/belt-exam/' . $fileName;
                }
            }
        }
        
        // Save data
        $content['belt_exams'] = $beltExamsData;
        
        if (save_json_data('site-content', $content, 'draft')) {
            $message = success_message('Belt Exams hero section saved to draft successfully!');
        } else {
            $message = error_message('Failed to save changes. Please check file permissions.');
        }
    }
    
    // Update Requirements
    if (isset($_POST['action']) && $_POST['action'] === 'requirements') {
        $requirements = [];
        
        if (isset($_POST['requirement_id']) && is_array($_POST['requirement_id'])) {
            foreach ($_POST['requirement_id'] as $index => $id) {
                $requirements[] = [
                    'id' => (int)$id,
                    'icon' => $_POST['requirement_icon'][$index] ?? 'fas fa-info-circle',
                    'title' => $_POST['requirement_title'][$index] ?? '',
                    'highlight' => $_POST['requirement_highlight'][$index] ?? '',
                    'order' => (int)($_POST['requirement_order'][$index] ?? ($index + 1))
                ];
            }
        }
        
        $beltExamsData['requirements'] = $requirements;
        
        // Save data
        $content['belt_exams'] = $beltExamsData;
        
        if (save_json_data('site-content', $content, 'draft')) {
            $message = success_message('Belt Exams requirements saved to draft successfully!');
        } else {
            $message = error_message('Failed to save changes. Please check file permissions.');
        }
    }
    
    // Update Accordions (Testing Process Pilot)
    if (isset($_POST['action']) && $_POST['action'] === 'accordion_process') {
        $accordionData = [
            'id' => 'process',
            'title' => $_POST['accordion_title'] ?? 'Testing Process',
            'icon' => $_POST['accordion_icon'] ?? 'fas fa-list-check',
            'order' => 1,
            'description' => $_POST['accordion_description'] ?? '',
            'content_type' => 'process',
            'process_sections' => []
        ];
        
        // Process sections data
        if (isset($_POST['section_id']) && is_array($_POST['section_id'])) {
            foreach ($_POST['section_id'] as $index => $sectionId) {
                $steps = [];
                
                // Process steps for this section
                if (isset($_POST['step_title'][$index]) && is_array($_POST['step_title'][$index])) {
                    foreach ($_POST['step_title'][$index] as $stepIndex => $stepTitle) {
                        if (!empty($stepTitle)) {
                            $steps[] = [
                                'title' => $stepTitle,
                                'icon' => $_POST['step_icon'][$index][$stepIndex] ?? 'fas fa-info-circle',
                                'description' => $_POST['step_description'][$index][$stepIndex] ?? ''
                            ];
                        }
                    }
                }
                
                $accordionData['process_sections'][] = [
                    'id' => $sectionId,
                    'title' => $_POST['section_title'][$index] ?? '',
                    'icon' => $_POST['section_icon'][$index] ?? 'fas fa-medal',
                    'order' => $index + 1,
                    'steps' => $steps
                ];
            }
        }
        
        // Update the process accordion in the accordions array
        $existingAccordions = $beltExamsData['accordions'] ?? [];
        $updatedAccordions = [];
        
        // Keep other accordions, replace process accordion
        foreach ($existingAccordions as $accordion) {
            if ($accordion['id'] !== 'process') {
                $updatedAccordions[] = $accordion;
            }
        }
        
        // Add updated process accordion
        $updatedAccordions[] = $accordionData;
        
        // Sort by order
        usort($updatedAccordions, function($a, $b) {
            return ($a['order'] ?? 0) - ($b['order'] ?? 0);
        });
        
        $beltExamsData['accordions'] = $updatedAccordions;
        
        // Save data
        $content['belt_exams'] = $beltExamsData;
        
        if (save_json_data('site-content', $content, 'draft')) {
            $message = success_message('Belt Exams testing process accordion saved to draft successfully!');
        } else {
            $message = error_message('Failed to save changes. Please check file permissions.');
        }
    }
    
    // Update Lightboxes (Basic System)
    if (isset($_POST['action']) && $_POST['action'] === 'lightboxes') {
        $lightboxes = [];
        
        if (isset($_POST['lightbox_id']) && is_array($_POST['lightbox_id'])) {
            foreach ($_POST['lightbox_id'] as $index => $lightboxId) {
                $lightboxes[] = [
                    'id' => $lightboxId,
                    'title' => $_POST['lightbox_title'][$index] ?? '',
                    'trigger_function' => $_POST['lightbox_trigger'][$index] ?? '',
                    'content_type' => $_POST['lightbox_content_type'][$index] ?? 'info',
                    'content' => [
                        'title' => $_POST['lightbox_content_title'][$index] ?? '',
                        'description' => $_POST['lightbox_content_description'][$index] ?? '',
                        'image' => $beltExamsData['lightboxes'][$index]['content']['image'] ?? '',
                        'text_content' => $_POST['lightbox_text_content'][$index] ?? ''
                    ]
                ];
            }
        }
        
        $beltExamsData['lightboxes'] = $lightboxes;
        
        // Save data
        $content['belt_exams'] = $beltExamsData;
        
        if (save_json_data('site-content', $content, 'draft')) {
            $message = success_message('Belt Exams lightboxes saved to draft successfully!');
        } else {
            $message = error_message('Failed to save changes. Please check file permissions.');
        }
    }
    
    // Update Requirements to Test Accordion
    if (isset($_POST['action']) && $_POST['action'] === 'accordion_requirements') {
        $accordionData = [
            'id' => 'requirements',
            'title' => $_POST['requirements_accordion_title'] ?? 'Requirements to Test',
            'icon' => $_POST['requirements_accordion_icon'] ?? 'fas fa-clipboard-list',
            'order' => 2,
            'description' => $_POST['requirements_accordion_description'] ?? '',
            'content_type' => 'requirements',
            'important_notice' => [
                'title' => $_POST['notice_title'] ?? 'Important Testing Requirements',
                'description' => $_POST['notice_description'] ?? '',
                'additional_notes' => []
            ],
            'requirement_images' => []
        ];
        
        // Process additional notes
        if (isset($_POST['additional_note']) && is_array($_POST['additional_note'])) {
            foreach ($_POST['additional_note'] as $note) {
                if (!empty(trim($note))) {
                    $accordionData['important_notice']['additional_notes'][] = trim($note);
                }
            }
        }
        
        // Process requirement images
        if (isset($_POST['req_image_id']) && is_array($_POST['req_image_id'])) {
            foreach ($_POST['req_image_id'] as $index => $imageId) {
                $requirementImage = [
                    'id' => $imageId,
                    'title' => $_POST['req_image_title'][$index] ?? '',
                    'icon' => $_POST['req_image_icon'][$index] ?? 'fas fa-image',
                    'description' => $_POST['req_image_description'][$index] ?? '',
                    'image' => $_POST['req_image_path'][$index] ?? '',
                    'download_url' => $_POST['req_download_url'][$index] ?? '',
                    'download_filename' => $_POST['req_download_filename'][$index] ?? '',
                    'lightbox_function' => $_POST['req_lightbox_function'][$index] ?? '',
                    'order' => (int)($_POST['req_image_order'][$index] ?? ($index + 1))
                ];
                
                // Handle image upload
                if (isset($_FILES['req_image_file']['name'][$index]) && 
                    $_FILES['req_image_file']['error'][$index] === UPLOAD_ERR_OK) {
                    
                    $uploadDir = '../assets/images/belt-exam/requirements-test/';
                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    
                    $fileInfo = pathinfo($_FILES['req_image_file']['name'][$index]);
                    $extension = strtolower($fileInfo['extension']);
                    
                    if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                        $fileName = $imageId . '.' . $extension;
                        $uploadPath = $uploadDir . $fileName;
                        
                        if (move_uploaded_file($_FILES['req_image_file']['tmp_name'][$index], $uploadPath)) {
                            $requirementImage['image'] = 'assets/images/belt-exam/requirements-test/' . $fileName;
                            // Set download URL to same image if not specified
                            if (empty($requirementImage['download_url'])) {
                                $requirementImage['download_url'] = $requirementImage['image'];
                            }
                        }
                    }
                }
                
                $accordionData['requirement_images'][] = $requirementImage;
            }
        }
        
        // Update the requirements accordion in the accordions array
        $existingAccordions = $beltExamsData['accordions'] ?? [];
        $updatedAccordions = [];
        
        // Keep other accordions, replace requirements accordion
        foreach ($existingAccordions as $accordion) {
            if ($accordion['id'] !== 'requirements') {
                $updatedAccordions[] = $accordion;
            }
        }
        
        // Add updated requirements accordion
        $updatedAccordions[] = $accordionData;
        
        // Sort by order
        usort($updatedAccordions, function($a, $b) {
            return ($a['order'] ?? 0) - ($b['order'] ?? 0);
        });
        
        $beltExamsData['accordions'] = $updatedAccordions;
        
        // Save data
        $content['belt_exams'] = $beltExamsData;
        
        if (save_json_data('site-content', $content, 'draft')) {
            $message = success_message('Belt Exams requirements accordion saved to draft successfully!');
        } else {
            $message = error_message('Failed to save changes. Please check file permissions.');
        }
    }
    
    // Update Belt Exam Clothing Requirements Accordion
    if (isset($_POST['action']) && $_POST['action'] === 'accordion_clothing') {
        $accordionData = [
            'id' => 'clothing',
            'title' => $_POST['clothing_accordion_title'] ?? 'Belt Exam Clothing Requirements',
            'icon' => $_POST['clothing_accordion_icon'] ?? 'fas fa-tshirt',
            'order' => 3,
            'description' => $_POST['clothing_accordion_description'] ?? '',
            'content_type' => 'clothing',
            'clothing_cards' => [],
            'shop_section' => [
                'title' => $_POST['shop_title'] ?? 'Shop for Karate Uniforms',
                'description' => $_POST['shop_description'] ?? '',
                'shop_url' => $_POST['shop_url'] ?? '',
                'shop_button_text' => $_POST['shop_button_text'] ?? 'Shop Now'
            ]
        ];
        
        // Process clothing cards
        if (isset($_POST['clothing_card_id']) && is_array($_POST['clothing_card_id'])) {
            foreach ($_POST['clothing_card_id'] as $index => $cardId) {
                $requirements = [];
                
                // Process requirements for this card
                if (isset($_POST['clothing_requirements'][$index]) && is_array($_POST['clothing_requirements'][$index])) {
                    foreach ($_POST['clothing_requirements'][$index] as $requirement) {
                        if (!empty(trim($requirement))) {
                            $requirements[] = trim($requirement);
                        }
                    }
                }
                
                $clothingCard = [
                    'id' => $cardId,
                    'title' => $_POST['clothing_card_title'][$index] ?? '',
                    'belt_color' => $_POST['clothing_belt_color'][$index] ?? '',
                    'stripe_color' => $_POST['clothing_stripe_color'][$index] ?? '',
                    'requirements' => $requirements,
                    'additional_notes' => $_POST['clothing_additional_notes'][$index] ?? '',
                    'order' => (int)($_POST['clothing_card_order'][$index] ?? ($index + 1))
                ];
                
                $accordionData['clothing_cards'][] = $clothingCard;
            }
        }
        
        // Update the clothing accordion in the accordions array
        $existingAccordions = $beltExamsData['accordions'] ?? [];
        $updatedAccordions = [];
        
        // Keep other accordions, replace clothing accordion
        foreach ($existingAccordions as $accordion) {
            if ($accordion['id'] !== 'clothing') {
                $updatedAccordions[] = $accordion;
            }
        }
        
        // Add updated clothing accordion
        $updatedAccordions[] = $accordionData;
        
        // Sort by order
        usort($updatedAccordions, function($a, $b) {
            return ($a['order'] ?? 0) - ($b['order'] ?? 0);
        });
        
        $beltExamsData['accordions'] = $updatedAccordions;
        
        // Save data
        $content['belt_exams'] = $beltExamsData;
        
        if (save_json_data('site-content', $content, 'draft')) {
            $message = success_message('Belt Exams clothing requirements accordion saved to draft successfully!');
        } else {
            $message = error_message('Failed to save changes. Please check file permissions.');
        }
    }
    
    // Update Testing Scripts Accordion
    if (isset($_POST['action']) && $_POST['action'] === 'accordion_scripts') {
        $accordionData = [
            'id' => 'scripts',
            'title' => $_POST['scripts_accordion_title'] ?? 'Testing Scripts',
            'icon' => $_POST['scripts_accordion_icon'] ?? 'fas fa-scroll',
            'order' => 4,
            'description' => $_POST['scripts_accordion_description'] ?? '',
            'content_type' => 'scripts',
            'script_cards' => [],
            'important_note' => [
                'title' => $_POST['note_title'] ?? 'Important Note',
                'icon' => $_POST['note_icon'] ?? 'fas fa-info-circle',
                'description' => $_POST['note_description'] ?? '',
                'additional_text' => $_POST['note_additional_text'] ?? ''
            ]
        ];
        
        // Process script cards
        if (isset($_POST['script_card_id']) && is_array($_POST['script_card_id'])) {
            foreach ($_POST['script_card_id'] as $index => $cardId) {
                $scriptCard = [
                    'id' => $cardId,
                    'title' => $_POST['script_card_title'][$index] ?? '',
                    'icon' => $_POST['script_card_icon'][$index] ?? 'fas fa-scroll',
                    'description' => $_POST['script_card_description'][$index] ?? '',
                    'lightbox_function' => $_POST['script_lightbox_function'][$index] ?? '',
                    'belt_color' => $_POST['script_belt_color'][$index] ?? '',
                    'stripe_color' => $_POST['script_stripe_color'][$index] ?? '',
                    'order' => (int)($_POST['script_card_order'][$index] ?? ($index + 1))
                ];
                
                $accordionData['script_cards'][] = $scriptCard;
            }
        }
        
        // Update the scripts accordion in the accordions array
        $existingAccordions = $beltExamsData['accordions'] ?? [];
        $updatedAccordions = [];
        
        // Keep other accordions, replace scripts accordion
        foreach ($existingAccordions as $accordion) {
            if ($accordion['id'] !== 'scripts') {
                $updatedAccordions[] = $accordion;
            }
        }
        
        // Add updated scripts accordion
        $updatedAccordions[] = $accordionData;
        
        // Sort by order
        usort($updatedAccordions, function($a, $b) {
            return ($a['order'] ?? 0) - ($b['order'] ?? 0);
        });
        
        $beltExamsData['accordions'] = $updatedAccordions;
        
        // Save data
        $content['belt_exams'] = $beltExamsData;
        
        if (save_json_data('site-content', $content, 'draft')) {
            $message = success_message('Belt Exams testing scripts accordion saved to draft successfully!');
        } else {
            $message = error_message('Failed to save changes. Please check file permissions.');
        }
    }
    
    // Update Upcoming Testing Dates Accordion
    if (isset($_POST['action']) && $_POST['action'] === 'accordion_dates') {
        $accordionData = [
            'id' => 'dates',
            'title' => $_POST['dates_accordion_title'] ?? 'Upcoming Testing Dates',
            'icon' => $_POST['dates_accordion_icon'] ?? 'fas fa-calendar-alt',
            'order' => 5,
            'description' => $_POST['dates_accordion_description'] ?? '',
            'content_type' => 'dates',
            'date_cards' => []
        ];
        
        // Process date cards with new frontend-matching structure
        if (isset($_POST['date_card_id']) && is_array($_POST['date_card_id'])) {
            foreach ($_POST['date_card_id'] as $index => $cardId) {
                $dateCard = [
                    'id' => $cardId,
                    'month_year' => $_POST['date_card_month_year'][$index] ?? '',
                    'icon' => $_POST['date_card_icon'][$index] ?? 'fas fa-calendar-day',
                    'location_name' => $_POST['date_card_location_name'][$index] ?? '',
                    'street_address' => $_POST['date_card_street_address'][$index] ?? '',
                    'city_state_zip' => $_POST['date_card_city_state_zip'][$index] ?? '',
                    'datetime_string' => $_POST['date_card_datetime_string'][$index] ?? '',
                    'link_text' => $_POST['date_card_link_text'][$index] ?? 'For more details and registration, click here',
                    'makeup_month' => $_POST['date_card_makeup_month'][$index] ?? '',
                    'youth_note' => $_POST['date_card_youth_note'][$index] ?? '*Youth testing takes place on Saturdays',
                    'adult_note' => $_POST['date_card_adult_note'][$index] ?? '*Adult testing takes place on Monday nights',
                    'video_note' => $_POST['date_card_video_note'][$index] ?? 'Video tests due 1 month prior to testing date (green belt and above). NO EXCEPTIONS.',
                    'order' => (int)($_POST['date_card_order'][$index] ?? ($index + 1))
                ];
                
                $accordionData['date_cards'][] = $dateCard;
            }
        }
        
        // Update the dates accordion in the accordions array
        $existingAccordions = $beltExamsData['accordions'] ?? [];
        $updatedAccordions = [];
        
        // Keep other accordions, replace dates accordion
        foreach ($existingAccordions as $accordion) {
            if ($accordion['id'] !== 'dates') {
                $updatedAccordions[] = $accordion;
            }
        }
        
        // Add updated dates accordion
        $updatedAccordions[] = $accordionData;
        
        // Sort by order
        usort($updatedAccordions, function($a, $b) {
            return ($a['order'] ?? 0) - ($b['order'] ?? 0);
        });
        
        $beltExamsData['accordions'] = $updatedAccordions;
        
        // Save data
        $content['belt_exams'] = $beltExamsData;
        
        if (save_json_data('site-content', $content, 'draft')) {
            $message = success_message('Belt Exams testing dates accordion saved to draft successfully!');
        } else {
            $message = error_message('Failed to save changes. Please check file permissions.');
        }
    }
    
    // Update Register for Belt Exam Accordion
    if (isset($_POST['action']) && $_POST['action'] === 'accordion_registration') {
        $accordionData = [
            'id' => 'registration',
            'title' => $_POST['registration_accordion_title'] ?? 'Register for Belt Exam',
            'icon' => $_POST['registration_accordion_icon'] ?? 'fas fa-user-plus',
            'order' => 6,
            'description' => $_POST['registration_accordion_description'] ?? '',
            'content_type' => 'registration',
            'registration_cards' => []
        ];
        
        // Process registration cards
        if (isset($_POST['registration_card_id']) && is_array($_POST['registration_card_id'])) {
            foreach ($_POST['registration_card_id'] as $index => $cardId) {
                $registrationCard = [
                    'id' => $cardId,
                    'title' => $_POST['registration_card_title'][$index] ?? '',
                    'time_slot' => $_POST['registration_card_time'][$index] ?? '',
                    'belt_levels' => $_POST['registration_card_belt_levels'][$index] ?? '',
                    'location' => $_POST['registration_card_location'][$index] ?? '',
                    'description' => $_POST['registration_card_description'][$index] ?? '',
                    'status' => $_POST['registration_card_status'][$index] ?? 'open',
                    'icon' => $_POST['registration_card_icon'][$index] ?? 'fas fa-clock',
                    'registration_link' => $_POST['registration_card_link'][$index] ?? '',
                    'notes' => $_POST['registration_card_notes'][$index] ?? '',
                    'order' => (int)($_POST['registration_card_order'][$index] ?? ($index + 1))
                ];
                
                $accordionData['registration_cards'][] = $registrationCard;
            }
        }
        
        // Update the registration accordion in the accordions array
        $existingAccordions = $beltExamsData['accordions'] ?? [];
        $updatedAccordions = [];
        
        // Keep other accordions, replace registration accordion
        foreach ($existingAccordions as $accordion) {
            if ($accordion['id'] !== 'registration') {
                $updatedAccordions[] = $accordion;
            }
        }
        
        // Add updated registration accordion
        $updatedAccordions[] = $accordionData;
        
        // Sort by order
        usort($updatedAccordions, function($a, $b) {
            return ($a['order'] ?? 0) - ($b['order'] ?? 0);
        });
        
        $beltExamsData['accordions'] = $updatedAccordions;
        
        // Save data
        $content['belt_exams'] = $beltExamsData;
        
        if (save_json_data('site-content', $content, 'draft')) {
            $message = success_message('Belt Exams registration accordion saved to draft successfully!');
        } else {
            $message = error_message('Failed to save changes. Please check file permissions.');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Belt Exams Management - Kaizen Karate Admin</title>
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
        
        .current-image-preview {
            max-width: 300px;
            height: auto;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            margin-top: 0.5rem;
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
        
        .requirement-card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            background: #f8f9fa;
            position: relative;
        }
        
        .requirement-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #dee2e6;
        }
        
        .requirement-number {
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
        
        .icon-select {
            font-family: 'Font Awesome 6 Free', monospace;
        }
        
        #add-requirement-btn {
            background: #28a745;
            border-color: #28a745;
            color: white;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
        }
        
        #add-requirement-btn:hover {
            background: #218838;
            border-color: #218838;
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
                    <h1><i class="fas fa-medal me-2 text-primary"></i>Belt Exams Management</h1>
                </div>
                
                <?php echo $message; ?>
                
                <!-- Hero Section -->
                <div class="content-section">
                    <h3 class="section-title"><i class="fas fa-image me-2"></i>Hero Section</h3>
                    
                    <div class="instructions-box">
                        <h6><i class="fas fa-info-circle"></i> Instructions</h6>
                        <ul>
                            <li>This hero section appears at the top of the Belt Exams page</li>
                            <li>The background image should be high-quality and related to belt testing</li>
                            <li>Keep the title and subtitle concise but impactful</li>
                            <li>The description provides context for visitors about the belt testing process</li>
                        </ul>
                    </div>
                    
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                        <input type="hidden" name="action" value="hero">
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="hero_title" class="form-label">Title</label>
                                    <input type="text" class="form-control" id="hero_title" name="hero_title"
                                           value="<?php echo htmlspecialchars($beltExamsData['hero']['title'] ?? ''); ?>" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="hero_subtitle" class="form-label">Subtitle</label>
                                    <input type="text" class="form-control" id="hero_subtitle" name="hero_subtitle"
                                           value="<?php echo htmlspecialchars($beltExamsData['hero']['subtitle'] ?? ''); ?>" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="hero_description" class="form-label">Description</label>
                                    <textarea class="form-control" id="hero_description" name="hero_description" rows="3" required><?php echo htmlspecialchars($beltExamsData['hero']['description'] ?? ''); ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="hero_background_image" class="form-label">Background Image</label>
                                    <input type="file" class="form-control" id="hero_background_image" name="hero_background_image" accept="image/*">
                                    <div class="form-text">Max 2MB, JPG/PNG/WebP</div>
                                    <?php if (!empty($beltExamsData['hero']['background_image'])): ?>
                                        <img src="../<?php echo htmlspecialchars($beltExamsData['hero']['background_image']); ?>" 
                                             alt="Current background image" class="current-image-preview">
                                    <?php endif; ?>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="hero_background_alt" class="form-label">Background Image Alt Text</label>
                                    <input type="text" class="form-control" id="hero_background_alt" name="hero_background_alt"
                                           value="<?php echo htmlspecialchars($beltExamsData['hero']['background_alt'] ?? ''); ?>" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-kaizen">
                                <i class="fas fa-save"></i> Save Hero Section
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Requirements Management -->
                <div class="content-section">
                    <h3 class="section-title"><i class="fas fa-exclamation-triangle me-2"></i>Requirements Management</h3>
                    
                    <div class="instructions-box">
                        <h6><i class="fas fa-info-circle"></i> Instructions</h6>
                        <ul>
                            <li>These requirements appear as cards in the "Important Requirements" section</li>
                            <li>Each requirement can have an icon, title text, and optional highlighted text</li>
                            <li>Use the highlight field to emphasize important words or phrases</li>
                            <li>Requirements are displayed in the order specified</li>
                        </ul>
                    </div>
                    
                    <form method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                        <input type="hidden" name="action" value="requirements">
                        
                        <div id="requirements-container">
                            <h5 class="mb-3">Belt Exam Requirements</h5>
                            <?php
                            $requirements = $beltExamsData['requirements'] ?? [];
                            foreach ($requirements as $index => $requirement):
                            ?>
                            <div class="requirement-card" data-index="<?php echo $index; ?>">
                                <div class="requirement-header">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="requirement-number"><?php echo $index + 1; ?></div>
                                        <h6 class="mb-0">Requirement <?php echo $index + 1; ?></h6>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-danger remove-requirement">
                                        <i class="fas fa-trash"></i> Remove
                                    </button>
                                </div>
                                
                                <input type="hidden" name="requirement_id[]" value="<?php echo $requirement['id']; ?>">
                                
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Icon Class</label>
                                        <select class="form-control icon-select" name="requirement_icon[]" required>
                                            <option value="fas fa-calendar-check" <?php echo ($requirement['icon'] === 'fas fa-calendar-check') ? 'selected' : ''; ?>>📅 Calendar Check</option>
                                            <option value="fas fa-user-shield" <?php echo ($requirement['icon'] === 'fas fa-user-shield') ? 'selected' : ''; ?>>🛡️ User Shield</option>
                                            <option value="fas fa-clock" <?php echo ($requirement['icon'] === 'fas fa-clock') ? 'selected' : ''; ?>>🕐 Clock</option>
                                            <option value="fas fa-times-circle" <?php echo ($requirement['icon'] === 'fas fa-times-circle') ? 'selected' : ''; ?>>❌ Times Circle</option>
                                            <option value="fas fa-envelope" <?php echo ($requirement['icon'] === 'fas fa-envelope') ? 'selected' : ''; ?>>✉️ Envelope</option>
                                            <option value="fas fa-exclamation-triangle" <?php echo ($requirement['icon'] === 'fas fa-exclamation-triangle') ? 'selected' : ''; ?>>⚠️ Warning</option>
                                            <option value="fas fa-info-circle" <?php echo ($requirement['icon'] === 'fas fa-info-circle') ? 'selected' : ''; ?>>ℹ️ Info Circle</option>
                                            <option value="fas fa-check-circle" <?php echo ($requirement['icon'] === 'fas fa-check-circle') ? 'selected' : ''; ?>>✅ Check Circle</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label class="form-label">Order</label>
                                        <input type="number" class="form-control" name="requirement_order[]" 
                                               value="<?php echo $requirement['order']; ?>" min="1" required>
                                    </div>
                                    <div class="col-md-7 mb-3">
                                        <label class="form-label">Title Text</label>
                                        <input type="text" class="form-control" name="requirement_title[]"
                                               value="<?php echo htmlspecialchars($requirement['title']); ?>" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Highlight Text (optional)</label>
                                        <input type="text" class="form-control" name="requirement_highlight[]"
                                               value="<?php echo htmlspecialchars($requirement['highlight'] ?? ''); ?>"
                                               placeholder="Text to highlight within the title (e.g., 'INVITATION ONLY')">
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <button type="button" id="add-requirement-btn" class="btn mb-3">
                            <i class="fas fa-plus"></i> Add Requirement
                        </button>
                        
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-kaizen">
                                <i class="fas fa-save"></i> Save Requirements
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Pilot Accordion: Testing Process -->
                <div class="content-section">
                    <h3 class="section-title"><i class="fas fa-list-check me-2"></i>Testing Process Accordion (Pilot)</h3>
                    
                    <div class="instructions-box">
                        <h6><i class="fas fa-info-circle"></i> Instructions</h6>
                        <ul>
                            <li>This is the pilot accordion implementation for the "Testing Process" section</li>
                            <li>The accordion contains sections for different belt levels with step-by-step processes</li>
                            <li>Each section can have multiple steps with titles, icons, and descriptions</li>
                            <li>This structure will be extended to other accordions in Phase 2</li>
                        </ul>
                    </div>
                    
                    <?php 
                    $processAccordion = null;
                    if (!empty($beltExamsData['accordions'])) {
                        foreach ($beltExamsData['accordions'] as $accordion) {
                            if ($accordion['id'] === 'process') {
                                $processAccordion = $accordion;
                                break;
                            }
                        }
                    }
                    ?>
                    
                    <form method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                        <input type="hidden" name="action" value="accordion_process">
                        
                        <!-- Accordion Header -->
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="accordion_title" class="form-label">Accordion Title</label>
                                    <input type="text" class="form-control" id="accordion_title" name="accordion_title"
                                           value="<?php echo htmlspecialchars($processAccordion['title'] ?? 'Testing Process'); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="accordion_description" class="form-label">Description</label>
                                    <textarea class="form-control" id="accordion_description" name="accordion_description" rows="2" required><?php echo htmlspecialchars($processAccordion['description'] ?? ''); ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="accordion_icon" class="form-label">Accordion Icon</label>
                                    <select class="form-control icon-select" id="accordion_icon" name="accordion_icon" required>
                                        <option value="fas fa-list-check" <?php echo ($processAccordion['icon'] ?? '') === 'fas fa-list-check' ? 'selected' : ''; ?>>📋 List Check</option>
                                        <option value="fas fa-clipboard-list" <?php echo ($processAccordion['icon'] ?? '') === 'fas fa-clipboard-list' ? 'selected' : ''; ?>>📄 Clipboard List</option>
                                        <option value="fas fa-tasks" <?php echo ($processAccordion['icon'] ?? '') === 'fas fa-tasks' ? 'selected' : ''; ?>>✅ Tasks</option>
                                        <option value="fas fa-cog" <?php echo ($processAccordion['icon'] ?? '') === 'fas fa-cog' ? 'selected' : ''; ?>>⚙️ Settings</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Process Sections -->
                        <h5 class="mb-3">Process Sections</h5>
                        <div id="process-sections-container">
                            <?php
                            $processSections = $processAccordion['process_sections'] ?? [];
                            foreach ($processSections as $sectionIndex => $section):
                            ?>
                            <div class="card mb-3 process-section" data-section="<?php echo $sectionIndex; ?>">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Section <?php echo $sectionIndex + 1; ?>: <?php echo htmlspecialchars($section['title']); ?></h6>
                                    <button type="button" class="btn btn-sm btn-danger remove-section">
                                        <i class="fas fa-trash"></i> Remove Section
                                    </button>
                                </div>
                                <div class="card-body">
                                    <input type="hidden" name="section_id[]" value="<?php echo htmlspecialchars($section['id']); ?>">
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-8">
                                            <label class="form-label">Section Title</label>
                                            <input type="text" class="form-control" name="section_title[]"
                                                   value="<?php echo htmlspecialchars($section['title']); ?>" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Section Icon</label>
                                            <select class="form-control icon-select" name="section_icon[]" required>
                                                <option value="fas fa-medal" <?php echo $section['icon'] === 'fas fa-medal' ? 'selected' : ''; ?>>🥇 Medal</option>
                                                <option value="fas fa-trophy" <?php echo $section['icon'] === 'fas fa-trophy' ? 'selected' : ''; ?>>🏆 Trophy</option>
                                                <option value="fas fa-star" <?php echo $section['icon'] === 'fas fa-star' ? 'selected' : ''; ?>>⭐ Star</option>
                                                <option value="fas fa-graduation-cap" <?php echo $section['icon'] === 'fas fa-graduation-cap' ? 'selected' : ''; ?>>🎓 Graduation Cap</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <!-- Steps for this section -->
                                    <h6>Steps:</h6>
                                    <div class="steps-container" data-section-index="<?php echo $sectionIndex; ?>">
                                        <?php
                                        $steps = $section['steps'] ?? [];
                                        foreach ($steps as $stepIndex => $step):
                                        ?>
                                        <div class="card mb-2 step-card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label">Step Title</label>
                                                        <input type="text" class="form-control" name="step_title[<?php echo $sectionIndex; ?>][]"
                                                               value="<?php echo htmlspecialchars($step['title']); ?>" required>
                                                    </div>
                                                    <div class="col-md-3 mb-2">
                                                        <label class="form-label">Step Icon</label>
                                                        <select class="form-control icon-select" name="step_icon[<?php echo $sectionIndex; ?>][]" required>
                                                            <option value="fas fa-user-check" <?php echo $step['icon'] === 'fas fa-user-check' ? 'selected' : ''; ?>>👤 User Check</option>
                                                            <option value="fas fa-users" <?php echo $step['icon'] === 'fas fa-users' ? 'selected' : ''; ?>>👥 Users</option>
                                                            <option value="fas fa-clipboard-check" <?php echo $step['icon'] === 'fas fa-clipboard-check' ? 'selected' : ''; ?>>📋 Clipboard Check</option>
                                                            <option value="fas fa-video" <?php echo $step['icon'] === 'fas fa-video' ? 'selected' : ''; ?>>📹 Video</option>
                                                            <option value="fas fa-exclamation-triangle" <?php echo $step['icon'] === 'fas fa-exclamation-triangle' ? 'selected' : ''; ?>>⚠️ Warning</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-5 mb-2">
                                                        <label class="form-label">Step Description</label>
                                                        <textarea class="form-control" name="step_description[<?php echo $sectionIndex; ?>][]" rows="2" required><?php echo htmlspecialchars($step['description']); ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                    
                                    <button type="button" class="btn btn-sm btn-success add-step" data-section="<?php echo $sectionIndex; ?>">
                                        <i class="fas fa-plus"></i> Add Step
                                    </button>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <button type="button" id="add-section-btn" class="btn btn-success mb-3">
                            <i class="fas fa-plus"></i> Add Process Section
                        </button>
                        
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-kaizen">
                                <i class="fas fa-save"></i> Save Testing Process Accordion
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Basic Lightbox System -->
                <div class="content-section">
                    <h3 class="section-title"><i class="fas fa-window-maximize me-2"></i>Lightbox Management (Basic System)</h3>
                    
                    <div class="instructions-box">
                        <h6><i class="fas fa-info-circle"></i> Instructions</h6>
                        <ul>
                            <li>Lightboxes are popup windows that display additional content when clicked</li>
                            <li>Each lightbox needs a unique ID and trigger function name</li>
                            <li>Content type determines how the lightbox displays (info, image, script)</li>
                            <li>This basic system will be expanded in Phase 2 for all lightbox types</li>
                        </ul>
                    </div>
                    
                    <form method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                        <input type="hidden" name="action" value="lightboxes">
                        
                        <div id="lightboxes-container">
                            <h5 class="mb-3">Lightboxes</h5>
                            <?php
                            $lightboxes = $beltExamsData['lightboxes'] ?? [];
                            foreach ($lightboxes as $index => $lightbox):
                            ?>
                            <div class="card mb-3 lightbox-card" data-index="<?php echo $index; ?>">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Lightbox: <?php echo htmlspecialchars($lightbox['title']); ?></h6>
                                    <button type="button" class="btn btn-sm btn-danger remove-lightbox">
                                        <i class="fas fa-trash"></i> Remove
                                    </button>
                                </div>
                                <div class="card-body">
                                    <input type="hidden" name="lightbox_id[]" value="<?php echo htmlspecialchars($lightbox['id']); ?>">
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Lightbox Title</label>
                                            <input type="text" class="form-control" name="lightbox_title[]"
                                                   value="<?php echo htmlspecialchars($lightbox['title']); ?>" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Trigger Function</label>
                                            <input type="text" class="form-control" name="lightbox_trigger[]"
                                                   value="<?php echo htmlspecialchars($lightbox['trigger_function']); ?>" 
                                                   placeholder="e.g., openTestingTipsLightbox" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Content Type</label>
                                            <select class="form-control" name="lightbox_content_type[]" required>
                                                <option value="info" <?php echo $lightbox['content_type'] === 'info' ? 'selected' : ''; ?>>Information</option>
                                                <option value="image" <?php echo $lightbox['content_type'] === 'image' ? 'selected' : ''; ?>>Image</option>
                                                <option value="script" <?php echo $lightbox['content_type'] === 'script' ? 'selected' : ''; ?>>Script/Text</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Content Title</label>
                                            <input type="text" class="form-control" name="lightbox_content_title[]"
                                                   value="<?php echo htmlspecialchars($lightbox['content']['title'] ?? ''); ?>" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Content Description</label>
                                            <input type="text" class="form-control" name="lightbox_content_description[]"
                                                   value="<?php echo htmlspecialchars($lightbox['content']['description'] ?? ''); ?>" required>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-label">Text Content</label>
                                            <textarea class="form-control" name="lightbox_text_content[]" rows="4" required><?php echo htmlspecialchars($lightbox['content']['text_content'] ?? ''); ?></textarea>
                                            <div class="form-text">For 'info' type: main content text. For 'script' type: full script content. For 'image' type: optional caption.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <button type="button" id="add-lightbox-btn" class="btn btn-success mb-3">
                            <i class="fas fa-plus"></i> Add Lightbox
                        </button>
                        
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-kaizen">
                                <i class="fas fa-save"></i> Save Lightboxes
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Requirements to Test Accordion -->
                <div class="content-section">
                    <h3 class="section-title"><i class="fas fa-clipboard-list me-2"></i>Requirements to Test Accordion</h3>
                    
                    <div class="instructions-box">
                        <h6><i class="fas fa-info-circle"></i> Instructions</h6>
                        <ul>
                            <li>This accordion displays testing requirements with downloadable images</li>
                            <li>Important notice section provides context and restrictions</li>
                            <li>Each requirement image has a title, description, lightbox, and download link</li>
                            <li>Upload images in JPG/PNG format, recommended size 800x600 or larger</li>
                        </ul>
                    </div>
                    
                    <?php 
                    $requirementsAccordion = null;
                    if (!empty($beltExamsData['accordions'])) {
                        foreach ($beltExamsData['accordions'] as $accordion) {
                            if ($accordion['id'] === 'requirements') {
                                $requirementsAccordion = $accordion;
                                break;
                            }
                        }
                    }
                    ?>
                    
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                        <input type="hidden" name="action" value="accordion_requirements">
                        
                        <!-- Accordion Header -->
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="requirements_accordion_title" class="form-label">Accordion Title</label>
                                    <input type="text" class="form-control" id="requirements_accordion_title" name="requirements_accordion_title"
                                           value="<?php echo htmlspecialchars($requirementsAccordion['title'] ?? 'Requirements to Test'); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="requirements_accordion_description" class="form-label">Description</label>
                                    <textarea class="form-control" id="requirements_accordion_description" name="requirements_accordion_description" rows="2" required><?php echo htmlspecialchars($requirementsAccordion['description'] ?? ''); ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="requirements_accordion_icon" class="form-label">Accordion Icon</label>
                                    <select class="form-control icon-select" id="requirements_accordion_icon" name="requirements_accordion_icon" required>
                                        <option value="fas fa-clipboard-list" <?php echo ($requirementsAccordion['icon'] ?? '') === 'fas fa-clipboard-list' ? 'selected' : ''; ?>>📄 Clipboard List</option>
                                        <option value="fas fa-list-check" <?php echo ($requirementsAccordion['icon'] ?? '') === 'fas fa-list-check' ? 'selected' : ''; ?>>📋 List Check</option>
                                        <option value="fas fa-file-alt" <?php echo ($requirementsAccordion['icon'] ?? '') === 'fas fa-file-alt' ? 'selected' : ''; ?>>📄 Document</option>
                                        <option value="fas fa-tasks" <?php echo ($requirementsAccordion['icon'] ?? '') === 'fas fa-tasks' ? 'selected' : ''; ?>>✅ Tasks</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Important Notice Section -->
                        <h5 class="mb-3">Important Notice</h5>
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Notice Title</label>
                                        <input type="text" class="form-control" name="notice_title"
                                               value="<?php echo htmlspecialchars($requirementsAccordion['important_notice']['title'] ?? 'Important Testing Requirements'); ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Notice Description</label>
                                        <textarea class="form-control" name="notice_description" rows="2" required><?php echo htmlspecialchars($requirementsAccordion['important_notice']['description'] ?? ''); ?></textarea>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Additional Notes</label>
                                    <div id="additional-notes-container">
                                        <?php
                                        $notes = $requirementsAccordion['important_notice']['additional_notes'] ?? [];
                                        foreach ($notes as $index => $note):
                                        ?>
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" name="additional_note[]" value="<?php echo htmlspecialchars($note); ?>">
                                            <button type="button" class="btn btn-danger remove-note"><i class="fas fa-trash"></i></button>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <button type="button" id="add-note-btn" class="btn btn-sm btn-success">
                                        <i class="fas fa-plus"></i> Add Note
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Requirement Images -->
                        <h5 class="mb-3">Requirement Images</h5>
                        <div id="requirement-images-container">
                            <?php
                            $requirementImages = $requirementsAccordion['requirement_images'] ?? [];
                            foreach ($requirementImages as $index => $image):
                            ?>
                            <div class="card mb-3 requirement-image-card" data-index="<?php echo $index; ?>">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Requirement Image: <?php echo htmlspecialchars($image['title']); ?></h6>
                                    <button type="button" class="btn btn-sm btn-danger remove-requirement-image">
                                        <i class="fas fa-trash"></i> Remove
                                    </button>
                                </div>
                                <div class="card-body">
                                    <input type="hidden" name="req_image_id[]" value="<?php echo htmlspecialchars($image['id']); ?>">
                                    <input type="hidden" name="req_image_path[]" value="<?php echo htmlspecialchars($image['image']); ?>">
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Title</label>
                                            <input type="text" class="form-control req-title-input" name="req_image_title[]"
                                                   value="<?php echo htmlspecialchars($image['title']); ?>" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Icon</label>
                                            <select class="form-control icon-select" name="req_image_icon[]" required>
                                                <option value="fas fa-th" <?php echo $image['icon'] === 'fas fa-th' ? 'selected' : ''; ?>>🔲 Grid</option>
                                                <option value="fas fa-clipboard-list" <?php echo $image['icon'] === 'fas fa-clipboard-list' ? 'selected' : ''; ?>>📋 Clipboard</option>
                                                <option value="fas fa-star" <?php echo $image['icon'] === 'fas fa-star' ? 'selected' : ''; ?>>⭐ Star</option>
                                                <option value="fas fa-image" <?php echo $image['icon'] === 'fas fa-image' ? 'selected' : ''; ?>>🖼️ Image</option>
                                                <option value="fas fa-file-alt" <?php echo $image['icon'] === 'fas fa-file-alt' ? 'selected' : ''; ?>>📄 Document</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Order</label>
                                            <input type="number" class="form-control" name="req_image_order[]" 
                                                   value="<?php echo $image['order']; ?>" min="1" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Lightbox Function</label>
                                            <input type="text" class="form-control" name="req_lightbox_function[]"
                                                   value="<?php echo htmlspecialchars($image['lightbox_function']); ?>" 
                                                   placeholder="e.g., openMatrixLightbox" required>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Description</label>
                                            <input type="text" class="form-control" name="req_image_description[]"
                                                   value="<?php echo htmlspecialchars($image['description']); ?>" required>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Image Upload</label>
                                            <input type="file" class="form-control" name="req_image_file[]" accept="image/*">
                                            <div class="form-text">Max 5MB, JPG/PNG/WebP</div>
                                            <?php if (!empty($image['image'])): ?>
                                                <img src="../<?php echo htmlspecialchars($image['image']); ?>" 
                                                     alt="Current image" class="current-image-preview mt-2" style="max-width: 200px;">
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Download URL</label>
                                            <input type="text" class="form-control" name="req_download_url[]"
                                                   value="<?php echo htmlspecialchars($image['download_url']); ?>" 
                                                   placeholder="Optional - defaults to image path">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Download Filename</label>
                                            <input type="text" class="form-control" name="req_download_filename[]"
                                                   value="<?php echo htmlspecialchars($image['download_filename']); ?>" 
                                                   placeholder="e.g., kaizen-testing-matrix.png">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <button type="button" id="add-requirement-image-btn" class="btn btn-success mb-3">
                            <i class="fas fa-plus"></i> Add Requirement Image
                        </button>
                        
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-kaizen">
                                <i class="fas fa-save"></i> Save Requirements Accordion
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Belt Exam Clothing Requirements Accordion -->
                <div class="content-section">
                    <h3 class="section-title"><i class="fas fa-tshirt me-2"></i>Belt Exam Clothing Requirements Accordion</h3>
                    
                    <div class="instructions-box">
                        <h6><i class="fas fa-info-circle"></i> Instructions</h6>
                        <ul>
                            <li>This accordion displays clothing requirements for different belt levels</li>
                            <li>Each clothing card has belt-specific uniform requirements</li>
                            <li>Belt colors can be specified with optional stripe colors</li>
                            <li>Shop section provides external link for purchasing uniforms</li>
                        </ul>
                    </div>
                    
                    <?php 
                    $clothingAccordion = null;
                    if (!empty($beltExamsData['accordions'])) {
                        foreach ($beltExamsData['accordions'] as $accordion) {
                            if ($accordion['id'] === 'clothing') {
                                $clothingAccordion = $accordion;
                                break;
                            }
                        }
                    }
                    ?>
                    
                    <form method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                        <input type="hidden" name="action" value="accordion_clothing">
                        
                        <!-- Accordion Header -->
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="clothing_accordion_title" class="form-label">Accordion Title</label>
                                    <input type="text" class="form-control" id="clothing_accordion_title" name="clothing_accordion_title"
                                           value="<?php echo htmlspecialchars($clothingAccordion['title'] ?? 'Belt Exam Clothing Requirements'); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="clothing_accordion_description" class="form-label">Description</label>
                                    <textarea class="form-control" id="clothing_accordion_description" name="clothing_accordion_description" rows="2" required><?php echo htmlspecialchars($clothingAccordion['description'] ?? ''); ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="clothing_accordion_icon" class="form-label">Accordion Icon</label>
                                    <select class="form-control icon-select" id="clothing_accordion_icon" name="clothing_accordion_icon" required>
                                        <option value="fas fa-tshirt" <?php echo ($clothingAccordion['icon'] ?? '') === 'fas fa-tshirt' ? 'selected' : ''; ?>>👕 T-Shirt</option>
                                        <option value="fas fa-user-tie" <?php echo ($clothingAccordion['icon'] ?? '') === 'fas fa-user-tie' ? 'selected' : ''; ?>>👔 Uniform</option>
                                        <option value="fas fa-star" <?php echo ($clothingAccordion['icon'] ?? '') === 'fas fa-star' ? 'selected' : ''; ?>>⭐ Star</option>
                                        <option value="fas fa-medal" <?php echo ($clothingAccordion['icon'] ?? '') === 'fas fa-medal' ? 'selected' : ''; ?>>🥇 Medal</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Clothing Cards -->
                        <h5 class="mb-3">Clothing Requirement Cards</h5>
                        <div id="clothing-cards-container">
                            <?php
                            $clothingCards = $clothingAccordion['clothing_cards'] ?? [];
                            foreach ($clothingCards as $index => $card):
                            ?>
                            <div class="card mb-3 clothing-card" data-index="<?php echo $index; ?>">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Clothing Card: <?php echo htmlspecialchars($card['title']); ?></h6>
                                    <button type="button" class="btn btn-sm btn-danger remove-clothing-card">
                                        <i class="fas fa-trash"></i> Remove
                                    </button>
                                </div>
                                <div class="card-body">
                                    <input type="hidden" name="clothing_card_id[]" value="<?php echo htmlspecialchars($card['id']); ?>">
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Card Title</label>
                                            <input type="text" class="form-control clothing-title-input" name="clothing_card_title[]"
                                                   value="<?php echo htmlspecialchars($card['title']); ?>" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Belt Color</label>
                                            <select class="form-control" name="clothing_belt_color[]" required>
                                                <option value="">Select Belt Color</option>
                                                <option value="white" <?php echo $card['belt_color'] === 'white' ? 'selected' : ''; ?>>White</option>
                                                <option value="orange" <?php echo $card['belt_color'] === 'orange' ? 'selected' : ''; ?>>Orange</option>
                                                <option value="yellow" <?php echo $card['belt_color'] === 'yellow' ? 'selected' : ''; ?>>Yellow</option>
                                                <option value="green" <?php echo $card['belt_color'] === 'green' ? 'selected' : ''; ?>>Green</option>
                                                <option value="purple" <?php echo $card['belt_color'] === 'purple' ? 'selected' : ''; ?>>Purple</option>
                                                <option value="blue" <?php echo $card['belt_color'] === 'blue' ? 'selected' : ''; ?>>Blue</option>
                                                <option value="brown" <?php echo $card['belt_color'] === 'brown' ? 'selected' : ''; ?>>Brown</option>
                                                <option value="red" <?php echo $card['belt_color'] === 'red' ? 'selected' : ''; ?>>Red</option>
                                                <option value="black" <?php echo $card['belt_color'] === 'black' ? 'selected' : ''; ?>>Black</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Stripe Color (Optional)</label>
                                            <select class="form-control" name="clothing_stripe_color[]">
                                                <option value="">No Stripe</option>
                                                <option value="black" <?php echo $card['stripe_color'] === 'black' ? 'selected' : ''; ?>>Black Stripe</option>
                                                <option value="white" <?php echo $card['stripe_color'] === 'white' ? 'selected' : ''; ?>>White Stripe</option>
                                                <option value="red" <?php echo $card['stripe_color'] === 'red' ? 'selected' : ''; ?>>Red Stripe</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Order</label>
                                            <input type="number" class="form-control" name="clothing_card_order[]" 
                                                   value="<?php echo $card['order']; ?>" min="1" required>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Additional Notes</label>
                                            <textarea class="form-control" name="clothing_additional_notes[]" rows="2"><?php echo htmlspecialchars($card['additional_notes']); ?></textarea>
                                        </div>
                                    </div>
                                    
                                    <!-- Requirements for this card -->
                                    <div class="mb-3">
                                        <label class="form-label">Uniform Requirements</label>
                                        <div class="clothing-requirements-container" data-card-index="<?php echo $index; ?>">
                                            <?php
                                            $requirements = $card['requirements'] ?? [];
                                            foreach ($requirements as $reqIndex => $requirement):
                                            ?>
                                            <div class="input-group mb-2">
                                                <input type="text" class="form-control" name="clothing_requirements[<?php echo $index; ?>][]" 
                                                       value="<?php echo htmlspecialchars($requirement); ?>" placeholder="Enter requirement">
                                                <button type="button" class="btn btn-danger remove-clothing-requirement"><i class="fas fa-trash"></i></button>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-success add-clothing-requirement" data-card="<?php echo $index; ?>">
                                            <i class="fas fa-plus"></i> Add Requirement
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <button type="button" id="add-clothing-card-btn" class="btn btn-success mb-3">
                            <i class="fas fa-plus"></i> Add Clothing Card
                        </button>
                        
                        <!-- Shop Section -->
                        <h5 class="mb-3">Shop Section</h5>
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Shop Section Title</label>
                                        <input type="text" class="form-control" name="shop_title"
                                               value="<?php echo htmlspecialchars($clothingAccordion['shop_section']['title'] ?? 'Shop for Karate Uniforms'); ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Shop Button Text</label>
                                        <input type="text" class="form-control" name="shop_button_text"
                                               value="<?php echo htmlspecialchars($clothingAccordion['shop_section']['shop_button_text'] ?? 'Shop Now'); ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Shop Description</label>
                                        <textarea class="form-control" name="shop_description" rows="2" required><?php echo htmlspecialchars($clothingAccordion['shop_section']['description'] ?? ''); ?></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Shop URL</label>
                                        <input type="url" class="form-control" name="shop_url"
                                               value="<?php echo htmlspecialchars($clothingAccordion['shop_section']['shop_url'] ?? ''); ?>" 
                                               placeholder="https://www.karatesupply.com" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-kaizen">
                                <i class="fas fa-save"></i> Save Clothing Requirements Accordion
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Testing Scripts Accordion -->
                <div class="content-section">
                    <h3 class="section-title"><i class="fas fa-scroll me-2"></i>Testing Scripts Accordion (Complex)</h3>
                    
                    <div class="instructions-box">
                        <h6><i class="fas fa-info-circle"></i> Instructions</h6>
                        <ul>
                            <li>This is the most complex accordion with 9 script cards in a 3x3 grid layout</li>
                            <li>Each script card links to a lightbox with detailed content</li>
                            <li>Belt colors and stripe colors provide visual identification</li>
                            <li>Testing Tips and Video Instructions are general purpose (no belt color)</li>
                            <li>Belt scripts (Green through Red w/ Stripe) are belt-specific</li>
                        </ul>
                    </div>
                    
                    <?php 
                    $scriptsAccordion = null;
                    if (!empty($beltExamsData['accordions'])) {
                        foreach ($beltExamsData['accordions'] as $accordion) {
                            if ($accordion['id'] === 'scripts') {
                                $scriptsAccordion = $accordion;
                                break;
                            }
                        }
                    }
                    ?>
                    
                    <form method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                        <input type="hidden" name="action" value="accordion_scripts">
                        
                        <!-- Accordion Header -->
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="scripts_accordion_title" class="form-label">Accordion Title</label>
                                    <input type="text" class="form-control" id="scripts_accordion_title" name="scripts_accordion_title"
                                           value="<?php echo htmlspecialchars($scriptsAccordion['title'] ?? 'Testing Scripts'); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="scripts_accordion_description" class="form-label">Description</label>
                                    <textarea class="form-control" id="scripts_accordion_description" name="scripts_accordion_description" rows="2" required><?php echo htmlspecialchars($scriptsAccordion['description'] ?? ''); ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="scripts_accordion_icon" class="form-label">Accordion Icon</label>
                                    <select class="form-control icon-select" id="scripts_accordion_icon" name="scripts_accordion_icon" required>
                                        <option value="fas fa-scroll" <?php echo ($scriptsAccordion['icon'] ?? '') === 'fas fa-scroll' ? 'selected' : ''; ?>>📜 Scroll</option>
                                        <option value="fas fa-file-text" <?php echo ($scriptsAccordion['icon'] ?? '') === 'fas fa-file-text' ? 'selected' : ''; ?>>📄 Document</option>
                                        <option value="fas fa-list-alt" <?php echo ($scriptsAccordion['icon'] ?? '') === 'fas fa-list-alt' ? 'selected' : ''; ?>>📋 List</option>
                                        <option value="fas fa-book" <?php echo ($scriptsAccordion['icon'] ?? '') === 'fas fa-book' ? 'selected' : ''; ?>>📚 Book</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Script Cards (3x3 Grid) -->
                        <h5 class="mb-3">Script Cards (3x3 Grid Layout)</h5>
                        <div id="script-cards-container">
                            <?php
                            $scriptCards = $scriptsAccordion['script_cards'] ?? [];
                            foreach ($scriptCards as $index => $card):
                            ?>
                            <div class="card mb-3 script-card" data-index="<?php echo $index; ?>">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Script Card: <?php echo htmlspecialchars($card['title']); ?></h6>
                                    <button type="button" class="btn btn-sm btn-danger remove-script-card">
                                        <i class="fas fa-trash"></i> Remove
                                    </button>
                                </div>
                                <div class="card-body">
                                    <input type="hidden" name="script_card_id[]" value="<?php echo htmlspecialchars($card['id']); ?>">
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Card Title</label>
                                            <input type="text" class="form-control script-title-input" name="script_card_title[]"
                                                   value="<?php echo htmlspecialchars($card['title']); ?>" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Icon</label>
                                            <select class="form-control icon-select" name="script_card_icon[]" required>
                                                <option value="fas fa-scroll" <?php echo $card['icon'] === 'fas fa-scroll' ? 'selected' : ''; ?>>📜 Scroll</option>
                                                <option value="fas fa-lightbulb" <?php echo $card['icon'] === 'fas fa-lightbulb' ? 'selected' : ''; ?>>💡 Lightbulb</option>
                                                <option value="fas fa-video" <?php echo $card['icon'] === 'fas fa-video' ? 'selected' : ''; ?>>📹 Video</option>
                                                <option value="fas fa-file-alt" <?php echo $card['icon'] === 'fas fa-file-alt' ? 'selected' : ''; ?>>📄 Document</option>
                                                <option value="fas fa-clipboard-check" <?php echo $card['icon'] === 'fas fa-clipboard-check' ? 'selected' : ''; ?>>📋 Clipboard</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Belt Color</label>
                                            <select class="form-control" name="script_belt_color[]">
                                                <option value="">No Specific Belt</option>
                                                <option value="green" <?php echo $card['belt_color'] === 'green' ? 'selected' : ''; ?>>Green</option>
                                                <option value="purple" <?php echo $card['belt_color'] === 'purple' ? 'selected' : ''; ?>>Purple</option>
                                                <option value="blue" <?php echo $card['belt_color'] === 'blue' ? 'selected' : ''; ?>>Blue</option>
                                                <option value="brown" <?php echo $card['belt_color'] === 'brown' ? 'selected' : ''; ?>>Brown</option>
                                                <option value="red" <?php echo $card['belt_color'] === 'red' ? 'selected' : ''; ?>>Red</option>
                                                <option value="black" <?php echo $card['belt_color'] === 'black' ? 'selected' : ''; ?>>Black</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Order</label>
                                            <input type="number" class="form-control" name="script_card_order[]" 
                                                   value="<?php echo $card['order']; ?>" min="1" max="9" required>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Stripe Color (Optional)</label>
                                            <select class="form-control" name="script_stripe_color[]">
                                                <option value="">No Stripe</option>
                                                <option value="black" <?php echo ($card['stripe_color'] ?? '') === 'black' ? 'selected' : ''; ?>>Black Stripe</option>
                                                <option value="white" <?php echo ($card['stripe_color'] ?? '') === 'white' ? 'selected' : ''; ?>>White Stripe</option>
                                            </select>
                                        </div>
                                        <div class="col-md-8">
                                            <label class="form-label">Lightbox Function</label>
                                            <input type="text" class="form-control" name="script_lightbox_function[]"
                                                   value="<?php echo htmlspecialchars($card['lightbox_function']); ?>" 
                                                   placeholder="e.g., openGreenBeltLightbox" required>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-label">Description</label>
                                            <input type="text" class="form-control" name="script_card_description[]"
                                                   value="<?php echo htmlspecialchars($card['description']); ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <button type="button" id="add-script-card-btn" class="btn btn-success mb-3">
                            <i class="fas fa-plus"></i> Add Script Card
                        </button>
                        
                        <!-- Important Note Section -->
                        <h5 class="mb-3">Important Note Section</h5>
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Note Title</label>
                                        <input type="text" class="form-control" name="note_title"
                                               value="<?php echo htmlspecialchars($scriptsAccordion['important_note']['title'] ?? 'Important Note'); ?>" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Note Icon</label>
                                        <select class="form-control icon-select" name="note_icon" required>
                                            <option value="fas fa-info-circle" <?php echo ($scriptsAccordion['important_note']['icon'] ?? '') === 'fas fa-info-circle' ? 'selected' : ''; ?>>ℹ️ Info</option>
                                            <option value="fas fa-exclamation-triangle" <?php echo ($scriptsAccordion['important_note']['icon'] ?? '') === 'fas fa-exclamation-triangle' ? 'selected' : ''; ?>>⚠️ Warning</option>
                                            <option value="fas fa-lightbulb" <?php echo ($scriptsAccordion['important_note']['icon'] ?? '') === 'fas fa-lightbulb' ? 'selected' : ''; ?>>💡 Tip</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Note Description</label>
                                        <textarea class="form-control" name="note_description" rows="2" required><?php echo htmlspecialchars($scriptsAccordion['important_note']['description'] ?? ''); ?></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-label">Additional Text</label>
                                        <textarea class="form-control" name="note_additional_text" rows="2"><?php echo htmlspecialchars($scriptsAccordion['important_note']['additional_text'] ?? ''); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-kaizen">
                                <i class="fas fa-save"></i> Save Testing Scripts Accordion
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Upcoming Testing Dates Accordion -->
                <div class="content-section">
                    <h3 class="section-title"><i class="fas fa-calendar-alt me-2"></i>Upcoming Testing Dates Accordion</h3>
                    <div class="alert alert-info">
                        <p class="mb-3"><strong>Upcoming Testing Dates:</strong> Manage 6 date cards with testing dates and registration information.</p>
                        <ul class="mb-0">
                            <li>Each date card has: Date/Time, Location, Notes, Registration status</li>
                            <li>Cards can be added, edited, and removed dynamically</li>
                            <li>Order can be customized for proper scheduling</li>
                        </ul>
                    </div>
                    
                    <?php 
                    $datesAccordion = null;
                    if (!empty($beltExamsData['accordions'])) {
                        foreach ($beltExamsData['accordions'] as $accordion) {
                            if ($accordion['id'] === 'dates') {
                                $datesAccordion = $accordion;
                                break;
                            }
                        }
                    }
                    
                    // If no dates accordion exists, get default from the default structure
                    if ($datesAccordion === null) {
                        foreach ($defaultBeltExams['accordions'] as $accordion) {
                            if ($accordion['id'] === 'dates') {
                                $datesAccordion = $accordion;
                                break;
                            }
                        }
                    }
                    ?>
                    
                    <!-- Data Structure Now Matches Frontend -->
                    
                    <form method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                        <input type="hidden" name="action" value="accordion_dates">
                        
                        <!-- Accordion Header -->
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="dates_accordion_title" class="form-label">Accordion Title</label>
                                    <input type="text" class="form-control" id="dates_accordion_title" name="dates_accordion_title"
                                           value="<?php echo htmlspecialchars($datesAccordion['title'] ?? 'Upcoming Testing Dates'); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="dates_accordion_description" class="form-label">Description</label>
                                    <textarea class="form-control" id="dates_accordion_description" name="dates_accordion_description" rows="2" required><?php echo htmlspecialchars($datesAccordion['description'] ?? ''); ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="dates_accordion_icon" class="form-label">Accordion Icon</label>
                                    <select class="form-control icon-select" id="dates_accordion_icon" name="dates_accordion_icon" required>
                                        <option value="fas fa-calendar-alt" <?php echo ($datesAccordion['icon'] ?? '') === 'fas fa-calendar-alt' ? 'selected' : ''; ?>>📅 Calendar</option>
                                        <option value="fas fa-clock" <?php echo ($datesAccordion['icon'] ?? '') === 'fas fa-clock' ? 'selected' : ''; ?>>🕐 Clock</option>
                                        <option value="fas fa-calendar-check" <?php echo ($datesAccordion['icon'] ?? '') === 'fas fa-calendar-check' ? 'selected' : ''; ?>>✅ Calendar Check</option>
                                        <option value="fas fa-calendar-week" <?php echo ($datesAccordion['icon'] ?? '') === 'fas fa-calendar-week' ? 'selected' : ''; ?>>📆 Week Calendar</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Testing Date Cards -->
                        <h5 class="mb-3">Testing Date Cards (Match Frontend Structure)</h5>
                        <div id="date-cards-container">
                            <?php
                            $dateCards = $datesAccordion['date_cards'] ?? [];
                            foreach ($dateCards as $index => $card):
                            ?>
                            <div class="card mb-3 date-card" data-index="<?php echo $index; ?>">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Date Card: <?php echo htmlspecialchars($card['month_year']); ?></h6>
                                    <button type="button" class="btn btn-sm btn-danger remove-date-card">
                                        <i class="fas fa-trash"></i> Remove
                                    </button>
                                </div>
                                <div class="card-body">
                                    <input type="hidden" name="date_card_id[]" value="<?php echo htmlspecialchars($card['id']); ?>">
                                    
                                    <!-- Basic Info Row -->
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Month/Year Title</label>
                                            <input type="text" class="form-control date-title-input" name="date_card_month_year[]"
                                                   value="<?php echo htmlspecialchars($card['month_year']); ?>" 
                                                   placeholder="e.g., November 2025" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Icon</label>
                                            <select class="form-control icon-select" name="date_card_icon[]" required>
                                                <option value="fas fa-calendar-day" <?php echo ($card['icon'] ?? 'fas fa-calendar-day') === 'fas fa-calendar-day' ? 'selected' : ''; ?>>📅 Calendar Day</option>
                                                <option value="fas fa-clock" <?php echo ($card['icon'] ?? '') === 'fas fa-clock' ? 'selected' : ''; ?>>🕐 Clock</option>
                                                <option value="fas fa-calendar-alt" <?php echo ($card['icon'] ?? '') === 'fas fa-calendar-alt' ? 'selected' : ''; ?>>📅 Calendar</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Order</label>
                                            <input type="number" class="form-control" name="date_card_order[]" 
                                                   value="<?php echo $card['order']; ?>" min="1" max="6" required>
                                        </div>
                                    </div>
                                    
                                    <!-- Location Info Row -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Location Name</label>
                                            <input type="text" class="form-control" name="date_card_location_name[]"
                                                   value="<?php echo htmlspecialchars($card['location_name'] ?? ''); ?>" 
                                                   placeholder="e.g., East Silver Spring ES - GYM" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Street Address</label>
                                            <input type="text" class="form-control" name="date_card_street_address[]"
                                                   value="<?php echo htmlspecialchars($card['street_address'] ?? ''); ?>"
                                                   placeholder="e.g., 631 Silver Spring Ave" required>
                                        </div>
                                    </div>
                                    
                                    <!-- Address & DateTime Row -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">City, State ZIP</label>
                                            <input type="text" class="form-control" name="date_card_city_state_zip[]"
                                                   value="<?php echo htmlspecialchars($card['city_state_zip'] ?? ''); ?>"
                                                   placeholder="e.g., Silver Spring, MD 20910" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Date & Time String</label>
                                            <input type="text" class="form-control" name="date_card_datetime_string[]"
                                                   value="<?php echo htmlspecialchars($card['datetime_string'] ?? ''); ?>"
                                                   placeholder="e.g., Saturday, November 15th - 11:00 AM Start Time" required>
                                        </div>
                                    </div>
                                    
                                    <!-- Registration Info Row -->
                                    <div class="row mb-3">
                                        <div class="col-md-8">
                                            <label class="form-label">Registration Link Text</label>
                                            <input type="text" class="form-control" name="date_card_link_text[]"
                                                   value="<?php echo htmlspecialchars($card['link_text'] ?? 'For more details and registration, click here'); ?>"
                                                   placeholder="For more details and registration, click here">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Make-up Month</label>
                                            <input type="text" class="form-control" name="date_card_makeup_month[]"
                                                   value="<?php echo htmlspecialchars($card['makeup_month'] ?? ''); ?>"
                                                   placeholder="e.g., January 2026">
                                        </div>
                                    </div>
                                    
                                    <!-- Standard Notes Section -->
                                    <h6 class="mb-3">Standard Notes (4 notes per card)</h6>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Youth Testing Note</label>
                                            <input type="text" class="form-control" name="date_card_youth_note[]"
                                                   value="<?php echo htmlspecialchars($card['youth_note'] ?? '*Youth testing takes place on Saturdays'); ?>"
                                                   placeholder="*Youth testing takes place on Saturdays">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Adult Testing Note</label>
                                            <input type="text" class="form-control" name="date_card_adult_note[]"
                                                   value="<?php echo htmlspecialchars($card['adult_note'] ?? '*Adult testing takes place on Monday nights'); ?>"
                                                   placeholder="*Adult testing takes place on Monday nights">
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Video Testing Note</label>
                                            <input type="text" class="form-control" name="date_card_video_note[]"
                                                   value="<?php echo htmlspecialchars($card['video_note'] ?? 'Video tests due 1 month prior to testing date (green belt and above). NO EXCEPTIONS.'); ?>"
                                                   placeholder="Video tests due 1 month prior to testing date (green belt and above). NO EXCEPTIONS.">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <button type="button" id="add-date-card-btn" class="btn btn-success mb-3">
                            <i class="fas fa-plus"></i> Add Date Card
                        </button>
                        
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-kaizen">
                                <i class="fas fa-save"></i> Save Testing Dates Accordion
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Register for Belt Exam Accordion -->
                <div class="content-section">
                    <h3 class="section-title"><i class="fas fa-user-plus me-2"></i>Register for Belt Exam Accordion</h3>
                    <div class="alert alert-info">
                        <p class="mb-3"><strong>Register for Belt Exam:</strong> Manage 3 registration cards with time slots and belt level groupings.</p>
                        <ul class="mb-0">
                            <li>Each registration card has: Time slot, Belt levels, Location, Registration link</li>
                            <li>Time slots: 11:00 AM, 12:00 PM, 1:00 PM</li>
                            <li>Belt groupings: White belts, Orange/Yellow, Green-Red</li>
                            <li>Status indicators for registration availability</li>
                        </ul>
                    </div>
                    
                    <?php 
                    $registrationAccordion = null;
                    if (!empty($beltExamsData['accordions'])) {
                        foreach ($beltExamsData['accordions'] as $accordion) {
                            if ($accordion['id'] === 'registration') {
                                $registrationAccordion = $accordion;
                                break;
                            }
                        }
                    }
                    ?>
                    
                    <form method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                        <input type="hidden" name="action" value="accordion_registration">
                        
                        <!-- Accordion Header -->
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="registration_accordion_title" class="form-label">Accordion Title</label>
                                    <input type="text" class="form-control" id="registration_accordion_title" name="registration_accordion_title"
                                           value="<?php echo htmlspecialchars($registrationAccordion['title'] ?? 'Register for Belt Exam'); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="registration_accordion_description" class="form-label">Description</label>
                                    <textarea class="form-control" id="registration_accordion_description" name="registration_accordion_description" rows="2" required><?php echo htmlspecialchars($registrationAccordion['description'] ?? ''); ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="registration_accordion_icon" class="form-label">Accordion Icon</label>
                                    <select class="form-control icon-select" id="registration_accordion_icon" name="registration_accordion_icon" required>
                                        <option value="fas fa-user-plus" <?php echo ($registrationAccordion['icon'] ?? '') === 'fas fa-user-plus' ? 'selected' : ''; ?>>👤 User Plus</option>
                                        <option value="fas fa-clipboard-list" <?php echo ($registrationAccordion['icon'] ?? '') === 'fas fa-clipboard-list' ? 'selected' : ''; ?>>📋 Clipboard</option>
                                        <option value="fas fa-calendar-plus" <?php echo ($registrationAccordion['icon'] ?? '') === 'fas fa-calendar-plus' ? 'selected' : ''; ?>>📅 Calendar Plus</option>
                                        <option value="fas fa-edit" <?php echo ($registrationAccordion['icon'] ?? '') === 'fas fa-edit' ? 'selected' : ''; ?>>✏️ Edit</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Registration Cards -->
                        <h5 class="mb-3">Registration Time Slot Cards</h5>
                        <div id="registration-cards-container">
                            <?php
                            $registrationCards = $registrationAccordion['registration_cards'] ?? [];
                            foreach ($registrationCards as $index => $card):
                            ?>
                            <div class="card mb-3 registration-card" data-index="<?php echo $index; ?>">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Registration Card: <?php echo htmlspecialchars($card['title']); ?></h6>
                                    <button type="button" class="btn btn-sm btn-danger remove-registration-card">
                                        <i class="fas fa-trash"></i> Remove
                                    </button>
                                </div>
                                <div class="card-body">
                                    <input type="hidden" name="registration_card_id[]" value="<?php echo htmlspecialchars($card['id']); ?>">
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Title</label>
                                            <input type="text" class="form-control registration-title-input" name="registration_card_title[]"
                                                   value="<?php echo htmlspecialchars($card['title']); ?>" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Time Slot</label>
                                            <select class="form-control" name="registration_card_time[]" required>
                                                <option value="11:00" <?php echo $card['time_slot'] === '11:00' ? 'selected' : ''; ?>>11:00 AM</option>
                                                <option value="12:00" <?php echo $card['time_slot'] === '12:00' ? 'selected' : ''; ?>>12:00 PM</option>
                                                <option value="13:00" <?php echo $card['time_slot'] === '13:00' ? 'selected' : ''; ?>>1:00 PM</option>
                                                <option value="14:00" <?php echo $card['time_slot'] === '14:00' ? 'selected' : ''; ?>>2:00 PM</option>
                                                <option value="15:00" <?php echo $card['time_slot'] === '15:00' ? 'selected' : ''; ?>>3:00 PM</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Status</label>
                                            <select class="form-control" name="registration_card_status[]" required>
                                                <option value="open" <?php echo $card['status'] === 'open' ? 'selected' : ''; ?>>Open</option>
                                                <option value="closing_soon" <?php echo $card['status'] === 'closing_soon' ? 'selected' : ''; ?>>Closing Soon</option>
                                                <option value="closed" <?php echo $card['status'] === 'closed' ? 'selected' : ''; ?>>Closed</option>
                                                <option value="full" <?php echo $card['status'] === 'full' ? 'selected' : ''; ?>>Full</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Order</label>
                                            <input type="number" class="form-control" name="registration_card_order[]" 
                                                   value="<?php echo $card['order']; ?>" min="1" max="5" required>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Belt Levels</label>
                                            <input type="text" class="form-control" name="registration_card_belt_levels[]"
                                                   value="<?php echo htmlspecialchars($card['belt_levels']); ?>" 
                                                   placeholder="e.g., White belts only" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Location</label>
                                            <input type="text" class="form-control" name="registration_card_location[]"
                                                   value="<?php echo htmlspecialchars($card['location']); ?>" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Icon</label>
                                            <select class="form-control icon-select" name="registration_card_icon[]" required>
                                                <option value="fas fa-clock" <?php echo $card['icon'] === 'fas fa-clock' ? 'selected' : ''; ?>>🕐 Clock</option>
                                                <option value="fas fa-users" <?php echo $card['icon'] === 'fas fa-users' ? 'selected' : ''; ?>>👥 Users</option>
                                                <option value="fas fa-user-check" <?php echo $card['icon'] === 'fas fa-user-check' ? 'selected' : ''; ?>>👤 User Check</option>
                                                <option value="fas fa-calendar-check" <?php echo $card['icon'] === 'fas fa-calendar-check' ? 'selected' : ''; ?>>📅 Calendar Check</option>
                                                <option value="fas fa-star" <?php echo $card['icon'] === 'fas fa-star' ? 'selected' : ''; ?>>⭐ Star</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Registration Link</label>
                                            <input type="url" class="form-control" name="registration_card_link[]"
                                                   value="<?php echo htmlspecialchars($card['registration_link']); ?>"
                                                   placeholder="https://example.com/register" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Additional Notes</label>
                                            <input type="text" class="form-control" name="registration_card_notes[]"
                                                   value="<?php echo htmlspecialchars($card['notes']); ?>"
                                                   placeholder="e.g., Instructor approval required">
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control" name="registration_card_description[]" rows="2" required><?php echo htmlspecialchars($card['description']); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <button type="button" id="add-registration-card-btn" class="btn btn-success mb-3">
                            <i class="fas fa-plus"></i> Add Registration Card
                        </button>
                        
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-kaizen">
                                <i class="fas fa-save"></i> Save Registration Accordion
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Phase 1 MVP Complete -->
                <div class="content-section">
                    <h3 class="section-title"><i class="fas fa-check-circle me-2 text-success"></i>Phase 1 MVP - Complete!</h3>
                    <div class="alert alert-success">
                        <h5><i class="fas fa-rocket me-2"></i>Phase 1 Components - All Complete:</h5>
                        <ul class="mb-3">
                            <li>✅ <strong>Hero Section</strong> - Complete with image upload and content management</li>
                            <li>✅ <strong>Requirements Management</strong> - Complete with CRUD operations</li>
                            <li>✅ <strong>Pilot Accordion</strong> - Complete with nested sections and steps</li>
                            <li>✅ <strong>Basic Lightbox System</strong> - Complete with content management</li>
                        </ul>
                        <p class="mb-0"><strong>Ready for testing!</strong> Please test all components thoroughly before proceeding to Phase 2.</p>
                    </div>
                    
                    <div class="alert alert-info">
                        <h5><i class="fas fa-road me-2"></i>Phase 2 Progress:</h5>
                        <ul class="mb-0">
                            <li>✅ <strong>Requirements to Test Accordion</strong> - Complete with image upload and lightbox management</li>
                            <li>✅ <strong>Belt Exam Clothing Requirements</strong> - Complete with belt-specific cards and shop section</li>
                            <li>✅ <strong>Testing Scripts</strong> - Complete with 9 script cards and lightbox functionality</li>
                            <li>✅ <strong>Upcoming Testing Dates</strong> - Complete with 6 date cards and registration links</li>
                            <li>✅ <strong>Register for Belt Exam</strong> - Complete with 3 registration time slot cards</li>
                        </ul>
                        <div class="alert alert-success mt-3">
                            <h6><i class="fas fa-check-circle me-2"></i>Phase 2 Complete!</h6>
                            <p class="mb-0">All 5 accordions have been built with full CRUD functionality, default data, and draft mode integration.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const requirementsContainer = document.getElementById('requirements-container');
        const addBtn = document.getElementById('add-requirement-btn');
        
        // Handle delete requirement buttons
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-requirement')) {
                const requirementCard = e.target.closest('.requirement-card');
                const requirementId = requirementCard.querySelector('input[name="requirement_id[]"]').value;
                
                if (confirm('Are you sure you want to delete this requirement? This action cannot be undone.')) {
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
                    deleteInput.name = 'delete_requirement';
                    deleteInput.value = '1';
                    
                    const idInput = document.createElement('input');
                    idInput.type = 'hidden';
                    idInput.name = 'requirement_id';
                    idInput.value = requirementId;
                    
                    form.appendChild(csrfInput);
                    form.appendChild(deleteInput);
                    form.appendChild(idInput);
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            }
        });
        
        // Add new requirement
        addBtn.addEventListener('click', function() {
            const requirements = requirementsContainer.querySelectorAll('.requirement-card');
            const newIndex = requirements.length;
            const newId = Date.now(); // Use timestamp as unique ID
            
            const newCard = document.createElement('div');
            newCard.className = 'requirement-card';
            newCard.dataset.index = newIndex;
            
            newCard.innerHTML = `
                <div class="requirement-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="requirement-number">${newIndex + 1}</div>
                        <h6 class="mb-0">Requirement ${newIndex + 1}</h6>
                    </div>
                    <button type="button" class="btn btn-sm btn-danger remove-requirement">
                        <i class="fas fa-trash"></i> Remove
                    </button>
                </div>
                
                <input type="hidden" name="requirement_id[]" value="${newId}">
                
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Icon Class</label>
                        <select class="form-control icon-select" name="requirement_icon[]" required>
                            <option value="fas fa-calendar-check">📅 Calendar Check</option>
                            <option value="fas fa-user-shield">🛡️ User Shield</option>
                            <option value="fas fa-clock">🕐 Clock</option>
                            <option value="fas fa-times-circle">❌ Times Circle</option>
                            <option value="fas fa-envelope">✉️ Envelope</option>
                            <option value="fas fa-exclamation-triangle">⚠️ Warning</option>
                            <option value="fas fa-info-circle" selected>ℹ️ Info Circle</option>
                            <option value="fas fa-check-circle">✅ Check Circle</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Order</label>
                        <input type="number" class="form-control" name="requirement_order[]" 
                               value="${newIndex + 1}" min="1" required>
                    </div>
                    <div class="col-md-7 mb-3">
                        <label class="form-label">Title Text</label>
                        <input type="text" class="form-control" name="requirement_title[]" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Highlight Text (optional)</label>
                        <input type="text" class="form-control" name="requirement_highlight[]"
                               placeholder="Text to highlight within the title (e.g., 'INVITATION ONLY')">
                    </div>
                </div>
            `;
            
            requirementsContainer.appendChild(newCard);
            updateRequirementNumbers();
        });
        
        // Update requirement numbers
        function updateRequirementNumbers() {
            const cards = requirementsContainer.querySelectorAll('.requirement-card');
            cards.forEach((card, index) => {
                card.dataset.index = index;
                card.querySelector('.requirement-number').textContent = index + 1;
                card.querySelector('h6').textContent = `Requirement ${index + 1}`;
            });
        }
        
        // Process Accordion Management
        const processSectionsContainer = document.getElementById('process-sections-container');
        const addSectionBtn = document.getElementById('add-section-btn');
        
        // Add new section
        if (addSectionBtn) {
            addSectionBtn.addEventListener('click', function() {
                const sections = processSectionsContainer.querySelectorAll('.process-section');
                const newSectionIndex = sections.length;
                const newSectionId = 'section_' + Date.now();
                
                const newSection = document.createElement('div');
                newSection.className = 'card mb-3 process-section';
                newSection.dataset.section = newSectionIndex;
                
                newSection.innerHTML = `
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Section ${newSectionIndex + 1}: New Section</h6>
                        <button type="button" class="btn btn-sm btn-danger remove-section">
                            <i class="fas fa-trash"></i> Remove Section
                        </button>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="section_id[]" value="${newSectionId}">
                        
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label class="form-label">Section Title</label>
                                <input type="text" class="form-control" name="section_title[]" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Section Icon</label>
                                <select class="form-control icon-select" name="section_icon[]" required>
                                    <option value="fas fa-medal">🥇 Medal</option>
                                    <option value="fas fa-trophy">🏆 Trophy</option>
                                    <option value="fas fa-star">⭐ Star</option>
                                    <option value="fas fa-graduation-cap">🎓 Graduation Cap</option>
                                </select>
                            </div>
                        </div>
                        
                        <h6>Steps:</h6>
                        <div class="steps-container" data-section-index="${newSectionIndex}">
                        </div>
                        
                        <button type="button" class="btn btn-sm btn-success add-step" data-section="${newSectionIndex}">
                            <i class="fas fa-plus"></i> Add Step
                        </button>
                    </div>
                `;
                
                processSectionsContainer.appendChild(newSection);
                updateSectionNumbers();
            });
        }
        
        // Remove section
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-section')) {
                const section = e.target.closest('.process-section');
                if (confirm('Are you sure you want to remove this section? This action cannot be undone.')) {
                    section.remove();
                    updateSectionNumbers();
                }
            }
        });
        
        // Add step
        document.addEventListener('click', function(e) {
            if (e.target.closest('.add-step')) {
                const btn = e.target.closest('.add-step');
                const sectionIndex = btn.dataset.section;
                const stepsContainer = btn.previousElementSibling;
                
                const newStep = document.createElement('div');
                newStep.className = 'card mb-2 step-card';
                
                newStep.innerHTML = `
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <label class="form-label">Step Title</label>
                                <input type="text" class="form-control" name="step_title[${sectionIndex}][]" required>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="form-label">Step Icon</label>
                                <select class="form-control icon-select" name="step_icon[${sectionIndex}][]" required>
                                    <option value="fas fa-user-check">👤 User Check</option>
                                    <option value="fas fa-users">👥 Users</option>
                                    <option value="fas fa-clipboard-check">📋 Clipboard Check</option>
                                    <option value="fas fa-video">📹 Video</option>
                                    <option value="fas fa-exclamation-triangle">⚠️ Warning</option>
                                </select>
                            </div>
                            <div class="col-md-5 mb-2">
                                <label class="form-label">Step Description</label>
                                <textarea class="form-control" name="step_description[${sectionIndex}][]" rows="2" required></textarea>
                            </div>
                        </div>
                    </div>
                `;
                
                stepsContainer.appendChild(newStep);
            }
        });
        
        // Update section numbers
        function updateSectionNumbers() {
            const sections = processSectionsContainer.querySelectorAll('.process-section');
            sections.forEach((section, index) => {
                section.dataset.section = index;
                section.querySelector('h6').textContent = `Section ${index + 1}: ${section.querySelector('input[name="section_title[]"]').value || 'New Section'}`;
                
                // Update step field names
                const steps = section.querySelectorAll('.step-card');
                steps.forEach(step => {
                    step.querySelector('input[name^="step_title"]').name = `step_title[${index}][]`;
                    step.querySelector('select[name^="step_icon"]').name = `step_icon[${index}][]`;
                    step.querySelector('textarea[name^="step_description"]').name = `step_description[${index}][]`;
                });
                
                section.querySelector('.add-step').dataset.section = index;
                section.querySelector('.steps-container').dataset.sectionIndex = index;
            });
        }
        
        // Lightbox Management
        const lightboxesContainer = document.getElementById('lightboxes-container');
        const addLightboxBtn = document.getElementById('add-lightbox-btn');
        
        // Add new lightbox
        if (addLightboxBtn) {
            addLightboxBtn.addEventListener('click', function() {
                const lightboxes = lightboxesContainer.querySelectorAll('.lightbox-card');
                const newIndex = lightboxes.length;
                const newId = 'lightbox_' + Date.now();
                
                const newLightbox = document.createElement('div');
                newLightbox.className = 'card mb-3 lightbox-card';
                newLightbox.dataset.index = newIndex;
                
                newLightbox.innerHTML = `
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Lightbox: New Lightbox</h6>
                        <button type="button" class="btn btn-sm btn-danger remove-lightbox">
                            <i class="fas fa-trash"></i> Remove
                        </button>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="lightbox_id[]" value="${newId}">
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Lightbox Title</label>
                                <input type="text" class="form-control" name="lightbox_title[]" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Trigger Function</label>
                                <input type="text" class="form-control" name="lightbox_trigger[]"
                                       placeholder="e.g., openTestingTipsLightbox" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Content Type</label>
                                <select class="form-control" name="lightbox_content_type[]" required>
                                    <option value="info">Information</option>
                                    <option value="image">Image</option>
                                    <option value="script">Script/Text</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Content Title</label>
                                <input type="text" class="form-control" name="lightbox_content_title[]" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Content Description</label>
                                <input type="text" class="form-control" name="lightbox_content_description[]" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label">Text Content</label>
                                <textarea class="form-control" name="lightbox_text_content[]" rows="4" required></textarea>
                                <div class="form-text">For 'info' type: main content text. For 'script' type: full script content. For 'image' type: optional caption.</div>
                            </div>
                        </div>
                    </div>
                `;
                
                lightboxesContainer.appendChild(newLightbox);
                updateLightboxHeaders();
            });
        }
        
        // Remove lightbox
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-lightbox')) {
                const lightbox = e.target.closest('.lightbox-card');
                if (confirm('Are you sure you want to remove this lightbox? This action cannot be undone.')) {
                    lightbox.remove();
                    updateLightboxHeaders();
                }
            }
        });
        
        // Update lightbox headers
        function updateLightboxHeaders() {
            const lightboxes = lightboxesContainer.querySelectorAll('.lightbox-card');
            lightboxes.forEach((lightbox, index) => {
                lightbox.dataset.index = index;
                const titleInput = lightbox.querySelector('input[name="lightbox_title[]"]');
                const header = lightbox.querySelector('.card-header h6');
                header.textContent = `Lightbox: ${titleInput.value || 'New Lightbox'}`;
            });
        }
        
        // Update lightbox header when title changes
        document.addEventListener('input', function(e) {
            if (e.target.matches('input[name="lightbox_title[]"]')) {
                updateLightboxHeaders();
            }
        });
        
        // Requirements Accordion Management
        const addNoteBtn = document.getElementById('add-note-btn');
        const notesContainer = document.getElementById('additional-notes-container');
        const requirementImagesContainer = document.getElementById('requirement-images-container');
        const addRequirementImageBtn = document.getElementById('add-requirement-image-btn');
        
        // Add additional note
        if (addNoteBtn) {
            addNoteBtn.addEventListener('click', function() {
                const noteGroup = document.createElement('div');
                noteGroup.className = 'input-group mb-2';
                noteGroup.innerHTML = `
                    <input type="text" class="form-control" name="additional_note[]" placeholder="Enter additional note">
                    <button type="button" class="btn btn-danger remove-note"><i class="fas fa-trash"></i></button>
                `;
                notesContainer.appendChild(noteGroup);
            });
        }
        
        // Remove additional note
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-note')) {
                e.target.closest('.input-group').remove();
            }
        });
        
        // Add requirement image
        if (addRequirementImageBtn) {
            addRequirementImageBtn.addEventListener('click', function() {
                const images = requirementImagesContainer.querySelectorAll('.requirement-image-card');
                const newIndex = images.length;
                const newId = 'requirement_image_' + Date.now();
                
                const newImage = document.createElement('div');
                newImage.className = 'card mb-3 requirement-image-card';
                newImage.dataset.index = newIndex;
                
                newImage.innerHTML = `
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Requirement Image: New Image</h6>
                        <button type="button" class="btn btn-sm btn-danger remove-requirement-image">
                            <i class="fas fa-trash"></i> Remove
                        </button>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="req_image_id[]" value="${newId}">
                        <input type="hidden" name="req_image_path[]" value="">
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control req-title-input" name="req_image_title[]" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Icon</label>
                                <select class="form-control icon-select" name="req_image_icon[]" required>
                                    <option value="fas fa-th">🔲 Grid</option>
                                    <option value="fas fa-clipboard-list">📋 Clipboard</option>
                                    <option value="fas fa-star">⭐ Star</option>
                                    <option value="fas fa-image">🖼️ Image</option>
                                    <option value="fas fa-file-alt">📄 Document</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Order</label>
                                <input type="number" class="form-control" name="req_image_order[]" 
                                       value="${newIndex + 1}" min="1" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Lightbox Function</label>
                                <input type="text" class="form-control" name="req_lightbox_function[]"
                                       placeholder="e.g., openMatrixLightbox" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <input type="text" class="form-control" name="req_image_description[]" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Image Upload</label>
                                <input type="file" class="form-control" name="req_image_file[]" accept="image/*">
                                <div class="form-text">Max 5MB, JPG/PNG/WebP</div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Download URL</label>
                                <input type="text" class="form-control" name="req_download_url[]"
                                       placeholder="Optional - defaults to image path">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Download Filename</label>
                                <input type="text" class="form-control" name="req_download_filename[]"
                                       placeholder="e.g., kaizen-testing-matrix.png">
                            </div>
                        </div>
                    </div>
                `;
                
                requirementImagesContainer.appendChild(newImage);
                updateRequirementImageHeaders();
            });
        }
        
        // Remove requirement image
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-requirement-image')) {
                const imageCard = e.target.closest('.requirement-image-card');
                if (confirm('Are you sure you want to remove this requirement image? This action cannot be undone.')) {
                    imageCard.remove();
                    updateRequirementImageHeaders();
                }
            }
        });
        
        // Update requirement image headers
        function updateRequirementImageHeaders() {
            const images = requirementImagesContainer.querySelectorAll('.requirement-image-card');
            images.forEach((image, index) => {
                image.dataset.index = index;
                const titleInput = image.querySelector('.req-title-input');
                const header = image.querySelector('.card-header h6');
                header.textContent = `Requirement Image: ${titleInput.value || 'New Image'}`;
            });
        }
        
        // Update requirement image header when title changes
        document.addEventListener('input', function(e) {
            if (e.target.matches('.req-title-input')) {
                updateRequirementImageHeaders();
            }
        });
        
        // Clothing Accordion Management
        const clothingCardsContainer = document.getElementById('clothing-cards-container');
        const addClothingCardBtn = document.getElementById('add-clothing-card-btn');
        
        // Add new clothing card
        if (addClothingCardBtn) {
            addClothingCardBtn.addEventListener('click', function() {
                const cards = clothingCardsContainer.querySelectorAll('.clothing-card');
                const newIndex = cards.length;
                const newId = 'clothing_card_' + Date.now();
                
                const newCard = document.createElement('div');
                newCard.className = 'card mb-3 clothing-card';
                newCard.dataset.index = newIndex;
                
                newCard.innerHTML = `
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Clothing Card: New Card</h6>
                        <button type="button" class="btn btn-sm btn-danger remove-clothing-card">
                            <i class="fas fa-trash"></i> Remove
                        </button>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="clothing_card_id[]" value="${newId}">
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Card Title</label>
                                <input type="text" class="form-control clothing-title-input" name="clothing_card_title[]" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Belt Color</label>
                                <select class="form-control" name="clothing_belt_color[]" required>
                                    <option value="">Select Belt Color</option>
                                    <option value="white">White</option>
                                    <option value="orange">Orange</option>
                                    <option value="yellow">Yellow</option>
                                    <option value="green">Green</option>
                                    <option value="purple">Purple</option>
                                    <option value="blue">Blue</option>
                                    <option value="brown">Brown</option>
                                    <option value="red">Red</option>
                                    <option value="black">Black</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Stripe Color (Optional)</label>
                                <select class="form-control" name="clothing_stripe_color[]">
                                    <option value="">No Stripe</option>
                                    <option value="black">Black Stripe</option>
                                    <option value="white">White Stripe</option>
                                    <option value="red">Red Stripe</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Order</label>
                                <input type="number" class="form-control" name="clothing_card_order[]" 
                                       value="${newIndex + 1}" min="1" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label">Additional Notes</label>
                                <textarea class="form-control" name="clothing_additional_notes[]" rows="2"></textarea>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Uniform Requirements</label>
                            <div class="clothing-requirements-container" data-card-index="${newIndex}">
                            </div>
                            <button type="button" class="btn btn-sm btn-success add-clothing-requirement" data-card="${newIndex}">
                                <i class="fas fa-plus"></i> Add Requirement
                            </button>
                        </div>
                    </div>
                `;
                
                clothingCardsContainer.appendChild(newCard);
                updateClothingCardHeaders();
            });
        }
        
        // Remove clothing card
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-clothing-card')) {
                const card = e.target.closest('.clothing-card');
                if (confirm('Are you sure you want to remove this clothing card? This action cannot be undone.')) {
                    card.remove();
                    updateClothingCardHeaders();
                }
            }
        });
        
        // Add clothing requirement
        document.addEventListener('click', function(e) {
            if (e.target.closest('.add-clothing-requirement')) {
                const btn = e.target.closest('.add-clothing-requirement');
                const cardIndex = btn.dataset.card;
                const container = btn.previousElementSibling;
                
                const requirementGroup = document.createElement('div');
                requirementGroup.className = 'input-group mb-2';
                requirementGroup.innerHTML = `
                    <input type="text" class="form-control" name="clothing_requirements[${cardIndex}][]" placeholder="Enter requirement">
                    <button type="button" class="btn btn-danger remove-clothing-requirement"><i class="fas fa-trash"></i></button>
                `;
                
                container.appendChild(requirementGroup);
            }
        });
        
        // Remove clothing requirement
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-clothing-requirement')) {
                e.target.closest('.input-group').remove();
            }
        });
        
        // Update clothing card headers
        function updateClothingCardHeaders() {
            const cards = clothingCardsContainer.querySelectorAll('.clothing-card');
            cards.forEach((card, index) => {
                card.dataset.index = index;
                const titleInput = card.querySelector('.clothing-title-input');
                const header = card.querySelector('.card-header h6');
                header.textContent = `Clothing Card: ${titleInput.value || 'New Card'}`;
                
                // Update requirements field names
                const requirements = card.querySelectorAll('.clothing-requirements-container input');
                requirements.forEach(req => {
                    req.name = `clothing_requirements[${index}][]`;
                });
                
                // Update container data attribute
                const container = card.querySelector('.clothing-requirements-container');
                if (container) {
                    container.dataset.cardIndex = index;
                }
                
                // Update add button data attribute
                const addBtn = card.querySelector('.add-clothing-requirement');
                if (addBtn) {
                    addBtn.dataset.card = index;
                }
            });
        }
        
        // Update clothing card header when title changes
        document.addEventListener('input', function(e) {
            if (e.target.matches('.clothing-title-input')) {
                updateClothingCardHeaders();
            }
        });
        
        // Testing Scripts Accordion Management
        const scriptCardsContainer = document.getElementById('script-cards-container');
        const addScriptCardBtn = document.getElementById('add-script-card-btn');
        
        // Add new script card
        if (addScriptCardBtn) {
            addScriptCardBtn.addEventListener('click', function() {
                const cards = scriptCardsContainer.querySelectorAll('.script-card');
                const newIndex = cards.length;
                const newId = 'script_card_' + Date.now();
                
                const newCard = document.createElement('div');
                newCard.className = 'card mb-3 script-card';
                newCard.dataset.index = newIndex;
                
                newCard.innerHTML = `
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Script Card: New Script Card</h6>
                        <button type="button" class="btn btn-sm btn-danger remove-script-card">
                            <i class="fas fa-trash"></i> Remove
                        </button>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="script_card_id[]" value="${newId}">
                        
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Card Title</label>
                                <input type="text" class="form-control script-title-input" name="script_card_title[]" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Icon</label>
                                <select class="form-control icon-select" name="script_card_icon[]" required>
                                    <option value="fas fa-scroll">📜 Scroll</option>
                                    <option value="fas fa-lightbulb">💡 Lightbulb</option>
                                    <option value="fas fa-video">📹 Video</option>
                                    <option value="fas fa-file-alt">📄 Document</option>
                                    <option value="fas fa-clipboard-check">📋 Clipboard</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Belt Color</label>
                                <select class="form-control" name="script_belt_color[]">
                                    <option value="">No Specific Belt</option>
                                    <option value="green">Green</option>
                                    <option value="purple">Purple</option>
                                    <option value="blue">Blue</option>
                                    <option value="brown">Brown</option>
                                    <option value="red">Red</option>
                                    <option value="black">Black</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Order</label>
                                <input type="number" class="form-control" name="script_card_order[]" 
                                       value="${newIndex + 1}" min="1" max="9" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Stripe Color (Optional)</label>
                                <select class="form-control" name="script_stripe_color[]">
                                    <option value="">No Stripe</option>
                                    <option value="black">Black Stripe</option>
                                    <option value="white">White Stripe</option>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Lightbox Function</label>
                                <input type="text" class="form-control" name="script_lightbox_function[]"
                                       placeholder="e.g., openGreenBeltLightbox" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <input type="text" class="form-control" name="script_card_description[]" required>
                            </div>
                        </div>
                    </div>
                `;
                
                scriptCardsContainer.appendChild(newCard);
                updateScriptCardHeaders();
            });
        }
        
        // Remove script card
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-script-card')) {
                const card = e.target.closest('.script-card');
                if (confirm('Are you sure you want to remove this script card? This action cannot be undone.')) {
                    card.remove();
                    updateScriptCardHeaders();
                }
            }
        });
        
        // Update script card headers
        function updateScriptCardHeaders() {
            const cards = scriptCardsContainer.querySelectorAll('.script-card');
            cards.forEach((card, index) => {
                card.dataset.index = index;
                const titleInput = card.querySelector('.script-title-input');
                const header = card.querySelector('.card-header h6');
                header.textContent = `Script Card: ${titleInput.value || 'New Script Card'}`;
            });
        }
        
        // Update script card header when title changes
        document.addEventListener('input', function(e) {
            if (e.target.matches('.script-title-input')) {
                updateScriptCardHeaders();
            }
        });
        
        // Testing Dates Accordion Management
        const dateCardsContainer = document.getElementById('date-cards-container');
        const addDateCardBtn = document.getElementById('add-date-card-btn');
        
        // Add new date card
        if (addDateCardBtn) {
            addDateCardBtn.addEventListener('click', function() {
                const cards = dateCardsContainer.querySelectorAll('.date-card');
                const newIndex = cards.length;
                const newId = 'date_card_' + Date.now();
                
                const newCard = document.createElement('div');
                newCard.className = 'card mb-3 date-card';
                newCard.dataset.index = newIndex;
                
                newCard.innerHTML = `
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Date Card: New Date Card</h6>
                        <button type="button" class="btn btn-sm btn-danger remove-date-card">
                            <i class="fas fa-trash"></i> Remove
                        </button>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="date_card_id[]" value="${newId}">
                        
                        <!-- Basic Info Row -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Month/Year Title</label>
                                <input type="text" class="form-control date-title-input" name="date_card_month_year[]"
                                       placeholder="e.g., November 2025" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Icon</label>
                                <select class="form-control icon-select" name="date_card_icon[]" required>
                                    <option value="fas fa-calendar-day">📅 Calendar Day</option>
                                    <option value="fas fa-clock">🕐 Clock</option>
                                    <option value="fas fa-calendar-alt">📅 Calendar</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Order</label>
                                <input type="number" class="form-control" name="date_card_order[]" 
                                       value="${newIndex + 1}" min="1" max="6" required>
                            </div>
                        </div>
                        
                        <!-- Location Info Row -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Location Name</label>
                                <input type="text" class="form-control" name="date_card_location_name[]"
                                       placeholder="e.g., East Silver Spring ES - GYM" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Street Address</label>
                                <input type="text" class="form-control" name="date_card_street_address[]"
                                       placeholder="e.g., 631 Silver Spring Ave" required>
                            </div>
                        </div>
                        
                        <!-- Address & DateTime Row -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">City, State ZIP</label>
                                <input type="text" class="form-control" name="date_card_city_state_zip[]"
                                       placeholder="e.g., Silver Spring, MD 20910" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Date & Time String</label>
                                <input type="text" class="form-control" name="date_card_datetime_string[]"
                                       placeholder="e.g., Saturday, November 15th - 11:00 AM Start Time" required>
                            </div>
                        </div>
                        
                        <!-- Registration Info Row -->
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label class="form-label">Registration Link Text</label>
                                <input type="text" class="form-control" name="date_card_link_text[]"
                                       value="For more details and registration, click here"
                                       placeholder="For more details and registration, click here">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Make-up Month</label>
                                <input type="text" class="form-control" name="date_card_makeup_month[]"
                                       placeholder="e.g., January 2026">
                            </div>
                        </div>
                        
                        <!-- Standard Notes Section -->
                        <h6 class="mb-3">Standard Notes (4 notes per card)</h6>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Youth Testing Note</label>
                                <input type="text" class="form-control" name="date_card_youth_note[]"
                                       value="*Youth testing takes place on Saturdays"
                                       placeholder="*Youth testing takes place on Saturdays">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Adult Testing Note</label>
                                <input type="text" class="form-control" name="date_card_adult_note[]"
                                       value="*Adult testing takes place on Monday nights"
                                       placeholder="*Adult testing takes place on Monday nights">
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label">Video Testing Note</label>
                                <input type="text" class="form-control" name="date_card_video_note[]"
                                       value="Video tests due 1 month prior to testing date (green belt and above). NO EXCEPTIONS."
                                       placeholder="Video tests due 1 month prior to testing date (green belt and above). NO EXCEPTIONS.">
                            </div>
                        </div>
                    </div>
                `;
                
                dateCardsContainer.appendChild(newCard);
                updateDateCardHeaders();
            });
        }
        
        // Remove date card
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-date-card')) {
                const card = e.target.closest('.date-card');
                if (confirm('Are you sure you want to remove this date card? This action cannot be undone.')) {
                    card.remove();
                    updateDateCardHeaders();
                }
            }
        });
        
        // Update date card headers
        function updateDateCardHeaders() {
            const cards = dateCardsContainer.querySelectorAll('.date-card');
            cards.forEach((card, index) => {
                card.dataset.index = index;
                const titleInput = card.querySelector('.date-title-input');
                const header = card.querySelector('.card-header h6');
                header.textContent = `Date Card: ${titleInput.value || 'New Date Card'}`;
            });
        }
        
        // Update date card header when title changes
        document.addEventListener('input', function(e) {
            if (e.target.matches('.date-title-input')) {
                updateDateCardHeaders();
            }
        });
        
        // Registration Accordion Management
        const registrationCardsContainer = document.getElementById('registration-cards-container');
        const addRegistrationCardBtn = document.getElementById('add-registration-card-btn');
        
        // Add new registration card
        if (addRegistrationCardBtn) {
            addRegistrationCardBtn.addEventListener('click', function() {
                const cards = registrationCardsContainer.querySelectorAll('.registration-card');
                const newIndex = cards.length;
                const newId = 'registration_card_' + Date.now();
                
                const newCard = document.createElement('div');
                newCard.className = 'card mb-3 registration-card';
                newCard.dataset.index = newIndex;
                
                newCard.innerHTML = `
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Registration Card: New Registration Card</h6>
                        <button type="button" class="btn btn-sm btn-danger remove-registration-card">
                            <i class="fas fa-trash"></i> Remove
                        </button>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="registration_card_id[]" value="${newId}">
                        
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control registration-title-input" name="registration_card_title[]" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Time Slot</label>
                                <select class="form-control" name="registration_card_time[]" required>
                                    <option value="11:00">11:00 AM</option>
                                    <option value="12:00">12:00 PM</option>
                                    <option value="13:00">1:00 PM</option>
                                    <option value="14:00">2:00 PM</option>
                                    <option value="15:00">3:00 PM</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="registration_card_status[]" required>
                                    <option value="open">Open</option>
                                    <option value="closing_soon">Closing Soon</option>
                                    <option value="closed">Closed</option>
                                    <option value="full">Full</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Order</label>
                                <input type="number" class="form-control" name="registration_card_order[]" 
                                       value="${newIndex + 1}" min="1" max="5" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Belt Levels</label>
                                <input type="text" class="form-control" name="registration_card_belt_levels[]"
                                       placeholder="e.g., White belts only" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Location</label>
                                <input type="text" class="form-control" name="registration_card_location[]" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Icon</label>
                                <select class="form-control icon-select" name="registration_card_icon[]" required>
                                    <option value="fas fa-clock">🕐 Clock</option>
                                    <option value="fas fa-users">👥 Users</option>
                                    <option value="fas fa-user-check">👤 User Check</option>
                                    <option value="fas fa-calendar-check">📅 Calendar Check</option>
                                    <option value="fas fa-star">⭐ Star</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Registration Link</label>
                                <input type="url" class="form-control" name="registration_card_link[]"
                                       placeholder="https://example.com/register" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Additional Notes</label>
                                <input type="text" class="form-control" name="registration_card_notes[]"
                                       placeholder="e.g., Instructor approval required">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="registration_card_description[]" rows="2" required></textarea>
                            </div>
                        </div>
                    </div>
                `;
                
                registrationCardsContainer.appendChild(newCard);
                updateRegistrationCardHeaders();
            });
        }
        
        // Remove registration card
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-registration-card')) {
                const card = e.target.closest('.registration-card');
                if (confirm('Are you sure you want to remove this registration card? This action cannot be undone.')) {
                    card.remove();
                    updateRegistrationCardHeaders();
                }
            }
        });
        
        // Update registration card headers
        function updateRegistrationCardHeaders() {
            const cards = registrationCardsContainer.querySelectorAll('.registration-card');
            cards.forEach((card, index) => {
                card.dataset.index = index;
                const titleInput = card.querySelector('.registration-title-input');
                const header = card.querySelector('.card-header h6');
                header.textContent = `Registration Card: ${titleInput.value || 'New Registration Card'}`;
            });
        }
        
        // Update registration card header when title changes
        document.addEventListener('input', function(e) {
            if (e.target.matches('.registration-title-input')) {
                updateRegistrationCardHeaders();
            }
        });
    });
    </script>
</body>
</html>