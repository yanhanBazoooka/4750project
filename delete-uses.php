<?php
include('includes/header.php');
include('includes/connect-db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $player_id = $_POST['PlayerID'];
    $equipment_name = $_POST['EquipmentName'];

    // Delete the usage entry
    $sql = "DELETE FROM Uses WHERE PlayerID = ? AND EquipmentName = ?";
    $stmt = $db->prepare($sql);
    if ($stmt->execute([$player_id, $equipment_name])) {
        echo "<p>Equipment usage deleted successfully!</p>";
        header("Location: stats.php");
        exit();
    } else {
        echo "<p>Error deleting equipment usage: " . $stmt->errorInfo()[2] . "</p>";
    }
}
?>

<form action="delete-uses.php" method="post">
    <label for="PlayerID">Player ID:</label>
    <input type="text" id="PlayerID" name="PlayerID" required>

    <label for="EquipmentName">Equipment Name:</label>
    <input type="text" id="EquipmentName" name="EquipmentName" required>

    <input type="submit" value="Delete Equipment Usage">
</form>

<?php include('footer.html'); ?>
