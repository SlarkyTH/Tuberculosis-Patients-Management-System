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
//$date = ($_GET["date"]);
$date = $_GET["date"];
// var_dump($date);
// if ($date == ''){
	
// }
if($_GET["hdnCmd"] == "Carl"){
	$sql = "SELECT * FROM appointment WHERE DATE(appoint_datetime) = " . "'" .$date. "'";
	$result = $conn->query($sql);
	$search['tbody'] = "";
	// var_dump($sql);
	if ($result->num_rows > 0) {
		while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
			$patient_id = $row['patient_id'];
			
			$sql2 = "SELECT * FROM patient WHERE patient_id = ".$patient_id;
			
			// $first_name = $row['first_name'];
			//$sql3 = "SELECT doctor.first_name, doctor.last_name, appointment.appoint_datetime FROM doctor, appointment WHERE doctor.doctor_id = appointment.doctor_id";
			$result2 = mysqli_query($conn,$sql2);
			$row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC);
			//$result3 = mysqli_query($conn,$sql3);
			//$row3 = mysqli_fetch_array($result3,MYSQLI_ASSOC);
			
			if ($row2["sex"] == 'M') {
			$row2["sex"] = "ชาย";
			}
			else {
			$row2["sex"] = "หญิง";
			}
			if ($row2["privilege"] == '0') {
			$row2["privilege"] = "ไม่มีสิทธิการรักษา";
			}
			else if ($row2["privilege"] == '1') {
			$row2["privilege"] = "สิทธิสวัสดิการการรักษาพยาบาลของพยาบาล";
			}
			else if ($row2["privilege"] == '2') {
			$row2["privilege"] = "สิทธิประกันสังคม";
			}
			else {
			$row2["privilege"] = "สิทธิหลักประกันสุขภาพ 30 บาท";
			}
			
			$search['tbody'] .= '<tr id="colT">
			<td>'.$row2["first_name"].'</td>
			<td>'.$row2["last_name"].'</td>
			<td>'.$row2["national_id"].'</td>
			<td>'.$row2["sex"].'</td>
			<td>'.$row2["weight"].'</td>
			<td>'.$row2["allergic"].'</td>
			<td>'.$row2["parent_name"].'</td>
			<td>'.$row2["address"].'</td>
			<td>'.$row2["tel"].'</td>
			<td>'.$row2["email"].'</td>
			<td>'.$row2["privilege"].'</td>
			</tr>';
		}
		echo json_encode($search);
	}
}
?>