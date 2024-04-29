<?php
include('includes/header.php');
include('includes/connect-db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $equipment_name = $_POST['EquipmentName'];

    $sql = "DELETE FROM Equipment WHERE EquipmentName = ?";
    $stmt = $db->prepare($sql);
    if ($stmt->execute([$equipment_name])) {
        echo "<p>Equipment deleted successfully!</p>";
        header("Location: stats.php");
        exit();
    } else {
        echo "<p>Error deleting equipment: " . $stmt->errorInfo()[2] . "</p>";
    }
}

?>

<form action="delete-equipment.php" method="post">
    <label for="EquipmentName">Equipment Name:</label>
    <input type="text" id="EquipmentName" name="EquipmentName" required>

    <input type="submit" value="Delete Equipment">
</form>

<?php include('footer.html'); ?>
