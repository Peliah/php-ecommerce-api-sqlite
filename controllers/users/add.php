<?php
require_once __DIR__ . '/../../models/User.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['name'], $data['email'], $data['password'], $data['role'])) {
            echo json_encode(['error' => 'Invalid input']);
            http_response_code(400);
            exit();
        }

        $name = $data['name'];
        $email = $data['email'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $role = $data['role'];
        $address = $data['address'] ?? '';
        $phone_number = $data['phone_number'] ?? '';

        $userModel = new User();
        if ($userModel->create($name, $email, $password, $role, $address, $phone_number)) {
            echo json_encode(['success' => 'User created successfully']);
            http_response_code(201);
        } else {
            echo json_encode(['error' => 'User creation failed']);
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

