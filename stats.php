<?php
include('includes/header.php');
include('includes/connect-db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>League of Legend Pro Stats</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
    <h1>League of Legend Pro Stats</h1>
    <div id="logo">
        <!-- Insert your logo here -->
    </div>
    <nav id="section-nav">
        <!-- Navigation items (possibly dynamic based on your database contents) -->
    </nav>
</header>

<div id="league-selector">
    <!-- League selection buttons or dropdowns -->
</div>

<div id="search-bar">
    <!-- Search form -->
    <input type="text" placeholder="Search for player, team, game...">
    <button type="submit">Search</button>
</div>

<main>
    <h2>Player List</h2>
    <button onclick="window.location.href = 'add-player.php';">Add New Player</button>

    <!-- Player Table -->
    <table>
        <thead>
        <tr>
            <th>PlayerID</th>
            <th>Name</th>
            <th>Most Used Champion</th>
            <th>Age</th>
            <th>Nationality</th>
            <th>Win Rate</th>
        </tr>
        </thead>
        <tbody>
        <?php
        try {
            $stmt = $db->query("SELECT PlayerID, Name, MostUsedChampion, Age, Nationality, WinRate FROM Player");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['PlayerID']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['MostUsedChampion']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Age']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Nationality']) . "</td>";
                echo "<td>" . htmlspecialchars($row['WinRate']) . "</td>";
                echo "</tr>";
            }
        } catch (PDOException $e) {
            echo "<tr><td colspan='6'>Error: " . $e->getMessage() . "</td></tr>";
        }
        ?>
        </tbody>
    </table>
</main>



</body>
    <img src="images/lol.png" alt="Description" id="top-left-image">

</html>
