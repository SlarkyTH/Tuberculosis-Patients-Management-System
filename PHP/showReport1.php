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

$sql = "SELECT * FROM appointment WHERE DATE(appoint_datetime) = DATE(NOW())";
$result = $conn->query($sql);
$resultJSON['tbody'] = "";
if ($result->num_rows > 0) {
   while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
   		$patient_id = $row['patient_id'];
   		$sql2 = "SELECT * FROM patient WHERE patient_id = ".$patient_id;
   		// $first_name = $row['first_name'];
   		$sql3 = "SELECT doctor.first_name,doctor.last_name,appointment.appoint_datetime FROM doctor, appointment WHERE doctor.doctor_id = appointment.doctor_id";
	    $result2 = mysqli_query($conn,$sql2);
	    $row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC);
	    $result3 = mysqli_query($conn,$sql3);
	    $row3 = mysqli_fetch_array($result3,MYSQLI_ASSOC);
    	$resultJSON['tbody'] .= '<tr id="colT">
		<td>'.$row2["patient_id"].'</td>
		<td>'.$row2["first_name"].'</td>
		<td>'.$row2["last_name"].'</td>
		<td>'.$row2["address"].'</td>
		<td>'.$row2["tel"].'</td>
		<td>'.$row2["email"].'</td>
		</tr>';
   }
   echo json_encode($resultJSON);
}
//<td>'.$row["patient_id"].'</td>
?>