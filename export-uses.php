<?php
include('includes/connect-db.php');

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=uses.csv');

$output = fopen('php://output', 'w');
fputcsv($output, array('PlayerID', 'EquipmentName'));

$stmt = $db->query("SELECT PlayerID, EquipmentName FROM Uses");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, $row);
}

fclose($output);
?>
