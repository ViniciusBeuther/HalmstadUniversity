<?php
class UserLogModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function insertUserLog($userId, $logId) {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $stmt = $this->db->prepare("INSERT INTO User_Access_Log (user_id, access_log_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $userId, $logId);
        $stmt->execute();
    }
}