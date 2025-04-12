<?php
session_start();
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Special admin password (you can change this)
    $admin_password = 'GlossyTravelAgency@987';

    // Check if user exists
    $stmt = $conn->prepare("SELECT user_id, name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $name, $hashed_password);
        $stmt->fetch();

        // First, check if the password is the special admin password
        if ($password === $admin_password) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user'] = $name;
            $_SESSION['role'] = 'admin';
            header("Location: admin_dashboard.php");
            exit();
        }

        // Otherwise, normal user login check
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user'] = $name;
            $_SESSION['role'] = 'user';
            header("Location: Home.php");
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No account found. Please sign up.";
    }

    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Travel Itinerary</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
<div class="container">
    <h2>Login</h2>
    <form action="login.php" method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
</div>
</body>
</html>
