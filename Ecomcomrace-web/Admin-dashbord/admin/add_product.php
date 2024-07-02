<?php
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name']) && isset($_POST['price'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $sql = "INSERT INTO products (name, price) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sd", $name, $price);
    if ($stmt->execute()) {
        echo "Product added successfully";
    } else {
        echo "Error adding product: " . $conn->error;
    }
} else {
    echo "Invalid request";
}
?>
