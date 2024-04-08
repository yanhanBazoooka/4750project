<?php
include('includes/header.php');
include('includes/connect-db.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Prepare the SQL statement with placeholders for the values to prevent SQL injection
    $sql = "DELETE FROM Player WHERE Name = ?";
    # $sql = "INSERT INTO Player (Name, Position, MostUsedChampion, Age, Nationality, WinRate) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);

    // Bind the form values to the placeholders in the SQL statement
    $stmt->bindParam(1, $_POST['Name']);

    // Execute the statement and check for errors
    if($stmt->execute()){
        echo "<p>Player deleted successfully!</p>";
        // Redirect back to the stats.php
        header("Location: stats.php");
        exit();
    } else {
        echo "<p>Error deleting player: " . $stmt->errorInfo()[2] . "</p>";
    }

    $stmt = null;
    $db = null;
}

?>

<!-- Form for adding a new player -->
<form action="delete_data.php" method="post">
    <label for="Name">Name:</label>
    <input type="text" id="Name" name="Name" required>

    <input type="submit" value="Delete Player">
</form>

