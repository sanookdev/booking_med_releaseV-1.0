<?php
// require 'databaseHandler.php';
require '../config/connect.php';

header("Content-Type: application/json"); 
// php://input recieves raw post data
$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);
$res_id = $json_obj['res_id'];
$room_id_change = $json_obj['room_id_change'];
$sql = "UPDATE reservation SET `room_id` = '$room_id_change' WHERE id = '$res_id'";
                        

$events = array();
if($conn->query($sql)){
    echo json_encode(array(
        "success" => true,
        "message" => 'updated'
    ));
    exit;
}
else{
    echo json_encode(array(
        "success" => false,
        "message" => 'SQL Error'
    ));
    exit;
}


?>