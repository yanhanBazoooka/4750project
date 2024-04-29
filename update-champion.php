<?php
include('includes/header.php');
include('includes/connect-db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $champion_name = $_POST['ChampionName'];
    $games_played = $_POST['GamesPlayed'];
    $win_rate = $_POST['WinRate'];

    $sql = "UPDATE Champion SET GamesPlayed = ?, WinRate = ? WHERE ChampionName = ?";
    $stmt = $db->prepare($sql);
    if ($stmt->execute([$games_played, $win_rate, $champion_name])) {
        echo "<p>Champion updated successfully.</p>";
        header("Location: stats.php");
        exit();
    } else {
        echo "<p>Error updating champion: " . $stmt->errorInfo()[2] . "</p>";
    }
}

// Retrieve current champion data for updating
$champion_data = array();
if (!empty($_GET['champion_name'])) {
    $champion_name = $_GET['champion_name'];
    $sql = "SELECT * FROM Champion WHERE ChampionName = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$champion_name]);
    $champion_data = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>

<!-- Form for updating a champion -->
<form action="update-champion.php" method="post">
    <label for="ChampionName">Champion Name:</label>
    <input type="text" id="ChampionName" name="ChampionName" value="<?php echo htmlspecialchars($champion_data['ChampionName'] ?? ''); ?>" required>

    <label for="GamesPlayed">Games Played:</label>
    <input type="number" id="GamesPlayed" name="GamesPlayed" value="<?php echo htmlspecialchars($champion_data['GamesPlayed'] ?? ''); ?>" required>

    <label for="WinRate">Win Rate (0-1):</label>
    <input type="number" id="WinRate" name="WinRate" step="0.01" min="0" max="1" value="<?php echo htmlspecialchars($champion_data['WinRate'] ?? ''); ?>" required>

    <input type="submit" value="Update Champion">
</form>

<?php include('footer.html'); ?>
