<?php
require_once __DIR__ . '/../config/Database.php';

class User {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->createTable(); 
    }

    private function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS user (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT NOT NULL UNIQUE,
            password TEXT NOT NULL,
            role TEXT NOT NULL,
            address TEXT,
            phone_number TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        $this->db->exec($sql);
    }

    public function create($name, $email, $password, $role, $address, $phone_number) {
        try {
            $stmt = $this->db->prepare('INSERT INTO user (name, email, password, role, address, phone_number) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->bindParam(1, $name);
            $stmt->bindParam(2, $email);
            $stmt->bindParam(3, $password);
            $stmt->bindParam(4, $role);
            $stmt->bindParam(5, $address);
            $stmt->bindParam(6, $phone_number);
            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    public function getAll() {
        return $this->db->query('SELECT * FROM user');
    }

    public function getById($id) {
        $stmt = $this->db->prepare('SELECT * FROM user WHERE id = ?');
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetchArray(SQLITE3_ASSOC);
    }

    public function delete($id) {
        try {
            $stmt = $this->db->prepare('DELETE FROM user WHERE id = ?');
            $stmt->bindParam(1, $id);
            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }
}
?>
