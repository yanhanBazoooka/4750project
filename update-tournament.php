<?php
include('includes/header.php');
include('includes/connect-db.php');

$tournament_data = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tournament_name = $_POST['TournamentName'];
    $prize = $_POST['Prize'];

    $sql = "UPDATE Tournament SET Prize = ? WHERE TournamentName = ?";
    $stmt = $db->prepare($sql);

    if ($stmt->execute([$prize, $tournament_name])) {
        echo "<p>Tournament updated successfully.</p>";
        header("Location: stats.php");
        exit();
    } else {
        echo "<p>Error updating tournament: " . $stmt->errorInfo()[2] . "</p>";
    }
}

// Retrieve current tournament data for updating
if (!empty($_GET['tournament_name'])) {
    $tournament_name = $_GET['tournament_name'];
    $sql = "SELECT * FROM Tournament WHERE TournamentName = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$tournament_name]);
    $tournament_data = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>

<form action="update-tournament.php" method="post">
    <label for="TournamentName">Tournament Name:</label>
    <input type="text" id="TournamentName" name="TournamentName" value="<?php echo htmlspecialchars($tournament_data['TournamentName'] ?? ''); ?>" required>

    <label for="Prize">Prize Amount:</label>
    <input type="number" id="Prize" name="Prize" value="<?php echo htmlspecialchars($tournament_data['Prize'] ?? ''); ?>" required>

    <input type="submit" value="Update Tournament">
</form>

<?php include('footer.html'); ?>
