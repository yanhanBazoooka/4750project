<?php
include('includes/header.php');
include('includes/connect-db.php');

$league_data = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $league_name = $_POST['LeagueName'];
    $number_of_teams = $_POST['NumberOfTeams'];

    $sql = "UPDATE League SET NumberOfTeams = ? WHERE LeagueName = ?";
    $stmt = $db->prepare($sql);

    if ($stmt->execute([$number_of_teams, $league_name])) {
        echo "<p>League updated successfully.</p>";
        header("Location: stats.php");
        exit();
    } else {
        echo "<p>Error updating league: " . $stmt->errorInfo()[2] . "</p>";
    }
}

// Retrieve current league data for updating
if (!empty($_GET['league_name'])) {
    $league_name = $_GET['league_name'];
    $sql = "SELECT * FROM League WHERE LeagueName = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$league_name]);
    $league_data = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>

<form action="update-league.php" method="post">
    <label for="LeagueName">League Name:</label>
    <input type="text" id="LeagueName" name="LeagueName" value="<?php echo htmlspecialchars($league_data['LeagueName'] ?? ''); ?>" required>

    <label for="NumberOfTeams">Number of Teams:</label>
    <input type="number" id="NumberOfTeams" name="NumberOfTeams" value="<?php echo htmlspecialchars($league_data['NumberOfTeams'] ?? ''); ?>" required>

    <input type="submit" value="Update League">
</form>

<?php include('footer.html'); ?>
