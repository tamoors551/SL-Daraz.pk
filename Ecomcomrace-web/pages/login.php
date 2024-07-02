<?php
session_start();
include '../includes/db.php'; // Include your database connection file
include '../includes/header.php'; // Include the header file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate input data
    if (!empty($email) && !empty($password)) {
        // Prepare the SQL statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $username, $hashed_password);

        if ($stmt->num_rows > 0) {
            $stmt->fetch();
            if (password_verify($password, $hashed_password)) {
                // Successful login
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;
                header('Location: index.php');
                exit();
            } else {
                // Incorrect password
                $_SESSION['login_error'] = 'Invalid email or password.';
            }
        } else {
            // Email not found
            $_SESSION['login_error'] = 'Invalid email or password.';
        }

        $stmt->close();
    } else {
        // Input data is invalid
        $_SESSION['login_error'] = 'Please fill in all fields.';
    }
}
?>

<div class="container">
  <h2>Login</h2>
  <?php
  // Display any error messages from previous login attempts
  if (isset($_SESSION['login_error'])) {
      echo '<div class="alert alert-danger">' . $_SESSION['login_error'] . '</div>';
      unset($_SESSION['login_error']);
  }
  ?>
  <form action="login.php" method="post">
    <div class="mb-3">
    huda@gmail.com
      <label for="email" class="form-label">Email address</label>
      <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="mb-3">
      huda
      <label for="password" class="form-label">Password</label>
      <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
    <a href="signup.php" class="btn btn-secondary">Sign Up</a>
    <a href="forgot_password.php" class="btn btn-secondary">Forgot Password</a>
    <a href="reset_password.php" class="btn btn-secondary">Reset Password</a>
   

    <a href="../Admin-dashbord/admin/index.php" class="btn btn-secondary">admin</a>
  </form>
</div>

<?php
include '../includes/footer.php'; // Include the footer file
?>
