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

    // Fetch the user's data from the database
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

    // Check if delete is confirmed
    if (isset($_POST['confirm_delete'])) {
        // Delete user from the database
        $delete_sql = "DELETE FROM users WHERE user_id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $user_id);

        if ($delete_stmt->execute()) {
            echo "User deleted successfully!";
            header("Location: manage_users.php"); // Redirect to the manage users page
            exit();
        } else {
            echo "Error deleting user: " . $conn->error;
        }

        $delete_stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User - Admin Dashboard</title>
    <link rel="stylesheet" href="manage_users.css">
</head>
<body>
    <div class="container">
        <h1>Delete User</h1>

        <p>Are you sure you want to delete the user <strong><?php echo htmlspecialchars($name); ?></strong>?</p>

        <!-- Form to confirm deletion -->
        <form action="delete_user.php?id=<?php echo $user_id; ?>" method="POST">
            <button type="submit" name="confirm_delete">Yes, Delete User</button>
            <a href="manage_users.php">Cancel</a>
        </form>
    </div>
</body>
</html>
