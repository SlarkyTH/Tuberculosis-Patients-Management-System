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

if ($stmt = $conn->prepare("SELECT * FROM admin")) {
	$stmt->execute();
    $stmt->fetch();
    $result['data'] = $data;
    echo json_encode($result);
    $stmt->close();
}

?>