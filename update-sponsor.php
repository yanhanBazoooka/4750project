<?php
include('includes/header.php');
include('includes/connect-db.php');

$sponsor_data = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sponsor_name = $_POST['SponsorName'];
    $industry = $_POST['Industry'];
    $country = $_POST['Country'];

    $sql = "UPDATE Sponsor SET Industry = ?, Country = ? WHERE SponsorName = ?";
    $stmt = $db->prepare($sql);

    if ($stmt->execute([$industry, $country, $sponsor_name])) {
        echo "<p>Sponsor updated successfully.</p>";
        header("Location: stats.php");
        exit();
    } else {
        echo "<p>Error updating sponsor: " . $stmt->errorInfo()[2] . "</p>";
    }
}

// Retrieve current sponsor data for updating
if (!empty($_GET['sponsor_name'])) {
    $sponsor_name = $_GET['sponsor_name'];
    $sql = "SELECT * FROM Sponsor WHERE SponsorName = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$sponsor_name]);
    $sponsor_data = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>

<form action="update-sponsor.php" method="post">
    <label for="SponsorName">Sponsor Name:</label>
    <input type="text" id="SponsorName" name="SponsorName" value="<?php echo htmlspecialchars($sponsor_data['SponsorName'] ?? ''); ?>" required>

    <label for="Industry">Industry:</label>
    <input type="text" id="Industry" name="Industry" value="<?php echo htmlspecialchars($sponsor_data['Industry'] ?? ''); ?>" required>

    <label for="Country">Country:</label>
    <input type="text" id="Country" name="Country" value="<?php echo htmlspecialchars($sponsor_data['Country'] ?? ''); ?>" required>

    <input type="submit" value="Update Sponsor">
</form>

<?php include('footer.html'); ?>
