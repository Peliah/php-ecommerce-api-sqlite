<?php
require_once __DIR__ . '/../config/Database.php';

class Order {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->createTable();
    }

    private function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS orders (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            order_date TEXT NOT NULL,
            status TEXT NOT NULL,
            total REAL NOT NULL,
            FOREIGN KEY(user_id) REFERENCES user(id)
        )";
        $this->db->exec($sql);
    }

    public function create($user_id, $order_date, $status, $total) {
        try {
            $stmt = $this->db->prepare('INSERT INTO orders (user_id, order_date, status, total) VALUES (?, ?, ?, ?)');
            $stmt->bindParam(1, $user_id);
            $stmt->bindParam(2, $order_date);
            $stmt->bindParam(3, $status);
            $stmt->bindParam(4, $total);
            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    // public function getById($order_id) {
    //     try {
    //         $stmt = $this->db->prepare('SELECT * FROM orders WHERE id = ?');
    //         $stmt->bindParam(1, $order_id);
    //         $stmt->execute();
    //         return $stmt->fetchAll(SQLITE3_ASSOC);
    //     } catch (Exception $e) {
    //         return false;
    //     }
    // }

    public function getById($order_id) {
        $stmt = $this->db->prepare('SELECT * FROM orders WHERE id = ?');
        $stmt->bindParam(1, $order_id);
        $result = $stmt->execute(); // Execute the statement
    
        // Fetch the order details
        $order = $result->fetchArray(SQLITE3_ASSOC);
        if ($order) {
            return $order;
        } else {
            throw new Exception('Order not found.');
        }
    }
    

    public function delete($id) {
        try {
            // Delete all associated items first
            $deleteItemsStmt = $this->db->prepare('DELETE FROM order_items WHERE order_id = ?');
            $deleteItemsStmt->bindParam(1, $id);
            $deleteItemsStmt->execute();

            // Now delete the order itself
            $stmt = $this->db->prepare('DELETE FROM orders WHERE id = ?');
            $stmt->bindParam(1, $id);
            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }
}
?>
