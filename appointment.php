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
  #appoint_datetime {
    color: black;
  }
  .save_tr {
    margin: 40px;
  }
  #add {
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
      <h2>การนัดหมาย</h2>
      <div class="group btmspace-50 demo">
        <!-- <div class="one_quarter first">
          รหัสการนัดหมาย : <input type="text" class="w3-border w3-round-large" id="colT" ><br>
        </div> -->
        <div class="one_quarter first">
          <input type="hidden" id="hdnCmd" value="Add">
          ชื่อผู้ป่วย :<br><select class="js-example-basic-single" id="patient_id" name="patient_id" style="width: 348px;">
          </select>
        </div>
        <div class="one_quarter first">
          <input type="hidden" id="appointment_status" value="R">
          <br>วันและเวลาที่นัดหมาย :<input type="datetime-local" class="w3-border w3-round-large" id="appoint_datetime" name="appoint_datetime" style="width: 348px;"><br>
          <button type="button" name="button" class="w3-border w3-round-large" id="add">บันทึกข้อมูล</button>
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
    $("#add").click(function(e){
    e.preventDefault();
      // $.ajax({
      //   url: '../PHP/getLastID_app.php',
      //   dataType: 'json',
      //   success: function(data) {
      //     if(data.status == true) {
      //       $("#appointment_id").val(data.last_ID);
      //     }
      //   }
      // });
      $.ajax({
          url: 'PHP/manage_appointment.php',
          data: {
            patient_id: $("#patient_id").val(),
            doctor_id: $("#doctor_id").val(),
            appoint_datetime: $("#appoint_datetime").val(),
            appointment_status: $("#appointment_status").val(),
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
      $(".js-example-basic-single").select2({
                ajax: {
                    dataType: 'json',
                    url: './PHP/getAppointment.php',
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
    // $("form").submit(function(e){
    //   e.preventDefault();
    //   if($("#nurse_username").val().length < 3 || $("#nurse_password").val().length < 3 || $("#first_name").val().length < 3 || $("#last_name").val().length < 3)
    //   {
    //     alert("คุณกรอกข้อมูลไม่ครบถ้วน กรุณากรอกให้ครบ");
    //     return;
    //   }

    });
</script>
</body>
</html>
