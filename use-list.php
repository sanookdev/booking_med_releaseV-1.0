<? 
    session_start(); 
    if($_SESSION['_LOGIN'] != "ADMIN"){
        header('location: ./main.php');
    }
?>

<?
    include "config/connect.php";

    $sql = "SELECT * FROM category WHERE type = 'use' ORDER BY category_id DESC LIMIT 1";
    $result = $conn->query($sql);

    if($result->num_rows>0){
        while($row = $result->fetch_assoc()){
            $last_id = $row['category_id'];
        }
    } else {
        $last_id = 0;   
    }

    $sql = "SELECT * FROM category WHERE type = 'use' ORDER BY category_id DESC";
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
                            <th>สำหรับ</th>
                            <th width="15%">แก้ไข</th>
                            <th width="3%">ลบ</th>
                        </tr>
                    </thead>
                    <tbody class="bg-light">
                        <?
                        $i = 1;
                        while($row = $result->fetch_array()){
                            ?>
                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $row['topic']; ?> </td>
                            <td>
                                <button type="button" name="edit" class="btn btn-sm btn-block btn-warning edit_data"
                                    id="<?= $row['category_id']; ?>"><i class="fa fa-edit"></i> แก้ไข</button>
                            </td>
                            <td>
                                <button type="button" name="delete" class="btn btn-sm btn-block btn-danger delete_data"
                                    id="<?= $row['category_id']; ?>">
                                    <i class="fa fa-remove" aria-hidden="true"></i></button>
                            </td>
                        </tr>
                        <?
                        if($last_id == ""){
                            $last_id = $row['category_id'];
                        }
                        $i++;
                    }
                    ?>
                    </tbody>
                </table>
                <button class="btn btn-success pull-right" href="#" data-toggle="modal" data-target="#add_use">
                    <i class="fa fa-plus mr-2" aria-hidden="true"></i>เพิ่มหัวข้อ
                </button>
            </div>
        </div>
    </div>
    <!-- dashboard contents -->

    <!-- Add Job Modal -->
    <? include "event/addUse.php";?>

    <!-- Edit Job Detaisl -->
    <? include "event/editUse.php";?>

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
        $('#details_page').html('วัตถุประสงค์');

        // ******************************* INSERT DATA *********************************
        $('#insertUse').on("submit", function(event) {
            event.preventDefault();
            var id = <?= $last_id; ?>;
            data = [];
            data[0] = "use";
            data[1] = $('input[name=name_use]').val();
            data[2] = id + 1;
            table = "category(type,topic,category_id)";
            $.ajax({
                url: "insert.php",
                method: "POST",
                data: {
                    data,
                    table: table
                },
                beforeSend: function() {
                    $('#insertUse').val("Inserting");
                },
                success: function(data) {
                    $('#insertUse')[0].reset();
                    $('#add_use').modal('hide');
                    sessionStorage.setItem('add_order', '1');
                    window.location.reload();
                }
            });
        });
        // ******************************* INSERT DATA (END) *********************************




        // ******************************* DELETE DATA *********************************

        $(document).on('click', '.delete_data', function() {
            var id = $(this).attr("id");
            var where = "category_id=" + id + " AND type = 'use'";
            var table = "category";
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
            var table = "category";
            var where = "category_id='" + id + "' AND type = 'use'";
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
                    $('input[name="id_edit"]').val(data.category_id);
                    $('input[name="name_edit"]').val(data.topic);
                    $('#edit_use').modal('show');
                }
            });
        });
        $('#form_edit').on("submit", function(event) {
            event.preventDefault();
            data = {};
            data['topic'] = $('input[name=name_edit]').val();
            data['id'] = $('input[name=id_edit]').val();
            data['table'] = "category";
            data['type'] = "use";

            $.ajax({
                url: "update.php",
                method: "POST",
                dataType: "json",
                data: {
                    data: data,
                    topic: 'วัตถุประสงค์'
                },
                beforeSend: function() {
                    $('#form_edit').val("Updating");
                },
                success: function(data) {
                    $('#form_edit')[0].reset();
                    $('#edit_use').modal('hide');
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