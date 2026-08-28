<?php
session_start();

require_once __DIR__ . '/chatbot-php/BusinessChatbotEngine.php';

$engine = new BusinessChatbotEngine(session_id());
$errors = [];
$notices = [];

$goal = $_SESSION['biz_goal'] ?? '';
$savedFiles = $_SESSION['biz_files'] ?? [];
$fileDescription = $_SESSION['biz_file_description'] ?? '';

if (isset($_GET['reset'])) {
    $engine->resetSessionStorage();
    $_SESSION['biz_goal'] = '';
    $_SESSION['biz_prompt'] = '';
    $_SESSION['biz_files'] = [];
    $_SESSION['biz_history'] = [];
    $_SESSION['biz_file_description'] = '';
    $goal = '';
    $savedFiles = [];
    $fileDescription = '';
    $notices[] = 'Session cleared. Start fresh below.';
}

function escapeHtml($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function humanFileSize($bytes) {
    $units = ['B', 'KB', 'MB', 'GB'];
    $i = 0;
    while ($bytes >= 1024 && $i < count($units) - 1) {
        $bytes /= 1024;
        $i++;
    }
    return round($bytes, 1) . ' ' . $units[$i];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $goal = trim($_POST['goal'] ?? '');
    $fileDescription = trim($_POST['file_description'] ?? $fileDescription);
    $_SESSION['biz_file_description'] = $fileDescription;

    if ($goal === '') {
        $errors[] = 'Please tell us what you would like to accomplish.';
    }

$uploaded = [];
$incomingNames = isset($_FILES['support_files']['name'])
    ? array_filter((array)$_FILES['support_files']['name'], fn($name) => !empty($name))
    : [];
if (!empty($incomingNames)) {
    $uploadResult = $engine->saveUploadedFiles($_FILES['support_files']);
        if (!empty($uploadResult['errors'])) {
            foreach ($uploadResult['errors'] as $error) {
                $errors[] = $error['error'];
            }
        }
        if (!empty($uploadResult['saved'])) {
            $uploaded = $uploadResult['saved'];
            $savedFiles = array_merge($savedFiles, $uploaded);
            $notices[] = count($uploaded) . ' file(s) ready for this session.';
        }
    }

    if (empty($errors)) {
        $parsed = !empty($savedFiles)
            ? $engine->parseSavedFiles($savedFiles)
            : ['files' => [], 'combined_text' => '', 'summaries' => []];
        $prompt = $engine->generateSystemPrompt($goal, $parsed['summaries']);

        $_SESSION['biz_goal'] = $goal;
        $_SESSION['biz_prompt'] = $prompt;
        $_SESSION['biz_files'] = $savedFiles;
        $_SESSION['biz_history'] = [];
        $_SESSION['biz_file_description'] = $fileDescription;

        header('Location: chatbot-business-review.php');
        exit;
    }
}

$suggestions = [
    'Draft email templates for common parent questions',
    'Review our policies and identify areas that need clarification',
    'Analyze NYC competitor schools and compare their programs to ours',
    'Create social media post text showcasing our programs',
    'Write compelling program descriptions for our website',
    'Generate FAQ answers based on our current offerings'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kaizen Business Assistant</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/style.css?v=<?php echo time(); ?>">
    <style>
        :root {
            --assistant-bg: #fefafb;
            --assistant-panel: #ffffff;
        }
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            background: var(--assistant-bg);
            color: var(--text-dark);
        }
        .kaizen-header {
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-light) 100%);
            color: #fff;
            padding: 60px 20px 80px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .kaizen-header::after {
            content: '';
            position: absolute;
            inset: 0;
            background: url('assets/images/patterns/subtle-grid.png');
            opacity: 0.1;
        }
        .kaizen-header-inner {
            position: relative;
            z-index: 1;
            max-width: 960px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
        }
        .kaizen-brand {
            display: flex;
            align-items: center;
            gap: 16px;
            text-decoration: none;
            color: inherit;
        }
        .kaizen-brand img {
            width: 80px;
            height: auto;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.25);
        }
        .kaizen-brand-text {
            text-align: left;
        }
        .kaizen-brand-text .brand-name {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 1px;
        }
        .kaizen-brand-text .brand-tagline {
            font-size: 0.95rem;
            opacity: 0.9;
        }
        .kaizen-header p {
            margin: 10px 0 0;
            font-size: 1.1rem;
        }
        main {
            max-width: 800px;
            margin: -60px auto 60px;
            padding: 0 20px;
        }
        .card {
            background: var(--assistant-panel);
            border-radius: 24px;
            padding: 36px;
            box-shadow: 0 25px 60px rgba(7, 16, 39, 0.12);
            position: relative;
        }
        label {
            font-weight: 600;
            display: block;
            margin-bottom: 12px;
            color: var(--text-dark);
        }
        textarea {
            width: 100%;
            min-height: 140px;
            border: 1px solid #e2e4ec;
            border-radius: 16px;
            padding: 18px;
            font-size: 16px;
            resize: vertical;
            background: #fff;
            box-shadow: inset 0 1px 4px rgba(0,0,0,0.03);
        }
        .suggestions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 18px 0 28px;
        }
        .suggestions button {
            border: 1px solid rgba(164, 51, 43, 0.2);
            padding: 10px 16px;
            border-radius: 999px;
            background: rgba(164, 51, 43, 0.08);
            color: var(--accent);
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
        }
        .suggestions button:hover {
            background: rgba(164, 51, 43, 0.18);
        }
        .optional-section {
            margin-top: 10px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .btn-secondary {
            width: 100%;
            padding: 16px;
            border-radius: 16px;
            background: #fff;
            border: 2px solid rgba(164, 51, 43, 0.4);
            color: var(--accent);
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 6px 16px rgba(164, 51, 43, 0.08);
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .btn-secondary:hover {
            background: rgba(164, 51, 43, 0.05);
            border-color: rgba(164, 51, 43, 0.6);
        }
        .helper-text {
            font-size: 13px;
            color: #6c768f;
            line-height: 1.6;
            max-width: 100%;
        }
        .upload-area {
            margin-top: 18px;
            padding: 20px;
            border: 1px dashed rgba(164, 51, 43, 0.4);
            border-radius: 16px;
            background: #fff7f6;
            display: none;
        }
        .upload-area.active {
            display: block;
        }
        .btn-primary {
            width: 100%;
            padding: 18px;
            border: none;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-light) 100%);
            color: #fff;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 30px;
            box-shadow: 0 16px 28px rgba(164, 51, 43, 0.28);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .status {
            margin-bottom: 15px;
            padding: 12px 15px;
            border-radius: 12px;
            background: #e7f3ff;
            color: #0f3a75;
        }
        .status.error {
            background: #ffe9e7;
            color: #8b1f1a;
        }
        .file-list {
            margin-top: 20px;
            border-top: 1px solid #eedede;
            padding-top: 15px;
        }
        .file-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            font-size: 14px;
            border-bottom: 1px solid #f5eaea;
            color: var(--text-medium);
        }
        .small-note {
            font-size: 13px;
            color: var(--text-light);
        }
        a.reset-link {
            color: var(--accent);
            font-weight: 600;
            text-decoration: none;
        }
        @media (max-width: 600px) {
            .kaizen-brand {
                flex-direction: column;
            }
            .kaizen-header {
                padding: 50px 20px 70px;
            }
            .card {
                padding: 28px;
            }
        }
    </style>
