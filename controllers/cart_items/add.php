<?php
require_once __DIR__ . '/../../models/CartItems.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['cart_id'], $data['product_id'], $data['quantity'])) {
            echo json_encode(['error' => 'Missing required fields']);
            http_response_code(400);
            exit();
        }

        $cart_id = $data['cart_id'];
        $product_id = $data['product_id'];
        $quantity = $data['quantity'];

        $cartItemsModel = new CartItems();
        if ($cartItemsModel->add($cart_id, $product_id, $quantity)) {
            echo json_encode(['success' => 'Product added to cart']);
            http_response_code(201);
        } else {
            echo json_encode(['error' => 'Failed to add product to cart']);
            http_response_code(500);
        }
    } else {
        echo json_encode(['error' => 'Invalid request method']);
        http_response_code(405);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
    http_response_code(500);
}
?>
