<? 
    session_start();
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
    <link href="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./css/styleCalendar.css">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/duration-time.css">
    <title>ห้องประชุม</title>
</head>

<body>

    <!-- nav -->
    <?
        // session_start();
        include "ui/nav.php";
        // print_r($_SESSION);
    ?>
    <!-- nav -->
    <div class="container-fluid">
        <div class="row mt-3">
            <? include "ui/sidebarCalendar.php";?>
            <div class="col-lg-9 col-md-9 mb-2 mx-auto">
                <div class="form-row"
                    style="background-color:#454d55;padding:20px;margin:0.5px;border: 1px solid black;color:white">
                    <div class="col-4 text-right">
                        <button id="prevBtn" class='btn btn-success'><i class="fa fa-arrow-left"></i></button>
                    </div>
                    <div class="col-4 text-center">
                        <span style='opacity:0.8'><u>MONTH</u></span>
                        <h4 id="monthAndYear" style='color:white'></h4>
                    </div>
                    <div class="col-4 text-left">
                        <button id="nextBtn" class='btn btn-success'><i class="fa fa-arrow-right"></i></button>
                    </div>
                </div>
                <table id="calendarTable">
                </table>
                <div id='eventPopUp' hidden>
                    <button id="closeEventBtn">&#10006</button>
                    <div id="eventTextArea">
                    </div>
                </div>
                <? include "ui/footer.php"; ?>
            </div>
        </div>
        <!-- footer -->
    </div>


    <? include './event/advanceSearch.php';?>

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
    <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script> -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/html-duration-picker@latest/dist/html-duration-picker.min.js"></script> -->
    <script src="./js/calendar.js"></script>
    <script src="./js/duration-time.js"></script>

</body>

</html>

