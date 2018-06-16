<?php
session_start();
if(!isset($_SESSION['logged'])) header("location: login.html");
?>
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
$id = ($_GET["medicine_id"]);
$sql = "SELECT * FROM medicine where medicine_id = $id";
$result = $conn->query($sql);
// $search['tbody'] = "";
if ($result->num_rows > 0) {
 	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
    // var_dump($row["medicine_name"]);
    $medicine_name = $row["medicine_name"];
 	}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>MyProject</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
      // $.ajax({
      //   url: '../PHP/getLastID_med.php',
      //   dataType: 'json',
      //   success: function(data) {
      //     if(data.status == true) {
      //       $("#medicine_id").val(data.last_ID);
      //     }
      //   }
      // });

    $("form").submit(function(e){
      e.preventDefault();
      // if($("#nurse_username").val().length < 3 || $("#nurse_password").val().length < 3 || $("#first_name").val().length < 3 || $("#last_name").val().length < 3)
      // {
      //   alert("คุณกรอกข้อมูลไม่ครบถ้วน กรุณากรอกให้ครบ");
      //   return;
      // }
      $.ajax({
          url: 'PHP/manage_medicine.php',
          data: {
            medicine_id : $("#medicine_id").val(),
            medicine_name: $("#medicine_name").val(),
            unit_id: $("#unit_id").val(),
            hdnCmd: $("#hdnCmd").val()
          },
          dataType: 'json',
          success: function(data) {
            if(data.status == true) {
              $("#result").html(data.msg);
              //location.reload();
            }
          },
          type: 'POST'
      });
    });
  });
</script>
</head>
<style>
  #unit_name, #medicine_name, #unit_id {
    color: black;
  }
  #editMedicine {
    background-color: #fff15e;
    border: none;
    color: black;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
  }
</style>
<body id="top">
<div class="wrapper row0">
  <div id="topbar" class="hoc clear">
    <div class="fl_left">
      <ul class="nospace inline pushright">
        <li><i class="fa fa-sign-in"></i> <a href="Logout.php">Logout</a></li>
        <li><a href="update.php"><?php echo $_SESSION['fullname'];?></a></li>
      </ul>
    </div>
    <div class="fl_right">
      <form class="clear" method="post" action="#">
        <fieldset>
          <legend>Search:</legend>
          <input type="search" value="" placeholder="Search Here&hellip;">
          <button class="fa fa-search" type="submit" title="Search"><em>Search</em></button>
        </fieldset>
      </form>
    </div>
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
      <h2>ข้อมูลยา</h2>
      <div class="group btmspace-50 demo">
        <form action="" method="POST">
        <div class="one_quarter first">
          <input type="hidden" id="hdnCmd" name="hdnCmd" value="updt">
          <input type="hidden" id="medicine_id" name="medicine_id" value="<?=$id ?>">
          ชื่อสามัญยา : <input type="text" class="w3-border w3-round-large" id="medicine_name" name="medicine_name" value="<?=$medicine_name ?>"><br>
          <!-- หน่วยยา : <select class="w3-border w3-round-large" id="unit_id" name="unit_id">
            <option value="1">มิลลิลิตร</option>
            <option value="2">ออนซ์ </option>
            <option value="3">มิลลิกรัม</option>
            <option value="4">กรัม</option>
            <option value="5">เม็ด</option>
            <option value="6">แผง</option>
          </select><br> -->
          <button type="submit" class="w3-border w3-round-large" id="editMedicine">แก้ไขข้อมูล</button>
          <br><span id="result"></span>
        </div>
      </form>
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
</body>
</html>
