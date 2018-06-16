<?php
session_start();
if(!isset($_SESSION['logged'])) header("location: login.html");
?>
<!DOCTYPE html>
<html>
<head>
<title>MyProject</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
</head>
<style>
  #first_name, #appoint_datetime, #appointment_status {
    color: black;
  }
  .save_tr {
    margin: 40px;
  }
  #add {
    width: 150px;
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
  }
  span {
    color: black;
  }
</style>
<body id="top">
<div class="wrapper row0">
  <div id="topbar" class="hoc clear">
    <div class="fl_left">
      <ul class="nospace inline pushright">
        <li><i class="fa fa-sign-in"></i> <a href="Logout.php">Logout</a></li>
        <li><i class="fa fa-user"></i><a href="update.php"><?php echo $_SESSION['fullname'];?></a></li>
      </ul>
    </div>
    <!-- <div class="fl_right">
      <form class="clear" method="post" action="#">
        <fieldset>
          <legend>Search:</legend>
          <input type="search" value="" placeholder="Search Here&hellip;">
          <button class="fa fa-search" type="submit" title="Search"><em>Search</em></button>
        </fieldset>
      </form>
    </div> -->
  </div>
</div>
<div class="wrapper row1">
  <header id="header" class="hoc clear">
    <div id="logo" class="fl_left">
      <h2><a href="index.php">Tobercolosis Patients</a></h2>
      <h2>Management System</h2>
    </div>
    <nav id="mainav" class="fl_right">
      <?php require_once './components/header.php'; ?>
    </nav>
  </header>
</div>
<div class="">
  <main class="hoc container clear">
    <div class="content">
      <h2>เปลี่ยนสถานะการนัดหมาย</h2>
      <div class="group btmspace-50 demo">
        <!-- <div class="one_quarter first">
          รหัสการนัดหมาย : <input type="text" class="w3-border w3-round-large" id="colT" ><br>
        </div> -->
        <div class="one_quarter first">
        <form action="" method="POST">
          <input type="hidden" id="hdnCmd" name="hdnCmd" value="save">
          <input type="hidden" id="red" name="red" value="R">
          <input type="hidden" id="patient_id" name="patient_id" value="<?=$id?>"
        </div>
        <div class="one_quarter first">
          <button type="submit" name="button" class="w3-border w3-round-large" id="add">มาตามนัด</button>
        </div>
      </div>
    <div class="clear"></div>
  </main>
</div>
<a id="backtotop" href="#top"><i class="fa fa-chevron-up"></i></a>
<script src="layout/scripts/jquery.min.js"></script>
<script src="layout/scripts/jquery.backtotop.js"></script>
<script src="layout/scripts/jquery.mobilemenu.js"></script>
<script src="layout/scripts/jquery.placeholder.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" >
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pj";
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn,"utf8");
//$('#medicine_name').val($(this).text());
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_POST["hdnCmd"] == "save") {
$id = ($_GET["patient_id"]);
$sql = "SELECT * FROM appointment where patient_id = $id";
$result = $conn->query($sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
// var_dump($sql);
$stmt = $conn->prepare("UPDATE appointment SET appointment_status=? WHERE patient_id=?");
$stmt->bind_param("si", $appointment_status, $patient_id);


// set parameters and execute
$appointment_status = $_POST['red'];
$patient_id = $id;

$stmt->execute();
$stmt->close();
$conn->close();
// $search['tbody'] = "";
}
?>
</body>
</html>
