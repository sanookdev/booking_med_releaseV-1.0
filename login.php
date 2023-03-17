<? 
if(isset($_SESSION)){session_destroy();}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->

    <title>ระบบจองห้องประชุม ( คณะแพทยศาสตร์ )</title>

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">

    <style>
    span {
        color: red;
    }
    </style>
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-10">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <h4 class='text-center mt-4'>Booking Room Meeting System</h4>
                    <hr>
                    <center>
                        <div class="col-lg-7">
                            <div class="p-4 mb-3">
                                <div class="text-center">
                                    <img src="img/med_logo.png" width="80px" class="mb-2">
                                    <h1 class="h4 text-gray-700 mb-4">Faculty Of Medicine</h1>
                                </div>

                                <!-- ERROR MESSAGE  -->
                                <span class="err" id="err"></span>
                                <form action="#" id="form_login">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" name="email"
                                            id="email" placeholder="Enter Your Username ..">
                                        <span class="email-err"></span>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" name="password"
                                            id="password" placeholder="Enter Your Password ..">
                                        <span class="pass-err"></span>

                                    </div>
                                    <button type="submit" class="btn btn-success btn-user btn-block">Login</button>
                                </form>
                            </div>
                        </div>
                    </center>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery-3.2.1.min.js" type="text/javascript"></script>

    <script>
    $(document).ready(function() {

        // realtime input checking
        $('#email').on('input', function(e) {
            if (e.target.value !== '') {
                $(".email-err").hide();
            }
        });
        $('#password').on('input', function(e) {
            if (e.target.value !== '') {
                $(".pass-err").hide();
            }
        })


        // event after submit login
        $("#form_login").on('submit', function(e) {
            e.preventDefault();
            var username = $("#email").val().trim();
            var password = $("#password").val().trim();
            if ($("#email").first().val() === "") {
                $(".email-err").text("กรุณากรอกข้อมูล...").show();
            }
            if ($("#password").first().val() === "") {
                $(".pass-err").text("กรุณากรอกข้อมูล...").show();
                event.preventDefault();
            }
            if (username != '' && password != '') {
                $.ajax({
                    url: 'checkLogin.php',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        username: username,
                        password: password
                    },
                    success: function(res) {
                        var msg = '';
                        console.log(res);
                        if (res != 0) {
                            window.location = "main.php";
                        } else {
                            msg = "อีเมลล์ หรือ พาสเวิร์ดของท่านไม่ถูกต้อง !";
                            $("#err").html(msg).show();
                        }
                        $("#err").html(msg).fadeOut(3000);
                    }
                });
            }
        });
    });
    </script>


</body>

</html>