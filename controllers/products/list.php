<?php
require_once __DIR__ . '/../../models/Product.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $product = new Product();
    $result = $product->getAll();

    $products = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $products[] = $row;
    }

    echo json_encode($products);
} else {
    echo json_encode(["message" => "Invalid request method"]);
}
?>
