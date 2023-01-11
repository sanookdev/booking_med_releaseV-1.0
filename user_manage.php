<? session_start(); ?>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <link rel="stylesheet" href="css/style.css">
    <title>จัดการสมาชิก (ระบบจองห้องประชุม)</title>
    <style>
    .headGroup {
        background-color: green !important;
        border-color: green !important;
    }
    </style>
</head>

<body>
    <!-- nav -->
    <?
        include "ui/nav.php";
        include "config/connect.php";
        include "function.php";

        if(isset($_SESSION) && $_SESSION['status_type'] != '1'){
            header('location: main.php');
        }

        $sql = "SELECT * FROM users ORDER BY id ASC";
        $result = $conn->query($sql);
        $users = array();
        if($result->num_rows > 0){
            $i = 0;
            while($row = $result->fetch_object()){
                foreach($row as $key => $val){
                    $users[$i][$key] = $val;
                }
                $i++;
            }
        }
    ?>
    <!-- nav -->
    <div class="container-fluid">
        <div class="row mt-3">
            <?
          if((isset($_SESSION) && $_SESSION['status_type'] != '1')){
            echo "<script>alert('ท่านไม่มีสิทธิ์ในหน้านี้')</script>";
        }else{
        ?>
            <div class="col-lg-12 col-md-12">
                <table class="table table-bordered shadow text-center" id="data-table">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">#</th>
                            <th width="20%">username</th>
                            <th>ชื่อ-สกุล</th>
                            <th width="12%">สถานะ</th>
                            <th width="12%">รายละเอียด</th>
                            <th width="9%">แก้ไข</th>
                            <th width="5%">ลบ</th>
                        </tr>
                    </thead>
                    <tbody class="bg-light">
                        <?
                    if(count($users) > 0){
                        for($i = 0 ; $i < count($users) ; $i++){?>
                        <tr>
                            <td><?= $i+1;?></td>
                            <td><?= $users[$i]['username'];?></td>
                            <td><?= $users[$i]['TFNAME']. " " . $users[$i]['TLNAME'];?></td>
                            <td><?= ($users[$i]['status_type'] == '1') ? 'ผู้ดูแลระบบ' : 'ผู้ใช้งาน' ;?></td>
                            <td>
                                <button type="button" name="details" class="btn btn-sm btn-block btn-info view_data"
                                    id="<?= $users[$i]['id']; ?>">
                                    <i class="fa fa-list" aria-hidden="true"></i> รายละเอียด</button>
                            </td>
                            <td>
                                <button type="button" name="edit" class="btn btn-sm btn-block btn-warning edit_data"
                                    id="<?= $users[$i]['id']; ?>">
                                    <i class="fa fa-edit" aria-hidden="true"></i> แก้ไข</button>
                            </td>
                            <td>
                                <?if($users[$i]['username'] != 'ADMIN'){?>
                                <button class="btn btn-sm btn-block btn-danger delete_data"
                                    value="<?= $users[$i]['id'];?>">
                                    <i class=" fa fa-close" aria-hidden="true"></i>
                                </button>
                                <?}?>
                            </td>
                        </tr>
                        <?}
                    }?>
                    </tbody>
                </table>
                <button class="btn btn-success pull-right btn_addUser" href="#" data-toggle="modal"
                    data-target="#add_employee">
                    <i class="fa fa-user-plus mr-2" aria-hidden="true"></i>เพิ่มผู้ใช้งาน
                </button>
            </div>

            <?}?>
        </div>
    </div>
    <!-- dashboard contents -->

    <!-- Add Employee Modal -->
    <!-- Details Model -->
    <!-- Edit Employee Detaisl -->
    <? 
    include "event/addUser.php";
    include "event/view_details.php";
    include "event/editUser.php";
    ?>

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

</body>

