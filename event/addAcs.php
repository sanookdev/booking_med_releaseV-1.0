    <div class="modal fade" id="add_acs" tabindex="-1" aria-labelledby="add_acs" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มอุปกรณ์</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="insertAcs">
                        <div class="mb-3">
                            <input type="text" class="form-control form-control-sm" placeholder="ชื่ออุปกรณ์..." name="name_acs" required>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-sm btn-success btn-block">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>