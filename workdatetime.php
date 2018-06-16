<?php
session_start();
if (!isset($_SESSION['logged'])) header("location: login.html");
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
$stmt_reset = $conn->prepare("ALTER TABLE working_date AUTO_INCREMENT = 1");
$stmt_reset->execute();
$stmt_reset->close();
//echo $Random;

$currentDoctorID = $_SESSION['doctor_id'];

$sqlMappingTable = "SELECT * FROM working_date WHERE doctor_id = '$currentDoctorID' AND work_date > NOW()";
$resultMappingTable = mysqli_query($conn, $sqlMappingTable);

$arrTable = array();
$i = 0;

if ($resultMappingTable != FALSE) {
    while ($row = mysqli_fetch_array($resultMappingTable)) {
        $arrTable[$i] = $row;
        $i++;
    }
}


$message = '';

if (isset($_POST['btnAddnewWorkDate'])) {
    //var_dump($_POST['inpDate']);
    //var_dump($_POST['inpStart']);
    //var_dump($_POST['inpEnd']);
    //$tmp = strtotime($_POST['inpDate']." ".$_POST['inpStart'].":00");
    $startDate = date("Y-m-d H:i:s", strtotime($_POST['inpDate'] . " " . $_POST['inpStart'] . ":00"));
    $endDate = date("Y-m-d H:i:s", strtotime($_POST['inpDate'] . " " . $_POST['inpEnd'] . ":00"));
    $date = date("Y-m-d", strtotime($_POST['inpDate']));

    if ($date < date("Y-m-d", strtotime("today"))) {
        $message = "วันที่เลือก ไม่สามารถเลือก";
    } else if ($startDate < $endDate) {

        $sqlChkDateAvailable = "SELECT * FROM working_date WHERE doctor_id = $currentDoctorID AND work_date = '$date'";
        $resultChkDateAvailable = mysqli_query($conn, $sqlChkDateAvailable);
        if (mysqli_num_rows($resultChkDateAvailable) == 0) {
            $stmt = $conn->prepare("INSERT INTO working_date (work_time_in, work_time_out, count_patient, work_date, doctor_id) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssisi", $start, $end, $amout, $date, $doctor_id);

            // set parameters and execute
            $amout = 0;
            $start = date("H:i:s", strtotime($startDate));
            $end = date("H:i:s", strtotime($endDate));
            $doctor_id = $_SESSION['doctor_id'];

            $stmt->execute();
            $stmt->close();

            $message = "";
            header("Refresh:0");
        } else {
            $message = "วันที่เลือก ได้ทำการเลือกไปแล้ว";
        }
    } else {
        $message = "วัน/เวลาเริ่มต้น มีค่ามากกว่า วัน/เวลาสิ้นสุด";
    }
}

$conn->close();
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
        #first_name, #treatment_datetime, #symptom, #comment, #medicine_id, #unit ,#amount, #patient_id, #unit_id ,#appoint_datetime , .inputgroup , table{
            color: black;
        }
        .save_tr {
            margin: 40px;
        }
        #add_user,.btnAction {
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
            </header>
        </div>
        <div class="">
            <main class="hoc container clear">
                <div class="content">
                    
                    <h2>ตารางการทำงาน</h2>
                    <div class="group btmspace-50 demo">
                        <div class="one_half first">

                            <?php if (count($arrTable) > 0)  ?>
                            <table>
                                <thead>
                                    <tr>
                                        <th>วันทำงาน</th>
                                        <th>เวลาเข้า</th>
                                        <th>เวลาออก</th>
                                        <th>ลบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($arrTable as $value) {
                                        echo '<tr>';

                                        echo "<td>" . $value['work_date'] . "</td>";
                                        echo "<td>" . $value['work_time_in'] . "</td>";
                                        echo "<td>" . $value['work_time_out'] . "</td>";
                                        echo "<td> <a href='workdatedel.php?wid=" . $value['no'] . "'> X </a></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <form action="" method="POST" enctype="multipart/form-data">

                            <div class="one_half first">
                                <label>เพิ่มวันทำงานใหม่</label>
                                <input type="date" id="inpDate" name="inpDate" min="<?= date('Y-m-d', strtotime("+1 day")) ?>" value="<?= date('Y-m-d', strtotime("+1 day")) ?>"  class="inputgroup" required>
                                <input type="time" id="inpStart" name="inpStart" value="09:00"  class="inputgroup" required >
                                <input type="time" id="inpEnd" name="inpEnd" value="18:00" class="inputgroup" required >
                                <input type="submit" value="เพิ่ม" name="btnAddnewWorkDate" id="btnAddnewWorkDate" class="btnAction" >
                                <?= $message ?>
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
            $(document).ready(function () {
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