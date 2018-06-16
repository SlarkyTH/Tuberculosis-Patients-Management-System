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
  .dropdown {
    position: relative;
    display: inline-block;
  }
  /* h2 {
    font-size: 2vw;
  }
  h1{
    font-size: 2vw;
  }
  p{
    font-size: 1.5vw; */
  }
  .dropdown-content {
    text-align: center;
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    /* min-width: 160px; */
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
  }

  .dropdown:hover .dropdown-content {
      display: block;
  }

  tr, td{
    color: black;
    text-align: center;
    /* font-size: 1.5vw; */
  }

  #colT {
    color: black;
  }

  .st-im{
    height: 30px;
  }

/*  #delay {
    transition-delay: 5s;
}*/
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
    <div class="fl_right">
      <form class="clear" method="GET" action="search.php">
        <fieldset>
          <legend>Search:</legend>
          <a href="searchCarl.php"><img class="st-im" src="images/car.png"></a>
          <select class="js-example-basic-single" id="patient_id" name="patient_id" style="width: 348px; right: 0px;">
          </select>
          <!--<input type="search" value="" placeholder="Search Here&hellip;">-->
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
<center>
<!--<?php echo date("d-m-Y");?>-->
<br><h1>รายการนัดหมายผู้ป่วย</h1>

<p>อีก 7 วันถึงวันนัดหมาย</p>
<table style="width:80%">
<tr>
  <th>นัดโดย</th>
  <th>วันนัด</th>
  <th>วันเลื่อนนัด</th>
  <th>ชื่อ</p></th>
  <th>นามสกุล</p></th>
  <th>เบอร์โทร</th>
  <th>สถานะ</th>
</tr>
<tbody id="showAppointment3"></tbody>
</table>

<p>อีก 5 วันถึงวันนัดหมาย</p>
<table style="width:80%">
<tr>
  <th>นัดโดย</th>
  <th>วันนัด</th>
  <th>วันเลื่อนนัด</th>
  <th>ชื่อ</p></th>
  <th>นามสกุล</p></th>
  <th>เบอร์โทร</th>
  <th>สถานะ</th>
</tr>
<tbody id="showAppointment2"></tbody>
</table>

<p>อีก 3 วันถึงวันนัดหมาย</p>
<table style="width:80%">
<tr>
  <th>นัดโดย</th>
  <th>วันนัด</th>
  <th>วันเลื่อนนัด</th>
  <th>ชื่อ</p></th>
  <th>นามสกุล</p></th>
  <th>เบอร์โทร</th>
  <th>สถานะ</th>
  <!-- <th>เลื่อนนัด</th> -->
</tr>
<tbody id="showAppointment"></tbody>
</table>

<p>นัดหมายวันนี้</p>
<table style="width:80%">
<tr>
  <th>นัดโดย</th>
  <th>วันนัด</th>
  <th>วันเลื่อนนัด</th>
  <th>ชื่อ</p></th>
  <th>นามสกุล</p></th>
  <th>เบอร์โทร</th>
  <th>สถานะ</th>
</tr>
<tbody id="showAppointment4"></tbody>
</table>
</center>

<!-- <div class="dropdown">
  <img src="images/green.png" width="5" height="5">
  <div class="dropdown-content">
    <a href=""><img src="images/yellow.png" ></a>
    <a href=""><img src="images/green.png"></a>
  </div>
</div> -->

<a id="backtotop" href="#top"><i class="fa fa-chevron-up"></i></a>
<script src="layout/scripts/jquery.min.js"></script>
<script src="layout/scripts/jquery.backtotop.js"></script>
<script src="layout/scripts/jquery.mobilemenu.js"></script>
<script src="layout/scripts/jquery.placeholder.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $.ajax({
      type: 'GET',
      data: {
            day: 3
      },
          url: 'PHP/showAppointment.php',
          dataType: 'json',
          success: function(data) {
              $("#showAppointment").html(data.tbody);
          }
    });
    $.ajax({
      type: 'GET',
      data: {
            day: 5
      },
          url: 'PHP/showAppointment.php',
          dataType: 'json',
          success: function(data) {
              $("#showAppointment2").html(data.tbody);
          }
    });

    $.ajax({
      type: 'GET',
      data: {
            day: 7
      },
          url: 'PHP/showAppointment.php',
          dataType: 'json',
          success: function(data) {
              $("#showAppointment3").html(data.tbody);
          }
    });

    $.ajax({
      type: 'GET',
      data: {
            day: 1
      },
          url: 'PHP/showAppointment.php',
          dataType: 'json',
          success: function(data) {
              $("#showAppointment4").html(data.tbody);
          }
    });
    $(".js-example-basic-single").select2({
      ajax: {
        dataType: 'json',
          url: './PHP/getSearch.php',
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