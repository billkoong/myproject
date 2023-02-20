<?php $connect = mysqli_connect("localhost","root","","test") or die("error");

// $connect = new PDO("mysql:host=localhost;dbname=PJ1","root","");
// $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type");
session_start();
  // รับค่าที่ส่งมาแปลงเป็น json ให้ php เข้าใจ 
$request = json_decode(file_get_contents("php://input"));
$data = array();
?>
<?php $errors = array(); ?>

<?php if (count($errors) > 0) : ?>
    <div class="error">
        <?php foreach ($errors as $error) : ?>
            <p><?php echo $error ?></p>
            <?php endforeach ?>
    </div>
<?php endif ?>



<?php
// message line
  //ao   MV1UyZcrqYBL6W5kPV4waoSD2IVKaRMCiwAJgxIjg21
  //bu   HjjPGIOAyRZjVXbRzB3YOfoKDsrZ1lTMqXtdfdFtJ91
  //it  MYbruMFCUigHDKGXElYEbJPUZS6NE9EV3JmGU7FMTog
if($request->action == "gmailto"){

  $sToken = "keYjwRYYNdr0yhh2OzFAwJ7iaZlTlidYftoztcNH9Bm";
  $sMessage = "แจ้งเตือนการสมัครสมาชิก!\r\n";
  $chOne = curl_init(); 
  curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
  curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
  curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
  curl_setopt( $chOne, CURLOPT_POST, 1); 
  curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 
  $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
  curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
  curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
  $result = curl_exec( $chOne ); 


}
?>


