<?php
/**
 * Business Chatbot Engine
 * Wrapper around SimpleChatbotEngine with support for:
 * - Session-scoped file uploads and parsing
 * - Automated prompt generation referencing uploaded material
 * - Combined context (site JSON + uploaded data) per chat session
 */

require_once __DIR__ . '/SimpleChatbotEngine.php';

class BusinessChatbotEngine {
    private const ALLOWED_EXTENSIONS = ['csv', 'xlsx', 'xls', 'pdf', 'txt', 'md', 'json'];
    private const MAX_FILE_SIZE = 10 * 1024 * 1024;          // 10 MB per file
    private const MAX_SESSION_BYTES = 50 * 1024 * 1024;      // 50 MB per session
    private const MAX_TEXT_PER_FILE = 20000;                 // cap text contribution per file
    private const MAX_ROWS_FOR_TABLE = 200;                  // avoid gigantic CSV/XLSX dumps
    private const CONTEXT_DIVIDER = "\n\n============================================================\n\n";

    private $simpleEngine;
    private $sessionId;
    private $uploadRoot;
    private $sessionDir;
    private $refinerModel = 'gpt-4o-mini';

    /**
     * @param string $sessionId Unique identifier for the browser session
     * @param bool $silent Pass true to suppress SimpleChatbotEngine console output
     * @throws Exception
     */
    public function __construct($sessionId, $silent = true) {
        if (empty($sessionId)) {
            throw new InvalidArgumentException('Session ID is required for BusinessChatbotEngine.');
        }

        $this->simpleEngine = new SimpleChatbotEngine($silent);
        $this->sessionId = $this->sanitizeSessionId($sessionId);
        $this->uploadRoot = dirname(__DIR__) . '/uploads/business-chatbot-temp';
        $this->sessionDir = $this->uploadRoot . '/' . $this->sessionId;

        $this->ensureDirectories();
    }

    /**
     * Return the absolute path to the session-specific upload directory.
     */
    public function getSessionDirectory() {
        return $this->sessionDir;
    }

    /**
     * Remove all uploaded files for the current session.
     */
    public function resetSessionStorage() {
        self::deleteDirectory($this->sessionDir);
        $this->ensureDirectories();
    }

    /**
     * Remove session folders older than the given age (hours)
     */
    public static function cleanupExpiredSessions($maxAgeHours = 24) {
        $root = dirname(__DIR__) . '/uploads/business-chatbot-temp';
        if (!is_dir($root)) {
            return;
        }

        $threshold = time() - ($maxAgeHours * 3600);
        foreach (glob($root . '/*') as $path) {
            if (is_dir($path) && filemtime($path) < $threshold) {
                self::deleteDirectory($path);
            }
        }
    }

    /**
     * Save uploaded files to the session directory (validating limits)
     * @param array $files Incoming $_FILES-style array (single or multi upload)
     * @return array ['saved'=>[], 'errors'=>[]]
     */
    public function saveUploadedFiles(array $files) {
        $normalized = $this->normalizeFilesArray($files);
        $result = ['saved' => [], 'errors' => []];

        if (empty($normalized)) {
            return $result;
        }

        $sessionUsage = $this->getSessionDiskUsage();
        foreach ($normalized as $file) {
            $errorMessage = $this->validateUploadedFile($file, $sessionUsage);
            if ($errorMessage !== null) {
                $result['errors'][] = [
                    'name' => $file['name'] ?? 'unknown',
                    'error' => $errorMessage
                ];
                continue;
            }

            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $safeName = $this->sanitizeFilename($file['name']);
            $storedName = uniqid('biz_', true) . '_' . $safeName;
            $destination = $this->sessionDir . '/' . $storedName;

            $moveSuccess = false;
            if (is_uploaded_file($file['tmp_name'])) {
                $moveSuccess = move_uploaded_file($file['tmp_name'], $destination);
            } else {
                $moveSuccess = copy($file['tmp_name'], $destination);
            }

            if (!$moveSuccess) {
                $result['errors'][] = [
                    'name' => $file['name'],
                    'error' => 'Unable to store uploaded file.'
                ];
                continue;
            }

            $sessionUsage += $file['size'];
            $result['saved'][] = [
                'original_name' => $file['name'],
                'stored_name' => $storedName,
                'stored_path' => $destination,
                'size' => $file['size'],
                'extension' => $extension,
                'mime' => $file['type'] ?? ''
            ];
        }

        return $result;
    }

