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

// var_dump($_POST["hdnCmd"]);

if($_POST["hdnCmd"] == "Add")
{
	/*$strSQL = "INSERT INTO admin";
	$strSQL .="(admin_id,username,password,admin_sex,admin_fname,admin_lastname,admin_status"
	$strSQL .="VALUES ";
	$strSQL .="('".$_POST["id"]."','".$_POST["username"]."','".$_POST["password"]."','".$_POST["ad_sex"]."''".$_POST["ad_firstname"]."','".$_POST["ad_lastname"]."')";*/
	//echo var_dump($_POST);
	// prepare and bind
	$stmt = $conn->prepare("INSERT INTO medicine (medicine_name) VALUES (?)");
	$stmt->bind_param("s", $medicine_name);

	// set parameters and execute
	$medicine_name = $_POST['medicine_name'];
	// $unit_id = $_POST['unit_id'];

	$stmt->execute();
	$stmt->close();
	$conn->close();

	$result['status'] = true;
	$result['msg'] = "Insert medicine Success";
	echo json_encode($result);

}

else if ($_POST["hdnCmd"] == "updt") {

  // var_dump($_POST['medicine_name'] . '-'. $_POST['medicine_id']. '-'. $_POST['unit_id']);
  // set parameters and execute
  $medicine_name = $_POST['medicine_name'];
//   $unit_id = $_POST['unit_id'];
  $medicine_id = $_POST['medicine_id'];

  $stmt = $conn->prepare("UPDATE medicine SET medicine_name=? WHERE medicine_id=?");
	$stmt->bind_param("si", $medicine_name, $medicine_id);

	$stmt->execute();
	$stmt->close();
	$conn->close();

	$result['status'] = true;
	$result['msg'] = "แก้ไขข้อมูลยาเรียบร้อย";
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
