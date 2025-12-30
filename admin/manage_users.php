<?php
include '../db_connect.php';
session_start();

// Add User
if (isset($_POST['add_user'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
    mysqli_query($conn, $query);
    header("Location: manage_users.php");
}

// Delete User
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM users WHERE id=$delete_id");
    header("Location: manage_users.php");
}

// Edit User
$edit_mode = false;
$edit_user = [];
if (isset($_GET['edit'])) {
    $edit_mode = true;
    $edit_id = $_GET['edit'];
    $edit_query = mysqli_query($conn, "SELECT * FROM users WHERE id=$edit_id");
    $edit_user = mysqli_fetch_assoc($edit_query);
}

// Update User
if (isset($_POST['update_user'])) {
    $id = $_POST['user_id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $query = "UPDATE users SET name='$name', email='$email' WHERE id=$id";
    mysqli_query($conn, $query);
    header("Location: manage_users.php");
}

$result = mysqli_query($conn, "SELECT id, name, email, created_at FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users | SuNNNyTech Admin</title>
    <link rel="stylesheet" type="text/css" href="/SuNNNyTech/admin/css/admin-style.css">
    <link rel="icon" type="image/png" href="/SuNNNyTech/images/header/STicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
</head>
<body>
<div style="height: 200px;"></div>
    <div class="admin-container">
        <div class="main-content">
            <h2>Manage Users</h2>
            <div class="line1"></div>
            <!-- Add or Edit Form -->
            <div class="admin-card">
                <h3><?= $edit_mode ? 'Edit User' : 'Add User' ?></h3>
                <form method="POST">
                    <input type="hidden" name="user_id" value="<?= $edit_user['id'] ?? '' ?>">
                    <input type="text" name="name" placeholder="Name" value="<?= $edit_user['name'] ?? '' ?>" required>
                    <input type="email" name="email" placeholder="Email" value="<?= $edit_user['email'] ?? '' ?>" required>
                    <?php if (!$edit_mode): ?>
                        <input type="password" name="password" placeholder="Password" required>
                        <button type="submit" name="add_user">Add User</button>
                    <?php else: ?>
                        <button type="submit" name="update_user">Update User</button>
                    <?php endif; ?>
                </form>
            </div>

            <!-- Users Table -->
            <div class="admin-card">
                <table>
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Registered On</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= $row['created_at'] ?></td>
                            <td>
                                <a class="btn edit" href="manage_users.php?edit=<?= $row['id'] ?>">Edit</a>
                                <a class="btn delete" href="manage_users.php?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure to delete this user?')">Delete</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>