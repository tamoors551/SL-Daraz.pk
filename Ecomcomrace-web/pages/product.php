<?php
include '../includes/db.php';
include '../includes/header.php';
include '../includes/functions.php';

$product_id = $_GET['id'];
$sql = "SELECT * FROM products WHERE id = $product_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
} else {
    echo "Product not found";
    exit;
}
?>

<div class="container">
  <div class="row">
    <div class="col-md-6">
      <img src="<?php echo $product['image']; ?>" class="img-fluid" alt="<?php echo $product['name']; ?>">
    </div>
    <div class="col-md-6">
      <h1><?php echo $product['name']; ?></h1>
      <p><?php echo $product['description']; ?></p>
      <h3>$<?php echo $product['price']; ?></h3>
      <form action="../ajax/cart.php" method="post">
        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
        <button type="submit" class="btn btn-primary">Add to Cart</button>
      </form>
    </div>
  </div>
</div>

<?php
include '../includes/footer.php';
?>
