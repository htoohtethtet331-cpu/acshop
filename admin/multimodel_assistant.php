<?php
// multi_model_assistant.php
class MultiModelAssistant {
    private $models = [
        'deepseek-chat' => 'DeepSeek Chat',
        'deepseek-coder' => 'DeepSeek Coder',
        'gpt-3.5-turbo' => 'GPT-3.5 Turbo',
        'gpt-4' => 'GPT-4'
    ];
    
    public function getResponse($message, $model = 'deepseek-chat') {
        if (!array_key_exists($model, $this->models)) {
            $model = 'deepseek-chat';
        }
        
        if (strpos($model, 'deepseek') === 0) {
            // Use DeepSeek API
            $assistant = new DeepSeekAssistant($model);
            return $assistant->getResponse($message);
        } else {
            // Use other API
            return $this->useOtherAPI($message, $model);
        }
    }
}
?>