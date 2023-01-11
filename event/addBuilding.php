<div class="modal fade" id="add_building" tabindex="-1" aria-labelledby="add_building" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">เพิ่มตึก</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="insertBuilding">
                    <div class="mb-3">
                        <input type="text" class="form-control form-control-sm" placeholder="ตึก..."
                            name="building_name" required>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-sm btn-success btn-block">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>