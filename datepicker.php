<html>

<head>
    <title>Bootstrap-Material DateTimePicker</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- ... -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="./js/php-date-formatter.js"></script>

    <script type="text/javascript" src="./js/jquery.datetimepicker.js"></script>

    <link rel="stylesheet" href="./css/jquery.datetimepicker.css" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

</head>

<body>
    <div class="container">
        <br><br><br>
        <div class='col-sm-6'>
            <div class="form-group">
                <label for="">Simple Date & Time</label>
                <input type="text" id="example1" name="example1" class="form-control form-control-sm floating-label"
                    placeholder="Begin Date Time" required>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    $(document).ready(function() {

        $('#example1').datetimepicker();

    });
    </script>
</body>

</html>