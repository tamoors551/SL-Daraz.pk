<?php
include "config.php";
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
  header("Location: login.php"); // Redirect to login page if not logged in
  exit;
}

// Display username
$username = $_SESSION['username'];
// Fetch cart items
$cart_items = [];
$total_price = 0;

$select_query = "SELECT * FROM cart";
$result = mysqli_query($conn, $select_query);
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $cart_items[] = $row;
    $total_price += $row['product_price'] * $row['quantity'];
  }
}

// Handle update cart logic
if (isset($_POST['update_cart'])) {
  foreach ($_POST['product_id'] as $key => $value) {
    $product_id = $_POST['product_id'][$key];
    $product_quantity = $_POST['product_quantity'][$key];
    
    // Update cart with new quantity
    $update_query = "UPDATE cart SET quantity = $product_quantity WHERE product_id = '$product_id'";
    mysqli_query($conn, $update_query);
  }
  // Redirect to avoid form resubmission
  header("Location: cart.php");
  exit;
}

// Handle remove from cart logic
if (isset($_POST['remove_from_cart'])) {
  $product_id = $_POST['product_id'];
  $delete_query = "DELETE FROM cart WHERE product_id = '$product_id'";
  mysqli_query($conn, $delete_query);
  // Redirect to avoid form resubmission
  header("Location: cart.php");
  exit;
}

?>











<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Simple E-commerce Website - Daraz Style</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet"> -->


  <!-- Custom CSS -->
  <style>
    .navbar {
      background-color: #f85606;
    }

    .navbar-brand img {
      max-height: 50px;
      margin-right: 15px;
    }

    .navbar .form-control {
      border-radius: 20px;
    }

    .product {
      border: 1px solid #f0f0f0;
      margin-bottom: 30px;
      transition: transform 0.3s ease-in-out;
    }

    .product:hover {
      transform: scale(1.05);
    }

    .product img {
      max-width: 100%;
      height: auto;
    }

    .product-info {
      padding: 15px;
    }

    .cart {
      background-color: #f8f9fa;
      padding: 15px;
      margin-top: 15px;
    }

    .category-section {
      background-color: #f0f0f0;
      padding: 15px;
      min-height: 200px;
      /* Example height, adjust as needed */
      border-radius: 14px;
    }

    .category-slider img {
      max-width: 100%;
      height: auto;
    }

    /* Category Cards Custom Styling */
    .category-cards .card {
      border: none;
      transition: transform 0.3s ease-in-out;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      max-width: 200px;
      height: 200px;
      /* Adding shadow for depth */
    }

    .category-cards .card:hover {
      transform: translateY(-5px);
      /* Lift card on hover */
    }

    .category-cards .card img {
      max-width: 100px;
      height: 100px;
    }

    .category-cards .card-title {
      text-align: center;
      margin-top: 10px;
    }

    /* Footer */
    footer {
      background-color: #f0f0f0;
      padding: 20px 0;
      color: #333;
      text-align: center;
      font-size: 14px;
      margin-top: 30px;
    }

    footer a {
      color: #333;
      text-decoration: none;
      margin: 0 10px;
    }

    footer a:hover {
      text-decoration: underline;
    }

    .carousel-item img {
      border-radius: 14px;
    }
  </style>
</head>

