<?php
// chat_history.php
class ChatHistory {
    private $db;
    
    public function __construct() {
        // Database connection (MySQL example)
        $this->db = new mysqli('localhost', 'username', 'password', 'chat_db');
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }
    
    public function saveMessage($userId, $message, $response, $isUser = true) {
        $stmt = $this->db->prepare("INSERT INTO chat_history (user_id, message, response, is_user, timestamp) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("issi", $userId, $message, $response, $isUser);
        return $stmt->execute();
    }
    
    public function getHistory($userId, $limit = 50) {
        $stmt = $this->db->prepare("SELECT * FROM chat_history WHERE user_id = ? ORDER BY timestamp DESC LIMIT ?");
        $stmt->bind_param("ii", $userId, $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>