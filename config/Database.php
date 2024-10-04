<?php
class Database {
    private $db;

    public function __construct() {
        $this->db = new SQLite3(__DIR__ . '/../database/ecommerce.db');
    }

    public function getConnection() {
        return $this->db;
    }
}
?>
