<?php
include('includes/header.php');
include('includes/connect-db.php');
session_start(); // Ensure session is started to access session variables

if (!isset($_SESSION['user_role'])) {
    header('Location: login.php'); // Redirect to login if no role is set
    exit();
}

$is_admin = ($_SESSION['user_role'] == 2); // Assuming '2' is the role ID for admins
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
    <form action="search.php" method="get">
        <input type="text" name="search_query" placeholder="Search for a player or a team" required>
        <button type="submit">Search</button>
    </form>
</div>

<div id="country-bar">
    <button class="country-button" id="country1" onclick="window.location.href='fetch_teams_by_league.php?league=LPL';"><img src="images/cn.png" alt="cn Flag">LPL</button>
    <button class="country-button" id="country2" onclick="window.location.href='fetch_teams_by_league.php?league=LCK';"><img src="images/kr.png" alt="kr Flag">LCK</button>
    <button class="country-button" id="country3" onclick="window.location.href='fetch_teams_by_league.php?league=LEC';"><img src="images/eu.jpg" alt="eu Flag">LEC</button>
    <button class="country-button" id="country4" onclick="window.location.href='fetch_teams_by_league.php?league=LCS';"><img src="images/us.png" alt="us Flag">LCS</button>
    <button class="country-button" id="country5" onclick="window.location.href='fetch_teams_by_league.php?league=VCS';"><img src="images/viet.png" alt="viet Flag">VCS</button>
    <button class="country-button" id="country6" onclick="window.location.href='fetch_teams_by_league.php?league=Others';"><img src="images/world.jpg" alt="world Flag">Others</button>
</div>

<main>
    <h2>Player List</h2>
    <button onclick="window.location.href = 'add-player.php';">Add New Player</button>
    <?php if ($is_admin): ?>
        <button onclick="window.location.href = 'delete_player.php';">Remove Player</button>
    <?php endif; ?>
    <button onclick="location.href='update_player.php';">Update Player</button>
    <button onclick="window.location.href = 'profile.php';">Account Profile</button>
    <button onclick="window.location.href = 'logout.php';">Logout</button>
    <button onclick="window.location.href='export_players.php'">Export Players to CSV</button>
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

</html>
