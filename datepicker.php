<html>

<head>
    <title>Bootstrap-Material DateTimePicker</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" />

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/css/bootstrap-material-design.min.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/css/ripples.min.css" />

    <link rel="stylesheet" href="./css/bootstrap-material-datetimepicker.css" />
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,500' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-1.12.3.min.js"
        integrity="sha256-aaODHAgvwQW1bFOGXMeX+pC4PZIPsvn2h1sArYOhgXQ=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/js/ripples.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/js/material.min.js"></script>
    <script type="text/javascript"
        src="https://rawgit.com/FezVrasta/bootstrap-material-design/master/dist/js/material.min.js"></script>
    <script type="text/javascript" src="http://momentjs.com/downloads/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="./js/bootstrap-material-datetimepicker.js"></script>

    <style>
    body {
        padding-top: 70px;
        font-family: 'Roboto', sans-serif;
    }

    h2 {
        padding: 0 20px 10px 20px;
        font-size: 20px;
        font-weight: 400;
    }

    .form-control-wrapper {
        margin: 10px 20px;
    }

    code {
        padding: 10px;
        background: #eee !important;
        display: block;
        color: #000;
    }

    code>p {
        font-weight: bold;
        color: #000;
        font-size: 1.5em;
    }

    @media(max-width: 300px) {
        .well {
            margin: 0
        }
    }
    </style>
</head>

<body>
    <div class="container well">
        <div class="row">
            <div class="col-md-6">
                <h2>Date Time Picker</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-control-wrapper">
                    <input type="text" id="date-format" class="form-control floating-label"
                        placeholder="Begin Date Time">
                </div>
            </div>
            <div class="col-md-6">
                <code>
						<p>Code</p>
						$('#date-format').bootstrapMaterialDatePicker({ format : 'dddd DD MMMM YYYY - HH:mm' });
					</code>
            </div>
        </div>
    </div>

    <script type="text/javascript">
    $(document).ready(function() {

        $('#date-format').bootstrapMaterialDatePicker({
            format: 'dddd DD MMMM YYYY - HH:mm'
        });

        $.material.init()
    });
    </script>
</body>

</html>