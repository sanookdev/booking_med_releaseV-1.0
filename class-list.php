<? 
    session_start(); 
    if($_SESSION['_LOGIN'] != "ADMIN"){
        header('location: ./main.php');
    }
?>

<?
    include "config/connect.php";

    $sql = "SELECT b.building_name  , c.* FROM building AS b
                RIGHT JOIN class AS c ON b.id = c.building_id ORDER BY b.building_name,c.class_no ASC";
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
            <?include "ui/leftbarRoom.php";?>
            <div class="col-lg-10 col-md-10">
                <table class="table table-bordered shadow text-center" id="data-table" style="width:100%">
                    <thead class="table-dark ">
                        <tr>
                            <th width="5%">#</th>
                            <th>ชั้น (ตึก)</th>
                            <th width="15%">แก้ไข</th>
                            <th width="3%">ลบ</th>
                        </tr>
                    </thead>
                    <tbody class="bg-light">
                        <?
                        $i = 1;
                    if($result->num_rows > 0){
                        while($row = $result->fetch_array()){
                            ?>
                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= 'ชั้น : '.$row['class_no']." / ตึก : ".$row['building_name'];?>
                            </td>
                            <td>
                                <button type="button" name="edit" class="btn btn-sm btn-block btn-warning edit_data"
                                    id="<?= $row['id']; ?>"><i class="fa fa-edit"></i> แก้ไข</button>
                            </td>
                            <td>
                                <button type="button" name="delete" class="btn btn-sm btn-block btn-danger delete_data"
                                    id="<?= $row['id']; ?>">
                                    <i class="fa fa-remove" aria-hidden="true"></i></button>
                            </td>
                        </tr>
                        <?
                        $i++;
                        }
                    }
                    ?>
                    </tbody>
                </table>
                <button id='btn_add' class="btn btn-success pull-right" href="#" data-toggle="modal"
                    data-target="#add_class">
                    <i class="fa fa-plus mr-2" aria-hidden="true"></i>เพิ่มชั้น
                </button>
            </div>
        </div>
    </div>
    <!-- dashboard contents -->

    <!-- Add Job Modal -->
    <? include "event/addClass.php";?>

    <!-- Edit Job Detaisl -->
    <? include "event/editClass.php";?>

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


    <script>
    $(document).ready(function() {

        // ********************************  DATA TABLE *****************************
        $('#data-table').DataTable({
            "bInfo": false,
            "bLengthChange": false,
            "bPaginate": true,
            "bFilter": false,
            "pagingType": "full_numbers"
        });
        // ********************************  DATA TABLE (END) *****************************

        $('#details_page').prop('hidden', false);
        $('#details_page').html('ชั้น');

        var $option = $(
                '<option selected><?= isset($_POST['building_id']) ? $_POST['building_id'] : '' ?></option>'
            )
            .val('<?= isset($_POST['building_id']) ? $_POST['building_id'] : '' ?>');
        $("select[name=building_id]").append($option).trigger(
            'change'); // append the option and update Select2
        $("select[name=building_id]").select2({
            minimumResultsForSearch: -1,
            tags: true,
            templateSelection: function(state) {
                if (state.id === '') {
                    return 'เลือกตึก...';
                }
                return state.text;
            },
            ajax: {
                url: 'search.php',
                dataType: 'json',
                type: "POST",
                quietMillis: 100,
                data: ({
                    topic: 'ตึก'
                }),
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.building_name,
                                id: item.id,
                            }
                        })
                    };
                }
            }
        });
        // ******************************* INSERT DATA *********************************
        $('#insertClass').on("submit", function(event) {
            event.preventDefault();
            data = [];
            // data[0] = "building_name";
            data[0] = $('input[name=class_no]').val();
            data[1] = $('select[name=building_id]').val();
            table = "class(`class_no`,`building_id`)";
            $.ajax({
                url: "insert.php",
                method: "POST",
                data: {
                    data,
                    table: table
                },
                beforeSend: function() {
                    $('#insertClass').val("Inserting");
                },
                success: function(data) {
                    $('#insertClass')[0].reset();
                    $('#add_class').modal('hide');
                    sessionStorage.setItem('add_order', '1');
                    window.location.reload();
                }
            });
        });
        // ******************************* INSERT DATA (END) *********************************




        // ******************************* DELETE DATA *********************************

        $(document).on('click', '.delete_data', function() {
            var id = $(this).attr("id");
            var where = "id=" + id;
            var table = "class";
            console.log(where);
            console.log(table);
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
                                id: id,
                                where: where,
                                table: table
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
        // ******************************* DELETE DATA (END) *********************************





        // ******************************** EDIT DATA *************************************
        $(document).on('click', '.edit_data', function() {
            var id = $(this).attr("id");
            var table = "class";
            var where = "id=" + id;
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
                    $('input[name="id"]').val(data.id);
                    $('input[name="edit_class"]').val(data.class_no);
                    $('#edit_class').modal('show');
                }
            });
        });
        $('#form_edit').on("submit", function(event) {
            event.preventDefault();
            data = {};
            data['class_no'] = $('[name=edit_class]').val();
            id = $('input[name=id]').val();
            table = "class";
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
                    $('#edit_class').modal('hide');
                    sessionStorage.setItem('edit_order', '1');
                    window.location.reload();
                }
            });
        });
        // ******************************** EDIT DATA (END) *************************************





        // ************************** send event after refresh page **************************
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
        // ************************** send event after refresh page ( END ) **************************



    });
    </script>

</body>

</html>