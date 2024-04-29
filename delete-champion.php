<?php
include('includes/header.php');
include('includes/connect-db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $champion_name = $_POST['ChampionName'];

    $sql = "DELETE FROM Champion WHERE ChampionName = ?";
    $stmt = $db->prepare($sql);
    if ($stmt->execute([$champion_name])) {
        echo "<p>Champion deleted successfully!</p>";
        header("Location: stats.php");
        exit();
    } else {
        echo "<p>Error deleting champion: " . $stmt->errorInfo()[2] . "</p>";
    }
}
?>

<!-- Form for deleting a champion -->
<form action="delete-champion.php" method="post">
    <label for="ChampionName">Champion Name:</label>
    <input type="text" id="ChampionName" name="ChampionName" required>

    <input type="submit" value="Delete Champion">
</form>

<?php include('footer.html'); ?>
