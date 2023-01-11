<?php
// include "config/connect.php";
date_default_timezone_set('Asia/Bangkok');
session_start();

include 'function.php';
include './config/userpassDb.php';

$uname =  strtoupper(trim($_POST['username']));
$password = trim($_POST['password']);
$conn = new mysqli($hostDb, $userDb ,$passDb,$nameDb);mysqli_set_charset($conn,"utf8");

$checkDb = '0'; // 1 check in 192.168.66.1 ( menu_handle )  OR   2 check in 192.168.66.17 ( attm_booking )
// if(substr($uname , 2 , 2 ) == '11'){
  if($uname != 'ADMIN'){
    $jsonurl = 'http://203.131.209.236/_authen/_authen.php?user_login=' . $uname;
    $json = file_get_contents($jsonurl);
    $returnInfo = json_decode($json, true);
    $data = $returnInfo;
    // echo json_encode($data);
    unset($data['chkData']);
    if ($returnInfo['chkData'] == md5($password)) {
      $output = array(
        'success'  =>  true
      );
      $_SESSION['_LOGIN'] = $uname;
      $_SESSION['fullname'] = $returnInfo['fullname'];
      $sql = "SELECT status_type FROM users WHERE username = '$uname' LIMIT 1";
      $query = $conn->query($sql) or die($conn->error());
      if(mysqli_num_rows($query) > 0){
        $res = $query->fetch_array();
        $_SESSION['status_type'] = $res['status_type'];
      }
    } else {
      $output = array(
        'error'    =>  'รหัสผ่านไม่ถูกต้อง'
      );
    }
  }else{
    if($conn->connect_error) { alert("can't connect db"); } 
    $uname =  strtoupper(mysqli_real_escape_string($conn,$_POST['username']));
    $password = md5(mysqli_real_escape_string($conn,$_POST['password']));
    $sql = "SELECT id_card AS ID_CODE, username AS medcode, status_type ,`password` 
                    , CONCAT(TFNAME,' ',TLNAME) AS fullname FROM users 
                        WHERE username = '$uname' AND `password` = '$password' LIMIT 1";
    $result = $conn->query($sql) or die($conn->error());
    if($result->num_rows == 1){
      $data = $result->fetch_object();
      $_SESSION['_LOGIN'] = $data->medcode;
      
      $output = array(
        'status'  =>  '1'
      );
    }else{
      $output = array(
        'status'    =>  '0'
      );
    }
  }
if(isset($data)){
  
  foreach($data as $key => $val) {
    if($key != 'password')
    $_SESSION[$key] = $val;
  }
  $sql = "SELECT * FROM active_class WHERE medcode = '$uname'";
  $query = $conn->query($sql) or die ($conn->error());
  $role = array();
  if(mysqli_num_rows($query) > 0){
    while($row = $query->fetch_assoc()){
      $role[] = $row;
    }
    foreach($role as $key => $val) {
      $_SESSION['role'][$key] = $val;
    }
  }
  
  if($conn->connect_error) { alert("can't connect db"); } 
  $sql = "INSERT INTO `log`(medcode,stats) VALUE('".$_SESSION['_LOGIN']."','1')";
  $conn->query($sql);
  echo json_encode($_SESSION);
}else{
  session_destroy();
  echo "0";
}
    

?>