<?php
require_once __DIR__ . '/../../models/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $user = new User();
    $result = $user->getAll();

    $users = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $users[] = $row;
    }

    echo json_encode($users);
} else {
    echo json_encode(["message" => "Invalid request method"]);
}
?>
