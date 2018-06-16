<?php
session_start();
if (!isset($_SESSION['logged']))
    header("location: login.html");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pj";
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn, "utf8");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';

if (!isset($_GET['appointment_id'])) {
    return;
} else {
    $refid = $_GET['appointment_id'];
}

if (isset($_POST['btnSubmit'])) {

    $currentNID = $_SESSION['nurse_id'];

    $refid = $_POST['hdnIDRef'];
    $sltAppStatus = $_POST['appointment_status'];
    //$inpDatetime = $_POST['appoint_datetime'];

    if ($sltAppStatus == "G") {
        $stmt = $conn->prepare("UPDATE appointment SET appointment_status=? WHERE appointment_id=?");
        $stmt->bind_param("si", $apm_status, $apm_id);
        $apm_status = "G";
        $apm_id = $refid;
        $stmt->execute();

        $stmt->close();
        $conn->close();
        header("location:index.php");
    } else {
        $inpDatetime = $_POST['appoint_datetime'];
        $sqltmp = "SELECT doctor_id,patient_id,appoint_datetime FROM appointment WHERE appointment_id = '$refid'";
        $resultDoc = mysqli_query($conn, $sqltmp);
        $resultDoc = mysqli_fetch_array($resultDoc);
        $doctorID = $resultDoc['doctor_id'];
        //$patientID = $resultDoc['patient_id'];
        $old_datetime = $resultDoc['appoint_datetime'];
        //$currentDoctorID = $_SESSION['doctor_id'];
        //$appoint_datetime = $_POST['appoint_datetime'];
        $sqltmp = "SELECT * FROM working_date WHERE doctor_id = '$doctorID' AND work_date = DATE('$inpDatetime') AND (work_time_in < TIME('$inpDatetime') AND work_time_out > TIME('$inpDatetime')) LIMIT 0,1";
        $resultQ = mysqli_query($conn, $sqltmp);
        //var_dump($sqltmp);
        if (!$resultQ || mysqli_num_rows($resultQ) < 1) {
            $message = "ไม่มีตารางนัดหมายทำงานในวัน/เวลาที่เลือกไว้";
        } else {
            //$message = "มี !";



            $stmt = $conn->prepare("INSERT INTO change_appointment (change_datetime, old_appoint, new_appoint, nurse_id) VALUES (?, ?, ?,?)");
            $stmt->bind_param("sssi",$currentDate, $old_datetime, $appoint_datetime, $currentNID);

            //$patient_id = $patientID;
            //$doctor_id = $doctorID;
            $currentDate = date("Y-m-d H:i:s");
            $appoint_datetime = $inpDatetime;
            $appointment_status = "Y";
            $treatment_id = $refid;
            $stmt->execute();

            $sqltmp = "SELECT change_id FROM change_appointment ORDER BY change_id DESC LIMIT 0,1 ";
            $resultLastChange = mysqli_query($conn, $sqltmp);
            $resultLastChange = mysqli_fetch_array($resultLastChange);
            $changeID = $resultLastChange['change_id'];

            $stmt = $conn->prepare("UPDATE appointment SET appointment_status=?,change_id=? WHERE appointment_id=?");
            $stmt->bind_param("sii", $apm_status, $change_id, $apm_id);
            $apm_status = "Y";
            $change_id = $changeID;
            $apm_id = $refid;
            $stmt->execute();

            //$message = "เย้!";
            

            $stmt->close();
            $conn->close();
            header("Location:index.php");
        }
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
    </head>
    <style>
        #first_name, #appoint_datetime, #appointment_status {
            color: black;
        }
        .save_tr {
            margin: 40px;
        }
        #btnSubmit {
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
                        <li><i class="fa fa-user"></i><a href="update.php"><?php echo $_SESSION['fullname']; ?></a></li>
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
                        <form action="" method="POST">
                            <div class="one_quarter first">
                                <input type="hidden" id="hdnCmd" value="Add">
                                <input type="hidden" id="hdnIDRef" name="hdnIDRef" value="<?= $refid ?>" />
                                <br>เปลี่ยนสถานะการนัดหมาย :<select id="appointment_status" name="appointment_status">
                                    <option value="G">มาตามนัด</option>
                                    <option value="Y">เลื่อนนัด</option>
                                </select>
                                <!-- <button type="button" name="button" class="w3-border w3-round-large" id="add">มาตามนัด</button> -->
                            </div>
                            <div class="one_quarter first">
                                <br>วันและเวลาที่นัดหมาย :<input type="datetime-local" class="w3-border w3-round-large" id="appoint_datetime" name="appoint_datetime" style="width: 348px;"><br>
                                <button type="submit" name="btnSubmit" class="w3-border w3-round-large" id="btnSubmit" >ยืนยัน</button>
                                <span><?= $message ?></span>
                            </div>
                        </form>
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
            /*
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
             url: 'PHP/manage_appointment.php',
             data: {
             patient_id: $("#patient_id").val(),
             doctor_id: $("#doctor_id").val(),
             appoint_datetime: $("#appoint_datetime").val(),
             appointment_status: $("#appointment_status").val(),
             hdnCmd: $("#hdnCmd").val()
             },
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
             */
        </script>
    </body>
</html>
