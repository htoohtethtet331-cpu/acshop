<?php
// deepseek_assistant.php
require_once 'config.php';

class DeepSeekAssistant {
    private $apiKey;
    private $apiUrl;
    private $model;
    
    public function __construct($model = DEEPSEEK_MODEL) {
        $this->apiKey = DEEPSEEK_API_KEY;
        $this->apiUrl = DEEPSEEK_API_URL;
        $this->model = $model;
    }
    
    public function getResponse($message, $systemPrompt = null) {
        // Default system prompt
        if ($systemPrompt === null) {
            $systemPrompt = "You are DeepSeek AI, a helpful AI assistant created by DeepSeek Company. Respond in the user's preferred language.";
        }
        
        $data = [
            'model' => $this->model,
            'messages' => [
                [
                    'role' => 'system', 
                    'content' => $systemPrompt
                ],
                [
                    'role' => 'user', 
                    'content' => $message
                ]
            ],
            'max_tokens' => MAX_TOKENS,
            'temperature' => 0.7,
            'stream' => false
        ];
        
        // cURL request ပို့ရန်
        $ch = curl_init();
        
        curl_setopt_array($ch, [
            CURLOPT_URL => $this->apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->apiKey,
                'Accept: application/json'
            ],
            CURLOPT_TIMEOUT => 30, // 30 seconds timeout
            CURLOPT_SSL_VERIFYPEER => true
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            return "Network error: " . $error;
        }
        
        curl_close($ch);
        
        // Response ကို process လုပ်ရန်
        $result = json_decode($response, true);
        
        if ($httpCode !== 200) {
            $errorMsg = isset($result['error']['message']) ? 
                       $result['error']['message'] : 
                       "HTTP Error: " . $httpCode;
            return "Error: " . $errorMsg;
        }
        
        if (isset($result['choices'][0]['message']['content'])) {
            return $result['choices'][0]['message']['content'];
        } else {
            return "No response generated. Response: " . print_r($result, true);
        }
    }
    
    // File upload အတွက် (DeepSeek supports file uploads)
    public function uploadFile($filePath, $purpose = 'vision') {
        if (!file_exists($filePath)) {
            return ['error' => 'File not found'];
        }
        
        $ch = curl_init();
        $cfile = new CURLFile($filePath);
        
        $postData = [
            'purpose' => $purpose,
            'file' => $cfile
        ];
        
        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://api.deepseek.com/files',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $this->apiKey
            ]
        ]);
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        return json_decode($response, true);
    }
}

// Helper function
function chatWithDeepSeek($message) {
    $assistant = new DeepSeekAssistant();
    return $assistant->getResponse($message);
}
?>