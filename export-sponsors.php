<?php
include('includes/connect-db.php');

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=sponsors.csv');

$output = fopen('php://output', 'w');
fputcsv($output, array('SponsorName', 'Industry', 'Country'));

$stmt = $db->query("SELECT SponsorName, Industry, Country FROM Sponsor");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, $row);
}

fclose($output);
?>
