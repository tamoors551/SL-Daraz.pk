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
    <h1>View Products</h1>
    <!-- Your product listing here -->
</div>
<?php include_once 'includes/footer.php'; ?>
