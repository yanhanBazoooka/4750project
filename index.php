<?php
include('header.php');
include('connect-db.php'); // This will set $db to the PDO object
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<main>
    <h2>Player List</h2>
    <!-- Add New Player Button -->
    <button onclick="window.location.href = 'add-player.php';">Add New Player</button>
    
    <!-- Player Table -->
    <table>
        <thead>
            <tr>
                <th>PlayerID</th>
                <th>Name</th>
                <th>Position</th>
                <th>Most Used Champion</th>
                <th>Age</th>
                <th>Nationality</th>
                <th>Win Rate</th>
            </tr>
        </thead>
        <tbody>
            <?php
            try {
                $query = "SELECT PlayerID, Name, Position, MostUsedChampion, Age, Nationality, WinRate FROM Player";
                $statement = $db->query($query); // Use $db, the PDO object from connect-db.php
                
                foreach ($statement as $row) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['PlayerID']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Position']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['MostUsedChampion']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Age']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Nationality']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['WinRate']) . "</td>";
                    echo "</tr>";
                }
            } catch (PDOException $e) {
                echo "<tr><td colspan='7'>Error: " . $e->getMessage() . "</td></tr>";
            }
            ?>
        </tbody>
    </table>
</main>

<?php include('footer.html'); ?>
