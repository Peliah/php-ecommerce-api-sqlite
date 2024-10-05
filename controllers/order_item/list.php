<?php
require_once __DIR__ . '/../../models/Order.php';
require_once __DIR__ . '/../../models/OrderItems.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['order_id'])) {
        $order_id = $_GET['order_id'];

        $orderModel = new Order();
        $order = $orderModel->getById($order_id);

        if (!$order) {
            echo json_encode(['error' => 'Order not found']);
            http_response_code(404);
            exit();
        }

        $orderItemsModel = new OrderItems();
        $orderItems = $orderItemsModel->getByOrderId($order_id);

        $response = [
            'order' => $order,
            'items' => $orderItems
        ];

        echo json_encode($response);
        http_response_code(200);
    } else {
        echo json_encode(['error' => 'Invalid request method or missing order_id']);
        http_response_code(400);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
    http_response_code(500);
}
?>
