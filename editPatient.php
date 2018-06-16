<?php
session_start();
if(!isset($_SESSION['logged'])) header("location: login.html");
?>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pj";
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn,"utf8");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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
<script type="text/javascript">
    // $(document).ready(function() {
    //   $.ajax({
    //     url: '../PHP/getLastID_pat.php',
    //     dataType: 'json',
    //     success: function(data) {
    //       if(data.status == true) {
    //         $("#patient_id").val(data.last_ID);
    //       }
    //     }
    //   });

    // $("form").submit(function(e){
    //   e.preventDefault();
    //   if($("#national_id").val().length < 13 || $("#tel").val().length < 10 || $("#first_name").val().length < 3 || $("#last_name").val().length < 3)
    //   {
    //     alert("คุณกรอกข้อมูลไม่ครบถ้วน กรุณากรอกให้ครบ");
    //     return;
    //   }
    //   $.ajax({
    //       url: '../PHP/manage_patient.php',
    //       data: {
    //         patient_status: $("#patient_status").val(),
    //         first_name: $("#first_name").val(),
    //         last_name: $("#last_name").val(),
    //         national_id: $("#national_id").val(),
    //         sex: $("#sex").val(),
    //         parent_name: $("#parent_name").val(),
    //         address: $("#address").val(),
    //         tel: $("#tel").val(),
    //         email: $("#email").val(),
    //         weight: $("#weight").val(),
    //         privilege: $("#privilege").val(),
    //         allergic: $("#allergic").val(),
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
    // });
</script>
</head>
<style>
  #first_name, #last_name, #patient_id, #national_id, #patient_status, #parent_name, #address,
  #tel, #email, #weight, #allergic, #privilege, #patient_id, #sex, #tbb {
    color: black;
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
<div class="tbbb">
      <center><h2><br>แก้ไขข้อมูลผู้ป่วย</h2>
        <table style="width:90%">
        <tr>
          <th>รหัสผู้ป่วย</th>
          <th>สถานะ</th>
          <th>ชื่อ</p></th>
          <th>นามสกุล</th>
          <th>รหัสบัตรประจำตัวประชาชน</th>
          <th>เพศ</th>
          <th>ชื่อญาติ</th>
          <th>ที่อยู่</th>
          <th>เบอร์โทร</th>
          <th>อีเมล์</th>
          <th>น้ำหนัก</th>
          <th>สิทธิ์การรักษา</th>
          <th>แพ้ยา</th>
          <th>แก้ไข</th>
        </tr>

        <?php
        $Query = mysqli_query($conn, "select * from patient");

        while ($arr = mysqli_fetch_array($Query)) {
            $autoid = $arr['patient_id'];
            if ($arr["sex"] == 'M') {
              $arr["sex"] = "ชาย";
            } else {
              $arr["sex"] = "หญิง";
            }
            if ($arr["patient_status"] == 1) {
                $arr["patient_status"] = "รักษาหายเเล้ว";
            }
            else {
              $arr["patient_status"] = "กำลังรักษา";
            }
            if ($arr["privilege"] == '0') {
                $arr["privilege"] = "ไม่มีสิทธิการรักษา";
            }
            else if ($arr["privilege"] == '1') {
                $arr["privilege"] = "สิทธิสวัสดิการการรักษาพยาบาลของพยาบาล";
            }
            else if ($arr["privilege"] == '2') {
              $arr["privilege"] = "สิทธิประกันสังคม";
            } else {
              $arr["privilege"] = "สิทธิหลักประกันสุขภาพ 30 บาท";
            }

        ?>

        <tr id="tbb">
          <td><?php echo $arr["patient_id"]; ?></td>
          <td><?php echo $arr["patient_status"]; ?></td>
          <td><?php echo $arr["first_name"]; ?></td>
          <td><?php echo $arr["last_name"]; ?></td>
          <td><?php echo $arr["national_id"]; ?></td>
          <td><?php echo $arr["sex"]; ?></td>
          <td><?php echo $arr["parent_name"]; ?></td>
          <td><?php echo $arr["address"]; ?></td>
          <td><?php echo $arr["tel"]; ?></td>
          <td><?php echo $arr["email"]; ?></td>
          <td><?php echo $arr["weight"]; ?></td>
          <td><?php echo $arr["privilege"]; ?></td>
          <td><?php echo $arr["allergic"]; ?></td>
          <td><a href="showEditptn.php?patient_id=<?=$arr["patient_id"]; ?>">แก้ไข</a></td>
        </tr>
          <?php } ?>
        <!-- <form action="../PHP/manage_patient.php" method="POST">
        <div class="one_quarter first">
          <input type="hidden" id="hdnCmd" value="Add">
          <input type="hidden" id="patient_status" value="0">
          <!-- <a href="../importExcel.php"><button type="button" class="w3-border w3-round-large" id="import">นำเข้าข้อมูล Excel</button></a><br> -->
          <!-- ชื่อ : <input type="text" class="w3-border w3-round-large" id="first_name" name="first_name"><br>
          นามสกุล : <input type="text" class="w3-border w3-round-large" id="last_name" name="last_name"><br>
          เพศ : <select class="w3-border w3-round-large" id="sex">
          <option value="M">ชาย</option>
          <option value="F">หญิง</option>
          </select><br>
          เลขประจำตัวประชาชน : <input type="text" class="w3-border w3-round-large" id="national_id" name="national_id"><br>
          เบอร์โทร : <input type="text" class="w3-border w3-round-large" id="tel" name="tel"></input><br>
          อีเมล์ : <input type="email" class="w3-border w3-round-large" id="email" name="email" required><br>
          ที่อยู่ : <textarea class="w3-border w3-round-large" rows="5" cols="40" id="address" name="address"></textarea><br>
          เเพ้ยา : <input type="text" class="w3-border w3-round-large" id="allergic" id="allergic"><br>
          น้ำหนัก : <input type="text" class="w3-border w3-round-large" id="weight" name="weight"><br>
          ชื่อญาติของผู้ป่วย : <textarea rows="1" cols="40" class="w3-border w3-round-large" id="parent_name" name="parent_name"></textarea><br>
          สิทธิ์การรักษา : <select class="w3-border w3-round-large" id="privilege" name="privilege">
          <option value="0">ไม่มีสิทธิการรักษา</option>
          <option value="1">สิทธิสวัสดิการการรักษาพยาบาลของข้าราชการ</option>
          <option value="2">สิทธิประกันสังคม</option>
          <option value="3">สิทธิหลักประกันสุขภาพ 30 บาท</option>
          </select><br>
          <!-- <button type="submit" class="w3-border w3-round-large" id="add_user">เพิ่มข้อมูล</button> -->
          <!-- <a href="../editMedicine.php"><button type="button" class="w3-border w3-round-large" id="editMedicine">แก้ไขข้อมูล</button></a>
          <span id="result"></span>
        </div>
      </form>
    </div> -->
</div>
<a id="backtotop" href="#top"><i class="fa fa-chevron-up"></i></a>
<script src="layout/scripts/jquery.min.js"></script>
<script src="layout/scripts/jquery.backtotop.js"></script>
<script src="layout/scripts/jquery.mobilemenu.js"></script>
<script src="layout/scripts/jquery.placeholder.min.js"></script>
</body>
</html>
