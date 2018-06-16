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
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
</head>
<style>
#colT, #sl_date {
    color: black;
  }
#ok {
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
        <li><i class="fa fa-sign-in"></i> <a href="Logout.php">Logout</a></li>
        <li><a href="update.php"><?php echo $_SESSION['fullname'];?></a></li>
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
<center><p>รายงานรายชื่อผู้ป่วยในเเต่ละวัน</p>
<!-- <input type="date" class="w3-border w3-round-large" id="sl_date" name="sl_date" style="width: 348px;">
<button type="submit" class="w3-border w3-round-large" id="ok" name="ok">ตกลง</button></center><br> -->
<center><table style="width:80%">
<tr>
  <th>รหัสผู้ป่วย</th>
  <th>ชื่อ</p></th>
  <th>นามสกุล</th>
  <th>ที่อยู่</th>
  <th>เบอร์โทร</th>
  <th>อีเมลล์</th>
</tr>
<tbody id="showReport1">
</tbody>
</table></center>
<a id="backtotop" href="#top"><i class="fa fa-chevron-up"></i></a>
<script src="layout/scripts/jquery.min.js"></script>
<script src="layout/scripts/jquery.backtotop.js"></script>
<script src="layout/scripts/jquery.mobilemenu.js"></script>
<script src="layout/scripts/jquery.placeholder.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $.ajax({
          url: 'PHP/showReport1.php',
          dataType: 'json',
          success: function(data) {
              $("#showReport1").html(data.tbody);
          },
          type: 'GET'
    });
    
  });
</script>
</body>
</html>
