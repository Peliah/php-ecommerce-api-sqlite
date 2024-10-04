<?php
require_once __DIR__ . '/../../models/Product.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $product = new Product();
    $data = json_decode(file_get_contents("php://input"), true);

    $id = $data['id'];

    if ($product->delete($id)) {
        echo json_encode(["message" => "Product deleted successfully"]);
    } else {
        echo json_encode(["message" => "Product deletion failed"]);
    }
}else {
    echo json_encode(["message" => "Invalid request method"]);
}
?>
