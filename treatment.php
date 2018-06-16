<?php
session_start();
if (!isset($_SESSION['logged']))
    header("location: login.html");
?>
<?php
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

$Random = date("YmdHis") . GenRanString(5);
$stmt_reset = $conn->prepare("ALTER TABLE treatment AUTO_INCREMENT = 1");
$stmt_reset->execute();
$stmt_reset->close();
//echo $Random;

if (isset($_POST["add_user"]) && $_POST["hdnCmd"] == "Add") {
    $target_dir = "imgXray/";
    $target_file = $target_dir . basename($_FILES["xray"]["name"]);
    $uploadOk = 0;
    $fileileType = pathinfo($target_file, PATHINFO_EXTENSION);
    if (!($fileileType == "jpg" || $fileileType == "png")) {
        $message = "ขออภัย, กรุณาใช้ไฟล์นามสกุล .jpg หรือ .png เท่านั้น";
        $uploadOk = 0;
    } else {
        $type = explode(".", $_FILES["xray"]["name"]);
        //var_dump(end($type));
        $ext = end($type);
        $location = "imgXray/" . $Random . '.' . $ext;

        move_uploaded_file($_FILES["xray"]["tmp_name"], $location);
        $uploadOk = 1;
        //print($location);
    }
    
    
    
    $currentDoctorID = $_SESSION['doctor_id'];
    $appoint_datetime = $_POST['appoint_datetime'];
    $sqltmp = "SELECT * FROM working_date WHERE doctor_id = '$currentDoctorID' AND work_date = DATE('$appoint_datetime') AND (work_time_in < TIME('$appoint_datetime') AND work_time_out > TIME('$appoint_datetime')) LIMIT 0,1";
    $resultQ = mysqli_query($conn, $sqltmp);
    //var_dump($sqltmp);
    if (!$resultQ || mysqli_num_rows($resultQ) < 1) {
        $message = "ไม่มีตารางนัดหมายทำงานในวัน/เวลาที่เลือกไว้";
    } else {
        //$message = "ถูกต้อง!";

        $stmt = $conn->prepare("INSERT INTO treatment (patient_id, doctor_id, treatment_datetime, symptom, comment) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisss", $patient_id, $doctor_id, $treatment_datetime, $symptom, $comment);

        // set parameters and execute
        $patient_id = $_POST['patient_id'];
        $doctor_id = $_SESSION['doctor_id'];
        $treatment_datetime = $_POST['treatment_datetime'];
        $symptom = $_POST['symptom'];
        $comment = $_POST['comment'];
        // var_dump($patient_id);
        $stmt->execute();

        $sql3 = "SELECT treatment_id FROM treatment ORDER BY treatment_id DESC LIMIT 0, 1";
        $result3 = mysqli_query($conn, $sql3);
        $row3 = mysqli_fetch_array($result3);

        $stmt = $conn->prepare("INSERT INTO dispend (treatment_id, medicine_id, unit_id, amount) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiis", $treatment_id, $medicine_id, $unit_id, $amount);

        $treatment_id = $row3[0];
        $medicine_id = $_POST['medicine_id'];
        $unit_id = $_POST['unit_id'];
        $amount = $_POST['amount'];
        $stmt->execute();

        $sql4 = "SELECT count_patient FROM working_date WHERE doctor_id = ".$_SESSION['doctor_id'];
        $result4 = mysqli_query($conn, $sql4);
        $row4 = mysqli_fetch_array($result4);
        $doctor_id = $_SESSION['doctor_id'];
        $stmt = $conn->prepare("UPDATE working_date SET count_patient=count_patient + 1 WHERE doctor_id=?");
        $stmt->bind_param("i", $doctor_id);
	    $stmt->execute();

        $stmt = $conn->prepare("INSERT INTO appointment (patient_id, doctor_id, appoint_datetime, appointment_status, treatment_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iissi", $patient_id, $doctor_id, $appoint_datetime, $appointment_status, $treatment_id);
        $patient_id = $_POST['patient_id'];
        $doctor_id = $_SESSION['doctor_id'];
        //$appoint_datetime = $_POST['appoint_datetime'];
        $appointment_status = $_POST['appointment_status'];
        $treatment_id = $row3[0];
        $stmt->execute();
        $message = "Insert Treatment Success";
    }

    //var_dump($row3[0]);
    if ($uploadOk == 1) {
        $sql3 = "SELECT treatment_id FROM treatment ORDER BY treatment_id DESC LIMIT 0, 1";
        $result3 = mysqli_query($conn, $sql3);
        $row3 = mysqli_fetch_array($result3);
        $stmt = $conn->prepare("INSERT INTO x_ray (x_ray_file, treatment_id) VALUES (?, ?)");
        $stmt->bind_param("si", $x_ray_file, $treatment_id);
        $x_ray_file = $location;
        $treatment_id = $row3[0];
        $stmt->execute();
        $stmt->close();
    }
    $result['status'] = true;
    
}
$sql1 = "SELECT * FROM medicine";
$sql2 = "SELECT * FROM unit";
$result1 = mysqli_query($conn, $sql1);
$result2 = mysqli_query($conn, $sql2);


$conn->close();

