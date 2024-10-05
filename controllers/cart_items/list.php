<?php
require_once __DIR__ . '/../../models/CartItems.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (!isset($_GET['cart_id'])) {
            echo json_encode(['error' => 'Missing cart ID']);
            http_response_code(400);
            exit();
        }

        $cart_id = $_GET['cart_id'];
        $cartItemsModel = new CartItems();
        $result = $cartItemsModel->getByCartId($cart_id);

        if ($result) {
            $items = [];
            while ($item = $result->fetchArray(SQLITE3_ASSOC)) {
                $items[] = $item;
            }
            echo json_encode($items);
        } else {
            echo json_encode(['error' => 'No items found']);
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
