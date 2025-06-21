<?php
// app/models/Order.php
require_once __DIR__ . '/../core/Database.php';

class Order {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllOrders() {
        $stmt = $this->db->query("SELECT o.*, m.name as motorcycle_name FROM orders o JOIN motorcycles m ON o.motorcycle_id = m.id ORDER BY o.created_at ASC");
        return $stmt->fetchAll();
    }

    public function getOrderById($id) {
        $stmt = $this->db->prepare("SELECT o.*, m.name as motorcycle_name FROM orders o JOIN motorcycles m ON o.motorcycle_id = m.id WHERE o.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function addOrder($motorcycle_id, $customer_name, $customer_email, $customer_phone, $rental_start_date, $rental_end_date, $total_price) {
        $stmt = $this->db->prepare("INSERT INTO orders (motorcycle_id, customer_name, customer_email, customer_phone, rental_start_date, rental_end_date, total_price) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$motorcycle_id, $customer_name, $customer_email, $customer_phone, $rental_start_date, $rental_end_date, $total_price]);
    }

    public function updateOrderStatus($id, $status) {
        $stmt = $this->db->prepare("UPDATE orders SET status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    public function getOrdersByDateRange($startDate, $endDate) {
        $stmt = $this->db->prepare("SELECT o.*, m.name as motorcycle_name FROM orders o JOIN motorcycles m ON o.motorcycle_id = m.id WHERE o.created_at BETWEEN ? AND ? ORDER BY o.created_at DESC");
        $stmt->execute([$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        return $stmt->fetchAll();
    }

    // Fungsi baru untuk mencari pesanan berdasarkan email atau nomor telepon
    public function getOrdersByCustomerContact($email = null, $phone = null) {
        $sql = "SELECT o.*, m.name as motorcycle_name FROM orders o JOIN motorcycles m ON o.motorcycle_id = m.id WHERE 1=1";
        $params = [];

        if ($email) {
            $sql .= " AND o.customer_email = ?";
            $params[] = $email;
        }
        if ($phone) {
            // Jika ada email dan telepon, bisa pakai OR
            if ($email) {
                $sql .= " OR o.customer_phone = ?";
            } else {
                $sql .= " AND o.customer_phone = ?";
            }
            $params[] = $phone;
        }
        
        // Tambahkan pengurutan dari yang terbaru ke terlama untuk hasil pencarian
        $sql .= " ORDER BY o.created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}