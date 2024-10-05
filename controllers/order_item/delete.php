<?php
require_once __DIR__ . '/../../models/OrderItems.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['order_id']) && isset($_GET['product_id'])) {
        $order_id = $_GET['order_id'];
        $product_id = $_GET['product_id'];

        $orderItemsModel = new OrderItems();
        $deleted = $orderItemsModel->delete($order_id, $product_id);

        if ($deleted) {
            echo json_encode(['success' => 'Order item deleted successfully']);
            http_response_code(200);
        } else {
            echo json_encode(['error' => 'Failed to delete order item']);
            http_response_code(500);
        }
    } else {
        echo json_encode(['error' => 'Invalid request method or missing parameters']);
        http_response_code(400);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
    http_response_code(500);
}
?>
