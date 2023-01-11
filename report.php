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
    <link rel="stylesheet" href="css/style.css">
    <title>หน้าหลัก</title>
</head>

<body>

    <!-- nav -->
    <?
        include "ui/nav.php";
        include "config/connect.php";
        $sql = "SELECT * FROM reservation";
        $result = $conn->query($sql);
        $numRes = $result->num_rows;

        $sql = "SELECT * FROM reservation WHERE `status` = '1'";
        $result = $conn->query($sql);
        $numResApprove = $result->num_rows;

        $sql = "SELECT * FROM reservation WHERE `status` = '0'";
        $result = $conn->query($sql);
        $numResWaiting = $result->num_rows;
    ?>
    <!-- nav -->

    <!-- หน้าแรก -->
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-lg-3 col-md-3">
                <div class="card card-border">
                    <div class="card-body">
                        <h4 class="card-title">
                            <?echo $numRes;?><small class="text-muted"> รายการจองทั้งหมด</small>
                        </h4>
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="booking-list.php" class="list-group-item list-group-item-primary">รายละเอียด</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="card card-border">
                    <div class="card-body">
                        <h4 class="card-title text-success">
                            <?echo $numResApprove;?> <small> รายการจองที่อนุมัติ</small>
                        </h4>
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="booking-list.php" class="list-group-item list-group-item-primary"> รายละเอียด</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="card card-border">
                    <div class="card-body">
                        <h4 class="card-title text-warning">
                            <?echo $numResWaiting;?> <small>รายการจองที่รอตรวจสอบ</small>
                        </h4>
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="booking-list.php" class="list-group-item list-group-item-primary">รายละเอียด</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- หน้าแรก (สิ้นสุด) -->

    <!-- Optional JavaScript -->
    <!-- Popper.js first, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
    </script>
</body>

</html>