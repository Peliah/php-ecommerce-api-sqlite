<?php
require_once __DIR__ . '/../../models/User.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $userModel = new User();
        $users = $userModel->getAll();

        $result = [];
        while ($user = $users->fetchArray(SQLITE3_ASSOC)) {
            $result[] = $user;
        }

        echo json_encode($result);
        http_response_code(200);
    } else {
        echo json_encode(['error' => 'Invalid request method']);
        http_response_code(405);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
    http_response_code(500);
}
?>
