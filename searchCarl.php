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
  #username, #password, #admin_firstname, #admin_lastname, #admin_status, #admin_id, #admin_sex ,#date{
    color: black;
  }
  .st-im{
    height: 30px;
  }
  #submit {
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
  tr, td {
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
      <?php if($_SESSION['type'] == "admin") echo '<h2><a href="#">Tobercolosis Patients</a></h2>';
            else echo '<h2><a href="index.php">Tobercolosis Patients</a></h2>' ?>
      <h2>Management System</h2>
    </div>
    <nav id="mainav" class="fl_right">
      <?php require_once './components/header.php'; ?>
    </nav>
  </header>
</div>
<center><br><br>
<p>ค้นหาข้อมูลจากวันที่</p>
    <input type="hidden" id="hdnCmd" value="Carl">
    <input type="date" name="date" id="date">
    <!-- <button type="submit" class="w3-border w3-round-large" id="submit">เพิ่มข้อมูล</button> -->
    <input type="button" class="w3-border w3-round-large" id="submit"  value="เพิ่มข้อมูล"/>
    <table style="width:95%">
      <tr>
        <th>ชื่อ</p></th>
        <th>นามสกุล</p></th>
        <th>รหัสบัตรประจำตัวประชาชน</th>
        <th>เพศ</th>
        <th>น้ำหนัก</th>
        <th>ยาที่แพ้</th>
        <th>ญาติผู้ป่วย</th>
        <th>ที่อยู่</th>
        <th>เบอร์โทรศัพย์</th>
        <th>อีเมลล์</th>
        <th>สิทธิการรักษา</th>
      </tr>
      <tbody id="search"></tbody>
    </table>
</center>
<a id="backtotop" href="#top"><i class="fa fa-chevron-up"></i></a>


<script src="layout/scripts/jquery.min.js"></script>
<script src="layout/scripts/jquery.backtotop.js"></script>
<script src="layout/scripts/jquery.mobilemenu.js"></script>
<script src="layout/scripts/jquery.placeholder.min.js"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->

<script type="text/javascript">
  $(document).ready(function() {
    $("#submit").click(function(e){
    e.preventDefault();
      $.ajax({
        url: 'PHP/showCarl.php',
        type: 'GET',
        data: {
              date: $("#date").val(),
              hdnCmd: $("#hdnCmd").val()
        },
            url: 'PHP/showCarl.php',
            dataType: 'json',
            success: function(data) {
                $("#search").html(data.tbody);
            }
      });
    });
  });
  </script>
</body>
</html>