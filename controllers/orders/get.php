<?php
require_once __DIR__ . '/../../models/Order.php';

try {
    if (!isset($_GET['order_id'])) {
        throw new Exception('Order ID is required');
    }

    $orderId = $_GET['order_id'];
    $order = new Order();
    $orderData = $order->getById($orderId);

    if (!$orderData) {
        throw new Exception('Order not found');
    }

    $items = $order->getItems($orderId);

    echo json_encode([
        'status' => 'success',
        'order' => $orderData,
        'items' => $items
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>
