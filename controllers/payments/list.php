<?php
require_once __DIR__ . '/../../models/Payment.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (!isset($_GET['order_id'])) {
            echo json_encode(['error' => 'Missing order ID']);
            http_response_code(400);
            exit();
        }

        $order_id = $_GET['order_id'];
        $paymentModel = new Payment();
        $result = $paymentModel->getByOrderId($order_id);

        if ($result) {
            $payments = [];
            while ($payment = $result->fetchArray(SQLITE3_ASSOC)) {
                $payments[] = $payment;
            }
            echo json_encode($payments);
        } else {
            echo json_encode(['error' => 'No payments found']);
            http_response_code(404);
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
