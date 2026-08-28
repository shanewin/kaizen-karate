<?php
/**
 * Smart Data Loader - Load relevant JSON data based on user query
 * 
 * Replaces the "load everything" approach with a topic-detection mechanism
 * to significantly reduce token usage and prevent API rate limits.
 */

class SmartDataLoader {
    private $topicsFolder;
    
    public function __construct($dataFolder = DATA_FOLDER) {
        // The topics are located in a subdirectory 'topics' within the data folder
        $this->topicsFolder = $dataFolder . '/topics';
        
        // Ensure the topics folder exists
        if (!is_dir($this->topicsFolder)) {
            // Fallback to main data folder if topics subfolder doesn't exist
            // This allows backward compatibility if needed, though we expect 'topics' to exist
            $this->topicsFolder = $dataFolder;
        }
    }
    
    /**
     * Load relevant data based on the user's question
     * 
     * @param string $question The user's query
     * @return string Formatted context string containing relevant data
     */
    public function loadRelevantData($question) {
        $filesToLoad = ['general.json']; // Always load general site info
        
        $questionLower = strtolower($question);
        
        // Topic identification logic
        // 1. Summer Camp
        if (strpos($questionLower, 'camp') !== false || 
            strpos($questionLower, 'summer') !== false) {
            $filesToLoad[] = 'summer_camp.json';
        }
        
        // 2. Programs / After School / Dojo
        if (strpos($questionLower, 'program') !== false || 
            strpos($questionLower, 'after school') !== false || 
            strpos($questionLower, 'dojo') !== false ||
            strpos($questionLower, 'class') !== false ||
            strpos($questionLower, 'schedule') !== false ||
            strpos($questionLower, 'weekend') !== false ||
            strpos($questionLower, 'evening') !== false ||
            strpos($questionLower, 'price') !== false ||
            strpos($questionLower, 'cost') !== false ||
            strpos($questionLower, 'tuition') !== false) {
            $filesToLoad[] = 'programs.json';
        }
        
        // 3. Belt Exams
        if (strpos($questionLower, 'belt') !== false || 
            strpos($questionLower, 'exam') !== false || 
            strpos($questionLower, 'test') !== false ||
            strpos($questionLower, 'rank') !== false ||
            strpos($questionLower, 'stripe') !== false ||
            strpos($questionLower, 'pass') !== false ||
            strpos($questionLower, 'fail') !== false ||
            strpos($questionLower, 'video') !== false ||
            strpos($questionLower, 'requirements') !== false) {
            $filesToLoad[] = 'belt_exams.json';
        }
        
        // 4. Kaizen Kenpo
        if (strpos($questionLower, 'kenpo') !== false || 
            strpos($questionLower, 'ikca') !== false ||
            strpos($questionLower, 'chuck sullivan') !== false ||
            strpos($questionLower, 'parker') !== false) {
            $filesToLoad[] = 'kaizen_kenpo.json';
        }

        // 5. Policies (refunds, make-ups, conduct, waivers)
        foreach (['policy','policies','refund','cancel','make-up','makeup',
                  'waiver','rule','conduct','absence','withdraw','terms'] as $kw) {
            if (strpos($questionLower, $kw) !== false) {
                $filesToLoad[] = 'policies.json';
                break;
            }
        }

        // 6. Locations / directions
        foreach (['location','address','direction','where','parking','nyc',
                  'manhattan','brooklyn','studio','near'] as $kw) {
            if (strpos($questionLower, $kw) !== false) {
                $filesToLoad[] = 'locations.json';
                break;
            }
        }

        // Deduplicate files just in case
        $filesToLoad = array_unique($filesToLoad);
        
        $allContent = [];
        
        foreach ($filesToLoad as $filename) {
            $filePath = $this->topicsFolder . '/' . $filename;
            
            if (file_exists($filePath)) {
                try {
                    $jsonContent = file_get_contents($filePath);
                    $data = json_decode($jsonContent, true);
                    
                    if ($data) {
                        $fileContent = $this->formatFileContent($filename, $data);
                        $allContent[] = $fileContent;
                    } else {
                        error_log("SmartDataLoader: Failed to decode JSON from {$filename}");
                    }
                } catch (Exception $e) {
                    error_log("SmartDataLoader: Error loading {$filename}: " . $e->getMessage());
                }
            } else {
                error_log("SmartDataLoader: File not found: {$filePath}");
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
     * (Reused from SimpleDataLoader)
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
        $clean = strip_tags($value);
        $clean = html_entity_decode($clean, ENT_QUOTES, 'UTF-8');
        $clean = preg_replace('/\s+/', ' ', $clean);
        $clean = trim($clean);
        return $clean;
    }
    
    /**
     * Check if a value is significant enough to include
     */
    private function isSignificantValue($value) {
        if (empty($value) || $value === '') return false;
        if (strlen($value) < 2) return false;
        $meaningless = ['#', 'null', 'undefined', 'true', 'false'];
        if (in_array(strtolower($value), $meaningless)) return false;
        return true;
    }
}
?>
