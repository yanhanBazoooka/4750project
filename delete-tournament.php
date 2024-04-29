<?php
include('includes/header.php');
include('includes/connect-db.php');
session_start();

$is_admin = ($_SESSION['user_role'] == '2'); // Assuming '2' is the admin role

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $is_admin) {
    $tournament_name = $_POST['TournamentName'];

    $sql = "DELETE FROM Tournament WHERE TournamentName = ?";
    $stmt = $db->prepare($sql);
    if ($stmt->execute([$tournament_name])) {
        echo "<p>Tournament deleted successfully!</p>";
        header("Location: stats.php");
        exit();
    } else {
        echo "<p>Error deleting tournament: " . $stmt->errorInfo()[2] . "</p>";
    }
}

if (!$is_admin) {
    echo "<p>You do not have permission to delete tournaments.</p>";
    exit();
}

?>

<form action="delete-tournament.php" method="post">
    <label for="TournamentName">Tournament Name:</label>
    <input type="text" id="TournamentName" name="TournamentName" required>

    <input type="submit" value="Delete Tournament">
</form>

<?php include('footer.html'); ?>