    /**
     * Parse saved files into text blocks for prompt context
     * @param array $savedFiles result from saveUploadedFiles()['saved']
     * @return array ['files'=>[], 'combined_text'=>'', 'summaries'=>[]]
     */
    public function parseSavedFiles(array $savedFiles) {
        $parsed = [];
        foreach ($savedFiles as $file) {
            $text = $this->parseFileToText($file['stored_path'], $file['extension']);
            $text = $this->truncateText($text, self::MAX_TEXT_PER_FILE);
            $summary = $this->buildSummaryFromText($text);

            $parsed[] = array_merge($file, [
                'text' => $text,
                'summary' => $summary
            ]);
        }

        return [
            'files' => $parsed,
            'combined_text' => $this->buildContextText($parsed),
            'summaries' => $this->buildSummaryList($parsed)
        ];
    }

    /**
     * Produce a tailored system prompt referencing the uploaded files and desired goal
     * @param string $goalDescription
     * @param array $fileSummaries result of parseSavedFiles()['summaries']
     * @return string
     * @throws Exception
     */
    public function generateSystemPrompt($goalDescription, array $fileSummaries = []) {
        $goalDescription = trim($goalDescription);
        if (empty($goalDescription)) {
            throw new InvalidArgumentException('Goal description is required to generate a prompt.');
        }

        $hasFiles = !empty($fileSummaries);
        $fileLines = [];
        foreach ($fileSummaries as $summary) {
            $fileLines[] = "- {$summary['name']}: {$summary['summary']}";
        }
        $filesText = implode("\n", $fileLines);

        $isSocialGoal = stripos($goalDescription, 'social media') !== false
            || stripos($goalDescription, 'social post') !== false
            || stripos($goalDescription, 'social posts') !== false;

        $siteDataOverview = "- site_info, hero_section, navigation, and registration_panel for branding, tone, CTAs, and contact details\n"
            . "- programs.cards covering After School Program, Weekend & Evening, Belt Exams, and Online Store offerings with summaries, buttons, and imagery context\n"
            . "- summer_camp.basic_info, special_offer, features, camp_locations, registration_info, and accordion_sections (daily schedule, policies, themes)\n"
            . "- after_school calendar_section, downloadable schedule (PDF), registration CTA, and disclaimer copy\n"
            . "- kaizen_dojo hero/van service/service cards + kaizen_kenpo tabs (about, IKCA overview, gallery, contact/location)\n"
            . "- belt_exams hero, requirements list, accordions (date cards, makeup info), and lightboxes for scheduling\n"
            . "- service_areas for DC, Maryland, Virginia, New York coverage plus policy references (refund, withdrawal, credit, transfer, make-up, travel, and equipment)\n";

        $filesInstruction = $hasFiles
            ? "Supplemental research files to reference:\n{$filesText}\nIn the final prompt, explicitly instruct the assistant to consult these files alongside Kaizen's JSON when relevant."
            : "No supplemental files were uploaded for this session. In the final prompt, do not mention uploads—focus solely on Kaizen's official JSON content.";

        $promptRequirements = "- Declare the assistant as an internal Kaizen strategist or specialist for the stated goal\n"
            . "- Reference Kaizen's real program names, locations, dates, pricing, and policies from the JSON data structure above\n"
            . "- Emphasize cross-referencing site-content.json before answering to ensure accuracy\n"
            . "- When discussing communications (emails, posts, scripts), require the assistant to include appropriate registration URLs and contact info\n"
            . "- Maintain Kaizen's professional yet family-friendly tone with actionable, specific guidance\n"
            . "- Provide task-specific instructions (number of outputs, analysis steps, formatting expectations) aligned with the user goal";
        if ($isSocialGoal) {
            $promptRequirements .= "\n- IMPORTANT: Only provide text content, hashtags, and posting instructions. DO NOT suggest creating images, graphics, or visual content. Focus on compelling copy, hooks, calls-to-action, and strategic posting guidance.";
        }

        $messages = [
            [
                'role' => 'system',
                'content' => "You are an expert prompt engineer for Kaizen Karate's internal intelligence assistant. Craft authoritative system prompts that force the assistant to cite Kaizen's structured JSON data (site-content.json and related files) for every answer."
            ],
            [
                'role' => 'user',
                'content' => "User Goal:\n{$goalDescription}\n\nKaizen Knowledge Base Overview:\n{$siteDataOverview}\n\n{$filesInstruction}\n\nPrompt Requirements:\n{$promptRequirements}\n\nWrite one production-ready system prompt obeying every requirement."
            ]
        ];

        $response = $this->callOpenAI($messages, 'gpt-4o-mini', 600, 0.15);
        return trim($response);
    }

