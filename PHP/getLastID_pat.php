<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pj";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt_reset = $conn->prepare("ALTER TABLE patient AUTO_INCREMENT = 1");
$stmt_reset->execute();
$stmt_reset->close();

if ($stmt = $conn->prepare("SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'pj' AND   TABLE_NAME   = 'patient';")) {
	$stmt->execute();
    $stmt->bind_result($last_ID);
    $stmt->fetch();
    $result['status'] = true;
    $result['last_ID'] = $last_ID;
    echo json_encode($result);
    $stmt->close();
}
?>