<?php
/**
 * Simple Chatbot Engine - Send ALL data to GPT-4 with every query
 * No RAG, no embeddings, no chunks - just the entire context every time
 */

require_once 'config.php';
require_once 'SimpleDataLoader.php';

class SimpleChatbotEngine {
    private $allData;
    private $dataLoader;
    
    public function __construct($silent = false) {
        $this->dataLoader = new SimpleDataLoader();
        
        // Load ALL data once at startup
        if (!$silent) {
            echo "Loading all JSON data...\n";
        }
        $this->allData = $this->dataLoader->loadAllData();
        
        if (!$silent) {
            $info = $this->dataLoader->getDataInfo();
            echo "✅ Loaded {$info['total_characters']} characters (~{$info['estimated_tokens']} tokens)\n";
        }
    }
    
    /**
     * Get response by sending ALL data + question to GPT-4
     */
    public function getResponse($question) {
        try {
            // Send everything to GPT-4
            $response = $this->callGPT4($question, $this->allData);
            
            $info = $this->dataLoader->getDataInfo();
            
            return [
                'success' => true,
                'response' => $response,
                'context_size' => $info['total_characters'],
                'estimated_tokens' => $info['estimated_tokens'],
                'approach' => 'full_context'
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    /**
     * Call GPT-4 with the entire context
     */
    private function callGPT4($question, $allData) {
        $systemPrompt = "You are a friendly, enthusiastic assistant for Kaizen Karate! 🥋 

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
- After School/Weekend Classes: https://www.kaizenkarateusa.com/#after-school
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

        $userPrompt = "Based on the complete Kaizen Karate data provided, please answer this question: {$question}

COMPLETE KAIZEN KARATE DATA:
{$allData}";

        $url = 'https://api.openai.com/v1/chat/completions';
        
        $data = [
            'model' => 'gpt-4-turbo',  // Use GPT-4 Turbo for large context
            'messages' => [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user', 'content' => $userPrompt]
            ],
            'temperature' => 0.7,
            'max_tokens' => 1000  // Increased for detailed responses
        ];
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . OPENAI_API_KEY
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode !== 200) {
            throw new Exception("OpenAI API error: HTTP {$httpCode}");
        }
        
        $result = json_decode($response, true);
        
        if (!isset($result['choices'][0]['message']['content'])) {
            throw new Exception("Invalid response from OpenAI");
        }
        
        return $result['choices'][0]['message']['content'];
    }
    
    /**
     * Get data statistics for debugging
     */
    public function getDataStats() {
        return $this->dataLoader->getDataInfo();
    }
    
    /**
     * Preview the loaded data (first 1000 characters)
     */
    public function previewData() {
        return substr($this->allData, 0, 1000) . "...";
    }
}
?>