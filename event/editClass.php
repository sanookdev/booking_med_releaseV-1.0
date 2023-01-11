<div class="modal fade" id="edit_class" tabindex="-1" aria-labelledby="edit_class" aria-hidden="true">
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
                    <div class="mb-3">
                        <label for="id_edit">ID :</label>
                        <input type="text" class="form-control form-control-sm" placeholder="รหัสชั้น" name="id"
                            disabled required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_class">ตึก :</label>
                        <input type="text" class="form-control form-control-sm" placeholder="ชั้น" name="edit_class"
                            required>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-sm btn-success btn-block">อัพเดต</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>