<?php
session_start();

require_once __DIR__ . '/chatbot-php/BusinessChatbotEngine.php';

$goal = $_SESSION['biz_goal'] ?? '';
$prompt = $_SESSION['biz_prompt'] ?? '';
$savedFiles = $_SESSION['biz_files'] ?? [];
$fileDescription = $_SESSION['biz_file_description'] ?? '';
$conversationHistory = $_SESSION['biz_history'] ?? [];

if (empty($goal) || empty($prompt)) {
    header('Location: chatbot-business-setup.php');
    exit;
}

$engine = new BusinessChatbotEngine(session_id());
$errors = [];

function escapeHtml($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = trim($_POST['user_message'] ?? '');
    if ($message === '') {
        $errors[] = 'Please type a message before sending.';
    } else {
        try {
            $parsed = !empty($savedFiles)
                ? $engine->parseSavedFiles($savedFiles)
                : ['files' => [], 'combined_text' => '', 'summaries' => []];
            $additionalContext = '';
            if (!empty($fileDescription)) {
                $additionalContext .= "USER FILE SUMMARY:\n{$fileDescription}\n\n";
            }
            $additionalContext .= $parsed['combined_text'];

            $response = $engine->getChatResponse(
                $message,
                $conversationHistory,
                $prompt,
                $additionalContext
            );

            if (!empty($response['success'])) {
                $conversationHistory[] = ['role' => 'user', 'content' => $message];
                $conversationHistory[] = ['role' => 'assistant', 'content' => $response['response']];
                $_SESSION['biz_history'] = $conversationHistory;
            } else {
                $errors[] = $response['error'] ?? 'Something went wrong. Please try again.';
            }
        } catch (Exception $e) {
            $errors[] = $e->getMessage();
        }
    }
}

$sessionInfo = sprintf(
    'Goal: %s%s',
    mb_strimwidth($goal, 0, 60, '…'),
    !empty($savedFiles) ? ' • Files attached: ' . count($savedFiles) : ''
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kaizen Business Assistant — Chat</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/style.css?v=<?php echo time(); ?>">
    <style>
        body {
            margin: 0;
            font-family: 'Montserrat', sans-serif;
            background: var(--secondary);
            color: var(--text-dark);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .chat-header {
            background: rgba(255,255,255,0.95);
            border-bottom: 1px solid rgba(164, 51, 43, 0.1);
            padding: 18px 24px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--accent);
            font-weight: 600;
            text-decoration: none;
        }
        .session-info {
            font-size: 14px;
            color: var(--text-medium);
            background: rgba(164, 51, 43, 0.08);
            padding: 6px 12px;
            border-radius: 999px;
        }
        .brand-mark {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text-dark);
            font-weight: 600;
        }
        .brand-mark img {
            width: 48px;
            border-radius: 8px;
            box-shadow: 0 6px 16px rgba(0,0,0,0.15);
        }
        main {
            flex: 1;
            padding: 30px 20px 110px;
            max-width: 900px;
            width: 100%;
            margin: 0 auto;
            box-sizing: border-box;
        }
        .chat-window {
            background: #fff;
            border-radius: 24px;
            padding: 28px;
            box-shadow: 0 25px 60px rgba(7, 16, 39, 0.1);
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .errors {
            margin-bottom: 15px;
            padding: 12px 15px;
            border-radius: 12px;
            background: #ffe9e7;
            color: #8b1f1a;
        }
        .messages {
            flex: 1;
            overflow-y: auto;
            padding-right: 8px;
        }
        .bubble {
            max-width: 80%;
            padding: 14px 18px;
            border-radius: 20px;
            margin-bottom: 16px;
            line-height: 1.6;
            white-space: pre-wrap;
            font-size: 15px;
        }
        .bubble.user {
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-light) 100%);
            color: #fff;
            margin-left: auto;
            border-bottom-right-radius: 6px;
            box-shadow: 0 12px 25px rgba(164, 51, 43, 0.25);
        }
        .bubble.assistant {
            background: #fff6f5;
            color: var(--text-dark);
            margin-right: auto;
            border-bottom-left-radius: 6px;
            border: 1px solid rgba(164, 51, 43, 0.15);
        }
        .composer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #fff;
            padding: 22px 20px 28px;
            box-shadow: 0 -20px 40px rgba(0,0,0,0.12);
        }
        .composer form {
            max-width: 900px;
            margin: 0 auto;
        }
        .composer textarea {
            width: 100%;
            min-height: 120px;
            border: 1px solid #e3e5ee;
            border-radius: 18px;
            padding: 16px;
            font-size: 16px;
            resize: vertical;
            box-sizing: border-box;
            box-shadow: inset 0 2px 6px rgba(0,0,0,0.04);
        }
        .composer button {
            margin-top: 12px;
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 18px;
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-light) 100%);
            color: #fff;
            font-size: 17px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 15px 30px rgba(164, 51, 43, 0.3);
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }
        @media (max-width: 768px) {
            .bubble {
                max-width: 100%;
            }
            .chat-header {
                flex-wrap: wrap;
                gap: 10px;
            }
            .brand-mark {
                width: 100%;
                justify-content: flex-start;
            }
        }
    </style>
