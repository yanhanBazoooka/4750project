<?php
include('includes/connect-db.php');

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=coaches.csv');

$output = fopen('php://output', 'w');
fputcsv($output, array('CoachName', 'Nationality'));

$stmt = $db->query("SELECT CoachName, Nationality FROM Coach");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, $row);
}

fclose($output);
?>
