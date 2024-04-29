<?php
include('includes/header.php');
include('includes/connect-db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $league_name = $_POST['LeagueName'];
    $number_of_teams = $_POST['NumberOfTeams'];

    $sql = "INSERT INTO League (LeagueName, NumberOfTeams) VALUES (?, ?)";
    $stmt = $db->prepare($sql);
    if ($stmt->execute([$league_name, $number_of_teams])) {
        echo "<p>New league added successfully!</p>";
        header("Location: stats.php");
        exit();
    } else {
        echo "<p>Error adding league: " . $stmt->errorInfo()[2] . "</p>";
    }
}
?>

<form action="add-league.php" method="post">
    <label for="LeagueName">League Name:</label>
    <input type="text" id="LeagueName" name="LeagueName" required>

    <label for="NumberOfTeams">Number of Teams:</label>
    <input type="number" id="NumberOfTeams" name="NumberOfTeams" required>

    <input type="submit" value="Add League">
</form>

<?php include('footer.html'); ?>
