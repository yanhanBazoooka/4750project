<?php
include('includes/header.php');
include('includes/connect-db.php');

$endorse_data = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sponsor_name = $_POST['SponsorName'];
    $team_name = $_POST['TeamName'];
    $price = $_POST['Price'];

    // Assuming SponsorName and TeamName together form a composite key
    $sql = "UPDATE Endorse SET Price = ? WHERE SponsorName = ? AND TeamName = ?";
    $stmt = $db->prepare($sql);

    if ($stmt->execute([$price, $sponsor_name, $team_name])) {
        echo "<p>Endorsement updated successfully.</p>";
        header("Location: stats.php");
        exit();
    } else {
        echo "<p>Error updating endorsement: " . $stmt->errorInfo()[2] . "</p>";
    }
}

// Retrieve current endorsement data for updating
if (!empty($_GET['sponsor_name']) && !empty($_GET['team_name'])) {
    $sponsor_name = $_GET['sponsor_name'];
    $team_name = $_GET['team_name'];
    $sql = "SELECT * FROM Endorse WHERE SponsorName = ? AND TeamName = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$sponsor_name, $team_name]);
    $endorse_data = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>

<form action="update-endorse.php" method="post">
    <label for="SponsorName">Sponsor Name:</label>
    <input type="text" id="SponsorName" name="SponsorName" value="<?php echo htmlspecialchars($endorse_data['SponsorName'] ?? ''); ?>" required>

    <label for="TeamName">Team Name:</label>
    <input type="text" id="TeamName" name="TeamName" value="<?php echo htmlspecialchars($endorse_data['TeamName'] ?? ''); ?>" required>

    <label for="Price">Price:</label>
    <input type="number" id="Price" name="Price" value="<?php echo htmlspecialchars($endorse_data['Price'] ?? ''); ?>" step="0.01" required>

    <input type="submit" value="Update Endorsement">
</form>

<?php include('footer.html'); ?>
