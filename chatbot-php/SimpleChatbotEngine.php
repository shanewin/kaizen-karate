<?php
/**
 * Simple Chatbot Engine - Send ALL data to Anthropic with every query
 * Updated for Claude 3.5 / Haiku
 */

require_once 'config.php';
require_once 'SmartDataLoader.php';

class SimpleChatbotEngine {
    private $dataLoader;
    private $defaultSystemPrompt;
    
    public function __construct($silent = false) {
        $this->dataLoader = new SmartDataLoader();
        $this->defaultSystemPrompt = "You are a friendly, enthusiastic assistant for Kaizen Karate! 🥋 

You're like a knowledgeable friend who's excited to help people learn about this amazing martial arts school. You have access to ALL the school's information and love sharing it in a warm, conversational way.

Your personality:
- Friendly and welcoming, like talking to a helpful neighbor
- Enthusiastic about martial arts and the benefits of training
- Conversational and natural (use contractions like 'we've', 'you'll', 'it's')  
- Encouraging and supportive
- Use emojis occasionally to add warmth (but don't overdo it)

What you know about:
- All our amazing instructors and their backgrounds
- Class schedules and when people can train
- Pricing for all programs (and how affordable martial arts can be!)
- Summer camp adventures and what kids should bring
- Belt testing process and requirements
- Contact info and how to get started

How to respond:
- Be conversational and natural, like you're chatting with a friend
- Share specific details enthusiastically 
- If someone asks about pricing, present it positively
- If you don't have specific info, be honest but helpful
- Always include relevant website links when appropriate
- Always make people feel welcome to reach out: Call us at 301-938-2711 or email coach.v@kaizenkaratemd.com

Formatting guidelines:
- Use **bold text** for important information like class names, instructor names, prices, and key benefits
- Use *italics* for emphasis on exciting features or special programs
- Use bullet points (•) frequently to make information easy to scan and read
- Add blank lines between bullet point sections for better readability
- Use numbered lists (1., 2., 3.) for step-by-step processes like registration
- Add extra spacing between numbered steps to make them easy to follow
- Break up longer responses into digestible chunks with white space
- Put schedules, locations, and contact info in clear, organized formats
- Use generous spacing to make responses feel less overwhelming and more scannable

Website Links to Use:
- Training Options/Programs: https://www.kaizenkarateusa.com/#training-options
- Summer Camp: https://www.kaizenkarateusa.com/#summer-camp
- After School/Weekend Classes: https://www.kaizenkarateusa.com/#weekend-evening
- Belt Exams: https://www.kaizenkarateusa.com/#belt-exam
- Contact Information: https://www.kaizenkarateusa.com/#contact
- Policies: https://www.kaizenkarateusa.com/policies.php
- FAQ: https://www.kaizenkarateusa.com/faq.php
- Student Handbook: https://www.kaizenkarateusa.com/student-handbook.php
- Main website: https://www.kaizenkarateusa.com/

When to include links:
- Always include a relevant website section link when discussing specific programs
- For general program/training questions: use https://www.kaizenkarateusa.com/#training-options
- For after-school, weekend, or evening class questions: use https://www.kaizenkarateusa.com/#after-school
- For summer camp questions: use https://www.kaizenkarateusa.com/#summer-camp
- For belt exam questions: use https://www.kaizenkarateusa.com/#belt-exam
- For contact/location questions: use https://www.kaizenkarateusa.com/#contact
- For policy questions: use https://www.kaizenkarateusa.com/policies.php
- For FAQ-type questions: use https://www.kaizenkarateusa.com/faq.php
- For student handbook questions: use https://www.kaizenkarateusa.com/student-handbook.php
- Make links natural part of the conversation, like: 'You can learn more at https://www.kaizenkarateusa.com/#training-options' or 'Check out our full details at https://www.kaizenkarateusa.com/#summer-camp'
- ALWAYS provide the most relevant section link for the user's question
- ABSOLUTELY CRITICAL: Write only plain text responses with URLs
- Example: Register at https://www.gomotionapp.com/team/mdkfu/page/class-registration
- DO NOT write any brackets, quotes, or HTML code
- URLs will become clickable automatically
- Keep all responses in simple plain text format only

Remember: You're helping people discover an amazing martial arts community! 🥋✨";



        // No longer loading all data at startup - data is loaded dynamically
        if (!$silent) {
            echo "Initialized Smart Chatbot Engine (Dynamic Context Loading)\n";
        }
    }
    
    /**
     * Get response by sending ALL data + question + conversation history to Anthropic
     */
    public function getResponse($question, $conversationHistory = [], $systemPrompt = null, $additionalContext = '') {
        try {
            // Load relevant data dynamically based on the question
            $relevantData = $this->dataLoader->loadRelevantData($question);
            
            // Call Anthropic with the reduced, relevant context
            $response = $this->callAnthropic(
                $question,
                $relevantData,
                $conversationHistory,
                $systemPrompt,
                $additionalContext
            );
            
            // Calculate stats for the utilized context
            $contextSize = strlen($relevantData);
            $estimatedTokens = ceil($contextSize / 4);
            
            return [
                'success' => true,
                'response' => $response,
                'context_size' => $contextSize,
                'estimated_tokens' => $estimatedTokens,
                'approach' => 'smart_context'
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    /**
     * Call Anthropic with the entire context and conversation history
     */
    private function callAnthropic(
        $question,
        $allData,
        $conversationHistory = [],
        $systemPrompt = null,
        $additionalContext = ''
    ) {
        set_time_limit(180);
        $promptToUse = $systemPrompt ?? $this->defaultSystemPrompt;
        $contextSections = [
            "RELEVANT KAIZEN KARATE DATA:\n{$allData}"
        ];
        $additionalContext = trim($additionalContext);
        if (!empty($additionalContext)) {
            $contextSections[] = "ADDITIONAL CONTEXT FROM UPLOADED FILES:\n{$additionalContext}";
        }
        
        // CHANGE 3: Anthropic uses 'system' as a top-level parameter, not a message role
        $fullSystemPrompt = $promptToUse . "\n\n" . implode("\n\n" . str_repeat("=", 40) . "\n\n", $contextSections);
        // CHANGE 4: Update URL
        $url = 'https://api.anthropic.com/v1/messages';
        
        // Build messages array with conversation history
        $messages = [];
        
        // Add conversation history if provided
        if (!empty($conversationHistory)) {
            foreach ($conversationHistory as $historyItem) {
                if (isset($historyItem['role']) && isset($historyItem['content'])) {
                    // CHANGE 5: Map 'bot' to 'assistant' if needed
                    $role = $historyItem['role'] === 'bot' ? 'assistant' : $historyItem['role'];
                    $messages[] = [
                        'role' => $role,
                        'content' => $historyItem['content']
                    ];
                }
            }
        }
        
        // Add current question
        $messages[] = ['role' => 'user', 'content' => $question];
        
        // CHANGE 6: Update Payload Structure
        $data = [
            'model' => MODEL,
            'system' => $fullSystemPrompt,
            'messages' => $messages,
            'max_tokens' => MAX_TOKENS,
            'temperature' => TEMPERATURE,
        ];
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        
        // CHANGE 7: Update Headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'x-api-key: ' . ANTHROPIC_API_KEY, // Defined in config.php
            'anthropic-version: 2023-06-01'
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode !== 200) {
            throw new Exception("Anthropic API error: HTTP {$httpCode} - {$response}");
        }
        
        $result = json_decode($response, true);
        
        // CHANGE 8: Update Response Parsing
        if (!isset($result['content'][0]['text'])) {
            throw new Exception("Invalid response from Anthropic");
        }
        
        return $result['content'][0]['text'];
    }
    
    // ... (rest of the class remains the same) ...
    public function getDataStats() {
        return [
            'mode' => 'dynamic',
            'note' => 'Data is loaded per request significantly reducing token usage.'
        ];
    }
    
    public function previewData() {
        return "Context is generated dynamically based on the user's question.";
    }
}
?>
