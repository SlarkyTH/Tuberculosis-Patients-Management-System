<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pj";
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn,"utf8mb4");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM appointment where date(appoint_datetime) = DATE_ADD(DATE(NOW()), INTERVAL 7 DAY) OR date(appoint_datetime) = DATE_ADD(DATE(NOW()), INTERVAL 5 DAY) OR date(appoint_datetime) = DATE_ADD(DATE(NOW()), INTERVAL 3 DAY)";
$result = $conn->query($sql);
$resultJSON['tbody'] = "";
if ($result->num_rows > 0) {
   while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
   		$patient_id = $row['patient_id'];
   		$sql2 = "SELECT * FROM patient WHERE patient_id = ".$patient_id;
	    $result2 = mysqli_query($conn,$sql2);
	    $row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC);
    	$resultJSON['tbody'] .= '<tr id="colT">
		<td>'.$row["patient_id"].'</td>
		<td>'.$row2["first_name"].'</td>
		<td>'.$row2["last_name"].'</td>
		<td>'.$row2["tel"].'</td>
		<td>'.'<center><img class="st-im" src="images/red.png" alt="Red"></center></td>
		</tr>';
   }
   echo json_encode($resultJSON);
}
?>