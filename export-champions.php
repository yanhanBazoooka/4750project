<?php
include('includes/connect-db.php');

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=champions.csv');

$output = fopen('php://output', 'w');
fputcsv($output, array('ChampionName', 'GamesPlayed', 'WinRate'));

$stmt = $db->query("SELECT ChampionName, GamesPlayed, WinRate FROM Champion");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, $row);
}

fclose($output);
?>
