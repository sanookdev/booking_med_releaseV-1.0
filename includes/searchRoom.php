<?php
// require 'databaseHandler.php';
require '../config/connect.php';

header("Content-Type: application/json"); 
$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);
$class_no = $json_obj['class_no'];
$sql = "SELECT * FROM rooms WHERE class_no = '$class_no'";
                        
$result = $conn->query($sql);
$rooms = array();
if($result){
    while($row = $result->fetch_assoc()){
        $rooms[] = $row;
    }
    echo json_encode(array(
        "success" => true,
        "rooms" => $rooms
    ));
    exit;
}
else{
    echo json_encode(array(
        "success" => false,
        "events" => 'SQL Error'
    ));
    exit;
}

?>