<body class="container-fluid">

  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img src="./draz-img/e650d6ca-1841-4646-b0e9-4ddbf2beb731.png" alt="Daraz Logo">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <form class="d-flex mx-auto my-2 my-lg-0">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-light" type="submit">Search</button>
        </form>
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a href="index.php" class="btn btn-danger">Home</a>
          </li>
          <li class="nav-item">
            <a href="logout.php" class="btn btn-danger">Logout</a>
          </li>
          <li>
            <a href="cart.php" class="btn btn-danger">Cart</a>
          </li>
          <li>
            <a href="wishlist.php" class="btn btn-danger">Wishlist</a>
          </li>
          <li class="nav-item">
            <h5 class=""><?php echo htmlspecialchars($username); ?></h5>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <br>
  
  <br>
  <hr><br>
  <!-- Category Section and Slider -->
  <div class="row">
    <div class="col-md-3">
      <div class="category-section">
        <h3>Categories</h3>
        <ul>
          <li><a href="#">Electronics</a></li>
          <li><a href="#">Fashion</a></li>
          <li><a href="#">Home & Living</a></li>
          <li><a href="#">Beauty & Health</a></li>
          <li><a href="#">Sports</a></li>
          <li><a href="#">Books</a></li>
          <li><a href="#">Toys & Games</a></li>
          <li><a href="#">Grocery & Pets</a></li>
          <li><a href="#">Food & Beverages</a></li>
          <li><a href="#">Home Appliances</a></li>
          <li><a href="#">Automobiles</a></li>
          <li><a href="#">Travel</a></li>
          <li><a href="#">Others</a></li>
          <li><a href="#">Home Appliances</a></li>
          <li><a href="#">Automobiles</a></li>
          <li><a href="#">Travel</a></li>
          <li><a href="#">Others</a></li>
          <li><a href="#">Home Appliances</a></li>
          <li><a href="#">Automobiles</a></li>
          <li><a href="#">Automobiles</a></li>
          
        </ul>
      </div>
    </div>
    <div class="col-md-9">
      <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="./Crusel-img/Best-Size-For-ecommerce-Product-Images1-ezgif.com-webp-to-jpg-converter.jpg" class="d-block w-100" alt="Category 1">
          </div>
          <div class="carousel-item">
            <img src="./Crusel-img/Best-Size-For-ecommerce-Product-Images1-ezgif.com-webp-to-jpg-converter.jpg" class="d-block w-100" alt="Category 2">
          </div>
          <div class="carousel-item">
            <img src="./Crusel-img/Best-Size-For-ecommerce-Product-Images1-ezgif.com-webp-to-jpg-converter.jpg" class="d-block w-100" alt="Category 3">
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>
  </div>
