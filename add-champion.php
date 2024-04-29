<?php
include('includes/header.php');
include('includes/connect-db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $champion_name = $_POST['ChampionName'];
    $games_played = $_POST['GamesPlayed'];
    $win_rate = $_POST['WinRate'];

    $sql = "INSERT INTO Champion (ChampionName, GamesPlayed, WinRate) VALUES (?, ?, ?)";
    $stmt = $db->prepare($sql);
    if ($stmt->execute([$champion_name, $games_played, $win_rate])) {
        echo "<p>New champion added successfully!</p>";
        header("Location: stats.php");
        exit();
    } else {
        echo "<p>Error adding champion: " . $stmt->errorInfo()[2] . "</p>";
    }
}
?>

<!-- Form for adding a new champion -->
<form action="add-champion.php" method="post">
    <label for="ChampionName">Champion Name:</label>
    <input type="text" id="ChampionName" name="ChampionName" required>

    <label for="GamesPlayed">Games Played:</label>
    <input type="number" id="GamesPlayed" name="GamesPlayed" required>

    <label for="WinRate">Win Rate (0-1):</label>
    <input type="number" id="WinRate" name="WinRate" step="0.01" min="0" max="1" required>

    <input type="submit" value="Add Champion">
</form>

<?php include('footer.html'); ?>
