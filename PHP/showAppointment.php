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


//var_dump($day);
$showdatetime = '';
if (isset($_GET['day'])) {

    $day = $_GET['day'];

    
    if (isset($_SESSION['nurse_id'])) {
        if ($day == 1)
            $sql = "SELECT * FROM appointment WHERE DATE(appoint_datetime) = DATE(NOW())";
        else
            $sql = "SELECT * FROM appointment WHERE DATE(appoint_datetime) = DATE_ADD(DATE(NOW()), INTERVAL $day DAY) AND appointment_status <> 'G'";
    }else {
        $currentDoctorID = $_SESSION['doctor_id'];
        if ($day == 1)
            $sql = "SELECT * FROM appointment WHERE DATE(appoint_datetime) = DATE(NOW()) AND doctor_id = '$currentDoctorID'";
        else
            $sql = "SELECT * FROM appointment WHERE DATE(appoint_datetime) = DATE_ADD(DATE(NOW()), INTERVAL $day DAY) AND appointment_status <> 'G' AND doctor_id = '$currentDoctorID'";
    }

    $result = $conn->query($sql);
    $resultJSON1['tbody'] = "";

    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $patient_id = $row['patient_id'];
            $sql2 = "SELECT * FROM patient WHERE patient_id = " . $patient_id;
            // $first_name = $row['first_name'];
            $sql3 = "SELECT doctor.first_name,doctor.last_name,appointment.appoint_datetime FROM doctor, appointment WHERE doctor.doctor_id = appointment.doctor_id AND doctor.doctor_id = " . $row['doctor_id'];
            //$sql4 = "SELECT change_appointment.change_id, change_appointment.new_appoint, change_appointment.old_appoint FROM change_appointment LEFT JOIN appointment ON change_appointment.change_id = appointment.change_id";
            
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);
            $result3 = mysqli_query($conn, $sql3);
            $row3 = mysqli_fetch_array($result3, MYSQLI_ASSOC);
            if($row['change_id'] != null) {
                $sql4 = "SELECT new_appoint FROM change_appointment WHERE change_id = " . $row['change_id'];
                $result4 = $conn->query($sql4);
                $row4 = mysqli_fetch_array($result4, MYSQLI_ASSOC);
            }
            if (isset($_SESSION['nurse_id'])) {
                if ($row["appointment_status"] == "R") {
                    $row["appointment_status"] = '<center><a href="./change_appointment.php?appointment_id=' . $row['appointment_id'] . '".$><img class="st-im" alt="red" src="images/red.png" alt="Red"></a></center>';
                    if (isset($row4["new_appoint"])) {
                        $showdatetime = $row4["new_appoint"];
                    } else{
                        $showdatetime = '-';
                    }
                } else if ($row["appointment_status"] == "Y") {
                    $row["appointment_status"] = '<center><a href="./change_appointment.php?appointment_id=' . $row['appointment_id'] . '"><img class="st-im" alt="yellow" src="images/yellow.png" alt="yellow"></a></center>';
                    if (isset($row4["new_appoint"])) {
                        $showdatetime = $row4["new_appoint"];
                        
                    } else{
                        $showdatetime = '-';
                    }
                } else if ($row["appointment_status"] == "G") {
                    if ($day = 1){
                        $row["appointment_status"] = '<center><a href="./change_appointmentRED.php?patient_id=' . $row['patient_id'] . '"><img class="st-im" alt="green" src="images/green.png" alt="green"></a></center>';
                    } else{
                        $row["appointment_status"] = '<center><a href="./change_appointment.php?appointment_id=' . $row['appointment_id'] . '"><img class="st-im" alt="green" src="images/green.png" alt="green"></a></center>';
                    }
                }
            } else {
                if ($row["appointment_status"] == "R") {
                    $row["appointment_status"] = '<center><img class="st-im" alt="red" src="images/red.png" alt="Red"></center>';
                    if (isset($row4["new_appoint"])) {
                        $showdatetime = $row4["new_appoint"];
                        
                    } else{
                        $showdatetime = '-';
                    }
                } else if ($row["appointment_status"] == "Y") {
                    $row["appointment_status"] = '<center><img class="st-im" alt="yellow" src="images/yellow.png" alt="yellow"></center>';
                    if (isset($row4["new_appoint"])) {
                        $showdatetime = $row4["new_appoint"];
                    } else{
                        $showdatetime = '-';
                    }
                } else if ($row["appointment_status"] == "G") {
                    $row["appointment_status"] = '<center><img class="st-im" alt="green" src="images/green.png" alt="green"></center>';
                }
            }
            $resultJSON1['tbody'] .= '<tr id="colT">
				<td>' . $row3["first_name"] . '  ' . $row3["last_name"] . '</td>
                <td>' . $row["appoint_datetime"] . '</td>
                <td>' . $showdatetime . '</td>;
				<td>' . $row2["first_name"] . '</td>
				<td>' . $row2["last_name"] . '</td>
				<td>' . $row2["tel"] . '</td>
				<td>' . $row["appointment_status"] . '</td>
				</tr>';
        }
        echo json_encode($resultJSON1);
    }
}
/*
  if ($day == '5') {
  $sql = "SELECT * FROM appointment WHERE DATE(appoint_datetime) = DATE_ADD(DATE(NOW()), INTERVAL $day DAY) AND appointment_status <> 'G'";
  $result = $conn->query($sql);
  $resultJSON2['tbody'] = "";
  if ($result->num_rows > 0) {
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
  $patient_id = $row['patient_id'];
  $sql2 = "SELECT * FROM patient WHERE patient_id = " . $patient_id;
  // $first_name = $row['first_name'];
  $sql3 = "SELECT doctor.first_name,doctor.last_name,appointment.appoint_datetime FROM doctor, appointment WHERE doctor.doctor_id = appointment.doctor_id";
  $result2 = mysqli_query($conn, $sql2);
  $row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);
  $result3 = mysqli_query($conn, $sql3);
  $row3 = mysqli_fetch_array($result3, MYSQLI_ASSOC);
  if ($row["appointment_status"] == "R") {
  $row["appointment_status"] = '<center><a href="./appointment.php"><img class="st-im" alt="red" src="images/red.png" alt="Red"></a></center>';
  } else if ($row["appointment_status"] == "Y") {
  $row["appointment_status"] = '<center><a href="./appointment.php"><img class="st-im" alt="yellow" src="images/yellow.png" alt="yellow"></a></center>';
  } else if ($row["appointment_status"] == "G") {
  $row["appointment_status"] = '<center><a href="./appointment.php"><img class="st-im" alt="green" src="images/green.png" alt="green"></a></center>';
  }
  $resultJSON2['tbody'] .= '<tr id="colT">
  <td>' . $row3["first_name"] . '  ' . $row3["last_name"] . '</td>
  <td>' . $row["appoint_datetime"] . '</td>
  <td>' . $row2["first_name"] . '</td>
  <td>' . $row2["last_name"] . '</td>
  <td>' . $row2["tel"] . '</td>
  <td>' . $row["appointment_status"] . '</td>
  </tr>';
  }
  echo json_encode($resultJSON2);
  }
  }

  if ($day == '7') {
  $sql = "SELECT * FROM appointment WHERE DATE(appoint_datetime) = DATE_ADD(DATE(NOW()), INTERVAL $day DAY) AND appointment_status <> 'G'";
  $result = $conn->query($sql);
  $resultJSON3['tbody'] = "";
  if ($result->num_rows > 0) {
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
  $patient_id = $row['patient_id'];
  $sql2 = "SELECT * FROM patient WHERE patient_id = " . $patient_id;
  // $first_name = $row['first_name'];
  $sql3 = "SELECT doctor.first_name,doctor.last_name,appointment.appoint_datetime FROM doctor, appointment WHERE doctor.doctor_id = appointment.doctor_id";
  $result2 = mysqli_query($conn, $sql2);
  $row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);
  $result3 = mysqli_query($conn, $sql3);
  $row3 = mysqli_fetch_array($result3, MYSQLI_ASSOC);
  if ($row["appointment_status"] == "R") {
  $row["appointment_status"] = '<center><a href="./change_appointment.php"><img class="st-im" alt="red" src="images/red.png" alt="Red"></a></center>';
  } else if ($row["appointment_status"] == "Y") {
  $row["appointment_status"] = '<center><a href="./appointment.php"><img class="st-im" alt="yellow" src="images/yellow.png" alt="yellow"></a></center>';
  } else if ($row["appointment_status"] == "G") {
  $row["appointment_status"] = '<center><a href="./appointment.php"><img class="st-im" alt="green" src="images/green.png" alt="green"></a></center>';
  }
  $resultJSON3['tbody'] .= '<tr id="colT">
  <td>' . $row3["first_name"] . '  ' . $row3["last_name"] . '</td>
  <td>' . $row3["appoint_datetime"] . '</td>
  <td>' . $row2["first_name"] . '</td>
  <td>' . $row2["last_name"] . '</td>
  <td>' . $row2["tel"] . '</td>
  <td>' . $row["appointment_status"] . '</td>
  </tr>';
  }
  echo json_encode($resultJSON3);
  }
  }
  if ($day == '1') {
  $sql = "SELECT * FROM appointment WHERE DATE(appoint_datetime) = DATE(NOW())";
  $result = $conn->query($sql);
  $resultJSON4['tbody'] = "";
  if ($result->num_rows > 0) {
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
  $patient_id = $row['patient_id'];
  // var_dump($patient_id);
  $sql2 = "SELECT * FROM patient WHERE patient_id = " . $patient_id;
  // $first_name = $row['first_name'];
  $sql3 = "SELECT doctor.first_name,doctor.last_name,appointment.appoint_datetime FROM doctor, appointment WHERE doctor.doctor_id = appointment.doctor_id";
  $result2 = mysqli_query($conn, $sql2);
  $row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);
  $result3 = mysqli_query($conn, $sql3);
  $row3 = mysqli_fetch_array($result3, MYSQLI_ASSOC);
  if ($row["appointment_status"] == "R") {
  $row["appointment_status"] = '<center><a href="#"><img class="st-im" alt="red" src="images/red.png"></a></center>';
  } else if ($row["appointment_status"] == "Y") {
  $row["appointment_status"] = '<center><a href="./change_appointmentRED.php?patient_id=' . $patient_id . '"><img class="st-im" alt="yellow" src="images/yellow.png"></a></center>';
  } else if ($row["appointment_status"] == "G") {
  $row["appointment_status"] = '<center><a href="./change_appointmentRED.php?patient_id=' . $patient_id . '"><img class="st-im" alt="green" src="images/green.png"></a></center>';
  }
  $resultJSON4['tbody'] .= '<tr id="colT">
  <td>' . $row3["first_name"] . '  ' . $row3["last_name"] . '</td>
  <td>' . $row3["appoint_datetime"] . '</td>
  <td>' . $row2["first_name"] . '</td>
  <td>' . $row2["last_name"] . '</td>
  <td>' . $row2["tel"] . '</td>
  <td>' . $row["appointment_status"] . '</td>
  </tr>';
  }
  echo json_encode($resultJSON4);
  }
  } */
//<td>'.$row["patient_id"].'</td>
?>