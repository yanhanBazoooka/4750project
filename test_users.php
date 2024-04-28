<?php
try {
$db = new PDO('mysql:host=localhost;dbname=league_tracker', 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $db->query("SELECT * FROM users");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
print_r($row);
}
} catch (PDOException $e) {
die("Error!: " . $e->getMessage());
}
?>
