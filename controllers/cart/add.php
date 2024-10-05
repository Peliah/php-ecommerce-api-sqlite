<?php
require_once __DIR__ . '/../../models/Cart.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['user_id'])) {
            echo json_encode(['error' => 'Missing user ID']);
            http_response_code(400);
            exit();
        }

        $user_id = $data['user_id'];
        $cartModel = new Cart();
        
        if ($cartModel->create($user_id)) {
            echo json_encode(['success' => 'Cart created successfully']);
            http_response_code(201);
        } else {
            echo json_encode(['error' => 'Failed to create cart']);
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
