 <?php
    include "config/connect.php";
    $output = '';
    session_start();
    if ($_POST['topic'] == 'rooms') {
        $sql = "SELECT r.*,b.building_name , sec.SECTION_CODE , sec.section_ID , sec.DESCRIPTION FROM rooms AS r 
                    JOIN building AS b ON r.building_id = b.id 
                        JOIN appm_section AS sec ON r.admin_section = sec.SECTION_CODE
                            WHERE r.id = " . $_POST["id"];
        $result = $conn->query($sql);
        $output .= ' <table class="table table-bordered">';
        $use_for = '';
        $use_for_text = '';
        while ($row = $result->fetch_array()) {
            $use_for = $row['use_for'];
            $use_for_arr = explode(',',$use_for);
            $sql_use_for = 'SELECT * FROM category WHERE ';
            for($i = 0 ; $i < count($use_for_arr) ; $i++){
                if($i == 0) {$sql_use_for .= '(';}
                else if ($i != 0 && $i != count($use_for_arr)){
                    $sql_use_for .= ' OR ';
                }

                $sql_use_for .= "category_id = '". $use_for_arr[$i]."'";

                if($i == count($use_for_arr)-1){
                     $sql_use_for .= ") AND type = 'use'";
                }

            }

            $result = $conn->query($sql_use_for);
            if($result->num_rows > 0){
                $j = 0;
                while ($row2 = $result->fetch_assoc()){
                    if($j != 0){
                        $use_for_text .= "<br>";
                    }
                    $use_for_text .= $j+1 . ".".$row2['topic'];
                    $j++;
                }
            }
            $noofroom = '';
            if($row['numberofroom'] == '1'){
                $noofroom = 'ไม่เกิน 10 คน';
            }else if($row['numberofroom'] == '2'){
                $noofroom = '11-30 คน';
            }else if($row['numberofroom'] == '3'){
                $noofroom = '31-50 คน';
            }else if($row['numberofroom'] == '4'){
                $noofroom = '51-100 คน';
            }else {
                $noofroom = 'มากกว่า 100 คน';
            }
            $output .= '  
               <tr>
                    <th>ID</th>
                    <td>' . $row['id'] . '</td>
                </tr>
                <tr>
                    <th>ชื่อห้องประชุม</th>
                    <td>' . $row['name'] . '</td>
                </tr>
                <tr>
                <th>จำนวนที่รับได้</th>
                    <td>' . $noofroom . '</td>
                </tr>
                <tr>
                    <th>ตึก</th>
                    <td>' . $row['building_name'] . '</td>
                </tr>
                <tr>
                    <th>ชั้น</th>
                    <td>' . $row['class_no'] . '</td>
                </tr>
                <tr>
                    <th>วัตถุประสงค์</th>
                    <td>' . $use_for_text . '</td>
                </tr>
                <tr>
                    <th>หน่วยงานผู้ดูแลห้อง</th>
                    <td>' . $row['DESCRIPTION'] . '</td>
                </tr>
                <tr>
                    <th>เบอร์ติดต่อผู้ดูแลห้อง</th>
                    <td>' . $row['admin_phone'] . '</td>
                </tr>
                <tr>
                    <th>หมายเหตุ</th>
                    <td>' . $row['detail'] . '</td>
                </tr>
           ';
            $output .= '  
           </table> ';
        }
    }else if($_POST['topic'] == 'user'){
        $sql = "SELECT * FROM users  WHERE id = '" . $_POST["id"] . "'";
        $result = $conn->query($sql);
        $output .= ' <table class="table table-bordered">';
        while ($row = $result->fetch_array()) {
            $output .= '  
                <tr>
                    <th>ID</th>
                    <td>' . $row['id'] . '</td>
                </tr>
                <tr>
                    <th>เลขบัตรประชาชน</th>
                    <td>' . $row['id_card'] . '</td>
                </tr>
                <tr>
                    <th>MEDCODE</th>
                    <td>' . $row['username']. '</td>
                </tr>
                <tr>
                    <th>ชื่อ - สกุล</th>
                    <td>' . $row['TFNAME'] .' '. $row['TLNAME'] .'</td>
                </tr>
                <tr>
                    <th>สถานะ</th>
                    <td>' . (($row['status_type'] == '1') ? 'ผู้ดูแลระบบ' : 'ผู้ใช้งาน') . '</td>
                </tr>
           ';
            $output .= '</table>';
        } 
    } else if ($_POST['topic'] == 'booking' || $_POST['topic'] == 'booking-list') {
        $id = $_POST['id'];
        $sql = "SELECT res.*,room.name ,room.building_id,room.detail, room.admin_phone, b.building_name ,room.class_no ,cat.topic AS use_for,
                        sec.section_ID , sec.DESCRIPTION , room.numberofroom
                    FROM reservation AS res
                        JOIN rooms AS room ON res.room_id = room.id
                            JOIN building AS b ON room.building_id =  b.id
                                JOIN category AS cat ON res.for = cat.category_id
                                    JOIN appm_section AS sec ON room.admin_section = sec.SECTION_CODE 
                                        WHERE cat.type = 'use' AND res.id = '" . $_POST['id'] . "'";
        $result = $conn->query($sql);
        $output .= '<table class="table table-bordered">';
        $row = $result->fetch_assoc();
        $noofroom = '';
            if($row['numberofroom'] == '1'){
                $noofroom = 'ไม่เกิน 10 คน';
            }else if($row['numberofroom'] == '2'){
                $noofroom = '11-30 คน';
            }else if($row['numberofroom'] == '3'){
                $noofroom = '31-50 คน';
            }else if($row['numberofroom'] == '4'){
                $noofroom = '51-100 คน';
            }else {
                $noofroom = 'มากกว่า 100 คน';
            }
            $explode_start = explode(' ',$row['begin']);
            $explode_end = explode(' ',$row['end']);
            $output .= '
                <tr>
                    <th>ID</th>
                    <td>' . $row['id'] . '</td>
                </tr>
                <tr>
                    <th>วันที่สร้างคำขอ</th>
                    <td>' . $row['create_date'] . '</td>
                </tr>
                <tr>
                    <th>ผู้จอง</th>
                    <td>' . $row['fullname_res'] . ' <br> <small style = "color:gray">' . $row['member_id'] . '</small></td>
                </tr>
                <tr>
                    <th>ตึก(ชั้น) / ห้องประชุม</th>
                    <td>' . $row['building_name'] . " ( ". $row['class_no'] . " )" . " / ". $row['name'].'</td>
                </tr> 
                <tr>
                    <th>หน่วยงานผู้ดูแล</th>
                    <td>' . $row['DESCRIPTION'] . '</td>
                </tr>
                <tr>
                    <th>เบอร์ติดต่อผู้ดูแล</th>
                    <td>' . $row['admin_phone'] . '</td>
                </tr>
                <tr>
                    <th>รายละเอียดห้อง</th>
                    <td>' . $row['detail'] . " ( " . $noofroom . ' )</td>
                </tr>
                <tr>
                    <th>หัวเรื่อง</th>
                    <td>' . $row['topic'] . '</td>
                </tr>
                <tr>
                    <th>วันที่จอง</th>
                    <td>' . date('d-m-Y', strtotime($row['begin'])) . '</td>
                </tr>
                <tr>
                    <th>เวลาจอง</th>
                    <td>' . $explode_start[1]. ' น. - ' .$explode_end[1] . ' น.' . '</td>
                </tr>
                <tr>
                    <th>วัตถุประสงค์</th>
                    <td>' . $row['use_for'] . '</td>
                </tr> 
                <tr>
                    <th>เบอร์โทรผู้ติดต่อ</th>
                    <td>' . $row['phone'] . '</td>
                </tr>
                 <tr>
                    <th>หมายเหตุ</th>
                    <td>' . $row['comment'] . '</td>
                </tr> 
            ';
            if ($_POST['topic'] == 'booking-list' && isset($_POST['medcode'])) {
                $stats = $row['status'];
                $chk = false;
                $output .= '<tr>
                                <th>สถานะ</th>
                                <td>
                                <select class="form-control form-control-sm" style="width:100%" type="text" name="status_value" id="status_value" placeholder="ดำเนินการ..." required>';

                $output .= ($stats == 0) ? '<option selected value="0">รอตรวจสอบ</option>' : '<option value="0">รอตรวจสอบ</option>';
                if($_POST['medcode'] == 'ADMIN' ){
                    $chk = true;
                }else if(isset($_SESSION['role'])){
                    for($i = 0 ; $i < count($_SESSION['role']) ; $i++){
                        if($_SESSION['role'][$i]['building_id'] == $row['building_id'] && $_SESSION['role'][$i]['class_no'] == $row['class_no'])
                        $chk = true;
                    }
                }
                if($chk == true){
                    $output .= ($stats == 1) ? '<option selected value="1">อนุมัติ</option>' : '<option value="1">อนุมัติ</option>';
                }
                // $output .= ($stats == 2) ? '<option selected value="2">ยกเลิก</option>' : '<option value="2">ยกเลิก</option>';
                $output .= ' </select>';
                if($chk == true){
                    $output .= '<input type="button" name = "status_set" 
                    value = "ดำเนินการ" class="btn btn-sm btn-success btn-block mt-2" id = "' . $_POST["id"] . '"/>';
                }
                $output .= '<button class = "mt-2 btn btn-sm btn-block btn-danger" onclick = "status_cancel('.$row['id'].')">ยกเลิกการจอง</button>
                                </td>           
                            </tr> ';
            }
            $output .= ' </table> ';
        
    }

    echo $output;
    ?>