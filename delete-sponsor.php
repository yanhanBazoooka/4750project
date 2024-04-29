<?php
include('includes/header.php');
include('includes/connect-db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $is_admin) {
    $sponsor_name = $_POST['SponsorName'];

    $sql = "DELETE FROM Sponsor WHERE SponsorName = ?";
    $stmt = $db->prepare($sql);
    if ($stmt->execute([$sponsor_name])) {
        echo "<p>Sponsor deleted successfully!</p>";
        header("Location: stats.php");
        exit();
    } else {
        echo "<p>Error deleting sponsor: " . $stmt->errorInfo()[2] . "</p>";
    }
}

if (!$is_admin) {
    echo "<p>You do not have permission to delete sponsors.</p>";
    exit();
}

?>

<form action="delete-sponsor.php" method="post">
    <label for="SponsorName">Sponsor Name:</label>
    <input type="text" id="SponsorName" name="SponsorName" required>

    <input type="submit" value="Delete Sponsor">
</form>

<?php include('footer.html'); ?>
