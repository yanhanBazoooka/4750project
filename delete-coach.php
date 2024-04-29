<?php
include('includes/header.php');
include('includes/connect-db.php');

// Assume $is_admin is determined by the session as before

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $is_admin) {
    $coach_name = $_POST['CoachName'];

    $sql = "DELETE FROM Coach WHERE CoachName = ?";
    $stmt = $db->prepare($sql);
    if ($stmt->execute([$coach_name])) {
        echo "<p>Coach deleted successfully!</p>";
        header("Location: stats.php");
        exit();
    } else {
        echo "<p>Error deleting coach: " . $stmt->errorInfo()[2] . "</p>";
    }
}

if (!$is_admin) {
    echo "<p>You do not have permission to delete coaches.</p>";
    exit();
}

?>

<form action="delete-coach.php" method="post">
    <label for="CoachName">Coach Name:</label>
    <input type="text" id="CoachName" name="CoachName" required>

    <input type="submit" value="Delete Coach">
</form>

<?php include('footer.html'); ?>
