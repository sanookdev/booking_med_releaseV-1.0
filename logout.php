<?
    include "config/connect.php";
    include "function.php";
    session_start();

    // $conn = new mysqli('192.168.66.1', 'root' ,'medadmin','techno_booking');mysqli_set_charset($conn,"utf8");
    if($conn->connect_error) { alert("can't connect db"); } 
    $sql = "INSERT INTO `log`(medcode,stats) VALUE('".$_SESSION['medcode']."','0')";
    $conn->query($sql);
    $urlAction = '';
    if($_SESSION['_LOGIN'] == 'ADMIN'){
        $urlAction = 'login.php';
    }else{
        $urlAction = 'login.php';

        // $urlAction = 'http://203.131.209.236/serviceTechno/login.htm';
    }
    session_destroy();
    header('location: '.$urlAction);
?>