<?php
include '../includes/db.php';
include '../includes/header.php';
include '../includes/functions.php';

$category_id = $_GET['id'];
$sql = "SELECT * FROM products WHERE category_id = $category_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $products = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo "No products found in this category";
    exit;
}
?>

<div class="container">
  <h2>Category Products</h2>
  <div class="row">
    <?php foreach ($products as $product) : ?>
    <div class="col-md-3">
      <div class="card mb-4 shadow-sm">
        <a href="product.php?id=<?php echo $product['id']; ?>">
          <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>">
          <div class="card-body">
            <h5 class="card-title"><?php echo $product['name']; ?></h5>
            <p class="card-text">$<?php echo $product['price']; ?></p>
          </div>
        </a>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<?php
include '../includes/footer.php';
?>
