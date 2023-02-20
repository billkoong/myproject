<?php $connect = mysqli_connect("localhost", "root", "", "databases") or die("error");

// $connect = new PDO("mysql:host=localhost;dbname=PJ1","root","");
// $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type");
session_start();
// รับค่าที่ส่งมาแปลงเป็น json ให้ php เข้าใจ 
$request = json_decode(file_get_contents("php://input"));
$data = array();
?>

<?php
//login
if ($request->action == "signin") {
  $data = array(":username" => $request->username, ":password" => $request->pass);
  $username = $data[":username"];
  $pass = $data[":password"];
  if (empty($username)) {
    echo json_encode("กรุณาใส่ username");
  } else if (empty($pass)) {
    echo json_encode("กรุณาใส่ password");
  } else {
    $sql = "SELECT * FROM `member` WHERE `username` = '$username' AND `password` = '$pass'";
    $query = mysqli_query($connect, $sql);
    if (mysqli_num_rows($query) == 1) {
      while ($row = $query->fetch_assoc()) {
        $data[] = $row;
      }
      echo json_encode($data);
      json_encode(true);
    } else {
      echo json_encode("username หรือ password ไม่ถูกต้อง");
    }
  }
}

//ช่องค้นหาแบบเจาะจง
if ($request->action == "searcdata") {
  $result = $connect->query("SELECT a.`RP_property`, a.`RP_property_number`, a.`RP_disrepair` , b.status 
  FROM `item_report` a , `report` b WHERE a.ID_reoprt=b.ID_RP AND a.RP_property LIKE '%$request->search%' AND b.status LIKE '%$request->status%';");
  while ($row = $result->fetch_assoc()) {
    $data[] = $row;
  }
  echo json_encode($data);
}

//ช่องค้นหาแบบทั้งหมด
if ($request->action == "searcalldata") {
  $result = $connect->query("SELECT a.`RP_property`, a.`RP_property_number`, a.`RP_disrepair` , b.status 
  FROM `item_report` a , `report` b WHERE a.ID_reoprt=b.ID_RP AND a.RP_property LIKE '%$request->search%';");
  while ($row = $result->fetch_assoc()) {
    $data[] = $row;
  }
  echo json_encode($data);
}


// มาจาก reportuser2 บันทึกลงฐานข้อมูล 
if ($request->action == "submitfromdata") {


  $data = array(
    ":id_user" => $request->id_user,
    ":RP_count_unit" => $request->addfroms[0]->RP_count_unit,
    ":RP_reason" => $request->addfroms[0]->RP_reason,
    ":RP_director1" => $request->addfroms[0]->RP_director1,
    ":RP_director2" => $request->addfroms[0]->RP_director2,
    ":RP_director3" => $request->addfroms[0]->RP_director3,
    ":status" => $request->status
  );
  date_default_timezone_set("Asia/Bangkok");
  $ID_MB = $data[":id_user"];
  $RP_date = date("Y-m-d ");
  $RP_time = date("H:i");
  $RP_count_unit = $data[":RP_count_unit"];
  $RP_reason = $data[":RP_reason"];

  $RP_director1 = $data[":RP_director1"];
  $RP_director2 = $data[":RP_director2"];
  $RP_director3 = $data[":RP_director3"];
  $status = $data[":status"];

  // บันทึกข้อมูลตาราง report
  $sql = "INSERT INTO `report`(`ID_MB`, `RP_date`, `RP_time`, `RP_count_unit`, `RP_reason`, `RP_director1`, `RP_director2`, `RP_director3`, `status`, `type`)
                       VALUES ('$ID_MB','$RP_date','$RP_time','$RP_count_unit','$RP_reason','$RP_director1','$RP_director2','$RP_director3','$status','$request->type')";
  $query = mysqli_query($connect, $sql);
  // ดึง ไอดี ล่าสุดมาจากตาราง userreport
  $select_id = $connect->query("SELECT `ID_RP` FROM `report` WHERE 1  ORDER BY `report`.`ID_RP` DESC;");
  $row = $select_id->fetch_assoc();

  // บันทึกข้อมูล ตามจำนวนที่มี
  for ($i = 0; $i < count($request->addfroms); $i++) {

    $data2 = array(
      ":RP_property" => $request->addfroms[$i]->RP_property,
      ":RP_property_number" => $request->addfroms[$i]->RP_property_number,
      ":RP_disrepair" => $request->addfroms[$i]->RP_disrepair,
    );


    $RP_property = $data2[":RP_property"];
    $RP_property_number = $data2[":RP_property_number"];
    $RP_disrepair = $data2[":RP_disrepair"];

    $sql2 = "INSERT INTO `item_report`(`ID_reoprt`, `RP_property`, `RP_property_number`, `RP_disrepair`)
     VALUES ('$row[ID_RP]','$RP_property','$RP_property_number','$RP_disrepair')";
    $query2 = mysqli_query($connect, $sql2);
  }

  //  messsage line
  //bu   MV1UyZcrqYBL6W5kPV4waoSD2IVKaRMCiwAJgxIjg21
  //ao   HjjPGIOAyRZjVXbRzB3YOfoKDsrZ1lTMqXtdfdFtJ91
  //it  MYbruMFCUigHDKGXElYEbJPUZS6NE9EV3JmGU7FMTog
  if ($query) {
    if ($request->type == "ครุภัณฑ์ทั่วไป เช่น พัดลม แอร์ หน้าต่าง") {
      $sToken = "MV1UyZcrqYBL6W5kPV4waoSD2IVKaRMCiwAJgxIjg21";

      $sMessage = "แจ้งเตือนมีคำร้องขอซ่อมใหม่!\r\n";
      $sMessage .= "วันที่ : " . $RP_date . "\r\n";
      $sMessage .= "เวลา : " . $RP_time . "\r\n";
      $sMessage .= "หน่วยงานที่แจ้งซ่อม : " . $RP_count_unit . "\r\n";
      $r = 1;
      for ($i = 0; $i < count($request->addfroms); $i++) {
        $sMessage .= "ลำดับที่ : " . $r . "\r\n";
        $sMessage .= "ทรัพย์สินที่ต้องการซ่อม : " . $request->addfroms[$i]->RP_property . "\r\n";
        $sMessage .= "หมายเลขครุภัณฑ์ : " . $request->addfroms[$i]->RP_property_number . "\r\n";
        $sMessage .= "สภาพชำรุดโดยละเอียด : " . $request->addfroms[$i]->RP_disrepair . "\r\n";
        $r++;
        $sMessage .= "\r\n";
      }
      $sMessage .= "\r\n";
      $sMessage .= "ขอให้พนักงานหน่วยอาคารเข้าดำเนินการตรวจสอบตามรายการที่แจ้งข้างต้น" . "\r\n";
      $sMessage .= "\r\n";
      $sMessage .= "หลังตรวจสอบแล้วกรุณากรอกข้อมูลหลังตรวจสอบที่ http://localhost:8080/login\r\n";


      $chOne = curl_init();
      curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
      curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($chOne, CURLOPT_POST, 1);
      curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $sMessage);
      $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $sToken . '', );
      curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
      $result = curl_exec($chOne);
    } else {
      $sToken = "MYbruMFCUigHDKGXElYEbJPUZS6NE9EV3JmGU7FMTog";

      $sMessage = "แจ้งเตือนมีคำร้องขอซ่อมใหม่!\r\n";
      $sMessage .= "วันที่ : " . $RP_date . "\r\n";
      $sMessage .= "เวลา : " . $RP_time . "\r\n";
      $sMessage .= "หน่วยงานที่แจ้งซ่อม : " . $RP_count_unit . "\r\n";
      $r = 1;
      for ($i = 0; $i < count($request->addfroms); $i++) {
        $sMessage .= "ลำดับที่ : " . $r . "\r\n";
        $sMessage .= "ทรัพย์สินที่ต้องการซ่อม : " . $request->addfroms[$i]->RP_property . "\r\n";
        $sMessage .= "หมายเลขครุภัณฑ์ : " . $request->addfroms[$i]->RP_property_number . "\r\n";
        $sMessage .= "สภาพชำรุดโดยละเอียด : " . $request->addfroms[$i]->RP_disrepair . "\r\n";
        $r++;
        $sMessage .= "\r\n";
      }
      $sMessage .= "\r\n";
      $sMessage .= "ขอให้พนักงานหน่วย IT เข้าดำเนินการตรวจสอบตามรายการที่แจ้งข้างต้น" . "\r\n";
      $sMessage .= "\r\n";
      $sMessage .= "หลังตรวจสอบแล้วกรุณากรอกข้อมูลหลังตรวจสอบที่ http://localhost:8080/login\r\n";

      $chOne = curl_init();
      curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
      curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($chOne, CURLOPT_POST, 1);
      curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $sMessage);
      $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $sToken . '', );
      curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
      $result = curl_exec($chOne);
    }
  }

  if ($query) {
    $ouptup = "completed";
    echo json_encode($ouptup);

  } else {
    $ouptup = "not completed";
    echo json_encode($ouptup);
  }


}
// adminreport ดึงค่าจาก ID มาแสดง
if ($request->action == "searchdata") {
  $result = $connect->query("SELECT * FROM `report` WHERE `ID_RP` = $request->id ");
  $row = $result->fetch_assoc();
  $data = $row;
  $result3 = $connect->query("SELECT * FROM `member` WHERE `ID_MB` = $request->id_rc ");
  $row3 = $result3->fetch_assoc();
  $data3 = $row3;
  $result4 = $connect->query("SELECT * FROM `recheck` WHERE `ID_RP` = $request->id  ");
  $row4 = $result4->fetch_assoc();
  $data4 = $row4;
  $result2 = $connect->query(" SELECT  * FROM `item_report`   WHERE `ID_reoprt` = $request->id ");
  while ($row2 = $result2->fetch_assoc()) {
    $data2[] = $row2;
  }
  date_default_timezone_set("Asia/Bangkok");
  $date = date("m-d-y");
  if ($data4 == []) {
    $data4 = array("a");
  }
  $data5[] = array_merge($data, $data2, $data3, $data4);
  class all
  {
    public $data1 = '';
    public $data2 = '';
  }
  $all = new all();
  $all->data1 = $data5;
  $all->data2 = $date;
  echo json_encode($all);

}
// adminreport ดึงค่า 'ขอแจ้งซ่อมสำเร็จ'  มาแสดง
if ($request->action == "statusdata") {
  $result = $connect->query("SELECT * FROM `report` WHERE `status` LIKE 'ขอแจ้งซ่อมสำเร็จ' 
                              AND `type` LIKE '$request->pass' ORDER BY `report`.`RP_time` DESC; ");
  if (mysqli_num_rows($result) != 0) {
    while ($row = $result->fetch_assoc()) {
      $data[] = $row;
      $result2 = $connect->query("SELECT * FROM `item_report` WHERE `ID_reoprt` = $row[ID_RP] ");
      while ($row2 = $result2->fetch_assoc()) {
        $data2[] = $row2;
      }
      $data3[] = array_merge($data, $data2);
      unset($data2);
      unset($data);
    }
    echo json_encode($data3);
  } else {
    echo json_encode("ไม่พบข้อมูล");
  }
}
// adminreport ดึงค่า 'ช่างตรวจสอบแล้ว'  มาแสดงเพื่อแก้ไข
if ($request->action == "statusdata2") {
  $result = $connect->query("SELECT * FROM `report` WHERE `status` LIKE 'ช่างตรวจสอบแล้ว' 
                              AND `type` LIKE '$request->pass' ORDER BY `report`.`RP_time` DESC; ");
  if (mysqli_num_rows($result) != 0) {
    while ($row = $result->fetch_assoc()) {
      $data[] = $row;
      $result2 = $connect->query("SELECT * FROM `item_report` WHERE `ID_reoprt` = $row[ID_RP] ");
      while ($row2 = $result2->fetch_assoc()) {
        $data2[] = $row2;
      }
      $data3[] = array_merge($data, $data2);
      unset($data2);
      unset($data);
    }
    echo json_encode($data3);
  } else {
    echo json_encode("ไม่พบข้อมูล");
  }
}
// MPYreport ดึงค่า 'ช่างตรวจสอบแล้ว'  มาแสดง
if ($request->action == "statusdataemployee") {
  $result = $connect->query("SELECT * FROM `report` WHERE `status` LIKE 'ช่างตรวจสอบแล้ว' ORDER BY `report`.`RP_time` DESC; ");
  if (mysqli_num_rows($result) != 0) {
    while ($row = $result->fetch_assoc()) {
      $data[] = $row;
      $result2 = $connect->query("SELECT * FROM `item_report` WHERE `ID_reoprt` = $row[ID_RP] ");
      while ($row2 = $result2->fetch_assoc()) {
        $data2[] = $row2;
      }
      $data3[] = array_merge($data, $data2);
      unset($data2);
      unset($data);
    }
    echo json_encode($data3);
  } else {
    echo json_encode("ไม่พบข้อมูล");
  }
}
// MPYreport ดึงค่า 'รอการอนุมัติ'  มาแสดงเพื่อแก้ไข
if ($request->action == "statusdataemployee2") {
  $result = $connect->query("SELECT * FROM `report` WHERE `status` LIKE 'รอการอนุมัติ'  ORDER BY `report`.`RP_time` DESC; ");
  if (mysqli_num_rows($result) != 0) {
    while ($row = $result->fetch_assoc()) {
      $data[] = $row;
      $result2 = $connect->query("SELECT * FROM `item_report` WHERE `ID_reoprt` = $row[ID_RP] ");
      while ($row2 = $result2->fetch_assoc()) {
        $data2[] = $row2;
      }
      $data3[] = array_merge($data, $data2);
      unset($data2);
      unset($data);
    }
    echo json_encode($data3);
  } else {
    echo json_encode("ไม่พบข้อมูล");
  }
}

if ($request->action == "searchdataMPY") {
  $result = $connect->query("SELECT * FROM `report` WHERE `ID_RP` = $request->id ");
  $row = $result->fetch_assoc();
  $data = $row;
  $result4 = $connect->query("SELECT * FROM `recheck` WHERE `ID_RP` = $request->id  ");
  $row4 = $result4->fetch_assoc();
  $data4 = $row4;
  $result2 = $connect->query(" SELECT  * FROM `item_report`   WHERE `ID_reoprt` = $request->id ");
  while ($row2 = $result2->fetch_assoc()) {
    $data2[] = $row2;
  }
  date_default_timezone_set("Asia/Bangkok");
  $date = date("m-d-y");
  if ($data4 == []) {
    $data4 = array("a");
  }
  $data5[] = array_merge($data, $data4);
  class all
  {
    public $data1 = '';
    public $data2 = '';
  }
  $all = new all();
  $all->data1 = $data5;
  $all->data2 = $data2;
  echo json_encode($all);
  // echo json_encode($data5);

}

if ($request->action == "searchdataMPY2") {
  $name_item = $request->name_item;
  for ($i = 0; $i < count($name_item); $i++) {
    $result = $connect->query("SELECT b.ID_RP,a.RP_property, a.`RC_limit` FROM `item_report` a , `report` b 
  WHERE a.`RP_property` LIKE '$name_item[$i]' AND b.status='กรรมการตรวจรับพัสดุเรียบร้อยแล้ว' AND a.ID_reoprt=b.ID_RP ORDER BY `b`.`ID_RP` DESC");
    $row = $result->fetch_assoc();
    $data[] = $row;
  }
  echo json_encode($data);
}


if ($request->action == "savedata") {
  $result = $connect->query("SELECT * FROM `report` WHERE `ID_RP` = $request->id ");
  $row = $result->fetch_assoc();
  $data = $row;
  $result3 = $connect->query("SELECT  `Fname`, `Lname` FROM `member` WHERE  `ID_MB` = $row[ID_MB] ");
  $row3 = $result3->fetch_assoc();
  $data3 = $row3;
  $result4 = $connect->query("SELECT * FROM `recheck` WHERE `ID_RP` = $request->id  ");
  $row4 = $result4->fetch_assoc();
  $data4 = $row4;
  $result2 = $connect->query(" SELECT  * FROM `item_report`   WHERE `ID_reoprt` = $request->id ");
  while ($row2 = $result2->fetch_assoc()) {
    $data2[] = $row2;
  }

  if ($data4 == []) {
    $data4 = array("a");
  }
  $data5[] = array_merge($data, $data3, $data2, $data4);
  // class all
  // {
  //   public $data1 = '';
  //   public $data2 = '';
  // }
  // $all = new all();
  // $all->data1 = $data5;
  // $all->data2 = $date;
  // echo json_encode($all);
  echo json_encode($data5);

}






// หน่วยที่เกี่ยวข้องบันทึกข้อมูลหลังตรวจสอบ
if ($request->action == "submitfromdataupdate") {
  if ($request->RC_status == true) {
    $RC_status = "เห็นควรจ้างร้าน";
  } else {
    $RC_status = "สามารถซ่อมเองได้";
  }
  if ($request->type == "ครุภัณฑ์ทั่วไป เช่น พัดลม แอร์ หน้าต่าง") {
    $munber = "bu089-999-9999";
    $gmail = "bu@gmail.com";
  } else {
    $munber = "it089-999-9999";
    $gmail = "it@gmail.com";
  }
  date_default_timezone_set("Asia/Bangkok");
  $date = date("y-m-d");
  $time = date("H:i");
  $result = $connect->query("INSERT INTO `recheck`( `ID_RP`, `RC_date`, `RC_ID`, `RC_result`, `RC_name`,`RC_status`) 
  VALUES ('$request->id','$date','$request->RC_ID','$request->adminData','$request->adminName','$RC_status')");
 $result4 = $connect->query("SELECT `ID_MB` FROM `report` WHERE `ID_RP` = $request->id  ");
 $row4 = $result4->fetch_assoc();

 $result5 = $connect->query("SELECT `email` FROM `member` WHERE `ID_MB` = $row4[ID_MB]  ");
 $row5 = $result5->fetch_assoc();
  if ($result) {
    // message line
    if ($RC_status == "เห็นควรจ้างร้าน") {
      $sql = $connect->query("UPDATE `report` SET `status`='$request->status' WHERE `ID_RP` = $request->id");
      $sToken = "HjjPGIOAyRZjVXbRzB3YOfoKDsrZ1lTMqXtdfdFtJ91";
      $sMessage = "แจ้งเตือนใหม่!\r\n";
      $sMessage .= "\r\n";
      $sMessage .= "วันที่ : " . $date . "\r\n";
      $sMessage .= "เวลา : " . $time . "\r\n";
      $sMessage .= "เจ้าหน้าที่" . $request->agency . "\r" . "ได้ทำการตรวจสอบตามคำร้องขอซ่อมของ" .
        $request->RP_count_unit . "\r" . "จากการตรวจสอบพบว่า : " . $request->adminData . "\r\n";
      $sMessage .= "\r\n";
      // $sMessage .= "จึงเห็นควรจ้างร้าน\r\n";
      $sMessage .= "ชื่อผู้ตรวจเช็ก :  " . $request->adminName . "\r\n";
      $sMessage .= "\r\n";
      $sMessage .= "ขอให้หน่วยพัสดุทำการติดต่อร้านและทำการกำหนดวงเงินในการซ่อม\r\n";
      $sMessage .= "รายละเอียดคำร้อง http://localhost:8080/loginMPY\r\n";

      $chOne = curl_init();
      curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
      curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($chOne, CURLOPT_POST, 1);
      curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $sMessage);
      $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $sToken . '', );
      curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
      $result = curl_exec($chOne);

      echo json_encode("บันทึกข้อมูลแล้ว");
    } elseif ($RC_status == "สามารถซ่อมเองได้") {
      $sql = $connect->query("UPDATE `report` SET `status`='ซ่อมสำเร็จ' WHERE `ID_RP` = $request->id");
      // message email
      $mail = new PHPMailer(true);

      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'novakoong@gmail.com';
      $mail->Password = 'hvzhcjkugfrrvbtd';
      $mail->SMTPSecure = 'ssl';
      $mail->Port = 465;

      $mail->setFrom('novakoong@gmail.com');

      $mail->addAddress($row5['email']);
      // $mail->addAddress("salisa.na@rmuti.ac.th");

      $mail->isHTML(true);

      $mail->Subject = "There is a new notification from your repair hire request.";
      $mail->Body =
        "วันที่ : " . $date . "<br/>" . "เวลา: " . $time . "<br/>" .
        "จากคำร้องขอซ่อมที่ส่งมา เจ้าหน้าที่" . $request->agency . "\r" . "ได้ทำการตรวจสอบแล้ว" . "<br/>"
        . "จากการตรวจสอบพบว่า : " . $request->adminData . "<br/>"
        . "สามารถดำเนินการซ่อมได้เลย และดำเนินการซ่อมเสร็จแล้ว <br/>
          <br/>
          !! โปรดตรวจสอบทรัพย์สินที่ท่านขอแจ้งซ่อมว่ากลับมาใช้งานได้ปกติแล้วหรือไม่ !!<br/>
          <br/>
          หากเกิดปัญหาขัดข้องกรุณาแจ้งมาที่หน่วยงานของเรา<br/>
          เบอร์ติดต่อ :  $munber  ($request->agency)<br/>
          หรือ Email : $gmail <br/>";

      $mail->send();
      echo json_encode("แจ้งไปยังผู้ขอแจ้งซ่อมแล้ว");
    }
  } else {
    echo json_encode("บันทึกข้อมูลไม่สำเร็จ");
  }
}
// หน่วยที่เกี่ยวข้องบันทึกข้อมูลหลังตรวจสอบ แก้ไข
if ($request->action == "savefromdataupdate") {
  if ($request->RC_status == true) {
    $RC_status = "เห็นควรจ้างร้าน";

  } else {
    $RC_status = "สามารถซ่อมเองได้";
  }
  if ($request->type == "ครุภัณฑ์ทั่วไป เช่น พัดลม แอร์ หน้าต่าง") {
    $munber = "bu089-999-9999";
    $gmail = "bu@gmail.com";
  } else {
    $munber = "it089-999-9999";
    $gmail = "it@gmail.com";
  }
  $date = date("y-m-d");

  $result4 = $connect->query("SELECT `ID_MB` FROM `report` WHERE `ID_RP` = $request->id  ");
  $row4 = $result4->fetch_assoc();

  $result5 = $connect->query("SELECT `email` FROM `member` WHERE `ID_MB` = $row4[ID_MB]  ");
  $row5 = $result5->fetch_assoc();

  $result = $connect->query("UPDATE `recheck` SET `RC_date`='$date',`RC_ID`='$request->RC_ID',`RC_result`='$request->adminData',
  `RC_name`='$request->adminName',`RC_status`='$RC_status' WHERE  `ID_RP` = '$request->id'");
  if ($result) {
    // message line
    if ($RC_status == "เห็นควรจ้างร้าน") {
      $sToken = "HjjPGIOAyRZjVXbRzB3YOfoKDsrZ1lTMqXtdfdFtJ91";
      $sMessage = "แจ้งเตือน มีการแก้ไขข้อมูล!!\r\n";
      $sMessage .= "\r\n";
      $sMessage .= "วันที่ : " . $date . "\r\n";
      $sMessage .= "เวลา : " . $time . "\r\n";

      $sMessage .= "เจ้าหน้าที่" . $request->agency . "\r" . "ได้ทำการตรวจสอบตามคำร้องขอซ่อมของ" .
        $request->RP_count_unit . "\r" . "จากการตรวจสอบพบว่า : " . $request->adminData . "\r\n";
        $sMessage .= "\r\n";
      // $sMessage .= "จึงเห็นควรจ้างร้าน\r\n";
      $sMessage .= "ชื่อผู้ตรวจเช็ก :  " . $request->adminName . "\r\n";
      $sMessage .= "\r\n";
      $sMessage .= "ขอให้หน่วยพัสดุทำการติดต่อร้านและทำการกำหนดวงเงินในการซ่อม\r\n";
      $sMessage .= "รายละเอียดคำร้อง http://localhost:8080/loginMPY\r\n";

      $chOne = curl_init();
      curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
      curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($chOne, CURLOPT_POST, 1);
      curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $sMessage);
      $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $sToken . '', );
      curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
      $result = curl_exec($chOne);

      echo json_encode("บันทึกการแก้ไขแล้ว");
    } elseif ($RC_status == "สามารถซ่อมเองได้") {
      // message email
      $mail = new PHPMailer(true);

      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'novakoong@gmail.com';
      $mail->Password = 'hvzhcjkugfrrvbtd';
      $mail->SMTPSecure = 'ssl';
      $mail->Port = 465;

      $mail->setFrom('novakoong@gmail.com');

      $mail->addAddress($row5['email']);
      // $mail->addAddress("salisa.na@rmuti.ac.th");

      $mail->isHTML(true);

      $mail->Subject = "There is a new notification from your repair hire request.";
      $mail->Body =
        "วันที่ : " . $date . "<br/>" ."เวลา: " . $time . "<br/>" .
        "จากคำร้องขอซ่อมที่ส่งมา เจ้าหน้าที่" . $request->agency . "\r" . "ได้ทำการตรวจสอบแล้ว" . "<br/>"
        . "จากการตรวจสอบพบว่า : " . $request->adminData . "<br/>"
        . "สามารถดำเนินการซ่อมได้เลย และดำเนินการซ่อมเสร็จแล้ว <br/>
        <br/>
        !! โปรดตรวจสอบทรัพย์สินที่ท่านขอแจ้งซ่อมว่ากลับมาใช้งานได้ปกติแล้วหรือไม่ !!<br/>
        <br/>
        หากเกิดปัญหาขัดข้องกรุณาแจ้งมาที่หน่วยงานของเรา<br/>
        เบอร์ติดต่อ :  $munber  ($request->agency)<br/>
        หรือ Email : $gmail <br/>";

      $mail->send();
      echo json_encode("แจ้งแก้ไขไปยังผู้ขอแจ้งซ่อมแล้ว");
    }
  } else {
    echo json_encode("บันทึกข้อมูลไม่สำเร็จ");
  }
}



// homeuser แสดงข้อมูล report ของ user
if ($request->action == "getalldataMB") {
  $result = $connect->query("SELECT * FROM `report` WHERE `ID_MB` LIKE '$request->id_user'  ORDER BY `report`.`RP_time` DESC; ");
  if (mysqli_num_rows($result) != 0) {
    while ($row = $result->fetch_assoc()) {
      $data[] = $row;
      $result2 = $connect->query("SELECT * FROM `item_report` WHERE `ID_reoprt` = $row[ID_RP] ");

      while ($row2 = $result2->fetch_assoc()) {
        $data2[] = $row2;
      }
      $data3[] = array_merge($data, $data2);
      unset($data2);
      unset($data);
    }

    echo json_encode($data3);
  } else {
    echo json_encode("ไม่พบข้อมูล");
  }

}
if ($request->action == "getalldata") {
  $result = $connect->query("SELECT * FROM `report` WHERE  1 ORDER BY `report`.`status` DESC; ");
  if (mysqli_num_rows($result) != 0) {
    while ($row = $result->fetch_assoc()) {
      $data[] = $row;
      $result2 = $connect->query("SELECT * FROM `item_report` WHERE `ID_reoprt` = $row[ID_RP] ");

      while ($row2 = $result2->fetch_assoc()) {
        $data2[] = $row2;
      }
      $data3[] = array_merge($data, $data2);
      unset($data2);
      unset($data);
    }

    echo json_encode($data3);
  } else {
    echo json_encode("ไม่พบข้อมูล");
  }

}


// mpyreport2
if ($request->action == "MPYsave") {
  $RC_limit = $request->RC_limit;
  $RC_latest_limit = $request->RC_latest_limit;
  $ID_item = $request->ID_item;

  date_default_timezone_set("Asia/Bangkok");
  $RC_date = date("Y-m-d ");
  $RC_time = date("H:i");

  for ($i = 0; $i < count($RC_limit); $i++) {

    $result = $connect->query("UPDATE `item_report` SET `RC_limit`='$RC_limit[$i]', `RC_latest_limit`='$RC_latest_limit[$i]' 
       WHERE `ID_item` = $ID_item[$i]");
  }
  $sql = $connect->query("UPDATE `report` SET `status`='$request->status' WHERE `ID_RP` = $request->id");
  $sql2 = $connect->query("UPDATE `recheck` SET `ID_AO`='$request->ID_AO',`RC_date_AO`='$RC_date',`RC_time_AO`='$RC_time' WHERE `ID_RP` = $request->id");
  $result4 = $connect->query("SELECT `ID_MB` FROM `report` WHERE `ID_RP` = $request->id  ");
  $row4 = $result4->fetch_assoc();

  $result5 = $connect->query("SELECT `email` FROM `member` WHERE `ID_MB` = $row4[ID_MB]  ");
  $row5 = $result5->fetch_assoc();

  // message email
  $mail = new PHPMailer(true);

  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';
  $mail->SMTPAuth = true;
  $mail->Username = 'novakoong@gmail.com';
  $mail->Password = 'hvzhcjkugfrrvbtd';
  $mail->SMTPSecure = 'ssl';
  $mail->Port = 465;

  $mail->setFrom('novakoong@gmail.com');

  $mail->addAddress($row5['email']);


  $mail->isHTML(true);

  $mail->Subject = "There is a new notification from your repair hire request.";
  $mail->Body =
    "วันที่ : " . $RC_date . "<br/>" ."เวลา: " . $RC_time . "<br/>" .
    "จากคำร้องขอซ่อมที่ส่งมา เจ้าหน้าที่หน่วยพัสดุ ได้กำหนดวงเงินเรียบร้อยแล้ว ขอให้ท่านดำเนิดการพิมพ์เอกสารคำร้อง แบบ-พด.-05 
       จากระบบเพื่อขออนุมัติจากหัวหน้าหัวของท่านแล้วนำส่งหน่วยพัสดุ เพื่อดำเนินการต่อ <br/>
       <br/>
       พิมพ์เอกสารที่ http://localhost:8081/<br/>
       <br/>
       หากเกิดปัญหาขัดข้องกรุณาแจ้งมาที่หน่วยงานของเรา<br/>
       เบอร์ติดต่อ :  099-999-9999  (หน่วยพัสดุ)<br/>
       หรือ Email : หน่วยพัสดุ@gmail.com <br/>";

  $mail->send();
  echo json_encode("แจ้งไปยังผู้ขอแจ้งซ่อมแล้ว");
}

if ($request->action == "MPYcheck") {
  $result = $connect->query("SELECT * FROM `report` WHERE `status` LIKE 'รอการอนุมัติ'  ORDER BY `report`.`RP_time` DESC; ");
  if (mysqli_num_rows($result) != 0) {
    while ($row = $result->fetch_assoc()) {
      $data[] = $row;
      $result2 = $connect->query("SELECT * FROM `item_report` WHERE `ID_reoprt` = $row[ID_RP] ");
      while ($row2 = $result2->fetch_assoc()) {
        $data2[] = $row2;
      }
      $data3[] = array_merge($data, $data2);
      unset($data2);
      unset($data);
    }
    echo json_encode($data3);
  } else {
    echo json_encode("ไม่พบข้อมูล");
  }
}
if ($request->action == "MPYcheck2") {
  $result = $connect->query("SELECT * FROM `report` WHERE `status` LIKE 'อนุมัติแล้วกำลังดำเนินการซ่อม'  ORDER BY `report`.`RP_time` DESC; ");
  if (mysqli_num_rows($result) != 0) {
    while ($row = $result->fetch_assoc()) {
      $data[] = $row;
      $result2 = $connect->query("SELECT * FROM `item_report` WHERE `ID_reoprt` = $row[ID_RP] ");
      while ($row2 = $result2->fetch_assoc()) {
        $data2[] = $row2;
      }
      $data3[] = array_merge($data, $data2);
      unset($data2);
      unset($data);
    }
    echo json_encode($data3);
  } else {
    echo json_encode("ไม่พบข้อมูล");
  }
}


if ($request->action == "อนุมัติแล้วกำลังดำเนินการซ่อม") {
  $sql = $connect->query("UPDATE `report` SET `status`='$request->action' WHERE `ID_RP` = $request->id");
  if ($sql) {
    echo json_encode("อัปเดตเรียบร้อย");
  } else {
    echo json_encode("เกิดข้อผิดผลาดกรุณาลองใหม่");
  }
}

if ($request->action == "ไม่ผ่านการอนุมัติ") {
  $sql = $connect->query("UPDATE `report` SET `status`='$request->action' , `Comments`='$request->comments' WHERE `ID_RP` = $request->id");
  if ($sql) {
    echo json_encode("อัปเดตเรียบร้อย");
  } else {
    echo json_encode("เกิดข้อผิดผลาดกรุณาลองใหม่");
  }
}
if ($request->action == "กรรมการตรวจรับพัสดุเรียบร้อยแล้ว") {
  $sql = $connect->query("UPDATE `report` SET `status`='$request->action' , `Comments`='$request->comments' WHERE `ID_RP` = $request->id");
  if ($sql) {
    echo json_encode("อัปเดตเรียบร้อย");
  } else {
    echo json_encode("เกิดข้อผิดผลาดกรุณาลองใหม่");
  }
}
?>