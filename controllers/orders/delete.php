<?php
require_once __DIR__ . '/../../models/Order.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['order_id'])) {
        $order_id = $_GET['order_id'];

        $orderModel = new Order();
        $deleted = $orderModel->delete($order_id);

        if ($deleted) {
            echo json_encode(['success' => 'Order and associated items deleted successfully']);
            http_response_code(200);
        } else {
            echo json_encode(['error' => 'Failed to delete order']);
            http_response_code(500);
        }
    } else {
        echo json_encode(['error' => 'Invalid request method or missing order_id']);
        http_response_code(400);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
    http_response_code(500);
}
?>
