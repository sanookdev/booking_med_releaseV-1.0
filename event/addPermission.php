<div class="modal fade" id="add_permission" tabindex="-1" aria-labelledby="add_permission" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">เพิ่มสิทธิ์การดูแลตึก</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="insert">
                    <div class="form-row">
                        <div class="mb-3 col">
                            <label for="username">Username</label>
                            <input type="text" class="form-control form-control-sm" placeholder="username" id="username"
                                maxlength="10" required>
                        </div>
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
                        <button class="btn btn-sm btn-success btn-block">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>