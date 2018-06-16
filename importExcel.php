<?php
session_start();
if(!isset($_SESSION['logged'])) header("location: login.html");
?>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pj";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn,"utf8");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$message = '';
$stmt_reset = $conn->prepare("ALTER TABLE patient AUTO_INCREMENT = 1");
$stmt_reset->execute();
$stmt_reset->close();

if(isset($_POST["add_user"]) && $_POST["hdnCmd"] == "Add")
{
  //var_dump($_FILES["excel"]);
  $target_dir = "import/";
  $target_file = $target_dir . basename($_FILES["excel"]["name"]);

  //var_dump($_FILES["excel"]["name"]);
    $uploadOk = 0;
    $fileileType = pathinfo($target_file, PATHINFO_EXTENSION);
    //var_dump($fileileType);
    if ($fileileType != "xlsx") {
        $message = "ขออภัย, กรุณาใช้ไฟล์นามสกุล .xlsx เท่านั้น";
        $uploadOk = 0;
    } else {
      $type = explode(".", $_FILES["excel"]["name"]);
      //var_dump(end($type));
        $ext = end($type);
        $location = "import/import." . $ext;

        move_uploaded_file($_FILES["excel"]["tmp_name"], $location);
        $uploadOk = 1;
        //print("done");

    }
    if ($uploadOk == 1) {
        require 'PHPExcel-1.8/Classes/PHPExcel.php';
        $inputFileName = $location;

        $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);

        $roundamount = 0;
        for ($index = 2; $index < 100000; $index++) {
            
            $subjectrow = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $index)->getValue();
            if ($subjectrow != '')
                $roundamount++;
            else
                break;
        // print($first_name. "|" .$last_name. "|" .$national_id. "|" .$sex. "|" .$parent_name. "|" .$address. "|" .$tel. "|" .$email. "|" .$weight. "|" .$privilege. "|" .$allergic. "|");

        $stmt = $conn->prepare("INSERT INTO patient (patient_status, first_name, last_name, national_id, sex, parent_name, address, tel, email, weight, privilege, allergic, nurse_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");


        $patient_status = '0';
        $first_name = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $index)->getValue();
        $last_name = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $index)->getValue();
        $national_id = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $index)->getValue();
        $sex = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $index)->getValue();
        $parent_name = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $index)->getValue();
        $address = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $index)->getValue();
        $tel = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6, $index)->getValue();
        $email = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $index)->getValue();
        $weight = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(8, $index)->getValue();
        $privilege = intval($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(9, $index)->getValue());
        $allergic = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(10, $index)->getValue();
        $nurse_id = $_SESSION['nurse_id'];
        /*
        print($first_name. "|" .$last_name. "|" .$national_id. "|" .$sex. "|" .$parent_name. "|" .$address. "|" .$tel. "|" .$email. "|" .$weight. "|" .$privilege. "|" .$allergic. "|");
        */

        $stmt->bind_param("sssssssssiisi", $patient_status, $first_name, $last_name, $national_id, $sex, $parent_name, $address, $tel, $email, $weight, $privilege, $allergic, $nurse_id);
        //var_dump($_SESSION['nurse_id']);
        // set parameters and execute
        
        $stmt->execute();
        //$test = $stmt->bind_result();
        //var_dump($test);
        }
        $stmt->close();
        $conn->close();

        $message = "เพิ่มข้อมูลสำเร็จ";
        $objPHPExcel->disconnectWorksheets();
        unset($objPHPExcel);

        unlink($inputFileName);
        //echo("Error description: " . mysqli_error($stmt));
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<style>
  #first_name, #last_name, #patient_id, #national_id, #patient_status, #parent_name, #address,
  #tel, #email, #weight, #allergic, #privilege, #patient_id, #sex {
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
      width: 142px;
    }
  #edit {
      background-color: #fff15e;
      border: none;
      color: black;
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
      <h2>นำเข้าข้อมูลผู้ป่วยผ่านไฟล์ Excel</h2>
      <div class="group btmspace-50 demo">
        <form action="" method="POST" enctype="multipart/form-data">
        <div class="one_quarter first">
          <input type="hidden" id="hdnCmd" name="hdnCmd" value="Add">
          <input type="hidden" id="patient_status" value="0">
          <input type="file" class="w3-border w3-round-large" name="excel" id="excel">
          <button type="submit" class="w3-border w3-round-large" id="add_user" name="add_user">เพิ่มข้อมูล</button>
          <br><span><?php echo $message;?></span>
      </form>
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
</body>
</html>