<div class="modal fade" id="edit_room" tabindex="-1" aria-labelledby="edit_room" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">แกไขข้อมูล</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form_edit">
                    <div class="form-row">
                        <div class="mb-3 col">
                            <label for="date_edit">วันที่</label>
                            <input type="datetime" class="form-control form-control-sm" id="date_edit" name="date_edit"
                                value="<?php echo date('Y-m-d');?>" readonly>

                        </div>
                        <div class="mb-3 col">
                            <label for="id_edit">ID</label>
                            <input type="text" class="form-control form-control-sm" placeholder="รหัสห้อง"
                                name="id_edit" readonly required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="mb-3 col-9">
                            <label for=" building_name">ตึก</label>
                            <select style='width:100%' class='form-control form-control-sm' name="building_name_edit"
                                id="building_name_edit" required></select>
                        </div>
                        <div class="mb-3 col-2">
                            <label for="name_no_edit">ชั้น</label>
                            <input type="text" class="form-control form-control-sm" placeholder="ชั้น"
                                name="name_no_edit" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="name_edit">ห้องประชุม</label>
                        <input type="text" class="form-control form-control-sm" placeholder="ชื่อห้องประชุม"
                            name="name_edit" required>
                    </div>
                    <div class="mb-3">
                        <label for="section_edit">หน่วยงานผู้ดูแลห้อง</label>
                        <input type="text" class="form-control form-control-sm" placeholder="หน่วยงานผู้ดูแลห้อง"
                            name="section_edit" required>
                    </div>
                    <div class="mb-3">
                        <label for="admin_phone_edit">เบอร์ติดต่อผู้ดูแลห้อง</label>
                        <input type="text" class="form-control form-control-sm" placeholder="เบอร์ติดต่อผู้ดูแลห้อง"
                            name="admin_phone_edit" required>
                    </div>
                    <div class="mb-3">
                        <label for="details_room_edit">หมายเหตุ</label>
                        <textarea rows='4' type="text" class="form-control form-control-sm" placeholder="รายละเอียด"
                            name="details_room_edit"></textarea>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-sm btn-success btn-block">อัพเดต</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>