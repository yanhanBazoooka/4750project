<?php
include('includes/connect-db.php');

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=leagues.csv');

$output = fopen('php://output', 'w');
fputcsv($output, array('LeagueName', 'NumberOfTeams'));

$stmt = $db->query("SELECT LeagueName, NumberOfTeams FROM League");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, $row);
}

fclose($output);
?>
