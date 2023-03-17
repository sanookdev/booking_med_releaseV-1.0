    <div class="modal fade" id="add_booking" tabindex="-1" aria-labelledby="add_booking" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มรายการจอง</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="insertBooking">
                        <div class="mb-3 ">
                            <label for="member">รหัสผู้จอง</label> <small class="text-error">*</small>
                            <input type="text" class="form-control form-control-sm"
                                value="<?= (isset($_SESSION['_LOGIN'])) ? $_SESSION['_LOGIN'] : '' ;?>" name="member"
                                disabled>
                        </div>
                        <div class="mb-3">
                            <label for="topic">หัวข้อการประชุม</label> <small class="text-error">*</small>
                            <input type="text" class="form-control form-control-sm" placeholder="หัวข้อการประชุม"
                                name="topic" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone">เบอร์ติดต่อ</label> <small class="text-error">*</small>
                            <input type="text" class="form-control form-control-sm" placeholder="เบอร์ติดต่อ"
                                name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="for">วัตถุประสงค์</label> <small class="text-error">*</small>
                            <select style='width:100%' type="text" class="form-control form-control-sm" name='for'
                                id='for' placeholder="ใช้สำหรับ" name="for" required></select>
                        </div>
                        <div class="form-row">
                            <div class="mb-3 col-md-9">
                                <label for="building_name">ตึก</label> <small class="text-error">*</small>
                                <select style='width:100%' type='text' name='building_name' id='building_name'
                                    class='form-control form-control-sm' disabled required></select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="class_no">ชั้น</label> <small class="text-error">*</small>
                                <select style='width:100%' type='text' name='class_no' id='class_no'
                                    class='form-control form-control-sm' disabled required></select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="name_room">ห้องประชุม</label> <small class="text-error">*</small>
                            <select style='width:100%' type='text' name='name_room' id='name_room'
                                class='form-control form-control-sm' disabled required></select>
                            <small class="pl-2 pr-2 mt-1 form-text text-muted">รายละเอียดห้อง : </small>
                            <small class="pr-2 pl-2 form-text text-muted" style="color:blue!important;"
                                id="datail_room_booking"></small>
                        </div>
                        <div class="mb-3 form-row">
                            <div class="mb-3 col-md-12">
                                <div class="form-control-wrapper">
                                    <label for="booking_date">วันที่จอง</label><small class="text-error">*</small>
                                    <input type="text" id="booking_date" name="booking_date"
                                        class="form-control form-control-sm floating-label" placeholder="booking date"
                                        disabled required>
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <div class="form-control-wrapper">
                                    <label for="start_date">เริ่ม</label><small class="text-error">*</small>
                                    <input type="text" id="start_date" name="start_date"
                                        class="form-control form-control-sm floating-label" placeholder="Begin Time"
                                        disabled required>
                                    <div class="err start_err"></div>
                                </div>
                            </div>
                            <div class=" mb-3 col-md-6">
                                <div class="form-control-wrapper">
                                    <label for="end_date">สิ้นสุด</label><small class="text-error">*</small>
                                    <input type="text" id="end_date" name="end_date"
                                        class="form-control form-control-sm floating-label" placeholder="End Time"
                                        disabled required>
                                </div>
                            </div>
                        </div>
                        <?if(substr($_SESSION['_LOGIN'] , 0 , 3) == "BET" || $_SESSION['_LOGIN'] == 'ADMIN'){?>
                        <?}?>
                        <div class="mb-3">
                            <label for="details_booking">รายละเอียดเพิ่มเติม</label>
                            <textarea class="form-control form-control-sm" id="details_booking" rows='4'
                                cols='50'></textarea>
                        </div>
                        <div class="mb-3 text-center">
                            <small class="text-danger" style="font-size:0.9rem">
                                หมายเหตุ :
                                หากต้องการขอใช้บริการบุคลากรด้านโสตทัศนูปกรณ์<br>ให้เข้าไปขอบริการงานเทคโนเพิ่มเติมหลังจากจองห้องที่
                            </small>
                            <a href="http://203.131.209.236/serviceTechno/login.htm" target="_blank">Click</a>
                        </div>
                        <div class="mb-3">
                            <button type="submit"
                                class="col-md-6 pull-right btn btn-sm btn-success btn-block btn_submit"
                                disabled>บันทึก</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
$(document).ready(function() {
    $('#booking_date').datetimepicker({
        format: 'd/m/Y',
        timepicker: false,
        minDate: new Date(),
        defaultDate: new Date(),
        scrollMonth: false,
        scrollInput: false
    });
    $('#start_date').datetimepicker({
        format: 'H:i:00',
        datepicker: false

    });


    // $('#start_date').bootstrapMaterialDatePicker({
    //     format: 'DD-MM-YYYY HH:mm:00'
    // });
    // $('#end_date').bootstrapMaterialDatePicker({
    //     format: 'DD-MM-YYYY HH:mm:00'
    // });

    // $.material.init()
});
    </script>