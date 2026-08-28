<?php
session_start();

require_once __DIR__ . '/../chatbot-php/BusinessChatbotEngine.php';

$goal = $_SESSION['biz_goal'] ?? '';
$instructions = $_SESSION['biz_prompt'] ?? '';
$savedFiles = $_SESSION['biz_files'] ?? [];
$fileDescription = $_SESSION['biz_file_description'] ?? '';
$conversationHistory = $_SESSION['biz_history'] ?? [];

if (empty($goal) || empty($instructions)) {
    header('Location: chatbot-business-setup.php');
    exit;
}

$engine = new BusinessChatbotEngine(session_id());
$errors = [];
$notices = [];
$refineNotes = '';

function escapeHtml($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $currentInstructions = trim($_POST['instructions'] ?? $instructions);
    $refineNotes = trim($_POST['refine_notes'] ?? '');

    if ($action === 'start_chat') {
        $_SESSION['biz_prompt'] = $currentInstructions;
        header('Location: chatbot-business-chat.php');
        exit;
    }

    if ($action === 'refine_instructions') {
        if ($refineNotes === '') {
            $errors[] = 'Please describe what needs to change before refining.';
        } else {
            try {
                $messages = [
                    [
                        'role' => 'system',
                        'content' => "You improve Kaizen chat instructions based on change requests. Keep the structure clear, respectful, and aligned with Kaizen branding."
                    ],
                    [
                        'role' => 'user',
                        'content' => "Original Goal:\n{$goal}\n\n" .
                            (!empty($fileDescription) ? "File Description:\n{$fileDescription}\n\n" : "") .
                            "Current Instructions:\n{$currentInstructions}\n\nRequested Changes:\n{$refineNotes}\n\nRevise the instructions accordingly. Keep them concise, actionable, and fully aligned with Kaizen's official data."
                    ]
                ];
                $newInstructions = $engine->callPromptRefiner($messages);
                $instructions = trim($newInstructions);
                $_SESSION['biz_prompt'] = $instructions;
                $refineNotes = '';
                $notices[] = 'Instructions updated.';
            } catch (Exception $e) {
                $errors[] = $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Review Chat Instructions | Kaizen Business Assistant</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/style.css?v=<?php echo time(); ?>">
    <style>
        body {
            margin: 0;
            font-family: 'Montserrat', sans-serif;
            background: var(--secondary);
            color: var(--text-dark);
        }
        .review-header {
            background: rgba(255, 255, 255, 0.96);
            border-bottom: 1px solid rgba(164, 51, 43, 0.1);
            padding: 22px 24px;
            display: flex;
            align-items: center;
            gap: 18px;
            box-shadow: 0 12px 25px rgba(0,0,0,0.06);
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .review-header a {
            color: var(--accent);
            font-weight: 600;
            text-decoration: none;
        }
        .review-main {
            max-width: 900px;
            margin: 30px auto 60px;
            padding: 0 20px;
        }
        .panel {
            background: #fff;
            border-radius: 24px;
            padding: 32px;
            box-shadow: 0 25px 60px rgba(7, 16, 39, 0.12);
        }
        .status {
            border-radius: 12px;
            padding: 12px 15px;
            margin-bottom: 15px;
        }
        .status.notice {
            background: #e7f3ff;
            color: #0f3a75;
        }
        .status.error {
            background: #ffe9e7;
            color: #8b1f1a;
        }
        textarea {
            width: 100%;
            border-radius: 18px;
            border: 1px solid #e1e4ec;
            padding: 16px;
            font-size: 15px;
            resize: vertical;
            background: #fff;
            box-shadow: inset 0 1px 5px rgba(0,0,0,0.03);
        }
        .goal-box {
            border-radius: 18px;
            background: #fff6f5;
            border: 1px solid rgba(164, 51, 43, 0.2);
            padding: 18px;
            font-size: 15px;
            color: var(--text-dark);
            margin-bottom: 25px;
        }
        .actions {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        .btn-primary {
            flex: 1 1 260px;
            padding: 16px;
            border: none;
            border-radius: 18px;
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-light) 100%);
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 16px 28px rgba(164, 51, 43, 0.25);
            text-transform: uppercase;
        }
        .btn-secondary {
            flex: 1 1 220px;
            padding: 16px;
            border-radius: 18px;
            border: 2px solid rgba(164, 51, 43, 0.3);
            background: #fff;
            color: var(--accent);
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        }
        .btn-secondary:hover {
            border-color: rgba(164, 51, 43, 0.6);
        }
        label {
            font-weight: 600;
            margin-bottom: 10px;
            display: block;
        }
    </style>
</head>
<body>
    <div class="review-header">
        <a href="chatbot-business-setup.php?reset=1">← Back to Setup</a>
        <h4 class="m-0">Kaizen Business Assistant</h4>
    </div>
    <main class="review-main">
        <div class="panel">
            <?php foreach ($notices as $notice): ?>
                <div class="status notice"><?= escapeHtml($notice) ?></div>
            <?php endforeach; ?>
            <?php foreach ($errors as $error): ?>
                <div class="status error"><?= escapeHtml($error) ?></div>
            <?php endforeach; ?>

            <h2>Review Your Chat Instructions</h2>
            <p style="color:#6c768f;">These instructions tell the assistant how to help. Make sure they match what you need.</p>

            <label>Your Goal</label>
            <div class="goal-box"><?= nl2br(escapeHtml($goal)) ?></div>

            <form method="post">
                <label for="instructions">Chat Instructions</label>
                <textarea id="instructions" name="instructions" rows="10"><?= escapeHtml($instructions) ?></textarea>

                <label for="refine_notes" style="margin-top:25px;">Want to improve these instructions?</label>
                <textarea id="refine_notes" name="refine_notes" rows="4" placeholder="Describe what you'd like to change..."><?= escapeHtml($refineNotes) ?></textarea>

                <div class="actions">
                    <button type="submit" name="action" value="refine_instructions" class="btn-secondary">
                        Improve Instructions
                    </button>
                    <button type="submit" name="action" value="start_chat" class="btn-primary">
                        Start Chat With These Instructions
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
