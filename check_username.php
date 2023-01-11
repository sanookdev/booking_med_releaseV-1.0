<?
    header("Content-type: application/json; charset=utf-8");
    include "config/connect.php";
    include "function.php";
    $username = strtoupper(mysqli_real_escape_string($conn,trim($_POST['username'])));

    $sql = "SELECT * FROM users WHERE `username` = '$username' LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0){
        echo 1;
    }else{
        echo 0;
    }

?>