</head>
<body>
    <header class="kaizen-header">
        <div class="kaizen-header-inner">
            <a class="kaizen-brand" href="/">
                <img src="assets/images/logo.png" alt="Kaizen Karate Logo">
                <div class="kaizen-brand-text">
                    <span class="brand-name">Kaizen Karate</span>
                    <span class="brand-tagline">Business Assistant</span>
                </div>
            </a>
            <p>AI-powered insights using your business data</p>
        </div>
    </header>
    <main>
        <div class="card">
            <?php foreach ($notices as $notice): ?>
                <div class="status"><?= escapeHtml($notice) ?></div>
            <?php endforeach; ?>
            <?php foreach ($errors as $error): ?>
                <div class="status error"><?= escapeHtml($error) ?></div>
            <?php endforeach; ?>
            <form method="post" enctype="multipart/form-data">
                <label for="goal">What would you like to accomplish?</label>
                <textarea id="goal" name="goal" placeholder="Example: Create social media posts showcasing our summer camp and after-school programs."><?= escapeHtml($goal) ?></textarea>

                <div class="suggestions">
                    <?php foreach ($suggestions as $text): ?>
                        <button type="button" class="suggestion" data-text="<?= escapeHtml($text) ?>"><?= escapeHtml($text) ?></button>
                    <?php endforeach; ?>
                </div>

                <div class="optional-section">
                    <button type="button" class="btn-secondary" id="toggle-files">
                        📎 Add Supporting Files (Optional)
                    </button>
                    <p class="helper-text">
                        Upload competitor data, research documents, or reference materials to enhance the AI's analysis.
                        The chatbot already knows Kaizen’s full business data—add files only when you need additional context.
                    </p>
                </div>

                <div class="upload-area <?= !empty($savedFiles) ? 'active' : '' ?>" id="upload-area">
                    <label for="support_files">Choose Files</label>
                    <input type="file" name="support_files[]" multiple id="support_files">
                    <p class="small-note">
                        CSV, XLS/XLSX, PDF, TXT, MD, JSON • 10MB per file • 50MB total session.
                    </p>

                    <label for="file_description" style="margin-top: 20px;">What's in these files?</label>
                    <textarea 
                        id="file_description" 
                        name="file_description" 
                        rows="3" 
                        placeholder="Example: 15 NYC karate schools with pricing, programs, and Instagram data"
                        style="width: 100%; padding: 12px; border: 1px solid #d9dfea; border-radius: 12px; font-size: 15px;"
                    ><?= escapeHtml($fileDescription) ?></textarea>
                    <p class="small-note" style="margin-top: 8px;">
                        Describing your files helps the AI provide better analysis.
                    </p>

                    <?php if (!empty($savedFiles)): ?>
                        <div class="file-list">
                            <?php foreach ($savedFiles as $file): ?>
                                <div class="file-item">
                                    <span><?= escapeHtml($file['original_name']) ?></span>
                                    <span><?= escapeHtml(humanFileSize($file['size'])) ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn-primary">Start Chat</button>
            </form>
            <p class="small-note" style="text-align:center; margin-top:15px;">
                Want to start over? <a class="reset-link" href="?reset=1">Clear session</a>
            </p>
        </div>
    </main>
    <script>
        const suggestionButtons = document.querySelectorAll('.suggestion');
        const goalField = document.getElementById('goal');
        suggestionButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                goalField.value = btn.dataset.text;
                goalField.focus();
            });
        });

        const toggleLink = document.getElementById('toggle-files');
        const uploadArea = document.getElementById('upload-area');
        const defaultLabel = '📎 Add Supporting Files (Optional)';
        const activeLabel = 'Hide Supporting Files';
        function updateToggleLabel() {
            toggleLink.textContent = uploadArea.classList.contains('active') ? activeLabel : defaultLabel;
        }
        toggleLink.addEventListener('click', () => {
            uploadArea.classList.toggle('active');
            updateToggleLabel();
        });
        updateToggleLabel();
    </script>
</body>
</html>
