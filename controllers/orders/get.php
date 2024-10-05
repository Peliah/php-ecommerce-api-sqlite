<?php
// require_once __DIR__ . '/../../models/Order.php';

// try {
//     if (!isset($_GET['order_id'])) {
//         throw new Exception('Order ID is required');
//     }

//     $orderId = $_GET['order_id'];
//     $order = new Order();
//     $orderData = $order->getById($orderId);

//     if (!$orderData) {
//         throw new Exception('Order not found');
//     }

//     $items = $order->getItems($orderId);

//     echo json_encode([
//         'status' => 'success',
//         'order' => $orderData,
//         'items' => $items
//     ]);
// } catch (Exception $e) {
//     echo json_encode([
//         'status' => 'error',
//         'message' => $e->getMessage()
//     ]);
// }
?>

<?php
require_once __DIR__ . '/../../models/Order.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (!isset($_GET['order_id'])) {
            echo json_encode(['error' => 'Order ID is required']);
            http_response_code(400);
            exit();
        }

        $order_id = $_GET['order_id'];

        $orderModel = new Order();
        $order = $orderModel->getById($order_id);
        echo json_encode($order);
    } else {
        echo json_encode(['error' => 'Invalid request method']);
        http_response_code(405);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
    http_response_code(500);
}
?>
