<?php
require_once __DIR__ . '/../config/Database.php';

class Cart {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->createTable();
    }

    private function createTable() {
        try {
            $this->db->exec("
                CREATE TABLE IF NOT EXISTS cart (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    user_id INTEGER NOT NULL,
                    created_at TEXT NOT NULL,
                    updated_at TEXT NOT NULL,
                    FOREIGN KEY (user_id) REFERENCES user(id)
                )
            ");
        } catch (Exception $e) {
            echo "Error creating Cart table: " . $e->getMessage();
        }
    }

    public function create($user_id) {
        try {
            $stmt = $this->db->prepare('INSERT INTO cart (user_id, created_at, updated_at) VALUES (?, datetime(), datetime())');
            $stmt->bindParam(1, $user_id);
            return $stmt->execute();
        } catch (Exception $e) {
            echo json_encode(['error' => 'Failed to create cart: ' . $e->getMessage()]);
            return false;
        }
    }

    public function getByUserId($user_id) {
        try {
            $stmt = $this->db->prepare('SELECT * FROM cart WHERE user_id = ?');
            $stmt->bindParam(1, $user_id);
            return $stmt->execute();
        } catch (Exception $e) {
            echo json_encode(['error' => 'Failed to retrieve cart: ' . $e->getMessage()]);
            return false;
        }
    }

    public function delete($id) {
        try {
            $stmt = $this->db->prepare('DELETE FROM cart WHERE id = ?');
            $stmt->bindParam(1, $id);
            return $stmt->execute();
        } catch (Exception $e) {
            echo json_encode(['error' => 'Failed to delete cart: ' . $e->getMessage()]);
            return false;
        }
    }
}
?>
