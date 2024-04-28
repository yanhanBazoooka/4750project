<?php
// Includes for header, database connection, and footer
include('includes/header.php');
include('includes/connect-db.php');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the 'league' parameter is set in the URL
if (isset($_GET['league'])) {
    $leagueName = $_GET['league'];

    // Prepare the SQL statement with a parameter placeholder
    $stmt = $db->prepare("SELECT * FROM Team WHERE LeagueName = ?");
    $stmt->bindParam(1, $leagueName);

    // Try to execute the statement
    try {
        $stmt->execute();

        // Check if any rows were returned
        if ($stmt->rowCount() > 0) {
            // Start the table
            echo "<table>";
            echo "<tr><th>Team Name</th><th>Win Rate</th><th>Rank</th></tr>";

            // Fetch each row and output the data
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['TeamName']) . "</td>";
                echo "<td>" . htmlspecialchars($row['WinRate']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Rank']) . "</td>";
                echo "</tr>";
            }

            // End the table
            echo "</table>";
        } else {
            // If no rows were returned
            echo "<p>No teams found for the specified league.</p>";
        }
    } catch (PDOException $e) {
        // Catch any exceptions and display the error
        echo "<p>Error executing query: " . $e->getMessage() . "</p>";
    }
} else {
    // If the 'league' parameter was not provided
    echo "<p>No league specified.</p>";
}

// Null the database connection
$db = null;


