<?php
include('includes/header.php');
include('includes/connect-db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $equipment_name = $_POST['EquipmentName'];
    $cost = $_POST['Cost'];

    $sql = "UPDATE Equipment SET Cost = ? WHERE EquipmentName = ?";
    $stmt = $db->prepare($sql);
    if ($stmt->execute([$cost, $equipment_name])) {
        echo "<p>Equipment updated successfully.</p>";
        header("Location: stats.php");
        exit();
    } else {
        echo "<p>Error updating equipment: " . $stmt->errorInfo()[2] . "</p>";
    }
}

// Retrieve current equipment data for updating
$equipment_data = array();
if (!empty($_GET['equipment_name'])) {
    $equipment_name = $_GET['equipment_name'];
    $sql = "SELECT * FROM Equipment WHERE EquipmentName = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$equipment_name]);
    $equipment_data = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>

<form action="update-equipment.php" method="post">
    <label for="EquipmentName">Equipment Name:</label>
    <input type="text" id="EquipmentName" name="EquipmentName" value="<?php echo htmlspecialchars($equipment_data['EquipmentName'] ?? ''); ?>" required>

    <label for="Cost">Cost:</label>
    <input type="number" id="Cost" name="Cost" value="<?php echo htmlspecialchars($equipment_data['Cost'] ?? ''); ?>" step="0.01" required>

    <input type="submit" value="Update Equipment">
</form>

<?php include('footer.html'); ?>
