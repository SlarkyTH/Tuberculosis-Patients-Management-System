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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $("form").submit(function(e){
      e.preventDefault();
      $.ajax({
          url: 'PHP/manage_nurse.php',
          data: {
            hdnCmd: $("#hdnCmd").val(),
            nurse_password: $("#nurse_password").val(),
            sex: $("#sex").val(),
            first_name: $("#first_name").val(),
            last_name: $("#last_name").val(),
            nurse_status: $("#nurse_status").val(),
            tel: $("#tel").val(),
            email: $("#email").val()
          },
          dataType: 'json',
          success: function(data) {
            if(data.status == true) {
              $("#result").html(data.msg);
            }
          },
          type: 'POST'
      });
      $.ajax({
          url: 'PHP/manage_doctor.php',
          data: {
            hdnCmd: $("#hdnCmd").val(),
            doctor_password: $("#doctor_password").val(),
            sex: $("#sex").val(),
            first_name: $("#first_name").val(),
            last_name: $("#last_name").val(),
            doctor_status: $("#doctor_status").val(),
            tel: $("#tel").val(),
            email: $("#email").val()
          },
          dataType: 'json',
          success: function(data) {
            if(data.status == true) {
              $("#result").html(data.msg);
            }
          },
          type: 'POST'
      });
      $.ajax({
          url: 'PHP/manage_admin.php',
          data: {
            hdnCmd: $("#hdnCmd").val(),
            password: $("#password").val(),
            admin_sex: $("#admin_sex").val(),
            admin_firstname: $("#admin_firstname").val(),
            admin_lastname: $("#admin_lastname").val(),
            admin_status: $("#admin_status").val()
          },
          dataType: 'json',
          success: function(data) {
            if(data.status == true) {
              $("#result").html(data.msg);
            }
          },
          type: 'POST'
      });
    });
  });
</script>
</head>
<style>
  #nurse_password, #first_name, #last_name, #nurse_status, #sex, #tel, #email, #doctor_password, #doctor_status, #admin_status
  , #admin_firstname, #admin_lastname, #password, #admin_sex {
    color: black;
  }
  /* .st-im{
    height: 30px;
  } */
  #add_user {
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
</style>
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
      <?php if($_SESSION['type'] == "admin") echo '<h2><a href="#">Tobercolosis Patients</a></h2>';
            else echo '<h2><a href="index.php">Tobercolosis Patients</a></h2>' ?>
      <h2>Management System</h2>
    </div>
    <nav id="mainav" class="fl_right">
      <?php require_once './components/header.php'; ?>
    </nav>
  </header>