function GenRanString($length) {
    //$length = 10;
    $characters = "abcdefghijklmnopqrstuvwxyz1234567890";
    $string = '';
    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }
    return $string;
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
        #first_name, #treatment_datetime, #symptom, #comment, #medicine_id, #unit ,#amount, #patient_id, #unit_id ,#appoint_datetime{
            color: black;
        }
        .save_tr {
            margin: 40px;
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
                        <li><i class="fa fa-user"></i> <a href="update.php"><?php echo $_SESSION['fullname']; ?></a></li>
                    </ul>
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
                    <h2>การรักษา</h2>
                    <div class="group btmspace-50 demo">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="one_quarter first">
                                <input type="hidden" id="hdnCmd" name="hdnCmd" value="Add">
                                <input type="hidden" id="appointment_status" name="appointment_status" value="R">
                                ชื่อผู้ป่วย :<br><select class="js-example-basic-single" id="patient_id" name="patient_id" style="width: 348px;">
                                </select>
                            </div>
                            <div class="one_quarter first">
                              <!-- ชื่อผู้ป่วย : <input type="text" class="w3-border w3-round-large" id="first_name" name="first_name"></input><br> -->
                                <br>วันและเวลาที่รักษา : <input type="datetime-local" class="w3-border w3-round-large" id="treatment_datetime" name="treatment_datetime" style="width: 348px;"><br>
                                อาการ : <textarea rows="5" cols="40" class="w3-border w3-round-large" id="symptom" name="symptom"></textarea><br>
                                ความคิดเห็น : <textarea rows="5" cols="40" class="w3-border w3-round-large" id="comment" name="comment"></textarea><br>
                                <!--<form action="PHP/getTreatment.php" method="POST">-->
                                ชื่อยา : <select class="w3-border w3-round-large"  id="medicine_id" name="medicine_id" style="width: 348px;">
<?php while ($row1 = mysqli_fetch_array($result1)):; ?>
                                        <option value="<?php echo $row1[0]; ?>"><?php echo $row1[1]; ?></option>
                                    <?php endwhile; ?>
                                </select><br>
                                ปริมาณยา : <input type="text" class="w3-border w3-round-large" id="amount" name="amount" style="width: 348px;"></input><br>
                                ชนิดยา : <select class="w3-border w3-round-large"  id="unit_id" name="unit_id" style="width: 348px;">
<?php while ($row2 = mysqli_fetch_array($result2)):; ?>
                                        <option value="<?php echo $row2[0]; ?>"><?php echo $row2[1]; ?></option>
                                    <?php endwhile; ?>
                                </select><br>
                                อัพโหลดไฟล์ X-ray :<input type="file" class="w3-border w3-round-large" name="xray" id="xray"><br>

                                กำหนดวันและเวลานัดหมาย :<input type="datetime-local" class="w3-border w3-round-large" id="appoint_datetime" name="appoint_datetime" style="width: 348px;"><br>
                                <button type="submit" class="w3-border w3-round-large" id="add_user" name="add_user">บันทึกข้อมูล</button><br>
                                <!--</form>-->
                                <span><?php echo $message; ?></span>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>

        <a id="backtotop" href="#top"><i class="fa fa-chevron-up"></i></a>
        <script src="layout/scripts/jquery.min.js"></script>
        <script src="layout/scripts/jquery.backtotop.js"></script>
        <script src="layout/scripts/jquery.mobilemenu.js"></script>
        <script src="layout/scripts/jquery.placeholder.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
        <script type="text/javascript">
            $.fn.setNow = function (onlyBlank) {
                var now = new Date($.now())
                        , year
                        , month
                        , date
                        , hours
                        , minutes
                        , seconds
                        , formattedDateTime
                        ;

                year = now.getFullYear();
                month = now.getMonth().toString().length === 1 ? '0' + (now.getMonth() + 1).toString() : now.getMonth() + 1;
                date = now.getDate().toString().length === 1 ? '0' + (now.getDate()).toString() : now.getDate();
                hours = now.getHours().toString().length === 1 ? '0' + now.getHours().toString() : now.getHours();
                minutes = now.getMinutes().toString().length === 1 ? '0' + now.getMinutes().toString() : now.getMinutes();
                //seconds = now.getSeconds().toString().length === 1 ? '0' + now.getSeconds().toString() : now.getSeconds();
                seconds = "00";
                formattedDateTime = year + '-' + month + '-' + date + 'T' + hours + ':' + minutes + ':' + seconds;

                if (onlyBlank === true && $(this).val()) {
                    return this;
                }

                $(this).val(formattedDateTime);

                return this;
            }
            $(document).ready(function () {

                $('input[type="datetime-local"]').setNow();

                $("#add").click(function (e) {
                    e.preventDefault();
                    // if($("#username").val().length < 3 || $("#password").val().length < 3 || $("#admin_firstname").val().length < 3 || $("#admin_lastname").val().length < 3)
                    // {
                    //   alert("คุณกรอกข้อมูลไม่ครบถ้วน กรุณากรอกให้ครบ");
                    //   return;
                    // }
                    //   $.ajax({
                    //       url: 'PHP/manage_treatment.php',
                    //       data: {
                    //         patient_id: $("#patient_id").val(),
                    //         doctor_id: $("#doctor_id").val(),
                    //         treatment_datetime: $("#treatment_datetime").val(),
                    //         symptom: $("#symptom").val(),
                    //         comment: $("#comment").val(),
                    //         //x_ray_id: $("#x_ray_id").val(),
                    //         hdnCmd: $("#hdnCmd").val()
                    //       },
                    //       dataType: 'json',
                    //       success: function(data) {
                    //         if(data.status == true) {
                    //           $("#result").html(data.msg);
                    //           //location.reload();
                    //         }
                    //       },
                    //       type: 'POST'
                    //   });
                    // });
                    // $.ajax({
                    //       url: 'PHP/getTreatment.php',
                    //       dataType: 'json',
                    //       success: function(data) {
                    //           $("#first_name").val();
                    //       },
                    //       type: 'GET'
                });
                //$('.js-example-basic-single').select2();
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