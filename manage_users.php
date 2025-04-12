<?php
session_start();

// Protect the page to ensure only the admin can access it
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Include database connection
include 'db_config.php';

// Fetch all users except admins
$sql = "SELECT user_id, name, email FROM users WHERE role != 'admin'";  // Assuming 'role' is the field to identify admins
$result = $conn->query($sql);

if (!$result) {
    echo "Error fetching users: " . $conn->error;
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin Dashboard</title>
    <link rel="stylesheet" href="manage_users.css">
</head>
<body>
    <div class="container">
        <h1>Manage Users</h1>

        <!-- Table to display users -->
        <table class="user-table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td>
                            <a href="edit_user.php?id=<?php echo $user['user_id']; ?>">Edit</a> |
                            <a href="delete_user.php?id=<?php echo $user['user_id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <a href="admin_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