    public function callPromptRefiner(array $messages) {
        return $this->callOpenAI($messages, $this->refinerModel, 500, 0.2);
    }

    /**
     * Chat entry point for the business assistant
     */
    public function getChatResponse($question, $conversationHistory, $systemPrompt, $additionalContext) {
        return $this->simpleEngine->getResponse(
            $question,
            $conversationHistory,
            $systemPrompt,
            $additionalContext
        );
    }

    /**
     * Helper to normalize $_FILES for single/multi uploads
     */
    private function normalizeFilesArray(array $files) {
        if (empty($files)) {
            return [];
        }

        $normalized = [];

        if (isset($files['name']) && is_array($files['name'])) {
            foreach ($files['name'] as $index => $name) {
                $normalized[] = [
                    'name' => $name,
                    'type' => $files['type'][$index] ?? '',
                    'tmp_name' => $files['tmp_name'][$index] ?? '',
                    'error' => $files['error'][$index] ?? UPLOAD_ERR_NO_FILE,
                    'size' => $files['size'][$index] ?? 0
                ];
            }
        } else {
            $normalized[] = $files;
        }

        return $normalized;
    }

    /**
     * Validate individual file constraints
     */
    private function validateUploadedFile($file, $currentUsage) {
        if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
            return 'Upload error code: ' . ($file['error'] ?? 'unknown');
        }
        if (empty($file['tmp_name']) || !file_exists($file['tmp_name'])) {
            return 'Temporary upload file not found.';
        }
        if (($file['size'] ?? 0) <= 0) {
            return 'Empty file.';
        }
        if ($file['size'] > self::MAX_FILE_SIZE) {
            return 'File exceeds the 10MB limit.';
        }
        if (($currentUsage + $file['size']) > self::MAX_SESSION_BYTES) {
            return 'Session storage limit (50MB) exceeded.';
        }
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, self::ALLOWED_EXTENSIONS, true)) {
            return 'Unsupported file type: ' . $extension;
        }

        return null;
    }

    private function parseFileToText($filePath, $extension) {
        switch ($extension) {
            case 'csv':
                return $this->parseCsv($filePath);
            case 'xlsx':
                return $this->parseXlsx($filePath);
            case 'xls':
                return $this->parseLegacyXls($filePath);
            case 'pdf':
                return $this->parsePdf($filePath);
            case 'md':
            case 'txt':
                return $this->parseTextFile($filePath);
            case 'json':
                return $this->parseJsonFile($filePath);
            default:
                return "Unsupported parser for extension: {$extension}.";
        }
    }

    private function parseCsv($filePath) {
        if (!is_readable($filePath)) {
            return 'Unable to read CSV.';
        }
        $handle = fopen($filePath, 'r');
        if (!$handle) {
            return 'Unable to open CSV.';
        }

        $headers = fgetcsv($handle, 0, ',', '"', '\\');
        $rows = [];
        $rowNumber = 1;
        while (($row = fgetcsv($handle, 0, ',', '"', '\\')) !== false && $rowNumber <= self::MAX_ROWS_FOR_TABLE) {
            $values = [];
            foreach ($row as $index => $value) {
                $label = $headers[$index] ?? 'Column ' . ($index + 1);
                $values[] = "{$label}: " . $this->cleanValue($value);
            }
            $rows[] = "Row {$rowNumber}: " . implode(' | ', $values);
            $rowNumber++;
        }
        fclose($handle);

        if (count($rows) >= self::MAX_ROWS_FOR_TABLE) {
            $rows[] = '[CSV truncated for brevity]';
        }

        return implode("\n", $rows);
    }

    private function parseXlsx($filePath) {
        if (!class_exists('ZipArchive')) {
            return 'ZipArchive not available to parse XLSX.';
        }

        $zip = new ZipArchive();
        if ($zip->open($filePath) !== true) {
            return 'Unable to open XLSX archive.';
        }

        $sharedStrings = $this->parseSharedStrings($zip);
        $sheetTexts = [];
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $stat = $zip->statIndex($i);
            $name = $stat['name'];
            if (preg_match('/xl\/worksheets\/sheet\d+\.xml$/', $name)) {
                $sheetTexts[] = $this->parseXlsxSheet($zip->getFromName($name), $sharedStrings, basename($name, '.xml'));
            }
        }
        $zip->close();

        return implode("\n\n", array_filter($sheetTexts));
    }

    private function parseLegacyXls($filePath) {
        // Basic fallback: treat as binary and attempt to extract ASCII text
        $content = @file_get_contents($filePath);
        if ($content === false) {
            return 'Unable to process XLS file.';
        }
        $text = preg_replace('/[^\x20-\x7E\r\n\t]/', '', $content);
        return "Legacy XLS (raw extract):\n" . $text;
    }

    private function parsePdf($filePath) {
        $pdftotext = trim(shell_exec('command -v pdftotext'));
        if (empty($pdftotext)) {
            return 'pdftotext utility not available for PDF extraction.';
        }
        $escapedPath = escapeshellarg($filePath);
        $command = "{$pdftotext} -layout {$escapedPath} -";
        $output = shell_exec($command);
        if ($output === null) {
            return 'Failed to extract text from PDF.';
        }
        return trim($output);
    }

    private function parseTextFile($filePath) {
        $content = @file_get_contents($filePath);
        return $content === false ? 'Unable to read text file.' : $content;
    }

    private function parseJsonFile($filePath) {
        $content = @file_get_contents($filePath);
        if ($content === false) {
            return 'Unable to read JSON.';
        }
        $data = json_decode($content, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return 'Invalid JSON structure.';
        }
        return $this->formatArrayRecursive($data);
    }

    private function parseSharedStrings(ZipArchive $zip) {
        $sharedStrings = [];
        $xmlContent = $zip->getFromName('xl/sharedStrings.xml');
        if ($xmlContent === false) {
            return $sharedStrings;
        }

        $xml = @simplexml_load_string($xmlContent);
        if (!$xml) {
            return $sharedStrings;
        }

        foreach ($xml->si as $index => $si) {
            if (isset($si->t)) {
                $sharedStrings[(int)$index] = (string)$si->t;
            } elseif (isset($si->r)) {
                $runs = [];
                foreach ($si->r as $r) {
                    $runs[] = (string)$r->t;
                }
                $sharedStrings[(int)$index] = implode('', $runs);
            }
        }

        return $sharedStrings;
    }

    private function parseXlsxSheet($xmlContent, $sharedStrings, $sheetName) {
        if ($xmlContent === false) {
            return '';
        }

        $xml = @simplexml_load_string($xmlContent);
        if (!$xml || !isset($xml->sheetData)) {
            return '';
        }

        $rows = [];
        $rowCounter = 0;
        foreach ($xml->sheetData->row as $row) {
            if ($rowCounter >= self::MAX_ROWS_FOR_TABLE) {
                $rows[] = '[Worksheet truncated for brevity]';
                break;
            }
            $cells = [];
            foreach ($row->c as $cell) {
                $ref = (string)$cell['r'];
                $col = preg_replace('/\d+/', '', $ref);
                $value = $this->resolveXlsxCellValue($cell, $sharedStrings);
                $cells[] = "{$col}: {$value}";
            }
            $rows[] = "Row " . (++$rowCounter) . ": " . implode(' | ', $cells);
        }

        return "Sheet {$sheetName}:\n" . implode("\n", $rows);
    }

    private function resolveXlsxCellValue($cell, $sharedStrings) {
        $value = (string)$cell->v;
        if (isset($cell['t']) && (string)$cell['t'] === 's') {
            $index = (int)$value;
            return $sharedStrings[$index] ?? '';
        }
        return $value;
    }

    private function buildContextText(array $files) {
        $chunks = [];
        foreach ($files as $file) {
            $chunks[] = "FILE: {$file['original_name']}\n" . $file['text'];
        }
        return empty($chunks) ? '' : implode(self::CONTEXT_DIVIDER, $chunks);
    }

    private function buildSummaryList(array $files) {
        $summaries = [];
        foreach ($files as $file) {
            $summaries[] = [
                'name' => $file['original_name'],
                'summary' => $file['summary']
            ];
        }
        return $summaries;
    }

    private function buildSummaryFromText($text) {
        $text = trim($text);
        if ($text === '') {
            return 'No extractable content.';
        }
        $clean = preg_replace('/\s+/', ' ', $text);
        return mb_substr($clean, 0, 200) . (mb_strlen($clean) > 200 ? '...' : '');
    }

    private function formatArrayRecursive($data, $depth = 0) {
        $indent = str_repeat('  ', $depth);
        $output = '';

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    $output .= "{$indent}{$key}:\n";
                    $output .= $this->formatArrayRecursive($value, $depth + 1);
                } else {
                    $output .= "{$indent}{$key}: " . $this->cleanValue($value) . "\n";
                }
            }
        } else {
            $output .= "{$indent}" . $this->cleanValue($data) . "\n";
        }

        return $output;
    }

    private function truncateText($text, $limit) {
        if (mb_strlen($text) <= $limit) {
            return $text;
        }
        return mb_substr($text, 0, $limit) . "\n...[content truncated to preserve token budget]...";
    }

    private function cleanValue($value) {
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }
        if ($value === null) {
            return 'null';
        }
        $value = strip_tags((string)$value);
        $value = html_entity_decode($value, ENT_QUOTES, 'UTF-8');
        return trim(preg_replace('/\s+/', ' ', $value));
    }

    private function sanitizeSessionId($sessionId) {
        $sessionId = preg_replace('/[^a-zA-Z0-9_\-]/', '', $sessionId);
        if (empty($sessionId)) {
            $sessionId = bin2hex(random_bytes(8));
        }
        return $sessionId;
    }

    private function sanitizeFilename($filename) {
        $filename = preg_replace('/[^a-zA-Z0-9_\.\-]/', '_', $filename);
        return substr($filename, 0, 120);
    }

    private function ensureDirectories() {
        if (!is_dir($this->uploadRoot)) {
            mkdir($this->uploadRoot, 0755, true);
        }
        if (!is_dir($this->sessionDir)) {
            mkdir($this->sessionDir, 0755, true);
        }
    }

    private function getSessionDiskUsage() {
        if (!is_dir($this->sessionDir)) {
            return 0;
        }
        $total = 0;
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($this->sessionDir, FilesystemIterator::SKIP_DOTS)
        );
        foreach ($iterator as $fileInfo) {
            $total += $fileInfo->getSize();
        }
        return $total;
    }

    private static function deleteDirectory($dir) {
        if (!is_dir($dir)) {
            return;
        }
        $items = array_diff(scandir($dir), ['.', '..']);
        foreach ($items as $item) {
            $path = $dir . '/' . $item;
            if (is_dir($path)) {
                self::deleteDirectory($path);
            } else {
                @unlink($path);
            }
        }
        @rmdir($dir);
    }

    private function callOpenAI(array $messages, $model = 'gpt-4o-mini', $maxTokens = 400, $temperature = 0.2) {
        $payload = [
            'model' => $model,
            'messages' => $messages,
            'temperature' => $temperature,
            'max_tokens' => $maxTokens
        ];

        $ch = curl_init(OPENAI_API_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: ' . 'Bearer ' . OPENAI_API_KEY
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            throw new RuntimeException("OpenAI API error ({$httpCode}): {$response}");
        }

        $result = json_decode($response, true);
        if (!isset($result['choices'][0]['message']['content'])) {
            throw new RuntimeException('OpenAI response missing content.');
        }

        return $result['choices'][0]['message']['content'];
    }
}
?>
