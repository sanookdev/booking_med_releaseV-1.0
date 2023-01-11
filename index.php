<?
    session_start();
    date_default_timezone_set('Asia/Bangkok');
    include 'function.php';
    
    if(isset($_GET['_LOGIN']) && isset($_GET['password'])){
    $uname =  strtoupper(trim($_GET['_LOGIN']));
    $password = trim($_GET['password']);
    $checkDb = '0';
    if($uname != 'ADMIN'){
    $jsonurl = 'http://203.131.209.236/_authen/_authen.php?user_login=' . $uname;
    $json = file_get_contents($jsonurl);
    $returnInfo = json_decode($json, true);
    $data = $returnInfo;
    echo json_encode($data);
    unset($data['chkData']);
    if ($returnInfo['chkData'] == md5($password)) {
        $_SESSION['_LOGIN'] = $uname;
        $output = array(
        'success'  =>  true
        );
    } else {
        $output = array(
        'error'    =>  'รหัสผ่านไม่ถูกต้อง'
        );
    }
    print_r($output);
    }else{
    $_SESSION['_LOGIN'] = 'ADMIN';
    $conn = new mysqli('192.168.66.17', 'medtu' ,'tmt@medtu','techno_booking');mysqli_set_charset($conn,"utf8");
    if($conn->connect_error) { alert("can't connect db"); } 
    $uname =  strtoupper(mysqli_real_escape_string($conn,$_POST['username']));
    $password = md5(mysqli_real_escape_string($conn,$_POST['password']));
    // echo $password;
    $sql = "SELECT id_card AS ID_CODE, username AS medcode, status_type ,`password` 
                    , CONCAT(TFNAME,' ',TLNAME) AS fullname FROM users 
                        WHERE username = '$uname' AND `password` = '$password' LIMIT 1";
                        // echo $sql;
    $result = $conn->query($sql) or die($conn->error());
    if($result->num_rows == 1){
        $data = $result->fetch_object();
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
    //   foreach($data as $key => $val) {
    //     $_SESSION[$key] = $val;
    //   }
      $conn = new mysqli('192.168.66.17', 'medtu' ,'tmt@medtu','techno_booking');mysqli_set_charset($conn,"utf8");
      if($conn->connect_error) { alert("can't connect db"); } 
      $sql = "INSERT INTO `log`(medcode,stats) VALUE('".$_SESSION['_LOGIN']."','1')";
      $conn->query($sql);

    //   print_r($_SESSION);
      header('location: main.php');

    }else{
      echo "0";
      session_destroy();
    }
}else{
    // header('location: http://203.131.209.236/serviceTechno/login.htm');
    header('location: ./login.php');
}




?>