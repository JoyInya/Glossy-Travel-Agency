<?php
session_start();
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $plain_password = $_POST['password'];
    $password = password_hash($plain_password, PASSWORD_DEFAULT);   

    // Unique admin password
    $admin_special_password = 'GlossyTravelAgency@987'; // Replace this with your secret admin pass

    // Determine the role
    $role = ($plain_password === $admin_special_password) ? 'admin' : 'user';

    // Check if the user already exists
    $checkUser = $conn->prepare("SELECT user_id FROM users WHERE name = ? OR email = ?");
    $checkUser->bind_param("ss", $name, $email);
    $checkUser->execute();
    $checkUser->store_result();

    if ($checkUser->num_rows > 0) {
        echo "User already exists. Try logging in.";
    } else {
        // Insert new user into the database with the role
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $password, $role);

        if ($stmt->execute()) {
            $user_id = $stmt->insert_id;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user'] = $name;
            $_SESSION['role'] = $role;

            // Redirect based on role
            if ($role === 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: Home.php");
            }
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
    $checkUser->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - Travel Itinerary</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body>
<div class="container">
    <h2>Sign Up</h2>
    <form action="signup.php" method="POST">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Sign Up</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</div>
</body>
</html>