<hr>
  <h1 class="my-4">Simple E-commerce Website - Daraz Style</h1>

  <!-- Category Cards -->
  <div class="row category-cards">
    <div class="col-md-2">
      <div class="card mb-4 shadow-sm">
        <a href="//www.daraz.pk/bedroom-clothes-storage/?up_id=167">
          <img src="https://static-01.daraz.pk/p/ad5e207f1b4f3d066014478fe365833d.jpg" class="card-img-top" alt="Wardrobe Organisers">
          <div class="card-body">
            <h5 class="card-title">Wardrobe Organisers</h5>
          </div>
        </a>
      </div>
    </div>
    <div class="col-md-2">
      <div class="card mb-4 shadow-sm">
        <a href="//www.daraz.pk/audio-studio-headphones-48/?up_id=168">
          <img src="https://pk-live-21.slatic.net/kf/S586c966206d947c187275a42f6415872d.jpg" class="card-img-top" alt="Studio Headphones">
          <div class="card-body">
            <h5 class="card-title">Studio Headphones</h5>
          </div>
        </a>
      </div>
    </div>
    <div class="col-md-2">
      <div class="card mb-4 shadow-sm">
        <a href="//www.daraz.pk/wall-art/?up_id=169">
          <img src="https://static-01.daraz.pk/p/5bc60c12775eaf82de99f4692d4efa06.jpg" class="card-img-top" alt="Wall Decor">
          <div class="card-body">
            <h5 class="card-title">Wall Decor</h5>
          </div>
        </a>
      </div>
    </div>
    <div class="col-md-2">
      <div class="card mb-4 shadow-sm">
        <a href="//www.daraz.pk/hair-shampoo/?up_id=170">
          <img src="https://static-01.daraz.pk/p/850c6ba341c89c24a7f4df27b2dc4991.jpg" class="card-img-top" alt="Shampoo">
          <div class="card-body">
            <h5 class="card-title">Shampoo</h5>
          </div>
        </a>
      </div>
    </div>
    <div class="col-md-2">
      <div class="card mb-4 shadow-sm">
        <a href="//www.daraz.pk/hair-shampoo/?up_id=170">
          <img src="https://static-01.daraz.pk/p/850c6ba341c89c24a7f4df27b2dc4991.jpg" class="card-img-top" alt="Shampoo">
          <div class="card-body">
            <h5 class="card-title">Shampoo</h5>
          </div>
        </a>
      </div>
    </div>
    <div class="col-md-2">
      <div class="card mb-4 shadow-sm">
        <a href="//www.daraz.pk/hair-shampoo/?up_id=170">
          <img src="https://static-01.daraz.pk/p/850c6ba341c89c24a7f4df27b2dc4991.jpg" class="card-img-top" alt="Shampoo">
          <div class="card-body">
            <h5 class="card-title">Shampoo</h5>
          </div>
        </a>
      </div>
    </div>
    <div class="col-md-2">
      <div class="card mb-4 shadow-sm">
        <a href="//www.daraz.pk/bedroom-clothes-storage/?up_id=167">
          <img src="https://static-01.daraz.pk/p/ad5e207f1b4f3d066014478fe365833d.jpg" class="card-img-top" alt="Wardrobe Organisers">
          <div class="card-body">
            <h5 class="card-title">Wardrobe Organisers</h5>
          </div>
        </a>
      </div>
    </div>
    <div class="col-md-2">
      <div class="card mb-4 shadow-sm">
        <a href="//www.daraz.pk/audio-studio-headphones-48/?up_id=168">
          <img src="https://pk-live-21.slatic.net/kf/S586c966206d947c187275a42f6415872d.jpg" class="card-img-top" alt="Studio Headphones">
          <div class="card-body">
            <h5 class="card-title">Studio Headphones</h5>
          </div>
        </a>
      </div>
    </div>
    <div class="col-md-2">
      <div class="card mb-4 shadow-sm">
        <a href="//www.daraz.pk/wall-art/?up_id=169">
          <img src="https://static-01.daraz.pk/p/5bc60c12775eaf82de99f4692d4efa06.jpg" class="card-img-top" alt="Wall Decor">
          <div class="card-body">
            <h5 class="card-title">Wall Decor</h5>
          </div>
        </a>
      </div>
    </div>
    <div class="col-md-2">
      <div class="card mb-4 shadow-sm">
        <a href="//www.daraz.pk/hair-shampoo/?up_id=170">
          <img src="https://static-01.daraz.pk/p/850c6ba341c89c24a7f4df27b2dc4991.jpg" class="card-img-top" alt="Shampoo">
          <div class="card-body">
            <h5 class="card-title">Shampoo</h5>
          </div>
        </a>
      </div>
    </div>
    <div class="col-md-2">
      <div class="card mb-4 shadow-sm">
        <a href="//www.daraz.pk/hair-shampoo/?up_id=170">
          <img src="https://static-01.daraz.pk/p/850c6ba341c89c24a7f4df27b2dc4991.jpg" class="card-img-top" alt="Shampoo">
          <div class="card-body">
            <h5 class="card-title">Shampoo</h5>
          </div>
        </a>
      </div>
    </div>
    <div class="col-md-2">
      <div class="card mb-4 shadow-sm">
        <a href="//www.daraz.pk/hair-shampoo/?up_id=170">
          <img src="https://static-01.daraz.pk/p/850c6ba341c89c24a7f4df27b2dc4991.jpg" class="card-img-top" alt="Shampoo">
          <div class="card-body">
            <h5 class="card-title">Shampoo</h5>
          </div>
        </a>
      </div>
    </div>
  </div>

  <!-- Products -->
  <div class="row row-cols-1 row-cols-md-6 g-4">
    <div class="col-3">
      <div class="product">
        <img src="./draz-img/6ca8f02f56d48f0daf38063da995e763.png" class="card-img-top" alt="Product 1">
        <div class="product-info">
          <h5 class="card-title">Product 1</h5>
          <p class="card-text">Description of Product 1. Price: $10</p>
          <button class="btn btn-primary add-to-cart" data-name="Product 1" data-price="10">Add to Cart</button>
        </div>
      </div>
    </div>
    <div class="col-3">
      <div class="product">
        <img src="./draz-img/6ca8f02f56d48f0daf38063da995e763.png" class="card-img-top" alt="Product 2">
        <div class="product-info">
          <h5 class="card-title">Product 2</h5>
          <p class="card-text">Description of Product 2. Price: $20</p>
          <button class="btn btn-primary add-to-cart" data-name="Product 2" data-price="20">Add to Cart</button>
        </div>
      </div>
    </div>
    <div class="col-3">
      <div class="product">
        <img src="./draz-img/grocery-items-png-free-png-images-download-50769.png" class="card-img-top" alt="Product 3">
        <div class="product-info">
          <h5 class="card-title">Product 3</h5>
          <p class="card-text">Description of Product 3. Price: $30</p>
          <button class="btn btn-primary add-to-cart" data-name="Product 3" data-price="30">Add to Cart</button>
        </div>
      </div>
    </div>

    <div class="col-3">
      <div class="product">
        <img src="./draz-img/grocery-items-png-free-png-images-download-50769.png" class="card-img-top" alt="Product 3">
        <div class="product-info">
          <h5 class="card-title">Product 3</h5>
          <p class="card-text">Description of Product 3. Price: $30</p>
          <button class="btn btn-primary add-to-cart" data-name="Product 3" data-price="30">Add to Cart</button>
        </div>
      </div>
    </div>


    <div class="col">
      <div class="product">
        <img src="./draz-img/grocery-items-png-free-png-images-download-50769.png" class="card-img-top" alt="Product 3">
        <div class="product-info">
          <h5 class="card-title">Product 3</h5>
          <p class="card-text">Description of Product 3. Price: $30</p>
          <button class="btn btn-primary add-to-cart" data-name="Product 3" data-price="30">Add to Cart</button>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="product">
        <img src="./draz-img/grocery-items-png-free-png-images-download-50769.png" class="card-img-top" alt="Product 3">
        <div class="product-info">
          <h5 class="card-title">Product 3</h5>
          <p class="card-text">Description of Product 3. Price: $30</p>
          <button class="btn btn-primary add-to-cart" data-name="Product 3" data-price="30">Add to Cart</button>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="product">
        <img src="./draz-img/grocery-items-png-free-png-images-download-50769.png" class="card-img-top" alt="Product 3">
        <div class="product-info">
          <h5 class="card-title">Product 3</h5>
          <p class="card-text">Description of Product 3. Price: $30</p>
          <button class="btn btn-primary add-to-cart" data-name="Product 3" data-price="30">Add to Cart</button>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="product">
        <img src="./draz-img/grocery-items-png-free-png-images-download-50769.png" class="card-img-top" alt="Product 3">
        <div class="product-info">
          <h5 class="card-title">Product 3</h5>
          <p class="card-text">Description of Product 3. Price: $30</p>
          <button class="btn btn-primary add-to-cart" data-name="Product 3" data-price="30">Add to Cart</button>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="product">
        <img src="./draz-img/grocery-items-png-free-png-images-download-50769.png" class="card-img-top" alt="Product 3">
        <div class="product-info">
          <h5 class="card-title">Product 3</h5>
          <p class="card-text">Description of Product 3. Price: $30</p>
          <button class="btn btn-primary add-to-cart" data-name="Product 3" data-price="30">Add to Cart</button>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="product">
        <img src="./draz-img/grocery-items-png-free-png-images-download-50769.png" class="card-img-top" alt="Product 3">
        <div class="product-info">
          <h5 class="card-title">Product 3</h5>
          <p class="card-text">Description of Product 3. Price: $30</p>
          <button class="btn btn-primary add-to-cart" data-name="Product 3" data-price="30">Add to Cart</button>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="product">
        <img src="./draz-img/grocery-items-png-free-png-images-download-50769.png" class="card-img-top" alt="Product 3">
        <div class="product-info">
          <h5 class="card-title">Product 3</h5>
          <p class="card-text">Description of Product 3. Price: $30</p>
          <button class="btn btn-primary add-to-cart" data-name="Product 3" data-price="30">Add to Cart</button>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="product">
        <img src="./draz-img/grocery-items-png-free-png-images-download-50769.png" class="card-img-top" alt="Product 3">
        <div class="product-info">
          <h5 class="card-title">Product 3</h5>
          <p class="card-text">Description of Product 3. Price: $30</p>
          <button class="btn btn-primary add-to-cart" data-name="Product 3" data-price="30">Add to Cart</button>
        </div>
      </div>
    </div>
    <!-- Add more product columns as needed -->
  </div>




  

  <!-- Footer -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <h5>ABOUT</h5>
          <ul class="list-unstyled text-small">
            <li><a href="#">About Us</a></li>
            <li><a href="#">Contact Us</a></li>
            <li><a href="#">Careers</a></li>
            <li><a href="#">Terms & Conditions</a></li>
            <li><a href="#">Privacy Policy</a></li>
          </ul>
        </div>
        <div class="col-md-3">
          <h5>HELP</h5>
          <ul class="list-unstyled text-small">
            <li><a href="#">Payments</a></li>
            <li><a href="#">Shipping</a></li>
            <li><a href="#">Cancellation & Returns</a></li>
            <li><a href="#">FAQ</a></li>
          </ul>
        </div>
        <div class="col-md-3">
          <h5>MY ACCOUNT</h5>
          <ul class="list-unstyled text-small">
            <li><a href="#">Sign In</a></li>
            <li><a href="#">View Cart</a></li>
            <li><a href="#">My Wishlist</a></li>
            <li><a href="#">Track My Order</a></li>
          </ul>
        </div>
        <div class="col-md-3">
          <h5>FOLLOW US</h5>
          <ul class="list-unstyled text-small">
            <li><a href="#">Facebook</a></li>
            <li><a href="#">Instagram</a></li>
            <li><a href="#">Twitter</a></li>
            <li><a href="#">YouTube</a></li>
          </ul>
        </div>
      </div>
      <p>&copy; 2024 Simple E-commerce Website - Daraz Style</p>12
    </div>
  </footer>



  <!-- jQuery and Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
</body>

</html>