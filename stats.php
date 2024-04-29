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
    <style>
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }

        #logo {
            flex-grow: 1;
        }

        .header-buttons {
            display: flex;
            align-items: center;
            gap: 10px; /* Adds space between the buttons */
        }

        button {
            padding: 10px;
            cursor: pointer;
        }

        .country-button img {
            vertical-align: middle;
        }
    </style>
</head>
<body>
<header>
    <h1>League of Legend Pro Stats</h1>
    <div id="logo">
        <img src="images/lol.png" alt="League of Legend Pro Stats Logo" />
    </div>
    <div class="header-buttons">
        <button onclick="window.location.href = 'profile.php';">Account Profile</button>
        <button onclick="window.location.href = 'logout.php';">Logout</button>
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
    <h2>Champion List</h2>
<?php ?>
    <button onclick="window.location.href = 'add-champion.php';">Add New Champion</button>
    <button onclick="location.href='update-champion.php';">Update Champion</button>
    <?php if ($is_admin): ?>
        <button onclick="window.location.href = 'delete-champion.php';">Remove Champion</button>
    <?php endif; ?>
    <button onclick="window.location.href='export-champions.php'">Export Champions to CSV</button>
<?php ?>
<table>
    <thead>
        <tr>
            <th>Champion Name</th>
            <th>Games Played</th>
            <th>Win Rate</th>
        </tr>
    </thead>
    <tbody>
        <?php
        try {
            $stmt = $db->query("SELECT ChampionName, GamesPlayed, WinRate FROM Champion");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['ChampionName']) . "</td>";
                echo "<td>" . htmlspecialchars($row['GamesPlayed']) . "</td>";
                echo "<td>" . htmlspecialchars($row['WinRate']) . "</td>";
                echo "</tr>";
            }
        } catch (PDOException $e) {
            echo "<tr><td colspan='3'>Error: " . $e->getMessage() . "</td></tr>";
        }
        ?>
    </tbody>
</table>
<!-- End of Champion List Section -->
<!-- Equipment List Section -->
<h2>Equipment List</h2>
<?php ?>
    <button onclick="window.location.href = 'add-equipment.php';">Add New Equipment</button>
    <?php if ($is_admin): ?>
        <button onclick="window.location.href = 'delete-equipment.php';">Remove Equipment</button>

    <?php endif; ?>
    <button onclick="location.href='update-equipment.php';">Update Equipment</button>
    <button onclick="window.location.href='export-equipment.php'">Export Equipment to CSV</button>
<?php ?>
<table>
    <thead>
        <tr>
            <th>Equipment Name</th>
            <th>Cost</th>
            <!-- Add additional headers if needed -->
        </tr>
    </thead>
    <tbody>
        <?php
        try {
            $stmt = $db->query("SELECT EquipmentName, Cost FROM Equipment");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['EquipmentName']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Cost']) . "</td>";
                echo "</tr>";
            }
        } catch (PDOException $e) {
            echo "<tr><td colspan='2'>Error: " . $e->getMessage() . "</td></tr>";
        }
        ?>
    </tbody>
</table>

<h2>Coach List</h2>
<button onclick="window.location.href = 'add-coach.php';">Add New Coach</button>
<?php if ($is_admin): ?>
    <button onclick="window.location.href = 'delete-coach.php';">Remove Coach</button>
<?php endif; ?>
<button onclick="location.href='update-coach.php';">Update Coach</button>
<button onclick="window.location.href='export-coaches.php'">Export Coaches to CSV</button>

<table>
    <thead>
        <tr>
            <th>Coach Name</th>
            <th>Nationality</th>
            <!-- Additional headers for other coach attributes if needed -->
        </tr>
    </thead>
    <tbody>
        <?php
        try {
            $stmt = $db->query("SELECT CoachName, Nationality FROM Coach");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['CoachName']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Nationality']) . "</td>";
                echo "</tr>";
            }
        } catch (PDOException $e) {
            echo "<tr><td colspan='2'>Error: " . $e->getMessage() . "</td></tr>";
        }
        ?>
    </tbody>
