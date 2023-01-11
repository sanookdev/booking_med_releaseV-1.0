<div class="col-lg-3 col-md-3 mb-3">
    <div class="list-group small mb-3">
        <div class="list-group-item text-center active headGroup"
            style="background-color:#454d55!important;padding:20px;margin:0.5px;border: 1px solid black;color:white">
            <h4>ค้นหาห้อง</h4>
        </div>
        <div class="list-group-item">
            <div class="form-row mb-3">
                <div class="col-sm-12">
                    <h6>สถานะ : </h6>
                    <div class="row">
                        <div class="col-sm">
                            <i class="fa fa-square " style="color:orange"></i>
                            <span class="medium"> = รอตรวจสอบ</span>
                            <i class="fa fa-square ml-3" style="color:rgb(142, 248, 169)"></i>
                            <span class="medium"> = อนุมัติ</span>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="form-row mb-3">
                <div class="col-sm-8">
                    <h6>ตึก : </h6>
                    <select class='form-control form-control-sm' style='border: 1px solid darkgrey;'
                        name="building_name" id="building_name">
                    </select>
                </div>
                <div class="col-sm-4">
                    <h6>ชั้น : </h6>
                    <select class='form-control form-control-sm' style='border: 1px solid darkgrey;' name="class_no"
                        id="class_no" disabled>
                    </select>
                </div>
            </div>
            <div class="form-row mb-3">
                <div class="col-sm-12">
                    <h6>ห้องประชุม : </h6>
                    <div id='name_room' name='name_room' style='text-align:left!important;'>
                        <br>
                        <center><img src='./img/loader.gif' hidden></center>
                    </div>
                    <div id="waitttAmazingLover"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="list-group small">
        <div class="list-group-item text-center active headGroup"
            style="background-color:#454d55!important;padding:20px;margin:0.5px;border: 1px solid black;color:white">
            <h5>ค้นหาและเช็ครายการจองห้อง</h5>
        </div>
        <div class="list-group-item">
            <label>ใช้สำหรับ :</label>
            <form id="form_search_rooms" method="post">
                <div class="form-row search_useFor">

                </div>
                <hr>
                <div class="form-row mb-3">
                    <div class="col-sm-8">
                        <label for="building_id_search">ตึก :</label>
                        <select class='form-control form-control-sm' style='border: 1px solid darkgrey;'
                            name="building_id_search" id="building_id_search" required>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="class_no_search">ชั้น :</label>
                        <select class='form-control form-control-sm' style='border: 1px solid darkgrey;'
                            name="class_no_search" id="class_no_search" required disabled>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="form-row mb-3">
                    <div class="col-sm-12 mb-3">
                        <label for="date_reservation">วันที่ต้องการจอง</label>
                        <input class="form-control form-control-sm" type="date" name="date_reservation"
                            id="date_reservation" value="2022-01-05" required />
                    </div>
                    <div class="col-sm-6">
                        <label for="search_time_start">เวลาเริ่ม</label>
                        <input type="time" class="form-control form-control-sm time24Hourse" name="search_time_start"
                            id="search_time_start" value="09:00:00" required>
                    </div>
                    <div class="col-sm-6">
                        <label for="search_time_end">เวลาสิ้นสุด</label>
                        <input type="time" class="form-control form-control-sm" name="search_time_end"
                            id="search_time_end" value="18:00:00" required>
                    </div>
                </div>
                <hr>
                <div class="form-row mb-3">
                    <div class="col-sm-12">
                        <button class="btn-block btn btn-sm btn-primary">
                            <i class="fa fa-search"></i>
                            &nbsp;เช็คข้อมูล
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div> -->
</div>

<style scoped>
.list-group-item .form-control {
    font-size: 0.75rem !important;
}
</style>