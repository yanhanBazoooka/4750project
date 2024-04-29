<?php
include('includes/header.php');
include('includes/connect-db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $equipment_name = $_POST['EquipmentName'];
    $cost = $_POST['Cost'];

    $sql = "INSERT INTO Equipment (EquipmentName, Cost) VALUES (?, ?)";
    $stmt = $db->prepare($sql);
    if ($stmt->execute([$equipment_name, $cost])) {
        echo "<p>New equipment added successfully!</p>";
        header("Location: stats.php");
        exit();
    } else {
        echo "<p>Error adding equipment: " . $stmt->errorInfo()[2] . "</p>";
    }
}
?>

<form action="add-equipment.php" method="post">
    <label for="EquipmentName">Equipment Name:</label>
    <input type="text" id="EquipmentName" name="EquipmentName" required>

    <label for="Cost">Cost:</label>
    <input type="number" id="Cost" name="Cost" step="0.01" required>

    <input type="submit" value="Add Equipment">
</form>

<?php include('footer.html'); ?>
