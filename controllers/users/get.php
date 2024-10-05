<?php
require_once __DIR__ . '/../../models/User.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        
        $userModel = new User();
        $user = $userModel->getById($id);

        if ($user) {
            echo json_encode($user);
            http_response_code(200);
        } else {
            echo json_encode(['error' => 'User not found']);
            http_response_code(404);
        }
    } else {
        echo json_encode(['error' => 'Invalid request method or missing user ID']);
        http_response_code(400);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
    http_response_code(500);
}
?>
