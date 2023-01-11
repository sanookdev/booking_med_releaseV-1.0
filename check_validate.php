<?
header("Content-type: application/json; charset=utf-8");
include "config/connect.php";
include "function.php";

$topic = $_POST['topic'];
$begin = $_POST['begin'];
$end = $_POST['end'];
$err = false;
$data = array();
if($topic == 'check_time'){

    $sql = "SELECT `begin`,`end` FROM reservation";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $i = 0;
        while($row = $result->fetch_assoc()){
            $data[$i] = $row['begin']." ".$row['end'];
            // if($begin < $row['begin'] && $end < $row['begin'] || $begin > $row['begin'] && $end > $row['end']){
            //     $err = false;
            // }else{
            //     $err = true ;
            // }
            $i++;
        }
    }
}

echo json_encode($data);



?>