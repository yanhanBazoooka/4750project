<?php
include('includes/connect-db.php');

// Set the Content-Type and Content-Disposition headers to force the download.
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=players.csv');

// Create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// Output the column headings
fputcsv($output, array('PlayerID', 'Name', 'Position', 'MostUsedChampion', 'Age', 'Nationality', 'WinRate'));

// Fetch the data from the database
$stmt = $db->query("SELECT PlayerID, Name, Position, MostUsedChampion, Age, Nationality, WinRate FROM Player");

// Loop over the rows, outputting them directly to the output stream
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, $row);
}

fclose($output);
?>
