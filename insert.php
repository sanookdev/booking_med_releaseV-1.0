<?php
header("Content-type: application/json; charset=utf-8");

include "config/connect.php";
include "function.php";
if (!empty($_POST)) {
    if (isset($_POST['topic']) && $_POST['topic'] == 'reservation') {
        $_POST['table'] = 'reservation(`room_id`,`member_id`,`fullname_res`,`topic`,`comment`, `begin`,`end`,`for`,`phone`)';

    }else if(isset($_POST['topic']) && $_POST['topic'] == 'addUser'){
        $_POST['table'] = 'users(`username`,`TFNAME`,`TLNAME`,`id_card`,`sex`,`password`,`status_type`)';
        $_POST['data']['username'] = strtoupper(trim($_POST['data']['username']));
        $_POST['data']['password'] = md5(trim($_POST['data']['password']));
        $active_arr = array();
        $active_arr['data']['medcode'] = $_POST['data']['username'];
        $active_arr['data']['building'] = $_POST['data']['building'];
        $active_arr['data']['class_no'] = $_POST['data']['class_no'];
        $active_arr['data']['write'] = 1;
        $active_arr['table'] = 'active_class(`medcode`,`building_id`,`class_no`,`write`)';

        unset($_POST['data']['building']);
        unset($_POST['data']['class_no']);

    }else if(isset($_POST['topic']) && $_POST['topic'] == 'addPermission'){
        $_POST['table'] = 'active_class(`class_no`,`medcode`,`building_id`,`read`,`write`)';
        $_POST['data']['medcode'] = strtoupper(trim($_POST['data']['username']));
        $_POST['data']['building_id'] = strtoupper(trim($_POST['data']['building']));
        $_POST['data']['class_no'] = strtoupper(trim($_POST['data']['class_no']));
        $_POST['data']['read'] = '1';
        $_POST['data']['write'] = '1';
        
        unset($_POST['data']['building']);
        unset($_POST['data']['username']);
    }
    if (insert($_POST['table'], $_POST['data'], $conn) == true) {
        if(isset($_POST['topic']) && $_POST['topic'] == 'addUser'){
            insert($active_arr['table'], $active_arr['data'], $conn);
        }
        echo "1";
    } else {
        echo "0";
    }
}