<?php
require_once __DIR__ . '/../config/Database.php';

class Product {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->createTable(); // Call to create the product table
    }

    private function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS product (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            description TEXT,
            price REAL NOT NULL,
            stock_quantity INTEGER NOT NULL,
            image_url TEXT,
            category_id INTEGER,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (category_id) REFERENCES category(id)
        )";

        // Execute the SQL to create the table
        $this->db->exec($sql);
    }

    public function create($name, $description, $price, $stock_quantity, $image_url, $category_id) {
        $stmt = $this->db->prepare('INSERT INTO product (name, description, price, stock_quantity, image_url, category_id) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $description);
        $stmt->bindParam(3, $price);
        $stmt->bindParam(4, $stock_quantity);
        $stmt->bindParam(5, $image_url);
        $stmt->bindParam(6, $category_id);
        return $stmt->execute();
    }

    public function getAll() {
        return $this->db->query('SELECT * FROM product');
    }

    public function delete($id) {
        $stmt = $this->db->prepare('DELETE FROM product WHERE id = ?');
        $stmt->bindParam(1, $id);
        return $stmt->execute();
    }
}

?>
