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
	/*$strSQL = "INSERT INTO admin";
	$strSQL .="(admin_id,username,password,admin_sex,admin_fname,admin_lastname,admin_status"
	$strSQL .="VALUES ";
	$strSQL .="('".$_POST["id"]."','".$_POST["username"]."','".$_POST["password"]."','".$_POST["ad_sex"]."''".$_POST["ad_firstname"]."','".$_POST["ad_lastname"]."')";*/
	//echo var_dump($_POST);
	// prepare and bind
	$username = $_POST['username'];
	$sql1= "SELECT * FROM admin WHERE username = '$username'";
	$result1 = $conn->query($sql1);
	if (mysqli_num_rows($result1) > 0) {
		$result['status'] = false;
		$result['msg'] = "ผู้ใช้งานนี้มีคนใช้แล้ว กรุณากรอกรหัสใหม่";
		echo json_encode($result);
		exit();
	}else{
	$stmt = $conn->prepare("INSERT INTO admin (username, password, admin_sex, admin_firstname, admin_lastname, admin_status) VALUES (?, ?, ?, ?, ?, ?)");
	$stmt->bind_param("ssssss", $username, $password, $admin_sex, $admin_firstname, $admin_lastname, $admin_status);

	// set parameters and execute
	$username = $_POST['username'];
	$password = md5($_POST['password']);
	$admin_sex = $_POST['admin_sex'];
	$admin_firstname = $_POST['admin_firstname'];
	$admin_lastname = $_POST['admin_lastname'];
	$admin_status = $_POST['admin_status'];

	$stmt->execute();
	$stmt->close();
	$conn->close();

	$result['status'] = true;
	$result['msg'] = "เพิ่มข้อมูลผู้ดูแลระบบเรียบร้อย";
	echo json_encode($result);
	}
}
else if ($_POST["hdnCmd"] == "updt") {

  $stmt = $conn->prepare("UPDATE admin SET admin_sex=?, admin_firstname=?, admin_lastname=?, admin_status=? WHERE admin_id=?");
	$stmt->bind_param('sssii', $admin_sex, $admin_firstname, $admin_lastname, $admin_status, $admin_id);


  // set parameters and execute
  $admin_sex = $_POST['admin_sex'];
  $admin_firstname = $_POST['admin_firstname'];
  $admin_lastname = $_POST['admin_lastname'];
  $admin_status = $_POST['admin_status'];
  $admin_id = $_SESSION['admin_id'];

	$stmt->execute();
	$stmt->close();
	$conn->close();

	$result['status'] = true;
	$result['msg'] = "แก้ไขข้อมูลผู้ดูแลระบบเรียบร้อย";
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
