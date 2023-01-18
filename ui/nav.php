<?
    if(!isset($_SESSION['_LOGIN'])){
        echo "<script>window.location.href='logout.php'</script>";
    }else{
        echo "<script>console.log(".json_encode($_SESSION).")</script>";
    }
?>

<style>
.logo-nav {
    height: 50px;
    width: auto;
}
</style>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link
    href="https://fonts.googleapis.com/css2?family=Kanit&family=Mandali&family=Sarabun:ital,wght@0,600;1,500&display=swap"
    rel="stylesheet">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div id="waitttAmazingLover"></div>
        <a href="main.php">
            <img src="img/med_logo.png" class="logo-nav">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto mb-lg-0 text-center">
                <li class="nav-item">
                    <a class="nav-link" href="main.php"><i class="fa fa-calendar ml-3 mr-1"></i>ปฏิทินการจองห้อง</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="booking-list.php"><i class="fa fa-list"></i>
                        รายการจองห้อง</a>
                </li>

                <?if((isset($_SESSION['_LOGIN']) && $_SESSION['_LOGIN'] == 'ADMIN') || 
                (isset($_SESSION['role']) && count($_SESSION['role']) > 0)){?>
                <!-- 
                <li class="nav-item">
                    <a class="nav-link" href="user_manage.php"><i class="fa fa-user"></i> จัดการสมาชิก</a>
                </li> -->
                <?if(isset($_SESSION['_LOGIN']) && $_SESSION['_LOGIN'] == 'ADMIN') {?>
                <li class="nav-item">
                    <a class="nav-link" href="permission_manage.php"><i class="fa fa-user"></i>
                        จัดการสิทธิ์</a>
                </li>
                <?}?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-gear"></i> ตั้งค่า
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="building-list.php"><i class="fa fa-edit"></i> ตึก </a>
                        <a class="dropdown-item" href="class-list.php"><i class="fa fa-edit"></i> ชั้น </a>
                        <a class="dropdown-item" href="rooms-list.php"><i class="fa fa-edit"></i> ห้อง </a>
                        <a class="dropdown-item" href="use-list.php"><i class="fa fa-edit"></i> วัตถุประสงค์</a>
                        <!-- <a class="dropdown-item" href="accessories-list.php"><i class="fa fa-edit"></i> อุปกรณ์</a> -->
                    </div>
                </li>
                <?}?>

            </ul>
            <ul class="navbar-nav mb-lg-0">
                <li class="nav-item">
                    <button class="btn btn-sm btn-light" disabled>
                        <i class="fa fa-user mr-1"></i>
                        <?= $_SESSION['_LOGIN']; ?>
                    </button>
                    <button class="btn btn-sm btn-danger btn_logout">
                        <i class="fa fa-sign-out"></i>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</nav>
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
    crossorigin="anonymous"></script>
<script>
$(document).ready(function() {

    $("#waitttAmazingLover").addClass("loading");
    $("#waitttAmazingLover").css("display", "block");
    setTimeout(function() {
        $("#waitttAmazingLover").css("display", "none");
    }, 500);


    $('.btn_logout').on('click', function() {
        Swal.fire({
            title: 'ต้องการออกจากระบบ ?',
            text: "ต้องการออกจากระบบ !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'red',
            cancelButtonColor: 'grey',
            confirmButtonText: 'ออกจากระบบ !'
        }).then((result) => {
            if (result.value) {
                window.location.href = 'logout.php';
            }
        })
    })

})
</script>