<?php
// chat_handler.php
header('Content-Type: text/plain; charset=utf-8');

require_once 'deepseek_assistant.php';

// CORS ထည့်ရန် (cross-origin requests အတွက်)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Error handling
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    error_log("PHP Error [$errno]: $errstr in $errfile on line $errline");
});

try {
    // Message ရယူရန်
    $message = '';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['message'])) {
            $message = trim($_POST['message']);
        } elseif ($input = file_get_contents('php://input')) {
            $data = json_decode($input, true);
            if (isset($data['message'])) {
                $message = trim($data['message']);
            }
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['message'])) {
        $message = trim($_GET['message']);
    }
    
    // Validate message
    if (empty($message)) {
        echo "Please enter a message.";
        exit;
    }
    
    // Security: Sanitize input
    $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
    
    // Character limit
    if (strlen($message) > 2000) {
        echo "Message is too long. Please keep it under 2000 characters.";
        exit;
    }
    
    // Initialize DeepSeek Assistant
    $assistant = new DeepSeekAssistant();
    
    // Custom system prompt (optional)
    $systemPrompt = "You are DeepSeek AI, a helpful assistant created by DeepSeek. ";
    $systemPrompt .= "You are knowledgeable, friendly, and professional. ";
    $systemPrompt .= "Respond in the same language as the user's question. ";
    $systemPrompt .= "If the user asks in Burmese, respond in Burmese. ";
    $systemPrompt .= "Keep responses clear and concise unless asked for more detail.";
    
    // Get response from DeepSeek
    $response = $assistant->getResponse($message, $systemPrompt);
    
    // Clean and return response
    $response = trim($response);
    
    // If response is empty
    if (empty($response)) {
        $response = "I apologize, but I couldn't generate a response. Please try again.";
    }
    
    echo $response;
    
} catch (Exception $e) {
    error_log("Chat Handler Error: " . $e->getMessage());
    echo "Sorry, an error occurred while processing your request. Please try again later.";
}
?>