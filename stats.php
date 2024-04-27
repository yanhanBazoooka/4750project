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
        <img src="images/lol.png" alt="League of Legend Pro Stats Logo" />
    </div>
    <nav id="section-nav">
    </nav>
</header>

<div id="league-selector">
</div>




<div id="search-bar">
    <input type="text" placeholder="Search for player, team, game...">
    <button type="submit">Search</button>
</div>
<div id="country-bar">
    <button class="country-button" id="country1"><img src="images/cn.png" alt="cn Flag">LPL</button>
    <button class="country-button" id="country2"><img src="images/kr.png" alt=" kr Flag">LCK</button>
    <button class="country-button" id="country3"><img src="images/eu.jpg" alt="eu Flag">LEC</button>
    <button class="country-button" id="country4"><img src="images/us.png" alt="us Flag">LCS</button>
    <button class="country-button" id="country5"><img src="images/viet.png" alt="viet Flag">VCS</button>
    <button class="country-button" id="country6"><img src="images/world.jpg" alt="world Flag">Others</button>
</div>

<main>
    <h2>Player List</h2>
    <button onclick="window.location.href = 'add-player.php';">Add New Player</button>
    <button onclick="window.location.href = 'delete_data.php';">Remove Player</button>
    <button onclick="window.location.href = 'profile.php';">Account Profile</button>
    <button onclick="window.location.href = 'logout.php';">Logout</button>
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
            $stmt = $db->query("SELECT PlayerID, Name, MostUsedChampion, Age, Nationality, WinRate FROM player");
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

