<?php
session_start(); // Start the session

include '../includes/db.php';
include '../includes/header.php';
include '../includes/functions.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  // If not logged in, redirect to login page
  header('Location: login.php');
  exit();
}
?>

  <!-- Category Section and Slider -->
  <?php
  include 'category-section-and-slider.php';
  ?>
  <hr>
  <!-- Category Cards -->
  <?php
  include 'categories.php';
  ?>
  <hr>
  <!-- Products -->
  <?php
  include 'products.php';
  ?>





<!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/script.js"></script>
<script src="../assets/js/scripts.js"></script>

<script>
  $(document).ready(function() {
    // Add to Cart Button Click Event
    $(".add-to-cart").click(function() {
      var name = $(this).data("name");
      var price = Number($(this).data("price"));
  
      // Append item to cart
      $("#cart-items").append("<li>" + name + " - $" + price + "</li>");
  
      // Update cart total
      var currentTotal = Number($("#cart-total").text());
      $("#cart-total").text(currentTotal + price);
    });
  });





</script>

<?php
include '../includes/footer.php';
?>