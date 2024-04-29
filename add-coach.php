<?php
include('includes/header.php');
include('includes/connect-db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $coach_name = $_POST['CoachName'];
    $nationality = $_POST['Nationality'];

    $sql = "INSERT INTO Coach (CoachName, Nationality) VALUES (?, ?)";
    $stmt = $db->prepare($sql);
    if ($stmt->execute([$coach_name, $nationality])) {
        echo "<p>New coach added successfully!</p>";
        header("Location: stats.php");
        exit();
    } else {
        echo "<p>Error adding coach: " . $stmt->errorInfo()[2] . "</p>";
    }
}
?>

<form action="add-coach.php" method="post">
    <label for="CoachName">Coach Name:</label>
    <input type="text" id="CoachName" name="CoachName" required>

    <label for="Nationality">Nationality:</label>
    <input type="text" id="Nationality" name="Nationality" required>

    <input type="submit" value="Add Coach">
</form>

<?php include('footer.html'); ?>
