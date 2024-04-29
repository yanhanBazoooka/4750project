<?php
include('includes/header.php');
include('includes/connect-db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $old_player_id = $_POST['OldPlayerID'];
    $old_equipment_name = $_POST['OldEquipmentName'];
    $new_player_id = $_POST['NewPlayerID'];
    $new_equipment_name = $_POST['NewEquipmentName'];

    $sql = "UPDATE Uses SET PlayerID = ?, EquipmentName = ? WHERE PlayerID = ? AND EquipmentName = ?";
    $stmt = $db->prepare($sql);
    if ($stmt->execute([$new_player_id, $new_equipment_name, $old_player_id, $old_equipment_name])) {
        echo "<p>Equipment usage updated successfully!</p>";
        header("Location: stats.php");
        exit();
    } else {
        echo "<p>Error updating equipment usage: " . $stmt->errorInfo()[2] . "</p>";
    }
}
?>

<form action="update-uses.php" method="post">
    <label for="OldPlayerID">Old Player ID:</label>
    <input type="text" id="OldPlayerID" name="OldPlayerID" required>

    <label for="OldEquipmentName">Old Equipment Name:</label>
    <input type="text" id="OldEquipmentName" name="OldEquipmentName" required>

    <label for="NewPlayerID">New Player ID:</label>
    <input type="text" id="NewPlayerID" name="NewPlayerID" required>

    <label for="NewEquipmentName">New Equipment Name:</label>
    <input type="text" id="NewEquipmentName" name="NewEquipmentName" required>

    <input type="submit" value="Update Equipment Usage">
</form>

<?php include('footer.html'); ?>
