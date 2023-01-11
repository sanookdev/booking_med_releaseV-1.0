<?php
header("Content-type: application/json; charset=utf-8");

include "config/connect.php";
include "function.php";

if (!empty($_POST)) {
    // echo json_encode($_POST);
    if(isset($_POST['topic']) && $_POST['topic'] == 'วัตถุประสงค์'){
        $table = $_POST['data']['table'];
        $data = $_POST['data']['topic'];
        $type = $_POST['data']['type'];
        $id = $_POST['data']['id'];
        $where = "category_id=".$id ." AND type =".$type;
        $sql = "UPDATE $table SET category_id = '$data' WHERE category_id = '$id' AND type = '$type'";
    }else if (isset($_POST['topic']) && $_POST['topic'] == 'edit_user'){
        $data = $_POST['data'];
        $table = $_POST['table'];
        $where = $_POST['where'];
        // processing .....
    }else if (isset($_POST['topic']) && $_POST['topic'] == 'update_status'){
        $table = $_POST['table'];
        $data = $_POST['data'];
        $where = $_POST['where'];
        $where_select = 'res.'.$_POST['where'];

        $sql = "SELECT res.*,cat.topic AS sub_type FROM reservation AS res 
                    JOIN category AS cat ON res.for = cat.category_id 
                        WHERE $where AND cat.type = 'use' LIMIT 1";
        $result = $conn->query($sql);
        $rs = $result->fetch_assoc();

        // if($rs['intendent'] != '' && $data['status'] == '1'){
        //     $nameDb_2 = '_service_techno';
        //     $conn_2 = new mysqli($hostDb,$userDb,$passDb,$nameDb_2);
        //     $conn_2->set_charset("utf8");
        //     if($conn_2->connect_error) { alert("can't connect db"); }

        //     $table_service = 'reg_servicemedia(`R_person`)';
        //     $data_service = explode(',',$rs['intendent']);
        //     for($i = 0 ; $i < count($data_service) ; $i++){
        //         $medcode = $data_service[$i];
        //         $sql = "INSERT INTO $table_service VALUE('$medcode')";
        //         $conn_2->query($sql);

        //         $sql = "SELECT Reg_id FROM reg_servicemedia WHERE R_person = '$medcode' ORDER BY Reg_id DESC LIMIT 1";
        //         $result = $conn_2->query($sql);
        //         $reg_id = $result->fetch_assoc();
        //         $reg_id = $reg_id['Reg_id'];
        //         $table_service_job = 'reg_servicemedia_job(`Reg_id`,`type_id`,`R_person`,`R_date`,`R_usedate`,`R_status`,`R_comment`)'; // R_status set VALUE = 3 -- ดำเนินการแล้ว
        //         if($rs['sub_type'] == 'ประชุม'){
        //             $type_id = '13';
        //         }else{
        //             $type_id = '17';
        //         }
        //         $R_date = $rs['begin'];
        //         $detail = isset($rs['detail']) ? isset($rs['detail']) : '';
        //         $sql = "INSERT INTO $table_service_job VALUE('$reg_id','$type_id','$medcode','$R_date','$R_date','3','$detail')";
        //         $conn_2->query($sql);
        //     }
        // }
    }else{
        $data = $_POST['data'];
        $table = $_POST['table'];
        $where = $_POST['where'];
    }
    if (update($table, $data,  $where, $conn) == true) {
        echo "1";
    } else {
        echo "0";
    }
}