<?php
//session_start();
?>

<ul class="clear">
    <?php
    if ($_SESSION['type'] == "admin")
        echo '<li><a href="backyard/upAdmin.php">จัดการข้อมูลผู้ใช้งาน</a></li>';
    if ($_SESSION['type'] == "nurse" || $_SESSION['type'] == "doctor")
        echo '<li class="active"><a href="index.php">ตารางการนัดหมายของผู้ป่วย</a></li>';
    if ($_SESSION['type'] == "doctor")
        
        echo '<li><a href="treatment.php">การรักษา</a></li>
                <li><a href="workdatetime.php">ตารางการทำงาน</a></li>
                <li><a class="drop" href="#">รายงาน</a>
                <ul>
                    <li><a href="report1.php">รายงานรายชื่อผู้ป่วยในเเต่ละวัน</a></li>
                    <li><a href="report2.php">รายงานการรักษาของผู้ป่วยในเเต่ละคน</a>
                    <li><a href="report3.php">รายงานผู้ป่วยที่รักษาหายเเล้ว</a>
                    <li><a href="report4.php">รายงานรายชื่อผู้ป่วยที่ขาดนัด</a>
               </ul>';
    if ($_SESSION['type'] == "nurse")
        echo '<li><a class="drop" href="#">จัดการข้อมูล</a>
                                    <ul><li><a href="backyard/upPatient.php">ข้อมูลผู้ป่วย</a></li>
                                    <li><a href="backyard/upMedicine.php">ข้อมูลยา</a></li></ul></li>
                                    <li><a class="drop" href="#">รายงาน</a>
                                    <ul><li><a href="report1.php">รายงานรายชื่อผู้ป่วยในเเต่ละวัน</a></li>
                                      <li><a href="report2.php">รายงานการรักษาของผู้ป่วยในเเต่ละคน</a>
                                      <li><a href="report3.php">รายงานผู้ป่วยที่รักษาหายเเล้ว</a>
                                      <li><a href="report4.php">รายงานรายชื่อผู้ป่วยที่ขาดนัด</a>
                                    </ul>';
    ?>
</ul>
