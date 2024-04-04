<?php
$data = query("SELECT * FROM `settings` WHERE `id` = 1")->fetch();
$sensor = query("SELECT * FROM `sensor-data` ORDER BY `id` DESC LIMIT 1")->fetch();
?>
<div class="container-fluid">
    <h3 class="text-dark mb-4"><i class="fa fa-cogs" aria-hidden="true"></i> Settings</h3>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="?page=dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Settings</li>

    </ol>
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="row">
                <div class="col">
                    <form action="" method="post">
                        <div class="card shadow mb-3">
                            <div class="card-header py-3">
                                <p class="text-primary m-0 fw-bold">Settings</p>
                            </div>
                            <div class="card-body">
                                <!-- <form action="" method="post"> -->
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3"><label class="form-label" for="data_rates"><strong>Data Rates (s)</strong></label><input class="form-control" type="number" id="data_rates" placeholder="อัตราการส่งข้อมูล (วินาที)" name="data_rates" value="<?php echo $data['data_rate']; ?>"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3"><label class="form-label" for="line_token"><strong>LINE Token</strong></label><input class="form-control" type="text" id="line_token" placeholder="โทเคนแจ้งเตือนไลน์" name="line_token" value="<?php echo $data['line_token']; ?>"></div>
                                    </div>
                                </div>
                                <div class="mb-3"><button class="btn btn-primary btn-sm" name="save_settings" type="submit"> <i class="fa fa-save" aria-hidden="true"></i> บันทึกการตั้งค่า</button></div>
                                <!-- </form> -->
                            </div>
                        </div>

                        <!-- Config condition Notify -->
                        <div class="card shadow mb-3">
                            <div class="card-header py-3">
                                <p class="text-primary m-0 fw-bold">Condition Notify</p>
                            </div>
                            <div class="card-body">
                                <!-- <form action="" method="post"> -->
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3"><label class="form-label" for="condition_notify"><strong>LINE Notify</strong></label>
                                            <select class="form-select" id="condition_notify" name="condition_notify">
                                                <option value="1" <?php if ($data['condition_notify'] == 1) {
                                                                        echo "selected";
                                                                    } ?>>เปิดใช้งานการแจ้งเตือน</option>
                                                <option value="0" <?php if ($data['condition_notify'] == 0) {
                                                                        echo "selected";
                                                                    } ?>>ปิดใช้งานการแจ้งเตือน</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- modify condition to notify -->
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="modify_notify"><strong>ปรับเงื่อนไขการแจ้งเตือน</strong></label> <br>
                                            <!-- use {temp}, {humidity}, {presser} and {altitude} -->
                                            <small>ใช้ {temp}, {humidity}, {pressure} และ {altitude} ในการแทนค่า</small> <br>
                                            <!-- ตัวอย่างการใช้งาน -->
                                            <small>ตัวอย่าง: if {temp} > 30 and {humidity} > 80</small>

                                            <textarea class="form-control mt-2" id="modify_notify" placeholder="เงื่อนไขการแจ้งเตือน" name="modify_notify" cols="30" rows="5"><?php echo $data['modify_notify']; ?></textarea>

                                        </div>
                                        <div class="row">
                                            <div class="col">

                                                <div class="mb-3"><label class="form-label" for="line_notify_message"><strong>Message</strong></label> <br>
                                                    <!-- use {temp}, {humidity}, {presser} and {altitude} -->
                                                    <small>ใช้ {temp}, {humidity}, {pressure} และ {altitude} ในการแทนค่า</small> <br>
                                                    <!-- ตัวอย่างการใช้งาน -->
                                                    <small>ตัวอย่าง: ทดสอบข้อความ อุณหภูมิ <font style="color: rgba(255, 0, 0, 0.7);">{temp}</font> ความชื้น {humidity} ความดัน {pressure} เวลา {time} วันที่ {date}</small>
                                                    <textarea class="form-control" type="text" id="line_notify_message" placeholder="ข้อความที่แสดงเมื่อเงื่อนไขถูกต้อง" name="line_notify_message" rows="5" cols="30"><?php echo $data['line_notify_message']; ?></textarea>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3"><button class="btn btn-primary btn-sm" name="save_settings" type="submit"> <i class="fa fa-save" aria-hidden="true"></i> บันทึกการตั้งค่า</button></div>
                                <!-- </form> -->
                            </div>
                        </div>
                    </form>

                    <!-- Set time interval to call line_check_notify.php every user set -->
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Line Notify</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3"><label class="form-label" for="line_notify"><strong>แจ้งเตือนไลน์</strong></label>
                                        <p class="text-muted">ทำการแจ้งเตือนทุก ๆ <font style="color: rgba(255, 0, 0, 0.7);"><?php echo $data['data_rate']; ?></font> วินาที เมื่อเปิดหน้าเว็บไซต์ไว้</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

</script>
<?php
if (isset($_POST['save_settings'])) {
    $data_rates = $_POST['data_rates'];
    $line_token = $_POST['line_token'];
    $condition_notify = $_POST['condition_notify'];
    $modify_notify = $_POST['modify_notify'];
    $line_notify_message = $_POST['line_notify_message'];

    $update = query("UPDATE `settings` SET `data_rate` = '$data_rates', `line_token` = '$line_token', `condition_notify` = '$condition_notify', `modify_notify` = '$modify_notify', `line_notify_message` = '$line_notify_message' WHERE `id` = 1");

    if ($update) {
        swal("ดำเนินการสำเร็จ", "อัพเดทการตั้งค่าใหม่แล้ว!", "success", "ตกลง");
        $user = $_SESSION['admin'];
        $ipAddress = getenv("REMOTE_ADDR");
        query("INSERT INTO `alert-center` (`alert_type`, `alert_text`, `alert_date`) VALUES (?, ?, ?)", array('system', 'มีการเปลี่ยนแปลงการตั้งค่าโดยผู้ใช้ ' . $user . ' ไอพีแอดเดรส ' . $ipAddress, date("Y-m-d H:i:s")));
    } else {
        swal("ล้มเหลว", "ไม่สามารถอัพเดทการตั้งค่าได้!", "error", "ตกลง");
    }
}
?>