<?php
require_once __DIR__ . '/../config/Database.php';

class Payment {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->createTable();
    }

    private function createTable() {
        try {
            $this->db->exec("
                CREATE TABLE IF NOT EXISTS payment (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    order_id INTEGER NOT NULL,
                    amount REAL NOT NULL,
                    payment_method TEXT NOT NULL,
                    payment_status TEXT NOT NULL,
                    payment_date TEXT NOT NULL,
                    FOREIGN KEY (order_id) REFERENCES orders(id)
                )
            ");
        } catch (Exception $e) {
            echo "Error creating Payment table: " . $e->getMessage();
        }
    }

    public function create($order_id, $amount, $payment_method, $payment_status) {
        try {
            $stmt = $this->db->prepare('INSERT INTO payment (order_id, amount, payment_method, payment_status, payment_date) VALUES (?, ?, ?, ?, datetime())');
            $stmt->bindParam(1, $order_id);
            $stmt->bindParam(2, $amount);
            $stmt->bindParam(3, $payment_method);
            $stmt->bindParam(4, $payment_status);
            return $stmt->execute();
        } catch (Exception $e) {
            echo json_encode(['error' => 'Failed to create payment: ' . $e->getMessage()]);
            return false;
        }
    }

    public function getByOrderId($order_id) {
        try {
            $stmt = $this->db->prepare('SELECT * FROM payment WHERE order_id = ?');
            $stmt->bindParam(1, $order_id);
            return $stmt->execute();
        } catch (Exception $e) {
            echo json_encode(['error' => 'Failed to retrieve payment: ' . $e->getMessage()]);
            return false;
        }
    }
}
?>
