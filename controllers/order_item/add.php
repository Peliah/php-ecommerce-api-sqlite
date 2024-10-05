<?php
require_once __DIR__ . '/../../models/OrderItems.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['order_id'], $data['product_id'], $data['quantity'], $data['price'])) {
            echo json_encode(['error' => 'Invalid input']);
            http_response_code(400);
            exit();
        }

        $order_id = $data['order_id'];
        $product_id = $data['product_id'];
        $quantity = $data['quantity'];
        $price = $data['price'];

        $orderItemsModel = new OrderItems();
        if ($orderItemsModel->create($order_id, $product_id, $quantity, $price)) {
            echo json_encode(['success' => 'Product added to order successfully']);
            http_response_code(201);
        } else {
            echo json_encode(['error' => 'Failed to add product to order']);
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
