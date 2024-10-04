<?php
require_once __DIR__ . '/../../models/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User();
    $data = json_decode(file_get_contents("php://input"), true);
    
    $name = $data['name'];
    $email = $data['email'];
    $password = $data['password'];
    $role = $data['role'];
    $address = $data['address'];
    $phone_number = $data['phone_number'];

    if ($user->create($name, $email, $password, $role, $address, $phone_number)) {
        echo json_encode(["message" => "User created successfully"]);
    } else {
        echo json_encode(["message" => "User creation failed"]);
    }
} else {
    echo json_encode(["message" => "Invalid request method"]);
}
?>