</table>
<h2>Sponsor List</h2>
<button onclick="window.location.href = 'add-sponsor.php';">Add New Sponsor</button>
<button onclick="location.href='update-sponsor.php';">Update Sponsor</button>
<button onclick="window.location.href='export-sponsors.php'">Export Sponsors to CSV</button>
<?php if ($is_admin): ?>
    <button onclick="window.location.href = 'delete-sponsor.php';">Remove Sponsor</button>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>Sponsor Name</th>
            <th>Industry</th>
            <th>Country</th>
        </tr>
    </thead>
    <tbody>
        <?php
        try {
            $stmt = $db->query("SELECT SponsorName, Industry, Country FROM Sponsor");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['SponsorName']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Industry']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Country']) . "</td>";
                echo "</tr>";
            }
        } catch (PDOException $e) {
            echo "<tr><td colspan='3'>Error: " . $e->getMessage() . "</td></tr>";
        }
        ?>
    </tbody>
</table>
<h2>League List</h2>
<button onclick="window.location.href = 'add-league.php';">Add New League</button>
<button onclick="location.href='update-league.php';">Update League</button>
<button onclick="window.location.href='export-leagues.php'">Export Leagues to CSV</button>
<?php if ($is_admin): ?>
    <button onclick="window.location.href = 'delete-league.php';">Remove League</button>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>League Name</th>
            <th>Number of Teams</th>
        </tr>
    </thead>
    <tbody>
        <?php
        try {
            $stmt = $db->query("SELECT LeagueName, NumberOfTeams FROM League");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['LeagueName']) . "</td>";
                echo "<td>" . htmlspecialchars($row['NumberOfTeams']) . "</td>";
                echo "</tr>";
            }
        } catch (PDOException $e) {
            echo "<tr><td colspan='2'>Error: " . $e->getMessage() . "</td></tr>";
        }
        ?>
    </tbody>
</table>

<h2>Tournament List</h2>
<button onclick="window.location.href = 'add-tournament.php';">Add New Tournament</button>
<button onclick="location.href='update-tournament.php';">Update Tournament</button>
<button onclick="window.location.href='export-tournaments.php'">Export Tournaments to CSV</button>
<?php if ($is_admin): ?>
    <button onclick="window.location.href = 'delete-tournament.php';">Remove Tournament</button>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>Tournament Name</th>
            <th>Prize</th>
        </tr>
    </thead>
    <tbody>
        <?php
        try {
            $stmt = $db->query("SELECT TournamentName, Prize FROM Tournament");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['TournamentName']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Prize']) . "</td>";
                echo "</tr>";
            }
        } catch (PDOException $e) {
            echo "<tr><td colspan='2'>Error: " . $e->getMessage() . "</td></tr>";
        }
        ?>
    </tbody>
</table>
<h2>Endorsements List</h2>
<button onclick="window.location.href = 'add-endorse.php';">Add New Endorsement</button>
<button onclick="location.href='update-endorse.php';">Update Endorsement</button>
<button onclick="window.location.href='export-endorsements.php'">Export Endorsements to CSV</button>
<?php if ($is_admin): ?>
    <button onclick="window.location.href = 'delete-endorse.php';">Remove Endorsement</button>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>Sponsor Name</th>
            <th>Team Name</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>
        <?php
        try {
            $stmt = $db->query("SELECT SponsorName, TeamName, Price FROM Endorse");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['SponsorName']) . "</td>";
                echo "<td>" . htmlspecialchars($row['TeamName']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Price']) . "</td>";
                echo "</tr>";
            }
        } catch (PDOException $e) {
            echo "<tr><td colspan='3'>Error: " . $e->getMessage() . "</td></tr>";
        }
        ?>
    </tbody>
</table>
<h2>Equipment Usage List</h2>
<button onclick="window.location.href = 'add-uses.php';">Add New Equipment Usage</button>
<button onclick="window.location.href='update-uses.php';">Update Equipment Usage</button>
<button onclick="window.location.href='export-uses.php'">Export Equipment Usage to CSV</button>
<?php if ($is_admin): ?>
    <button onclick="window.location.href = 'delete-uses.php';">Remove Equipment Usage</button>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>Player ID</th>
            <th>Equipment Name</th>
        </tr>
    </thead>
    <tbody>
        <?php
        try {
            $stmt = $db->query("SELECT PlayerID, EquipmentName FROM Uses");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['PlayerID']) . "</td>";
                echo "<td>" . htmlspecialchars($row['EquipmentName']) . "</td>";
                echo "</tr>";
            }
        } catch (PDOException $e) {
            echo "<tr><td colspan='2'>Error: " . $e->getMessage() . "</td></tr>";
        }
        ?>
    </tbody>
</table>

</main>







</html>

