<?php
include('includes/header.php');
include('includes/connect-db.php');

// Check if POST request and data are valid
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $player_id = $_POST['PlayerID'];
    $equipment_name = $_POST['EquipmentName'];

    // Validate existence of Player and Equipment in the database
    $validation_sql = "SELECT EXISTS(SELECT 1 FROM Player WHERE PlayerID = ?) AS PlayerExists, 
                              EXISTS(SELECT 1 FROM Equipment WHERE EquipmentName = ?) AS EquipmentExists";

    $validation_stmt = $db->prepare($validation_sql);
    $validation_stmt->execute([$player_id, $equipment_name]);
    $exists = $validation_stmt->fetch(PDO::FETCH_ASSOC);

    if ($exists['PlayerExists'] && $exists['EquipmentExists']) {
        // Both Player and Equipment exist, insert new use
        $sql = "INSERT INTO Uses (PlayerID, EquipmentName) VALUES (?, ?)";
        $stmt = $db->prepare($sql);
        if ($stmt->execute([$player_id, $equipment_name])) {
            echo "<p>New equipment usage added successfully!</p>";
            header("Location: stats.php"); // Redirect after successful addition
            exit();
        } else {
            echo "<p>Error adding equipment usage: " . $stmt->errorInfo()[2] . "</p>";
        }
    } else {
        // Error if Player or Equipment does not exist
        if (!$exists['PlayerExists']) {
            echo "<p>Error: Player does not exist.</p>";
        }
        if (!$exists['EquipmentExists']) {
            echo "<p>Error: Equipment does not exist.</p>";
        }
    }
}
?>

<form action="add-uses.php" method="post">
    <label for="PlayerID">Player ID:</label>
    <input type="text" id="PlayerID" name="PlayerID" required>

    <label for="EquipmentName">Equipment Name:</label>
    <input type="text" id="EquipmentName" name="EquipmentName" required>

    <input type="submit" value="Add Equipment Usage">
</form>

<?php include('footer.html'); ?>
