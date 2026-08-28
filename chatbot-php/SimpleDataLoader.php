<?php
/**
 * Simple Data Loader - Load ALL JSON data into one context string
 * No chunking, no embeddings, no complexity - just raw data for GPT-4
 */

class SimpleDataLoader {
    private $dataFolder;
    
    public function __construct($dataFolder = DATA_FOLDER) {
        $this->dataFolder = $dataFolder;
    }
    
    /**
     * Load ALL JSON data and format it for GPT-4 context
     * Returns one large formatted string with all content
     */
    public function loadAllData() {
        $allContent = [];
        
        // Get all JSON files
        $jsonFiles = glob($this->dataFolder . '/*.json');
        
        foreach ($jsonFiles as $filePath) {
            $filename = basename($filePath);
            
            // Skip backup and draft files
            if (strpos($filename, '-backup') !== false || strpos($filename, '-draft') !== false) {
                continue;
            }
            
            try {
                $data = json_decode(file_get_contents($filePath), true);
                if ($data) {
                    $fileContent = $this->formatFileContent($filename, $data);
                    $allContent[] = $fileContent;
                }
            } catch (Exception $e) {
                error_log("Error loading {$filename}: " . $e->getMessage());
            }
        }
        
        return implode("\n\n" . str_repeat("=", 80) . "\n\n", $allContent);
    }
    
    /**
     * Format content from a single JSON file
     */
    private function formatFileContent($filename, $data) {
        $content = "FILE: {$filename}\n";
        $content .= str_repeat("-", 40) . "\n\n";
        
        $content .= $this->formatDataRecursively($data, 0);
        
        return $content;
    }
    
    /**
     * Recursively format JSON data into readable text
     */
    private function formatDataRecursively($data, $depth = 0) {
        $content = "";
        $indent = str_repeat("  ", $depth);
        
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    $content .= "{$indent}{$key}:\n";
                    $content .= $this->formatDataRecursively($value, $depth + 1);
                } else {
                    // Format individual values
                    $cleanValue = $this->cleanValue($value);
                    if ($this->isSignificantValue($cleanValue)) {
                        $content .= "{$indent}{$key}: {$cleanValue}\n";
                    }
                }
            }
        } else {
            $cleanValue = $this->cleanValue($data);
            if ($this->isSignificantValue($cleanValue)) {
                $content .= "{$indent}{$cleanValue}\n";
            }
        }
        
        return $content;
    }
    
    /**
     * Clean and format individual values
     */
    private function cleanValue($value) {
        if (!is_string($value)) {
            return $value;
        }
        
        // Remove HTML tags
        $clean = strip_tags($value);
        
        // Decode HTML entities
        $clean = html_entity_decode($clean, ENT_QUOTES, 'UTF-8');
        
        // Clean up whitespace
        $clean = preg_replace('/\s+/', ' ', $clean);
        $clean = trim($clean);
        
        return $clean;
    }
    
    /**
     * Check if a value is significant enough to include
     */
    private function isSignificantValue($value) {
        if (empty($value) || $value === '') {
            return false;
        }
        
        // Skip very short non-meaningful values
        if (strlen($value) < 2) {
            return false;
        }
        
        // Skip common meaningless values
        $meaningless = ['#', 'null', 'undefined', 'true', 'false'];
        if (in_array(strtolower($value), $meaningless)) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Get formatted data size info
     */
    public function getDataInfo() {
        $content = $this->loadAllData();
        
        return [
            'total_characters' => strlen($content),
            'total_words' => str_word_count($content),
            'estimated_tokens' => ceil(strlen($content) / 4), // Rough estimate: 4 chars per token
            'total_lines' => substr_count($content, "\n")
        ];
    }
}
?>