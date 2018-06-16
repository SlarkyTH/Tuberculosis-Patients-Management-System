<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pj";
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn,"utf8");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$typeuser = mysqli_real_escape_string($conn,$_POST['type']);
if ($typeuser == 'admin'){
	$myusername = mysqli_real_escape_string($conn,$_POST['username']);
    $mypassword = md5(mysqli_real_escape_string($conn,$_POST['password']));

    $sql = "SELECT * FROM admin WHERE username = '$myusername' and password = '$mypassword'";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    //$active = $row['active'];

    $count = mysqli_num_rows($result);
    if($count == 1) {
    	$result2['status'] = true;
    	$_SESSION['type'] = "admin";
    	$_SESSION['logged'] = true;
    	$_SESSION['fullname'] = $_SESSION['type'].': '.$row['admin_firstname'].'  '.$row['admin_lastname'];
        $_SESSION['password'] = $row['password'];
        $_SESSION['admin_firstname'] = $row['admin_firstname'];
        $_SESSION['admin_lastname'] = $row['admin_lastname'];
        $_SESSION['admin_status'] = $row['admin_status'];
        $_SESSION['admin_sex'] = $row['admin_sex'];
        $_SESSION['admin_id'] = $row['admin_id'];
        $result2['type'] = "admin";
    }else {
    $result2['status'] = false;
    }
    echo json_encode($result2);
	}
if ($typeuser == 'doctor'){
    $myusername = mysqli_real_escape_string($conn,$_POST['username']);
    $mypassword = md5(mysqli_real_escape_string($conn,$_POST['password']));

    $sql = "SELECT * FROM doctor WHERE doctor_username = '$myusername' and doctor_password = '$mypassword'";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    //$active = $row['active'];

    $count = mysqli_num_rows($result);
    if($count == 1) {
        $result2['status'] = true;
        $_SESSION['type'] = "doctor";
        $_SESSION['logged'] = true;
        $_SESSION['fullname'] = $_SESSION['type'].': '.$row['first_name'].'  '.$row['last_name'];
        $_SESSION['doctor_id'] = $row['doctor_id'];
        $_SESSION['first_name'] = $row['first_name'];
        $_SESSION['last_name'] = $row['last_name'];
        $_SESSION['doctor_password'] = $row['doctor_password'];
        $_SESSION['tel'] = $row['tel'];
        $_SESSION['email'] = $row['email'];
        $result2['type'] = "doctor";
    }else {
         $result2['status'] = false;
    }
    echo json_encode($result2);
    }
if ($typeuser == 'nurse'){
    $myusername = mysqli_real_escape_string($conn,$_POST['username']);
    $mypassword = md5(mysqli_real_escape_string($conn,$_POST['password']));

    $sql = "SELECT * FROM nurse WHERE nurse_username = '$myusername' and nurse_password = '$mypassword'";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    //$active = $row['active'];

    $count = mysqli_num_rows($result);
    if($count == 1) {
        $result2['status'] = true;
        $_SESSION['type'] = "nurse";
        $_SESSION['logged'] = true;
        $_SESSION['fullname'] = $_SESSION['type'].': '.$row['first_name'].'  '.$row['last_name'];
        $_SESSION['nurse_id'] = $row['nurse_id'];
        $_SESSION['first_name'] = $row['first_name'];
        $_SESSION['last_name'] = $row['last_name'];
        $_SESSION['nurse_password'] = $row['nurse_password'];
        $_SESSION['tel'] = $row['tel'];
        $_SESSION['email'] = $row['email'];
        $result2['type'] = "nurse";
    }else {
         $result2['status'] = false;
    }
    echo json_encode($result2);
    }
// $sql = "SELECT * FROM admin";
// $result = $conn->query($sql);

// if ($result->num_rows > 0) {
//     while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
//     	echo '<tr>
// 			<td>'.$row["username"].'</td>
// 			<td>'.$row["password"].'</td>
// 			</tr>';
//     	}
// 	} else {
//     	echo "0 results";
// }
$conn->close();
?>
