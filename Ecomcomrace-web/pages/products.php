<?php
include '../includes/db.php';
// session_start();

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>


<div class="container">
    <h2>Products</h2>
    <div class="row">
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="col-3">
                <div class="product">
                    <img src="<?php echo $row['image']; ?>" class="card-img-top" alt="Product Image">
                    <div class="product-info">
                        <h5 class="card-title"><?php echo $row['name']; ?></h5>
                        <p class="card-text"><?php echo $row['description']; ?>. Price: $<?php echo $row['price']; ?></p>
                        <button class="btn btn-primary add-to-cart"
                                data-id="<?php echo $row['id']; ?>"
                                data-name="<?php echo $row['name']; ?>"
                                data-price="<?php echo $row['price']; ?>"
                                data-quantity="1">Add to Cart</button>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

