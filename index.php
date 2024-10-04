<?php
// Check if the request method is correct
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Define the base URL
    $base_url = "http://" . $_SERVER['HTTP_HOST'] . "/ecommerce_project/controllers";

    // Print a debug message
    echo "Base URL: " . $base_url . "<br><br>";
    echo "Available Endpoints:<br>";

    // Define an array of endpoints with full paths
    $endpoints = [
        $base_url . '/products/list.php' => 'List all products',
        $base_url . '/products/add.php' => 'Add a new product',
        $base_url . '/products/delete.php?id={id}' => 'Delete a product by ID',
        $base_url . '/products/update.php?id={id}' => 'Update a product by ID',
        $base_url . '/categories/list.php' => 'List all categories',
        $base_url . '/categories/add.php' => 'Add a new category',
        $base_url . '/categories/delete.php?id={id}' => 'Delete a category by ID',
        $base_url . '/categories/update.php?id={id}' => 'Update a category by ID',
        $base_url . '/orders/list.php' => 'List all orders',
        $base_url . '/orders/add.php' => 'Place a new order',
        $base_url . '/orders/delete.php?id={id}' => 'Delete an order by ID',
        $base_url . '/users/list.php' => 'List all users',
        $base_url . '/users/add.php' => 'Add a new user',
        $base_url . '/users/delete.php?id={id}' => 'Delete a user by ID',
    ];

    // Display the list of endpoints
    header('Content-Type: application/json');
    echo json_encode($endpoints, JSON_PRETTY_PRINT);
} else {
    echo "Invalid request method!";
}
?>
