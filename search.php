<?
header("Content-type: application/json; charset=utf-8");
include "config/connect.php";
include "function.php";

$getVal = $_POST['topic'];
if($getVal == 'ห้องประชุม'){
    $rs = select("SELECT `name`,`id` FROM rooms", $conn);
}
else if($getVal == 'วัตถุประสงค์'){
    $rs = array();
    $rs['for'] = select("SELECT `topic`,`category_id` FROM category WHERE type = 'use'", $conn);
    $rs['section'] = select("SELECT `SECTION_CODE`,`section_ID` , `DESCRIPTION` FROM appm_section", $conn);
}
else if($getVal == 'อุปกรณ์'){
    $rs = select("SELECT `topic`,`category_id` FROM category WHERE type = 'accessories'", $conn);
}
else if ($getVal =='ตึก'){
    $rs = select("SELECT * FROM building",$conn);
}
else if ($getVal =='ชั้น'){
    $building_id = $_POST['building_id'];
    $rs = select("SELECT c.*,c.id,b.id AS building_id ,b.building_name FROM class AS c
                    LEFT JOIN building AS b ON b.id = c.building_id WHERE building_id = '$building_id'
                        ORDER BY c.class_no ASC ",$conn);
}
else if ($getVal =='หาห้องประชุม'){
    $building_id = $_POST['building_id'];
    $class_no = $_POST['class_id'];
    $sql = "SELECT r.`name`,r.id,r.detail ,r.admin_phone ,r.admin_section AS SECTION_CODE,sec.DESCRIPTION AS department
                 FROM rooms AS r
                    JOIN appm_section AS sec ON sec.SECTION_CODE = r.admin_section
                        WHERE r.building_id = '$building_id' 
                            AND r.class_no = '$class_no'";
    if(isset($_POST['use'])){
        $sql .= " AND use_for 
                        LIKE '%".$_POST['use']."%'";
    } 
                                            
    $rs = select($sql,$conn);
}

else if ($getVal =='เช็คเวลา'){
    $begin = $_POST['begin'];
    $end = $_POST['end'];
    $room_id = $_POST['room_id'];
    $sql = "SELECT * FROM reservation 
                WHERE `room_id` = '$room_id' 
                    AND 
                    (`begin` <= '$begin' AND '$begin' < `end`)
                        OR (`begin` < '$end' AND '$end' <= `end`)
                            OR ('$begin' <= `begin` AND `begin` < '$end')";
    $rs = select($sql,$conn);
}else if ($getVal == "getContact"){
    $room_id = $_POST['room_id'];
    $sql = "SELECT r.*,sec.DESCRIPTION AS department FROM rooms AS r 
                JOIN appm_section AS sec ON sec.SECTION_CODE = r.admin_section
                    WHERE r.`id` = '$room_id'";
    $rs = select($sql,$conn);
}else if ($getVal == "advanceSearch"){
    $dataSearch=json_decode(stripslashes($_POST['data']), true);
    $sql_rooms = "SELECT * FROM rooms 
                    WHERE building_id = '".$dataSearch['building_id_search']."' 
                        AND class_no = '".$dataSearch['class_no_search']."'";
    $sql_res = "SELECT res.* , room.name FROM reservation AS res
        JOIN rooms AS room ON res.room_id = room.id
            WHERE room.building_id = '".$dataSearch['building_id_search']."' AND room.class_no = '".$dataSearch['class_no_search']."'
                AND ((TIME(res.begin) BETWEEN '".$dataSearch['search_time_start']."' AND '".$dataSearch['search_time_end']."')
                    OR (TIME(res.end) BETWEEN '".$dataSearch['search_time_start']."' AND '".$dataSearch['search_time_end']."'))
                AND (DATE(res.begin) = '".$dataSearch['date_reservation']."' AND DATE(res.end) = '".$dataSearch['date_reservation']."')";
                        
    $rs['rooms_booked'] = select($sql_res,$conn);
    $rs['rooms_found'] = select($sql_rooms,$conn);
    // echo $sql_res;

    
}
if(count($rs) > 0){
        $rs = $rs;
    }else{
        $rs = 1;
    }
echo json_encode($rs);
?>