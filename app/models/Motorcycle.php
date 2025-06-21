<?php
// app/models/Motorcycle.php
require_once __DIR__ . '/../core/Database.php';

class Motorcycle {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Fungsi ini sekarang menerima parameter untuk kolom pengurutan, arahnya, DAN kata kunci pencarian
    public function getAllMotorcycles($orderBy = 'id', $orderDirection = 'ASC', $searchQuery = null) {
        $allowedColumns = ['id', 'name', 'rental_price', 'created_at'];
        if (!in_array($orderBy, $allowedColumns)) {
            $orderBy = 'id';
        }

        $orderDirection = strtoupper($orderDirection);
        if (!in_array($orderDirection, ['ASC', 'DESC'])) {
            $orderDirection = 'ASC';
        }

        $sql = "SELECT * FROM motorcycles";
        $params = [];
        
        // Tambahkan kondisi pencarian jika ada searchQuery
        if ($searchQuery) {
            $sql .= " WHERE name LIKE ? OR description LIKE ?";
            $params[] = '%' . $searchQuery . '%';
            $params[] = '%' . $searchQuery . '%';
        }

        $sql .= " ORDER BY " . $orderBy . " " . $orderDirection;
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params); // Eksekusi query dengan parameter pencarian
        return $stmt->fetchAll();
    }

    public function getMotorcycleById($id) {
        $stmt = $this->db->prepare("SELECT * FROM motorcycles WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function addMotorcycle($name, $description, $price, $image_path, $is_available) {
        $stmt = $this->db->prepare("INSERT INTO motorcycles (name, description, rental_price, image_path, is_available) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$name, $description, $price, $image_path, $is_available]);
    }

    public function updateMotorcycle($id, $name, $description, $price, $image_path, $is_available) {
        $sql = "UPDATE motorcycles SET name = ?, description = ?, rental_price = ?, image_path = ?, is_available = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name, $description, $price, $image_path, $is_available, $id]);
    }

    public function deleteMotorcycle($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM motorcycles WHERE id = ?");
            $result = $stmt->execute([$id]);
            return $result;
        } catch (PDOException $e) {
            error_log("Motorcycle Delete Exception: " . $e->getMessage());
            return false;
        }
    }
}