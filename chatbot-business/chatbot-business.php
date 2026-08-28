<?php
session_start();

require_once __DIR__ . '/../chatbot-php/BusinessChatbotEngine.php';

$engine = new BusinessChatbotEngine(session_id());
$messages = [];
$errors = [];
$latestAssistantReply = '';

$goal = $_SESSION['biz_goal'] ?? '';
$generatedPrompt = $_SESSION['biz_prompt'] ?? '';
$savedFiles = $_SESSION['biz_files'] ?? [];
$conversationHistory = $_SESSION['biz_history'] ?? [];
$parsedResult = null;

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
    $action = $_POST['action'] ?? '';

    try {
        switch ($action) {
            case 'upload':
                if (!isset($_FILES['support_files'])) {
                    $errors[] = 'Please choose at least one file.';
                    break;
                }
                $uploadResult = $engine->saveUploadedFiles($_FILES['support_files']);
                if (!empty($uploadResult['saved'])) {
                    $savedFiles = array_merge($savedFiles, $uploadResult['saved']);
                    $messages[] = count($uploadResult['saved']) . ' file(s) uploaded successfully.';
                }
                if (!empty($uploadResult['errors'])) {
                    foreach ($uploadResult['errors'] as $err) {
                        $errors[] = $err['name'] . ': ' . $err['error'];
                    }
                }
                break;

            case 'generate_prompt':
                $goal = trim($_POST['goal'] ?? '');
                if (empty($goal)) {
                    $errors[] = 'Please describe your goal before generating a prompt.';
                    break;
                }
                $parsedResult = !empty($savedFiles)
                    ? $engine->parseSavedFiles($savedFiles)
                    : ['files' => [], 'combined_text' => '', 'summaries' => []];
                $generatedPrompt = $engine->generateSystemPrompt($goal, $parsedResult['summaries']);
                $messages[] = 'Custom system prompt generated.';
                break;

            case 'send_message':
                $userMessage = trim($_POST['user_message'] ?? '');
                $systemPromptInput = trim($_POST['system_prompt'] ?? '');
                if (empty($userMessage)) {
                    $errors[] = 'Enter a question or instruction for the chatbot.';
                    break;
                }
                if (empty($systemPromptInput)) {
                    $errors[] = 'System prompt is required. Generate one or provide custom instructions.';
                    break;
                }
                $parsedResult = !empty($savedFiles)
                    ? $engine->parseSavedFiles($savedFiles)
                    : ['files' => [], 'combined_text' => '', 'summaries' => []];
                $chatResponse = $engine->getChatResponse(
                    $userMessage,
                    $conversationHistory,
                    $systemPromptInput,
                    $parsedResult['combined_text']
                );
                if (!empty($chatResponse['success'])) {
                    $conversationHistory[] = ['role' => 'user', 'content' => $userMessage];
                    $conversationHistory[] = ['role' => 'assistant', 'content' => $chatResponse['response']];
                    $generatedPrompt = $systemPromptInput;
                    $latestAssistantReply = $chatResponse['response'];
                    $messages[] = 'Response generated.';
                } else {
                    $errors[] = $chatResponse['error'] ?? 'Unknown error from chatbot.';
                }
                break;

            case 'reset_session':
                $engine->resetSessionStorage();
                $goal = '';
                $generatedPrompt = '';
                $savedFiles = [];
                $conversationHistory = [];
                $messages[] = 'Session cleared.';
                break;

            default:
                break;
        }
    } catch (Exception $e) {
        $errors[] = $e->getMessage();
    }
}

if ($parsedResult === null) {
    if (!empty($savedFiles)) {
        try {
            $parsedResult = $engine->parseSavedFiles($savedFiles);
        } catch (Exception $e) {
            $errors[] = 'Unable to parse uploaded files: ' . $e->getMessage();
            $parsedResult = ['files' => [], 'combined_text' => '', 'summaries' => []];
        }
    } else {
        $parsedResult = ['files' => [], 'combined_text' => '', 'summaries' => []];
    }
}

$_SESSION['biz_goal'] = $goal;
$_SESSION['biz_prompt'] = $generatedPrompt;
$_SESSION['biz_files'] = $savedFiles;
$_SESSION['biz_history'] = $conversationHistory;

