    <div class="modal fade" id="add_room" tabindex="-1" aria-labelledby="add_room" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มห้องประชุม</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="insert">
                        <div class="form-row">
                            <div class="mb-3 col-9">
                                <label for=" building_name">ตึก</label>
                                <select style='width:100%' class='form-control form-control-sm' name="building_name"
                                    id="building_name" required></select>
                            </div>
                            <div class="mb-3 col-3">
                                <label for="class_no">ชั้น</label>
                                <select name="class_no" id="class_no" class='form-control form-control-sm' disabled
                                    required>
                                </select>
                            </div>
                        </div>


                        <div class="mb-3">
                            <label for="name_room">ชื่อห้องประชุม</label>
                            <input type="text" class="form-control form-control-sm" placeholder="ชื่อห้องประชุม"
                                name="name_room" required>
                        </div>

                        <div class="form-row">
                            <div class="mb-3 col-12">
                                <label for=" section">หน่วยงานผู้ดูแลห้อง</label>
                                <select name="section" id="section" class='form-control form-control-sm' required>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="mb-3 col-12">
                                <label for=" admin_phone">เบอร์ติดต่อผู้ดูแลห้อง</label>
                                <input type="text" name="admin_phone" id="admin_phone"
                                    class='form-control form-control-sm' required />
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="use_for">วัตถุประสงค์</label>
                            <div class="checkbox_result form-row"></div>
                        </div>
                        <div class="mb-3">
                            <label for="details_rooms">หมายเหตุ</label>
                            <textarea class="form-control form-control-sm" name="details_rooms" rows='3' cols='50'
                                placeholder="กรุณากรอกรายละเอียด"></textarea>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-sm btn-success btn-block">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>