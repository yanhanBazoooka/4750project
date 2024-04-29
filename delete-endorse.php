<?php
include('includes/header.php');
include('includes/connect-db.php');
session_start();

$is_admin = ($_SESSION['user_role'] == '2'); // Assuming '2' is the admin role

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $is_admin) {
    $sponsor_name = $_POST['SponsorName'];
    $team_name = $_POST['TeamName'];

    $sql = "DELETE FROM Endorse WHERE SponsorName = ? AND TeamName = ?";
    $stmt = $db->prepare($sql);
    if ($stmt->execute([$sponsor_name, $team_name])) {
        echo "<p>Endorsement deleted successfully!</p>";
        header("Location: stats.php");
        exit();
    } else {
        echo "<p>Error deleting endorsement: " . $stmt->errorInfo()[2] . "</p>";
    }
}

if (!$is_admin) {
    echo "<p>You do not have permission to delete endorsements.</p>";
    exit();
}

?>

<form action="delete-endorse.php" method="post">
    <label for="SponsorName">Sponsor Name:</label>
    <input type="text" id="SponsorName" name="SponsorName" required>

    <label for="TeamName">Team Name:</label>
    <input type="text" id="TeamName" name="TeamName" required>

    <input type="submit" value="Delete Endorsement">
</form>

<?php include('footer.html'); ?>
