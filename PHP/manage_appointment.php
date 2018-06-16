<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pj";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn,"utf8");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
if($_POST["hdnCmd"] == "Add")
{
	$stmt = $conn->prepare("INSERT INTO appointment (patient_id, doctor_id, appoint_datetime, appointment_status) VALUES (?, ?, ?, ?)");
	$stmt->bind_param("iiss", $patient_id, $doctor_id, $appoint_datetime, $appointment_status);

	// set parameters and execute
	$patient_id = $_POST['patient_id'];
	$doctor_id = $_SESSION['doctor_id'];
	$appoint_datetime = $_POST['appoint_datetime'];
	$appointment_status = $_POST['appointment_status'];

	$stmt->execute();
	$stmt->close();
	$conn->close();

	$result['status'] = true;
	$result['msg'] = "Insert Appointment Success";
	echo json_encode($result);

}
/*if($_POST["hdnCmd"] == "Edit")
{
	$stmt = $conn->prepare("UPDATE admin SET (username, password, admin_sex, admin_firstname, admin_lastname, admin_status) VALUES (?, ?, ?, ?, ?, ?)");
	$stmt->bind_param("ssssss", $username, $password, $admin_sex, $admin_firstname, $admin_lastname, $admin_status);

	// set parameters and execute
	$username = $_POST['username'];
	$password = $_POST['password'];
	$admin_sex = $_POST['admin_sex'];
	$admin_firstname = $_POST['admin_firstname'];
	$admin_lastname = $_POST['admin_lastname'];
	$admin_status = $_POST['admin_status'];

	$stmt->execute();
	$stmt->close();
	$conn->close();

	$result['status'] = true;
	$result['msg'] = "Edit Success";
	echo json_encode($result);

}
/*$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["user_id"]. " - status " . $row["user_status"]. " - Name: " . $row["first_name"]. " " . $row["last_name"]. " sex: " . $row["sex"]. " tel: " . $row["tel"]. " email: " . $row["email"]. " admin id: " . $row["admin_id"]. "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();*/
?>