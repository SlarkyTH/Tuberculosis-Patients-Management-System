<?php

session_start();
if (!isset($_SESSION['logged']))
    header("location: login.html");
?>
<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pj";
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn, "utf8");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_GET['wid']))
    return;

$stmt = $conn->prepare("DELETE FROM working_date WHERE no = ? ");
$stmt->bind_param("i", $no);

$no = $_GET['wid'];

$stmt->execute();
$stmt->close();

$conn->close();
header("Location:workdatetime.php");
?>
