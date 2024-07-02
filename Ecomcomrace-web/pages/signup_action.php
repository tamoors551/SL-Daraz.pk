<?php
session_start();
include '../includes/db.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password

    // Perform any necessary validations on input data

    // Example query to insert user into database
    $query = "INSERT INTO users (username, email, password) VALUES ('$name', '$email', '$password')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Successfully signed up
        $_SESSION['signup_success'] = 'You have successfully signed up!';
        header('Location: /Daraz.pk/Ecomcomrace-web/pages/home.php');
        exit();
    } else {
        // Error in signing up
        $_SESSION['signup_error'] = 'Failed to sign up. Please try again.';
        header('Location: signup.php');
        exit();
    }
} else {
    // Redirect back if accessed without POST method
    header('Location: signup.php');
    exit();
}
?>
