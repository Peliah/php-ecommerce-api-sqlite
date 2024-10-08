<?php
require_once __DIR__ . '/../../models/Order.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['user_id'], $data['order_date'], $data['status'], $data['total'])) {
            echo json_encode(['error' => 'Invalid input']);
            http_response_code(400);
            exit();
        }

        $user_id = $data['user_id'];
        $order_date = $data['order_date'];
        $status = $data['status'];
        $total = $data['total'];

        $orderModel = new Order();
        if ($orderModel->create($user_id, $order_date, $status, $total)) {
            echo json_encode(['success' => 'Order created successfully']);
            http_response_code(201);
        } else {
            echo json_encode(['error' => 'Order creation failed']);
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
