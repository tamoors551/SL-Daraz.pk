<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['username'])) {
    header("Location: index.php"); // Redirect to homepage or dashboard if logged in
    exit;
}

// Include database connection
require_once "config.php";

// Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password

    // Prepare statement to check if username already exists
    $stmt_check = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt_check->bind_param("s", $username);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        $error = "Username already exists. Please choose a different username.";
    } else {
        // Prepare SQL statement to insert new user into database
        $stmt_insert = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt_insert->bind_param("ss", $username, $password);

        // Execute the statement
        if ($stmt_insert->execute()) {
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $stmt_insert->insert_id; // Get the ID of the inserted user
            header("Location: index.php"); // Redirect to homepage or dashboard
            exit;
        } else {
            $error = "Signup failed. Please try again later.";
        }

        $stmt_insert->close();
    }

    $stmt_check->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
</head>
<body>
    <h2>Sign Up</h2>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Sign Up">
    </form>
</body>
</html>
