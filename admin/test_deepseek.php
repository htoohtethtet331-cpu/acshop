<?php
// test_deepseek.php
require_once 'deepseek_assistant.php';

echo "<h1>DeepSeek API Test</h1>";

$testMessages = [
    "Hello, who are you?",
    "What is the capital of Myanmar?",
    "Write a simple PHP function to calculate factorial",
    "ကျေးဇူးပြုပြီး မြန်မာလို ပြန်ဖြေပေးပါ"
];

$assistant = new DeepSeekAssistant();

foreach ($testMessages as $message) {
    echo "<h3>Question: " . htmlspecialchars($message) . "</h3>";
    $response = $assistant->getResponse($message);
    echo "<p><strong>Response:</strong> " . nl2br(htmlspecialchars($response)) . "</p>";
    echo "<hr>";
}
?>