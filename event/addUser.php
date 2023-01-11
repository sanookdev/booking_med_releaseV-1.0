<div class="modal fade" id="add_employee" tabindex="-1" aria-labelledby="add_employee" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">เพิ่มผู้ใช้งาน</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="insert">
                    <div class="form-row">
                        <div class="mb-3 col">
                            <input type="text" class="form-control form-control-sm" minlength="13" maxlength="13"
                                id="id_card" placeholder="บัตรประชาชน" required>
                        </div>
                        <div class="mb-3 col">
                            <select class="form-control form-control-sm" id="sex">
                                <option value="">เพศ</option>
                                <option value="ชาย">ชาย</option>
                                <option value="หญิง">หญิง</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="mb-3 col">
                            <input type="text" class="form-control form-control-sm" placeholder="username" id="username"
                                maxlength="10" required>
                            <span id="errUser" class="ml-1" style="font-size:80%" hidden></span>
                        </div>
                        <div class="mb-3 col">
                            <input type="text" class="form-control form-control-sm" placeholder="password" id="password"
                                required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="mb-3 col">
                            <input type="text" class="form-control form-control-sm" placeholder="ชื่อ..." id="TFNAME"
                                required>
                        </div>
                        <div class="mb-3 col">
                            <input type="text" class="form-control form-control-sm" placeholder="นามสกุล..." id="TLNAME"
                                required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <select class="form-control form-control-sm" id="status_type" required>
                            <option value="">สถานะ</option>
                            <option value="0">ผู้ใช้งาน</option>
                            <option value="1">ผู้ดูแลระบบ</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="mb-3 col-9">
                            <span>ชั้นของตึกที่ดูแล</span>
                            <label for="building_name">ตึก</label>
                            <select style='width:100%' type='text' name='building_name' id='building_name'
                                class='form-control form-control-sm' required></select>
                        </div>
                        <div class="mb-3 col-3">
                            <label for="class_no">ชั้น</label>
                            <select style='width:100%' type='text' name='class_no' id='class_no'
                                class='form-control form-control-sm' disabled required></select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-sm btn-success btn-block btn_submitUser" disabled>บันทึก</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>