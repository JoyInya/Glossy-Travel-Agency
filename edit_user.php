<?php
session_start();

// Protect the page to ensure only the admin can access it
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Include database connection
include 'db_config.php';

// Check if the user ID is provided in the URL
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Fetch the user's current data from the database
    $sql = "SELECT user_id, name, email FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->store_result();
    
    // Check if the user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $name, $email);
        $stmt->fetch();
    } else {
        echo "User not found.";
        exit();
    }
    
    $stmt->close();
}

// Handle form submission for editing user details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_name = $_POST['name'];
    $new_email = $_POST['email'];

    // Update user details in the database
    $update_sql = "UPDATE users SET name = ?, email = ? WHERE user_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssi", $new_name, $new_email, $user_id);

    if ($update_stmt->execute()) {
        echo "User updated successfully!";
        header("Location: manage_users.php");  // Redirect back to the manage users page
        exit();
    } else {
        echo "Error updating user: " . $conn->error;
    }

    $update_stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - Admin Dashboard</title>
    <link rel="stylesheet" href="manage_users.css">
</head>
<body>
    <div class="container">
        <h1>Edit User</h1>

        <!-- Form to edit user details -->
        <form action="edit_user.php?id=<?php echo $user_id; ?>" method="POST">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($name); ?>" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" required>

            <button type="submit">Update User</button>
        </form>

        <a href="manage_users.php">Back to Manage Users</a>
    </div>
</body>
</html>
