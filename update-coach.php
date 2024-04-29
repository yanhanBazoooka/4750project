<?php
include('includes/header.php');
include('includes/connect-db.php');

$coach_data = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $coach_name = $_POST['CoachName'];
    $nationality = $_POST['Nationality'];

    $sql = "UPDATE Coach SET Nationality = ? WHERE CoachName = ?";
    $stmt = $db->prepare($sql);

    if ($stmt->execute([$nationality, $coach_name])) {
        echo "<p>Coach updated successfully.</p>";
        header("Location: stats.php");
        exit();
    } else {
        echo "<p>Error updating coach: " . $stmt->errorInfo()[2] . "</p>";
    }
}

// Retrieve current coach data for updating
if (!empty($_GET['coach_name'])) {
    $coach_name = $_GET['coach_name'];
    $sql = "SELECT * FROM Coach WHERE CoachName = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$coach_name]);
    $coach_data = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>

<form action="update-coach.php" method="post">
    <label for="CoachName">Coach Name:</label>
    <input type="text" id="CoachName" name="CoachName" value="<?php echo htmlspecialchars($coach_data['CoachName'] ?? ''); ?>" required>

    <label for="Nationality">Nationality:</label>
    <input type="text" id="Nationality" name="Nationality" value="<?php echo htmlspecialchars($coach_data['Nationality'] ?? ''); ?>" required>

    <input type="submit" value="Update Coach">
</form>

<?php include('footer.html'); ?>
