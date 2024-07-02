<?php
include '../includes/header.php'; // Assuming header.php is located in ../includes/

// Ensure to start the session if you haven't already
session_start();
?>

<div class="container">
  <h2>Sign Up</h2>
  <?php
  // Display any error messages from previous signup attempts
  if (isset($_SESSION['signup_error'])) {
      echo '<div class="alert alert-danger">' . $_SESSION['signup_error'] . '</div>';
      unset($_SESSION['signup_error']);
  }
  ?>
  <form action="signup_action.php" method="post">
    <div class="mb-3">
      <label for="name" class="form-label">Full Name</label>
      <input type="text" class="form-control" id="name" name="username" required>
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Email address</label>
      <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <button type="submit" class="btn btn-primary">Sign Up</button>
  </form>
</div>

<?php
include '../includes/footer.php'; // Assuming footer.php is located in ../includes/
?>
