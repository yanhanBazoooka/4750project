<?php
session_start();

// Database connection
$db = new PDO('mysql:host=localhost;dbname=your_database_name', 'username', 'password');

// Check if the user is an admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 1) {
    die('Access Denied: You do not have permission to access this page.');
}

// Handle the role update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['user_id'];
    $roleId = $_POST['role_id'];  // Admin role ID should be handled with care

    $stmt = $db->prepare("UPDATE users SET role_id = ? WHERE id = ?");
    if ($stmt->execute([$roleId, $userId])) {
        echo "<p>User role updated successfully.</p>";
    } else {
        echo "<p>Error updating user role.</p>";
    }
}

// Fetch all users and roles for the form
$users = $db->query("SELECT id, email FROM users");
$roles = $db->query("SELECT id, name FROM roles");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Manage Roles</title>
</head>
<body>
<h1>Admin - Manage User Roles</h1>
<form method="post">
    User:
    <select name="user_id">
        <?php while ($user = $users->fetch(PDO::FETCH_ASSOC)) { ?>
            <option value="<?php echo $user['id']; ?>"><?php echo $user['email']; ?></option>
        <?php } ?>
    </select>
    <br>
    Role:
    <select name="role_id">
        <?php while ($role = $roles->fetch(PDO::FETCH_ASSOC)) { ?>
            <option value="<?php echo $role['id']; ?>"><?php echo $role['name']; ?></option>
        <?php } ?>
    </select>
    <br>
    <input type="submit" value="Update Role">
</form>
</body>
</html>