</html>
<script>
$(document).ready(function() {
    errUser = false;
    // ************************** DATA TABLE *************************
    $('#data-table').DataTable({
        "bInfo": false,
        "bLengthChange": false,
        "bPaginate": true,
        "bFilter": false,
        "pagingType": "full_numbers"
    });
    // ************************** DATA TABLE (END) *************************
    $('#details_page').prop('hidden', false);
    $('#details_page').html('จัดการห้องประชุม');



    // *********************** VIEW DATA ***********************
    $(document).on('click', '.view_data', function() {
        var id = $(this).attr("id");
        if (id != '') {
            $.ajax({
                url: "select.php",
                method: "POST",
                data: {
                    id: id,
                    topic: 'user'
                },
                success: function(data) {
                    $('#showData').html(data);
                    $('#room_details').modal('show');
                }
            });
        }
    });
    // *********************** VIEW DATA (END)***********************


    // ************************* INSERT DATA ***********************
    $('.btn_addUser').on('click', function() {
        var topic = "ห้องที่ดูแล"
        $.ajax({
            url: "search.php",
            method: "POST",
            data: {
                topic: topic,
            },
            dataType: "json",
            success: function(data) {
                var res = '';
                for (i = 0; i < data.length; i++) {
                    res += "<div class ='col-4'>&nbsp;&nbsp;";
                    res += "<input type = 'checkbox' name ='acs' value =" + data[i]
                        .category_id + ">" + "<label for='" + data[i].topic + "'>" +
                        "&nbsp;" + data[i].topic + "</label>";
                    res += "</div>";
                }
                $('div.checkbox_result').html(res);
            }
        });
    })
    $('#username').on('change', function() {
        $.ajax({
            url: 'check_username.php',
            method: 'POST',
            dataType: 'json',
            data: {
                username: $('#username').val()
            },
            success: function(res) {
                msg = '';
                if (res == '1') {
                    errUser = true;
                    msg += "<span style = 'color: red' >มีผู้ใช้อยู่ในระบบแล้ว</span>";
                    $('.btn_submitUser').prop('disabled', true);
                } else {
                    errUser = false;
                    msg += "<span style = 'color: green' >สามารถใช้ username นี้ได้</span>";
                    $('.btn_submitUser').prop('disabled', false);
                }
                $('#errUser').html(msg);
                $('#errUser').prop("hidden", false);
            }
        })
    })
    $('#insert').on('submit', function() {
        // $('.btn_submitUser').on('click', function() {

        var data = {};
        data['username'] = $('#username').val();
        data['TFNAME'] = $('#TFNAME').val();
        data['TLNAME'] = $('#TLNAME').val();
        data['id_card'] = $('#id_card').val();
        data['sex'] = $('#sex').val();
        data['password'] = $('#password').val();
        data['status_type'] = $('#status_type').val();
        data['building'] = $('#building_name').val();
        data['class_no'] = $('#class_no').val();
        if (errUser != true) {
            $.ajax({
                url: 'insert.php',
                method: 'POST',
                dataType: 'json',
                data: {
                    data,
                    topic: 'addUser'
                },
                success: function(res) {
                    // console.log(res);
                    $('#insert')[0].reset();
                    $('#add_employee').modal('hide');
                    sessionStorage.setItem('add_order', '1');
                    window.location.reload();
                }
            })
        }
    })

    $('#id_card').change(function() {
        password = $('#id_card').val().substr(7, 6);
        $('#password').val(password);
    })

    option = '';
    $.ajax({
        url: "search.php",
        method: "POST",
        data: {
            topic: 'ตึก'
        },
        success: function(data) {
            option += "<option value = ''>เลือกตึก...</option>";
            for (i = 0; i < data.length; i++) {
                option += "<option value='" + data[i]['id'] + "'>";
                option += data[i]['building_name'];
                option += "</option>";
            }
            $('#building_name').html(option);
        }
    })

    $('#building_name').on('change', function() {
        // console.log($('#building_name option:selected').text())
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
    // ************************* INSERT DATA (END) ***********************



    // ************************* EDIT DATA *******************************
    var chk_validate_password = '';
    $(document).on('click', '.edit_data', function() {
        var id = $(this).attr("id");
        var table = "users";
        var where = "id=" + id;
        $.ajax({
            url: "fetch.php",
            method: "POST",
            data: {
                id: id,
                table: table,
                where: where,
            },
            dataType: "json",
            success: function(data) {
                $('input[name="id_edit"]').val(data.id);
                $('input[name="id_card"]').val(data.id_card);
                $('input[name="username"]').val(data.username);
                $('input[name="password"]').val(data.password);
                $('input[name="sex"]').val(data.sex);
                $('input[name="TFNAME"]').val(data.TFNAME);
                $('input[name="TLNAME"]').val(data.TLNAME);
                $('#edit_room').modal('show');
                chk_validate_password = data.password;

            }
        });
    });
    $('#form_edit').on("submit", function(event) {
        event.preventDefault();
        data = {};
        data['id_card'] = $('input[name=id_card]').val();
        data['sex'] = $('input[name=sex]').val();
        data['TFNAME'] = $('input[name=TFNAME]').val();
        data['TLNAME'] = $('input[name=TLNAME]').val();
        if (chk_validate_password != $('input[name=password]').val()) {
            data[4] = $('input[name=password]').val();
            key[4] = "password";
        }
        id = $('input[name=id_edit]').val();
        table = "users";
        where = "id=" + id;
        $.ajax({
            url: "update.php",
            method: "POST",
            data: {
                data,
                table: table,
                where: where,
                topic: 'edit_user'
            },
            beforeSend: function() {
                $('#form_edit').val("Updating");
            },
            success: function(data) {
                $('#form_edit')[0].reset();
                $('#edit_room').modal('hide');
                sessionStorage.setItem('edit_order', '1');
                window.location.reload();
            }
        });
    });
    // ************************* EDIT DATA (END) *******************************


    // ************************* DELETE DATA *******************************
    $(document).on('click', '.delete_data', function() {
        var id = $(this).val();
        var where = "id=" + id;
        var table = "users";
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
                        }
                    });
                    window.location.reload();
                }
            })
        }
    });
    // ************************* DELETE DATA (END) *******************************



    // ************************** send event after refresh page for show "sweetalert" **************************
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

    });
    // ************************** send event after refresh page for show "sweetalert" ( END ) **************************

});
</script>