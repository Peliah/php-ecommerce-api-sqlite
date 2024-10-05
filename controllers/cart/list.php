<?php
require_once __DIR__ . '/../../models/Cart.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (!isset($_GET['user_id'])) {
            echo json_encode(['error' => 'Missing user ID']);
            http_response_code(400);
            exit();
        }

        $user_id = $_GET['user_id'];
        $cartModel = new Cart();
        $result = $cartModel->getByUserId($user_id);

        if ($result) {
            $cart = $result->fetchArray(SQLITE3_ASSOC);
            echo json_encode($cart);
        } else {
            echo json_encode(['error' => 'Cart not found']);
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
