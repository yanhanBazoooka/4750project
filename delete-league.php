<?php
include('includes/header.php');
include('includes/connect-db.php');
session_start();

$is_admin = ($_SESSION['user_role'] == '2'); // Assuming '2' is the admin role

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($is_admin) {
        $league_name = $_POST['LeagueName'];

        $sql = "DELETE FROM League WHERE LeagueName = ?";
        $stmt = $db->prepare($sql);
        if ($stmt->execute([$league_name])) {
            echo "<p>League deleted successfully!</p>";
            header("Location: stats.php");
            exit();
        } else {
            echo "<p>Error deleting league: " . $stmt->errorInfo()[2] . "</p>";
        }
    } else {
        echo "<p>You do not have permission to delete leagues.</p>";
    }
}

// Only show the form if the user is an admin
if ($is_admin):
?>

<form action="delete-league.php" method="post">
    <label for="LeagueName">League Name:</label>
    <input type="text" id="LeagueName" name="LeagueName" required>

    <input type="submit" value="Delete League">
</form>

<?php
endif;
include('footer.html'); 
?>
