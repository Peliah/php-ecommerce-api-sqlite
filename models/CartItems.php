<?php
require_once __DIR__ . '/../config/Database.php';

class CartItems {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->createTable();
    }

    private function createTable() {
        try {
            $this->db->exec("
                CREATE TABLE IF NOT EXISTS cart_items (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    cart_id INTEGER NOT NULL,
                    product_id INTEGER NOT NULL,
                    quantity INTEGER NOT NULL,
                    FOREIGN KEY (cart_id) REFERENCES cart(id),
                    FOREIGN KEY (product_id) REFERENCES product(id)
                )
            ");
        } catch (Exception $e) {
            echo "Error creating CartItems table: " . $e->getMessage();
        }
    }

    public function add($cart_id, $product_id, $quantity) {
        try {
            $stmt = $this->db->prepare('INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (?, ?, ?)');
            $stmt->bindParam(1, $cart_id);
            $stmt->bindParam(2, $product_id);
            $stmt->bindParam(3, $quantity);
            return $stmt->execute();
        } catch (Exception $e) {
            echo json_encode(['error' => 'Failed to add product to cart: ' . $e->getMessage()]);
            return false;
        }
    }

    public function getByCartId($cart_id) {
        try {
            $stmt = $this->db->prepare('SELECT * FROM cart_items WHERE cart_id = ?');
            $stmt->bindParam(1, $cart_id);
            return $stmt->execute();
        } catch (Exception $e) {
            echo json_encode(['error' => 'Failed to retrieve cart items: ' . $e->getMessage()]);
            return false;
        }
    }

    public function delete($id) {
        try {
            $stmt = $this->db->prepare('DELETE FROM cart_items WHERE id = ?');
            $stmt->bindParam(1, $id);
            return $stmt->execute();
        } catch (Exception $e) {
            echo json_encode(['error' => 'Failed to delete cart item: ' . $e->getMessage()]);
            return false;
        }
    }
}
?>
