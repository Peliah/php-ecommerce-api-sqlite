<?php
require_once __DIR__ . '/../../models/Cart.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        if (!isset($_GET['id'])) {
            echo json_encode(['error' => 'Missing cart ID']);
            http_response_code(400);
            exit();
        }

        $cart_id = $_GET['id'];
        $cartModel = new Cart();

        if ($cartModel->delete($cart_id)) {
            echo json_encode(['success' => 'Cart deleted successfully']);
        } else {
            echo json_encode(['error' => 'Failed to delete cart']);
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
