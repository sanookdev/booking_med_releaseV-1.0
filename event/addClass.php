<div class="modal fade" id="add_class" tabindex="-1" aria-labelledby="add_class" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">เพิ่มชั้น</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="insertClass">
                    <div class="mb-3">
                        <label for="building_name">ตึก</label>
                        <select style='width:100%' class='form-control form-control-sm' name="building_id"
                            id="building_id"></select>
                    </div>

                    <div class="mb-3">
                        <label for="class_no">ชั้น</label>
                        <input type="text" class="form-control form-control-sm" placeholder="ชั้น..." name="class_no"
                            required>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-sm btn-success btn-block">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>