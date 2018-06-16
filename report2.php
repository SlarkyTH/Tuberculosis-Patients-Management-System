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
  #colT, span {
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
<center><br>รายงานการรักษาของผู้ป่วยในเเต่ละคน</h><br><br>
<!-- ชื่อผู้ป่วย :<select class="js-example-basic-single" id="patient_id" name="patient_id" style="width: 348px;"></select></center> -->
<center><table style="width:80%">
<tr>
  <th>รหัสผู้ป่วย</th>
  <th>ชื่อ</p></th>
  <th>นามสกุล</th>
  <th>รหัสบัตรประจำตัวประชาชน</th>
  <th>การแพ้ยา</th>
  <th>อาการ</th>
  <th>แพทย์ที่รักษา</th>
  <th>สถานะ</th>
</tr>
<tbody id="showReport2">
</tbody>
</table></center>
<a id="backtotop" href="#top"><i class="fa fa-chevron-up"></i></a>
<script src="layout/scripts/jquery.min.js"></script>
<script src="layout/scripts/jquery.backtotop.js"></script>
<script src="layout/scripts/jquery.mobilemenu.js"></script>
<script src="layout/scripts/jquery.placeholder.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $.ajax({
          url: 'PHP/showReport2.php',
          dataType: 'json',
          success: function(data) {
              $("#showReport2").html(data.tbody);
          },
          type: 'GET'
    });
    $(".js-example-basic-single").select2({
      ajax: {
        dataType: 'json',
        url: './PHP/getTreatment.php',
        delay: 250,
        data: function (params) {
          return {
            //alert(params.term);
            q: params.term,
            page: params.page
          };
        },
        processResults: function (data, params) {
          //alert(data);
          params.page = params.page || 1;
          return {
            results: data,
              pagination: {
                more: (params.page * 30) < data.total_count
              }
          };
        }
      }
    });
  });
</script>
</body>
</html>
