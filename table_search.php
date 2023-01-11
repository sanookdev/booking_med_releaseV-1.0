<?
header("Content-type: application/json; charset=utf-8");
include "config/connect.php";


$id = $_POST['id'];

$sql = "SELECT res.* FROM reservation AS res
            JOIN rooms AS room ON res.room_id = room.id";


echo json_encode($id);




?>