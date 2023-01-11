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
                            <label for="id_edit">ID</label>
                            <input type="text" class="form-control form-control-sm" placeholder="รหัสห้อง"
                                name="id_edit" disabled required>
                        </div>
                        <div class="mb-3 col">
                            <label for="date">วันที่</label>
                            <input type="date" class="form-control form-control-sm" placeholder="วันที่แก้ไข"
                                name="date_edit" value="<?= date('Y-m-d');?>" disabled required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="mb-3 col">
                            <label for="id_card">เลขบัตรประชาชน</label>
                            <input type="text" class="form-control form-control-sm" placeholder="เลขบัตรประชาชน"
                                name="id_card" disabled required>
                        </div>
                        <div class="mb-3 col">
                            <label for="sex">เพศ</label>
                            <input type="text" class="form-control form-control-sm" placeholder="เลขบัตรประชาชน"
                                name="sex" disabled required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="mb-3 col">
                            <label for="username">username</label>
                            <input type="text" class="form-control form-control-sm" placeholder="username"
                                name="username" disabled required>
                        </div>
                        <div class="mb-3 col">
                            <label for="password">password</label>
                            <input type="text" class="form-control form-control-sm" placeholder="password"
                                name="password" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="mb-3 col">
                            <label for="TFNAME">ชื่อ</label>
                            <input type="text" class="form-control form-control-sm" placeholder="ชื่อ" name="TFNAME"
                                required>
                        </div>
                        <div class="mb-3 col">
                            <label for="TLNAME">สกุล</label>
                            <input type="text" class="form-control form-control-sm" placeholder="สกุล" name="TLNAME"
                                required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-sm btn-success btn-block">อัพเดต</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>