<?php
require_once __DIR__ . '/../../models/Product.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product = new Product();
    $data = json_decode(file_get_contents("php://input"), true);

    $name = $data['name'];
    $description = $data['description'];
    $price = $data['price'];
    $stock_quantity = $data['stock_quantity'];
    $image_url = $data['image_url'];
    $category_id = $data['category_id'];

    if ($product->create($name, $description, $price, $stock_quantity, $image_url, $category_id)) {
        echo json_encode(["message" => "Product added successfully"]);
    } else {
        echo json_encode(["message" => "Product addition failed"]);
    }
} else {
    echo json_encode(["message" => "Invalid request method"]);
}
?>