</div>
<center><p>แก้ไขข้อมูลส่วนตัว</p></center>
<div class="">
  <main class="hoc container clear">
    <div class="content">
      <div class="group btmspace-50 demo">
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
          if($_SESSION['type'] == 'nurse') {

            $sql1 = "SELECT * FROM nurse";
            $result1 = mysqli_query($conn, $sql1);
            $conn->close();
            ?>
            <form action="PHP/manage_nurse.php" method="POST">
              <div class="one_quarter first">
                <input type="hidden" id="hdnCmd" name="hdnCmd" value="updt">
                <!-- <input type="hidden" id="admin_status" value="1"> -->
              </div>
              <div class="one_quarter first">
                ชื่อ : <input type="text" class="w3-border w3-round-large" name="first_name" id="first_name" value="<?php echo $_SESSION['first_name'];?>"><br>
                นามสกุล : <input type="text" class="w3-border w3-round-large" name="last_name" id="last_name" value="<?php echo $_SESSION['last_name'];?>"><br>
                เพศ : <select class="w3-border w3-round-large"  id="sex" name="sex"><br>
                  <option value="M">ชาย</option>
                  <option value="F">หญิง</option>
                </select><br>
                <!-- รหัสผู้ใช้งาน : <input type="password" class="w3-border w3-round-large" name="nurse_password" id="nurse_password" value="<?php echo $_SESSION['nurse_password'];?> "><br> -->
                เบอร์โทร : <input type="text" class="w3-border w3-round-large" name="tel" id="tel" value="<?php echo $_SESSION['tel'];?>"><br>
                อีเมล์ : <input type="text" class="w3-border w3-round-large" name="email" id="email" value="<?php echo $_SESSION['email'];?>"><br>
                สถานะ : <select class="w3-border w3-round-large"  id="nurse_status" name="nurse_status"><br>
                  <option value="1">Activate</option>
                  <option value="0">Deactive</option>
                </select><br>
                <button type="submit" class="w3-border w3-round-large" id="add_user">บันทึกข้อมูล</button><br><br>
                <span id="result"></span>
              </div>
            </form>
            <?php }
          ?>
          <?php
          if($_SESSION['type'] == 'doctor') {
            $sql1 = "SELECT * FROM doctor";
            $result1 = mysqli_query($conn, $sql1);
            $conn->close();
            ?>
            <form action="PHP/manage_doctor.php" method="POST">
              <div class="one_quarter first">
                <input type="hidden" id="hdnCmd" name="hdnCmd" value="updt">
                <!-- <input type="hidden" id="admin_status" value="1"> -->
              </div>
              <div class="one_quarter first">
                ชื่อ : <input type="text" class="w3-border w3-round-large" name="first_name" id="first_name" value="<?php echo $_SESSION['first_name'];?>"><br>
                นามสกุล : <input type="text" class="w3-border w3-round-large" name="last_name" id="last_name" value="<?php echo $_SESSION['last_name'];?>"><br>
                เพศ : <select class="w3-border w3-round-large"  id="sex" name="sex"><br>
                  <option value="M">ชาย</option>
                  <option value="F">หญิง</option>
                </select><br>
                <!-- รหัสผู้ใช้งาน : <input type="password" class="w3-border w3-round-large" name="doctor_password" id="doctor_password" value="<?php echo $_SESSION['doctor_password'];?> "><br> -->
                เบอร์โทร : <input type="text" class="w3-border w3-round-large" name="tel" id="tel" value="<?php echo $_SESSION['tel'];?>"><br>
                อีเมล์ : <input type="text" class="w3-border w3-round-large" name="email" id="email" value="<?php echo $_SESSION['email'];?>"><br>
                สถานะ : <select class="w3-border w3-round-large"  id="doctor_status" name="doctor_status"><br>
                  <option value="1">Activate</option>
                  <option value="0">Deactive</option>
                </select><br>
                <button type="submit" class="w3-border w3-round-large" id="add_user">บันทึกข้อมูล</button><br><br>
                <span id="result"></span>
              </div>
            </form>
          <?php } ?>
          <?php
          if ($_SESSION['type'] == 'admin') {
            $sql1 = "SELECT * FROM admin";
            $result1 = mysqli_query($conn, $sql1);
            $conn->close();
            ?>
            <form action="PHP/manage_admin.php" method="POST">
              <div class="one_quarter first">
                <input type="hidden" id="hdnCmd" name="hdnCmd" value="updt">
                <!-- <input type="hidden" id="admin_status" value="1"> -->
              </div>
              <div class="one_quarter first">
                ชื่อ : <input type="text" class="w3-border w3-round-large" name="admin_firstname" id="admin_firstname" value="<?php echo $_SESSION['admin_firstname'];?>"><br>
                นามสกุล : <input type="text" class="w3-border w3-round-large" name="admin_lastname" id="admin_lastname" value="<?php echo $_SESSION['admin_lastname'];?>"><br>
                เพศ : <select class="w3-border w3-round-large"  id="admin_sex" name="admin_sex"><br>
                  <option value="M">ชาย</option>
                  <option value="F">หญิง</option>
                </select><br>
                <!-- รหัสผู้ใช้งาน : <input type="password" class="w3-border w3-round-large" name="password" id="password" value="<?php echo $_SESSION['password'];?> "><br> -->
                สถานะ : <select class="w3-border w3-round-large"  id="admin_status" name="admin_status"><br>
                  <option value="1">Activate</option>
                  <option value="0">Deactive</option>
                </select><br>
                <button type="submit" class="w3-border w3-round-large" id="add_user">บันทึกข้อมูล</button><br><br>
                <span id="result"></span>
              </div>
            </form>
            <?php } ?>
      </div>
    </div>
  </main>
</div>
<a id="backtotop" href="#top"><i class="fa fa-chevron-up"></i></a>
<script src="layout/scripts/jquery.min.js"></script>
<script src="layout/scripts/jquery.backtotop.js"></script>
<script src="layout/scripts/jquery.mobilemenu.js"></script>
<script src="layout/scripts/jquery.placeholder.min.js"></script>

</body>
</html>
