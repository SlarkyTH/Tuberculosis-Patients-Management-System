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
<link href="../layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
    //   $.ajax({
    //     url: '../PHP/getLastID_nur.php',
    //     dataType: 'json',
    //     success: function(data) {
    //       if(data.status == true) {
    //         $("#nurse_id").val(data.last_ID);
    //       }
    //     }
    //   });

    $("form").submit(function(e){
      e.preventDefault();
      if($("#nurse_username").val().length < 3 || $("#nurse_password").val().length < 3 || $("#first_name").val().length < 3 || $("#last_name").val().length < 3)
      {
        alert("คุณกรอกข้อมูลไม่ครบถ้วน กรุณากรอกให้ครบ");
        return;
      }
      $.ajax({
          url: '../PHP/manage_nurse.php',
          data: {
            nurse_username: $("#nurse_username").val(),
            nurse_password: $("#nurse_password").val(),
            sex: $("#sex").val(),
            first_name: $("#first_name").val(),
            last_name: $("#last_name").val(),
            nurse_status: $("#nurse_status").val(),
            tel: $("#tel").val(),
            email: $("#email").val(),
            hdnCmd: $("#hdnCmd").val()
          },
          dataType: 'json',
          success: function(data) {
            if(data.status == true) {
              $("#result").html(data.msg);
              //location.reload();
            }
            else if(data.status != true) {
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
  #nurse_username, #nurse_password, #first_name, #last_name, #nurse_status, #tel, #email, #sex, 
  #nurse_id {
    color: black;
  }
  .st-im{
    height: 30px;
  }
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
<body id="top">
<div class="wrapper row0">
  <div id="topbar" class="hoc clear">
    <div class="fl_left">
      <ul class="nospace inline pushright">
        <li><i class="fa fa-sign-in"></i> <a href="../Logout.php">Logout</a></li>
        <li><i class="fa fa-user"></i><a href="../update.php"><?php echo $_SESSION['fullname'];?></a></li>
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
      <h2><a href="#">Tobercolosis Patients</a></h2>
      <h2>Management System</h2>
    </div>
    <nav id="mainav" class="fl_right">
      <ul class="clear">
        <li><a class="drop" href="#">จัดการข้อมูลผู้ใช้งานระบบ</a>
          <ul>
            <li><a href="upAdmin.php">ข้อมูลผู้ดูแลระบบ</a></li>
            <li><a href="upDoctor.php">ข้อมูลเเพทย์</a></li>
            <li><a href="upNurse.php">ข้อมูลพยาบาล</a></li>
          </ul>
        </li>
      </ul>
  </header>
</div>
<div class="">
  <main class="hoc container clear">
    <div class="content">
      <h2>ข้อมูลพยาบาล</h2>
      <div class="group btmspace-50 demo">
        <form action="../PHP/manage_nurse.php" method="POST">
        <div class="one_quarter first">
          <input type="hidden" id="hdnCmd" value="Add" name="hdnCmd">
          <input type="hidden" id="nurse_status" value="1">
        </div>
        <div class="one_quarter first">
          <!-- รหัสพยาบาล : <input type="text" class="w3-border w3-round-large" name="nurse_id" id="nurse_id" readonly disabled><br> -->
          ชื่อผู้ใช้งาน : <input type="text" class="w3-border w3-round-large" id="nurse_username" required><br>
          รหัสผู้ใช้งาน : <input type="password" class="w3-border w3-round-large" id="nurse_password" required><br>
          ชื่อ : <input type="text" class="w3-border w3-round-large" name="first_name" id="first_name" required><br>
          นามสกุล : <input type="text" class="w3-border w3-round-large" name="last_name" id="last_name" required><br>
          เพศ : <select class="w3-border w3-round-large"  id="sex" name="sex"><br>
            <option value="M">ชาย</option>
            <option value="F">หญิง</option>
          </select><br>
          เบอร์โทร : <input type="text" class="w3-border w3-round-large" name="tel" id="tel" required><br>
          อีเมล์ : <input type="text" class="w3-border w3-round-large" name="email" id="email" required><br>
          <button type="submit" class="w3-border w3-round-large" id="add_user">เพิ่มข้อมูล</button><br>
          <span id="result"></span>
        </div>
      </form>
      </div>
    </div>
    <div class="clear"></div>
  </main>
</div>
<a id="backtotop" href="#top"><i class="fa fa-chevron-up"></i></a>
<script src="../layout/scripts/jquery.min.js"></script>
<script src="../layout/scripts/jquery.backtotop.js"></script>
<script src="../layout/scripts/jquery.mobilemenu.js"></script>
<script src="../layout/scripts/jquery.placeholder.min.js"></script>
</body>
</html>
