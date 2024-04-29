<?php
include('includes/header.php');
include('includes/connect-db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tournament_name = $_POST['TournamentName'];
    $prize = $_POST['Prize'];

    $sql = "INSERT INTO Tournament (TournamentName, Prize) VALUES (?, ?)";
    $stmt = $db->prepare($sql);
    if ($stmt->execute([$tournament_name, $prize])) {
        echo "<p>New tournament added successfully!</p>";
        header("Location: stats.php");
        exit();
    } else {
        echo "<p>Error adding tournament: " . $stmt->errorInfo()[2] . "</p>";
    }
}
?>

<form action="add-tournament.php" method="post">
    <label for="TournamentName">Tournament Name:</label>
    <input type="text" id="TournamentName" name="TournamentName" required>

    <label for="Prize">Prize Amount:</label>
    <input type="number" id="Prize" name="Prize" required>

    <input type="submit" value="Add Tournament">
</form>

<?php include('footer.html'); ?>
