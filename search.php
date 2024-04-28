<?php
include('includes/header.php');
include('includes/connect-db.php');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the search query is set
if (isset($_GET['search_query'])) {
    $searchQuery = $_GET['search_query'];
    $foundResults = false; // flag to track if we found any results

    // First, try to find a team that matches the search query
    $stmt = $db->prepare("SELECT * FROM Team WHERE TeamName LIKE ?");
    $stmt->execute(array("%$searchQuery%"));
    
    if ($stmt->rowCount() > 0) {
        $foundResults = true; // We found team results
        echo "<h2>Teams</h2>";
        echo "<table>";
        echo "<tr><th>Team Name</th><th>League Name</th><th>Win Rate</th><th>Rank</th></tr>";

        while ($team = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            foreach ($team as $key => $value) {
                echo "<td>" . htmlspecialchars($value) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }

    // Next, try to find a player that matches the search query
    $stmt = $db->prepare("SELECT * FROM Player WHERE Name LIKE ?");
    $stmt->execute(array("%$searchQuery%"));

    if ($stmt->rowCount() > 0) {
        $foundResults = true; // We found player results
        echo "<h2>Players</h2>";
        echo "<table>";
        echo "<tr><th>Player ID</th><th>Name</th><th>Position</th><th>Most Used Champion</th><th>Age</th><th>Nationality</th><th>Win Rate</th></tr>";

        while ($player = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            foreach ($player as $key => $value) {
                echo "<td>" . htmlspecialchars($value) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }

    // If no results found
    if (!$foundResults) {
        echo "<p>No teams or players found with the search term '$searchQuery'.</p>";
    }
} else {
    echo "<p>Please enter a search query.</p>";
}

$db = null;
?>
