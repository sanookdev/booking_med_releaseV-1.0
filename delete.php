<?
include "config/connect.php";
include "function.php";

    $where = $_POST['where'];
    $table = $_POST['table'];
    
    if(delete($table,$where,$conn) == true){
        echo "1";
    }else{
        echo "0";
    }
?>