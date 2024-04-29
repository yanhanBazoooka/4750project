<?php
include('includes/connect-db.php');

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=equipment.csv');

$output = fopen('php://output', 'w');
fputcsv($output, array('EquipmentName', 'Cost'));

$stmt = $db->query("SELECT EquipmentName, Cost FROM Equipment");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, $row);
}

fclose($output);
?>
