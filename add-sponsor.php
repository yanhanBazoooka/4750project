<?php
include('includes/header.php');
include('includes/connect-db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sponsor_name = $_POST['SponsorName'];
    $industry = $_POST['Industry'];
    $country = $_POST['Country'];

    $sql = "INSERT INTO Sponsor (SponsorName, Industry, Country) VALUES (?, ?, ?)";
    $stmt = $db->prepare($sql);
    if ($stmt->execute([$sponsor_name, $industry, $country])) {
        echo "<p>New sponsor added successfully!</p>";
        header("Location: stats.php");
        exit();
    } else {
        echo "<p>Error adding sponsor: " . $stmt->errorInfo()[2] . "</p>";
    }
}
?>

<form action="add-sponsor.php" method="post">
    <label for="SponsorName">Sponsor Name:</label>
    <input type="text" id="SponsorName" name="SponsorName" required>

    <label for="Industry">Industry:</label>
    <input type="text" id="Industry" name="Industry" required>

    <label for="Country">Country:</label>
    <input type="text" id="Country" name="Country" required>

    <input type="submit" value="Add Sponsor">
</form>

<?php include('footer.html'); ?>
