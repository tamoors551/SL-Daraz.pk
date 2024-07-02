<?php
session_start();

require_once 'includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include_once 'includes/header.php';
?>

<div class="container">
    <h1>Welcome to the Admin Dashboard</h1>

    <div class="row">
        <div class="col-md-8">
            <h2>Product List</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="product-list">
                    <!-- Product list will be dynamically added here -->
                </tbody>
            </table>
        </div>
        <div class="col-md-4">
            <h2>Add Product</h2>
            <form id="add-product-form">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="number" class="form-control" id="price" name="price" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Product</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Fetch products on page load
    $(document).ready(function() {
        fetchProducts();
    });

    // Function to fetch products from database
    function fetchProducts() {
        $.ajax({
            url: 'fetch_products.php',
            type: 'GET',
            success: function(response) {
                $('#product-list').html(response);
            }
        });
    }

    // Ajax form submission for adding a product
    $('#add-product-form').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'add_product.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                fetchProducts(); // Refresh product list after adding
                $('#add-product-form')[0].reset(); // Reset form fields
            }
        });
    });

    // Ajax request for deleting a product
    function deleteProduct(id) {
        $.ajax({
            url: 'delete_product.php',
            type: 'POST',
            data: { id: id },
            success: function(response) {
                fetchProducts(); // Refresh product list after deletion
            }
        });
    }
</script>

<?php include_once 'includes/footer.php'; ?>
