<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pj";
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn,"utf8");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (!isset($_GET['q'])){
	$sql = "SELECT * FROM patient";
}
else {
	$q = trim($_GET['q']);
	$sql = "SELECT * FROM patient where first_name like '%$q%' ";
}
$result = mysqli_query($conn, $sql);
$resultJSON = array();
if ($result->num_rows > 0) {
   while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
   	$iteminner = array();
    $iteminner = array("id" => $row['patient_id'], "text" =>  $row['first_name'] . " " . $row['last_name']. " | " .$row['national_id']);
    $resultJSON[] = $iteminner;
   }
}
echo json_encode($resultJSON);
?>