$contextPreview = substr($parsedResult['combined_text'], 0, 1500);
if (strlen($parsedResult['combined_text']) > 1500) {
    $contextPreview .= "\n...[context truncated]...";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Business Intelligence Chatbot</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f5f6fa;
            color: #222;
        }
        header {
            background: #1a2238;
            color: #fff;
            padding: 24px 20px;
        }
        main {
            padding: 20px;
            max-width: 1100px;
            margin: 0 auto 40px;
        }
        h1, h2, h3 {
            margin-top: 0;
        }
        .panel {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 12px 28px rgba(20, 25, 39, 0.08);
        }
        .collapsible summary {
            font-weight: 600;
            cursor: pointer;
            list-style: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .collapsible summary::after {
            content: '▸';
            font-size: 18px;
            transition: transform 0.2s ease;
        }
        .collapsible[open] summary::after {
            transform: rotate(90deg);
        }
        .panel-body {
            margin-top: 15px;
        }
        textarea, input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #cfd3df;
            border-radius: 8px;
            font-size: 15px;
            background: #fff;
        }
        textarea {
            min-height: 110px;
            resize: vertical;
        }
        .small-note {
            font-size: 13px;
            color: #666;
        }
        .buttons {
            margin-top: 12px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        button {
            background: #1a73e8;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px 22px;
            font-size: 15px;
            cursor: pointer;
        }
        button.secondary {
            background: #5f6368;
        }
        .send-btn {
            width: 100%;
            font-size: 16px;
            font-weight: 600;
            padding: 14px;
        }
        .messages {
            padding: 10px 14px;
            border-radius: 6px;
            margin-bottom: 10px;
        }
        .messages.success {
            background: #e2f5e9;
            color: #1e6337;
        }
        .messages.error {
            background: #fdecea;
            color: #a12920;
        }
        .setup-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .stack-form {
            flex: 1 1 320px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .file-list table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .file-list th, .file-list td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #eee;
        }
        .context-preview summary {
            cursor: pointer;
            font-weight: 600;
        }
        .context-preview pre {
            background: #f3f4f6;
            padding: 12px;
            border-radius: 8px;
            overflow-x: auto;
            max-height: 220px;
        }
        .chat-panel {
            min-height: 320px;
        }
        .chat-history {
            max-height: 420px;
            overflow-y: auto;
            border: 1px solid #e0e3eb;
            border-radius: 10px;
            padding: 15px;
            background: #fafafa;
        }
        .chat-entry {
            margin-bottom: 18px;
            padding-bottom: 12px;
            border-bottom: 1px dashed #dcdfe6;
        }
        .chat-entry:last-child {
            border-bottom: none;
        }
        .chat-entry .label {
            font-size: 12px;
            font-weight: 700;
            display: inline-block;
            margin-bottom: 6px;
            color: #1a73e8;
        }
        .chat-entry.assistant .label {
            color: #34a853;
        }
        .prompt-panel summary {
            cursor: pointer;
            font-weight: 600;
            margin-bottom: 8px;
        }
        .prompt-panel textarea {
            min-height: 100px;
        }
        @media (max-width: 768px) {
            .chat-history {
                max-height: none;
            }
            button, .send-btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Business Intelligence Chatbot</h1>
        <p>Upload supporting data, generate a tailored system prompt, and chat using Kaizen Karate's full knowledge base.</p>
    </header>
    <main>
<?php foreach ($messages as $msg): ?>
            <div class="messages success"><?= escapeHtml($msg) ?></div>
        <?php endforeach; ?>
        <?php foreach ($errors as $err): ?>
            <div class="messages error"><?= escapeHtml($err) ?></div>
        <?php endforeach; ?>

<?php $setupOpen = (empty($goal) && empty($savedFiles)); ?>
        <details class="panel collapsible" <?= $setupOpen ? 'open' : '' ?>>
            <summary>Session Setup</summary>
            <div class="panel-body">
                <div class="setup-grid">
                    <form method="post" class="stack-form">
                        <label for="goal">Session Goal</label>
                        <textarea id="goal" name="goal" placeholder="Example: Analyze competitor posts and draft marketing content"><?= escapeHtml($goal) ?></textarea>
                        <p class="small-note">Describe the outcome you need; the assistant will see this in the system prompt.</p>
                        <div class="buttons">
                            <button type="submit" name="action" value="generate_prompt">Generate / Refresh Prompt</button>
                            <button type="submit" name="action" value="reset_session" class="secondary">Start New Session</button>
                        </div>
                    </form>
                    <form method="post" enctype="multipart/form-data" class="stack-form upload-form">
                        <label>Supporting Files</label>
                        <input type="file" name="support_files[]" multiple>
                        <p class="small-note">
                            CSV, XLS/XLSX, PDF, TXT, MD, JSON • 10MB per file • 50MB per session • No images yet.
                        </p>
                        <div class="buttons">
                            <button type="submit" name="action" value="upload">Upload</button>
                        </div>
                    </form>
                </div>
                <?php if (!empty($savedFiles)): ?>
                    <div class="file-list">
                        <table>
                            <thead>
                                <tr>
                                    <th>File</th>
                                    <th>Size</th>
                                    <th>Stored Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($savedFiles as $file): ?>
                                    <tr>
                                        <td><?= escapeHtml($file['original_name']) ?></td>
                                        <td><?= escapeHtml(humanFileSize($file['size'])) ?></td>
                                        <td class="small-note"><?= escapeHtml($file['stored_name']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
                <?php if (!empty($parsedResult['files'])): ?>
                    <details class="context-preview" open>
                        <summary>Extracted File Context Preview</summary>
                        <pre><?= escapeHtml($contextPreview) ?></pre>
                    </details>
                <?php endif; ?>
            </div>
        </details>

<?php $promptOpen = !empty(trim($generatedPrompt)); ?>
        <section class="panel chat-panel">
            <h2>Conversation</h2>
            <?php if (empty($conversationHistory)): ?>
                <p class="small-note">No messages yet. Once you send a prompt, the conversation will appear here.</p>
            <?php else: ?>
                <div class="chat-history">
                    <?php foreach ($conversationHistory as $entry): ?>
                        <div class="chat-entry <?= escapeHtml($entry['role']) ?>">
                            <span class="label"><?= escapeHtml(strtoupper($entry['role'])) ?></span>
                            <div><?= nl2br(escapeHtml($entry['content'])) ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <section class="panel composer-panel">
            <h2>Your Question</h2>
            <form method="post" class="chat-form">
                <details class="prompt-panel" <?= $promptOpen ? 'open' : '' ?>>
                    <summary>System Prompt (auto-generated)</summary>
                    <textarea name="system_prompt" placeholder="Generate a prompt above or paste your own instructions"><?= escapeHtml($generatedPrompt) ?></textarea>
                    <p class="small-note">
                        Tip: update this if you need to override the AI-assisted prompt. The assistant sees this text as the system message.
                    </p>
                </details>
                <label for="user_message">Your Question or Instruction</label>
                <textarea id="user_message" name="user_message" placeholder="Example: Suggest three posts using the competitor data and Kaizen's summer camp details"></textarea>
                <div class="buttons">
                    <button type="submit" name="action" value="send_message" class="primary send-btn">Send Message</button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
