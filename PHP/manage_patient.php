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
	$stmt = $conn->prepare("INSERT INTO patient (patient_status, first_name, last_name, national_id, sex, parent_name, address, tel, email, weight, privilege, allergic, nurse_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$stmt->bind_param("sssssssssiisi", $patient_status, $first_name, $last_name, $national_id, $sex, $parent_name, $address, $tel, $email, $weight, $privilege, $allergic, $nurse_id);

	// set parameters and execute
	$patient_status = $_POST['patient_status'];
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$national_id = $_POST['national_id'];
	$sex = $_POST['sex'];
	$parent_name = $_POST['parent_name'];
	$address = $_POST['address'];
	$tel = $_POST['tel'];
	$email = $_POST['email'];
	$weight = $_POST['weight'];
	$privilege = $_POST['privilege'];
	$allergic = $_POST['allergic'];
	$nurse_id = $_SESSION['nurse_id'];

	$stmt->execute();
	$stmt->close();
	$conn->close();

	$result['status'] = true;
	$result['msg'] = "เพิ่มข้อมูลผู้ป่วยเรียบร้อย";
	echo json_encode($result);

}
else if ($_POST["hdnCmd"] == "updt") {

  // var_dump($_SESSION['nurse_id']);

  $stmt = $conn->prepare("UPDATE patient SET patient_status=?, first_name=?, last_name=?, national_id=?, sex=?, parent_name=?,
    address=?, tel=?, email=?, weight=?, privilege=?, allergic=?, nurse_id=? WHERE patient_id=?");
	$stmt->bind_param("issssssssiisii", $patient_status, $first_name, $last_name, $national_id, $sex, $parent_name, $address, $tel, $email,
    $weight, $privilege, $allergic, $nurse_id, $patient_id);


    // set parameters and execute
    $patient_id = $_POST['patient_id'];
  	$patient_status = $_POST['patient_status'];
  	$first_name = $_POST['first_name'];
  	$last_name = $_POST['last_name'];
  	$national_id = $_POST['national_id'];
  	$sex = $_POST['sex'];
  	$parent_name = $_POST['parent_name'];
  	$address = $_POST['address'];
  	$tel = $_POST['tel'];
  	$email = $_POST['email'];
  	$weight = $_POST['weight'];
  	$privilege = $_POST['privilege'];
  	$allergic = $_POST['allergic'];
  	$nurse_id = $_SESSION['nurse_id'];

	$stmt->execute();
	$stmt->close();
	$conn->close();

	$result['status'] = true;
	$result['msg'] = "แก้ไขข้อมูลผู้ป่วยเรียบร้อย";
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
