<?php
include('includes/connect-db.php');

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=endorsements.csv');

$output = fopen('php://output', 'w');
fputcsv($output, array('SponsorName', 'TeamName', 'Price'));

$stmt = $db->query("SELECT SponsorName, TeamName, Price FROM Endorse");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, $row);
}

fclose($output);
?>
