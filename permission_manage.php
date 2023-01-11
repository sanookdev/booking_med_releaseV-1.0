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
    <?
        include "./ui/nav.php";
        include "./config/connect.php";
        include "./function.php";

        $sql = "SELECT active.*, b.building_name FROM active_class AS active 
                    JOIN building AS b ON active.building_id = b.id ORDER BY id_active ASC";
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
            <div class="col-lg-12 col-md-12">
                <table class="table table-bordered shadow text-center" id="data-table">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">#</th>
                            <th width="20%">Username</th>
                            <th>ตึกและชั้นที่ดูแล</th>
                            <th width="20%">วันที่อัพเดต</th>
                            <th width="5%">ลบ</th>
                        </tr>
                    </thead>
                    <tbody class="bg-light">
                        <? for($i = 0 ; $i < count($users) ; $i++){?>
                        <tr>
                            <td><?= $i+1;?></td>
                            <td><?= $users[$i]['medcode'];?></td>
                            <td><?= $users[$i]['building_name'] . " ชั้น " . $users[$i]['class_no'];?></td>
                            <td><?= $users[$i]['created'];?></td>
                            <td>
                                <button class="btn btn-sm btn-block btn-danger delete_data"
                                    value="<?= $users[$i]['id_active'];?>">
                                    <i class=" fa fa-close" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>
                        <?}?>
                    </tbody>
                </table>
                <button class="btn btn-success pull-right btn_addPermission" href="#" data-toggle="modal"
                    data-target="#add_permission">
                    <i class="fa fa-user-plus mr-2" aria-hidden="true"></i>เพิ่มสิทธิ์ผู้ใช้งาน
                </button>
            </div>
        </div>
    </div>
    <!-- dashboard contents -->

    <?
    include "./event/addPermission.php";
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


    // ************************* INSERT DATA ***********************
    $('.btn_addPermission').on('click', function() {
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
    $('#insert').on('submit', function(e) {
        e.preventDefault();
        let data = {};
        data['username'] = $('#username').val();
        data['building'] = $('#building_name').val();
        data['class_no'] = $('#class_no').val();
        if (errUser != true) {
            $.ajax({
                url: 'insert.php',
                method: 'POST',
                dataType: 'json',
                data: {
                    data,
                    topic: 'addPermission'
                },
                success: function(res) {
                    // console.log(res);
                    $('#insert')[0].reset();
                    $('#add_permission').modal('hide');
                    sessionStorage.setItem('add_order', '1');
                    window.location.reload();
                }
            })
        }
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



    // ************************* DELETE DATA *******************************
    $(document).on('click', '.delete_data', function() {
        let id = $(this).val();
        console.log(id);
        let where = "id_active=" + id;
        let table = "active_class";
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