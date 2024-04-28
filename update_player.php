<?php
include('includes/header.php');
include('includes/connect-db.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);


// Initialize player data array
$player_data = array();

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['player_id'])) {
    // Extract and sanitize the input data
    $player_id = $_POST['player_id'];
    $name = $_POST['name'] ?? null;
    $position = $_POST['position'] ?? null;
    $most_used_champion = $_POST['most_used_champion'] ?? null;
    $age = $_POST['age'] ?? null;
    $nationality = $_POST['nationality'] ?? null;
    $win_rate = $_POST['win_rate'] ?? null;

    // Construct the SQL update statement with placeholders
    $sql = "UPDATE Player SET 
                Name = ?, 
                Position = ?, 
                MostUsedChampion = ?, 
                Age = ?, 
                Nationality = ?, 
                WinRate = ?
            WHERE PlayerID = ?";
    
    // Prepare the SQL statement
    $stmt = $db->prepare($sql);

    // Bind the variables to the placeholders
    $stmt->bindParam(1, $name);
    $stmt->bindParam(2, $position);
    $stmt->bindParam(3, $most_used_champion);
    $stmt->bindParam(4, $age, PDO::PARAM_INT);
    $stmt->bindParam(5, $nationality);
    $stmt->bindParam(6, $win_rate);
    $stmt->bindParam(7, $player_id, PDO::PARAM_INT);

    // Execute the statement and check for errors
    if($stmt->execute()){
        echo "Player updated successfully.";
    } else {
        echo "ERROR: " . $stmt->errorInfo()[2];
    }
}

// Retrieve current player data from the database if a player ID is provided
if (!empty($_GET['player_id'])) {
    $player_id = $_GET['player_id'];
    $sql = "SELECT * FROM Player WHERE PlayerID = ?";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $player_id, PDO::PARAM_INT);
    $stmt->execute();
    $player_data = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Player</title>
    <!-- Include your CSS here -->
</head>
<body>
    <form action="update_player.php" method="post">
        <label for="player_id">Player ID:</label>
        <input type="number" id="player_id" name="player_id" value="<?php echo htmlspecialchars($player_data['PlayerID'] ?? ''); ?>" required>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($player_data['Name'] ?? ''); ?>">
        <label for="position">Position:</label>
        <input type="text" id="position" name="position" value="<?php echo htmlspecialchars($player_data['Position'] ?? ''); ?>">
        <label for="most_used_champion">Most Used Champion:</label>
        <input type="text" id="most_used_champion" name="most_used_champion" value="<?php echo htmlspecialchars($player_data['MostUsedChampion'] ?? ''); ?>">
        <label for="age">Age:</label>
        <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($player_data['Age'] ?? ''); ?>">
        <label for="nationality">Nationality:</label>
        <input type="text" id="nationality" name="nationality" value="<?php echo htmlspecialchars($player_data['Nationality'] ?? ''); ?>">
        <label for="win_rate">Win Rate:</label>
        <input type="number" step="0.01" id="win_rate" name="win_rate" value="<?php echo htmlspecialchars($player_data['WinRate'] ?? ''); ?>">
        <input type="submit" value="Update Player">
    </form>
</body>
</html>