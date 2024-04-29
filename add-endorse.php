<?php
include('includes/header.php');
include('includes/connect-db.php');

// Check if POST request and data are valid
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sponsor_name = $_POST['SponsorName'];
    $team_name = $_POST['TeamName'];
    $price = $_POST['Price'];

    // Validate existence of Sponsor and Team in the database
    $validation_sql = "SELECT EXISTS(SELECT 1 FROM Sponsor WHERE SponsorName = ?) AS SponsorExists, 
                              EXISTS(SELECT 1 FROM Team WHERE TeamName = ?) AS TeamExists";

    $validation_stmt = $db->prepare($validation_sql);
    $validation_stmt->execute([$sponsor_name, $team_name]);
    $exists = $validation_stmt->fetch(PDO::FETCH_ASSOC);

    if ($exists['SponsorExists'] && $exists['TeamExists']) {
        // Both Sponsor and Team exist, insert new endorsement
        $sql = "INSERT INTO Endorse (SponsorName, TeamName, Price) VALUES (?, ?, ?)";
        $stmt = $db->prepare($sql);
        if ($stmt->execute([$sponsor_name, $team_name, $price])) {
            echo "<p>New endorsement added successfully!</p>";
            header("Location: stats.php"); // Redirect after successful addition
            exit();
        } else {
            echo "<p>Error adding endorsement: " . $stmt->errorInfo()[2] . "</p>";
        }
    } else {
        // Error if Sponsor or Team does not exist
        if (!$exists['SponsorExists']) {
            echo "<p>Error: Sponsor does not exist.</p>";
        }
        if (!$exists['TeamExists']) {
            echo "<p>Error: Team does not exist.</p>";
        }
    }
}
?>

<form action="add-endorse.php" method="post">
    <label for="SponsorName">Sponsor Name:</label>
    <input type="text" id="SponsorName" name="SponsorName" required>

    <label for="TeamName">Team Name:</label>
    <input type="text" id="TeamName" name="TeamName" required>

    <label for="Price">Price:</label>
    <input type="number" id="Price" name="Price" step="0.01" required>

    <input type="submit" value="Add Endorsement">
</form>

<?php include('footer.html'); ?>