</head>
<body>
    <header class="chat-header">
        <a class="back-link" href="chatbot-business-setup.php?reset=1">
            <span>←</span> Back
        </a>
        <div class="session-info"><?= escapeHtml($sessionInfo) ?></div>
        <div class="brand-mark">
            <img src="assets/images/logo.png" alt="Kaizen Karate">
            <span>Kaizen Business Assistant</span>
        </div>
    </header>
    <main>
        <div class="chat-window">
            <?php foreach ($errors as $error): ?>
                <div class="errors"><?= escapeHtml($error) ?></div>
            <?php endforeach; ?>

            <div class="messages">
                <?php if (empty($conversationHistory)): ?>
                    <div class="bubble assistant">
                        <?php
                        $goalLower = strtolower($goal);
                        $hasFiles = !empty($savedFiles);

                        if (stripos($goalLower, 'social media') !== false || stripos($goalLower, 'post') !== false) {
                            echo "Perfect! I can help you create engaging social media content";
                            if ($hasFiles) echo " based on the competitive data you provided";
                            echo ". Would you like me to analyze current trends and suggest posts, or jump straight into creating content?";
                        } elseif (stripos($goalLower, 'email') !== false) {
                            echo "Great! I can help draft professional email templates";
                            if ($hasFiles) echo " informed by the documents you uploaded";
                            echo ". Should I start with common parent questions, or do you have specific scenarios in mind?";
                        } elseif (stripos($goalLower, 'analyz') !== false || stripos($goalLower, 'compar') !== false) {
                            echo "Excellent! I'm ready to analyze";
                            if ($hasFiles) echo " the data you provided and compare it with Kaizen's offerings";
                            else echo " Kaizen's programs and market position";
                            echo ". What specific aspects would you like to explore first?";
                        } elseif (stripos($goalLower, 'polic') !== false) {
                            echo "I can help review and improve our policies. Should I analyze them for clarity, identify gaps, or suggest improvements?";
                        } elseif (stripos($goalLower, 'pricing') !== false) {
                            echo "Let's dive into pricing strategy";
                            if ($hasFiles) echo " and see how we compare to the competition";
                            echo ". Would you like a market analysis or specific pricing recommendations?";
                        } else {
                            echo "I'm ready to help with: " . htmlspecialchars($goal);
                            if ($hasFiles) echo ", using the files you provided";
                            echo ". What would you like to explore first?";
                        }
                        ?>
                    </div>
                <?php else: ?>
                    <?php foreach ($conversationHistory as $entry): ?>
                        <div class="bubble <?= escapeHtml($entry['role']) ?>">
                            <?= nl2br(escapeHtml($entry['content'])) ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <div class="composer">
        <form method="post">
            <textarea name="user_message" placeholder="Type your message..."></textarea>
            <button type="submit" name="action" value="send_message">Send</button>
        </form>
    </div>
</body>
</html>
