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
$id = ($_GET["patient_id"]);
$sql = "SELECT * FROM patient where patient_id = $id";
$result = $conn->query($sql);
// $search['tbody'] = "";
if ($result->num_rows > 0) {
 	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
    // var_dump($row["address"]);
    $first_name = $row["first_name"];
    $last_name = $row["last_name"];
    $national_id = $row["national_id"];
    $tel = $row["tel"];
    $email = $row["email"];
    $address = $row["address"];
    $weight = $row["weight"];
    $allergic = $row["allergic"];
    $parent_name = $row["parent_name"];
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
<script type="text/javascript">
    $(document).ready(function() {
      // $.ajax({
      //   url: '../PHP/getLastID_pat.php',
      //   dataType: 'json',
      //   success: function(data) {
      //     if(data.status == true) {
      //       $("#patient_id").val(data.last_ID);
      //     }
      //   }
      // });

    $("form").submit(function(e){
      e.preventDefault();
      // if($("#national_id").val().length < 13 || $("#tel").val().length < 10 || $("#first_name").val().length < 3 || $("#last_name").val().length < 3)
      // {
      //   alert("คุณกรอกข้อมูลไม่ครบถ้วน กรุณากรอกให้ครบ");
      //   return;
      // }
      $.ajax({
          url: 'PHP/manage_patient.php',
          data: {
            patient_id: $("#patient_id").val(),
            patient_status: $("#patient_status").val(),
            first_name: $("#first_name").val(),
            last_name: $("#last_name").val(),
            national_id: $("#national_id").val(),
            sex: $("#sex").val(),
            parent_name: $("#parent_name").val(),
            address: $("#address").val(),
            tel: $("#tel").val(),
            email: $("#email").val(),
            weight: $("#weight").val(),
            privilege: $("#privilege").val(),
            allergic: $("#allergic").val(),
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
    });
</script>
</head>
<style>
  #first_name, #last_name, #patient_id, #national_id, #patient_status, #parent_name, #address,
  #tel, #email, #weight, #allergic, #privilege, #patient_id, #sex {
    color: black;
  }
  #editPatient {
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
      <h2>ข้อมูลผู้ป่วย</h2>
      <div class="group btmspace-50 demo">
        <form action="" method="POST">
        <div class="one_quarter first">
          <input type="hidden" id="hdnCmd" name="hdnCmd" value="updt">
          <input type="hidden" id="patient_id" name="patient_id" value="<?=$id ?>">
          ชื่อ : <input type="text" class="w3-border w3-round-large" id="first_name" name="first_name" value="<?=$first_name ?>"><br>
          นามสกุล : <input type="text" class="w3-border w3-round-large" id="last_name" name="last_name" value="<?=$last_name ?>"><br>
          เพศ : <select class="w3-border w3-round-large" id="sex">
          <option value="M">ชาย</option>
          <option value="F">หญิง</option>
          </select><br>
          เลขประจำตัวประชาชน : <input type="text" class="w3-border w3-round-large" id="national_id" name="national_id" value="<?=$national_id ?>"><br>
          เบอร์โทร : <input type="text" class="w3-border w3-round-large" id="tel" name="tel" value="<?=$tel ?>"><br>
          อีเมล์ : <input type="email" class="w3-border w3-round-large" id="email" name="email" value="<?=$email ?>" required><br>
          ที่อยู่ : <textarea class="w3-border w3-round-large" rows="5" cols="40" id="address" name="address"><?=$address ?></textarea><br>
          เเพ้ยา : <input type="text" class="w3-border w3-round-large" id="allergic" id="allergic" value="<?=$allergic ?>"><br>
          น้ำหนัก : <input type="text" class="w3-border w3-round-large" id="weight" name="weight" value="<?=$weight ?>"><br>
          ชื่อญาติของผู้ป่วย : <textarea rows="1" cols="40" class="w3-border w3-round-large" id="parent_name" name="parent_name"><?=$parent_name ?></textarea><br>
          สิทธิ์การรักษา : <select class="w3-border w3-round-large" id="privilege" name="privilege">
          <option value="0">ไม่มีสิทธิการรักษา</option>
          <option value="1">สิทธิสวัสดิการการรักษาพยาบาลของข้าราชการ</option>
          <option value="2">สิทธิประกันสังคม</option>
          <option value="3">สิทธิหลักประกันสุขภาพ 30 บาท</option>
          </select><br>
          สถานะการรักษา : <select class="w3-border w3-round-large" id="patient_status" name="patient_status">
            <option value="0">กำลังรักษาอยู่</option>
            <option value="1">รักษาหายแล้ว</option>
          </select><br>
          <button type="submit" class="w3-border w3-round-large" id="editPatient">แก้ไขข้อมูล</button><br>
          <span id="result"></span>
        </div>
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