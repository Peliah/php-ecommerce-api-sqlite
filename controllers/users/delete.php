<?php
require_once __DIR__ . '/../../models/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $user = new User();
    $data = json_decode(file_get_contents("php://input"), true);

    $id = $data['id'];

    if ($user->delete($id)) {
        echo json_encode(["message" => "User deleted successfully"]);
    } else {
        echo json_encode(["message" => "User deletion failed"]);
    }
} else {
    echo json_encode(["message" => "Invalid request method"]);
}
?>