<script>
$(document).ready(function() {
    // $("#duration").durationPicker();
    $('#duration').durationPicker({
        showSeconds: false,
        showDays: false
    });
    room_id_nextAndprevBTN = '';
    btn_id_old = '';
    search = function(room_id, btn_id) {
        if (room_id_nextAndprevBTN != room_id) {
            $('#' + btn_id).addClass('action');
            room_id_nextAndprevBTN = room_id;
            if (btn_id_old != '') {
                $('#' + btn_id_old).removeClass('action');
            }
            btn_id_old = btn_id;
        }
        $("#waitttAmazingLover").addClass("loading");
        $("#waitttAmazingLover").css("display", "block");
        setTimeout(function() {
            generateMonth();
            getEventsAjax(room_id);
            $("#waitttAmazingLover").css("display", "none");
        }, 500);
    }
    // ********************************* autocomplete search 'BUILDING NAME ( ตึก )' ************************************
    option = '';
    $.ajax({
        url: "search.php",
        method: "POST",
        dataType: "json",
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
            $('#building_id_search').html(option);

        }
    })

    $.ajax({
        url: "search.php",
        method: "POST",
        dataType: "json",
        data: {
            topic: 'วัตถุประสงค์'
        },
        success: function(data) {
            use_output = '';
            if (data.length > 0) {
                for (i = 0; i < data.length; i++) {
                    use_output += '<div class="col-sm-4">';
                    use_output += '<div class="form-check">';
                    use_output +=
                        '<input class="form-check-input mt-0" type="radio"  name="category_use" value = "' +
                        data[i]['category_id'] +
                        '" id = "use_' + (i + 1) + '">';
                    use_output +=
                        '<label class="form-check-label" for="category_use" style="margin-top:1px!important">' +
                        data[i]['topic'];
                    use_output += '</div></div>';

                }
                $('.search_useFor').html(use_output);

                // test
                $('#use_1').prop('checked', true);
            }
        }
    })

    // THIS IS STEP FOR AUTOCOMPLETE   >>> STEP 1 -> ตึก , STEP 2 -> ชั้น , STEP 3 -> ห้องประชุม , STEP 4 -> FETCH DATA TO TABLE
    $('#building_name').on('change', function() {
        if ($(this).val() != '') {
            $('#class_no').prop('disabled', false);
        } else {
            $('#class_no').val('');
            $('#name_room').val('');
            $('#class_no').prop('disabled', true);
            $('#name_room').prop('disabled', true);
            $('#name_room').html('');
            search('');
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
        $('#class_no').on('change', function() {
            if ($(this).val() != '') {
                $('#name_room').prop('disabled', false);
            } else {
                $('#name_room').prop('disabled', true);
            }

            class_id = $(this).val();
            building_id = $('#building_name').val();

            $.ajax({
                url: "search.php",
                method: "POST",
                data: {
                    topic: 'หาห้องประชุม',
                    class_id: class_id,
                    building_id: building_id
                },
                success: function(data) {
                    option = '';
                    if (data.length > 0) {
                        // option += "<div class = 'form-row'>"
                        for (i = 0; i < data.length; i++) {
                            option +=
                                "<button onclick = 'search(this.value,this.id)' id ='btn_" +
                                i +
                                "' class = 'btn btn-sm btn-block btn-light btn_search text-left' value = '";
                            option += data[i]['id'] + "'>";
                            option +=
                                "<i class='fa fa-check-circle-o'></i> &nbsp;";
                            option += data[i]['name'];
                            option += "</button>";
                        }
                    } else {
                        option +=
                            "<span>ไม่พบห้องประชุม...</span>";
                    }
                    $('#name_room').html(option);
                }
            })
        })
    })

    // FOR ADVANCE SEARCH
    $('#building_id_search').on('change', function() {
        if ($(this).val() != '') {
            $('#class_no_search').prop('disabled', false);
        } else {
            $('#class_no_search').val('');
            $('#class_no_search').prop('disabled', true);
            search('');
        }
        let building_id = $('#building_id_search').val();
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
                $('#class_no_search').html(option);
            }
        })
    })
    // ********************************* autocomplete search 'ROOMS' (END) ************************************


    $('#form_search_rooms').on('submit', (e) => {
        e.preventDefault();
        let dataform = $('#form_search_rooms').serializeArray();
        let dataSearch = {};
        $.each(dataform, function(i, field) {
            dataSearch[field.name] = field.value;
        });
        let building_name = $('[name = "building_id_search"] option:selected').text();
        output_detailsSearch = '';
        let search_time_start = dataSearch['search_time_start'].split(/:/);
        let search_time_end = dataSearch['search_time_end'].split(/:/);
        search_time_start = search_time_start[0] + ':' + search_time_start[1];
        search_time_end = search_time_end[0] + ':' + search_time_end[1];
        output_detailsSearch +=
            'ตึก ' +
            building_name + ' ชั้น ' + dataSearch['class_no_search'] + ' <br>';
        output_detailsSearch += 'วันที่ ' + dataSearch['date_reservation'];
        output_detailsSearch += ' ช่วงเวลา ' + search_time_start + 'น. - ' +
            search_time_end + 'น.';
        console.log(dataSearch['search_time_start'].split(/:/));

        $('.details_advanceSearch').html(output_detailsSearch);
        dataSearch = JSON.stringify(dataSearch);
        $.ajax({
            url: "search.php",
            method: "POST",
            dataType: "json",
            data: {
                topic: 'advanceSearch',
                data: dataSearch
            },
            success: function(data) {
                console.log(data);
                output_roomsFound = '';
                output_roomsBooked = '';


                if (data['rooms_found'].length > 0) {
                    output_roomsFound += '<h6>พบ ' + data['rooms_found']
                        .length +
                        ' ห้องประชุม</h6>';
                    for (i = 0; i < data['rooms_found'].length; i++) {
                        output_roomsFound += '<div class = "pl-5">';
                        output_roomsFound += '<small>' + data['rooms_found'][i]['name'] +
                            '</small><br>';
                        output_roomsFound += '</div>';
                    }
                } else {
                    output_roomsFound += '<h6>พบ 0 ห้องประชุม</h6>';
                }
                if (data['rooms_booked'].length > 0) {
                    output_roomsBooked +=
                        '<h6>พบ ' + data[
                            'rooms_booked']
                        .length +
                        ' เวลาการจอง</h6>';
                    for (i = 0; i < data['rooms_booked'].length; i++) {
                        let begin_time = new Date(data['rooms_booked'][i].begin);
                        let end_time = new Date(data['rooms_booked'][i].end);
                        let hours = begin_time.getHours(); //returns 0-23
                        let minutes = begin_time.getMinutes(); //returns 0-59

                        if (minutes < 10)
                            minutesString = '0' + minutes +
                            ""; //+""casts minutes to a string.
                        else
                            minutesString = minutes;

                        begin_time = hours + ":" + minutesString;

                        hours = end_time.getHours(); //returns 0-23
                        minutes = end_time.getMinutes(); //returns 0-59
                        if (minutes < 10)
                            minutesString = '0' + minutes +
                            ""; //+""casts minutes to a string.
                        else
                            minutesString = minutes;
                        end_time = hours + ":" + minutesString;

                        output_roomsBooked += '<div class = "pl-5">';
                        output_roomsBooked += '<small>' + data['rooms_booked'][i]['name'] +
                            '</small>';
                        output_roomsBooked += ' <small>' + begin_time + 'น. - ' +
                            end_time + 'น.</small><br>';
                        output_roomsBooked += '</div>';
                    }
                } else {
                    output_roomsBooked = '<h6>พบ 0 เวลาการจอง</h6>';
                }

                $('.rooms_found').html(output_roomsFound);
                $('.rooms_booked').html(output_roomsBooked);
                $('#advanceSearch').modal('show');
            }
        })

        console.log(dataSearch);
        console.log('submit form clicked')
    })

})
</script>