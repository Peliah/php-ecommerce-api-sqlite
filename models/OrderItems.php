<?php
require_once __DIR__ . '/../config/Database.php';

class OrderItems {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->createTable();
    }

    private function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS order_items (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            order_id INTEGER NOT NULL,
            product_id INTEGER NOT NULL,
            quantity INTEGER NOT NULL,
            price REAL NOT NULL,
            FOREIGN KEY(order_id) REFERENCES orders(id),
            FOREIGN KEY(product_id) REFERENCES product(id)
        )";
        $this->db->exec($sql);
    }

    public function create($order_id, $product_id, $quantity, $price) {
        try {
            $stmt = $this->db->prepare('INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)');
            $stmt->bindParam(1, $order_id);
            $stmt->bindParam(2, $product_id);
            $stmt->bindParam(3, $quantity);
            $stmt->bindParam(4, $price);
            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    public function getByOrderId($order_id) {
        try {
            $stmt = $this->db->prepare('SELECT * FROM order_items WHERE order_id = ?');
            $stmt->bindParam(1, $order_id);
            $stmt->execute();
            return $stmt->fetchAll(SQLITE3_ASSOC);
        } catch (Exception $e) {
            return false;
        }
    }

    public function delete($order_id, $product_id) {
        try {
            $stmt = $this->db->prepare('DELETE FROM order_items WHERE order_id = ? AND product_id = ?');
            $stmt->bindParam(1, $order_id);
            $stmt->bindParam(2, $product_id);
            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }
}
?>
