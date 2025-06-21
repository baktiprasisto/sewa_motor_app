<?php

require_once __DIR__ . '/../core/Database.php';

class WebsiteProfile {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllProfiles() {
        $stmt = $this->db->query("SELECT * FROM website_profile ORDER BY id ASC");
        return $stmt->fetchAll();
    }

    public function getProfileById($id) {
        $stmt = $this->db->prepare("SELECT * FROM website_profile WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getProfileByTitle($title) {
        $stmt = $this->db->prepare("SELECT * FROM website_profile WHERE title = ?");
        $stmt->execute([$title]);
        return $stmt->fetch();
    }

    public function updateProfile($id, $title, $content) {
        $stmt = $this->db->prepare("UPDATE website_profile SET title = ?, content = ?, last_updated_at = CURRENT_TIMESTAMP WHERE id = ?");
        return $stmt->execute([$title, $content, $id]);
    }

    public function addProfile($title, $content) {
        $stmt = $this->db->prepare("INSERT INTO website_profile (title, content) VALUES (?, ?)");
        return $stmt->execute([$title, $content]);
    }

    public function deleteProfile($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM website_profile WHERE id = ?");
            $result = $stmt->execute([$id]);

            if (!$result) {
                $errorInfo = $stmt->errorInfo();
                $dbErrorInfo = Database::getInstance()->getErrorInfo();
                error_log("Profile Delete Error (SQLSTATE: " . $errorInfo[0] . ", Code: " . $errorInfo[1] . ", Message: " . $errorInfo[2] . ")"); 
                echo "DEBUG PDO ERROR IN Profile Model (SQLSTATE: " . $errorInfo[0] . ", Code: " . $errorInfo[1] . ", Message: " . $errorInfo[2] . ")<br>";
                echo "DEBUG DB ERROR INFO (from connection): " . print_r($dbErrorInfo, true) . "<br>";
            }
            return $result;
        } catch (PDOException $e) {
            error_log("Profile Delete Exception: " . $e->getMessage()); 
            echo "DEBUG PDO EXCEPTION IN Profile Model: " . $e->getMessage() . "<br>";
            return false;
        }
    }
}
?>