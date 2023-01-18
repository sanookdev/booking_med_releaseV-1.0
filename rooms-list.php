<? session_start(); ?>

<?
    include "config/connect.php";
    include "function.php";
    $sql = "SELECT room.* , b.building_name FROM rooms AS room
                LEFT JOIN building AS b
                    ON room.building_id = b.id";
    if($_SESSION['_LOGIN'] != "ADMIN"){
        $sql .= " WHERE admin_section ='".$_SESSION['SECTION_ID']."'";
    }
    $sql .=" ORDER BY room.id ASC";
    $result = $conn->query($sql);
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
    <title>ห้องประชุม</title>
</head>

<body>

    <!-- nav -->
    <?include "ui/nav.php";?>
    <!-- nav -->

    <!-- dashboard contents -->
    <div class="container-fluid">
        <div class="row mt-3">
            <?
            include "ui/leftbarRoom.php";
            ?>
            <div class="col-lg-10 col-md-10">
                <table class="table table-bordered shadow text-center" id="data-table" style="width:100%">
                    <thead class="table-dark ">
                        <tr>
                            <th width="5%">#</th>
                            <th>ห้องประชุม / ตึก ( ชั้น )</th>
                            <th width="15%">รายละเอียด</th>
                            <th width="15%">แก้ไข</th>
                            <th width="7%">ลบ</th>
                        </tr>
                    </thead>
                    <tbody class="bg-light">
                        <?
                        $i = 1;
                        while($row = $result->fetch_assoc())
                        {?>
                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $row['name']. " / ". $row['building_name'].' ('.$row['class_no'].')'; ?>
                            </td>
                            <td>
                                <button type="button" name="details" class="btn btn-sm btn-block btn-info view_data"
                                    id="<?= $row['id']; ?>">
                                    <i class="fa fa-list" aria-hidden="true"></i> รายละเอียด</button>
                            </td>
                            <td>
                                <button type="button" name="edit" class="btn btn-sm btn-block btn-warning edit_data"
                                    id="<?= $row['id']; ?>">
                                    <i class="fa fa-edit" aria-hidden="true"></i> แก้ไข</button>
                            </td>
                            <td>
                                <button type="button" name="delete" class="btn btn-sm btn-block btn-danger delete_data"
                                    id="<?= $row['id']; ?>">
                                    <i class="fa fa-remove" aria-hidden="true"></i></button>
                            </td>
                        </tr>
                        <?
                        $i++;
                    }?>
                    </tbody>
                </table>
                <button class="btn btn-success pull-right add_data" href="#" data-toggle="modal"
                    data-target="#add_room">
                    <i class="fa fa-plus mr-2" aria-hidden="true"></i>เพิ่มห้องประชุม
                </button>
            </div>
        </div>
    </div>
    <!-- dashboard contents -->

    <!-- Add Job Modal -->
    <? include "event/addRoom.php";?>

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
    <!-- <script src="js/event.js"></script> -->




    <!-- ******************************************* JS ********************************************* -->

    <script>
    $(document).ready(function() {

        var session = <?= json_encode($_SESSION);?>;
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
        $('#details_page').html('ห้อง');
        // *********************** VIEW DATA ***********************
        $(document).on('click', '.view_data', function() {
            var id = $(this).attr("id");
            console.log(id);
            if (id != '') {
                $.ajax({
                    url: "select.php",
                    method: "POST",
                    data: {
                        id: id,
                        topic: 'rooms'
                    },
                    success: function(data) {
                        $('#showData').html(data);
                        $('#room_details').modal('show');
                    }
                });
            }
        });
        // *********************** VIEW DATA (END)***********************


        getBuilding = (tag_id, building_id_check) => {
            let option = '';
            $.ajax({
                url: "search.php",
                method: "POST",
                data: {
                    topic: 'ตึก'
                },
                success: function(data) {
                    option += "<option value = ''>เลือกตึก...</option>";
                    for (i = 0; i < data.length; i++) {
                        option += "<option value='" + data[i]['id'] + "'";
                        option += (data[i]['id'] == building_id_check) ? " selected " : "";
                        option += ">";
                        option += data[i]['building_name'];
                        option += "</option>";
                    }
                    $('#' + tag_id).html(option);
                }
            })
        }

        // ************************* INSERT DATA ***********************

        $('.add_data').on('click', function() {
            let option = '';
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
        })
        $(document).on('click', '.add_data', function() {
            var topic = "วัตถุประสงค์"
            $.ajax({
                url: "search.php",
                method: "POST",
                data: {
                    topic: topic,
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    var res = '';
                    for (i = 0; i < data['for'].length; i++) {
                        res += "<div class ='col-4'>&nbsp;&nbsp;";
                        res += "<input type = 'checkbox' name ='use_for' value =" + data[
                                'for'][i]
                            .category_id + ">" + "<label for='" + data['for'][i].topic +
                            "'>" +
                            "&nbsp;" + data['for'][i].topic + "</label>";
                        res += "</div>";
                    }
                    $('div.checkbox_result').html(res);

                    let option = "";
                    option += "<option value = ''>เลือกผู้ดูแล...</option>";
                    for (i = 0; i < data['section'].length; i++) {
                        option += "<option value='" + data['section'][i]['SECTION_CODE'] +
                            "'>";
                        option += data['section'][i]['DESCRIPTION'] +
                            "(" + data['section'][i]['section_ID'] +
                            ")";
                        option += "</option>";
                    }
                    $('#section').html(option);
                }
            });
        });

        $('#building_name').on('change', function() {
            if ($(this).val() != '') {
                $('#class_no').prop('disabled', false);
            } else {
                $('#class_no').prop('disabled', true);
            }
            building_id = $('#building_name').val();
            console.log(building_id);
            option = '';
            $.ajax({
                url: "search.php",
                method: "POST",
                data: {
                    topic: 'ชั้น',
                    building_id: building_id
                },
                success: function(data) {
                    for (i = 0; i < data.length; i++) {
                        option += "<option value='" + data[i]['class_no'] + "'>";
                        option += data[i]['class_no'];
                        option += "</option>";
                    }
                    $('#class_no').html(option);
                    console.log(data);
                }
            })
        })

        $('#insert').on("submit", function(event) {
            event.preventDefault();
            checkbox = '';
            i = 0;
            $("input:checkbox[name=use_for]:checked").each(function() {
                if (i != 0) {
                    checkbox += ',';
                }
                checkbox += $(this).val();
                i++;
            });
            data = [];
            data[0] = $('select[name=building_name]').val();
            data[1] = $('select[name=class_no]').val();
            data[2] = $('input[name=name_room]').val();
            data[3] = document.querySelector('textarea[name="details_rooms"]').value;
            data[4] = checkbox
            data[5] = $('select[name=section]').val();
            data[6] = $('input[name=admin_phone]').val();
            data[7] = session._LOGIN;
            table =
                "rooms(building_id,class_no,name,detail,use_for,admin_section,admin_phone,userupdate)";
            $.ajax({
                url: "insert.php",
                method: "POST",
                data: {
                    data,
                    table: table
                },
                beforeSend: function() {
                    $('#insert').val("Inserting");
                },
                success: function(data) {
                    $('#insert')[0].reset();
                    $('#add_room').modal('hide');
                    sessionStorage.setItem('add_order', '1');
                    window.location.reload();
                }
            });
        });
        // ************************* INSERT DATA (END) ***********************



        // ************************* EDIT DATA *******************************
        $(document).on('click', '.edit_data', function() {
            var id = $(this).attr("id");
            var table = "rooms";
            var where = "id=" + id;
            console.log(id);
            $.ajax({
                url: "fetch.php",
                method: "POST",
                data: {
                    id: id,
                    table: table,
                    where: where
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    $('input[name="date_edit"]').val(data.date_edit);
                    $('input[name="id_edit"]').val(data.id);
                    getBuilding('building_name_edit', data[3]);
                    $('input[name="name_edit"]').val(data.name);
                    $('input[name="name_no_edit"]').val(data.class_no);
                    $('input[name="section_edit"]').val(data.admin_section);
                    $('input[name="admin_phone_edit"]').val(data.admin_phone);
                    $('textarea[name="details_room_edit"').val(data.detail);
                    $('#edit_room').modal('show');
                }
            });
        });
        $('#form_edit').on("submit", function(event) {
            event.preventDefault();
            data = {};
            data['date_edit'] = $('input[name=date_edit]').val();
            data['building_name'] = $('input[name=building_name]').val();
            data['name'] = $('input[name=name_edit]').val();
            data['class_no'] = $('input[name=name_no_edit]').val();
            data['detail'] = $('textarea[name=details_room_edit]').val();
            data['admin_phone'] = $('input[name=admin_phone_edit]').val();
            id = $('input[name=id_edit]').val();
            table = "rooms";
            where = "id=" + id;
            $.ajax({
                url: "update.php",
                method: "POST",
                data: {
                    data,
                    table: table,
                    where: where,
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
            var id = $(this).attr("id");
            var where = "id=" + id;
            var table = "rooms";
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

</body>

</html>