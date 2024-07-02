<?php
session_start();

require_once 'includes/db.php';

if (isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

include_once 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin_users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['admin_id'] = $row['id'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid username or password";
    }
}

?>
<div class="login-container">
    <h1>Admin Login</h1>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <button type="submit">Login</button>
    </form>
</div>
<?php include_once 'includes/footer.php'; ?>
