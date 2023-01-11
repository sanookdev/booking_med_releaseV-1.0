<?
    session_start();
    include "./config/connect.php";
    include "./function.php";
    date_default_timezone_set("Asia/Bangkok");
    if(isset($_SESSION['status_type']) && $_SESSION['status_type'] != '1' ){
        echo "<script>window.location.href='./login.php'</script>";
    }

    

   
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <link rel="stylesheet" href="css/style.css">
    <title>จองห้องประชุม</title>

    <style>
    .fixed-height {
        padding: 1px;
        max-height: 200px;
        overflow: auto;
    }

    input[type="checkbox"] {
        cursor: pointer !important;
    }
    </style>
</head>

<body>

    <!-- nav -->
    <?
        include "ui/nav.php";
        $myRes = array();
        $sql = "SELECT res.*,room.name ,room.detail,room.building_id, room.class_no,b.building_name FROM reservation AS res
                    JOIN rooms AS room ON res.room_id = room.id
                        JOIN building AS b ON b.id = room.building_id";
        (($_SESSION['_LOGIN']) != 'ADMIN') ? $sql.=" WHERE (res.member_id = '".$_SESSION['_LOGIN']."')" : '';

        // if user not ADMIN  , then checking role for access permission rooms control
        if($_SESSION['_LOGIN'] != 'ADMIN' && isset($_SESSION['role'])){
            $role = $_SESSION['role'];
            if(count($role) > 0){
                $sql.= " OR ";
                for($i = 0 ; $i < count($role) ; $i++){
                    $b_id = $role[$i]['building_id'];
                    $c_no = $role[$i]['class_no'];
                    ($i == 0) ? $sql .= "(" : $sql .= " OR ";
                    $sql.= "(building_id = '$b_id' AND class_no = '$c_no')";
                }
            }
        }
        if(isset($role) && count($role) > 0 ) $sql .= ")"; 
        // if user not ADMIN  , then checking role for access permission rooms control ( END )


        $sql .= " ORDER BY res.status, res.create_date  DESC";
        $result = $conn->query($sql) or die('error SQL');
        while($row = $result->fetch_assoc()){
            $myRes[] = $row;
        }
    ?>
    <!-- nav -->

    <!-- dashboard contents -->
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-lg-10 col-md-10 mb-2 mx-auto">
                <div class="pb-2 mt-4 mb-2">
                    <h3><u>รายการจองห้อง</u></h3>
                </div>
                <table class="table table-bordered shadow" id="data-table" style="width:100%">
                    <thead class="table-dark text-center">
                        <tr>
                            <th width="5%">#</th>
                            <th width="20%">ชื่อเรื่อง</th>
                            <th>ชื่อห้อง</th>
                            <th>วันที่จอง</th>
                            <th>เวลาจอง</th>
                            <th width="12%">รายละเอียด</th>
                            <th width="9%">สถานะ</th>
                            <?if($_SESSION['_LOGIN'] == 'ADMIN'){?>
                            <th width="5%">ลบ</th>
                            <?}?>
                        </tr>
                    </thead>
                    <tbody class="bg-light text-center">
                        <?for($i = 0 ; $i < count($myRes) ; $i++){?>
                        <tr>
                            <td><?= $i + 1; ?></td>
                            <td><?= $myRes[$i]['topic']; ?> </td>
                            <td><?= $myRes[$i]['name'].' / '.$myRes[$i]['building_name'].' ('.$myRes[$i]['class_no'].')'; ?>
                            </td>
                            <td><?= date('d-m-Y',strtotime($myRes[$i]['begin'])); ?> </td>
                            <td><?= date('d-m-Y',strtotime($myRes[$i]['begin'])) . "-" . date('d-m-Y',strtotime($myRes[$i]['end'])); ?>
                            </td>
                            <td>
                                <button type="button" name="details" class="btn btn-sm btn-block btn-info view_data"
                                    id="<?= $myRes[$i]['id']; ?>">
                                    <i class="fa fa-list"></i> รายละเอียด</button>
                            </td>
                            <td>
                                <?if($myRes[$i]['status'] == 0){?>
                                <input type="button" value="รอตรวจสอบ" name="status"
                                    class="btn btn-sm btn-block btn-warning" style='opacity:1;' disabled />
                                <?}else if ($myRes[$i]['status'] == 1){?>
                                <input type="button" value="อนุมัติ" name="status"
                                    class="btn btn-sm btn-block btn-success" style='opacity:1' disabled />
                                <?}else{?>
                                <input type="button" value="ยกเลิก" name="status"
                                    class="btn btn-sm btn-block btn-danger" style='opacity:1' disabled />
                                <?}?>
                            </td>
                            <?if($_SESSION['_LOGIN'] == 'ADMIN'){?>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm delete_data" name="delete_data"
                                    id="<?= $myRes[$i]['id']; ?>">
                                    <i class="fa fa-remove" aria-hidden="true"></i>
                                </button>
                            </td>
                            <?}?>
                        </tr>
                        <?}?>
                    </tbody>
                </table>
                <button class="btn btn-success  pull-right add_data" href="#" data-toggle="modal"
                    data-target="#add_booking">
                    <i class="fa fa-plus mr-2" aria-hidden="true"></i>จองห้อง
                </button>
            </div>
        </div>
    </div>

    <!-- Add Job Modal -->
    <? include "event/addBooking.php";?>

    <!-- Rooms Details Model -->
    <? include "event/view_details.php";?>

    <!-- Edit Job Detaisl -->
    <? include "event/editRoom.php";?>


    <!-- Optional JavaScript -->
    <!-- Popper.js first, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
    </script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>


    <!-- ******************************************* JS ********************************************* -->

    <script>
    $(document).ready(function() {

        status_err = false;
        // ************************** DATA TABLE *************************
        $('#data-table').DataTable({
            "bInfo": false,
            "bLengthChange": false,
            "bPaginate": true,
            "bFilter": false,
            "pagingType": "full_numbers"
        });
        // ************************** DATA TABLE (END) *************************



        // --------------------------- VIEW DATA ---------------------------
        $(document).on('click', '.view_data', function() {
            var id = $(this).attr("id");
            // console.log(id);
            if (id != '') {
                $.ajax({
                    url: "select.php",
                    method: "POST",
                    data: {
                        id: id,
                        topic: 'booking-list',
                        medcode: <?= json_encode($_SESSION['_LOGIN']);?>
                    },
                    success: function(data) {
                        $('#showData').html(data);
                        $('#room_details').modal('show');
                    }
                });
            }
        });
        // --------------------------- VIEW DATA (END---------------------------



        // --------------------------- INSERT DATA ---------------------------

        $('.add_data').on('click', function() {
            option = '';
            $.ajax({
                url: "search.php",
                method: "POST",
                data: {
                    topic: 'วัตถุประสงค์'
                },
                success: function(data) {
                    console.log(data);
                    option += "<option value = ''>เลือกวัตถุประสงค์...</option>";
                    for (i = 0; i < data.length; i++) {
                        option += "<option value='" + data[i]['category_id'] + "'>";
                        option += data[i]['topic'];
                        option += "</option>";
                    }
                    $('#for').html(option);
                }
            })
        })

        $('#for').on('change', function() {
            // console.log($('#building_name option:selected').text())
            if ($(this).val() != '') {
                $('#building_name').prop('disabled', false);
            } else {
                $('#building_name').prop('disabled', true);
            }
            $.ajax({
                url: "search.php",
                method: "POST",
                data: {
                    topic: 'ตึก'
                },
                success: function(data) {
                    option = '';
                    option += "<option value = ''>เลือกตึก...</option>";
                    for (i = 0; i < data.length; i++) {
                        option += "<option value='" + data[i]['id'] + "'>";
                        option += data[i]['building_name'];
                        option += "</option>";
                    }
                    $('#building_name').html(option);
                }
            })
        })

        $('#building_name').on('change', function() {
            if ($(this).val() != '') {
                $('#class_no').prop('disabled', false);
            } else {
                $('#class_no').prop('disabled', true);
            }
            building_id = $('#building_name').val();
            option = '';
            $.ajax({
                url: "search.php",
                method: "POST",
                data: {
                    topic: 'ชั้น',
                    building_id: building_id
                },
                success: function(data) {
                    option = '';
                    option += "<option value = ''>เลือกชั้น...</option>";
                    for (i = 0; i < data.length; i++) {
                        option += "<option value='" + data[i]['class_no'] + "'>";
                        option += data[i]['class_no'];
                        option += "</option>";
                    }
                    $('#class_no').html(option);
                }
            })
        })
        $('#class_no').on('change', function() {
            if ($(this).val() != '') {
                $('#name_room').prop('disabled', false);
            } else {
                $('#name_room').prop('disabled', true);
            }

            class_id = $(this).val();
            building_id = $('#building_name').val();
            use_for = $('#for').val();
            $.ajax({
                url: "search.php",
                method: "POST",
                data: {
                    topic: 'หาห้องประชุม',
                    class_id: class_id,
                    building_id: building_id,
                    use: use_for
                },
                success: function(data) {
                    option = '';
                    if (data.length > 0) {
                        for (i = 0; i < data.length; i++) {
                            option += "<option value='" + data[i]['id'] + "'>";
                            option += data[i]['name'];
                            option += "</option>";
                            $('#start_date').prop('disabled', false);
                            $('#end_date').prop('disabled', false);
                        }
                    } else {
                        option +=
                            "<option value = '' selected disabled>ไม่พบห้องประชุม...</option>";
                        $('#start_date').prop('disabled', true);
                        $('#end_date').prop('disabled', true);
                    }
                    $('#name_room').html(option);
                }
            })
        })

        // เวลา เริ่ม - สิ้นสุด
        $('[name = end_date]').on('change', function() {

            begin = $('[name = start_date]').val();
            end = $('[name = end_date]').val();
            begin = begin.replace('T', ' ');
            end = end.replace('T', ' ');
            room_id = $('#name_room').val();
            // console.log(begin + ' ' + end);

            if (begin != '' && end != '') {
                $.ajax({
                    url: "search.php",
                    method: "POST",
                    data: {
                        topic: 'เช็คเวลา',
                        begin: begin,
                        end: end,
                        room_id
                    },
                    success: function(data) {
                        // console.log(data);
                        var msg = '';
                        if (data == 1) {
                            msg =
                                "<span class = 'success'>สามารถจองในช่วงเวลาดังกล่าวได้...</span>";
                            status_err = false;
                            $('.btn_submit').prop('disabled', false);
                        } else {
                            time_begin = data[0]['begin'].split(' ')[1];
                            time_end = data[0]['end'].split(' ')[1];
                            console.log(time_begin + " " + time_end);
                            msg =
                                "<span class = 'error'>!! ไม่สามารถจองช่วงเวลาดังกล่าวได้...</span><br>";
                            msg += "<span class = 'error'>มีผู้จองเวลา : " + time_begin +
                                " น.-" +
                                time_end +
                                " น.</span>";
                            status_err = true;
                            $('.btn_submit').prop('disabled', true);
                        }
                        $('.start_err').html(msg);
                    }
                })
            }
        })


        // วันที่  /   เวลา เริ่ม - สิ้นสุด
        // $('[name = date_reservation]').on('change', function() {
        //     date = $('#date_reservation').val();

        //     begin = $('#start_date').val();
        //     end = $('#end_date').val();
        //     console.log(begin, end);
        //     // choice_time = $('#start_to_end_time').val();
        //     // if (choice_time != '') {
        //     //     if (choice_time == '1') {
        //     //         begin = date + ' 08:30';
        //     //         end = date + ' 12:00';
        //     //     } else if (choice_time == '2') {
        //     //         begin = date + ' 13:00';
        //     //         end = date + ' 16:30';
        //     //     } else if (choice_time == '3') {
        //     //         begin = date + ' 08:30';
        //     //         end = date + ' 16:30';
        //     //     }
        //     // }
        //     room_id = $('#name_room').val();

        //     if (typeof(begin) != 'undefined' && typeof(end) != 'undefined') {
        //         $.ajax({
        //             url: "search.php",
        //             method: "POST",
        //             data: {
        //                 topic: 'เช็คเวลา',
        //                 begin: begin,
        //                 end: end,
        //                 room_id
        //             },
        //             success: function(data) {
        //                 // console.log(data);
        //                 var msg = '';
        //                 if (data == 1) {
        //                     msg =
        //                         "<span class = 'success'>สามารถจองในช่วงเวลาดังกล่าวได้...</span>";
        //                     status_err = false;
        //                     $('.btn_submit').prop('disabled', false);
        //                 } else {
        //                     time_begin = data[0]['begin'].split(' ')[1];
        //                     time_end = data[0]['end'].split(' ')[1];
        //                     // console.log(time_begin + " " + time_end);
        //                     msg =
        //                         "<span class = 'error'>!! ไม่สามารถจองช่วงเวลาดังกล่าวได้...</span><br>";
        //                     msg += "<span class = 'error'>มีผู้จองเวลา : " + time_begin +
        //                         " น.-" +
        //                         time_end +
        //                         " น.</span>";
        //                     status_err = true;
        //                     $('.btn_submit').prop('disabled', true);
        //                 }
        //                 $('.start_err').html(msg);
        //             }
        //         })
        //     }
        // })
        // $('[name = start_to_end_time]').on('change', function() {

        //     date = $('#date_reservation').val();
        //     choice_time = $('#start_to_end_time').val();
        //     if (choice_time == '1') {
        //         begin = date + ' 08:30';
        //         end = date + ' 12:00';
        //     } else if (choice_time == '2') {
        //         begin = date + ' 13:00';
        //         end = date + ' 16:30';
        //     } else if (choice_time == '3') {
        //         begin = date + ' 08:30';
        //         end = date + ' 16:30';
        //     }
        //     room_id = $('#name_room').val();

        //     if (typeof(begin) != 'undefined' && typeof(end) != 'undefined') {
        //         $.ajax({
        //             url: "search.php",
        //             method: "POST",
        //             data: {
        //                 topic: 'เช็คเวลา',
        //                 begin: begin,
        //                 end: end,
        //                 room_id
        //             },
        //             success: function(data) {
        //                 var msg = '';
        //                 if (data == 1) {
        //                     msg =
        //                         "<span class = 'success'>สามารถจองในช่วงเวลาดังกล่าวได้...</span>";
        //                     status_err = false;
        //                     $('.btn_submit').prop('disabled', false);
        //                 } else {
        //                     time_begin = data[0]['begin'].split(' ')[1];
        //                     time_end = data[0]['end'].split(' ')[1];
        //                     msg =
        //                         "<span class = 'error'>!! ไม่สามารถจองช่วงเวลาดังกล่าวได้...</span><br>";
        //                     msg += "<span class = 'error'>มีผู้จองเวลา : " + time_begin +
        //                         " น.-" +
        //                         time_end +
        //                         " น.</span>";
        //                     status_err = true;
        //                     $('.btn_submit').prop('disabled', true);
        //                 }
        //                 $('.start_err').html(msg);
        //             }
        //         })
        //     }
        // })
        // วันที่  /  เวลา เริ่ม - สิ้นสุด ( END )


        $('#count_responsible_person').on('change', function() {
            count_person = $(this).val();
            name_person = '';
            list_employee = '';

            if (count_person != '') {
                $.ajax({
                    url: "search.php",
                    method: "POST",
                    data: {
                        topic: 'เจ้าหน้าที่ผู้รับผิดชอบ'
                    },
                    success: function(data) {
                        for (i = 0; i < data.length; i++) {
                            list_employee += "<option value='" + data[i]['USERNAME'] + "'>";
                            list_employee += data[i]['TFNAME'] + " " + data[i]['TLNAME'];
                            list_employee += "</option>";
                        }
                        for (i = 0; i < count_person; i++) {
                            name_person += '<label for = "person' + parseInt(i + 1) + '">' +
                                'เจ้าหน้าที่ผู้ดูแล ' +
                                parseInt(i + 1) +
                                '</label>';
                            name_person +=
                                '<select type = "text" class = "form-control form-control-sm" id = "person' +
                                parseInt(i + 1) +
                                '" required>';
                            name_person +=
                                '<option value = "" >เลือกเจ้าหน้าที่งานเทคโน</option>';
                            name_person += list_employee;
                            name_person += '</select>';
                        }
                        $('.add_responsible_person').html(name_person);
                    }
                })
            } else {
                $('.add_responsible_person').html('');
            }
        })


        // insert confirm submit
        $('#insertBooking').on("submit", function(event) {
            event.preventDefault();
            data = {};
            i = 0;
            data['id_room'] = $('select[name=name_room]').val();
            data['id_card'] = $('input[name=member]').val();
            data['subject'] = $('input[name=topic]').val();
            data['details'] = $('#details_booking').val();

            // start to end time of reservation
            date = $('#date_reservation').val();
            choice_time = $('#start_to_end_time').val();
            if (choice_time == '1') {
                begin = date + ' 08:30';
                end = date + ' 12:00';
            } else if (choice_time == '2') {
                begin = date + ' 13:00';
                end = date + ' 16:30';
            } else if (choice_time == '3') {
                begin = date + ' 08:30';
                end = date + ' 16:30';
            }
            data['start_date'] = begin;
            data['end_date'] = end;
            // start to end time of reservation (end)

            data['for'] = $('select[name=for]').val();
            for_text = $('select[name=for] option:selected').text();
            count_intendent = $('#count_responsible_person').val()
            medcode_intendent = '';
            if (count_intendent > 0) {
                for (i = 0; i < count_intendent; i++) {
                    if (i != 0) {
                        medcode_intendent += ',';
                    }
                    console.log(parseInt(i + 1));
                    medcode_intendent += $('#person' + parseInt(i + 1) + ' option:selected').val();
                }
            }
            data['intendent'] = medcode_intendent;
            $.ajax({
                url: "insert.php",
                method: "POST",
                dataType: "json",
                data: {
                    data,
                    for_text,
                    topic: 'reservation',
                },
                beforeSend: function() {
                    $('#insertBooking').val("Inserting");
                },
                success: function(data) {
                    $('#insertBooking')[0].reset();
                    $('#add_booking').modal('hide');
                    sessionStorage.setItem('add_order', '1');
                    window.location.reload();
                }
            });
        });
        // --------------------------- INSERT DATA (END) ------------- --------------



        // --------------------------- DELETE DATA ---------------------------
        $(document).on('click', '.delete_data', function() {
            var id = $(this).attr("id");
            var where = "id=" + id;
            var table = "reservation";
            if (id != '') {
                Swal.fire({
                    title: 'ลบข้อมูล ?',
                    text: "ท่านแน่ใจว่าต้องการลบข้อมูล !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: 'red',
                    cancelButtonColor: 'grey',
                    confirmButtonText: 'ลบข้อมูล !'
                }).then((result) => {
                    if (result.value) {
                        sessionStorage.setItem('delete_order', '1');
                        $.ajax({
                            url: "delete.php",
                            method: "POST",
                            data: {
                                table: table,
                                id: id,
                                where: where
                            },
                            success: function(data) {
                                console.log(data);
                                window.location.reload();
                            }
                        });
                    }
                })
            }
        });
        // --------------------------- DELETE DATA (END) ---------------------------

        // --------------------------- UPDATE STATUS ---------------------------
        $(document).on('click', 'input[name = "status_set"]', function() {
            var id = $(this).attr("id");
            var where = "id=" + id;
            var table = "reservation";
            var data = {};
            data['status'] = $('#status_value').val();
            Swal.fire({
                title: 'ต้องการปรับสถานะ ?',
                text: "ต้องการปรับสถานะ !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'green',
                cancelButtonColor: 'grey',
                confirmButtonText: 'บันทึก !'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "update.php",
                        method: "POST",
                        data: {
                            data,
                            table: table,
                            where: where,
                            topic: 'update_status'
                        },
                        success: function(data) {
                            sessionStorage.setItem('status_order', '1');
                            window.location.reload();
                        }
                    });
                }
            })
        });
        // --------------------------- CHANGE STATUS (END) ---------------------------


        // --------------------------- send event after refresh page for show "sweetalert" ---------------------------
        $(function() {
            if (sessionStorage.getItem('delete_order') == '1') {
                Swal.fire({
                    position: 'bottom-end',
                    icon: 'error',
                    title: 'ลบข้อมูลเรียบร้อยแล้ว',
                    showConfirmButton: false,
                    timer: 1500
                });
                sessionStorage.setItem('delete_order', '0');
            }
            if (sessionStorage.getItem('add_order') == '1') {
                Swal.fire({
                    position: 'bottom-end',
                    icon: 'success',
                    title: 'บันทึกข้อมูลเรียบร้อยแล้ว',
                    showConfirmButton: false,
                    timer: 1500
                });
                sessionStorage.setItem('add_order', '0');

            }
            if (sessionStorage.getItem('edit_order') == '1') {
                Swal.fire({
                    position: 'bottom-end',
                    icon: 'success',
                    title: 'อัพเดตข้อมูลเรียบร้อยแล้ว',
                    showConfirmButton: false,
                    timer: 1500
                });
                sessionStorage.setItem('edit_order', '0');

            }
            if (sessionStorage.getItem('status_order') == '1') {
                Swal.fire({
                    position: 'bottom-end',
                    icon: 'success',
                    title: 'อัพเดตข้อมูลเรียบร้อยแล้ว',
                    showConfirmButton: false,
                    timer: 1500
                });
                sessionStorage.setItem('status_order', '0');

            }

        });
        // --------------------------- send event after refresh page for show "sweetalert" ( END ) ---------------------------


        // $('.add_responsible_preson_btn').on('click', function() {
        //     console.log(1);
        //     var input_text_person = '<div class = "mb-3" >';
        //     input_text_person += '<input type = "text" class = "form-control forn-control-sm" />';
        //     input_text_person += '</div>'
        //     $('.add_responsible_person').html($('.add_responsible_person').html() + input_text_person);
        // })
    });
    </script>

</body>

</html>