<?php
//ช่องค้นหาแบบเจาะจง
if ($request->action == "searcdata"){
  $result = $connect->query("SELECT a.ID_U_RP, a.URP_name, a.URP_munber, a.URP_condition,b.status_name 
  FROM userreport a , statuss b WHERE a.URP_name LIKE '%$request->search%' AND b.status_name LIKE '$request->status' AND a.ID_U_RP = b.ID_U_RP 
  ORDER BY `a`.`ID_U_RP` DESC;
  ");
  while ($row = $result->fetch_assoc()) {
    $data[]=$row;
  }
  echo json_encode($data);
}

//ช่องค้นหาแบบทั้งหมด
if ($request->action == "searcalldata"){
  $result = $connect->query("SELECT a.ID_U_RP, a.URP_name, a.URP_munber, a.URP_condition,b.status_name 
  FROM userreport a , statuss b WHERE a.URP_name LIKE '%$request->search%' AND a.ID_U_RP = b.ID_U_RP 
  ORDER BY `a`.`ID_U_RP` DESC;
  ");
  while ($row = $result->fetch_assoc()) {
    $data[]=$row;
  }
  echo json_encode($data);
}




//register
if($request->action == "signup"){ //ถ้ามีการกด submit มา จะทำ
  $data = array(":username"=>$request->user,":pass1"=>$request->pass1,":pass2"=>$request->pass2,":email"=>$request->email);

  $username = $data[":username"];
  $pass1 = $data[":pass1"];
  $pass2 = $data[":pass2"];
  $email = $data[":email"];
  // $status = $data[":status"]; 
  
  // เช็กว่าไม่เป็นค่าว่าง
  if(empty($email)){
     
      echo json_encode("กรุณาใส่ gmail");

  }else if(empty($pass1)){
      
      echo json_encode("กรุณาใส่ password ");

  }else if(empty($pass2)){
    
    echo json_encode("กรุณา confirm password ");

  }else if(empty($username)){
      
      
      echo json_encode("กรุณาใส่ username");

  }else{
  ////
  $check_member = "SELECT * FROM users WHERE username = '$username' or gmail = '$email' ";
  $query = mysqli_query($connect, $check_member);
  $result = mysqli_fetch_assoc($query);
      // เช็กว่ามี user อยู่แล้วหรือยัง
    if ($result){
          if($result['username'] === $username){
              echo json_encode("มี username นี้อยู่แล้ว");
          }else if($result['email'] === $email){
              echo json_encode("มี gmail นี้อยู่แล้ว");
          }
    }else
    if(count($errors) == 0 ){
      $sql = "INSERT INTO users (`username`,`password1`,`password2`,`gmail`) VALUES('$username','$pass1','$pass2','$email')";
      $query = mysqli_query($connect, $sql);
      echo json_encode("สมัครสมาชิกเรียบร้อย");
             
    }else{
      array_push($errors, "");
              
              echo json_encode("สมัครสมาชิกไม่สำเร็จ กรุณาลองใหม่อีกครั้งในภายหลัง!!!!!");
   }
  }
}
//login
if($request->action == "signin"){
  $data = array(":username"=>$request->user,":password"=>$request->pass);
  $user = $data[":username"];
  $pass = $data[":password"];

  if(empty($user)){          
          echo json_encode("กรุณาใส่ Username");
  }else if(empty($pass)){
      echo json_encode("กรุณาใส่ password");
  
  }else if(count($errors) == 0 ){
       $sql = "SELECT * FROM `users` WHERE `username` = '$user' AND `password1` = '$pass'";
       $query = mysqli_query($connect, $sql);
      if(mysqli_num_rows($query) == 1 ){
        while ($row = $query->fetch_assoc()) {
          $data[]=$row;
        }
        echo json_encode($data);
         json_encode(true);
      }else{
          echo json_encode("Username หรือ password ไม่ถูกต้อง");
      }
  }
}
//login RP
if($request->action == "signinRP"){
  $data = array(":password"=>$request->pass);
 
  $pass = $data[":password"];

  if(empty($pass)){
      echo json_encode("กรุณาใส่ password");
  
  }else if(count($errors) == 0 ){
       $sql = "SELECT * FROM `admin_rp` WHERE `AdminPassword` = '$pass'";
       $query = mysqli_query($connect, $sql);
      if(mysqli_num_rows($query) == 1 ){
        while ($row = $query->fetch_assoc()) {
          $data[]=$row;
        }
        echo json_encode($data);
         json_encode(true);
      }else{
          echo json_encode("password ไม่ถูกต้อง");
      }
  }
}
//login MPY
if($request->action == "signinMPY"){
  $data = array(":password"=>$request->pass);
 
  $pass = $data[":password"];

  if(empty($pass)){
      echo json_encode("กรุณาใส่ password");
  
  }else if(count($errors) == 0 ){
       $sql = "SELECT * FROM `admin_mpy` WHERE `AdminPassword` = '$pass'";
       $query = mysqli_query($connect, $sql);
      if(mysqli_num_rows($query) == 1 ){
        while ($row = $query->fetch_assoc()) {
          $data[]=$row;
        }
        echo json_encode($data);
         json_encode(true);
      }else{
          echo json_encode("password ไม่ถูกต้อง");
      }
  }
}



// MPY_RP2
if($request->action == "MPYsubmit"){
  $sql= "INSERT INTO `employeereport`( `ID_MPY`, `ID_RP_RP`, `MPY_money`, `MPY_last`) 
  VALUES ('$request->ID_MPY','$request->ID_RP_RP','$request->before','$request->after')";
  $sql2 = "UPDATE `statuss` SET `status_name`='งานพัสดุอนุมัติการจัดชื้อแล้ว' WHERE `ID_U_RP` = $request->id ";
  $query = mysqli_query($connect, $sql);
  $query2 = mysqli_query($connect, $sql2);
  $ouptup = "completed";
  echo json_encode($ouptup);
}
if($request->action == "MPYprint"){
  $sql2 = "UPDATE `fromdata` SET `status`='$request->status' WHERE `ID` = $request->id ";
  $query2 = mysqli_query($connect, $sql2);
  $ouptup = "completed";
  echo json_encode($ouptup);
}



// มาจาก reportuser2 บันทึกลงฐานข้อมูล ตามจำนำ array ที่ส่งมา
if($request->action == "submitfromdata"){
  for ($i=0; $i < count($request->addfroms) ; $i++) { 
  $data =array (":date"=>$request->addfroms[$i]->date,":id_user"=>$request->id_user,":data1"=>$request->addfroms[$i]->data1,
  ":data2"=>$request->addfroms[$i]->data2,":data3"=>$request->addfroms[$i]->data3,":name1"=>$request->addfroms[$i]->name1,
  ":name2"=>$request->addfroms[$i]->name2,":name3"=>$request->addfroms[$i]->name3,":status"=>$request->status);
  $date = $data[":date"];
  $id_user = $data[":id_user"];
  $data1 = $data[":data1"];
  $data2 = $data[":data2"];
  $data3 = $data[":data3"];
  $name1 = $data[":name1"];
  $name2 = $data[":name2"];
  $name3 = $data[":name3"];
  $status = $data[":status"];

    // บันทึกข้อมูลตาราง userreport
  $sql = "INSERT INTO `userreport`(`ID_user`,`URP_date`,`URP_to`, `URP_location`,`URP_reason`, `URP_name`, `URP_munber`, `URP_condition`) 
  VALUES ('$id_user','$date','$data1','$data2','$data3','$name1','$name2','$name3')";
  $query = mysqli_query($connect, $sql);
    // ดึง ไอดี ล่าสุดมาจากตาราง userreport
  $select_id = $connect->query("SELECT `ID_U_RP` FROM `userreport` WHERE 1  ORDER BY `userreport`.`ID_U_RP` DESC;");
  $row = $select_id->fetch_assoc();
    // บันทึกข้อมูลสถานะ
  $sql2 = "INSERT INTO `statuss`( `ID_U_RP`, `status_name`) VALUES ('$row[ID_U_RP]','$status')";
  $query2 = mysqli_query($connect, $sql2);
  //  messsage line
  if ($query){
    $sToken = "MV1UyZcrqYBL6W5kPV4waoSD2IVKaRMCiwAJgxIjg21";
    $sMessage = "แจ้งเตือนมีคำร้องขอซ่อมใหม่!\r\n";
    $sMessage .= "วันที่ : ". $date . "\r\n";
    $sMessage .= "ทรัพย์สินที่ต้องการซ้อม : ". $name1 . "\r\n";
    $sMessage .= "หมายเลขครุภัณฑ์ : ". $name2 . "\r\n";
    $sMessage .= "สภาพชำรุดโดยละเอียด : ". $name3 . "\r\n";
    $sMessage .= "ตรวจสอบ\r\n";
    $sMessage .= "http://localhost:8081/loginRP\r\n";
    $chOne = curl_init(); 
    curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
    curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
    curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
    curl_setopt( $chOne, CURLOPT_POST, 1); 
    curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 
    $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
    curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
    curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
    $result = curl_exec( $chOne ); 

  }
}
if ($query){
  $ouptup = "completed";
  echo json_encode($ouptup);

}else{
  $ouptup = "not completed";
  echo json_encode($ouptup);
}
 

}
// มาจาก homeuser แสดงข้อมูลขอ user นั้นๆ
if($request->action == "getalldatame"){
  $result = $connect->query("  SELECT a.ID_U_RP, a.URP_name, a.URP_munber, a.URP_condition,b.status_name 
  FROM userreport a , statuss b WHERE a.ID_user LIKE $request->id_user AND a.ID_U_RP = b.ID_U_RP ORDER BY `a`.`ID_U_RP` DESC;
  ");
  while ($row = $result->fetch_assoc()) {
    $data[]=$row;
  }
  echo json_encode($data);
}
// มาจาก statusdata แสดงข้อมูล
if($request->action == "getalldata"){
  $result = $connect->query("SELECT a.ID_U_RP, a.URP_name, a.URP_munber, a.URP_condition,b.status_name FROM userreport a , statuss b 
  WHERE a.ID_U_RP = b.ID_U_RP ORDER BY `a`.`ID_U_RP` DESC");
  while ($row = $result->fetch_assoc()) {
    $data[]=$row;
  }
  echo json_encode($data);
}
// มาจาก adminReport แสดงแค่ที่มี `status` = 'ขอแจ้งซ่อมสำเร็จ' เพื่อดำเนินการต่อ
if($request->action == "statusdata"){
  $result = $connect->query("SELECT * FROM `userreport` a , `statuss` b WHERE b.status_name = 'ขอแจ้งซ่อมสำเร็จ' AND a.ID_U_RP = b.ID_U_RP ORDER BY `a`.`ID_U_RP` DESC;");
  while ($row = $result->fetch_assoc()) {
    $data[]=$row;
  }
  echo json_encode($data);
}
// มาจาก adminReport แสดงแค่ที่มี `status` = 'ช่างตรวจสอบแล้ว' เพื่อแก้ไขข้อมูล
if($request->action == "statusdata2"){
  $result = $connect->query("SELECT * FROM `userreport` a , `statuss` b WHERE b.status_name = 'ช่างตรวจสอบแล้ว' AND a.ID_U_RP = b.ID_U_RP ORDER BY `a`.`ID_U_RP` DESC; ");
  while ($row = $result->fetch_assoc()) {
    $data[]=$row;
  }
  echo json_encode($data);
}
// มาจาก adminReport2 รับ ID จาก adminReport เพื่อดึงข้อมูลจากตาราง ID นั่นมาแสดง
if($request->action == "searchdata"){
  $result = $connect->query("SELECT * FROM `userreport` a , `statuss` b WHERE a.ID_U_RP = '$request->id' AND a.ID_U_RP = b.ID_U_RP  ");
  while ($row = $result->fetch_assoc()) {
    $data[]=$row;
  }
  echo json_encode($data);
}
// มาจาก adminReport2 ถ้ามีการกด แก้ไขมา ให้แสดงข้อมูล
if($request->action == "searchdata2"){
  $result = $connect->query("SELECT `ID_U_RP`, `RP_name`, `RP_date`, `RP_check`, `RP_nameRP1`, `RP_nameRP2`, `RP_nameRP3` FROM `repairmanreport` WHERE `ID_U_RP`= '$request->id';  ");
  while ($row = $result->fetch_assoc()) {
    $data[]=$row;
  }
  echo json_encode($data);
}
// มาจาก EmployeeREport2 รับ ID จาก EmployeeREport เพื่อดึงข้อมูลจากตาราง ID นั่นมาแสดง
if($request->action == "searchalldataMPY"){
  $result = $connect->query("SELECT * FROM `userreport` a , `repairmanreport` b WHERE a.ID_U_RP = '$request->id' AND a.ID_U_RP = b.ID_U_RP;");
  while ($row = $result->fetch_assoc()) {
    $data[]=$row;
  }
  echo json_encode($data);
}
// มาจาก EmployeeREport2v
if($request->action == "searchdataMPY"){
  $result = $connect->query("SELECT * FROM `adminreport` WHERE `IDadmin` = '$request->id' ");
  while ($row = $result->fetch_assoc()) {
    $data[]=$row;
  }
  echo json_encode($data);
}
if($request->action == "searchdataMPY2"){
  $result = $connect->query("SELECT * FROM `userreport` a , `statuss` b , `employeereport` c 
  WHERE a.URP_name = '$request->name1' AND b.status_name = 'รอการอนุมัติ'  AND a.ID_U_RP = b.ID_U_RP ORDER BY `a`.`ID_U_RP` DESC;");
  $row = $result->fetch_assoc();
  $data[]=$row;
  
  echo json_encode($data);
}




// มาจาก save
if($request->action == "searchdatasave"){
  $result = $connect->query("SELECT * FROM `adminreport` WHERE `IDadmin` = '$request->id' ");
  while ($row = $result->fetch_assoc()) {
    $data[]=$row;
  }
  echo json_encode($data);
}
// มาจาก employeeReport แสดงแค่ที่มี `status` = 'ช่างตรวจสอบแล้ว' เพื่อดำเนินการต่อ
if($request->action == "statusdataemployee"){
  $result = $connect->query("SELECT * FROM `userreport` a , `statuss` b WHERE b.status_name = 'ช่างตรวจสอบแล้ว' 
  AND a.ID_U_RP = b.ID_U_RP ORDER BY `a`.`ID_U_RP` DESC;  ");
  while ($row = $result->fetch_assoc()) {
    $data[]=$row;
  }
  echo json_encode($data);
}
// มาจาก employeeReport แสดงแค่ที่มี `status` = 'งานพัสดุอนุมัติการจัดชื้อแล้ว' เพื่อดำเนินการต่อ
if($request->action == "statusdataemployee2"){
  $result = $connect->query("SELECT * FROM `userreport` a , `statuss` b WHERE b.status_name = 'งานพัสดุอนุมัติการจัดชื้อแล้ว' 
  AND a.ID_U_RP = b.ID_U_RP ORDER BY `a`.`ID_U_RP` DESC; ");
  $result2 = $connect->query("SELECT * FROM `userreport` a , `statuss` b WHERE b.status_name = 'รอการอนุมัติ' AND b.ID_U_RP = a.ID_U_RP;");
  while ($row = $result->fetch_assoc()) {
    $data[]=$row;
  }
  while ($row2 = $result2->fetch_assoc()) {
    $data2[]=$row2;
  }

  class all {
    public $data1 = '';
    public $data2 = '';
  }
  $all = new all();
  $all->data1 = $data;
  $all->data2 = $data2;
  echo json_encode($all);
  // echo json_encode($data2);
}

// มาจาก adminReport2 บันทึกข้อมูล
if($request->action == "submitfromdataupdate"){
  $data =array (":id"=>$request->id,":adminDate"=>$request->addfromupdate[0]->adminDate,":adminName"=>$request->addfromupdate[0]->adminName,
  ":adminData"=>$request->addfromupdate[0]->adminData,":adminName1"=>$request->addfromupdate[0]->adminName1,":adminName2"=>$request->addfromupdate[0]->adminName2,
  ":adminName3"=>$request->addfromupdate[0]->adminName3,":status"=>$request->status);
  $adminDate = $data[":adminDate"];
  $adminName = $data[":adminName"];
  $adminData = $data[":adminData"];
  $adminName1 = $data[":adminName1"];
  $adminName2 = $data[":adminName2"];
  $adminName3 = $data[":adminName3"];
  $status = $data[":status"];
  $ID_U_RP = $data[":id"];
  $ID_RP = $request->ID_RP;
  $sql = "INSERT INTO `repairmanreport`( `ID_RP`, `ID_U_RP`, `RP_name`, `RP_date`, `RP_check`, `RP_nameRP1`, `RP_nameRP2`, `RP_nameRP3`) 
  VALUES  ('$ID_RP','$ID_U_RP','$adminName','$adminDate','$adminData','$adminName1','$adminName2','$adminName3')";
  $sql2 = "UPDATE `statuss` SET `status_name`='ช่างตรวจสอบแล้ว' WHERE `ID_U_RP` = $ID_U_RP ";
  $query = mysqli_query($connect, $sql);
  $query2 = mysqli_query($connect, $sql2);
  if($query && $query2){
    $ouptup = "completed"; 
     echo json_encode($ouptup);
  }else{
    $ouptup = "errery";
  echo json_encode($ouptup);
  }
  // message line MPY
  // MV1UyZcrqYBL6W5kPV4waoSD2IVKaRMCiwAJgxIjg21
  // HjjPGIOAyRZjVXbRzB3YOfoKDsrZ1lTMqXtdfdFtJ91
  if ($query && $query2){
    $sToken = "HjjPGIOAyRZjVXbRzB3YOfoKDsrZ1lTMqXtdfdFtJ91";
    $sMessage = "แจ้งเตือนใหม่!\r\n";
    $sMessage .= "วันที่ : ". $adminDate . "\r\n";
    $sMessage .= "ชื่อผู้ตรวจเซ็ก :  ". $adminName . "\r\n";
    $sMessage .= "รายละเอียด\r\n";
    $sMessage .= "http://localhost:8081/loginMPY\r\n";
    $chOne = curl_init(); 
    curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
    curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
    curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
    curl_setopt( $chOne, CURLOPT_POST, 1); 
    curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 
    $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
    curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
    curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
    $result = curl_exec( $chOne ); 

  }
}
// มาจาก adminReport2 แก้ไขข้อมูล
if($request->action == "savefromdataupdate"){
  $data =array (":id"=>$request->id,":adminDate"=>$request->addfromupdate[0]->adminDate,":adminName"=>$request->addfromupdate[0]->adminName,
  ":adminData"=>$request->addfromupdate[0]->adminData,":adminName1"=>$request->addfromupdate[0]->adminName1,":adminName2"=>$request->addfromupdate[0]->adminName2,
  ":adminName3"=>$request->addfromupdate[0]->adminName3,":status"=>$request->status);
  $adminDate = $data[":adminDate"];
  $adminName = $data[":adminName"];
  $adminData = $data[":adminData"];
  $adminName1 = $data[":adminName1"];
  $adminName2 = $data[":adminName2"];
  $adminName3 = $data[":adminName3"];
  $status = $data[":status"];
  $ID_U_RP = $data[":id"];
  $ID_RP = $request->ID_RP;
  $sql = "UPDATE `repairmanreport` SET `RP_name`='$adminName',`RP_date`='$adminDate',`RP_check`='$adminData',
  `RP_nameRP1`='$adminName1',`RP_nameRP2`='$adminName2',`RP_nameRP3`='$adminName3'WHERE `ID_U_RP` = $ID_U_RP ";
  $sql2 = "UPDATE `statuss` SET `status_name`='ช่างตรวจสอบแล้ว' WHERE `ID_U_RP` = $ID_U_RP ";
  $query = mysqli_query($connect, $sql);
  $query2 = mysqli_query($connect, $sql2);
  if($query && $query2){
    $ouptup = "completed"; 
     echo json_encode($ouptup);
  }else{
    $ouptup = "errery";
  echo json_encode($ouptup);
  }
  // message line MPY
  // MV1UyZcrqYBL6W5kPV4waoSD2IVKaRMCiwAJgxIjg21
  // HjjPGIOAyRZjVXbRzB3YOfoKDsrZ1lTMqXtdfdFtJ91
  if ($query && $query2){
    $sToken = "HjjPGIOAyRZjVXbRzB3YOfoKDsrZ1lTMqXtdfdFtJ91";
    $sMessage = "แจ้งเตือนใหม่!  มีการแก้ไขข้อมูล\r\n";
    $sMessage .= "วันที่ : ". $adminDate . "\r\n";
    $sMessage .= "ชื่อผู้แก้ไข :  ". $adminName . "\r\n";
    $sMessage .= "รายละเอียด\r\n";
    $sMessage .= "http://localhost:8081/loginMPY\r\n";
    $chOne = curl_init(); 
    curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
    curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
    curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
    curl_setopt( $chOne, CURLOPT_POST, 1); 
    curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 
    $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
    curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
    curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
    $result = curl_exec( $chOne ); 

  }
}
?>






