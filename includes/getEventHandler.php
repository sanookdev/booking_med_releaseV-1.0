<?php
// require 'databaseHandler.php';
require '../config/connect.php';

header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to
// php://input recieves raw post data
session_start();
$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);
$room_id = $json_obj['room_id'];
$sql = "SELECT b.building_name , c.class_no ,room.`name`,res.*,sec.section_ID AS section_admin FROM building AS b
            JOIN class AS c ON b.id = c.`building_id`
                JOIN rooms AS room ON (room.`building_id` = b.`id` AND room.`class_no` = c.`class_no`)
                    JOIN reservation AS res ON room.`id` = res.`room_id`
                        JOIN appm_section AS sec ON room.admin_section = sec.SECTION_CODE
                            WHERE room.id = '$room_id' AND res.status != '2'";
                        
$result = $conn->query($sql);
$events = array();
if($result){
    while($row = $result->fetch_assoc()){
        $events[] = $row;
    }
    echo json_encode(array(
        "success" => true,
        "events" => $events,
        "session" => $_SESSION
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