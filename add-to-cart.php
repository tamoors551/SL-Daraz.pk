<?php
session_start();

// Include database connection
require_once "config.php";

// Check if product information is provided via GET
if (!isset($_GET['product_id'], $_GET['product_name'], $_GET['product_price'], $_GET['product_image'])) {
    header("Location: index.php");
    exit;
}

// Retrieve product information from GET parameters
$product_id = $_GET['product_id'];
$product_name = $_GET['product_name'];
$product_price = $_GET['product_price'];
$product_image = $_GET['product_image'];

// Handle form submission (Add to cart)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    // Validate product ID
    if (!empty($product_id)) {
        // Check if user is logged in
        if (isset($_SESSION['id'])) {
            $user_id = $_SESSION['id'];

            // Check if the product is already in the cart for this user
            $stmt_check = $conn->prepare("SELECT id FROM cart WHERE user_id = ? AND product_id = ?");
            $stmt_check->bind_param("ii", $user_id, $product_id);
            $stmt_check->execute();
            $stmt_check->store_result();

            if ($stmt_check->num_rows > 0) {
                // Product already in cart, update quantity
                $stmt_update = $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?");
                $stmt_update->bind_param("ii", $user_id, $product_id);
                $stmt_update->execute();
                $stmt_update->close();
            } else {
                // Product not in cart, insert new entry
                $stmt_insert = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)");
                $stmt_insert->bind_param("ii", $user_id, $product_id);
                $stmt_insert->execute();
                $stmt_insert->close();
            }
            $stmt_check->close();

            // Redirect to cart page
            header("Location: cart.php");
            exit;
        } else {
            // User not logged in, redirect to login page
            header("Location: login.php");
            exit;
        }
    } else {
        // Product ID not provided, redirect to index page
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add to Cart</title>
</head>
<body>
    <h1>Add to Cart</h1>
    <div>
        <h2><?php echo $product_name; ?></h2>
        <img src="<?php echo $product_image; ?>" alt="<?php echo $product_name; ?>" width="200">
        <p>Price: $<?php echo $product_price; ?></p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?product_id=' . $product_id . '&product_name=' . urlencode($product_name) . '&product_price=' . $product_price . '&product_image=' . urlencode($product_image); ?>" method="post">
            <button type="submit" name="add_to_cart">Add to Cart</button>
        </form>
    </div>
</body>
</html>
