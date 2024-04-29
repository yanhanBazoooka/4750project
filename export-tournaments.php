<?php
include('includes/connect-db.php');

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=tournaments.csv');

$output = fopen('php://output', 'w');
fputcsv($output, array('TournamentName', 'Prize'));

$stmt = $db->query("SELECT TournamentName, Prize FROM Tournament");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, $row);
}

fclose($output);
?>
