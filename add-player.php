<?php
include('header.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('connect-db.php');

    // Prepare the SQL statement with placeholders for the values to prevent SQL injection
    $sql = "INSERT INTO Player (Name, Position, MostUsedChampion, Age, Nationality, WinRate) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);

    // Bind the form values to the placeholders in the SQL statement
    $stmt->bindParam(1, $_POST['Name']);
    $stmt->bindParam(2, $_POST['Position']);
    $stmt->bindParam(3, $_POST['MostUsedChampion']);
    $stmt->bindParam(4, $_POST['Age']);
    $stmt->bindParam(5, $_POST['Nationality']);
    $stmt->bindParam(6, $_POST['WinRate']);

    // Execute the statement and check for errors
    if($stmt->execute()){
        echo "<p>New player added successfully!</p>";
        // Redirect back to the index.php
        header("Location: index.php");
        exit();
    } else {
        echo "<p>Error adding player: " . $stmt->errorInfo()[2] . "</p>";
    }

    $stmt = null;
    $db = null;
}

?>

<!-- Form for adding a new player -->
<form action="add-player.php" method="post">
    <label for="Name">Name:</label>
    <input type="text" id="Name" name="Name" required>

    <label for="Position">Position:</label>
    <input type="text" id="Position" name="Position" required>

    <label for="MostUsedChampion">Most Used Champion:</label>
    <input type="text" id="MostUsedChampion" name="MostUsedChampion" required>

    <label for="Age">Age:</label>
    <input type="number" id="Age" name="Age" required>

    <label for="Nationality">Nationality:</label>
    <input type="text" id="Nationality" name="Nationality" required>

    <label for="WinRate">Win Rate (>0 && <1):</label>
    <input type="number" id="WinRate" name="WinRate" step="0.01" required>

    <input type="submit" value="Add Player">
</form>

<?php include('footer.html'); ?>
